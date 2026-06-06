// src/js/core/EditorState.js

export class EditorState {
  #content = '';
  #selectionStart = 0;
  #selectionEnd = 0;
  #scrollTop = 0;
  #dirty = false;
  #modified = false;
  #listeners = new Set();

  constructor(initialContent = '') {
    this.#content = initialContent;
  }

  // Getters
  get content() { return this.#content; }
  get selection() {
    return { start: this.#selectionStart, end: this.#selectionEnd };
  }
  get scrollTop() { return this.#scrollTop; }
  get isDirty() { return this.#dirty; }
  get isModified() { return this.#modified; }

  // Main setter with reactivity
  setContent(newContent, metadata = {}) {
    if (newContent === this.#content) return false;

    const oldContent = this.#content;
    this.#content = newContent;
    this.#dirty = true;
    this.#modified = true;

    if (metadata.selection) {
      this.#selectionStart = metadata.selection.start;
      this.#selectionEnd = metadata.selection.end;
    }
    if (typeof metadata.scroll === 'number') {
      this.#scrollTop = metadata.scroll;
    }

    this.#notify({
      type: 'content',
      content: newContent,
      oldContent,
      selection: metadata.selection,
      scroll: metadata.scroll,
      _programmatic: metadata._programmatic ?? true
    });

    return true;
  }

  setSelection(start, end = start) {
    this.#selectionStart = start;
    this.#selectionEnd = end;
    this.#notify({ type: 'selection' });
  }

  markClean() {
    this.#dirty = false;
    this.#notify({ type: 'clean' });
  }

  markSaved() {
    this.#modified = false;
    this.#dirty = false;
    this.#notify({ type: 'saved' });
  }

  subscribe(listener) {
    this.#listeners.add(listener);
    return () => this.#listeners.delete(listener); // unsubscribe
  }

  #notify(change) {
    for (const listener of this.#listeners) {
      listener(change);
    }
  }
}