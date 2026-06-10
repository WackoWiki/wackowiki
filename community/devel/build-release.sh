#!/bin/bash
# ================================================
# WackoWiki Release Builder
# ================================================
# Location: community/devel/build-release.sh
# Usage: Copy to repository root and execute
# ================================================

set -euo pipefail

# ================== CONFIG ==================
VERSION=""
SOURCE="HEAD"
BRANCH=""
MINIMAL=true
ENABLE_LOG=true
AUTO_ACCEPT=false

# Colors (detect BEFORE any output redirection)
if [ -t 1 ] && command -v tput > /dev/null 2>&1; then
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

# Global log file
LOG_FILE=""

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

write_log() {
    if [ -n "$LOG_FILE" ] && [ -f "$LOG_FILE" ]; then
        echo "$*" >> "$LOG_FILE"
    fi
}

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
        ((depth++))
    done

    return 1
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

    if ! cd "$target_dir"; then
        log_warn "Cannot change to directory '$target_dir', skipping git status check"
        return 0
    fi

    # Check if git repository
    if ! git rev-parse --git-dir > /dev/null 2>&1; then
        log_warn "Not a git repository, skipping sync check"
        return 0
    fi
    
    # Check for remote
    local remote_url
    remote_url=$(git remote get-url origin 2>/dev/null || echo "")

    if [ -z "$remote_url" ]; then
        log_warn "No remote configured, skipping sync check"
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
    write_log "Checking sync with $remote_host..."

    # Fetch latest from remote
    log_step "Fetching latest from remote..."
    if ! git fetch origin 2>&1; then
        log_warn "Failed to fetch from remote, continuing anyway..."
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
        write_log "Local HEAD: ${local_head:0:8}, Remote HEAD: ${remote_head:0:8}"
        echo ""

        if [ "$AUTO_ACCEPT" = false ]; then
            read -p "Do you want to pull the latest changes before creating the release? [y/N] " -n 1 -r
            echo ""
            if [[ $REPLY =~ ^[Yy]$ ]]; then
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
        write_log "Repository is up-to-date"
    fi

    echo ""
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
    echo "You can specify a version using:"
    echo "  • Interactive input (this prompt)"
    echo "  • Command line: ${CYAN}./build-release.sh --version=6.2.2${NC}"
    echo ""

   # Get current branch/tag info for suggestions
    local current_branch latest_tag
    current_branch=$(git symbolic-ref --short HEAD 2>/dev/null || echo "")
    latest_tag=$(git describe --tags --abbrev=0 2>/dev/null || echo "")

    if [ -n "$latest_tag" ]; then
        echo -e "Latest tag: ${GREEN}$latest_tag${NC}"
    fi

    if [ -n "$current_branch" ]; then
        echo -e "Current branch: ${YELLOW}$current_branch${NC}"
    fi
    echo ""
    
    # Special case: if on master/main and SOURCE is HEAD
    if [ "$SOURCE" = "HEAD" ] && { [ "$current_branch" = "master" ] || [ "$current_branch" = "main" ]; } && [ -z "$BRANCH" ]; then
        echo "Since you're on ${BOLD}$current_branch${NC} (HEAD), you have two options:"
        echo ""
        echo "  1) Build a MASTER snapshot (unstable, for testing)"
        echo "     → Will be named: ${CYAN}wackowiki-MASTER.tar.gz${NC}"
        echo ""
        echo "  2) Specify a version number (for stable releases)"
        echo "     → Will be named: ${CYAN}wackowiki-X.Y.Z.tar.gz${NC}"
        echo ""
        read -p "Build MASTER snapshot or enter version? [M/v]: " -n 1 -r
        echo ""

        if [[ $REPLY =~ ^[Mm]$ ]] || [ -z "$REPLY" ]; then
            VERSION="MASTER"
            log_info "Building MASTER snapshot..."
        else
            prompt_version_number
        fi
    else
        prompt_version_number
    fi
}

prompt_version_number() {
    echo ""
    read -p "Enter version number (e.g., 6.2.2): " VERSION
    VERSION=$(echo "$VERSION" | tr -d '[:space:]')

    if [ -z "$VERSION" ]; then
        log_error "Version cannot be empty"
        prompt_version_number
    fi
    
    # Validate version format (basic check)
    if ! [[ "$VERSION" =~ ^[0-9]+\.[0-9]+(\.[0-9]+)?$ ]]; then
        log_warn "Version '$VERSION' doesn't look like a standard semver (X.Y or X.Y.Z)"
        read -p "Use this version anyway? [y/N]: " -n 1 -r
        echo ""
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            prompt_version_number
        fi
    fi
}

# ================== SOURCE/BRANCH RESOLUTION ==================
resolve_source() {
    # If BRANCH specified, use that; otherwise use SOURCE
    if [ -n "$BRANCH" ]; then
        # Verify branch exists
        if ! git rev-parse --verify "$BRANCH" > /dev/null 2>&1; then
            log_error "Branch '$BRANCH' does not exist"
            log_info "Available branches:"
            git branch --format='  %(refname:short)'
            exit 1
        fi
        echo "$BRANCH"
    elif [ "$SOURCE" = "HEAD" ]; then
        # Use current HEAD
        git rev-parse HEAD
    else
        # SOURCE could be a tag or commit hash
        if git rev-parse --verify "$SOURCE" > /dev/null 2>&1; then
            echo "$SOURCE"
        else
            log_error "Source '$SOURCE' not found (not a valid tag, branch, or commit)"
            exit 1
        fi
    fi
}

# ================== PARSE ARGUMENTS ==================
parse_arguments() {
    while [[ $# -gt 0 ]]; do
        case $1 in
            --version=*)
                VERSION="${1#*=}"
                ;;
            --source=*)
                SOURCE="${1#*=}"
                ;;
            --branch=*)
                BRANCH="${1#*=}"
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

OPTIONS:
    --version=X.Y.Z    Version number for the release
                       (required unless building MASTER snapshot)

    --source=REF       Git reference to build from
                       Can be: HEAD, tag name, commit hash
                       Default: HEAD (current commit)

    --branch=NAME      Build from specific branch
                       (alternative to --source)

    --minimal          Build minimal package (src/ + vendor/)
                       This is the default

    --full             Build full package including docs
                       (src/ + vendor/ + README, LICENSE, etc.)

    --no-log           Disable logging to build.log

    -y, --yes          Auto-accept all prompts (for CI/CD)

    --help, -h         Show this help message

EXAMPLES:
    # Interactive mode (will prompt for version)
    ./build-release.sh

    # Build specific version
    ./build-release.sh --version=6.2.2

    # Build master snapshot
    ./build-release.sh --version=MASTER

    # Build from specific tag
    ./build-release.sh --source=v6.2.2

    # Build from specific branch
    ./build-release.sh --branch=6.3 --version=6.3.0

    # Build full package
    ./build-release.sh --version=6.2.2 --full

    # Non-interactive/CI mode
    ./build-release.sh --version=6.2.2 --yes

NOTES:
    - Script must be executed from repository root
    - composer.json must be present in root directory
    - Git remote should be configured (GitHub or Codeberg)
    - Script will check if local repo is up-to-date with remote

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
    found_repo=$(find_repo_root)

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

    # Check git sync status
    check_git_status "$REPO_ROOT"

    # Prompt for version if not provided
    if [ -z "$VERSION" ]; then
        prompt_version
    fi

    # Resolve actual source to build from
    local resolved_source
    resolved_source=$(resolve_source)
    log_info "Building from source: $resolved_source"

    # Determine release name
    local RELEASE_NAME="wackowiki-$VERSION"
    local BUILD_DIR="$REPO_ROOT/build"
    local TEMP_DIR="$BUILD_DIR/tmp"
    local FINAL_DIR="$BUILD_DIR/$RELEASE_NAME"
    LOG_FILE="$BUILD_DIR/build.log"

    # Create directories and setup logging
    log_step "Preparing build directories..."
    rm -rf "$BUILD_DIR"
    mkdir -p "$TEMP_DIR" "$FINAL_DIR"
    
    # Logging setup
    if [ "$ENABLE_LOG" = true ]; then
        : > "$LOG_FILE"
        log_info "Logging to: $LOG_FILE"
    fi

    write_log "=== Building WackoWiki $VERSION from $resolved_source ==="

    echo ""
    echo "=================================================="
    echo -e "${BOLD}Building WackoWiki $VERSION${NC}"
    echo "=================================================="
    echo "Source      : $resolved_source"
    echo "Mode        : $([ "$MINIMAL" = true ] && echo "Minimal (src/ + vendor/)" || echo "Full (includes docs)")"
    echo "=================================================="
    echo ""

    # 1. Export clean source from Git
    log_step "Exporting source from Git..."
    write_log "Exporting source from Git ($resolved_source)..."
    git archive --format=tar "$resolved_source" | tar -x -C "$TEMP_DIR"
    log_success "Source exported"

    # 2. Prepare distribution structure
    log_step "Preparing distribution structure..."
    
    # Handle potential subdirectory structure
    local src_dir="$TEMP_DIR/src"
    if [ ! -d "$src_dir" ]; then
        src_dir="$TEMP_DIR"
    fi

    cp -a "$src_dir/." "$FINAL_DIR/"
    log_success "Files copied to $FINAL_DIR"

    if [ "$MINIMAL" = true ]; then
        log_info "Minimal mode: src/ + vendor/ only"
    else
        log_info "Full mode: src/ + vendor/ + documentation files"

        for file in "composer.json" "composer.lock"; do
            if [ -f "$TEMP_DIR/$file" ]; then
                cp "$TEMP_DIR/$file" "$FINAL_DIR/"
                log_success "Copied $file"
            fi
        done

        for file in "README.md" "LICENSE" "INSTALL.md" "CHANGELOG.md"; do
            if [ -f "$TEMP_DIR/$file" ]; then
                cp "$TEMP_DIR/$file" "$FINAL_DIR/"
                log_success "Copied $file"
            fi
        done
    fi

    # 3. Install Composer dependencies
    log_step "Installing Composer dependencies..."
    write_log "Installing Composer dependencies..."
    cd "$FINAL_DIR" || exit 1

    if [ ! -f "composer.json" ]; then
        log_warn "composer.json not found in archive, copying from project root..."
        cp -v "$REPO_ROOT/composer.json" . 2>/dev/null || {
            log_error "Failed to find composer.json"
            exit 1
        }
        cp -v "$REPO_ROOT/composer.lock" . 2>/dev/null || true
    fi
    
    # Also copy composer.lock if it exists but not in archive
    if [ -f "composer.json" ] && [ ! -f "composer.lock" ]; then
        if [ -f "$REPO_ROOT/composer.lock" ]; then
            cp -v "$REPO_ROOT/composer.lock" . 2>/dev/null || true
        fi
    fi

    # Detect composer command
    local COMPOSER_CMD=""
    if command -v composer >/dev/null 2>&1; then
        COMPOSER_CMD="composer"
    elif [ -f "$REPO_ROOT/composer.phar" ]; then
        COMPOSER_CMD="php $REPO_ROOT/composer.phar"
    elif [ -f "$(dirname "$0")/composer.phar" ]; then
        COMPOSER_CMD="php $(dirname "$0")/composer.phar"
    else
        log_warn "Composer not found."
        log_info "Install composer with: curl -sS https://getcomposer.org/installer | php"
        log_info "Or: apt install composer (Debian/Ubuntu)"
        log_info "Or: yum install composer (RHEL/CentOS)"
    fi

    local COMPOSER_PACKAGES="(Composer not available)"

    if [ -n "$COMPOSER_CMD" ] && [ -f "composer.json" ]; then
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
            log_info "You may need to install them for composer to work properly"
        fi

        if $COMPOSER_CMD install --no-dev --optimize-autoloader --no-interaction --prefer-dist --verbose 2>&1; then
            log_success "Composer install completed"
            
            # Get vendor size
            local vendor_size
            vendor_size=$(du -sh src/vendor/ 2>/dev/null | cut -f1 || echo 'N/A')
            log_info "Vendor size: $vendor_size"
            
            # Capture package list
            echo ""
            log_step "Capturing Composer package list..."

            COMPOSER_PACKAGES=$($COMPOSER_CMD show 2>/dev/null | awk '{print $1, $2}' | grep -v -i "deprecated" || echo "(List unavailable)")

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

    cd "$BUILD_DIR" || exit 1

    # 4. Create archives
    echo ""
    log_step "Creating release archives..."
    write_log "Creating release archives..."

    # Create zip
    if command -v zip >/dev/null 2>&1; then
        zip -r "${RELEASE_NAME}.zip" "$RELEASE_NAME"
        log_success "Created ${RELEASE_NAME}.zip"
    else
        log_warn "zip command not found, skipping .zip creation"
    fi
    
    # Create tar.gz
    tar -czf "${RELEASE_NAME}.tar.gz" "$RELEASE_NAME"
    log_success "Created ${RELEASE_NAME}.tar.gz"

    # 5. Final cleanup
    log_step "Cleaning up temporary files..."
    rm -rf "$TEMP_DIR"
    log_success "Temporary folder removed"

    # ================== SUMMARY ==================
    echo ""
    echo "=================================================="
    echo -e "${GREEN}${BOLD}✅ Release build completed successfully!${NC}"
    echo "=================================================="
    echo ""
    echo "Version : $VERSION"
    echo "Source  : $resolved_source"
    echo "Mode    : $([ "$MINIMAL" = true ] && echo "Minimal" || echo "Full")"
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

    if [ "$ENABLE_LOG" = true ]; then
        echo "Log file: $LOG_FILE"
    fi

    echo ""
    log_info "Release files are in: $(pwd)/"
    echo ""
}

# Run main with all arguments
main "$@"
