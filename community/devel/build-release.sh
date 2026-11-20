#!/bin/bash

# ================================================
# WackoWiki Release Builder
# ================================================

# Location: community/devel/build-release.sh
# Usage: Copy to repository root and execute
#
# ------------------------------------------------------------
# IMPORTANT: VERSION and SOURCE are two different things
#
#   --version   ONLY defines the name of the generated archive
#               (file name). It does NOT select any Git code.
#
#   --source    Defines the Git code that is really built:
#               a tag, a branch or a commit hash.
#
#   Without --source the code is taken from HEAD of the current
#   branch (master) and the archive is only renamed.
#
#   In the interactive prompt a version that matches an existing
#   Git tag is built FROM that tag and the file name follows the
#   tag - any other name must be requested explicitly.
# ------------------------------------------------------------

set -euo pipefail
set -E    # ERR trap is inherited by functions and subshells

# ================== CONFIG ==================
VERSION=""
VERSION_EXPLICIT=false      # --version was given on the command line
SOURCE="HEAD"
SOURCE_EXPLICIT=false      # --source=/--branch= was given on the command line
BRANCH=""
ARCHIVE_NAME=""            # explicit archive base name (without extension)
MINIMAL=true
ENABLE_LOG=true
AUTO_ACCEPT=false
MAKE_ZIP=true

# ── ASSET BUILD (JS + THEME) ────────────────────────────────
BUILD_JS=false              # build the JavaScript assets from the exported source
BUILD_THEME=false           # minify the theme CSS from the exported source
JS_STRICT=false             # fail the release if the JS build reports problems
JS_SOURCE_MAPS=false        # emit .map files for the static JS assets
ESBUILD_VERSION="0.25.0"    # fallback pin, used when package.json has no esbuild entry
JS_DEST=""                  # filled in by build_assets()
THEME_DEST=""               # filled in by build_assets()
JS_MANIFEST=""              # filled in by build_assets()

# Colors (detect BEFORE any output redirection)
if [ -t 1 ] && [ -z "${NO_COLOR:-}" ] && command -v tput > /dev/null 2>&1; then
    RED="$(tput setaf 1 2>/dev/null || echo '')"
    GREEN="$(tput setaf 2 2>/dev/null || echo '')"
    YELLOW="$(tput setaf 3 2>/dev/null || echo '')"
    BLUE="$(tput setaf 4 2>/dev/null || echo '')"
    CYAN="$(tput setaf 6 2>/dev/null || echo '')"
    BOLD="$(tput bold 2>/dev/null || echo '')"
    NC="$(tput sgr0 2>/dev/null || echo '')"
else
    RED='' GREEN='' YELLOW='' BLUE='' CYAN='' BOLD='' NC=''
fi

# Global variables
LOG_FILE=""
LOG_FIFO=""
LOG_WRITER_PID=""
REPO_ROOT=""
RESOLVED_REF=""
RESOLVED_COMMIT=""
BUILD_DIR=""                # build working directory (global: used by the asset functions)

# Keep the original stdout/stderr so logging can be detached cleanly at the end
exec 3>&1 4>&2

# ================== ANSI STRIPPING ==================
# build.log must be plain text. The colors come from tput, so the escape
# sequences have to be removed from the log stream.
#
# NOTE: many sed implementations do NOT understand "\x1b" inside a regular
# expression (they search for a literal "x1b"), and mawk does not always
# interpret "\033" in a regex constant. Therefore the primary implementation
# is written in pure bash (no external tool at all); perl/sed are used only
# if they pass a self test.
ESC=$'\033'
BEL=$'\007'

# Test sample: CSI + charset + cursor + OSC must all disappear
ANSI_SAMPLE=$'\033[1;32mtest\033[0m\033(B\033[2J\033]0;title\007'
ANSI_SAMPLE_EXPECTED="test"

# --- pure bash implementation (primary, always available) ---------------
ansi_strip_bash() {
    local line prefix suffix
    local re_csi="${ESC}\[[0-9;?]*[ -/]*[@-~]"
    local re_osc="${ESC}\][^${BEL}]*(${BEL}|${ESC}\\\\)"
    local re_charset="${ESC}[()][AB0-2]"

    while IFS= read -r line || [ -n "$line" ]; do
        while [[ $line =~ $re_csi ]]; do
            prefix="${line%%"${BASH_REMATCH[0]}"*}"
            suffix="${line#*"${BASH_REMATCH[0]}"}"
            line="${prefix}${suffix}"
        done
        while [[ $line =~ $re_charset ]]; do
            prefix="${line%%"${BASH_REMATCH[0]}"*}"
            suffix="${line#*"${BASH_REMATCH[0]}"}"
            line="${prefix}${suffix}"
        done
        while [[ $line =~ $re_osc ]]; do
            prefix="${line%%"${BASH_REMATCH[0]}"*}"
            suffix="${line#*"${BASH_REMATCH[0]}"}"
            line="${prefix}${suffix}"
        done
        printf '%s\n' "$line"
    done
}

# --- perl implementation (fast, used when available) --------------------
ansi_strip_perl() {
    perl -pe 's/\e\[[0-9;?]*[ -\/]*[@-~]//g;
              s/\e\][^\a]*(?:\a|\e\\)//g;
              s/\e[()][AB0-2]//g;
              s/\e[=>]//g'
}

# --- sed implementation (with a LITERAL escape byte) --------------------
SED_OPTS=()
if printf '' | sed -E '' > /dev/null 2>&1; then
    SED_OPTS=(-E)
elif printf '' | sed -r '' > /dev/null 2>&1; then
    SED_OPTS=(-r)
fi

ANSI_SED="s#${ESC}\\[[0-9;?]*[ -/]*[@-~]##g; s#${ESC}\\][^${BEL}]*(${BEL}|${ESC}\\\\)##g; s#${ESC}[()][AB0-2]##g"

ansi_strip_sed() {
    if [ "${#SED_OPTS[@]}" -eq 0 ]; then
        cat
        return 0
    fi
    sed "${SED_OPTS[@]}" "$ANSI_SED"
}

# --- awk implementation (sprintf -> no \033 portability problem) --------
ansi_strip_awk() {
    awk '
    BEGIN { esc = sprintf("%c", 27); bel = sprintf("%c", 7) }
    {
        gsub(esc "\\[[0-9;?]*[ -/]*[@-~]", "")
        gsub(esc "[()][AB0-2]", "")
        gsub(esc "\\][^" bel "]*(" bel "|" esc "\\\\)", "")
        print
    }'
}

# --- last resort: drop the escape bytes themselves ----------------------
ansi_strip_tr() {
    tr -d '\033'
}

ANSI_STRIPPER="ansi_strip_bash"

# Does the stripper really remove everything?
ansi_stripper_works() {
    local out
    out="$(printf '%s' "$ANSI_SAMPLE" | "$1" 2>/dev/null || true)"
    [ "$out" = "$ANSI_SAMPLE_EXPECTED" ]
}

select_ansi_stripper() {
    if command -v perl > /dev/null 2>&1 && ansi_stripper_works ansi_strip_perl; then
        ANSI_STRIPPER="ansi_strip_perl"
    elif [ "${#SED_OPTS[@]}" -gt 0 ] && ansi_stripper_works ansi_strip_sed; then
        ANSI_STRIPPER="ansi_strip_sed"
    elif ansi_stripper_works ansi_strip_bash; then
        ANSI_STRIPPER="ansi_strip_bash"
    else
        ANSI_STRIPPER="ansi_strip_tr"
    fi
}

strip_ansi() {
    case "$ANSI_STRIPPER" in
        ansi_strip_perl) ansi_strip_perl ;;
        ansi_strip_sed)  ansi_strip_sed ;;
        ansi_strip_awk)  ansi_strip_awk ;;
        ansi_strip_tr)   ansi_strip_tr ;;
        *)               ansi_strip_bash ;;
    esac
}

# ================== LOGGING FUNCTIONS ==================
log_info() {
    echo -e "${BLUE}ℹ${NC} $*"
}

log_success() {
    echo -e "${GREEN}✓${NC} $*"
}

log_warn() {
    echo -e "${YELLOW}⚠${NC} $*" >&2
}

log_error() {
    echo -e "${RED}✗${NC} $*" >&2
}

log_step() {
    echo -e "${CYAN}→${NC} $*"
}

# Start logging.
#   terminal output  -> tee -> FIFO -> (strip ANSI) -> build.log
#   The FIFO reader runs in the background and is waited for in stop_logging(),
#   so build.log is ALWAYS complete (also when the script aborts).
start_logging() {
    local dir="$1"

    mkdir -p "$dir" 2>/dev/null || true

    LOG_FILE="$dir/build.log"
    LOG_FIFO="$dir/.build.log.fifo"

    if ! : > "$LOG_FILE" 2>/dev/null; then
        printf 'Warning: cannot create %s - logging disabled\n' "$LOG_FILE" >&4
        LOG_FILE=""
        return 1
    fi

    # Pick a stripper that really works (and verify it!)
    select_ansi_stripper
    if ! ansi_stripper_works "$ANSI_STRIPPER"; then
        ANSI_STRIPPER="ansi_strip_bash"
    fi

    if ! command -v tee > /dev/null 2>&1; then
        printf 'Warning: "tee" not found - logging disabled\n' >&4
        LOG_FILE=""
        return 1
    fi

    if ! command -v mkfifo > /dev/null 2>&1 || ! mkfifo "$LOG_FIFO" 2>/dev/null; then
        printf 'Warning: cannot create log FIFO - logging disabled\n' >&4
        LOG_FIFO=""
        return 1
    fi

    # Background writer: FIFO -> (strip ANSI) -> build.log
    (
        trap - ERR
        set +e
        strip_ansi < "$LOG_FIFO" > "$LOG_FILE"
    ) &
    LOG_WRITER_PID=$!

    # Open the write end of the FIFO in this shell (blocks until reader is ready)
    exec 9> "$LOG_FIFO"

    # Mirror stdout + stderr to the terminal AND into the log
    # (no ERR trap inside the subshell -> a failing tee can never kill the script)
    exec > >(set +E; trap - ERR; tee "$LOG_FIFO") 2>&1

    return 0
}

# Stop logging and make sure the log file is complete (flush + wait)
stop_logging() {
    if [ -z "$LOG_WRITER_PID" ]; then
        return 0
    fi

    # Restore the original terminal streams -> "tee" gets EOF and exits
    exec 1>&3 2>&4

    # Close our copy of the FIFO write end
    exec 9>&-

    # Wait until the writer flushed everything -> build.log is complete
    wait "$LOG_WRITER_PID" 2>/dev/null || true
    LOG_WRITER_PID=""

    if [ -n "$LOG_FIFO" ]; then
        rm -f "$LOG_FIFO"
        LOG_FIFO=""
    fi

    # Safety net: if any escape sequence is still in the log, clean it now
    if [ -n "$LOG_FILE" ] && [ -f "$LOG_FILE" ]; then
        if LC_ALL=C grep -q "$ESC" "$LOG_FILE" 2>/dev/null; then
            local tmp_log="${LOG_FILE}.tmp"
            if ansi_strip_bash < "$LOG_FILE" > "$tmp_log" 2>/dev/null && mv -f "$tmp_log" "$LOG_FILE"; then
                printf 'Warning: remaining ANSI escape sequences removed from %s\n' "$LOG_FILE" >&4
            else
                rm -f "$tmp_log"
            fi
        fi
    fi

    return 0
}

# ================== ERROR HANDLING ==================
# Everything is expanded directly inside the trap (no helper function, no $1/$2),
# and the exit code is validated to be numeric.
trap 'rc=$?; printf "\n[build-release] ERROR: command failed (exit status %s) at line %s: %s\n" "$rc" "$LINENO" "$BASH_COMMAND" >&2; case "$rc" in ""|*[!0-9]*) rc=1;; esac; exit "$rc"' ERR
trap 'stop_logging' EXIT
trap 'stop_logging; exit 130' INT
trap 'stop_logging; exit 143' TERM

# ================== SCRIPT LOCATION CHECK ==================
# Find the actual repository root
find_repo_root() {
    local dir
    dir="$(pwd)"

    local max_depth=10
    local depth=0

    while [ "$depth" -lt "$max_depth" ]; do
        if [ -f "$dir/composer.json" ] && [ -d "$dir/.git" ]; then
            # Verify it's a WackoWiki repository
            if grep -q '"name".*[wW]acko[Ww]iki' "$dir/composer.json" 2>/dev/null; then
                echo "$dir"
                return 0
            fi
        fi

        # Check if we've reached filesystem root
        if [ "$dir" = "/" ] || [ -z "$dir" ]; then
            break
        fi

        dir="$(dirname "$dir")"
        depth=$((depth + 1))   # FIX: "((depth++))" returns exit status 1 under "set -e"
    done

    return 1
}

# ================== GIT HELPERS ==================
# NOTE: all lookups use FULLY QUALIFIED ref names (refs/tags/..., refs/heads/...)
# so that a tag and a branch with the same name never cause an
# "ambiguous argument" error.

# Does the given name exist as a Git tag?
git_tag_exists() {
    local tag="$1"
    git show-ref --verify --quiet "refs/tags/$tag"
}

# Does the given name exist as a local branch?
git_branch_exists() {
    local branch="$1"
    git show-ref --verify --quiet "refs/heads/$branch"
}

# Resolve a ref name to a commit SHA (tag > branch > remote branch > generic).
resolve_ref_to_commit() {
    local ref="$1"

    if git rev-parse --verify --quiet "refs/tags/$ref^{commit}" > /dev/null 2>&1; then
        git rev-parse --verify --quiet "refs/tags/$ref^{commit}"
        return 0
    fi

    if git rev-parse --verify --quiet "refs/heads/$ref^{commit}" > /dev/null 2>&1; then
        git rev-parse --verify --quiet "refs/heads/$ref^{commit}"
        return 0
    fi

    if git rev-parse --verify --quiet "refs/remotes/$ref^{commit}" > /dev/null 2>&1; then
        git rev-parse --verify --quiet "refs/remotes/$ref^{commit}"
        return 0
    fi

    # Generic: commit hash, HEAD, HEAD~2, sha^, ...
    git rev-parse --verify --quiet "${ref}^{commit}" 2>/dev/null
}

# Does the given ref resolve to a commit (tag, branch or hash)?
git_ref_exists() {
    local ref="$1"
    resolve_ref_to_commit "$ref" > /dev/null 2>&1
}

# Show similar names when a ref cannot be found
show_ref_hints() {
    local ref="$1"
    local found=""

    local t
    t=$(git tag --list "*$ref*" 2>/dev/null | head -n 10 || true)
    if [ -n "$t" ]; then
        log_info "Tags matching '${ref}':"
        printf '%s\n' "$t" | sed 's/^/  /'
        found="yes"
    fi

    local b
    b=$(git branch --list "*$ref*" 2>/dev/null | head -n 10 || true)
    if [ -n "$b" ]; then
        log_info "Branches matching '${ref}':"
        printf '%s\n' "$b" | sed 's/^/  /'
        found="yes"
    fi

    local rb
    rb=$(git branch -r --list "*$ref*" 2>/dev/null | head -n 10 || true)
    if [ -n "$rb" ]; then
        log_info "Remote branches matching '${ref}':"
        printf '%s\n' "$rb" | sed 's/^/  /'
        found="yes"
    fi

    [ -n "$found" ] || log_info "No tag, branch or remote branch matches '${ref}'"
}

# Make sure the requested source is available locally; try to fetch it if not.
ensure_source_available() {
    local ref="$1"

    if git_ref_exists "$ref"; then
        return 0
    fi

    # The ref exists but does not point to a commit?
    if git show-ref --verify --quiet "refs/tags/$ref" || git show-ref --verify --quiet "refs/heads/$ref"; then
        log_error "Ref '$ref' exists but does not point to a commit"
        return 1
    fi

    if git remote get-url origin > /dev/null 2>&1; then
        log_info "Source '$ref' is not available locally - trying to fetch it from origin..."

        # The '+' allows updating an already existing tag, so a locally
        # present tag does not abort the fetch with "would clobber existing tag".
        git fetch origin "+refs/tags/$ref:refs/tags/$ref" > /dev/null 2>&1 || true
        git fetch --tags origin > /dev/null 2>&1 || true

        if git_ref_exists "$ref"; then
            log_success "Fetched '$ref' from origin"
            return 0
        fi
    fi

    return 1
}

# Describe what kind of Git object the resolved ref is
describe_ref() {
    local ref="$1"

    if git show-ref --verify --quiet "refs/tags/$ref"; then
        local type
        type=$(git cat-file -t "refs/tags/$ref" 2>/dev/null || echo "commit")
        if [ "$type" = "tag" ]; then
            echo "annotated tag"
        else
            echo "lightweight tag"
        fi
    elif git show-ref --verify --quiet "refs/heads/$ref"; then
        echo "branch"
    elif [ "$ref" = "HEAD" ]; then
        echo "current HEAD"
    else
        echo "commit"
    fi
}

# ================== GIT STATUS CHECK ==================
check_git_status() {
    local target_dir="$1"

    # Validate input
    if [ -z "$target_dir" ]; then
        log_warn "No directory specified for git status check"
        return 0
    fi

    if [ ! -d "$target_dir" ]; then
        log_warn "Directory '$target_dir' does not exist, skipping git status check"
        return 0
    fi

    local prev_dir
    prev_dir="$(pwd)"

    if ! cd "$target_dir"; then
        log_warn "Cannot change to directory '$target_dir', skipping git status check"
        return 0
    fi

    # Check if git repository
    if ! git rev-parse --git-dir > /dev/null 2>&1; then
        log_warn "Not a git repository, skipping sync check"
        cd "$prev_dir" || true
        return 0
    fi

    # Check for remote
    local remote_url
    remote_url=$(git remote get-url origin 2>/dev/null || echo "")

    if [ -z "$remote_url" ]; then
        log_warn "No remote configured, skipping sync check"
        cd "$prev_dir" || true
        return 0
    fi

    # Identify host (GitHub or Codeberg)
    local remote_host="origin"
    if echo "$remote_url" | grep -q "github.com"; then
        remote_host="GitHub"
    elif echo "$remote_url" | grep -q "codeberg.org"; then
        remote_host="Codeberg"
    fi

    log_info "Checking sync with $remote_host..."

    # Fetch latest from remote (tags included, so that --source=<tag> works)
    log_step "Fetching latest from remote..."
    if ! git fetch --tags origin 2>&1; then
        log_warn "Failed to fetch from remote, continuing anyway..."
        cd "$prev_dir" || true
        return 0
    fi

    # Get current HEAD commit and remote HEAD commit
    local local_head remote_head
    local_head=$(git rev-parse HEAD)
    remote_head=$(git rev-parse FETCH_HEAD 2>/dev/null || echo "$local_head")

    if [ "$local_head" != "$remote_head" ]; then
        log_warn "Your local repository is NOT up-to-date with $remote_host"
        log_warn "Local HEAD:  ${local_head:0:8}"
        log_warn "Remote HEAD: ${remote_head:0:8}"
        echo ""

        if [ "$AUTO_ACCEPT" = false ]; then
            read -p "Do you want to pull the latest changes before creating the release? [y/N] " -n 1 -r || true
            echo ""

            if [[ "${REPLY:-}" =~ ^[Yy]$ ]]; then
                log_step "Pulling latest changes..."
                if git pull --ff-only; then
                    log_success "Pull completed"
                else
                    log_error "Pull failed. Please resolve conflicts manually."
                    exit 1
                fi
            else
                log_warn "Proceeding without pulling latest changes..."
            fi
        else
            log_warn "Auto-accept enabled, proceeding without pulling..."
        fi
    else
        log_success "Repository is up-to-date with $remote_host"
    fi

    echo ""
    cd "$prev_dir" || true
    return 0
}

# ================== INTERACTIVE INPUT ==================
prompt_version() {
    echo ""
    echo "=============================================="
    echo -e "${BOLD}WackoWiki Release Builder${NC}"
    echo "=============================================="
    echo ""
    echo "No VERSION specified."
    echo ""
    echo -e "${BOLD}VERSION and SOURCE are two different things:${NC}"
    echo ""
    echo "  ${BOLD}VERSION${NC}  = the ${BOLD}file name${NC} of the release archive only"
    echo "               (e.g. 6.3.1 or 6.3.1-dev)"
    echo "               ${YELLOW}It does NOT select any Git code.${NC}"
    echo "  ${BOLD}SOURCE${NC}   = the ${BOLD}Git code${NC} that is really built"
    echo "               (tag, branch or commit hash - see --source)"
    echo ""
    echo "On the command line the version is only a file name:"
    echo "  ${CYAN}./build-release.sh --version=6.3.1${NC}              ${YELLOW}-> HEAD of master, file wackowiki-6.3.1.tar.gz${NC}"
    echo "  ${CYAN}./build-release.sh --version=6.3.1 --source=6.3.1${NC} ${YELLOW}-> tag 6.3.1,   file wackowiki-6.3.1.tar.gz${NC}"
    echo ""

    # Get current branch/tag info for suggestions
    local current_branch latest_tag answer=""
    current_branch=$(git symbolic-ref --short HEAD 2>/dev/null || echo "")
    latest_tag=$(git describe --tags --abbrev=0 2>/dev/null || echo "")

    if [ -n "$latest_tag" ]; then
        echo -e "Latest tag: ${GREEN}$latest_tag${NC}  ${YELLOW}(only a suggestion - it is not built unless you choose it)${NC}"
    fi

    if [ -n "$current_branch" ]; then
        echo -e "Current branch: ${YELLOW}$current_branch${NC}"
    fi
    echo ""

    if [ -z "$latest_tag" ]; then
        read -r -p "Build MASTER snapshot (M) or enter a version: " answer || true
    else
        read -r -p "Build MASTER snapshot (M), the latest tag ${GREEN}${latest_tag}${NC} (T), or enter a version: " answer || true
    fi
    echo ""
    answer="${answer//[[:space:]]/}"

    # (1) MASTER snapshot - unstable, built from HEAD
    case "$answer" in
        ""|M|m|MASTER|master)
            VERSION="MASTER"
            SOURCE="HEAD"
            SOURCE_EXPLICIT=false
            log_info "MASTER snapshot"
            log_info "  Source : HEAD of ${current_branch:-current branch}"
            log_info "  File   : wackowiki-MASTER.tar.gz"
            prompt_build_assets
            return 0
            ;;
    esac

    # (2) The latest tag - real tagged release
    case "$answer" in
        T|t|tag|TAG)
            if [ -z "$latest_tag" ]; then
                log_error "No Git tag found in this repository"
                return 1
            fi
            VERSION="$latest_tag"
            SOURCE="$latest_tag"
            SOURCE_EXPLICIT=true
            prompt_archive_name "$latest_tag"
            log_info "Tagged release"
            log_info "  Source : tag ${SOURCE}"
            log_info "  File   : wackowiki-${VERSION}.tar.gz"
            prompt_build_assets
            return 0
            ;;
    esac

    # (3) An explicitly entered version
    prompt_version_number "$answer"

    # Does the entered version match an existing Git tag?
    if git_tag_exists "$VERSION"; then
        local confirm=""
        echo ""
        echo -e "Version '${GREEN}${VERSION}${NC}' exists as a Git tag."
        read -r -p "Build from that tag? [Y/n]: " confirm || true
        echo ""
        confirm="${confirm:-Y}"

        if [[ "$confirm" =~ ^[Yy]$ ]]; then
            SOURCE="$VERSION"
            SOURCE_EXPLICIT=true
            # The file name follows the tag by default
            prompt_archive_name "$VERSION"
            log_info "Tagged release"
            log_info "  Source : tag ${SOURCE}"
            log_info "  File   : wackowiki-${VERSION}.tar.gz"
        else
            SOURCE="HEAD"
            SOURCE_EXPLICIT=false
            log_warn "Source : HEAD of ${current_branch:-current branch}  (NOT the tag ${VERSION})"
            log_info "The archive will be named wackowiki-${VERSION}.tar.gz but it contains"
            log_info "master HEAD - not the ${VERSION} release."
            log_info "Build the tagged release with: ./build-release.sh --version=${VERSION} --source=${VERSION}"
        fi
        prompt_build_assets
        return 0
    fi

    # No tag with that name -> the version is only a file name
    SOURCE="HEAD"
    SOURCE_EXPLICIT=false
    log_info "No Git tag named '${VERSION}' found."
    log_info "  Source : HEAD of ${current_branch:-current branch}"
    log_info "  File   : wackowiki-${VERSION}.tar.gz  ${YELLOW}(file name only - not a Git tag)${NC}"

    # Give the chance to select the Git code explicitly
    prompt_source_ref
    prompt_build_assets
    return 0
}

# Ask for the version (file name). $1 = optional pre-filled value.
prompt_version_number() {
    local initial="${1:-}"
    local answer=""
    local confirm=""

    if [ -n "$initial" ]; then
        answer="$initial"
    else
        read -r -p "Enter version number (e.g., 6.2.2): " answer || true
    fi

    answer="${answer//[[:space:]]/}"

    if [ -z "$answer" ]; then
        log_error "Version cannot be empty"
        prompt_version_number ""
        return
    fi

    # Validate version format (basic check, not a hard restriction)
    if ! [[ "$answer" =~ ^[0-9]+\.[0-9]+(\.[0-9]+)?([-+][0-9A-Za-z.-]+)?$ ]]; then
        log_warn "Version '$answer' doesn't look like a standard semver (X.Y or X.Y.Z)"
        read -r -p "Use this version anyway? [y/N]: " confirm || true
        echo ""

        if [[ ! "${confirm:-}" =~ ^[Yy]$ ]]; then
            prompt_version_number ""
            return
        fi
    fi

    VERSION="$answer"
}

# Ask for the Git source (tag / branch / commit hash).
prompt_source_ref() {
    local answer=""
    local current_branch
    current_branch=$(git symbolic-ref --short HEAD 2>/dev/null || echo "current branch")

    echo ""
    echo -e "${BOLD}SOURCE${NC} = the Git code that is built (tag, branch or commit hash)."
    read -r -p "Source ref (empty = HEAD of ${current_branch}): " answer || true
    echo ""
    answer="${answer//[[:space:]]/}"

    if [ -z "$answer" ]; then
        return 0
    fi

    if ! ensure_source_available "$answer"; then
        log_error "Source '$answer' not found (not a valid tag, branch, or commit)"
        show_ref_hints "$answer"
        return 0
    fi

    SOURCE="$answer"
    SOURCE_EXPLICIT=true

    # The file naming follows the tag by default
    if git_tag_exists "$answer" && [ "$VERSION" != "$answer" ]; then
        log_info "Source is the tag '${answer}' - the file name follows the tag by default."
        prompt_archive_name "$answer"
    fi

    log_info "  Source : ${SOURCE}"
    log_info "  File   : wackowiki-${VERSION}.tar.gz"
}

# Ask for the archive file name. $1 = default base name (usually the tag).
prompt_archive_name() {
    local default_name="${1:-$VERSION}"
    local answer=""

    if [ -n "$ARCHIVE_NAME" ]; then
        VERSION="$ARCHIVE_NAME"
        return 0
    fi

    echo -e "  ${BOLD}File name${NC}: ${CYAN}wackowiki-${default_name}.tar.gz${NC}   ${YELLOW}(press ENTER to keep)${NC}"
    read -r -p "  Different name (without .tar.gz)? " answer || true
    echo ""
    answer="${answer//[[:space:]]/}"

    if [ -n "$answer" ]; then
        VERSION="$answer"
    else
        VERSION="$default_name"
    fi
}

# Ask whether to build/minimize JavaScript and CSS assets
prompt_build_assets() {
    echo ""
    echo -e "${BOLD}Asset optimization${NC}"
    echo "  Minify and bundle JavaScript (esbuild) and minify theme CSS."
    echo "  This requires Node.js >= 18 and network access (to fetch esbuild)."
    echo ""
    read -r -p "Build and minimize JavaScript assets and CSS? [y/N]: " -n 1 -r || true
    echo ""
    if [[ "${REPLY:-}" =~ ^[Yy]$ ]]; then
        BUILD_JS=true
        BUILD_THEME=true
        log_info "JavaScript and CSS optimization: ${GREEN}enabled${NC}"
    else
        BUILD_JS=false
        BUILD_THEME=false
        log_info "JavaScript and CSS optimization: ${YELLOW}disabled${NC} (unbuilt sources will be shipped)"
    fi
}

# ================== SOURCE/BRANCH RESOLUTION ==================
resolve_source() {
    local ref=""

    # If BRANCH specified, use that; otherwise use SOURCE
    if [ -n "$BRANCH" ]; then
        # Verify branch exists
        if ! git_branch_exists "$BRANCH"; then
            log_error "Branch '$BRANCH' does not exist"
            log_info "Available branches:"
            git branch --format='  %(refname:short)' || true
            return 1
        fi
        ref="$BRANCH"

    elif [ "$SOURCE" = "auto" ]; then
        # Tag matching --version, otherwise HEAD
        if [ -n "$VERSION" ] && git_tag_exists "$VERSION"; then
            ref="$VERSION"
            log_info "Auto source: tag '${VERSION}' (matches the given version)"
        else
            ref="HEAD"
            log_info "Auto source: no tag named '${VERSION:-<none>}' - using HEAD of the current branch"
        fi

    elif [ "$SOURCE" = "HEAD" ]; then
        # Use current HEAD
        ref="HEAD"

    else
        # SOURCE could be a tag, a branch or a commit hash
        if git_tag_exists "$SOURCE" && git_branch_exists "$SOURCE"; then
            log_warn "'$SOURCE' exists as a tag AND as a branch - the tag is used"
        fi

        if ! ensure_source_available "$SOURCE"; then
            log_error "Source '$SOURCE' not found (not a valid tag, branch, or commit)"
            show_ref_hints "$SOURCE"
            return 1
        fi

        ref="$SOURCE"
    fi

    if ! RESOLVED_COMMIT=$(resolve_ref_to_commit "$ref"); then
        log_error "Cannot resolve source '$ref' to a commit"
        show_ref_hints "$ref"
        return 1
    fi

    RESOLVED_REF="$ref"
    return 0
}

# ================== ASSET BUILD (JS + THEME) ==================
# The JavaScript AND the theme are built FROM THE EXPORTED SOURCE TREE,
# so the shipped assets always match the Git commit that is released
# (never the working copy).

# Locate the JS source folder inside the EXPORTED tree.
# Works for "src/js", "js" and "src/plugins/<name>/js" layouts.
find_js_source() {
    local root="$1"
    local c

    for c in "$root/src/js" "$root/js" "$root/src/plugins/wikiedit/js"; do
        if [ -f "$c/main.js" ]; then
            echo "$c"
            return 0
        fi
    done

    # Fallback: any js/main.js within a reasonable depth
    local found
    found="$(find "$root" -maxdepth 6 -type f -name 'main.js' -path '*/js/*' 2>/dev/null | sort | head -n 1 || true)"
    if [ -n "$found" ]; then
        dirname "$found"
        return 0
    fi

    return 1
}

# Locate the THEME source folder inside the EXPORTED tree.
# The theme lives next to the JS sources: "src/theme" (preferred),
# "theme" or "src/plugins/<name>/theme" are accepted as well.
find_theme_source() {
    local root="$1"
    local c

    for c in "$root/src/theme" "$root/theme" "$root/src/plugins/wikiedit/theme"; do
        if [ -d "$c" ]; then
            echo "$c"
            return 0
        fi
    done

    # Fallback: any folder named "theme" within a reasonable depth
    local found
    found="$(find "$root" -maxdepth 6 -type d -name 'theme' 2>/dev/null | sort | head -n 1 || true)"
    if [ -n "$found" ]; then
        echo "$found"
        return 0
    fi

    return 1
}

# Locate build.mjs: the checkout's copy is preferred (it is release
# tooling, like this script), the exported copy is the fallback.
find_build_script() {
    local root="$1"
    local f

    if [ -f "$REPO_ROOT/build.mjs" ]; then
        echo "$REPO_ROOT/build.mjs"
        return 0
    fi

    f="$(find "$root" -maxdepth 6 -type f -name 'build.mjs' 2>/dev/null | sort | head -n 1 || true)"
    if [ -n "$f" ]; then
        echo "$f"
        return 0
    fi

    return 1
}

# Informational: list the source files that are not shipped any more
# (they are compiled into a bundle now).
report_js_diff() {
    local src_js="$1" out_js="$2"
    [ -d "$src_js" ] || return 0

    local f rel count=0
    while IFS= read -r -d '' f; do
        rel="${f#"$src_js"/}"
        if [ ! -e "$out_js/$rel" ]; then
            log_info "not shipped (compiled into a bundle): js/$rel"
            count=$((count + 1))
        fi
    done < <(find "$src_js" -type f -print0 2>/dev/null || true)

    if [ "$count" -gt 0 ]; then
        log_info "$count source file(s) are not shipped any more"
    fi
    return 0
}

# Informational: check that every theme CSS file was built (minified).
report_theme_diff() {
    local src_theme="$1" out_theme="$2"
    [ -d "$src_theme" ] || return 0

    local css_total=0 css_built=0 f rel
    while IFS= read -r -d '' f; do
        css_total=$((css_total + 1))
        rel="${f#"$src_theme"/}"
        if [ -f "$out_theme/$rel" ]; then
            css_built=$((css_built + 1))
        fi
    done < <(find "$src_theme" -type f -name '*.css' -print0 2>/dev/null || true)

    if [ "$css_total" -gt 0 ]; then
        log_info "theme CSS: $css_built/$css_total minified"
    fi

    if [ "$css_built" -ne "$css_total" ]; then
        log_warn "Some theme CSS files are missing in the built theme"
        if [ "$JS_STRICT" = true ]; then
            log_error "Strict mode: aborting because of the incomplete theme build."
            exit 1
        fi
    fi
    return 0
}

# Rewrite the manifest keys so they match the layout of the release tree:
#   "theme/default/css/default.css" -> "src/theme/default/css/default.css"
rewrite_manifest_theme_keys() {
    local manifest="$1" out="$2" prefix="$3"

    node -e '
const fs = require("fs");
const [src, out, prefix] = process.argv.slice(1);
const m = JSON.parse(fs.readFileSync(src, "utf8"));
const files = {};
for (const [k, v] of Object.entries(m.files || {})) {
    const nk = k.startsWith("theme/") ? prefix + k.slice("theme/".length) : k;
    files[nk] = v;
}
m.files = files;
fs.writeFileSync(out, JSON.stringify(m, null, 2) + "\n");
' "$manifest" "$out" "$prefix" 2>/dev/null
}

# Build the JavaScript AND theme assets from the EXPORTED source tree.
#   $1 = exported tree root (contains src/)
#   $2 = destination root of the release tree (contains src/)
#
# build.mjs handles both in a single run:
#   --js=<dir>         source folder with the JS sources
#   --out=<dir>        output folder for the built JS
#   --theme=<dir>      source theme folder (CSS is minified here)
#   --theme-out=<dir>  output folder for the built theme
build_assets() {
    local src_root="$1"
    local dest_root="$2"

    if [ "$BUILD_JS" != true ]; then
        log_warn "JavaScript build skipped (--js not specified) - the release contains the unbuilt sources"
        log_warn "The theme CSS is not minified either (JS and theme are built in one run)"
        return 0
    fi

    # --- node -----------------------------------------------------------
    if ! command -v node >/dev/null 2>&1; then
        log_error "Node.js >= 18 is required to build the JavaScript assets, but 'node' was not found."
        log_info "Install Node.js (https://nodejs.org) or build with --js."
        exit 1
    fi

    local node_version node_major
    node_version="$(node -v 2>/dev/null || echo 'unknown')"
    node_major="$(node -p 'process.versions.node.split(".")[0]' 2>/dev/null || echo 0)"
    if [ "${node_major:-0}" -lt 18 ]; then
        log_error "Node.js >= 18 is required (found $node_version)."
        exit 1
    fi

    # --- source folder / build script ------------------------------------
    local js_src build_mjs
    if ! js_src="$(find_js_source "$src_root")"; then
        log_error "No JS source folder (js/main.js) found in the exported source."
        log_info "Looked in: $src_root/src/js, $src_root/js and below src/plugins/*/js"
        log_info "Use --js to build the assets."
        exit 1
    fi

    if ! build_mjs="$(find_build_script "$src_root")"; then
        log_error "build.mjs not found (looked in '$REPO_ROOT' and in the exported tree)."
        exit 1
    fi

    # The destination mirrors the source path inside the release tree
    # ($TEMP_DIR/src/js  ->  $FINAL_DIR/src/js)
    JS_DEST="${js_src#"$src_root"}"        # e.g. /src/js
    local dest_js="${dest_root}${JS_DEST}"

    # --- theme source ----------------------------------------------------
    local theme_src="" dest_theme=""
    local theme_stage="$BUILD_DIR/theme-dist"
    local -a theme_args=()

    if [ "$BUILD_THEME" = true ]; then
        if theme_src="$(find_theme_source "$src_root")"; then
            THEME_DEST="${theme_src#"$src_root"}"     # e.g. /src/theme
            dest_theme="${dest_root}${THEME_DEST}"
            theme_args+=("--theme=$theme_src" "--theme-out=$theme_stage")

            log_info "  Theme source: $theme_src"
            log_info "  Theme output: $theme_stage"
        else
            log_warn "No theme folder found in the exported source - the CSS is shipped unminified."
            BUILD_THEME=false
        fi
    fi

    if [ "$BUILD_THEME" != true ]; then
        # Explicitly neutralise the theme build inside build.mjs, so it never
        # falls back to its own defaults (which would point at the checkout's
        # src/theme instead of the exported source).
        mkdir -p "$BUILD_DIR/.no-theme-src"
        theme_args+=("--theme=$BUILD_DIR/.no-theme-src" "--theme-out=$BUILD_DIR/.no-theme-out")
    fi

    # --- esbuild --------------------------------------------------------
    # build.mjs imports the esbuild JS API. ESM ignores NODE_PATH, so
    # esbuild must be resolvable from the directory of the build script.
    local tools_dir="$BUILD_DIR/.js-tools"
    local build_script="$build_mjs"

    if [ ! -d "$REPO_ROOT/node_modules/esbuild" ]; then
        if ! command -v npm >/dev/null 2>&1; then
            log_error "'npm' is required to install esbuild, but it was not found."
            log_info "Install Node.js + npm, or build without --js."
            exit 1
        fi

        rm -rf "$tools_dir"
        mkdir -p "$tools_dir"

        cat > "$tools_dir/package.json" <<'EOF'
{
  "name": "wikiedit-js-tools",
  "private": true,
  "version": "1.0.0"
}
EOF

        # Prefer the version pinned in the repository
        local esbuild_version="$ESBUILD_VERSION"
        local pinned
        pinned="$(PKG_JSON="$REPO_ROOT/package.json" node -p "try{const p=require(process.env.PKG_JSON);(p.devDependencies&&p.devDependencies.esbuild)||(p.dependencies&&p.dependencies.esbuild)||''}catch(e){''}" 2>/dev/null || true)"
        if [ -n "$pinned" ]; then
            esbuild_version="${pinned#\^}"
        fi

        log_step "Installing esbuild@$esbuild_version (isolated in $tools_dir)..."
        if ! npm install --prefix "$tools_dir" --no-save --no-audit --no-fund \
                --loglevel=error "esbuild@$esbuild_version" >/dev/null 2>&1; then
            log_error "Could not install esbuild@$esbuild_version (no network?)."
            log_info "Run 'npm install' in the checkout and retry, or build without --js."
            exit 1
        fi

        # Copy the build script next to the installed esbuild so that the
        # ESM import of 'esbuild' resolves against $tools_dir/node_modules.
        cp "$build_mjs" "$tools_dir/build.mjs"
        build_script="$tools_dir/build.mjs"
    fi

    # --- run -------------------------------------------------------------
    local js_stage="$BUILD_DIR/js-dist"
    local manifest="$BUILD_DIR/js-manifest.json"

    rm -rf "$js_stage" "$theme_stage"
    rm -f "$manifest"

    local -a js_args=()
    [ "$JS_STRICT" = true ] && js_args+=("--strict")
    [ "$JS_SOURCE_MAPS" = true ] && js_args+=("--with-source-maps")

    log_step "Building JavaScript and theme assets (source: $RESOLVED_REF, commit ${RESOLVED_COMMIT:0:8})..."
    log_info "  JS source   : $js_src"
    log_info "  JS output   : $js_stage"
    if [ "$BUILD_THEME" = true ]; then
        log_info "  Theme source: $theme_src"
        log_info "  Theme output: $theme_stage"
    fi

    if ! node "$build_script" \
            --js="$js_src" \
            --out="$js_stage" \
            --manifest="$manifest" \
            --commit="$RESOLVED_COMMIT" \
            ${theme_args[@]+"${theme_args[@]}"} \
            ${js_args[@]+"${js_args[@]}"}; then
        log_error "The asset build failed."
        exit 1
    fi

    # --- sanity checks ---------------------------------------------------
    if [ ! -f "$js_stage/wikiedit.min.js" ]; then
        log_error "The JavaScript build did not produce js/wikiedit.min.js - aborting."
        exit 1
    fi

    # The toolbar customizer keeps its original name (NO ".min" suffix).
    local standalone_rel="editor/toolbar/toolbar-customizer.js"
    if [ -f "$js_src/$standalone_rel" ]; then
        if [ -f "$js_stage/$standalone_rel" ]; then
            log_info "standalone: $standalone_rel (name unchanged)"
        else
            log_warn "The build did not produce js/$standalone_rel - the build.mjs in use looks outdated."
            log_warn "The file name must NOT be changed to toolbar-customizer.min.js."
            if [ "$JS_STRICT" = true ]; then
                log_error "Strict mode: aborting."
                exit 1
            fi
        fi
    fi

    # --- install into the release tree -----------------------------------
    log_step "Installing the built JavaScript into the release tree..."
    report_js_diff "$js_src" "$js_stage"

    rm -rf "$dest_js"
    mkdir -p "$(dirname "$dest_js")"
    cp -a "$js_stage" "$dest_js"

    # --- install the built theme ------------------------------------------
    if [ "$BUILD_THEME" = true ]; then
        log_step "Installing the built theme into the release tree..."
        report_theme_diff "$theme_src" "$theme_stage"

        rm -rf "$dest_theme"
        mkdir -p "$(dirname "$dest_theme")"

        if [ -d "$theme_stage" ]; then
            # copy the CONTENTS of the staging folder (not the folder itself)
            cp -a "$theme_stage/." "$dest_theme/"
        else
            log_warn "The built theme folder '$theme_stage' is missing."
            if [ "$JS_STRICT" = true ]; then
                log_error "Strict mode: aborting because the theme build produced no output."
                exit 1
            fi
            log_warn "Shipping the unminified theme instead."
            cp -a "$theme_src/." "$dest_theme/"
        fi

        log_success "Theme installed ($(du -sh "$dest_theme" 2>/dev/null | cut -f1) total)"
    fi


    # Manifest for PHP (integrity attribute + cache busting)
    if [ -f "$manifest" ]; then
        JS_MANIFEST="$manifest"

        # The manifest keys must match the release tree layout:
        #   "theme/..." -> "<THEME_DEST without leading slash>/..."
        local release_manifest="$BUILD_DIR/js-manifest.release.json"
        local theme_prefix=""
        [ -n "$THEME_DEST" ] && theme_prefix="${THEME_DEST#/}"

        if [ -n "$theme_prefix" ] && rewrite_manifest_theme_keys "$manifest" "$release_manifest" "$theme_prefix"; then
            cp "$release_manifest" "$dest_js/manifest.json"
        else
            cp "$manifest" "$dest_js/manifest.json"
        fi

        local sri
        sri="$(MANIFEST_JSON="$dest_js/manifest.json" node -p "try{require(process.env.MANIFEST_JSON).files['wikiedit.min.js'].sri||''}catch(e){''}" 2>/dev/null || true)"
        if [ -n "$sri" ]; then
            log_info "SRI (wikiedit.min.js): $sri"
        fi
    fi

    log_success "JavaScript assets installed ($(du -sh "$dest_js" 2>/dev/null | cut -f1) total)"
}

# ================== PARSE ARGUMENTS ==================
parse_arguments() {
    while [[ $# -gt 0 ]]; do
        case "$1" in
            --version=*)
                VERSION="${1#*=}"
                VERSION_EXPLICIT=true
                ;;

            --source=*)
                SOURCE="${1#*=}"
                SOURCE_EXPLICIT=true
                ;;

            --branch=*)
                BRANCH="${1#*=}"
                SOURCE_EXPLICIT=true
                ;;

            --name=*)
                ARCHIVE_NAME="${1#*=}"
                ;;

            --minimal)
                MINIMAL=true
                ;;

            --full)
                MINIMAL=false
                ;;

            --no-log)
                ENABLE_LOG=false
                ;;

            --no-zip)
                MAKE_ZIP=false
                ;;

            # ── ASSET BUILD ──
            --js)
                BUILD_JS=true
                ;;

            --theme)
                BUILD_THEME=true
                ;;

            --strict-js)
                JS_STRICT=true
                ;;

            --js-source-maps)
                JS_SOURCE_MAPS=true
                ;;

            -y|--yes|--auto-accept)
                AUTO_ACCEPT=true
                ;;

            --help|-h)
                show_help
                exit 0
                ;;

            *)
                echo "Unknown option: $1"
                echo "Use --help for usage information"
                exit 1
                ;;
        esac
        shift
    done
}

show_help() {
    cat << 'EOF'
===============================================
WackoWiki Release Builder
===============================================

Usage: ./build-release.sh [OPTIONS]

VERSION and SOURCE are two different things:
    --version   ONLY names the archive (file name).
                It does NOT select any Git code that is built.
    --source    Selects the Git code that is really built
                (tag / branch / commit hash).

OPTIONS:
    --version=X.Y.Z    Name of the release archive (file name only)
                       (required unless building a MASTER snapshot)
                       If a Git tag with the same name exists, the interactive
                       prompt offers to build that tag and the file name
                       follows the tag.

    --source=REF       Git reference to build from
                       Can be: HEAD, tag name, branch name, commit hash
                       or "auto" (tag matching --version, otherwise HEAD)
                       Default: HEAD (current commit)

    --branch=NAME      Build from specific branch
                       (alternative to --source)

    --name=BASE        Override the archive base name
                       (default: wackowiki-<version>)

    --minimal          Build minimal package (src/ + vendor/)
                       This is the default

    --full             Build full package including docs
                       (src/ + vendor/ + README, LICENSE, etc.)

    --no-log           Disable logging to build.log

    --no-zip           Skip creation of the .zip archive
                       (only the .tar.gz is created)

    --js               Build and minimize JavaScript assets (esbuild)
                       Requires Node.js >= 18 and network access
                       (default: off - unbuilt sources are shipped)

    --theme            Minify theme CSS
                       Requires --js (both are built in one run)
                       (default: off - unminified CSS is shipped)

    --strict-js        Fail the release if the JS build reports problems
                       (files outside editor/, dangling imports,
                        missing theme CSS, renamed standalone scripts)

    --js-source-maps   Also emit .map files for the static JS assets
                       (and for the theme CSS)

    -y, --yes          Auto-accept all prompts (for CI/CD)

    --help, -h         Show this help message

EXAMPLES:
Basic usage (default):

    ./build-release.sh --version=6.3.1 - pulls HEAD of master branch

Build from tag:

    ./build-release.sh --version=6.3.1 --source=6.3.1 - pulls version with 6.3.1 tag

Build from commit hash:

    ./build-release.sh --version=6.3.1-dev --source=e5266a8043f17fcef4a168ecaf6232bc6a38e9b8 - pulls version with the provided hash

More examples:
    # Interactive mode (asks for version AND for the Git source)
    ./build-release.sh

    # Build master snapshot
    ./build-release.sh --version=MASTER

    # Build from a tag, but name the file differently
    ./build-release.sh --version=6.3.1-dev --source=6.3.1

    # Build from a tag when it exists, otherwise from HEAD
    ./build-release.sh --version=6.3.1 --source=auto

    # Build from specific branch
    ./build-release.sh --branch=6.3 --version=6.3.0

    # Build full package
    ./build-release.sh --version=6.3.1 --full

    # Build with optimized assets (minified JS + CSS)
    ./build-release.sh --version=6.3.1 --js --theme

    # Non-interactive/CI mode with asset optimization
    ./build-release.sh --version=6.3.1 --source=6.3.1 --js --theme --yes

NOTES:
    - Script must be executed from repository root
    - composer.json must be present in root directory
    - Git remote should be configured (GitHub or Codeberg)
    - Script will check if local repo is up-to-date with remote
    - If --version matches an existing tag but no --source is given, the
      script warns that the archive contains master HEAD, not that tag.

For more information, see: community/devel/build-release.sh
===============================================
EOF
}

# ================== MAIN ==================
main() {
    # Parse command line arguments first
    parse_arguments "$@"

    # Find repository root
    log_step "Locating WackoWiki repository..."

    local found_repo
    found_repo=$(find_repo_root) || found_repo=""   # keep "set -e" from aborting here

    if [ -z "$found_repo" ]; then
        log_error "This does not appear to be a WackoWiki repository."
        echo ""
        log_info "Please run this script from the WackoWiki repository root."
        log_info "The root directory must contain:"
        echo "    • composer.json (with \"name\" containing \"wackowiki\")"
        echo "    • .git directory"
        echo ""
        log_info "Expected location: ~/path/to/wackowiki/"
        echo ""
        log_info "You are currently in: $(pwd)"
        echo ""
        log_info "Tip: If you copied build-release.sh to community/devel/, "
        log_info "     copy it to the repository root and run it from there."
        exit 1
    fi

    # Validate the found path
    if [ ! -d "$found_repo" ]; then
        log_error "Found repository path is invalid: $found_repo"
        exit 1
    fi

    # Change to repository root
    if ! cd "$found_repo"; then
        log_error "Cannot change to repository directory: $found_repo"
        exit 1
    fi

    REPO_ROOT="$(pwd)"
    log_success "WackoWiki repository confirmed: $REPO_ROOT"
    echo ""

    # ---------------------------------------------------------
    # Prepare build directory and START LOGGING as early as
    # possible, so build.log contains the whole run.
    # ---------------------------------------------------------
    BUILD_DIR="$REPO_ROOT/build"

    rm -rf "$BUILD_DIR"
    mkdir -p "$BUILD_DIR"

    if [ "$ENABLE_LOG" = true ]; then
        if start_logging "$BUILD_DIR"; then
            log_step "Logging to: $LOG_FILE"
            log_info "build.log is plain text (ANSI stripping via $ANSI_STRIPPER)"
        fi
    fi

    echo ""
    echo "=================================================="
    echo -e "${BOLD}Building WackoWiki${NC}"
    echo "=================================================="
    if [ -n "$VERSION" ]; then
        echo "Version     : $VERSION    ${YELLOW}<- archive file name only${NC}"
        echo "Source      : ${SOURCE}${BRANCH:+ (branch: $BRANCH)}    ${YELLOW}<- Git code that is built${NC}"
    else
        echo "Version     : ${YELLOW}<will be asked interactively>${NC}"
        echo "Source      : ${YELLOW}<will be asked interactively>${NC}"
    fi
    echo "Mode        : $([ "$MINIMAL" = true ] && echo "Minimal (src/ + vendor/)" || echo "Full (includes docs)")"
    echo "JS build    : $([ "$BUILD_JS" = true ] && echo "yes (--js)" || echo "no")"
    echo "Theme build : $([ "$BUILD_THEME" = true ] && echo "yes (--theme, CSS minified)" || echo "no")"
    echo "=================================================="
    echo ""

    # Check git sync status
    check_git_status "$REPO_ROOT"

    # Prompt for version if not provided
    if [ -z "$VERSION" ]; then
        if [ "$AUTO_ACCEPT" = true ]; then
            log_error "--version is required in non-interactive mode (--yes)"
            log_info "Example: ./build-release.sh --version=6.3.1 --source=auto --yes"
            exit 1
        fi
        prompt_version
    fi

    # Guard against an empty archive name
    if [ -z "$VERSION" ]; then
        log_error "No version / archive file name determined - aborting"
        exit 1
    fi

    # Resolve actual source to build from
    if ! resolve_source; then
        log_error "Could not resolve source"
        exit 1
    fi

    local source_kind
    source_kind=$(describe_ref "$RESOLVED_REF")

    # Make sure the user is not misled: a version that exists as tag but is
    # built from something else must be stated explicitly.
    if [ "$VERSION_EXPLICIT" = true ] && [ "$SOURCE_EXPLICIT" = false ] \
       && [ "$RESOLVED_REF" != "$VERSION" ] && git_tag_exists "$VERSION"; then
        log_warn "Version '${VERSION}' matches the Git tag '${VERSION}', but this build uses '${RESOLVED_REF}'."
        log_warn "The archive will be named wackowiki-${VERSION}.tar.gz but it contains ${source_kind} '${RESOLVED_REF}', not the ${VERSION} release."
        log_info "Build the tagged release with: ./build-release.sh --version=${VERSION} --source=${VERSION}"
        echo ""
    fi

    log_info "Building from source: $RESOLVED_REF ($source_kind)"
    log_info "Commit: $RESOLVED_COMMIT"

    # Determine release name and directories
    local RELEASE_NAME="wackowiki-$VERSION"
    if [ -n "$ARCHIVE_NAME" ]; then
        RELEASE_NAME="$ARCHIVE_NAME"
    fi
    local TEMP_DIR="$BUILD_DIR/tmp"
    local FINAL_DIR="$BUILD_DIR/$RELEASE_NAME"

    log_step "Preparing build directories..."
    mkdir -p "$TEMP_DIR" "$FINAL_DIR"

    echo ""
    echo "=================================================="
    echo -e "${BOLD}Building WackoWiki $VERSION${NC}"
    echo "=================================================="
    echo "Version     : $VERSION    ${YELLOW}(archive file name only)${NC}"
    echo "Source      : $RESOLVED_REF    ${YELLOW}($source_kind)${NC}"
    echo "Commit      : $RESOLVED_COMMIT"
    echo "Mode        : $([ "$MINIMAL" = true ] && echo "Minimal (src/ + vendor/)" || echo "Full (includes docs)")"
    echo "=================================================="
    echo ""

    # 1. Export clean source from Git
    log_step "Exporting source from Git..."

    # Use the resolved commit hash so the archive always matches the displayed source
    # Use --worktree-attributes to include files that match .gitignore patterns
    git archive --format=tar --worktree-attributes "$RESOLVED_COMMIT" | tar -x -C "$TEMP_DIR"
    log_success "Source exported"

    # 2. Prepare distribution structure
    log_step "Preparing distribution structure..."

    # Copy src/ to FINAL_DIR - this ensures proper structure: FINAL_DIR/src/...
    cp -a "$TEMP_DIR/src/" "$FINAL_DIR/"
    log_success "Files copied to $FINAL_DIR"

    # composer.json / composer.lock live at the repository root (not in src/).
    # Always take them from the selected --source, never from the current
    # checkout ($REPO_ROOT / HEAD).
    #
    # 1. Prefer the already exported tree ($TEMP_DIR).
    # 2. If git archive left them out (e.g. .gitattributes export-ignore),
    #    extract them straight from the Git object database at the resolved
    #    commit so the archive always matches the selected tag/branch/commit.
    #    git cat-file -e is used first so we never create an empty placeholder
    #    file for composer.lock on tags that predate it (before 6.3.0).
    for file in "composer.json" "composer.lock"; do
        if [ -f "$TEMP_DIR/$file" ]; then
            cp -a "$TEMP_DIR/$file" "$FINAL_DIR/"
            log_success "Copied $file from source ${RESOLVED_REF}"
        elif git cat-file -e "$RESOLVED_COMMIT:$file" 2>/dev/null; then
            git show "$RESOLVED_COMMIT:$file" > "$FINAL_DIR/$file"
            log_success "Extracted $file from source ${RESOLVED_REF}"
        fi
    done

    if [ "$MINIMAL" = true ]; then
        log_info "Minimal mode: src/ + vendor/ only"
    else
        log_info "Full mode: src/ + vendor/ + documentation files"

        for file in "README.md" "LICENSE" "INSTALL.md" "CHANGELOG.md"; do
            if [ -f "$TEMP_DIR/$file" ]; then
                cp "$TEMP_DIR/$file" "$FINAL_DIR/"
                log_success "Copied $file"
            fi
        done
    fi

    # ── ASSET BUILD (JS + THEME) ────────────────────────────────────────
    # Built from the EXPORTED tree ($TEMP_DIR), so the bundle and the
    # minified CSS match the released commit.
    # Runs BEFORE the Composer install to fail fast.
    log_step "Building JavaScript and theme assets..."
    build_assets "$TEMP_DIR" "$FINAL_DIR"
    # ── END ASSET BUILD ─────────────────────────────────────────────────

    # 3. Install Composer dependencies
    log_step "Installing Composer dependencies..."
    cd "$FINAL_DIR" || { log_error "Cannot enter $FINAL_DIR"; exit 1; }

    # composer.json must have been copied from the exported source above.
    # Never fall back to $REPO_ROOT (HEAD), because that installs dependencies
    # from the wrong Git revision.
    if [ ! -f "composer.json" ]; then
        log_error "composer.json not found in the exported source ($RESOLVED_REF)."
        log_error "Aborting to prevent installing wrong Composer dependencies."
        exit 1
    fi

    # Detect composer command (array => safe quoting of "php file.phar")
    local COMPOSER_CMD=()

    if command -v composer >/dev/null 2>&1; then
        COMPOSER_CMD=(composer)
    elif [ -f "$REPO_ROOT/composer.phar" ]; then
        COMPOSER_CMD=(php "$REPO_ROOT/composer.phar")
    elif [ -f "$(dirname "$0")/composer.phar" ]; then
        COMPOSER_CMD=(php "$(dirname "$0")/composer.phar")
    else
        log_warn "Composer not found."
        log_info "Install composer with: curl -sS https://getcomposer.org/installer | php"
        log_info "Or: apt install composer (Debian/Ubuntu)"
        log_info "Or: yum install composer (RHEL/CentOS)"
    fi

    local COMPOSER_PACKAGES="(Composer not available)"

    if [ "${#COMPOSER_CMD[@]}" -gt 0 ] && [ -f "composer.json" ]; then
        echo ""

        # Check for required PHP extensions
        local missing_exts=""
        for ext in "mbstring" "json" "phar"; do
            if ! php -m 2>/dev/null | grep -qi "^$ext$"; then
                missing_exts="$missing_exts $ext"
            fi
        done

        if [ -n "$missing_exts" ]; then
            log_warn "Missing PHP extensions:$missing_exts"
        fi

        # Run composer install - vendor will be created at src/vendor per composer.json config
        if "${COMPOSER_CMD[@]}" install --no-dev --optimize-autoloader --no-interaction --prefer-dist --verbose 2>&1; then
            log_success "Composer install completed"

            # Get vendor size (src/vendor as per composer.json)
            local vendor_size
            vendor_size=$(du -sh src/vendor/ 2>/dev/null | cut -f1 || echo 'N/A')
            log_info "Vendor size: $vendor_size"

            # Capture package list
            echo ""
            log_step "Capturing Composer package list..."

            COMPOSER_PACKAGES=$("${COMPOSER_CMD[@]}" show 2>/dev/null | awk '{print $1, $2}' | grep -v -i "deprecated" || echo "(List unavailable)")

            if [ -z "$COMPOSER_PACKAGES" ] || [ "$COMPOSER_PACKAGES" = "(List unavailable)" ]; then
                if [ -d "src/vendor" ]; then
                    COMPOSER_PACKAGES="(Packages installed but list unavailable)"
                else
                    COMPOSER_PACKAGES="(No packages installed)"
                fi
            fi
        else
            log_warn "Composer install had issues, continuing anyway..."
            COMPOSER_PACKAGES="(Composer install failed)"
        fi

        # Cleanup composer files in minimal mode
        if [ "$MINIMAL" = true ]; then
            rm -f composer.json composer.lock
            log_info "Minimal mode: Removed composer.json and composer.lock"
        fi

    elif [ ! -f "composer.json" ]; then
        log_error "composer.json is missing!"
        exit 1
    fi

    cd "$BUILD_DIR" || { log_error "Cannot enter $BUILD_DIR"; exit 1; }

    # 4. Create archives
    echo ""
    log_step "Creating release archives..."

    local TAR_FILE="${RELEASE_NAME}.tar.gz"
    local ZIP_FILE="${RELEASE_NAME}.zip"

    # Free space check (rough estimate: archive + extracted tree + margin)
    local avail_kb need_kb required_kb
    avail_kb=$(df -Pk "$BUILD_DIR" 2>/dev/null | tail -n 1 | awk '{print $4}' || true)
    need_kb=$(du -sk "$FINAL_DIR" 2>/dev/null | awk '{print $1}' || true)

    if [[ "$avail_kb" =~ ^[0-9]+$ ]] && [[ "$need_kb" =~ ^[0-9]+$ ]]; then
        required_kb=$(( need_kb + 20480 ))
        if [ "$avail_kb" -lt "$required_kb" ]; then
            log_warn "Low disk space in $BUILD_DIR: $((avail_kb / 1024)) MB free, ~$((required_kb / 1024)) MB needed"
            log_warn "Archive creation may fail - free some space and/or use --no-zip"
        fi
    fi

    # tar.gz is the primary artifact -> create it first, failure is fatal
    if tar -czf "$TAR_FILE" "$RELEASE_NAME"; then
        log_success "Created $TAR_FILE"
    else
        log_error "Failed to create $TAR_FILE"
        exit 1
    fi

    # zip is optional -> a failure must NOT abort the build
    if [ "$MAKE_ZIP" = true ]; then
        if command -v zip >/dev/null 2>&1; then
            if zip -r -q "$ZIP_FILE" "$RELEASE_NAME"; then
                log_success "Created $ZIP_FILE"
            else
                log_warn "zip creation failed (archive may be incomplete) - continuing"
                rm -f "$ZIP_FILE"
            fi
        else
            log_warn "zip command not found, skipping .zip creation"
        fi
    else
        log_info "Skipping .zip creation (--no-zip)"
    fi

    # 5. Final cleanup
    log_step "Cleaning up temporary files..."
    rm -rf "$TEMP_DIR"
    rm -rf "$BUILD_DIR/js-dist"
    rm -rf "$BUILD_DIR/theme-dist"
    rm -rf "$BUILD_DIR/.js-tools"
    rm -rf "$BUILD_DIR/.no-theme-src"
    rm -rf "$BUILD_DIR/.no-theme-out"
    log_success "Temporary folders removed"

    # ================== SUMMARY ==================
    echo ""
    echo "=================================================="
    echo -e "${GREEN}${BOLD}✅ Release build completed successfully!${NC}"
    echo "=================================================="
    echo ""
    echo "Version     : $VERSION    (archive file name only)"
    echo "Source      : $RESOLVED_REF    ($source_kind)"
    echo "Commit      : $RESOLVED_COMMIT"
    echo "Mode        : $([ "$MINIMAL" = true ] && echo "Minimal" || echo "Full")"
    echo ""
    if [ -n "$JS_DEST" ] && [ -d "$FINAL_DIR$JS_DEST" ]; then
        echo "JavaScript  : $JS_DEST  ($(du -sh "$FINAL_DIR$JS_DEST" 2>/dev/null | cut -f1))"
    fi
    if [ -n "$THEME_DEST" ] && [ -d "$FINAL_DIR$THEME_DEST" ]; then
        echo "Theme       : $THEME_DEST  ($(du -sh "$FINAL_DIR$THEME_DEST" 2>/dev/null | cut -f1))"
    fi
    if [ -n "$JS_MANIFEST" ] && [ -f "$JS_MANIFEST" ]; then
        echo "JS manifest : $JS_MANIFEST"
    fi
    echo ""
    echo "Composer packages:"
    echo "$COMPOSER_PACKAGES" | while read -r line; do
        echo "  $line"
    done
    echo ""
    echo "Files created:"
    if [ -f "${RELEASE_NAME}.zip" ]; then
        ls -lh "${RELEASE_NAME}.zip"
    fi
    ls -lh "${RELEASE_NAME}.tar.gz"
    echo ""
    echo "=================================================="

    if [ "$ENABLE_LOG" = true ] && [ -n "$LOG_FILE" ]; then
        echo "Log file: $LOG_FILE"

        # Final safety check: the log must not contain raw escape sequences
        local esc_lines
        esc_lines=$(LC_ALL=C grep -c "$ESC" "$LOG_FILE" 2>/dev/null || true)
        if [ "${esc_lines:-0}" -gt 0 ]; then
            log_warn "build.log still contains $esc_lines line(s) with ANSI escape sequences"
        fi
    fi

    echo ""
    log_info "Release files are in: $(pwd)/"
    echo ""

    # Flush + close the log file completely (nothing is lost)
    stop_logging
}

# Run main with all arguments
main "$@"
