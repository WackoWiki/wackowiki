// src/editor/features/markup-conversion.js

/**
 * Convert WackoWiki markup to Markdown (approximate).
 * @param {string} text - Wacko markup text
 * @returns {string} Markdown text
 */
export function wackoToMarkdown(text) {
  let md = text;
  const placeholders = [];

  // 0. Handle escaped/literal text: ""text"" → text (remove escaping quotes)
  md = md.replace(/""(.*?)""/g, (match, content) => {
    placeholders.push(content);
    return `§§ESCAPED${placeholders.length - 1}§§`;
  });

  // 1. Inline code: ##text## → `text` (process BEFORE code blocks)
  md = md.replace(/##(.*?)##/g, (match, content) => {
    let restoredContent = content.replace(/§§ESCAPED(\d+)§§/g, (m, idx) => placeholders[idx]);
    placeholders.push('`' + restoredContent + '`');
    return `§§INLINECODE${placeholders.length - 1}§§`;
  });

  // 2. Tables: #| … |# and #|| … ||# → Markdown tables
  // Use placeholders to prevent other rules from processing table content
  md = md.replace(/#\|\|?[\s\S]*?\|\|?#/gs, block => {
    const mdTable = wackoTableToMarkdown(block);
    placeholders.push(mdTable);
    return `§§TABLE${placeholders.length - 1}§§`;
  });

  // 3. Fenced code blocks: %%(hl lang)\n...\n%%  →  ```lang\n...\n```
  md = md.replace(/%%(?:\(hl\s+(\w+)\)\s*)?([\s\S]*?)%%/g, (match, lang, content) => {
    const language = lang ? lang.trim() : '';
    const code = content.trim();
    const fence = language ? '```' + language + '\n' + code + '\n```'
                            : '```\n' + code + '\n```';
    placeholders.push(fence);
    return `§§CODEBLOCK${placeholders.length - 1}§§`;
  });

  // 4. Headings: === Title === → ## Title (etc.)
  md = md.replace(/^={2,7}\s*(.*?)\s*={2,}$/gm, (match, title) => {
    const level = match.match(/^=+/)[0].length;
    const marker = '#'.repeat(level - 1);
    placeholders.push(marker);
    return `§§HEADING${placeholders.length - 1}§§ ${title.trim()}`;
  });
  
  // Italic: //text// → *text*
  md = md.replace(/\/\/(.*?)\/\//g, '*\$1*');
  // Strikethrough: --text-- → ~~text~~
  md = md.replace(/--(.*?)--/g, '~~\$1~~');
  // Small text: ++text++ → <small>text</small>
  md = md.replace(/\+\+(.*?)\+\+/g, '<small>$1</small>');
  // Highlight / Marked text: ??text?? and !!text!! → **text**
  md = md.replace(/\?\?(.*?)\?\?/g, '**\$1**');
  md = md.replace(/!!(.*?)!!/g, '**\$1**');
  md = md.replace(/!!\([^)]+\)(.*?)!!/g, '$1');

  // Quote: <[ text ]> → > text
  md = md.replace(/<\[(.*?)\]>/gs, '> $1');

  // Lists: leading * → -
  md = md.replace(/^(\s*)[*-]\s+/gm, '$1- ');

  // Links: ((url text)) → [text](url)
  md = md.replace(/\(\(([^)]+?)\s+([^\)]+?)\)\)/g, '[\$2](\$1)');
  // Wiki pages: [[page]] → [page](page)
  md = md.replace(/\[\[([^\]]+?)\]\]/g, '[\$1](\$1)');

  // Horizontal rule: ---- → ---
  md = md.replace(/^----$/gm, '---');

  // Restore placeholders in order
  md = md.replace(/§§TABLE(\d+)§§/g, (match, idx) => placeholders[idx]);
  md = md.replace(/§§INLINECODE(\d+)§§/g, (match, idx) => placeholders[idx]);
  md = md.replace(/§§CODEBLOCK(\d+)§§/g, (match, idx) => placeholders[idx]);
  md = md.replace(/§§HEADING(\d+)§§/g, (match, idx) => placeholders[idx]);
  md = md.replace(/§§ESCAPED(\d+)§§/g, (match, idx) => placeholders[idx]);

  return md;
}

/**
 * Convert Markdown to WackoWiki markup (approximate).
 * @param {string} text - Markdown text
 * @returns {string} Wacko markup text
 */
export function markdownToWacko(text) {
  let w = text;
  const placeholders = [];

  // Fenced code blocks: ```lang\n...\n``` → %%(hl lang)\n...\n%%
  w = w.replace(/```(\w+)?\s*\n([\s\S]*?)```/g, (match, language, content) => {
    const lang = (language || '').trim().toLowerCase();
    const code = content.trim();
    const block = lang
      ? `%%(hl ${lang})\n${code}\n%%`
      : `%%\n${code}\n%%`;
    placeholders.push(block);
    return `§§CODEBLOCK${placeholders.length - 1}§§`;
  });

  // Inline code: `text` → ##text##
  w = w.replace(/`([^`\n]+)`/g, (match, content) => {
    placeholders.push(`##${content}##`);
    return `§§INLINECODE${placeholders.length - 1}§§`;
  });

  // Horizontal rules: ---, ***, ___ → ----
  w = w.replace(/^(?:[-*_]){3,}[ \t]*$/gm, '----');

  // Blockquote: > text → <[text]>
  w = w.replace(/^>\s+(.*)$/gm, '<[$1]>');

  // Lists: normalize indentation to Wacko conventions
  w = w.replace(
    /^(?!\s*----)(?!\s*\*\*)(\s*)([*+-]|\d+\.|[A-Za-z]\.)([ \t]*)/gm,
    (match, indent, marker, postSpace) => {
      const len = indent.length;
      let newIndent = indent;
      if (len % 4 === 0 && len >= 4) {
        newIndent = ' '.repeat(len / 2 + 2);
      } else if (len < 4) {
        newIndent = '  ';
      }
      return newIndent + marker + postSpace;
    }
  );

  // Headings: # Title → === Title === (etc.)
  w = w.replace(/^#{1,7}\s+(.*)$/gm, (match, title) => {
    const level = match.match(/^#+/)[0].length;
    const marker = '='.repeat(level + 1);
    return `${marker} ${title} ${marker}`;
  });

  // Bold: already compatible (but convert __text__ → **text**)
  w = w.replace(/__(.*?)__/g, '**\$1**');

  // Italic: *text* → //text//
  w = w.replace(
    /(^|[^*\w])\*(?!\*)([^*\s][^*]*[^*\s])\*(?![*\w])/g,
    '\$1//\$2//'
  );
  w = w.replace(
    /(^|[^*\w])\*(?!\*)([^*\s])\*(?![*\w])/g,
    '\$1//\$2//'
  );

  // Italic: _text_ → //text//
  w = w.replace(
    /(^|[^_\w])_(?!_)([^_\s][^_]*[^_\s])_(?![_\w])/g,
    '\$1//\$2//'
  );
  w = w.replace(
    /(^|[^_\w])_(?!_)([^_\s])_(?![_\w])/g,
    '\$1//\$2//'
  );

  // Strikethrough: ~~text~~ → --text--
  w = w.replace(/~~(.*?)~~/g, '--\$1--');
  // Small text: <small>text</small> → ++text++
  w = w.replace(/<small>(.*?)<\/small>/g, '++$1++');

  // Images: ![alt](url) → ((url alt))
  w = w.replace(/!\[([^\]]*)\]\(([^)]+)\)/g, '((\$2 \$1))');

  // Links: [text](url) → ((url text))
  w = w.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '((\$2 \$1))');

  // Tables: Markdown table blocks → Wacko table
  w = w.replace(
    /^(?:\|.*\|\n\|[-:\s|]+\|\n(?:\|.*\|\n?)+)/gm,
    block => markdownTableToWacko(block)
  );

  // Restore code blocks and inline code placeholders
  w = w.replace(/§§CODEBLOCK(\d+)§§/g, (match, idx) => placeholders[idx]);
  w = w.replace(/§§INLINECODE(\d+)§§/g, (match, idx) => placeholders[idx]);

  return w;
}

/**
 * Convert a single Wacko table block (#| … |#) to Markdown.
 * @param {string} block - Wacko table block
 * @returns {string} Markdown table
 */
function wackoTableToMarkdown(block) {
  // First, convert inline %%(hl lang) ... %% within table cells to inline code
  let processedBlock = block.replace(/%%\(hl\s+(\w+)\)\s*(.*?)%%/g, (match, lang, code) => {
    return '`' + code.trim() + '`';
  });
  // Also handle simple %% ... %% 
  processedBlock = processedBlock.replace(/%%(.+?)%%/g, (match, code) => {
    return '`' + code.trim() + '`';
  });

  const lines = processedBlock.split(/\r?\n/).filter(l => l.trim());
  const mdRows = [];
  let headerRow = null;

  // Helper function to apply inline formatting to cell content
  const formatCellContent = (content) => {
    // Handle escaped/literal text
    content = content.replace(/""(.*?)""/g, '\$1');
    
    // Inline code (already handled above, but just in case)
    content = content.replace(/##(.*?)##/g, '`\$1`');
    
    // Italic
    content = content.replace(/\/\/(.*?)\/\//g, '*$1*');
    
    // Bold (Wacko uses ** or !!)
    content = content.replace(/\*\*(.*?)\*\*/g, '**\$1**');
    
    // Strikethrough
    content = content.replace(/--(.*?)--/g, '~~\$1~~');
    
    // Small text
    content = content.replace(/\+\+(.*?)\+\+/g, '<small>$1</small>');
    
    // Highlight/Marked
    content = content.replace(/\?\?(.*?)\?\?/g, '**\$1**');
    content = content.replace(/!!(.*?)!!/g, '**\$1**');
    content = content.replace(/!!\([^)]+\)(.*?)!!/g, '$1');
    
    // Links
    content = content.replace(/\(\(([^)]+?)\s+([^\)]+?)\)\)/g, '[\$2](\$1)');
    content = content.replace(/\[\[([^\]]+?)\]\]/g, '[\$1](\$1)');
    
    return content;
  };

  for (let line of lines) {
    line = line.trim();
    
    // Skip opening/closing markers
    if (line === '#|' || line === '#||' || line === '|#' || line === '||#') continue;

    let isHeader = false;
    if (line.startsWith('*|') || line.endsWith('|*')) {
      isHeader = true;
      // Remove header markers
      line = line.replace(/^\*\|?\s*/, '').replace(/\s*\|?\*$/, '');
    } else {
      // Remove row markers
      line = line.replace(/^\|?\|\s*/, '').replace(/\s*\|\|?\s*$/, '');
    }

    // Strip cell attributes like (colspan=2 align=center)
    line = line.replace(/\(\s*[^)]+\)\s*/g, '');

    // Handle escaped pipes "" → escaped pipe in Markdown
    line = line.replace(/""/g, '\\|');

    // Split into cells and apply formatting to each cell
    const cells = line.split('|').map(cell => {
      return formatCellContent(cell.trim());
    });
    
    if (cells.length < 1) continue;

    if (isHeader) {
      headerRow = '| ' + cells.join(' | ') + ' |';
    } else {
      mdRows.push('| ' + cells.join(' | ') + ' |');
    }
  }

  // Build markdown table
  let mdTable = '';
  if (headerRow) {
    mdTable += headerRow + '\n';
    // Count actual columns in header
    const cols = headerRow.split('|').filter(c => c.trim()).length;
    mdTable += '| ' + Array(cols).fill('---').join(' | ') + ' |\n';
  }
  mdTable += mdRows.join('\n');

  return mdTable;
}

/**
 * Convert a single Markdown table block to Wacko table.
 * @param {string} block - Markdown table block
 * @returns {string} Wacko table
 */
function markdownTableToWacko(block) {
  const lines = block.trim().split(/\r?\n/);
  if (lines.length < 3) return block; // not a valid table

  let wacko = '#|\n';

  /**
   * Split a Markdown table row into cells.
   * Drops only the empty first/last entries produced by the surrounding
   * `|` pipes, preserving empty cells inside the row.
   */
  const splitRow = (line) => {
    const parts = line.split('|').map(c => c.trim());
    if (parts.length && parts[0] === '') parts.shift();
    if (parts.length && parts[parts.length - 1] === '') parts.pop();
    return parts;
  };

  const headerCells = splitRow(lines[0]);
  if (headerCells.length) {
    wacko += '*| ' + headerCells.join(' | ') + ' |*\n';
  }

  // Skip separator line (lines[1])
  for (let i = 2; i < lines.length; i++) {
    const cells = splitRow(lines[i]);
    if (cells.length) {
      wacko += '|| ' + cells.join(' | ') + ' ||\n';
    }
  }

  wacko += '|#\n';
  return wacko;
}
