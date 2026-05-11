# YAUR: Yet Another URI Router - Technical Documentation

## Table of Contents
1. [Overview](#overview)
2. [Architecture](#architecture)
3. [Core Concepts](#core-concepts)
4. [Routing Configuration](#routing-configuration)
5. [Syntax Reference](#syntax-reference)
6. [Variable System](#variable-system)
7. [Action Operators](#action-operators)
8. [Patterns and Matching](#patterns-and-matching)
9. [Control Flow](#control-flow)
10. [Practical Examples](#practical-examples)
11. [Advanced Techniques](#advanced-techniques)

---

## Overview

**YAUR** (Yet Another URI Router) is a lightweight, rule-based URI routing engine designed for the WackoWiki platform. It processes incoming HTTP requests and dispatches them to appropriate handlers by matching URI patterns against a sequence of rules defined in a configuration file.

### Key Characteristics

- **Rule-based processing**: Sequential evaluation of regex patterns against incoming URIs
- **Flexible variable system**: Supports URL parameters, HTTP globals, and local variables
- **Pattern matching and substitution**: Extract parts of URIs and assign them to variables
- **Caching support**: Configuration is cached for performance optimization
- **Control flow**: Support for conditional routing with explicit success/failure markers

### Design Philosophy

The router operates on a simple principle: iterate through rules sequentially until one matches, execute all associated actions, and if successful, determine the next step (continue, jump, or terminate).

---

## Architecture

### Request Processing Pipeline

```
HTTP Request
    ↓
1. Extract URI and HTTP metadata (_uri, _method, _rewrite, _tls)
    ↓
2. Initialize routing environment with variables
    ↓
3. Iterate through config rules sequentially
    ↓
4. For each rule:
   a) Match regex against current _uri
   b) If match: populate variables from match groups
   c) Execute actions sequentially
   d) If action succeeds: continue to next action
   e) If action fails: discard all changes, try next rule
   f) If _ok! executed: terminate routing successfully
   g) If _next! executed: skip to next regex rule
    ↓
5. Backpatch successful changes into HTTP superglobals
    ↓
6. Return routing result with extracted parameters
```

### Component Stack

1. **Configuration Parser** (`read_config()`): Processes router.conf file
   - Expands macros
   - Validates regex patterns
   - Compiles action specifications

2. **Routing Engine** (`route()`): Main routing loop
   - Pattern matching
   - Variable substitution
   - Action execution
   - Backtracking on failure

3. **Variable System** (`parse_var()`): Manages variable namespace
   - Regex match groups ($0-$9)
   - Sub-match groups ($a-$j)
   - HTTP superglobals (G*/P*/S*)
   - Local variables

---

## Core Concepts

### Rules

A rule is a complete routing definition consisting of a regex pattern and zero or more actions:

```
regex [action1] [action2] [actionN]
```

**Characteristics:**
- Rules are processed in order
- A regex pattern must match for actions to execute
- If any action fails, all changes from that line are discarded
- Continuation lines (starting with whitespace) share the same regex

### Matches and Sub-matches

When a regex pattern matches:
- **Main match groups** ($0-$9): Captured by the main regex
  - $0: Complete match
  - $1-$9: Capture groups from (...)

- **Sub-match groups** ($a-$j): Captured by pattern-matching actions (~)
  - Used only when a pattern matching operator succeeds

### Variables

Three variable scopes exist:

1. **Regex matches**: `$0`, `$1`, ..., `$9`
2. **Sub-matches**: `$a`, `$b`, ..., `$j`
3. **Named variables**:
   - `Gvar`: $_GET['var']
   - `Pvar`: $_POST['var']
   - `Svar`: $_SERVER['var']
   - `var`: Local variable in router namespace

---

## Routing Configuration

### File Structure

The `router.conf` file contains:

1. **Comments**: Lines starting with `//` or `#` are ignored
2. **Macro definitions**: `define {name} pattern`
3. **Rules**: `regex [actions...]`
4. **Continuation lines**: Lines starting with whitespace (common regex)

### Macro System

Macros are text substitutions that expand during configuration parsing.

#### Defining Macros

```
define {name} replacement_pattern
```

**Examples:**
```
define {hashid}    [0-9a-zA-Z]+
define {i}         [0-9]+
define {h}         [0-9a-fA-F]+
define {a}         [0-9a-zA-Z]+
define {w}         [\w]+
define {}          [^/]*
define {*}         .*?
define {**}        .*
```

#### Using Macros

**Basic substitution:**
```
`^{i}/about$`
```
Expands to: `^([0-9]+)/about$`

**Named capture group:**
```
`^{page_id=i}/$`
```
Expands to: `^(?P<page_id>[0-9]+)/$`

**For variable assignment (inline naming):**
```
`^{i=hashid}/show$`
```
This creates a capture group that can be accessed as `$1~hashid:N` for validation.

#### Predefined Macros

The `{method}` macro is automatically populated by the router with all available handler methods (discovered from handler directory):

```
define {method} show|edit|delete|admin|install|...
```

### Regex Pattern Syntax

YAUR uses PHP PCRE regex syntax:

- **Delimiters**: Backticks or other paired delimiters required
- **Modifiers**: Added after closing delimiter (e.g., `/pattern/i` for case-insensitive)
- **Match groups**: `()` creates numbered captures, `(?P<name>...)` creates named captures
- **Special sequences**: Standard PCRE syntax applies

#### Empty Regex in Continuation Lines

A continuation line (starting with whitespace) may have an empty regex, meaning:
- Use the same regex pattern as the previous line
- Execute actions only if the regex already matched

```
`^user/(\d+)$`
    action1 action2
    action3 action4        # uses same regex as line above
```

---

## Syntax Reference

### Configuration Line Format

```
regex action1 action2 action3
```

- **Regex**: PCRE pattern in delimiters (required for first line of rule)
- **Actions**: Whitespace-separated specifications
- **Comments**: Start with // or # (removed during parsing)

### Action Format

```
VARIABLE[:FUNCTION] OPERATOR VALUE
```

**Components:**
- `VARIABLE`: Target variable (see Variable System section)
- `[:FUNCTION]`: Optional transformation (tolower, toupper, int)
- `OPERATOR`: One of =, !=, ==, ~, !~, ?, -, ?=, <, >, <=, >=, !
- `VALUE`: Value to assign or compare (supports variable expansion)

---

## Variable System

### Variable Naming

#### Special Prefixes (HTTP Superglobals)

| Prefix | Source | Example | Access |
|--------|--------|---------|--------|
| G | $_GET | Gpage | $_GET['page'] |
| P | $_POST | Paction | $_POST['action'] |
| S | $_SERVER | SREQUEST_METHOD | $_SERVER['REQUEST_METHOD'] |

#### Regex Match Groups

| Notation | Type | Source | Scope |
|----------|------|--------|-------|
| $0 | Complete match | Main regex | Current action line |
| $1-$9 | Capture groups | Main regex | Current action line |
| $a-$j | Sub-matches | Pattern matching (~) | From that ~action onward |

#### Local Variables

Simple identifiers (no prefix, no $) are stored in the router's local namespace:

```
method=show         # stores in local 'method' variable
```

### Predefined Variables

The router automatically initializes:

| Variable | Type | Value | Example |
|----------|------|-------|---------|
| _uri | string | Request URI (without query string) | /admin/page |
| _method | string | HTTP method | GET, POST, PUT |
| _rewrite | boolean | 1 if mod_rewrite active, 0 otherwise | 1 or 0 |
| _tls | boolean | 1 for HTTPS, 0 for HTTP | 1 or 0 |
| _ip | string | Client IP address | 192.168.1.1 |
| _line | integer | Current config line number | 42 |
| _ok | boolean | Set to terminate routing successfully | (internal) |
| _next | boolean | Set to skip to next regex | (internal) |

### Variable Expansion

Variables can be expanded in action values using several formats:

#### Basic Expansion

```
Gpage=${page}       # expands local variable 'page'
method=$1           # expands first capture group
```

#### Safe Expansion (Suppress Errors)

Use `@` prefix to suppress undefined variable errors:

```
template=@${theme}  # returns empty string if theme undefined
```

#### Special Escaping

| Sequence | Expands To | Purpose |
|----------|-----------|---------|
| $$ | $ | Literal dollar sign |
| $@ | @ | Literal @ sign |
| @$var | Empty or "" | Undefined variable (no error) |

#### Invalid Expansions

Using an undefined variable without `@` causes the action to fail:

```
var=${undefined}    # Action fails if 'undefined' not set
Gres=${nonexist}    # Fails, assignment not executed
```

---

## Action Operators

### Assignment Operators

#### Simple Assignment (`=`)

Assigns value to variable, discarding any previous value.

```
method=$1                           # Assign capture group
Gpage=about                         # Assign literal string
template:tolower=${Gtemplate}      # Assign with function
```

**Functions:**
- `tolower`: Convert to lowercase
- `toupper`: Convert to uppercase
- `int`: Convert to integer

#### Conditional Assignment (`?=`)

Assigns value only if variable is not already set.

```
method?=show        # Only sets method if not already set
```

#### Force Assignment (`!`)

Sets variable to 1 (used as boolean flag).

```
unlock!             # Sets unlock=1
session!            # Sets session=1
```

#### Unset (`-`)

Removes variable from its scope (e.g., removes from $_GET).

```
Gpage-              # Removes $_GET['page']
method-             # Removes local method variable
```

### Comparison Operators

All comparisons fail if the variable is undefined (no `@` masking available).

#### Equality (`==`)

Loose equality comparison.

```
method==show
_method==GET
Gid==0
```

#### Inequality (`!=`)

Loose inequality comparison.

```
_method!=POST
method!=admin
```

#### Less Than (`<`), Greater Than (`>`)

Numeric or string comparison (depends on operand types).

```
year:int<2020
role:int>5
name>admin         # String comparison
```

#### Less Than or Equal (`<=`), Greater Than or Equal (`>=`)

```
age:int<=18
priority:int>=3
```

**Function Modifier:**
- `int`: Converts both operands to integers before comparison

#### Isset (`?`)

Checks if variable is set (no value needed).

```
Gpage?              # Pass if $_GET['page'] exists
method?             # Pass if local method exists
$1?                 # Pass if first capture group exists
```

### Pattern Matching

#### Regex Match (`~`)

Matches variable value against a PCRE regex pattern.

```
var~/pattern/i                      # Match with flags
var!~/^admin/                       # Negative match (must NOT match)
```

**Match Groups:**
- Successful `~` operation populates $a-$j with sub-match groups
- $a = complete match (or first group if group exists)
- $b-$j = subsequent capture groups

**Example:**
```
method~/^(show|edit|delete)$/ _next!
# If method matches one of those, $a contains matched value
```

#### Hashid Match (`~hashid:N`)

Validates a hashid (encoded numeric IDs) with checksum verification.

```
$1~hashid:2        # Validate $1 as hashid with 2 numeric IDs
Gone=$a             # $a gets first numeric ID after validation
Gtwo=$b             # $b gets second numeric ID
```

**Hashid Validation:**
- Decodes the hashid string (removes non-alphanumeric characters)
- Checks that exactly N numeric values are encoded
- Verifies checksum using SHA1 hash
- Sets sub-match variables ($a-$j) with decoded values

---

## Patterns and Matching

### Regex Matching Process

1. **Pattern validation**: Regex is validated during config parsing
2. **Macro expansion**: All {macro} references expanded to capture groups
3. **Pattern compilation**: PHP PCRE regex compiled with delimiters and flags
4. **URI matching**: `preg_match()` executed against current _uri value
5. **Group extraction**: Matched groups stored in $0-$9 and accessible as variables

### Match Group Assignment

When a regex matches, captured groups are automatically available:

```
`^admin/(\w+)/(\d+)$`
    Gaction=$1                      # First capture group
    Gid=$2                          # Second capture group
```

### The Match Context

- Only the first **matching rule line** executes its actions
- Actions have access to that rule's match groups
- Match groups persist across multiple action lines (continuations)
- After any action fails, backtrack to previous state and try next rule

---

## Control Flow

### Successful Routing

A route terminates successfully when `_ok!` is executed as an action in a rule where all previous actions also succeeded.

```
`^page/(\d+)$`
    Gpage_id=$1
    method=show
    _ok!                            # Route succeeds
```

### Conditional Routing (`_ok!`)

The `_ok!` action terminates routing immediately with success. All previous actions in the line must have succeeded.

```
`^static/(.+)$`
    route=static
    age=30
    _ok!                            # No further rules processed
```

### Jumping to Next Rule (`_next!`)

The `_next!` action skips all remaining continuation lines for the current regex and jumps to the next regex rule.

```
`^{hashid}(/.*)?$`
    $1~hashid:2 page=$a method=hashid _ok!
    // If hashid validation fails, jump to next rule
    _next!                          # Skip remaining lines for this regex
    // Following lines not executed if _next! above is reached
```

### Fallthrough and 404

If no rule matches or if all rules have `_ok!` action fail:

```
// Return 404 (routing failed)
$vars['_ok'] = false;
```

### Rule Sequence

```
Rule 1 regex
    Rule 1 action A
    Rule 1 action B
    
Rule 1 regex (continuation, same regex)
    Rule 1 action C
    
Rule 2 regex
    Rule 2 action A
```

**Execution flow:**
1. Try Rule 1 regex against _uri
2. If matches: execute actions A, B, C sequentially
3. If any action fails: revert changes, try Rule 2
4. If `_ok!` executed: stop routing
5. If `_next!` executed: skip remaining actions, try Rule 2

---

## Practical Examples

### Example 1: Static File Routes

```
`^robots\.txt$`                                     _ok!
`^(theme/{}/css|theme/_common)/{}$`                _ok!            // css
`^js/(lang/|photoswipe/)?{}$`                      _ok!            // js
```

**How it works:**
- Match static files (robots.txt, CSS, JavaScript)
- If matched, mark as handled (`_ok!`) and stop routing
- Router will serve these files without further processing

### Example 2: Dynamic Page with Hashid

```
`^{hashid=a}(/.*)?$`
    $1~hashid:2 page=$a method=hashid _ok!
    _next!
    
    // If hashid validation fails, continue with standard page routing
    $1~hashid:2 Gpage_id=$a Gversion_id=$b page= method=show redirect=301 _ok!
```

**Flow:**
1. Capture hashid into $1
2. Validate as 2-part hashid
3. If valid: extract IDs, set method to hashid handler, succeed
4. If invalid: `_next!` jumps to next rule
5. Next rule tries standard page routing

### Example 3: Method-based Routing

```
`^(|{page=**}/){method}(/.*?)?$`ii
    method:tolower=$3                           # Convert method to lowercase
    method==file session=2                      # Special session handling for files
    _ok!
```

**Pattern breakdown:**
- `^(|{page=**}/)`: Optional page prefix (empty or page path with /)
- `{method}`: Method name (expanded to show|edit|delete|...)
- `(/.*?)?$`: Optional trailing path
- `i` flags: Case-insensitive matching
- Actions: Convert method to lowercase, set session level for file method

### Example 4: Request URI Initialization

```
`^`
    SPATH_INFO!= _uri=${SPATH_INFO} _next!      // if PATH_INFO available - use it
    _rewrite==0 _uri=@${Gpage} Gpage-          // when rewrite mode is off - replace _uri by page _GET variable

`^/*{_uri=*}/*$`    // trim _uri of beginning & trailing slashes
```

**Purpose:**
- Initialize _uri from multiple sources (PATH_INFO or GET parameter)
- Handle both mod_rewrite and non-rewrite modes
- Normalize URI by trimming slashes

### Example 5: Variable Extraction and Transformation

```
`^admin/(\w+)/(\d+)$`
    Gaction:tolower=$1              # Convert action to lowercase
    Gid:int=$2                      # Convert ID to integer
    unlock!                         # Set unlock flag
    route=admin
    _ok!
```

**Variable transformations:**
- `tolower`: Convert extracted action to lowercase
- `int`: Convert ID string to integer for database queries
- `!`: Set boolean flag for authorization

---

## Advanced Techniques

### Conditional Execution Chains

Execute actions conditionally based on request properties:

```
`^data/(\w+)$`
    _method==GET route=show_data _ok!           # GET requests
    _method==POST route=save_data _ok!          # POST requests
    _method==DELETE route=delete_data _ok!      # DELETE requests
    // If method is none of above, routing fails (404)
```

### Sub-Match Extraction

Use pattern matching to extract parts of variables:

```
`^(\w+):(\w+):(\w+)$`
    $1~/(show|edit)/i next!
    // If $1 matches (show or edit), $a contains matched portion
    action=$a
    resource=$2
    id=$3
    _ok!
```

### Safe Variable Fallback

Use `@` masking to provide defaults:

```
template=@${Gtemplate:default.html}
// If Gtemplate undefined, template becomes ":default.html" (contains literal text)
// Better approach:
template:tolower=@${Gtemplate}
// If undefined, template stays empty, allowing defaults elsewhere
```

### Hashid Multiple Parts

Extract multiple encoded IDs from a single hashid:

```
`^docs/({hashid=id})/versions/(\d+)$`
    $id~hashid:3 page=$a section=$b version_id=$c _ok!
    // Hashid contains 3 IDs: page, section, version_id
```

**Result after successful match:**
- `$a` = first numeric ID
- `$b` = second numeric ID
- `$c` = third numeric ID

### Combined Conditions

Chain multiple comparisons to enforce complex rules:

```
`^admin/(.+)$`
    _method!=GET next!              // Must be GET
    Glevel:int>5 next!              // User level > 5
    _tls==1 next!                   // Must use HTTPS
    Gaction=$1
    route=admin
    _ok!
```

If any condition fails, `_next!` continues to next rule.

### Progressive URI Rewriting

Modify _uri and re-match it:

```
`^index\.php$`
    _uri=                           // Clear _uri to re-match from top

`^index\.(php|html)$`
    _uri=                           // Both rewritten to empty

// First rule: detect index.php
// Second rule: matches both index.php and index.html, clears URI
// Since _uri is now empty, matches the initial `^` rule again
```

### Macro Composition

Build complex patterns from simpler macros:

```
define {hashid}     [0-9a-zA-Z]+
define {i}          [0-9]+
define {page}       {hashid}(x{i})?

`^docs/{page=id}$`
    page_id=$1
    version_id=$2                   // May be empty if no version
    method=show
    _ok!
```

---

## Integration with WackoWiki

### Handler Discovery

The router automatically discovers available handlers:

```php
foreach (Ut::file_glob(HANDLER_DIR, '*/[!_]*.php') as $method)
{
    $methods[] = pathinfo($method, PATHINFO_FILENAME);
}

define {method} show|edit|delete|admin|install|...
```

**Available handlers** become routing options:

```
`^{page=**}/{method}$`
    method:tolower=$2
    _ok!
```

### Static Asset Serving

Routes for CSS, JavaScript, and images skip the main handler:

```
`^theme/{}/css/{}$`         _ok!
`^image/(wikiedit/)?{}$`    _ok!
`^js/(lang/)?{}$`           _ok!
```

**Optimization**: `_ok!` prevents further processing, serving assets directly.

### API/Feed Support

Special handling for XML feeds:

```
`^xml/opensearch\.xml$`     _ok!
`^xml/{}$`                  age=0        // feeds (no cache)
    route=feed
    _ok!
```

### Installation Mode

Separate routing during setup:

```
`^setup/(image|css)/{}$`    _ok! unlock=1
```

Sets `unlock=1` to bypass normal authorization during installation.

---

## Best Practices

### 1. Order Matters
Place more specific rules before general ones:

```
`^admin/special$`           _ok!        // Specific case first
`^admin/(.+)$`              _ok!        // General case second
`^(.+)$`                    _ok!        // Catchall last
```

### 2. Use Named Macros for Clarity

```
// Good
`^docs/{id=hashid}/show$`

// Less clear
`^docs/{hashid}/show$`
```

### 3. Validate Before Assigning

```
// Good - validate before use
$1~hashid:2 page=$a _ok!

// Risky - unvalidated use
page=$1 _ok!
```

### 4. Document Complex Rules

```
// Extract page ID and version from hashid format
// then route to version-specific handler
`^{page=hashid}(/.*)?$`
    $1~hashid:2 page_id=$a version_id=$b _ok!
```

### 5. Use Safe Expansion for Optional Values

```
// Good - won't fail if undefined
theme:tolower=@${Gtheme}

// Risky - fails if not set
theme=$Gtheme
```

### 6. Separate Concerns

```
// First: normalize and validate
`^`
    SPATH_INFO!= _uri=${SPATH_INFO} _next!

// Then: route based on URI
`^page/(\d+)$`
    Gpage=$1 _ok!
```

---

## Troubleshooting

### Rule Not Matching
1. Check regex syntax: Use online PCRE tester
2. Verify _uri value: Add `dbg=_uri` action
3. Check macro expansion: Ensure {macro} is defined
4. Verify flags: Ensure regex is case-sensitive when needed

### Action Failing Silently
1. Check undefined variables: Add @ prefix for safe expansion
2. Verify operator: Ensure correct operator for comparison type
3. Check function names: tolower, toupper, int are only built-in functions
4. Verify variable names: G/P/S prefixes for superglobals

### Changes Not Applied
- Remember: If any action in a line fails, ALL changes from that line are discarded
- Split complex rules into multiple lines
- Use `_next!` to skip and try alternative rules

### Configuration Caching Issues
- Router caches compiled config to `/src/_cache/router.conf`
- If changes not reflected, clear cache file or set incorrect permissions
- Cache includes CODE_VERSION to auto-invalidate on code changes

---

## References

- PHP PCRE Regex Syntax: https://www.php.net/manual/en/reference.pcre.pattern.syntax.php
- WackoWiki URI Router: https://wackowiki.org/doc/Dev/Projects/UriRouter
- Source Code: `/src/class/urirouter.php`
- Configuration: `/src/config/router.conf`

