# Session Management Technical Documentation

## Overview

The `Session` class is an abstract session management system for WackoWiki that extends `ArrayObject` to provide secure, configurable session handling. It implements sophisticated security features including session ID regeneration, anti-replay protection, nonce verification, and user agent/IP validation.

**Location:** `src/class/session.php`  
**Type:** Abstract class (must be extended with a `SessionStoreInterface` implementation)  
**Inheritance:** `ArrayObject`

---

## Table of Contents

1. [Core Concepts](#core-concepts)
2. [Architecture](#architecture)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [Security Features](#security-features)
6. [API Reference](#api-reference)
7. [Session Lifecycle](#session-lifecycle)
8. [Flash Data](#flash-data)
9. [Nonce System](#nonce-system)
10. [Cookie Management](#cookie-management)
11. [Error Handling](#error-handling)
12. [Implementation Guide](#implementation-guide)

---

## Core Concepts

### Session State
The Session class maintains three primary states:

- **Inactive** (`$active = false`): Session not yet started or has been closed
- **Active** (`$active = true`): Session is running and can store/retrieve data
- **Regenerated**: Session ID has been replaced (tracked via `$regenerated` flag)

### Session Data Storage
Session data is stored as an array accessible through `ArrayObject` interface:
```php
$session['user_id'] = 123;  // Set data
echo $session['user_id'];   // Get data
```

### Sticky Data
Variables prefixed with `sticky_` are persistent across session resets:
- `sticky__created`: Session creation timestamp
- `sticky__flash`: Flash data lifetime tracking
- `sticky__log`: Regeneration event log
- `sticky__ip`: IP change tracking

### Internal Tracking Variables
Variables prefixed with `__` are internal session metadata:
- `__started`: Session start time
- `__updated`: Last session update time
- `__regenerated`: Last session ID regeneration time
- `__user_agent`: Client user agent string
- `__user_ip`: Client IP address
- `__user_tls`: TLS/SSL status
- `__nonces`: Active nonce storage
- `__expire`: Session expiration time (for old sessions)

---

## Architecture

### Class Hierarchy
```
ArrayObject (PHP native)
    ↓
Session (abstract)
    ↓
[Concrete Implementation] (must implement store_* methods)
```

### Key Methods Categories

**Lifecycle Management:**
- `__construct()`: Initialize session object
- `start()`: Begin a session
- `write_close()`: Save and close session
- `restart()`: Destroy and restart session
- `terminator()`: Shutdown handler (garbage collection, flash data cleanup)

**Security:**
- `regenerate_id()`: Replace session ID
- `verify_nonce()`: Validate nonce tokens
- `prevent_replay()`: Anti-replay protection
- `create_nonce()`: Generate nonce tokens

**Storage (Abstract - Must Implement):**
- `store_open()`: Open session storage
- `store_read()`: Read session data
- `store_write()`: Write session data
- `store_close()`: Close session storage
- `store_gc()`: Garbage collection
- `store_validate_id()`: Validate session ID format
- `store_generate_id()`: Generate new session ID

**Cookie Management:**
- `setcookie()`: Set HTTP cookie with security headers
- `get_cookie()`: Retrieve cookie value
- `set_cookie()`: Set cookie (legacy interface)
- `delete_cookie()`: Remove cookie
- `send_cookie()`: Internal cookie transmission

---

## Configuration

### Configuration Properties (Public)

All configuration properties are prefixed with `cf_` (config) and can be set before calling `start()`:

#### Session Behavior
```php
$session->cf_static = 0;                    // Disable regenerations (e.g., for CAPTCHA)
$session->cf_max_session = 7200;            // Max session lifetime (seconds)
$session->cf_max_idle = 1440;               // Max idle time before destruction (seconds)
$session->cf_regen_time = 500;              // Seconds between forced ID regenerations
$session->cf_regen_probability = 2;         // Percentage probability of forced regen (0-100)
```

#### Nonce & Replay Protection
```php
$session->cf_secret = 'adyaiD9+255JeiskPybgisby';  // Secret for nonce generation
$session->cf_nonce_lifetime = 7200;                 // Nonce expiration (seconds)
$session->cf_prevent_replay = 1;                    // Enable replay attack prevention
```

#### Garbage Collection
```php
$session->cf_gc_probability = 2;           // Probability of GC on shutdown (0-100)
$session->cf_gc_maxlifetime = 1440;        // Max session file lifetime (seconds)
```

#### Cookie Settings
```php
$session->cf_cookie_prefix = '';                   // Prefix for all cookies
$session->cf_cookie_persistent = false;            // Make cookies persistent
$session->cf_cookie_lifetime = 0;                  // Cookie lifetime (0 = session cookie)
$session->cf_cookie_path = '/';                    // Cookie path
$session->cf_cookie_domain = '';                   // Cookie domain ('' = current host)
$session->cf_cookie_secure = false;                // HTTPS only
$session->cf_cookie_httponly = true;               // Disable JavaScript access
$session->cf_cookie_samesite = COOKIE_SAMESITE;   // SameSite attribute
```

#### Cache Control
```php
$session->cf_cache_limiter = 'none';       // Cache control mode (public|private|nocache|none)
$session->cf_cache_expire = 180*60;        // Cache TTL (seconds)
$session->cf_cache_mtime = 0;              // Modify time for Last-Modified header
```

#### Security Validation
```php
$session->cf_referer_check = '';           // Check HTTP Referer header
```

#### HTTP Context (Set by HTTP class)
```php
$session->cf_ip;                           // Client IP address
$session->cf_tls;                          // TLS/SSL connection indicator
```

---

## Usage

### Basic Session Setup

```php
// Create a concrete session implementation
class MySession extends Session {
    // Implement abstract store_* methods
    // See "Implementation Guide" section
}

// Initialize and start session
$session = new MySession();
$session->cf_max_session = 3600;  // 1 hour
$session->cf_cookie_path = '/';
$session->start('myapp');          // Session name: 'myapp'

// Store data
$session['user_id'] = 42;
$session['username'] = 'john';

// Retrieve data
echo $session['user_id'];  // 42

// Check if session is active
if ($session->active()) {
    echo "Session is active";
}

// Explicitly save and close
$session->write_close();

// Shutdown handler automatically called via register_shutdown_function()
```

### Session Data Access

```php
// Array-like access (via ArrayObject)
$session['user_id'] = 123;
echo $session['user_id'];
unset($session['user_id']);
isset($session['user_id']);

// Convert to array
$all_data = $session->toArray();
```

### Session ID Management

```php
// Get current session ID
$id = $session->id();          // Returns: e.g., "abc123xyz..."

// Get session name
$name = $session->name();       // Returns: 'myapp'

// Get session ID from request
$session->start('myapp', $_REQUEST['sid'] ?? null);
```

### Session State

```php
// Check if session is active
if ($session->active()) {
    // Session is running
}

// Get last state change message
$message = $session->message();  // 'replay', 'ip', 'ua', 'timeout', etc.

// Restart session (destroy old + start new)
$session->restart();
```

---

## Security Features

### 1. Session ID Regeneration

**Purpose:** Prevent session fixation attacks

**Automatic Triggers:**
- Initial session creation (`regenerated = 2`)
- First request after creation (`regenerated = 1`)
- Periodic forced regeneration (based on `cf_regen_time` and `cf_regen_probability`)
- Session validation failures

**Manual Trigger:**
```php
$session->regenerate_id($delete_old = false, $message = 'custom_reason');
```

**Parameters:**
- `$delete_old`: 
  - `false` (0): Keep old session active for ~5 seconds (for pending AJAX requests)
  - `true` (1): Keep old session for time specified (unused in current code)
  - `2`: Immediately destroy old session

**Implementation Details:**
- New session ID is generated via `store_generate_id()`
- Old session data is copied to new ID
- Old session marked with `__expire` timestamp
- Cookie immediately updated with new ID
- Single regeneration per request (checked via `$this->regenerated` flag)
- Logged in `sticky__log` for debugging (max 15 entries)

```php
// Example: Force regeneration on login
$session->start('myapp');
if ($user_authenticated) {
    $session->regenerate_id(false, 'login');
    $session['user_id'] = $user->id;
}
```

### 2. User Agent Validation

**Purpose:** Detect browser/device changes that might indicate hijacking

**Behavior:**
- Stores user agent on first request
- Compares on subsequent requests using `similar_text()`
- Destroys session if similarity < 95%
- Useful against bot attacks or stolen sessions

**Configuration:**
```php
// Automatic on each request (if enabled in code logic)
// Triggers session destruction if UA changes significantly
```

### 3. IP Address Validation

**Purpose:** Detect IP spoofing or hijacking

**Behavior:**
- Stores IP on first request
- Compares on subsequent requests
- Soft failure on mismatch: `destroy = 1` (keeps regenerating)
- Tracks IP changes in `sticky__ip`

**Configuration:**
```php
$session->cf_ip = $_SERVER['REMOTE_ADDR'];  // Set by HTTP class
// Validation happens automatically during start()
```

**IP Change Tracking:**
```php
// Access IP change history
$ip_history = $session->sticky__ip;  // Array of [ip => change_count]
```

### 4. TLS/SSL Validation

**Purpose:** Prevent protocol downgrade attacks

**Behavior:**
- Checks if connection transitioned from HTTPS to HTTP
- Destroys session on mismatch

**Configuration:**
```php
$session->cf_tls = !empty($_SERVER['HTTPS']);  // Set by HTTP class
// Validation happens automatically during start()
```

### 5. Anti-Replay Protection

**Purpose:** Prevent CSRF and replay attacks

**Mechanism:**
- Generates unique "NoReplay" nonce on each request
- Cookie-based nonce verification
- Detects rapid-fire requests (AJAX attacks)

**Configuration:**
```php
$session->cf_prevent_replay = 1;       // Enable (default)
$session->cf_prevent_replay = 0;       // Disable if needed
```

**How It Works:**
```
Request 1: Generate nonce, send in cookie
Request 2: Client sends nonce back, verify & generate new one
Request 3: If old nonce used again → reject (replay detected)
```

### 6. Referer Validation (Optional)

**Purpose:** Prevent CSRF via header checking

**Configuration:**
```php
$session->cf_referer_check = 'example.com';
// Session rejected if HTTP_REFERER doesn't contain this string
```

---

## API Reference

### Public Methods

#### Lifecycle Management

##### `start($name = null, $id = null): bool`
Start or resume a session.

**Parameters:**
- `$name` (string|null): Session name (cookie name base). Alphanumeric + underscore/dash. Defaults to 'sesid'
- `$id` (string|null): Existing session ID to resume. If null, attempts to read from cookie

**Returns:** `true` if session started successfully, `false` on error

**Side Effects:**
- Sets headers (cookies, cache control)
- Populates session data from storage
- Performs security validations
- May trigger session ID regeneration

**Example:**
```php
if ($session->start('webapp', $_COOKIE['sess_id'] ?? null)) {
    // Session ready
} else {
    // Session failed
}
```

**Validation Steps:**
1. Reject if headers already sent
2. Validate session name format
3. Retrieve ID from parameter or cookie
4. Check Referer header (if configured)
5. Validate ID format via `store_validate_id()`
6. Read session data from storage
7. Verify nonces and timestamps
8. Check user agent, IP, TLS
9. Regenerate if needed

---

##### `write_close(): void`
Save session data and close session.

**Side Effects:**
- Calls `write_session()` to serialize and store data
- Calls `store_close()` to close storage handler
- Sets `$active = false`

**Example:**
```php
$session['key'] = 'value';
$session->write_close();  // Ensure data is saved
```

---

##### `restart(): bool`
Destroy current session and create new one.

**Equivalent to:** `regenerate_id(true) + clean_vars() + populate()`

**Returns:** `true` on success, `false` on error

**Use Cases:**
- User logout and new login
- Security reset
- Complete session refresh

**Example:**
```php
$session->restart();
// New session created, old data cleared, sticky_ vars preserved
```

---

#### Session Access

##### `id(): mixed`
Get current session ID.

**Returns:** Session ID string or null if not started

```php
$sid = $session->id();  // "abc123xyz..."
```

---

##### `name(): string`
Get session name (cookie prefix).

**Returns:** Session name

```php
$name = $session->name();  // "myapp"
```

---

##### `active(): bool`
Check if session is currently active.

**Returns:** `true` if session is started and active, `false` otherwise

```php
if ($session->active()) {
    $session['key'] = 'value';
}
```

---

##### `message(): string|null`
Get reason for last session state change.

**Returns:** Message string or null

**Possible Values:**
- `'replay'`: Replay attack detected
- `'obsolete'`: Session marked for expiration
- `'reg_expire'`: Regeneration expiration reached
- `'max_session'`: Max session lifetime exceeded
- `'max_idle'`: Idle timeout exceeded
- `'ua'`: User agent mismatch (>5% difference)
- `'tls'`: TLS status changed
- `'ip'`: IP address mismatch
- `'restart'`: Session manually restarted
- `null`: No state change

**Example:**
```php
$session->start('app');
if ($message = $session->message()) {
    error_log("Session issue: $message");
}
```

---

##### `toArray(): array`
Convert session data to array.

**Returns:** Associative array of session data

**Note:** This is a direct call to `ArrayObject::getArrayCopy()`

```php
$data = $session->toArray();
foreach ($data as $key => $value) {
    echo "$key => $value\n";
}
```

---

#### Nonce System

##### `create_nonce($action, $expires = null): string`
Generate a unique nonce token.

**Parameters:**
- `$action` (string): Action identifier (e.g., 'form_submit', 'delete_action')
- `$expires` (int|null): Expiration time in seconds. Defaults to `cf_nonce_lifetime`

**Returns:** Nonce token string (11 characters)

**Example:**
```php
$nonce = $session->create_nonce('form_submit', 3600);
// Use in HTML: <input type="hidden" name="nonce" value="<?= $nonce ?>">
```

**Storage:**
- Stored in `$session->__nonces[]`
- Key: `{action}.{base64_encoded_hash}`
- Value: Expiration timestamp

---

##### `verify_nonce($action, $code, $protect = 0)`
Verify a nonce token.

**Parameters:**
- `$action` (string): Action identifier that was used in `create_nonce()`
- `$code` (string): Nonce token from user
- `$protect` (int): Protection level
  - `0`: Single-use nonce (consumed on first verification)
  - `1+`: Protected nonce (can verify multiple times, prevents fast replays)

**Returns:**
- `true` (1): Nonce verified and valid
- `false` (0): Nonce invalid or expired
- `-1`: Protected nonce used twice in quick succession (possible AJAX attack)

**Example:**
```php
if ($nonce = $session->verify_nonce('form_submit', $_POST['nonce'])) {
    if ($nonce === -1) {
        // Possible replay, but might be legitimate AJAX
        $session->cf_prevent_replay = 0;  // Disable for this request
    } else {
        // Safe to process
        process_form();
    }
}
```

**Cleanup:**
- Expired nonces automatically removed
- Verified single-use nonces removed from storage

---

#### Cookie Management

##### `setcookie($name, $value = null, $expires = 0, $path = null, $domain = null, $secure = null, $httponly = null, $samesite = null): bool`
Set a cookie with security headers.

**Parameters:**
- `$name`: Cookie name (automatically URL-encoded)
- `$value`: Cookie value (automatically URL-encoded, null to delete)
- `$expires`: Expiration timestamp (0 = session cookie)
- `$path`: Cookie path (default: `cf_cookie_path`)
- `$domain`: Cookie domain (default: `cf_cookie_domain`)
- `$secure`: HTTPS only (default: `cf_cookie_secure`)
- `$httponly`: Disable JS access (default: `cf_cookie_httponly`)
- `$samesite`: SameSite attribute (default: `cf_cookie_samesite`)

**Returns:** `true` on success, `false` if headers already sent

**Features:**
- RFC 2616 2.2 token encoding for cookie name
- RFC 6265 4.1.1 cookie-octet encoding for value
- Removes duplicate cookie headers automatically
- Adds all security attributes (secure, httponly, samesite)
- Does NOT replace existing cookies (allows multiple Set-Cookie headers)

**Example:**
```php
// Session cookie
$session->setcookie('user_pref', 'dark_mode');

// Persistent cookie (30 days)
$session->setcookie('remember_me', 'token123', time() + 30*86400);

// Delete cookie
$session->setcookie('old_cookie', null);

// Secure cookie with SameSite
$session->setcookie('token', 'abc123', time() + 3600, 
    path: '/', secure: true, httponly: true, samesite: 'Strict');
```

---

##### `get_cookie($name)`
Retrieve cookie value.

**Parameters:**
- `$name`: Cookie name (prefix automatically added)

**Returns:** Cookie value or null if not set

```php
$value = $session->get_cookie('user_pref');  // Reads $_COOKIE['user_pref']
```

---

##### `set_cookie($name, $value, $persistent = false): void`
Legacy cookie setter (alternative to `setcookie()`).

**Parameters:**
- `$name`: Cookie name (prefix added)
- `$value`: Cookie value
- `$persistent`: 
  - `false`: Session cookie (deleted on browser close)
  - Number: Days to persist
  - `0`: Use `cf_cookie_persistent` config

**Example:**
```php
$session->set_cookie('theme', 'dark');  // Session cookie
$session->set_cookie('lang', 'en', 365);  // 1 year
```

---

##### `delete_cookie($name): void`
Delete a cookie.

**Parameters:**
- `$name`: Cookie name (prefix added)

**Implementation:** Sets empty value with immediate expiration

```php
$session->delete_cookie('old_preference');
```

---

##### `unsetcookie($name): void`
Alias for `setcookie($name)` with no value (convenience method).

```php
$session->unsetcookie('cookie_name');
```

---

### Protected Methods (For Store Implementation)

#### `regenerate_id($delete_old = false, $message = ''): bool`
Internal method to regenerate session ID (called automatically).

**Protected** - Usually called automatically, but can be overridden/called by subclasses

---

#### `store_generate_id(): string`
Generate a new session ID.

**Default Implementation:** Returns 21-character random alphanumeric string via `Ut::random_token(21)`

**Override in subclass to customize:**
```php
protected function store_generate_id(): string {
    return hash('sha256', random_bytes(32));  // Your format
}
```

---

#### `store_validate_id($id): bool`
Validate session ID format.

**Default Implementation:** Regex check: `/^[a-zA-Z\d]{21}$/`

**Override in subclass to match your format:**
```php
protected function store_validate_id($id): bool {
    return preg_match('/^[a-f0-9]{64}$/', $id);  // SHA256 format
}
```

---

#### `store_open($name): void`
Open session storage (called before first read/write).

**Subclass must implement** - Initialize storage handler

**Example:**
```php
protected function store_open($name): void {
    $this->db = new PDO('sqlite::memory:');
}
```

---

#### `store_read($id, $lock = false): string|false`
Read session data from storage.

**Subclass must implement**

**Parameters:**
- `$id`: Session ID to read
- `$lock`: If true, lock the session file for writing (create new)

**Returns:**
- Serialized session data (string) if found and locked
- Empty string (`''`) if new session should be created
- `false` if session doesn't exist or read error

**Example:**
```php
protected function store_read($id, $lock = false): string|false {
    $data = file_get_contents("/tmp/sess_$id");
    return $data ?: false;
}
```

---

#### `store_write($id, $data): void`
Write session data to storage.

**Subclass must implement**

**Parameters:**
- `$id`: Session ID
- `$data`: Serialized session data (already processed by `Ut::serialize()`)

**Example:**
```php
protected function store_write($id, $data): void {
    file_put_contents("/tmp/sess_$id", $data);
}
```

---

#### `store_close(): void`
Close session storage.

**Subclass must implement** - Release resources

**Example:**
```php
protected function store_close(): void {
    // Close database, file, etc.
}
```

---

#### `store_gc(): void`
Perform garbage collection on old sessions.

**Subclass must implement** - Delete expired sessions

**Called During:**
- Shutdown handler (probabilistic, based on `cf_gc_probability`)

**Should Delete:**
- Sessions older than `cf_gc_maxlifetime` seconds

**Example:**
```php
protected function store_gc(): void {
    $max_age = time() - $this->cf_gc_maxlifetime;
    // Delete files/records older than $max_age
}
```

---

### Private Methods (Internal Use)

##### `populate(): void`
Initialize session tracking variables on first request.

**Called by:** `start()`, `restart()`

**Initializes:**
- `__started`: Current timestamp
- `__regenerated`: Current timestamp
- `__user_agent`: Browser user agent
- `__user_ip`: Client IP (if configured)
- `__user_tls`: TLS status (if configured)
- `sticky__created`: Creation time (if not exists)

---

##### `write_session(): void`
Serialize and write session data to storage.

**Called by:** `regenerate_id()`, `write_close()`, `terminator()`

**Updates:**
- `__updated`: Current timestamp
- Calls `store_write()` with serialized data

---

##### `clean_vars(): void`
Remove non-sticky session variables.

**Called by:** `restart()`, session validation failure

**Preserves:** Variables starting with `sticky_`

---

##### `prevent_replay(): void`
Generate and send anti-replay nonce.

**Called by:** `populate()`

**Action:**
- Creates 'NoReplay' nonce
- Sends in cookie: `{cf_cookie_prefix}NoReplay`

---

##### `cache_limiter(): void`
Set HTTP cache control headers based on configuration.

**Called by:** `start()` after session data loaded

**Modes:**
- `'public'`: Cacheable, `Cache-Control: public, max-age=...`
- `'private'`: Private, `Cache-Control: private, max-age=...`
- `'private_no_expire'`: Private no TTL
- `'nocache'`: No storage, `Cache-Control: no-store`
- `'none'`: No headers (default)

---

##### `set_new_id(): void`
Generate and assign new session ID, send in cookie.

**Called by:** `regenerate_id()`, `start()` (for new sessions)

---

##### `remove_cookie($cookie): void`
Remove existing Set-Cookie header to avoid duplicates.

**Called by:** `setcookie()` before setting new value

---

##### `nonce_index($action, $code): string` (static)
Generate storage key for nonce.

**Returns:** `{action}.{base64_encoded_hash}`

---

---

## Session Lifecycle

### Complete Session Flow

```
┌─ Browser Request
│
├─ Application Code
│  └─ $session->start('appname')
│     │
│     ├─ Check if headers sent
│     ├─ Validate/read session name
│     ├─ Get session ID from:
│     │  1. Parameter $id
│     │  2. Cookie: {prefix}appname
│     ├─ Validate referer (if cf_referer_check set)
│     ├─ Validate ID format via store_validate_id()
│     ├─ store_open(name)
│     ├─ store_read(id)
│     │  └─ If missing/invalid/expired:
│     │     └─ set_new_id()
│     │        └─ regenerate_id = 2 (NEW)
│     ├─ Deserialize session data
│     ├─ exchangeArray(data)
│     ├─ active = true
│     ├─ cache_limiter()
│     │
│     └─ Security Checks (if NOT first request):
│        ├─ Verify NoReplay nonce
│        ├─ Check expiration flags
│        ├─ Check max session time
│        ├─ Check max idle time
│        ├─ Compare user agent (95%+ similarity)
│        ├─ Compare TLS status
│        ├─ Compare IP address
│        │  ├─ Match: OK
│        │  └─ Mismatch: destroy=1, regenerate
│        └─ Check regen time/probability
│           └─ regenerate_id()
│
├─ Application Code
│  └─ $session['key'] = 'value'
│
└─ End of Request
   │
   └─ register_shutdown_function() → terminator()
      │
      ├─ Process flash data
      │  └─ Decrement lifetimes
      │  └─ Remove expired flash
      ├─ write_session()
      │  └─ store_write(id, serialized_data)
      ├─ store_close()
      ├─ Probabilistic garbage collection
      │  └─ store_gc() (cf_gc_probability % chance)
      │     └─ Delete old sessions
      └─ Output sent to browser
```

### First Request (New Session)

```
start() is called
├─ No ID in cookie
├─ store_read(id) → false
├─ set_new_id()
│  └─ id = store_generate_id()
│  └─ send_cookie(name, id)
├─ data = []
├─ active = true
├─ populate()
│  ├─ __started = now
│  ├─ __regenerated = now
│  ├─ __user_agent = UA
│  └─ sticky__created = now
└─ return true
```

### Subsequent Request (Resume Session)

```
start() is called
├─ ID from cookie
├─ store_read(id) → serialized_data
├─ data = unserialize(data)
├─ exchangeArray(data)
├─ active = true
├─ Security checks:
│  ├─ Replay check
│  ├─ Timeout checks
│  ├─ UA/IP/TLS checks
│  └─ May trigger regenerate_id()
└─ return true
```

### Session ID Regeneration

```
regenerate_id($delete_old, $message) is called
├─ Check not headers_sent()
├─ Check $active
├─ Check not already regenerated in this request
├─ write_session()  [Save current data]
├─ set __expire:
│  ├─ if $delete_old=0: __expire = now + 5
│  └─ if $delete_old>0: __expire = 0
├─ Generate new ID:
│  └─ loop:
│      ├─ id = store_generate_id()
│      └─ while store_read(id) !== false  [Ensure unique]
├─ Lock new session: store_read(id, true)
├─ Set: __regenerated = now
├─ Set: regenerated = 1
├─ Log event: sticky__log[] = [now, message]
└─ return true
```

### Session Destruction

```
Triggered by:
├─ restart() → regenerate_id(true)
├─ Validation failure (destroy=2)
│  └─ regenerate_id(2)
│  └─ clean_vars()  [Remove non-sticky data]
└─ Timeout or security violation

Results in:
├─ __expire = 0  [Immediate expiration]
├─ Non-sticky variables cleared
├─ sticky_ variables preserved
└─ New session ID generated
```

---

## Flash Data

Flash data persists for a limited number of requests (typically 1-2) and is automatically removed.

### Usage

```php
// Store flash message for next request
$session->set_flash('error', 'Username already exists', 1);  // 1 request
$session->set_flash('info', 'Welcome back!', 2);             // 2 requests

// In next request, data automatically available
echo $session['error'];  // "Username already exists"
```

### How It Works

1. **Storage:** Flash data stored in `$session->sticky__flash`
   - Key: Variable name
   - Value: Lifetime in requests

2. **Cleanup:** In `terminator()` (shutdown handler):
   ```php
   foreach ($sticky__flash as $var => $age) {
       if (!isset($session[$var])) {
           unset($sticky__flash[$var]);  // Already deleted
       } else if (--$age <= 0) {
           unset($session[$var]);         // Expired, remove
           unset($flash__flash[$var]);
       } else {
           $flash__flash[$var] = $age;    // Decrement counter
       }
   }
   ```

3. **Persistence:** Flash variables are kept in `sticky__flash` even during session resets

### Example: Login Flow

```php
// POST /login
if ($credentials_valid) {
    $session->restart();  // New session
    $session['user_id'] = $user->id;
    $session->set_flash('success', 'Login successful!', 1);
    header('Location: /dashboard');
} else {
    $session->set_flash('error', 'Invalid credentials', 1);
    header('Location: /login');
}

// GET /dashboard (or /login on failure)
if ($message = $session['error'] ?? null) {
    echo "<div class='error'>$message</div>";
}
if ($message = $session['success'] ?? null) {
    echo "<div class='success'>$message</div>";
}
```

---

## Nonce System

Nonces provide CSRF protection and replay attack detection.

### Terminology

- **Nonce:** Number used ONCE - cryptographic token for action verification
- **Action:** Type of operation being protected (e.g., 'form_submit', 'delete_user')
- **Protected Nonce:** Can be verified multiple times with protection against rapid reuse

### Complete Example: Form Protection

```php
// 1. Display form with nonce
$nonce = $session->create_nonce('user_update', 3600);
?>
<form method="POST" action="/update-profile">
    <input type="hidden" name="nonce" value="<?= htmlspecialchars($nonce) ?>">
    <input type="text" name="username" value="...">
    <button type="submit">Update</button>
</form>

<?php
// 2. Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$session->verify_nonce('user_update', $_POST['nonce'] ?? '')) {
        http_response_code(403);
        die('Security check failed');
    }
    
    // Safe to process
    update_user($_POST);
}
```

### Example: Protected Nonce (AJAX-Safe)

```php
// Generate protected nonce (can verify multiple times)
$nonce = $session->create_nonce('ajax_action', 300);

// Verify with protection level 3 (3 seconds)
$result = $session->verify_nonce('ajax_action', $_POST['nonce'], 3);

if ($result === -1) {
    // Rapid reuse detected (possible attack, but might be AJAX)
    if (is_ajax_request()) {
        // AJAX is OK, disable replay protection this once
        $session->cf_prevent_replay = 0;
    } else {
        // Likely attack
        http_response_code(403);
        die('Suspicious activity');
    }
} else if ($result === true) {
    // Safe to process
    process_ajax();
}
```

### Nonce Storage Format

```
Internal storage (__nonces array):
[
    "{action}.{hash}" => expiration_timestamp,
    "form_submit.AbCdEfGhIjK" => 1234567890,
    "delete_user.XyZaBcDeFgH" => 1234567890,
]

Where:
- action: Custom action identifier
- hash: First 11 chars of base64(sha1(code_bytes)) 
- expiration_timestamp: time() + lifetime
```

### Security Properties

- **CSRF Protection:** Nonce must match to process form
- **One-Time Use:** Each nonce consumed after first verification (unless protected)
- **Expiration:** Nonces automatically expire
- **Action-Specific:** Each action has separate nonce space
- **AJAX-Safe:** Protected nonces allow multiple quick verifications

---

## Cookie Management

### Security Features

The `setcookie()` method implements comprehensive cookie security:

#### Encoding
```php
// Cookie names: RFC 2616 2.2 token format
// Cookie values: RFC 6265 4.1.1 cookie-octet format
// Unsafe characters automatically URL-encoded
```

#### Security Attributes
```php
setcookie('auth', 'token',
    expires: time() + 3600,
    secure: true,           // HTTPS only
    httponly: true,         // Disable JavaScript
    samesite: 'Strict'      // CSRF protection
);
```

#### No Duplicate Headers
```php
// Automatically removes old Set-Cookie header before setting new one
// Prevents cookie header duplication
remove_cookie($name) → clears old headers
setcookie() → sets new header
```

### Configuration-Driven Defaults

```php
$session->cf_cookie_path = '/app';          // Path
$session->cf_cookie_domain = '.example.com'; // Domain
$session->cf_cookie_secure = true;           // HTTPS
$session->cf_cookie_httponly = true;         // No JS
$session->cf_cookie_samesite = 'Lax';        // SameSite
$session->cf_cookie_prefix = 'app_';         // Prefix

$session->setcookie('token', 'value');
// Uses all configured defaults
```

### Typical Secure Configuration

```php
// Prevent XSS and CSRF
$session->cf_cookie_secure = true;              // HTTPS only
$session->cf_cookie_httponly = true;            // No JavaScript access
$session->cf_cookie_samesite = 'Strict';        // Strict CSRF protection

// Set scope
$session->cf_cookie_path = '/';                 // Root path
$session->cf_cookie_domain = '';                // Current host only

// Session cookies (delete on browser close)
$session->cf_cookie_lifetime = 0;
$session->cf_cookie_persistent = false;
```

---

## Error Handling

### Graceful Degradation

The Session class gracefully handles errors:

#### Headers Already Sent
```php
if (headers_sent($file, $line)) {
    trigger_error("id regeneration requested after headers flushed at $file:$line", 
                  E_USER_WARNING);
    return false;
}
```

**Impact:** Session ID cannot be regenerated, but session continues

#### Cookie Setting Failure
```php
if (headers_sent($file, $line)) {
    trigger_error("cannot place session cookie $name=$value due to $file:$line", 
                  E_USER_WARNING);
    return;
}
```

**Impact:** Cookie not set, but session data remains accessible

#### Storage Errors
```php
if ($this->store_read($this->id, true) !== '') {
    // error!  [comment indicates error, but continues]
}
```

**Impact:** Creates new session if storage returns error

### Debug Logging

The Session class includes commented debug statements:

```php
# Ut::dbg("regeneration failed by flush at $file:$line");
# Ut::dbg($destroy, $message);
# Ut::dbg("session setcookie $name failed by $file:$line");
```

To enable: Uncomment lines and ensure `Ut::dbg()` function exists

### Event Logging

Session events tracked in `sticky__log`:

```php
// Access session event history
if (isset($session->sticky__log)) {
    foreach ($session->sticky__log as [$timestamp, $message]) {
        echo "[$timestamp] $message\n";
    }
}
```

**Logged Events:**
- Session regeneration (with reason)
- Limited to 15 most recent events (old entries archived as '...')

---

## Implementation Guide

### Creating a Concrete Session Class

You must implement the abstract storage methods. Choose your storage backend: files, database, cache, etc.

#### File-Based Storage

```php
<?php

class FileSession extends Session {
    private $session_dir = '/tmp/sessions';
    private $file_handle = null;
    
    public function __construct() {
        parent::__construct();
        if (!is_dir($this->session_dir)) {
            mkdir($this->session_dir, 0700, true);
        }
    }
    
    protected function store_open($name): void {
        // PHP sessions don't really "open", just prepare
        // In file mode, we could initialize directory
    }
    
    protected function store_read($id, $lock = false): string|false {
        $file = $this->session_dir . '/sess_' . preg_replace('/[^a-zA-Z0-9]/', '', $id);
        
        if (!file_exists($file)) {
            if ($lock) {
                // Create new session file
                file_put_contents($file, '', LOCK_EX);
                return '';
            }
            return false;
        }
        
        if (filemtime($file) < time() - $this->cf_gc_maxlifetime) {
            unlink($file);  // Expired
            return false;
        }
        
        return file_get_contents($file);
    }
    
    protected function store_write($id, $data): void {
        $file = $this->session_dir . '/sess_' . preg_replace('/[^a-zA-Z0-9]/', '', $id);
        file_put_contents($file, $data, LOCK_EX);
    }
    
    protected function store_close(): void {
        // No cleanup needed for file backend
    }
    
    protected function store_gc(): void {
        $cutoff = time() - $this->cf_gc_maxlifetime;
        foreach (glob($this->session_dir . '/sess_*') as $file) {
            if (filemtime($file) < $cutoff) {
                unlink($file);
            }
        }
    }
}
```

#### Database Storage (PDO)

```php
<?php

class DatabaseSession extends Session {
    private PDO $pdo;
    
    public function __construct(PDO $pdo) {
        parent::__construct();
        $this->pdo = $pdo;
        $this->ensure_table();
    }
    
    private function ensure_table(): void {
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS sessions (
                id VARCHAR(21) PRIMARY KEY,
                data LONGTEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        SQL;
        $this->pdo->exec($sql);
    }
    
    protected function store_open($name): void {
        // Database already connected
    }
    
    protected function store_read($id, $lock = false): string|false {
        $stmt = $this->pdo->prepare('SELECT data FROM sessions WHERE id = ?');
        $stmt->execute([$id]);
        
        if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $result['data'];
        }
        
        if ($lock) {
            // Create new session
            $stmt = $this->pdo->prepare('INSERT INTO sessions (id, data) VALUES (?, ?)');
            $stmt->execute([$id, '']);
            return '';
        }
        
        return false;
    }
    
    protected function store_write($id, $data): void {
        $stmt = $this->pdo->prepare(
            'INSERT INTO sessions (id, data) VALUES (?, ?) 
             ON DUPLICATE KEY UPDATE data = VALUES(data)'
        );
        $stmt->execute([$id, $data]);
    }
    
    protected function store_close(): void {
        // Connection persists for application
    }
    
    protected function store_gc(): void {
        $cutoff = time() - $this->cf_gc_maxlifetime;
        $this->pdo->prepare('DELETE FROM sessions WHERE updated_at < FROM_UNIXTIME(?)')
                   ->execute([$cutoff]);
    }
}
```

#### Redis Storage

```php
<?php

class RedisSession extends Session {
    private Redis $redis;
    private string $prefix = 'sess:';
    
    public function __construct(Redis $redis) {
        parent::__construct();
        $this->redis = $redis;
    }
    
    protected function store_open($name): void {
        // Redis already connected
    }
    
    protected function store_read($id, $lock = false): string|false {
        $data = $this->redis->get($this->prefix . $id);
        
        if ($data !== false) {
            return $data;
        }
        
        if ($lock) {
            // Create new session
            $this->redis->set($this->prefix . $id, '', 
                            ['EX' => $this->cf_gc_maxlifetime]);
            return '';
        }
        
        return false;
    }
    
    protected function store_write($id, $data): void {
        $this->redis->set($this->prefix . $id, $data,
                        ['EX' => $this->cf_gc_maxlifetime]);
    }
    
    protected function store_close(): void {
        // Connection persists
    }
    
    protected function store_gc(): void {
        // Redis handles expiration automatically with TTL
    }
}
```

### Complete Integration Example

```php
<?php

// Initialize session with configuration
$session = new FileSession();

// Configure security
$session->cf_cookie_secure = (!empty($_SERVER['HTTPS']));
$session->cf_cookie_httponly = true;
$session->cf_cookie_samesite = 'Lax';
$session->cf_max_session = 86400;  // 24 hours
$session->cf_max_idle = 3600;      // 1 hour
$session->cf_prevent_replay = true;

// Set IP and TLS validation
$session->cf_ip = $_SERVER['REMOTE_ADDR'];
$session->cf_tls = !empty($_SERVER['HTTPS']);

// Start session
if (!$session->start('myapp')) {
    die('Session start failed');
}

// Check for session validation messages
if ($message = $session->message()) {
    error_log("Session validation: $message");
}

// Use session
if (!isset($session['user_id'])) {
    // Handle login...
    $session['user_id'] = $user->id;
    $session['username'] = $user->name;
    $session->regenerate_id(false, 'login');
} else {
    // User already logged in
    echo "Welcome back, " . htmlspecialchars($session['username']);
}

// Logout handling
if ($_REQUEST['action'] === 'logout') {
    $session->restart();
    header('Location: /');
}

// Automatic cleanup happens in register_shutdown_function()
```

### Configuration Best Practices

```php
<?php

class SessionConfig {
    public static function apply(Session $session, string $environment = 'production'): void {
        // Base configuration
        $session->cf_cookie_prefix = 'app_';
        $session->cf_cookie_path = '/';
        $session->cf_cache_limiter = 'private';
        
        if ($environment === 'production') {
            // Strict production settings
            $session->cf_cookie_secure = true;       // HTTPS only
            $session->cf_cookie_httponly = true;     // No JavaScript
            $session->cf_cookie_samesite = 'Strict'; // Maximum CSRF protection
            $session->cf_prevent_replay = true;      // Anti-replay
            $session->cf_max_session = 3600;         // 1 hour
            $session->cf_max_idle = 1800;            // 30 minutes
            $session->cf_regen_time = 300;           // Regen every 5 min
            $session->cf_regen_probability = 50;     // 50% chance
        } else {
            // Development settings
            $session->cf_cookie_secure = false;      // Allow HTTP
            $session->cf_cookie_httponly = false;    // Allow JS debugging
            $session->cf_prevent_replay = false;     // Easier testing
            $session->cf_max_session = 86400;        // 24 hours
            $session->cf_max_idle = 3600;            // 1 hour
            $session->cf_regen_time = 60;            // 1 minute
            $session->cf_regen_probability = 10;     // 10% chance
        }
    }
}

// Usage
$session = new FileSession();
SessionConfig::apply($session, $_ENV['APP_ENV'] ?? 'production');
$session->start('myapp');
```

### Testing Tips

```php
<?php

// Test nonce generation and verification
$nonce1 = $session->create_nonce('test_action', 60);
assert($session->verify_nonce('test_action', $nonce1) === true);

// Test single-use property
assert($session->verify_nonce('test_action', $nonce1) === false);

// Test expiration
$old_nonce = $session->create_nonce('expire_test', 1);
sleep(2);
assert($session->verify_nonce('expire_test', $old_nonce) === false);

// Test user agent validation
assert(isset($session->__user_agent));

// Test session ID format
assert(preg_match('/^[a-zA-Z0-9]{21}$/', $session->id()));

// Test data persistence
$session['test_key'] = 'test_value';
$session->write_close();
// New request...
$session2 = new FileSession();
$session2->start('myapp');
assert($session2['test_key'] === 'test_value');
```

---

## Security Checklist

Use this checklist when implementing sessions:

- [ ] Use HTTPS only in production
- [ ] Enable `cf_cookie_secure`
- [ ] Enable `cf_cookie_httponly`
- [ ] Set `cf_cookie_samesite` to 'Strict' or 'Lax'
- [ ] Set appropriate `cf_max_session` timeout
- [ ] Set appropriate `cf_max_idle` timeout
- [ ] Enable `cf_prevent_replay`
- [ ] Validate `cf_ip` if possible
- [ ] Validate `cf_tls` on HTTPS sites
- [ ] Use nonces for all state-changing forms
- [ ] Implement proper logout (call `restart()`)
- [ ] Regenerate on privilege escalation (login)
- [ ] Monitor `sticky__ip` for suspicious changes
- [ ] Review `sticky__log` for attack patterns
- [ ] Implement garbage collection (`store_gc`)
- [ ] Hash session IDs before storing (see TODOs)
- [ ] Use secure random token generation

---

## Common Patterns

### Login Flow

```php
if ($_POST['action'] === 'login') {
    $user = authenticate($_POST['username'], $_POST['password']);
    if ($user) {
        $session->regenerate_id(false, 'login');  // New ID after auth
        $session['user_id'] = $user->id;
        $session['username'] = $user->username;
        $session['roles'] = $user->roles;
        header('Location: /dashboard');
    } else {
        $session->set_flash('error', 'Invalid credentials', 1);
        header('Location: /login');
    }
}
```

### Logout Flow

```php
if ($_GET['action'] === 'logout') {
    $session->restart();  // Complete reset
    header('Location: /');
}
```

### CSRF-Protected Form

```php
// Display form
$csrf = $session->create_nonce('form_' . $form_id, 3600);
echo '<form method="POST">';
echo '<input type="hidden" name="csrf" value="' . htmlspecialchars($csrf) . '">';
// ... form fields
echo '</form>';

// Process form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$session->verify_nonce('form_' . $form_id, $_POST['csrf'] ?? '')) {
        die('CSRF check failed');
    }
    // Process safely
}
```

### Permission Check with Session Regeneration

```php
if ($user->privilege_level < ADMIN_LEVEL && $promoted_to_admin) {
    $session->regenerate_id(false, 'privilege_escalation');
    $session['is_admin'] = true;
}
```

### Session Messages/Flash

```php
// After action
$session->set_flash('info', 'Profile updated successfully', 1);

// Display next page
if (isset($session['info'])) {
    echo $session['info'];
}
```

---

## Performance Considerations

### Optimization Tips

1. **Minimize Session Writes:**
   - Session data only written during `write_close()` or regeneration
   - No unnecessary serialization during reads

2. **Garbage Collection:**
   - Probabilistic GC (based on `cf_gc_probability`)
   - Only runs on ~2% of requests by default
   - Customize based on your session volume

3. **Nonce Cleanup:**
   - Expired nonces automatically removed on verification
   - Verified nonces removed from storage
   - No manual cleanup needed

4. **Session ID Validation:**
   - Regex-based validation is fast
   - No database lookup needed

5. **Caching Strategy:**
   - Cache expensive lookups between session operations
   - Session data loaded once per request

### Benchmarks

Typical performance on modern hardware:

- Session start: ~1-5ms (file) / ~2-10ms (database)
- Session write: <1ms (file) / 1-5ms (database)
- Nonce generation: <1ms
- Nonce verification: <1ms

---

## Troubleshooting

### Session Not Starting

```php
if (!$session->start('myapp')) {
    // Check reasons:
    // 1. Headers already sent?
    // 2. Storage backend not initialized?
    // 3. Permissions issue on session directory?
    debug_backtrace();
}
```

### Cookie Not Setting

```php
// If setcookie() returns false:
// - Check if headers_sent()
// - Check if cookie name is RFC 2616 compliant
// - Check if cookie value is properly encoded
```

### Session ID Not Regenerating

```php
// If regenerate_id() returns false:
// - Headers might be sent
// - $active might be false
// - Already regenerated once in this request
if (!$session->regenerate_id()) {
    error_log("Regeneration failed: headers sent or session inactive");
}
```

### Nonce Verification Failing

```php
// If verify_nonce() returns false:
// 1. Nonce might be expired
// 2. Nonce might be for different action
// 3. Nonce might have been used already
// 4. Session might have been reset

// Debug:
var_dump($session->__nonces);  // See stored nonces
```

### Session Data Lost

```php
// Possible causes:
// 1. write_close() not called (usually automatic via shutdown)
// 2. Storage backend failing silently
// 3. File permissions issues
// 4. Session timeout due to cf_max_idle
// 5. IP/UA/TLS validation failure (check message())

if ($message = $session->message()) {
    error_log("Session issue: $message");
}
```

---

## TODO Items (From Code Comments)

The following improvements are planned:

1. **Do not store session ID in filename or DB index - store hash instead**
   - Improves security by not exposing IDs in storage layer
   - Would require hashing logic in store_* methods

2. **Log of IP changes and other possible security alerts**
   - Track `sticky__ip` changes more comprehensively
   - Create security audit trail

3. **Allocate internal unique session which lives through lifetime of uber-session**
   - Multi-session management (parent/child sessions)
   - Useful for complex user flows

4. **Do not delete old sessions, but use them as hijack pointers**
   - Maintain session history for analysis
   - Detect potential session hijacking patterns
   - Implement session relationship tracking

5. **All SIDs used later than ~5secs of regenerations is hijacks**
   - Detect and block delayed session ID usage
   - Current implementation allows 5-second window
   - Could be more granular

---

## References

### Security Standards

- RFC 2616: HTTP/1.1 (Cookie syntax)
- RFC 6265: HTTP State Management Mechanism
- RFC 6234: US Secure Hash and Message Authentication Code Algorithms
- OWASP: Session Management Cheat Sheet
- OWASP: Cross-Site Request Forgery (CSRF) Prevention

### Related Code

- `Ut::serialize()` / `Ut::unserialize()`: Session data serialization
- `Ut::random_token()`: Cryptographic token generation
- `Ut::http_date()`: HTTP date formatting
- `Ut::urlencode()`: Cookie-safe encoding
- `Ut::is_empty()`: Empty value checking

### See Also

- `src/class/http.php`: HTTP request/response handling
- `src/class/auth.php`: Authentication (uses Session)
- Session security best practices in OWASP documentation

---

## Version History

- **Current**: Abstract session class with security features
- **Planned**: Implementation of TODO items above

---

*Documentation generated: 2026-05-05*  
*For latest updates, see: https://github.com/Trojer/wackowiki/blob/main/docs/SESSION_DOCUMENTATION.md*
