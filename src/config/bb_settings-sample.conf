; Bad Behaviour 3.0 Configuration
; Copy to settings.ini and customize

[core]
logging = true
verbose = false
strict = false

; (opt-in)
; inspect_json_body = false        ; Inspect JSON POST bodies for attacks (BREAKS AJAX)
; inspect_multipart_body = false   ; Inspect multipart uploads (BREAKS FILE UPLOADS)
; enable_fingerprinting = false    ; JA3/H2/header-order analysis (FP RISK)
; enable_behavioral_analysis = true ; Rate anomalies, rotating UA/IP (SAFE)
; enable_ai_crawler_control = true ; AI crawler management (SAFE)

[reverse_proxy]
enabled = true
header = "CF-Connecting-IP"
addresses[] = "10.0.0.0/8"
addresses[] = "172.16.0.0/12"
addresses[] = "192.168.0.0/16"
; Cloudflare IPs (auto-fetch recommended)
; addresses[] = "173.245.48.0/20"
; addresses[] = "103.21.244.0/22"

[forms]
offsite_forms = false

[httpbl]
key = ""
threat = 25
maxage = 30

[dnsbl]
lists[] = "zen.spamhaus.org"
lists[] = "bl.spamcop.net"

[ai_crawlers]
allowed[] = "GPTBot"
allowed[] = "ClaudeBot"
allowed[] = "Google-Extended"
allowed[] = "PerplexityBot"
block_unverified = true
strict = false

[search_engines]
strict = false

[bot_categories]
blocked[] = "malicious"
; blocked[] = "seo_crawler"

[rate_limits]
enabled = true
global.requests = 1000
global.window = 3600
per_minute.requests = 60
per_minute.window = 60
post.requests = 30
post.window = 3600
login.requests = 10
login.window = 900

[custom_rules]
; rules[] = {"type": "ip", "value": "192.0.2.0/24", "action": "block", "id": "test_network"}
; rules[] = {"type": "country", "value": "KP", "action": "block", "id": "north_korea"}

[fingerprints]
bad_ja3[] = ""
bad_h2[] = ""
bot_header_orders[] = ""

[geoip]
enabled = false
database_path = "/usr/share/GeoIP/GeoLite2-Country.mmdb"
blocked_countries[] = "KP"
blocked_asns[] = ""

[challenge]
enabled = false
provider = "builtin"
site_key = ""
secret_key = ""
recaptcha_min_score = 0.5

[performance]
skip_extensions[] = "css"
skip_extensions[] = "js"
skip_extensions[] = "png"
skip_extensions[] = "jpg"
skip_paths[] = "/static/"
skip_paths[] = "/assets/"
