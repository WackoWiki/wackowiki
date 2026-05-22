// src/js/core/EditorState.js
export class EditorState {
  #content = '';
  #selectionStart = 0;
  #selectionEnd = 0;
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
  get isDirty() { return this.#dirty; }
  get isModified() { return this.#modified; }

  // Main setter with reactivity
  setContent(newContent, pushToUndo = true) {
    if (newContent === this.#content) return false;

    const oldContent = this.#content;
    this.#content = newContent;
    this.#dirty = true;
    this.#modified = true;

    this.#notify({
      type: 'content',
      content: newContent,
      oldContent,
      pushToUndo
    });

    return true;
  }

  setSelection(start, end = start) {
    if (this.#selectionStart === start && this.#selectionEnd === end) return;
    
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