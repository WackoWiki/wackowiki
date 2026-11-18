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
//  2) Standalone script → <out>/editor/toolbar/toolbar-customizer.min.js
//     The toolbar customizer is not part of WikiEdit (own page/script).
//     It keeps the folder it has in the source tree.
//
//  3) Static assets (loaded elsewhere)
//     components/, core/, utils/clipboard.js → minified, SAME filename/path
//     lang/                                → minified (own build step)
//     external/                            → copied 1:1 (third party, untouched)
//
//  Options
//    --js=<dir>            source folder with the JS sources (default: <repo>/src/js)
//    --out=<dir>           output folder for the built JS   (default: <repo>/dist/js)
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
  dev: false, watch: false, strict: false,
  withSources: false, withSourceMaps: false,
  keep: []
};

const USAGE = `build.mjs — WikiEdit release bundler

  node build.mjs [--dev] [--watch] [--strict]
                 [--js=<dir>] [--out=<dir>] [--manifest=<file>]
                 [--commit=<sha>] [--keep=<relpath>]
                 [--with-sources] [--with-source-maps]`;

for (const arg of process.argv.slice(2)) {
  if (arg === '--dev') opts.dev = true;
  else if (arg === '--watch') opts.watch = true;
  else if (arg === '--strict') opts.strict = true;
  else if (arg === '--with-sources') opts.withSources = true;
  else if (arg === '--with-source-maps') opts.withSourceMaps = true;
  else if (arg.startsWith('--js=')) opts.js = arg.slice(5);
  else if (arg.startsWith('--out=')) opts.out = arg.slice(6);
  else if (arg.startsWith('--manifest=')) opts.manifest = arg.slice(11);
  else if (arg.startsWith('--commit=')) opts.commit = arg.slice(9);
  else if (arg.startsWith('--keep=')) opts.keep.push(arg.slice(7));
  else if (arg === '--help' || arg === '-h') { console.log(USAGE); process.exit(0); }
  else { console.error(`build: unknown option "${arg}"\n${USAGE}`); process.exit(1); }
}

const SRC  = resolve(opts.js  ?? join(ROOT, 'src', 'js'));   // source js folder
const DIST = resolve(opts.out ?? join(ROOT, 'dist', 'js'));   // output js folder

/* ──────────────────────────────────────────────────────────────
 * Scope configuration
 * ────────────────────────────────────────────────────────────── */
const ENTRY          = 'main.js';                                // WikiEdit entry point
const STANDALONE     = ['editor/toolbar/toolbar-customizer.js']; // own bundle, own folder
const WIKIEDIT_UTILS = ['logger.js', 'storage.js', 'time.js'];   // bundled, never static
const LANG_DIR       = 'lang';                                   // handled by buildLang()
const EXTERNAL_DIR   = 'external';                               // copied 1:1, never rebuilt

// Files that must NOT be parsed/rebuilt (non-standard JS, legacy scripts, …)
// → copied verbatim. Example: ['components/legacy-widget.js']
const STATIC_PASSTHROUGH = [];

/* ──────────────────────────────────────────────────────────────
 * Small helpers
 * ────────────────────────────────────────────────────────────── */
const toPosix = (p) => p.split(sep).join('/');
const relSrc  = (p) => toPosix(relative(SRC, p));

const problems = [];   // collected warnings, fatal with --strict

async function exists(p) {
  try { await stat(p); return true; } catch { return false; }
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

/* ──────────────────────────────────────────────────────────────
 * Entry points → one bundle each
 * ────────────────────────────────────────────────────────────── */
function buildEntries(scope) {
  const entries = [
    // The WikiEdit bundle: editor/** + utils/{logger,storage,time}.js
    { in: join(SRC, ENTRY), out: 'wikiedit' }
  ];

  // Standalone scripts keep their original folder:
  // src/js/editor/toolbar/toolbar-customizer.js
  //   → dist/js/editor/toolbar/toolbar-customizer.min.js
  for (const r of scope.standalone) {
    entries.push({ in: join(SRC, r), out: r.replace(/\.js$/, '') });
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
 *       → minified, written to the SAME path/filename so every
 *         existing reference in PHP/templates keeps working
 *   • third-party (external/) and non-JS files → copied 1:1
 * ────────────────────────────────────────────────────────────── */
async function buildStatic(scope) {
  let minified = 0;
  let copied   = 0;

  for (const file of await walkFiles(SRC)) {
    const r = relSrc(file);

    // --- already handled by other steps -------------------------------
    if (r.startsWith(LANG_DIR + '/')) continue;             // buildLang()
    if (r === ENTRY) {                                       // bundle entry point
      if (opts.withSources) await copyFile(file, join(DIST, r));
      continue;
    }
    if (scope.bundled.has(r) || scope.standalone.has(r)) {   // compiled into a bundle
      if (opts.withSources) await copyFile(file, join(DIST, r));
      continue;
    }

    const dest = join(DIST, r);

    // --- verbatim: third-party, non-JS, or explicitly excluded -------
    const verbatim =
      r.startsWith(EXTERNAL_DIR + '/') ||
      !r.endsWith('.js') ||
      STATIC_PASSTHROUGH.includes(r);

    if (verbatim) {
      await copyFile(file, dest);
      copied++;
      continue;
    }

    // --- own JS → minify in place (same path, same name) -------------
    await esbuild.build({
      entryPoints: [file],
      outfile: dest,
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
    });
    minified++;
  }

  console.log(`static: ${minified} JS minified, ${copied} files copied`);
}

/* ──────────────────────────────────────────────────────────────
 * Check: every relative import of a shipped file must still exist
 * (catches static files importing a helper that now only lives
 *  inside the WikiEdit bundle)
 * ────────────────────────────────────────────────────────────── */
const STATIC_IMPORT_RE = /(?:^|[\s;])(?:import|export)\s+(?:[^'"]*?\sfrom\s*)?['"]([^'"]+)['"]/g;
const DYNAMIC_IMPORT_RE = /\bimport\s*\(\s*['"]([^'"]+)['"]\s*\)/g;

async function checkStaticImports() {
  const broken = [];

  for (const file of await walkFiles(DIST)) {
    const rel = toPosix(relative(DIST, file));
    if (!rel.endsWith('.js')) continue;
    if (rel.startsWith(EXTERNAL_DIR + '/')) continue;

    const code = await readFile(file, 'utf8');
    const specs = new Set();
    for (const m of code.matchAll(STATIC_IMPORT_RE)) specs.add(m[1]);
    for (const m of code.matchAll(DYNAMIC_IMPORT_RE)) specs.add(m[1]);

    for (const spec of specs) {
      if (!spec.startsWith('.')) continue;              // bare module → not our business
      const base = resolve(dirname(file), spec);
      const candidates = [base, `${base}.js`, join(base, 'index.js')];
      let found = false;
      for (const c of candidates) {
        if (await exists(c)) { found = true; break; }
      }
      if (!found) broken.push(`${rel} → ${spec}`);
    }
  }

  if (broken.length) {
    console.warn('build: WARNING — shipped files import something that is not shipped:');
    for (const b of broken) console.warn(`  • ${b}`);
    problems.push(`${broken.length} dangling import(s) in the shipped assets`);
  }
}

/* ──────────────────────────────────────────────────────────────
 * Files that should be shipped verbatim although they are bundled
 * (--keep=main.js etc.)
 * ────────────────────────────────────────────────────────────── */
async function applyKeep(scope) {
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

  for (const f of await walkFiles(DIST)) {
    const rel = toPosix(relative(DIST, f));
    const buf = await readFile(f);
    files[rel] = {
      bytes: buf.length,
      sha256: createHash('sha256').update(buf).digest('hex'),
      sri: 'sha384-' + createHash('sha384').update(buf).digest('base64')
    };
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

const options = entries.map(e => ({
  ...base,
  entryPoints: [e.in],
  outfile: join(DIST, `${e.out}.min.js`)
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
await applyKeep(scope);
await checkStaticImports();

if (opts.manifest) {
  await writeManifest(resolve(opts.manifest));
}

console.log(`bundle: ${entries.map(e => `${e.out}.min.js`).join(', ')}`);

if (problems.length) {
  console.error(`build: ${problems.length} problem(s) found`);
  if (opts.strict) process.exit(1);
}
