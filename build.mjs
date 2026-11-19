#!/usr/bin/env node
// build.mjs — WikiEdit release bundler
//
// ─────────────────────────────────────────────────────────────────────────────
//  Bundling rules
// ─────────────────────────────────────────────────────────────────────────────
//  1) WikiEdit bundle → <out>/wikiedit.min.js
//     Entry point : <js>/main.js
//     Content     : <js>/editor/**  +  the WikiEdit-only helpers
//                   utils/{logger,storage,time}.js
//     Anything else that ends up in this bundle is reported as a warning.
//
//  2) Standalone script → <out>/editor/toolbar/toolbar-customizer.js
//     The toolbar customizer is not part of WikiEdit (own page/script).
//     It keeps its folder AND its filename in the source tree —
//     NO ".min" suffix is added, the name stays exactly as it is.
//
//  3) Static assets (loaded elsewhere)
//     components/, core/, utils/clipboard.js → minified, SAME filename/path
//     lang/                                → minified (own build step)
//     CSS inside the JS tree               → minified, SAME filename/path
//     external/                            → copied 1:1 (third party, untouched)
//
//  4) Theme assets   (source folder: <repo>/src/theme)
//     src/theme/**/*.css                   → minified into <theme-out>,
//                                             folder structure preserved
//     all other theme files (php, tpl, …)   → copied 1:1
//
//  5) Rescue pass
//     If a shipped static file imports a helper that only exists inside the
//     bundle (e.g. core/init-usersettings.js → ../utils/storage.js), that
//     helper is shipped AGAIN as a standalone static asset (minified) so the
//     import resolves at runtime.
//
//  Options
//    --js=<dir>            source folder with the JS sources (default: <repo>/src/js)
//    --out=<dir>           output folder for the built JS   (default: <repo>/dist/js)
//    --theme=<dir>         source theme folder               (default: <repo>/src/theme)
//    --theme-out=<dir>     output folder for the built theme (default: <repo>/dist/theme)
//    --manifest=<file>     write a JSON manifest (size + sha256 + SRI per file)
//    --commit=<sha>        source commit, recorded in the manifest
//    --keep=<relpath>      additionally ship a source file verbatim (repeatable)
//    --dev                 no minification, inline source maps
//    --watch               rebuild on change
//    --with-sources        also ship the raw sources of the bundled files
//    --with-source-maps    emit .map files for the static assets
//    --strict              exit with code 1 when a check reports a problem
// ─────────────────────────────────────────────────────────────────────────────

import * as esbuild from 'esbuild';
import { mkdir, rm, cp, readdir, stat, readFile, writeFile } from 'node:fs/promises';
import { join, resolve, relative, dirname, sep, isAbsolute } from 'node:path';
import { createHash } from 'node:crypto';

const ROOT = resolve(import.meta.dirname);

/* ──────────────────────────────────────────────────────────────
 * Command line
 * ────────────────────────────────────────────────────────────── */
const opts = {
  js: null, out: null, manifest: null, commit: null,
  theme: null, themeOut: null,
  dev: false, watch: false, strict: false,
  withSources: false, withSourceMaps: false,
  keep: []
};

const USAGE = `build.mjs — WikiEdit release bundler

  node build.mjs [--dev] [--watch] [--strict]
                 [--js=<dir>] [--out=<dir>] [--manifest=<file>]
                 [--commit=<sha>] [--keep=<relpath>]
                 [--theme=<dir>] [--theme-out=<dir>]
                 [--with-sources] [--with-source-maps]`;

// Options that take a value. The value is always taken after the FIRST "=",
// so no manual index arithmetic (and no off-by-one bugs) can happen.
const VALUE_OPTIONS = {
  '--js':        'js',
  '--out':       'out',
  '--theme':     'theme',
  '--theme-out': 'themeOut',
  '--manifest':  'manifest',
  '--commit':    'commit',
  '--keep':      'keep'
};

for (const arg of process.argv.slice(2)) {
  if (arg === '--dev') opts.dev = true;
  else if (arg === '--watch') opts.watch = true;
  else if (arg === '--strict') opts.strict = true;
  else if (arg === '--with-sources') opts.withSources = true;
  else if (arg === '--with-source-maps') opts.withSourceMaps = true;
  else if (arg === '--help' || arg === '-h') { console.log(USAGE); process.exit(0); }
  else {
    const eq    = arg.indexOf('=');
    const key   = eq === -1 ? arg : arg.slice(0, eq);
    const value = eq === -1 ? '' : arg.slice(eq + 1);
    const prop  = VALUE_OPTIONS[key];

    if (!prop) {
      console.error(`build: unknown option "${arg}"\n${USAGE}`);
      process.exit(1);
    }

    if (prop === 'keep') {
      if (!value) {
        console.error(`build: --keep needs a path\n${USAGE}`);
        process.exit(1);
      }
      opts.keep.push(value);
    } else {
      opts[prop] = value;
    }
  }
}

const SRC       = resolve(opts.js       ?? join(ROOT, 'src', 'js'));
const DIST      = resolve(opts.out      ?? join(ROOT, 'dist', 'js'));
const THEME_SRC = resolve(opts.theme    ?? join(ROOT, 'src', 'theme'));   // <repo>/src/theme
const THEME_OUT = resolve(opts.themeOut ?? join(ROOT, 'dist', 'theme'));  // <repo>/dist/theme

/* ──────────────────────────────────────────────────────────────
 * Scope configuration
 * ────────────────────────────────────────────────────────────── */
const ENTRY          = 'main.js';                                // WikiEdit entry point
const STANDALONE     = ['editor/toolbar/toolbar-customizer.js']; // own bundle, own folder + own name
const WIKIEDIT_UTILS = ['logger.js', 'storage.js', 'time.js'];   // bundled, never static
const LANG_DIR       = 'lang';                                   // handled by buildLang()
const EXTERNAL_DIR   = 'external';                               // copied 1:1, never rebuilt
const SOURCES_DIR    = '_sources';                               // raw sources (--with-sources)

// Files that must NOT be parsed/rebuilt (non-standard JS, legacy scripts, …)
// → copied verbatim. Example: ['components/legacy-widget.js']
const STATIC_PASSTHROUGH = [];

/* ──────────────────────────────────────────────────────────────
 * Small helpers
 * ────────────────────────────────────────────────────────────── */
const toPosix = (p) => p.split(sep).join('/');
const relSrc  = (p) => toPosix(relative(SRC, p));
const relRoot = (p) => toPosix(relative(ROOT, p));

// true when "child" is located inside "parent"
const isInside = (parent, child) => {
  const rel = relative(parent, child);
  return rel !== '' && !rel.startsWith('..') && !isAbsolute(rel);
};

const problems = [];   // collected warnings, fatal with --strict

async function exists(p) {
  try { await stat(p); return true; } catch { return false; }
}

// true only for regular files (a directory is NOT a valid import target)
async function isFile(p) {
  try { return (await stat(p)).isFile(); } catch { return false; }
}

async function walkFiles(dir) {
  const out = [];
  for (const entry of await readdir(dir, { withFileTypes: true })) {
    const full = join(dir, entry.name);
    if (entry.isDirectory()) out.push(...await walkFiles(full));
    else out.push(full);
  }
  return out;
}

async function copyFile(from, to) {
  await mkdir(dirname(to), { recursive: true });
  await cp(from, to);
}

/* ──────────────────────────────────────────────────────────────
 * Collect the scope: bundled / standalone / static
 * ────────────────────────────────────────────────────────────── */
async function collectScope() {
  const bundled    = new Set();   // rel. paths compiled into the WikiEdit bundle
  const standalone = new Set();   // rel. paths built as their own bundle

  const editorDir = join(SRC, 'editor');
  if (await exists(editorDir)) {
    for (const file of await walkFiles(editorDir)) {
      const r = relSrc(file);
      if (!r.endsWith('.js')) continue;
      if (STANDALONE.includes(r)) standalone.add(r);
      else bundled.add(r);                       // everything under editor/ is WikiEdit code
    }
  }

  // WikiEdit-only helpers: src/js/utils (current) or src/js/editor/utils (recommended)
  for (const name of WIKIEDIT_UTILS) {
    let found = false;
    for (const dir of [join(SRC, 'utils'), join(SRC, 'editor', 'utils')]) {
      const file = join(dir, name);
      if (await exists(file)) {
        bundled.add(relSrc(file));
        found = true;
        break;
      }
    }
    if (!found) console.warn(`build: WikiEdit helper "${name}" not found — skipped`);
  }

  return { bundled, standalone };
}

/* ──────────────────────────────────────────────────────────────
 * Shared options
 * ────────────────────────────────────────────────────────────── */
const base = {
  bundle: true,
  format: 'iife',            // plain <script src> works, no type="module"
  target: ['es2023'],
  platform: 'browser',
  charset: 'utf8',
  logLevel: 'info',
  minify: !opts.dev,
  keepNames: true,           // keeps Function/class .name (feature detection)
  sourcemap: opts.dev ? 'inline' : false,
  legalComments: 'none',
  define: {
    'process.env.NODE_ENV': JSON.stringify(opts.dev ? 'development' : 'production')
  },
  banner: {
    js: '/*! WikiEdit v3.26 | BSD-3-Clause | (c) WackoWiki Team */'
  },
  // Libs loaded by their own <script> tag stay external.
  // e.g. external: ['jquery']
  external: [],
  absWorkingDir: SRC,        // metafile paths are relative to the js source folder
  metafile: true             // used for the scope check below
};

// Shared CSS options — CSS is minified, but @import/url() are left untouched
// (bundle:false → relative paths and imports stay valid).
function cssOptions(extra = {}) {
  return {
    bundle: false,
    minify: !opts.dev,
    target: ['es2023'],
    charset: 'utf8',
    legalComments: 'inline',    // keep /*! licence headers
    sourcemap: opts.dev ? 'inline' : (opts.withSourceMaps ? 'linked' : false),
    logLevel: 'warning',
    ...extra
  };
}

// Options for a single JS file that is minified in place (same path/name).
function staticJsOptions(file, outfile) {
  return {
    entryPoints: [file],
    outfile,
    bundle: false,          // no import rewriting → relative imports stay valid
    minify: !opts.dev,
    keepNames: true,        // keeps Function/class .name (feature detection)
    target: ['es2023'],
    platform: 'browser',
    charset: 'utf8',        // do not escape non-ASCII
    legalComments: 'inline',// keep /*! licence headers
    sourcemap: opts.dev ? 'inline' : (opts.withSourceMaps ? 'linked' : false),
    logLevel: 'silent'
    // no `format` → script stays a script, module stays a module
  };
}

/* ──────────────────────────────────────────────────────────────
 * Entry points → one bundle each
 * ────────────────────────────────────────────────────────────── */
function buildEntries(scope) {
  const entries = [
    // The WikiEdit bundle: editor/** + utils/{logger,storage,time}.js
    { in: join(SRC, ENTRY), outfile: join(DIST, 'wikiedit.min.js') }
  ];

  // Standalone scripts keep their original folder AND their original filename:
  // src/js/editor/toolbar/toolbar-customizer.js
  //   → dist/js/editor/toolbar/toolbar-customizer.js     (name unchanged!)
  for (const r of scope.standalone) {
    entries.push({ in: join(SRC, r), outfile: join(DIST, r) });
  }

  return entries;
}

/* ──────────────────────────────────────────────────────────────
 * Scope check — the WikiEdit bundle may only contain
 * editor/** + the WikiEdit-only helpers (+ main.js itself)
 * ────────────────────────────────────────────────────────────── */
function checkBundleScope(metafile) {
  const unexpected = [];

  for (const input of Object.keys(metafile.inputs)) {
    const abs = isAbsolute(input) ? input : resolve(SRC, input);
    const r   = relSrc(abs);

    if (r.startsWith('..')) continue;                     // outside the js folder (node_modules…)
    if (r === ENTRY) continue;                            // the entry point itself
    if (r.startsWith('editor/')) continue;                // editor code ✔
    if (/(^|\/)utils\//.test(r) && WIKIEDIT_UTILS.includes(r.split('/').pop())) continue; // WikiEdit helpers ✔

    unexpected.push(r);
  }

  if (unexpected.length) {
    console.warn('build: WARNING — the WikiEdit bundle contains files outside editor/:');
    for (const r of unexpected) console.warn(`  • ${r}`);
    console.warn('build: those files must be static assets, not part of the WikiEdit bundle.');
    problems.push(`${unexpected.length} file(s) outside editor/ in the WikiEdit bundle`);
  }
}

/* ──────────────────────────────────────────────────────────────
 * CSS diagnostics
 *   esbuild reports CSS parse problems as warnings and still writes the
//   file. To make them actionable, the source is scanned for unbalanced
//   braces (the usual reason for "Unexpected \"@media\"" and friends).
// ────────────────────────────────────────────────────────────── */
function scanCssStructure(code) {
  const findings = [];
  const stack = [];          // line numbers of the currently open blocks
  let line = 1;
  let i = 0;
  let inComment = false;
  let quote = null;
  const len = code.length;

  while (i < len) {
    const ch   = code[i];
    const next = i + 1 < len ? code[i + 1] : '';

    if (ch === '\n') { line++; i++; continue; }

    if (inComment) {
      if (ch === '*' && next === '/') { inComment = false; i += 2; continue; }
      i++; continue;
    }

    if (quote) {
      if (ch === '\\') { i += 2; continue; }
      if (ch === quote) quote = null;
      i++; continue;
    }

    if (ch === '/' && next === '*') { inComment = true; i += 2; continue; }
    if (ch === '"' || ch === "'") { quote = ch; i++; continue; }

    if (ch === '{') { stack.push(line); i++; continue; }

    if (ch === '}') {
      if (!stack.length) findings.push({ type: 'extra-close', line });
      else stack.pop();
      i++; continue;
    }

    if (ch === '@') {
      let j = i + 1;
      let name = '';
      while (j < len && /[A-Za-z0-9_-]/.test(code[j])) { name += code[j]; j++; }
      if (name) {
        findings.push({ type: 'at-rule', name, line, depth: stack.length });
        i = j; continue;
      }
    }

    i++;
  }

  if (stack.length) {
    findings.push({ type: 'unclosed', line: stack[0], count: stack.length });
  }

  return findings;
}

async function reportCssStructure(file, warning) {
  let code = '';
  try { code = await readFile(file, 'utf8'); } catch { return; }

  const findings = scanCssStructure(code);
  const rel = relRoot(file);

  console.warn(`build: CSS source analysis for ${rel}:`);

  const extraClose = findings.find(f => f.type === 'extra-close');
  const unclosed   = findings.find(f => f.type === 'unclosed');

  if (extraClose) {
    console.warn(`  • line ${extraClose.line}: a "}" closes a block that was never opened`);
  }
  if (unclosed) {
    console.warn(`  • line ${unclosed.line}: a block is opened here but never closed (${unclosed.count} level(s) still open)`);
    console.warn(`    → most likely a missing "}" — everything after line ${unclosed.line} is parsed inside this block`);
  }

  if (warning?.location?.line) {
    const atRules = findings.filter(f => f.type === 'at-rule' && f.line === warning.location.line);
    for (const a of atRules) {
      console.warn(`  • line ${a.line}: @${a.name} is encountered at nesting depth ${a.depth}`);
    }
  }

  if (!extraClose && !unclosed) {
    console.warn(`  • braces are balanced - the problem is a different CSS syntax error`);
  }
  console.warn(`  → fix the source file, then rebuild (the build continues with the minified output)`);
}

/* ──────────────────────────────────────────────────────────────
 * Build a single CSS file (minified, same path/name).
 * A hard error never aborts the release: the original file is copied
 * instead and the problem is reported (fatal with --strict).
 * ────────────────────────────────────────────────────────────── */
async function buildCssFile(file, dest) {
  try {
    const result = await esbuild.build({
      entryPoints: [file],
      outfile: dest,
      ...cssOptions({ logLevel: 'silent' })
    });

    for (const w of result.warnings || []) {
      const isSyntax = (w.text || '').includes('css-syntax-error');
      const where = w.location
        ? `${w.location.file}:${w.location.line}:${w.location.column}`
        : relRoot(file);
      console.warn(`build: CSS warning in ${where}: ${w.text}`);
      if (isSyntax) await reportCssStructure(file, w);
    }

    return true;
  } catch (err) {
    const msgs = (err && err.errors)
      ? err.errors.map(e => e.text).join('; ')
      : String(err);
    console.error(`build: CSS build failed for ${relRoot(file)}: ${msgs}`);
    await reportCssStructure(file, null);

    // Fall back to the original file so the release is never incomplete
    await copyFile(file, dest);
    problems.push(`CSS build failed: ${relRoot(file)}`);
    return false;
  }
}

/* ──────────────────────────────────────────────────────────────
 * Language files — loaded at runtime, NOT bundled
 * ────────────────────────────────────────────────────────────── */
async function buildLang() {
  const langSrc = join(SRC, LANG_DIR);
  const langOut = join(DIST, LANG_DIR);
  await mkdir(langOut, { recursive: true });

  const files = (await readdir(langSrc)).filter(f => f.endsWith('.js'));

  for (const file of files) {
    await esbuild.build({
      entryPoints: [join(langSrc, file)],
      outfile: join(langOut, file),
      bundle: false,          // keep the file standalone
      minify: !opts.dev,
      target: ['es2023'],
      charset: 'utf8',
      logLevel: 'silent',
      legalComments: 'inline'
      // no `format` → the original script/module nature is preserved
    });
  }
  console.log(`lang: ${files.length} files`);
}

/* ──────────────────────────────────────────────────────────────
 * Static assets
 *   • own JS (components/, core/, utils/clipboard.js, …)
//       → minified, written to the SAME path/filename so every
//         existing reference in PHP/templates keeps working
//   • own CSS (… .css inside the JS tree)
//       → minified, SAME path/filename as well
//   • third-party (external/) and non-JS/non-CSS files → copied 1:1
// ────────────────────────────────────────────────────────────── */
async function buildStatic(scope) {
  let minified    = 0;
  let cssMinified = 0;
  let copied      = 0;

  for (const file of await walkFiles(SRC)) {
    const r = relSrc(file);

    // --- already handled by other steps -------------------------------
    if (r.startsWith(LANG_DIR + '/')) continue;             // buildLang()
    if (r === ENTRY) {                                       // bundle entry point
      if (opts.withSources) await copyFile(file, join(DIST, SOURCES_DIR, r));
      continue;
    }
    if (scope.bundled.has(r) || scope.standalone.has(r)) {   // compiled into a bundle
      // raw sources go to _sources/ so they never overwrite the built file
      // (the standalone now keeps its original name → same path as the bundle)
      if (opts.withSources) await copyFile(file, join(DIST, SOURCES_DIR, r));
      continue;
    }

    const dest = join(DIST, r);
    const isJs  = r.endsWith('.js');
    const isCss = r.endsWith('.css');

    // --- verbatim: third-party, non-JS/CSS, or explicitly excluded ---
    const verbatim =
      r.startsWith(EXTERNAL_DIR + '/') ||
      (!isJs && !isCss) ||
      STATIC_PASSTHROUGH.includes(r);

    if (verbatim) {
      await copyFile(file, dest);
      copied++;
      continue;
    }

    // --- own CSS → minify in place (same path, same name) -------------
    if (isCss) {
      if (await buildCssFile(file, dest)) cssMinified++;
      continue;
    }

    // --- own JS → minify in place (same path, same name) -------------
    await esbuild.build(staticJsOptions(file, dest));
    minified++;
  }

  console.log(`static: ${minified} JS minified, ${cssMinified} CSS minified, ${copied} files copied`);
}

/* ──────────────────────────────────────────────────────────────
 * Theme assets (source: <repo>/src/theme) — CSS is minified,
// everything else is copied 1:1
 *   src/theme/_common/X11colors.css    → dist/theme/_common/X11colors.css
//   src/theme/default/css/default.css  → dist/theme/default/css/default.css
// ────────────────────────────────────────────────────────────── */
async function resetThemeOut() {
  if (!await exists(THEME_SRC)) {
    console.warn(`build: theme folder not found: ${THEME_SRC} — skipped`);
    return false;
  }
  if (THEME_OUT === THEME_SRC || isInside(THEME_OUT, THEME_SRC)) {
    console.error(`build: refusing to use "${THEME_OUT}" as theme output (it would delete the theme source)`);
    problems.push('invalid theme output folder');
    return false;
  }
  // never wipe the JS source folder
  if (THEME_OUT === SRC || isInside(SRC, THEME_OUT)) {
    console.error(`build: refusing to use "${THEME_OUT}" as theme output (it would delete the JS source folder)`);
    problems.push('invalid theme output folder');
    return false;
  }
  await rm(THEME_OUT, { recursive: true, force: true });
  await mkdir(THEME_OUT, { recursive: true });
  return true;
}

async function collectTheme() {
  const css = [];
  const other = [];
  for (const file of await walkFiles(THEME_SRC)) {
    if (isInside(THEME_OUT, file)) continue;      // never re-read the output folder
    if (file.endsWith('.css')) css.push(file);
    else other.push(file);
  }
  return { css, other };
}

async function copyThemeFiles(files) {
  for (const file of files) {
    await copyFile(file, join(THEME_OUT, relative(THEME_SRC, file)));
  }
}

// Build the theme CSS file by file: one broken file must not stop the
// others, and the log tells exactly which file caused a problem.
async function buildThemeCss(cssFiles) {
  if (!cssFiles.length) return 0;

  let ok = 0;
  for (const file of cssFiles) {
    const dest = join(THEME_OUT, relative(THEME_SRC, file));
    await mkdir(dirname(dest), { recursive: true });
    if (await buildCssFile(file, dest)) ok++;
  }

  console.log(`theme: ${ok}/${cssFiles.length} CSS minified → ${THEME_OUT}`);
  return ok;
}

/* ──────────────────────────────────────────────────────────────
 * Check: every relative import of a shipped file must still exist
 * (catches static files importing a helper that now only lives
 *  inside the WikiEdit bundle)
 * ────────────────────────────────────────────────────────────── */
const STATIC_IMPORT_RE = /(?:^|[\s;])(?:import|export)\s+(?:[^'"]*?\sfrom\s*)?['"]([^'"]+)['"]/g;
const DYNAMIC_IMPORT_RE = /\bimport\s*\(\s*['"]([^'"]+)['"]\s*\)/g;

function collectImportSpecs(code) {
  const specs = new Set();
  for (const m of code.matchAll(STATIC_IMPORT_RE)) specs.add(m[1]);
  for (const m of code.matchAll(DYNAMIC_IMPORT_RE)) specs.add(m[1]);
  return specs;
}

// Resolve a relative import specifier to the existing file (if any).
async function resolveImport(file, spec) {
  const base = resolve(dirname(file), spec);
  const candidates = [base, `${base}.js`, join(base, 'index.js')];
  for (const c of candidates) {
    if (await isFile(c)) return c;
  }
  return null;
}

async function checkStaticImports() {
  const broken = [];

  for (const file of await walkFiles(DIST)) {
    const rel = toPosix(relative(DIST, file));
    if (!rel.endsWith('.js')) continue;
    if (rel.startsWith(EXTERNAL_DIR + '/')) continue;
    if (rel.startsWith(SOURCES_DIR + '/')) continue;

    const code = await readFile(file, 'utf8');
    const specs = collectImportSpecs(code);

    for (const spec of specs) {
      if (!spec.startsWith('.')) continue;              // bare module → not our business
      if (await resolveImport(file, spec)) continue;    // already resolvable
      broken.push(`${rel} → ${spec}`);
    }
  }

  if (broken.length) {
    console.warn('build: WARNING — shipped files import something that is not shipped:');
    for (const b of broken) console.warn(`  • ${b}`);
    problems.push(`${broken.length} dangling import(s) in the shipped assets`);
  }
}

/* ──────────────────────────────────────────────────────────────
 * Rescue pass
 *   A shipped static file may import a helper that is compiled into
 *   the WikiEdit bundle and therefore not shipped as a file, e.g.
 *     core/init-usersettings.js → ../utils/storage.js
 *   Such a helper is shipped AGAIN as a standalone static asset
 *   (minified, same relative path) so the import resolves at runtime.
 * ────────────────────────────────────────────────────────────── */
async function findBundledHelper(scope, expectedRel) {
  // 1) exact match in the source tree
  const exact = join(SRC, expectedRel);
  if (scope.bundled.has(expectedRel) && await isFile(exact)) return exact;

  // 2) same file name somewhere in the bundled set
  //    (e.g. the helper lives in editor/utils/storage.js but the static
  //     file imports ../utils/storage.js)
  const base = expectedRel.split('/').pop();
  for (const r of scope.bundled) {
    if (r.split('/').pop() !== base) continue;
    const f = join(SRC, r);
    if (await isFile(f)) return f;
  }

  return null;
}

async function rescueBundledImports(scope) {
  let rescued = 0;

  for (const file of await walkFiles(DIST)) {
    if (!file.endsWith('.js')) continue;

    const rel = toPosix(relative(DIST, file));
    if (rel.startsWith(EXTERNAL_DIR + '/')) continue;
    if (rel.startsWith(SOURCES_DIR + '/')) continue;

    const code = await readFile(file, 'utf8');
    const specs = collectImportSpecs(code);

    for (const spec of specs) {
      if (!spec.startsWith('.')) continue;              // bare module → not our business
      if (await resolveImport(file, spec)) continue;    // already resolvable

      // Expected location of the imported file inside the output tree
      const expectedDist = resolve(dirname(file), spec);
      const relFromDist  = toPosix(relative(DIST, expectedDist));
      if (relFromDist.startsWith('..')) continue;

      const helper = await findBundledHelper(scope, relFromDist);
      if (!helper) continue;

      // Ship the helper (minified) at the expected path
      await mkdir(dirname(expectedDist), { recursive: true });
      await esbuild.build(staticJsOptions(helper, expectedDist));

      console.log(`build: shipped bundled helper for static import: ${relFromDist}`);
      rescued++;
    }
  }

  if (rescued) console.log(`rescue: ${rescued} bundled helper(s) shipped as static assets`);
  return rescued;
}

/* ──────────────────────────────────────────────────────────────
 * Files that should be shipped verbatim although they are bundled
 * (--keep=main.js etc.)
 * ────────────────────────────────────────────────────────────── */
async function applyKeep() {
  for (const rel of opts.keep) {
    const src = join(SRC, rel);
    if (!await exists(src)) {
      console.warn(`build: --keep="${rel}" not found — skipped`);
      continue;
    }
    await copyFile(src, join(DIST, rel));
    console.log(`keep: ${rel}`);
  }
}

/* ──────────────────────────────────────────────────────────────
 * Manifest — sizes + hashes + SRI for every shipped file
 * ────────────────────────────────────────────────────────────── */
async function writeManifest(file) {
  const files = {};

  const addDir = async (dir, prefix) => {
    if (!await exists(dir)) return;
    for (const f of await walkFiles(dir)) {
      const rel = prefix + toPosix(relative(dir, f));
      const buf = await readFile(f);
      files[rel] = {
        bytes: buf.length,
        sha256: createHash('sha256').update(buf).digest('hex'),
        sri: 'sha384-' + createHash('sha384').update(buf).digest('base64')
      };
    }
  };

  await addDir(DIST, '');
  // theme files are part of the manifest as well (unless they already live inside DIST)
  if (!isInside(DIST, THEME_OUT) && !isInside(THEME_OUT, DIST)) {
    await addDir(THEME_OUT, 'theme/');
  }

  const manifest = {
    generatedAt: new Date().toISOString(),
    sourceCommit: opts.commit || null,
    files
  };

  await mkdir(dirname(file), { recursive: true });
  await writeFile(file, JSON.stringify(manifest, null, 2) + '\n');
  console.log(`manifest: ${file}`);
  return manifest;
}

/* ──────────────────────────────────────────────────────────────
 * Run
 * ────────────────────────────────────────────────────────────── */
if (!await exists(SRC)) {
  console.error(`build: source folder not found: ${SRC}`);
  process.exit(1);
}

const scope = await collectScope();
const entries = buildEntries(scope);

await rm(DIST, { recursive: true, force: true });
await mkdir(DIST, { recursive: true });

// ── theme: validate + wipe output, copy non-CSS files ─────────
const themeOk = await resetThemeOut();
const theme = themeOk ? await collectTheme() : { css: [], other: [] };
if (themeOk) await copyThemeFiles(theme.other);

const options = entries.map(e => ({
  ...base,
  entryPoints: [e.in],
  outfile: e.outfile
}));

if (opts.watch) {
  const contexts = await Promise.all(options.map(o => esbuild.context(o)));
  const results  = await Promise.all(contexts.map(c => c.rebuild()));
  checkBundleScope(results[0].metafile);            // results[0] = WikiEdit bundle
  await Promise.all(contexts.map(c => c.watch()));
  console.log('watching…');
} else {
  const results = await Promise.all(options.map(o => esbuild.build(o)));
  checkBundleScope(results[0].metafile);            // results[0] = WikiEdit bundle
}

await buildLang();
await buildStatic(scope);
await buildThemeCss(theme.css);
await rescueBundledImports(scope);
await applyKeep();
await checkStaticImports();

if (opts.manifest) {
  await writeManifest(resolve(opts.manifest));
}

console.log(`bundle: ${entries.map(e => toPosix(relative(DIST, e.outfile))).join(', ')}`);

if (problems.length) {
  console.error(`build: ${problems.length} problem(s) found`);
  if (opts.strict) process.exit(1);
}
