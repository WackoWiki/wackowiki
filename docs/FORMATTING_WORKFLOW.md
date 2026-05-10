# WackoWiki Formatting Workflow

## Overview

The WackoWiki text formatting system is a multi-stage pipeline that transforms raw wiki markup into rendered HTML. Understanding the order and purpose of each stage is critical to properly extending or debugging the formatter.

The complete workflow consists of **6 primary stages**:

```
User Input
    ↓
[1] PRE_WACKO - Macro Resolution
    ↓
[2] WACKO FORMATTER - Wiki Markup Parsing
    ↓
[3] TYPOGRAFICA - Typography Enhancement
    ↓
[4] PARAGRAFICA - Paragraph Structuring
    ↓
[5] HIGHLIGHTER - Syntax Highlighting (if applicable)
    ↓
[6] POST_WACKO - Link & Action Resolution
    ↓
Final HTML Output
```

---

## Stage 1: Pre-Wacko (Macro Resolution)

**File:** `src/formatter/pre_wacko.php`  
**Class:** `src/formatter/class/pre_wacko.php` → `PreFormatter`

### Purpose
The Pre-Wacko stage processes user-defined macros and preserves special formatting markers before the main wiki parsing begins. This stage acts as a preprocessing layer that resolves temporal and user-specific macros.

### Input
Raw text containing wiki markup with embedded macros, formatter markers, and escaped text.

### Output
Text with macros expanded, but formatter markers and escaped text preserved for later stages.

### Processing Details

The `PreFormatter` class uses regex patterns to identify and process four types of constructs:

#### 1. **Formatter Text Preservation** (`` ` ` ... ` ` ``)
- Backtick-enclosed text (`` `code` ``) is preserved but remains wrapped
- These sections bypass most transformations in later stages
- Example: `` `some code` `` → `` `some code` `` (unchanged)

#### 2. **Formatter Text Preservation** (`%%...%%`)
- Percent-enclosed text is preserved but remains wrapped
- Used for literal text that shouldn't be processed
- Example: `%%literal text%%` → `%%literal text%%` (unchanged)

#### 3. **Escaped Text** (`""...""`)
- Double-quote-enclosed text is preserved from markup parsing
- Allows users to include wiki syntax literally
- Example: `""((link))""` → `""((link))""` (treated as literal)

#### 4. **User Macros** (Special `::`sequences)
- `::::::` → Expands to `((user:username username)):`
- `::::: ` → Expands to `((user:username username))`
- `::@::` → Expands to `((user:username username)) YYYY-MM-DD HH:MM:SS`
- `::+::` → Expands to current date/time in configured format

### Workflow

```php
// 1. Instantiate PreFormatter with current context
$parser = new PreFormatter($this);

// 2. Apply regex to find all macro/marker patterns
$text = preg_replace_callback($parser->PRE_REGEX, [&$parser, 'precallback'], $text);

// 3. precallback() processes each match:
//    - Identifies the type of construct (formatter, escaped, macro)
//    - Expands macros or preserves markers
//    - Returns the processed construct
```

### Key Points
- **Non-destructive:** Original markers remain to guide subsequent stages
- **Context-aware:** Can access user information and system configuration
- **Regex-based:** Single-pass processing with callback evaluation
- **Ordering:** Must run FIRST to establish preserved sections before wiki markup parsing

---

## Stage 2: Wacko Formatter (Wiki Markup Parsing)

**File:** `src/formatter/wiki.php`  
**Class:** `src/formatter/class/wackoformatter.php` → `WackoFormatter`

### Purpose
The main formatting engine that parses WackoWiki markup syntax and converts it to intermediate HTML. This stage handles:
- Wiki syntax (bold, italic, headers, etc.)
- Links and references
- Lists and indentation
- Tables
- Code blocks and special blocks

### Input
Text from Pre-Wacko stage (with macros expanded and markers preserved).

### Output
Intermediate HTML with:
- Processed wiki markup converted to HTML tags
- Links wrapped in `<!--link:begin-->...<!--link:end-->` markers for later processing
- Actions wrapped in `<!--action:begin-->...<!--action:end-->` markers
- Formatter markers (`<!--markup:1:...-->`) inserted for later stages
- Typography-safe markers (`<!--notypo-->...<!--/notypo-->`) protecting code sections

### Processing Details

The `WackoFormatter` class is the most complex component. It:

1. **Tokenizes** wiki markup syntax
2. **Builds an AST** (Abstract Syntax Tree) of the document structure
3. **Traverses the tree** to generate HTML
4. **Handles nesting** of elements (lists within lists, emphasis within links, etc.)
5. **Preserves marked sections** (formatter text, escaped text, code blocks)

### Key Features

- **Smart link handling:** Links are not immediately converted; they're wrapped in markers for Post-Wacko stage
- **Action processing:** Wiki actions (like `{{include}}`, `{{toc}}`, etc.) are also marked for Post-Wacko
- **Nested formatting:** Properly handles bold within italics, lists within tables, etc.
- **Context preservation:** Maintains state about what's inside code blocks, quotes, etc.

### Example Transformations

```
**bold** → <strong>bold</strong>
//italic// → <em>italic</em>
= Header = → <h1>Header</h1>
[[link]] → <!--link:begin-->link==link<!--link:end-->
{{action}} → <!--action:begin-->action<!--action:end-->
```

### Workflow

```php
// In wiki.php
$text = $this->format($text, 'wacko');

// This calls WackoFormatter which:
// 1. Parses entire wiki markup into HTML
// 2. Wraps links and actions in special markers
// 3. Preserves typography-sensitive sections
// 4. Returns intermediate HTML ready for next stage
```

### Key Points
- **Central to the system:** Most of the formatting logic resides here
- **Marker-based approach:** Uses HTML comments to mark regions for later processing
- **Stateful:** Maintains parsing context as it traverses the document
- **Extensible:** Custom wiki syntax can be added by extending the formatter

---

## Stage 3: Typografica (Typography Enhancement)

**File:** `src/formatter/class/typografica.php`  
**Class:** `Typografica`

### Purpose
Enhance typography and readability of text within HTML. This stage processes already-parsed HTML to apply language-specific typography rules and improve spacing/punctuation.

### Input
Intermediate HTML from WackoFormatter stage.

### Output
HTML with typography improvements applied:
- Smart quotes (language-specific)
- Proper dashes (em-dash, en-dash, hyphen)
- Non-breaking spaces between short words and prepositions
- Special characters (©, ®, ™, etc.)
- Phone number formatting with no-break wrapping

### Processing Details

The `Typografica::correct()` method applies 10 transformation phases:

#### Phase -2: Preserve Ignored Regions
- Identifies `<!--notypo-->...<!--/notypo-->` regions
- Replaces them with temporary markers
- Stores original content for later restoration
- Purpose: Prevents typography rules from affecting code/literal text

#### Phase -1: HTML Tag Stripping (Optional)
- If `settings['html']` enabled, escapes `&` to `&amp;`
- Allows safer text processing

#### Phase 0: HTML Tag Preservation
- Removes all HTML tags and stores them temporarily
- Replaces with marker `{:typo:markup:1:}`
- Purpose: Prevents typography rules from breaking tag syntax
- Handles complex cases: nested tags, attributes with `>`, wiki markers

#### Phase 1: Spacing Corrections
- Moves commas before spaces: ` ,` → `,`
- Moves punctuation before spaces: ` .?!` → `.?!`
- Language: Supports Unicode letter classes (`\p{L}`)

#### Phase 2: Special Character Replacements
Depending on settings:

| Pattern | Replacement | Code Point |
|---------|-------------|-----------|
| `"` (inches) | `"` | U+0022 |
| `'` (apostrophe) | `'` | U+2019 (configurable) |
| `"..."` (English) | `"..."` | U+201C/U+201D |
| `"..."` (angle) | `«...»` | U+00AB/U+00BB |
| ` - ` (en-dash) | ` – ` | U+2013 |
| ` -- ` (em-dash) | ` — ` | U+2014 |
| `(c)` | `©` | U+00A9 |
| `(r)` | `®` | U+00AE |
| `(tm)` | `™` | U+2122 |
| `(p)` | `§` | U+00A7 |
| `+-` | `±` | U+00B1 |
| `^C` / `^F` / `^K` | `°C` / `°F` / `°K` | U+00B0 |

#### Phase 3: Short Word Spacing
- Applies non-breaking spaces (`\u{00A0}` NBSP) between:
  - Short words (1-3 characters) and following words
  - Prepositions and following words (language-specific)
- Prevents orphaned prepositions at line breaks
- Supports Russian abbreviations: `рис.`, `табл.`, `см.`, `им.`, `ул.`, `пер.`, `кв.`, `офис`, `оф.`, `г.`

#### Phase 4: Hyphenated Word Wrapping
- Wraps hyphenated words: `word-word-word` → `<nobr>word-word-word</nobr>`
- Prevents line breaks within compound words
- Later converted to `<span class="nobr">` (unless `de_nobr` disabled)

#### Phase 5: Macro Processing
- Replaces `[--]` with spacer image (single indent)
- Replaces `[---]` with spacer image (double indent)

#### Phase ∞: Tag Restoration
- Restores preserved HTML tags from Phase 0

#### Phase ∞+1: Ignored Region Restoration
- Restores original content from ignored regions

### Workflow

```php
$typo = new Typografica($this, $options);
$text = $typo->correct($text);
```

### Key Points
- **Non-HTML-destructive:** Carefully preserves tag syntax while transforming content
- **Language-aware:** Settings vary based on language (`$options['lang']`)
- **Configurable:** Each rule can be enabled/disabled via settings array
- **Regex-intensive:** Uses complex regex with Unicode support
- **Runs AFTER wiki parsing:** Works on already-formed HTML

---

## Stage 4: Paragrafica (Paragraph Structuring)

**File:** `src/formatter/paragrafica.php`  
**Class:** `src/formatter/class/paragrafica.php` → `Paragrafica`

### Purpose
Insert semantic `<p>` tags around text blocks that lack explicit block-level markup. Converts loose text and `<br>` sequences into proper paragraphs while respecting already-structured block elements.

### Input
HTML from Typografica stage (with proper typography but possibly lacking paragraph tags).

### Output
HTML with:
- Auto-generated `<p id="pXXXXX-N" class="auto">` tags around text blocks
- Proper nesting preserved (no `<p>` inside block elements)
- Table-of-contents (TOC) entries extracted

### Processing Details

The `Paragrafica::correct()` method uses a sophisticated "terminator" system with special markers:

#### Marker System

| Marker | Purpose |
|--------|---------|
| `<:t->` | Start paragraph zone (left terminator) |
| `<:-t>` | End paragraph zone (right terminator) |
| `<:::>` | Wronginator: indicates problematic nesting (table cells, list items) |
| `<:-:>` | Ultimate wronginator: never insert paragraphs here |

#### Processing Steps

**Step -2: Preserve Ignored Regions**
- Stores `<!--notypo-->...<!--/notypo-->` content
- Replaces with marker `{:typo:markup:3:}`

**Step -1: Remove Prefix**
- Cleans up typography markers from previous stages

**Step 1: Insert Terminators**
- Scans for block-level HTML elements using regex patterns
- Inserts `<:t->` before and `<:-t>` after each block element
- Special handling for problematic elements:
  - `<td>`, `<dd>`, `<dt>`, `<li>` get "wronginator" markers (`<:::>`)
  - `<:-:>` markers prevent paragraph insertion completely

**Step 2: Clean Up Whitespace**
- Removes empty terminator pairs: `<:t->\s*<:-t>` → deleted
- Swaps `<:t->` before `<br>` tags to prevent orphaned breaks

**Step 3: Generate Paragraph Tags**
- Splits text on `<:t->` markers
- Between `<:t->` and `<:-t>`, inserts `<p id="pID-COUNT" class="auto">...</p>`
- Assigns unique IDs based on page ID and counter
- Only inserts `<p>` if content exists and not flagged with wronginator

#### Example Transformation

```html
Before:
Text without paragraph
<table>
  <tr><td>In table</td></tr>
</table>
More text

After:
<p id="p12345-1" class="auto">Text without paragraph</p>
<table>
  <tr><td>In table</td></tr>
</table>
<p id="p12345-2" class="auto">More text</p>
```

### TOC (Table of Contents) Extraction

After paragraph insertion, `Paragrafica` builds a TOC by:

1. Finding all `<h1>...<h6>` headers with IDs
2. Extracting header depth from tag name
3. Finding all auto-generated `<p>` tags with IDs
4. Identifying included pages via `{{include page="..."}}` actions
5. Storing in `$para->toc` array for later use

### Workflow

```php
$para = new Paragrafica($this);
$result = $para->correct($text);
$this->set_toc_array($para->toc);  // Store TOC for later
```

### Key Points
- **Selective insertion:** Only adds `<p>` where needed
- **ID generation:** Creates unique IDs combining page ID and paragraph count
- **TOC building:** Extracts document structure simultaneously
- **Complex logic:** Terminator system prevents common paragraph nesting errors
- **Runs AFTER typography:** Works on fully-enhanced HTML

---

## Stage 5: Highlighter (Syntax Highlighting)

**File:** `src/formatter/class/highlighter.php` (if applicable based on configuration)  
**Purpose:** Apply syntax highlighting to code blocks

### Note
The highlighter stage is optional and depends on:
- Whether code blocks exist in the document
- Configuration/enablement in system settings
- Availability of highlighter library (e.g., Pygments integration)

### Input
HTML with `<pre>` or `<code>` blocks marked for highlighting.

### Output
HTML with syntax-highlighted code blocks (language-specific color and markup).

---

## Stage 6: Post-Wacko (Link & Action Resolution)

**File:** `src/formatter/post_wacko.php`  
**Class:** `src/formatter/class/post_wacko.php` → `PostWacko`

### Purpose
Process dynamically-deferred links and actions. By the time we reach this stage, the document is structurally complete; now we resolve references that depend on:
- Database lookups (page existence, user info)
- Permission checks
- Dynamic content generation (includes, tables of contents, etc.)

### Input
HTML from previous stages containing:
- `<!--link:begin-->URL==DESCRIPTION<!--link:end-->` markers
- `<!--imglink:begin-->IMAGE==URL<!--imglink:end-->` markers
- `<!--action:begin-->ACTION_NAME PARAMS<!--action:end-->` markers

### Output
Final HTML with:
- Links converted to actual `<a href="...">` tags
- Images wrapped in appropriate `<img>` tags
- Actions executed and replaced with generated content
- Optional formatter markers stripped (if requested)

### Processing Details

The `PostWacko::postcallback()` method handles three types of constructs:

#### 1. Forced Links
**Marker Format:** `<!--link:begin-->URL==DESCRIPTION<!--link:end-->`

**Processing:**
- Extracts URL and description
- URL-encodes spaces → `%20`
- Cleans description (removes formatter markup)
- Calls `$wacko->link()` to generate proper `<a>` tag
- Returns generated link HTML

**Example:**
```
<!--link:begin-->http://example.com==Click here<!--link:end-->
↓
<a href="http://example.com">Click here</a>
```

#### 2. Image Links
**Marker Format:** `<!--imglink:begin-->LINK_TARGET==IMAGE_SOURCE<!--imglink:end-->`

**Processing:**
- Extracts link target and image source
- Calls `$wacko->link()` twice:
  - First on link target to get URL
  - Then on image source to get image tag
- Wraps image tag in `<a>` pointing to link target

**Example:**
```
<!--imglink:begin-->page.html==file:image.jpg<!--imglink:end-->
↓
<a href="page.html"><img src="/file/image.jpg" /></a>
```

#### 3. Actions
**Marker Format:** `<!--action:begin-->ACTION_NAME param1="value1" param2=value2<!--action:end-->`

**Processing:**
- Extracts action name and parameters
- Parses parameters (handles quoted values and unquoted values)
- Checks if action is in whitelist (via `ACTION4DIFF` constant)
- Calls `$wacko->action()` to execute the action
- Returns generated content (or placeholder if action not allowed)

**Parameter Parsing:**
```
{{include page="MyPage" notoc=1 limit=5}}
↓
$action = 'include'
$params = [
  0 => 'MyPage',       // positional
  'page' => 'MyPage',  // named
  1 => 1,              // positional
  'notoc' => 1,        // named
  2 => 5,              // positional
  'limit' => 5         // named
]
```

#### 4. Formatter Marker Stripping (Optional)
If `$options['strip_marker']` is true:
- Removes `<!--noinclude-->` / `<!--/noinclude-->` markers
- Removes `<!--notypo-->` / `<!--/notypo-->` markers
- Removes `<ignore>` / `</ignore>` tags

### Workflow

```php
// In wiki.php, if post_wacko processing requested
if (isset($options['post_wacko']))
{
    $options['strip_marker'] = true;
    include Ut::join_path(FORMATTER_DIR, 'post_wacko.php');
}

// In post_wacko.php
$parser = new PostWacko($this, $options);
$text = preg_replace_callback(
    '/(<!--link:begin-->...<!--link:end-->|' .
    '<!--imglink:begin-->...<!--imglink:end-->|' .
    '<!--action:begin-->...<!--action:end-->)/usm',
    [&$parser, 'postcallback'],
    $text
);

// Optionally strip temporary markers
if ($options['strip_marker'])
{
    $text = str_replace(['<!--noinclude-->', '<!--/noinclude-->', ...], '', $text);
}
```

### Key Points
- **Deferred processing:** Links/actions not resolved until final stage
- **Database-dependent:** Requires access to page information and user permissions
- **Side-effect capable:** Actions can modify state or generate complex content
- **Safety checks:** Actions validated against whitelist
- **Optional:** Can be skipped if only static rendering needed (e.g., showing raw wiki syntax)

---

## Complete Flow Example

Let's trace a simple example through the entire pipeline:

### Input
```
== My Header ==

This is a **bold** paragraph with [[a link]].

{{include page="Template"}}
```

### After Pre-Wacko
```
== My Header ==

This is a **bold** paragraph with [[a link]].

{{include page="Template"}}
```
(unchanged; no macros or special markers)

### After Wacko Formatter
```
<h2 id="h12345-1" class="heading">My Header<a class="self-link" href="#h12345-1"></a></h2>

This is a <strong>bold</strong> paragraph with <!--link:begin-->a link==a link<!--link:end-->.

<!--action:begin-->include page="Template"<!--action:end-->
```

### After Typografica
```
<h2 id="h12345-1" class="heading">My Header<a class="self-link" href="#h12345-1"></a></h2>

This is a <strong>bold</strong> paragraph with <!--link:begin-->a link==a link<!--link:end-->.

<!--action:begin-->include page="Template"<!--action:end-->
```
(unchanged; no special typography rules triggered)

### After Paragrafica
```
<h2 id="h12345-1" class="heading">My Header<a class="self-link" href="#h12345-1"></a></h2>

<p id="p12345-1" class="auto">This is a <strong>bold</strong> paragraph with <!--link:begin-->a link==a link<!--link:end-->.</p>

<!--action:begin-->include page="Template"<!--action:end-->
```

### After Post-Wacko
```
<h2 id="h12345-1" class="heading">My Header<a class="self-link" href="#h12345-1"></a></h2>

<p id="p12345-1" class="auto">This is a <strong>bold</strong> paragraph with <a href="/a link" class="link">a link</a>.</p>

<div class="template-content">
  <!-- included template content here -->
</div>
```

---

## Architecture Decisions & Trade-offs

### Multi-Stage Design Benefits
1. **Separation of Concerns:** Each stage has a specific responsibility
2. **Debuggability:** Output of each stage can be inspected independently
3. **Extensibility:** New stages can be inserted or existing ones modified
4. **Reusability:** Stages can potentially be used in different contexts
5. **Performance:** Some stages can be cached independently

### Marker-Based Approach
- **Pro:** Defers complex decisions (link resolution, action execution) until final stage
- **Pro:** Allows clean separation between structural HTML generation and dynamic content
- **Con:** Creates temporary markers that must be carefully managed through multiple stages
- **Con:** Regex patterns must account for markers throughout the pipeline

### Preserved Sections Strategy
- **Pro:** Allows users to protect content from transformation (code, escaping)
- **Pro:** Each stage respects previous markers without conflict
- **Con:** Adds complexity to regex patterns
- **Con:** Requires careful coordination between stages

---

## Extending the Formatter

### Adding a Custom Formatter Stage

1. **Create a new class** following the pattern: `class MyFormatter { public function process(&$wacko, $text) {...} }`
2. **Insert in the pipeline** after appropriate stage (consider data dependencies)
3. **Handle markers** - respect existing formatter markers from previous stages
4. **Add to handler** - modify the show handler or renderer to call your stage

### Modifying Wiki Syntax

- Edit `WackoFormatter` class to parse new wiki syntax
- Use `<!--marker:type:name-->` to defer processing if needed
- Or handle completely in `WackoFormatter` if no dynamic dependency

### Adding Typography Rules

- Extend `Typografica::replace_specials()` or `replace_macros()`
- Add new setting to `$settings` array
- Update regex patterns to handle new language/rule

---

## Performance Considerations

1. **Regex Complexity:** Most stages are regex-heavy; optimize patterns if processing large documents
2. **Caching:** Consider caching formatter output if documents are static
3. **Stage Skipping:** If not using certain features (actions, syntax highlighting), skip those stages
4. **Memory:** Large documents with many markers may consume significant memory

---

## Debugging Tips

1. **Enable Stage Output:** Echo output after each stage to see transformations
2. **Check Marker Integrity:** Ensure markers remain balanced and properly nested
3. **Test Individual Stages:** Create test input at each stage's interface
4. **Review Regex:** Use online regex testers to verify complex patterns
5. **Trace Callback Functions:** These are often where logic errors occur

---

## Summary Table

| Stage | Input | Output | Purpose | Key Class |
|-------|-------|--------|---------|-----------|
| 1. Pre-Wacko | Raw text + macros | Text + expanded macros | Resolve user macros | `PreFormatter` |
| 2. Wacko | Text + markup | Intermediate HTML | Parse wiki syntax | `WackoFormatter` |
| 3. Typografica | Intermediate HTML | Typographic HTML | Typography rules | `Typografica` |
| 4. Paragrafica | Typographic HTML | Structured HTML | Add `<p>` tags + TOC | `Paragrafica` |
| 5. Highlighter | Structured HTML | Highlighted HTML | Syntax highlighting | (Optional) |
| 6. Post-Wacko | Marked HTML | Final HTML | Resolve links/actions | `PostWacko` |
