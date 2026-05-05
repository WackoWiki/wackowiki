# HTTP Class Technical Documentation

## Overview

The `Http` class (`src/class/http.php`) is a core component of the WackoWiki system responsible for handling HTTP request/response processing, session management, caching, and security features. This class acts as a bridge between the web server and the wiki engine.

**File Location:** `src/class/http.php`  
**Language:** PHP  
**Dependencies:** Database class, Session classes, Utility classes (`Ut`), Diagnostics class (`Diag`)

---

## Class Properties

### Public Properties

| Property | Type | Description |
|----------|------|-------------|
| `$tls_session` | bool | Indicates if the current session uses HTTPS/TLS encryption |
| `$request_uri` | string | Normalized REQUEST_URI (e.g., 'PageOfNoReturn/show?a=1') |
| `$ip` | string | Client's real IP address (accounts for proxies) |
| `$sess` | Session | Reference to the Session object |
| `$method` | string | Current HTTP method/request type |

### Private Properties

| Property | Type | Description |
|----------|------|-------------|
| `$db` | object | Database connection reference |
| `$tls_mark` | string | Cookie name for TLS session marking |
| `$page` | string | Current page name being processed |
| `$hash` | string | SHA1 hash of the page name |
| `$query` | string | Encoded query string |
| `$lang` | string | Current language code |
| `$file` | string | Cache file path |
| `$caching` | int | Flag indicating if page should be cached (0 or 1) |

---

## Constructor

```php
public function __construct(&$db)
```

**Purpose:** Initializes the Http object and sets up HTTP session handling.

**Parameters:**
- `$db` - Database object reference

**Initialization Steps:**
1. Stores database reference
2. Extracts and normalizes REQUEST_URI
3. Detects TLS/HTTPS session status
4. Determines client's real IP address
5. Sets up TLS mark cookie name
6. Enforces TLS session upgrade if needed

**Example:**
```php
$http = new Http($db);
```

---

## Core Methods

### Session Management

#### `session($route): void`
Initializes the session handler (file-based or database-based).

**Parameters:**
- `$route` (int) - Routing flag:
  - Bit 2 (`$route & 2`): Enable static mode for files/freecap (disables replay prevention and ID regeneration)

**Features:**
- Selects storage backend (file or database)
- Configures cookie settings (security, path, httponly)
- Binds IP and TLS validation
- Recovers diagnostic logs from previous session

**Example:**
```php
$http->session(0);  // Normal session
$http->session(2);  // Static file serving mode
```

---

### Caching System

#### `check_cache($page, $method): void`
Determines if a page can be cached and prepares the cache check.

**Parameters:**
- `$page` (string) - Page name to cache
- `$method` (string) - Request method/action (e.g., 'show', 'edit')

**Caching Rules:**
- ✅ Enabled for GET requests only
- ✅ Disabled for POST requests
- ❌ Never cached for 'edit' or 'watch' methods
- ✅ Only cached for anonymous users (no logged-in users)

**Example:**
```php
$http->check_cache('HomePage', 'show');
```

---

#### `store_cache(): void`
Saves the generated page content to cache file.

**Features:**
- Retrieves output buffer content
- Saves to cache file with proper permissions
- Records cache metadata in database
- Only executes if caching flag is set and user is anonymous

**Example:**
```php
// Called at end of page rendering
$http->store_cache();
```

---

#### `invalidate_page($page): int`
Invalidates all cached versions of a page.

**Parameters:**
- `$page` (string) - Page name to invalidate

**Returns:**
- Number of cache entries invalidated

**Process:**
1. Finds all cached versions (different methods/languages)
2. Touches files to past timestamp (faster than deletion)
3. Removes entries from cache metadata table
4. Returns count of invalidated caches

**Example:**
```php
$count = $http->invalidate_page('HomePage');
echo "Invalidated $count cache entries";
```

---

### TLS/HTTPS Security

#### `secure_base_url(): void`
Switches base URL from HTTP to HTTPS.

**Purpose:**
- Ensures all subsequent URLs use HTTPS
- Stores original HTTP URL for fallback
- Called when TLS session is detected

**Example:**
```php
$http->secure_base_url();
// $db->base_url now uses https://
```

---

#### `ensure_tls($url): void`
Enforces HTTPS for a specific URL and redirects if necessary.

**Parameters:**
- `$url` (string) - URL to secure

**Behavior:**
- If not already HTTPS and TLS is enabled, forces HTTPS redirect
- Handles both relative and absolute URLs
- Converts relative URLs using current server name

**Example:**
```php
$http->ensure_tls('/secure/payment');
```

---

### IP Address Detection

#### `real_ip(): string` (Private)
Detects client's real IP address accounting for proxies.

**Proxy Headers Checked (in order):**
1. `HTTP_X_CLUSTER_CLIENT_IP`
2. `HTTP_X_FORWARDED_FOR` (or custom header)
3. `HTTP_CLIENT_IP`
4. `HTTP_X_REMOTE_ADDR`
5. `REMOTE_ADDR` (fallback)

**Features:**
- Filters out private/reserved IP ranges
- Respects configured reverse proxy addresses
- Returns `'0.0.0.0'` as fallback

**Configuration in Database:**
- `reverse_proxy_addresses` - Comma/space-separated proxy IPs
- `reverse_proxy_header` - Custom header name (default: `X-Forwarded-For`)

**Example:**
```php
$client_ip = $http->ip;  // e.g., "203.0.113.42"
```

---

### HTTPS Detection

#### `tls_session(): bool` (Private)
Detects if current connection uses HTTPS/TLS.

**Checks (any being true = HTTPS):**
- `$_SERVER['HTTPS']` is 'on'
- `$_SERVER['SERVER_PORT']` is 443
- `$_SERVER['HTTP_X_FORWARDED_PROTO']` is 'https'
- `$_SERVER['HTTP_X_FORWARDED_SSL']` is 'on'
- `$_SERVER['HTTP_X_FORWARDED_PORT']` is 443

---

### Security Headers

#### `http_security_headers(): void`
Sets security-related HTTP headers.

**Headers Set:**

| Header | Purpose | Config Key |
|--------|---------|------------|
| Content-Security-Policy | XSS/injection protection | `csp` |
| Permissions-Policy | Control browser features | `permissions_policy` |
| Referrer-Policy | Control referrer information | `referrer_policy` |
| Strict-Transport-Security | Force HTTPS | Auto (TLS only) |
| X-Frame-Options | Clickjacking protection | Hardcoded: `SAMEORIGIN` |
| X-Content-Type-Options | MIME sniffing prevention | Hardcoded: `nosniff` |

**CSP Configuration Options:**
- `0` - Disabled
- `1` - Default policy (from `csp.conf`)
- `2` - Custom policy (from `csp_custom.conf`)

**Example:**
```php
$http->http_security_headers();
```

---

### HTTP Methods

#### `redirect($url, $permanent = false): void`
Performs an HTTP redirect.

**Parameters:**
- `$url` (string) - Target URL
- `$permanent` (bool) - Use 301 (permanent) vs 302 (temporary)

**Features:**
- Decodes `&amp;` entities to prevent broken redirects
- Only works if headers not yet sent
- Uses output buffering to work anywhere in page processing

**Example:**
```php
$http->redirect('http://example.com/new-page', true);  // 301
$http->redirect('/wiki/HomePage');                       // 302
```

---

#### `terminate(): void`
Safe exit/die with cleanup.

**Cleanup Operations:**
- Saves diagnostic logs to session flash data
- Ends script execution

**Example:**
```php
$http->terminate();
```

---

#### `status($code): void`
Sets HTTP response status code.

**Supported Status Codes:**
```php
200 => 'OK'
206 => 'Partial Content'
301 => 'Moved Permanently'
302 => 'Moved Temporarily'
304 => 'Not Modified'
400 => 'Bad Request'
401 => 'Unauthorized'
403 => 'Forbidden'
404 => 'Not Found'
405 => 'Method Not Allowed'
409 => 'Conflict'
410 => 'Gone'
416 => 'Requested Range Not Satisfiable'
500 => 'Internal Server Error'
501 => 'Not Implemented'
503 => 'Service Unavailable'
```

**Example:**
```php
$http->status(404);  // Send 404 Not Found
```

---

### Caching Control

#### `no_cache($client_only = true): void`
Disables caching of the current page.

**Parameters:**
- `$client_only` (bool, default: TRUE)
  - `TRUE`: Disable browser cache only
  - `FALSE`: Disable both browser and server cache

**Headers Set:**
- `Last-Modified: <current-time>` (always fresh)
- `Cache-Control: no-store`

**Example:**
```php
$http->no_cache();        // Client-side only
$http->no_cache(false);   // Both client & server
```

---

#### `cache_promisc(): void`
Marks page as publicly cacheable.

**Headers Set:**
- `Cache-Control: public`

**Example:**
```php
$http->cache_promisc();
```

---

### Language Negotiation

#### `user_agent_language(): string`
Determines best language based on browser preferences.

**Features:**
- Follows RFC 9110 section 12.5.4 (HTTP Accept-Language)
- Parses `Accept-Language` header with quality factors
- Attempts exact match first, then language fallback
- Falls back to default system language

**Example Header:**
```
Accept-Language: en-US,en;q=0.9,de;q=0.8
```

**Returns:**
- Language code (e.g., 'en', 'en-US', 'de')

---

#### `available_languages($subset = true): array`
Returns list of available language translations.

**Parameters:**
- `$subset` (bool, default: TRUE)
  - `TRUE`: Only allowed languages
  - `FALSE`: All available languages

**Features:**
- Scans `LANG_DIR` for language files
- Filters by `allowed_languages` config if set
- Caches result in session
- System language always included

**Returns:**
- Associative array: `['en' => 'en', 'de' => 'de', ...]`

**Example:**
```php
$all_langs = $http->available_languages(false);
$allowed = $http->available_languages(true);
```

---

### File Serving

#### `sendfile($path, $filename = null, $age = null): void`
Serves files with proper HTTP headers and caching.

**Parameters:**
- `$path` (string) - File path (or HTTP_XXX constant for error pages)
- `$filename` (string, optional) - Custom download filename
- `$age` (int, optional) - Cache age in days

**Features:**
- HTTP range request support (partial file downloads)
- ETag and Last-Modified conditional requests
- Proper MIME type detection
- Content-Security-Policy for special file types
- Streaming for large files
- GZip compression for text files

**Special Paths:**
```php
$http->sendfile(404);  // Serves file defined by HTTP_404 constant
$http->sendfile(403);  // Serves file defined by HTTP_403 constant
```

**Example:**
```php
$http->sendfile('uploads/document.pdf', 'my-document.pdf', 30);
```

---

#### `mime_type($path): string`
Returns MIME type for a file.

**Returns:**
- MIME type string (e.g., 'application/pdf')
- Default: `'application/octet-stream'`

**Example:**
```php
$mime = $http->mime_type('file.pdf');  // 'application/pdf'
```

---

#### `mime_types(): array` (Private)
Loads and caches MIME types from configuration.

**Features:**
- Reads from `config/mime.types`
- Caches to `cache/config/mime.types`
- Reloads if config is updated

---

### Compression

#### `gzip(): void`
Compresses HTTP response with gzip/x-gzip.

**Features:**
- Manually implements gzip (not relying on zlib.output_compression)
- Produces correct `Content-Length` header
- Only compresses if:
  - 860 bytes < content < 1 MB
  - Client accepts compression
  - Headers not already sent

**Example:**
```php
$http->gzip();
```

---

### Utility Methods

#### `parse_str($str): array` (Private)
Parses URL-encoded strings with special character handling.

**Purpose:**
- Safely handles special characters in query/form data
- Converts encoding properly

**Example:**
```php
$data = $http->parse_str('name=John&age=30');
```

---

#### `request_uri(): string` (Private)
Extracts and normalizes REQUEST_URI from server.

**Normalization:**
- Removes base URL prefix
- Removes spaces
- Collapses multiple slashes
- Removes `..` path traversal attempts
- Removes leading/trailing slashes

---

#### `cut_prefix($prefix, $path): string` (Private)
Removes prefix from path (case-insensitive).

---

#### `get_header_conf($file_name): string` (Private)
Loads security header configuration from files.

**Files Supported:**
- `csp.conf` / `csp_custom.conf`
- `permissions_policy.conf` / `permissions_policy_custom.conf`

---

## Configuration Dependencies

The class relies on these database configuration settings:

| Setting | Type | Purpose |
|---------|------|---------|
| `base_url` | string | Wiki's base URL |
| `tls` | bool | Enable HTTPS enforcement |
| `cache` | bool | Enable page caching |
| `cache_ttl` | int | Cache lifetime in seconds |
| `session_store` | int | 1=File, 0=Database |
| `system_seed_hash` | string | Session encryption seed |
| `cookie_prefix` | string | Session cookie prefix |
| `cookie_path` | string | Cookie path |
| `allow_persistent_cookie` | bool | Allow persistent login |
| `session_length` | int | Session lifetime in seconds |
| `reverse_proxy_addresses` | string | Comma/space-separated proxy IPs |
| `reverse_proxy_header` | string | Custom X-Forwarded header |
| `language` | string | Default language code |
| `multilanguage` | bool | Enable language negotiation |
| `allowed_languages` | string | Comma/space-separated allowed langs |
| `enable_security_headers` | bool | Send security headers |
| `csp` | int | CSP setting (0/1/2) |
| `permissions_policy` | int | Permissions-Policy setting (0/1/2) |
| `referrer_policy` | int | Referrer-Policy setting (0-8) |

---

## Constants Used

| Constant | Type | Purpose |
|----------|------|---------|
| `IN_WACKO` | bool | Security check (exit if not defined) |
| `CHMOD_SAFE` | int | File permissions for cache files |
| `CHMOD_FILE` | int | File permissions for config cache |
| `CACHE_PAGE_DIR` | string | Page cache directory |
| `CACHE_SESSION_DIR` | string | Session cache directory |
| `CACHE_CONFIG_DIR` | string | Config cache directory |
| `CONFIG_DIR` | string | Configuration directory |
| `LANG_DIR` | string | Language files directory |
| `DAYSECS` | int | Seconds in a day (86400) |
| `HTTP_404` | string | Path to 404 error page |
| `HTTP_403` | string | Path to 403 error page |

---

## Workflow Examples

### Example 1: Handling a GET Request

```php
// In main wiki entry point
$http = new Http($db);
$http->session(0);  // Start session

// Check if page can be served from cache
$http->check_cache('HomePage', 'show');

// ... render page content ...

// Store rendered page in cache if applicable
$http->store_cache();

// Send security headers
$http->http_security_headers();

// Possibly compress output
$http->gzip();
```

### Example 2: Handling TLS/HTTPS Upgrade

```php
$http = new Http($db);  // Constructor detects TLS requirement
// If TLS is enabled and user wasn't in TLS before:
// - Sets TLS session flag
// - Marks session with TLS cookie
// - Redirects to HTTPS version
```

### Example 3: Invalidating Cache After Page Edit

```php
// User edits a page
$http = new Http($db);
$count = $http->invalidate_page('HomePage');
// All cached versions (different languages, methods) are invalidated
```

### Example 4: Serving a File

```php
$http = new Http($db);
$http->session(2);  // Static file mode - no session replay prevention

// Serve with 30-day cache
$http->sendfile('uploads/manual.pdf', 'user-manual.pdf', 30);
```

---

## Security Considerations

### 1. **IP Address Spoofing**
- Validates IPs against private ranges
- Filters proxy-provided IPs appropriately
- Configurable reverse proxy trust

### 2. **Session Security**
- Binds sessions to IP address
- Binds sessions to TLS status
- Supports both file and database storage
- HttpOnly cookies by default

### 3. **TLS Enforcement**
- Automatic HTTPS upgrade when configured
- Marks TLS sessions to prevent downgrade attacks
- HSTS header support

### 4. **Content Security**
- CSP headers to prevent XSS
- X-Frame-Options to prevent clickjacking
- X-Content-Type-Options to prevent MIME sniffing
- Referrer-Policy control
- Permissions-Policy for browser features

### 5. **File Serving**
- Validates file existence and readability
- Prevents directory traversal via `realpath()`
- Rejects symbolic links
- Special CSP for SVG and PDF files

### 6. **Cache Security**
- Cached only for anonymous users
- Disabled for sensitive operations (edit, watch)
- Only GET requests cached

---

## Performance Optimization

### 1. **Page Caching**
- Stores full HTML output
- TTL-based expiration
- Language and method-aware caching
- Conditional request support (304 Not Modified)

### 2. **MIME Type Caching**
- Loads MIME types once and caches
- Regenerates only when config changes

### 3. **Session Options**
- File-based sessions for simple deployments
- Database sessions for distributed systems

### 4. **Compression**
- Manual gzip implementation
- Proper Content-Length generation
- Only compresses appropriate sizes

---

## Debugging

The class integrates with WackoWiki's diagnostic system:

```php
// Diagnostic messages are preserved across redirects
// via session flash data

// Check cached pages (debug comments in output):
// <!-- WackoWiki Caching Engine: page cached at 2024-01-15 12:30:45 GMT -->
```

---

## Related Classes

- **Session Classes** (`SessionFileStore`, `SessionDbalStore`) - Session management backends
- **Database Class** - Configuration and cache metadata storage
- **Ut Utility Class** - String/path utilities
- **Diag Class** - Diagnostic logging

---

## Version History

- Supports PHP 8.0+ (uses match expressions, union types)
- Follows RFC 9110 for HTTP header handling
- Modern cookie security practices

---

## Conclusion

The `Http` class is the central request/response handler in WackoWiki, managing everything from session initialization to security headers to file serving. Understanding this class is essential for:

- Extending WackoWiki with custom request handlers
- Implementing custom session logic
- Adding new security policies
- Optimizing cache strategies
- Debugging HTTP-related issues
