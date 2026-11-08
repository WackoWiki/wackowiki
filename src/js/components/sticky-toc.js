/**
 * WackoWiki Sticky Table of Contents
 *
 * - Builds / enhances a sidebar ToC from existing heading anchors
 *   (page body + comments).
 * - Highlights the active section via Intersection Observer.
 * - Optionally limits visible items around the active entry
 *   for very long documents.
 *
 * Does NOT replace {{toc}}; it is an independent navigation aid.
 */
(function () {
	'use strict';

	const CONFIG = {
		/** Max items shown above/below active (0 = show all) */
		neighbourLimit: 5,
		/** IntersectionObserver threshold */
		threshold: 0.15,
		/** Root margin – prefer upper portion of viewport */
		rootMargin: '-10% 0px -55% 0px',
		/**
		 * Page-body headings only (class=heading + id).
		 * Comment *section* headings are collected separately so we can
		 * interleave each comment's title first.
		 */
		pageHeadingSelector:
			'#page-show h2.heading[id], #page-show h3.heading[id], #page-show h4.heading[id], ' +
			'#page-show h5.heading[id], #page-show h6.heading[id]',
		/**
		 * Headings inside a comment body (not the comment title itself).
		 */
		commentBodyHeadingSelector:
			'.comment-text section h2.heading[id], .comment-text section h3.heading[id], ' +
			'.comment-text section h4.heading[id], ' +
			'.comment-body h2.heading[id], .comment-body h3.heading[id], .comment-body h4.heading[id]',
		/**
		 * Comment title headers – one entry per comment, gets the 💬 marker.
		 * Anchor target is the parent <li id="CommentN">.
		 */
		commentTitleSelector:
			'li.comment > article.comment-text > header.comment-title h2, ' +
			'li.comment header.comment-title h2, ' +
			'#header-comments li.comment .comment-title h2',
		/** Sidebar root */
		tocRoot: '#ww-sticky-toc',
		/** List inside sidebar */
		tocList: '#ww-sticky-toc-list',
		/** Mobile toggle button */
		tocToggle: '#ww-sticky-toc-toggle',
		/** Min headings before sidebar is shown */
		minHeadings: 2,
	};

	function qs(sel, ctx) {
		return (ctx || document).querySelector(sel);
	}

	function qsa(sel, ctx) {
		return Array.from((ctx || document).querySelectorAll(sel));
	}

	/**
	 * Extract visible heading text, stripping navigation-only anchors
	 * (.self-link, .edit-section) that are not part of the title.
	 */
	function headingText(el) {
		const clone = el.cloneNode(true);
		qsa('a.self-link, a.edit-section', clone).forEach((a) => a.remove());
		// Also drop any leftover empty anchors / pure whitespace nodes noise
		return (clone.textContent || '').replace(/\s+/g, ' ').trim();
	}

	/**
	 * Collect headings from page body and comments (in document order).
	 *
	 * Returns [{ key, id, text, level, isCommentTitle, el }, ...]
	 * - key            → unique per ToC row (never shared, even if HTML ids collide)
	 * - id             → DOM id used for href / deep links
	 * - isCommentTitle → comment H2 title (only these get 💬)
	 *
	 * If the formatter reuses the parent page_id for comment headings,
	 * multiple nodes can share the same HTML id. We still list both rows
	 * but activate only one via `key`, never by matching title text.
	 */
	/**
	 * True when the node lives inside a comment block (not the page body).
	 * Comments are often nested under #page-show, so the page selector alone
	 * would otherwise pick them up and list them twice.
	 */
	function isInsideComment(el) {
		return !!(
			el.closest('li.comment') ||
			el.closest('#header-comments') ||
			el.closest('.comment-text') ||
			el.closest('.comment-body') ||
			el.closest('[id^="Comment"]')
		);
	}

	function collectHeadings() {
		const entries = [];
		let seq = 0;
		const seen = new WeakSet(); // each heading element at most once

		const push = (partial) => {
			if (!partial.el || seen.has(partial.el)) {
				return;
			}
			seen.add(partial.el);
			entries.push({
				key: 'toc-' + seq++,
				...partial,
			});
		};

		// 1) Page body headings only – skip anything inside a comment
		qsa(CONFIG.pageHeadingSelector).forEach((el) => {
			if (isInsideComment(el)) {
				return;
			}
			const text = headingText(el);
			if (!el.id || !text) {
				return;
			}
			push({
				id: el.id,
				text,
				level: parseInt(el.tagName.charAt(1), 10) || 2,
				isCommentTitle: false,
				el,
			});
		});

		// 2) Comments: title first, then body headings under that comment
		const commentItems = qsa(
			'#header-comments li.comment[id], li.comment[id^="Comment"]'
		);

		if (commentItems.length) {
			commentItems.forEach((li) => {
				const titleEl = qs('header.comment-title h2, .comment-title h2', li);
				const commentId = li.id; // e.g. Comment621

				if (titleEl && commentId) {
					const text = headingText(titleEl);
					if (text) {
						push({
							id: commentId,
							text,
							level: 2,
							isCommentTitle: true,
							el: titleEl,
						});
					}
				}

				qsa(CONFIG.commentBodyHeadingSelector, li).forEach((el) => {
					const text = headingText(el);
					if (!el.id || !text) {
						return;
					}
					push({
						id: el.id,
						text,
						level: parseInt(el.tagName.charAt(1), 10) || 2,
						isCommentTitle: false,
						el,
					});
				});
			});
		} else {
			qsa(CONFIG.commentBodyHeadingSelector).forEach((el) => {
				const text = headingText(el);
				if (!el.id || !text) {
					return;
				}
				push({
					id: el.id,
					text,
					level: parseInt(el.tagName.charAt(1), 10) || 2,
					isCommentTitle: false,
					el,
				});
			});
		}

		return entries;
	}

	/**
	 * Build nested-looking flat list HTML into the sidebar.
	 */
	function buildTocList(headings, listEl) {
		listEl.innerHTML = '';
		let commentLabelAdded = false;

		headings.forEach((h, index) => {
			if (h.isCommentTitle && !commentLabelAdded) {
				const label = document.createElement('li');
				label.className = 'ww-sticky-toc__group-label';
				label.textContent = listEl.dataset.commentsLabel || 'Comments';
				label.setAttribute('role', 'presentation');
				listEl.appendChild(label);
				commentLabelAdded = true;
			}

			const li = document.createElement('li');
			li.className = 'ww-sticky-toc__item';
			li.dataset.level = String(h.level);
			li.dataset.index = String(index);
			li.dataset.tocKey = h.key;
			if (h.isCommentTitle) {
				li.classList.add('is-comment');
			}

			const a = document.createElement('a');
			a.href = '#' + h.id;
			a.textContent = h.text;
			a.title = h.text;
			a.dataset.targetId = h.id;
			a.dataset.tocKey = h.key;

			li.appendChild(a);
			listEl.appendChild(li);
		});
	}

	/**
	 * Limit visible items: show active ± neighbourLimit, dim or hide the rest.
	 */
	function applyVisibilityLimit(listEl, activeIndex) {
		const limit = CONFIG.neighbourLimit;
		if (!limit || limit < 1) {
			// show all
			qsa('.ww-sticky-toc__item', listEl).forEach((li) => {
				li.classList.remove('is-hidden', 'is-dimmed');
			});
			return;
		}

		const items = qsa('.ww-sticky-toc__item', listEl);
		const total = items.length;
		if (total <= limit * 2 + 1) {
			items.forEach((li) => li.classList.remove('is-hidden', 'is-dimmed'));
			return;
		}

		const lo = Math.max(0, activeIndex - limit);
		const hi = Math.min(total - 1, activeIndex + limit);

		items.forEach((li, i) => {
			li.classList.remove('is-hidden', 'is-dimmed');
			if (i < lo || i > hi) {
				// Far away → hide; near edge of window → dim
				if (i < lo - 2 || i > hi + 2) {
					li.classList.add('is-hidden');
				} else {
					li.classList.add('is-dimmed');
				}
			}
		});
	}

	/**
	 * Scroll only the sticky sidebar panel so `el` is visible.
	 * Must NOT use element.scrollIntoView() – browsers treat that as a
	 * document scroll and jump the page (breaks #CommentN deep links).
	 */
	function scrollSidebarTo(el) {
		const panel = el && el.closest(CONFIG.tocRoot);
		if (!panel || !el) {
			return;
		}
		const panelRect = panel.getBoundingClientRect();
		const elRect = el.getBoundingClientRect();
		const offset = elRect.top - panelRect.top + panel.scrollTop;
		const target =
			offset - panel.clientHeight / 2 + elRect.height / 2;
		panel.scrollTop = Math.max(0, target);
	}

	/**
	 * Set active link by unique ToC key (not by title text, not by HTML id alone).
	 * HTML ids can collide when page and comment headings share a page_id prefix.
	 */
	function setActive(listEl, key) {
		if (!key) {
			return;
		}
		const links = qsa('a[data-toc-key]', listEl);
		let activeIndex = -1;

		links.forEach((a) => {
			const on = a.dataset.tocKey === key;
			a.classList.toggle('is-active', on);
			if (on) {
				activeIndex = parseInt(a.parentElement.dataset.index, 10);
				scrollSidebarTo(a);
			}
		});

		if (activeIndex >= 0) {
			applyVisibilityLimit(listEl, activeIndex);
		}
	}

	/**
	 * Resolve initial active key from location.hash.
	 * If several entries share the same HTML id, prefer the first in document order
	 * (page body before comments) unless the hash target element is known.
	 */
	function keyFromHash(headings, hashId) {
		if (!hashId) {
			return headings[0] ? headings[0].key : null;
		}
		const target = document.getElementById(hashId);
		if (target) {
			const exact = headings.find((h) => h.el === target);
			if (exact) {
				return exact.key;
			}
			// Comment block: hash is CommentN; title entry uses that id
			const inComment = headings.find(
				(h) => h.id === hashId && (h.el === target || target.contains(h.el))
			);
			if (inComment) {
				return inComment.key;
			}
		}
		const first = headings.find((h) => h.id === hashId);
		return first ? first.key : headings[0].key;
	}

	/**
	 * Restore document scroll to location.hash after DOM rearrangements
	 * (ensureShell moves #header-comments, which cancels the browser's
	 * initial hash scroll).
	 */
	function restoreHashScroll() {
		const hash = location.hash;
		if (!hash || hash.length < 2) {
			return;
		}
		const id = decodeURIComponent(hash.slice(1));
		if (!id) {
			return;
		}
		const target = document.getElementById(id);
		if (!target) {
			return;
		}
		// Instant jump after layout; avoid smooth so it does not fight observer
		target.scrollIntoView({ block: 'start', behavior: 'auto' });
	}

	/**
	 * Intersection Observer for active section tracking.
	 * Maps observed DOM nodes → unique ToC keys (not HTML ids), so two
	 * headings that share the same id string still highlight independently.
	 */
	function observeSections(headings, listEl) {
		if (!('IntersectionObserver' in window)) {
			return;
		}

		const keyByNode = new WeakMap();
		const visible = new Map(); // key → { entry, level }

		const observer = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					const key = keyByNode.get(entry.target);
					if (!key) {
						return;
					}
					if (entry.isIntersecting) {
						visible.set(key, {
							entry,
							level: parseInt(entry.target.tagName?.charAt(1), 10) || 2,
						});
					} else {
						visible.delete(key);
					}
				});

				if (visible.size === 0) {
					return;
				}

				// Prefer the top-most intersecting target; on a tie prefer
				// deeper headings so a comment body h2 wins over the title.
				let best = null;
				let bestTop = Infinity;
				let bestLevel = -1;
				visible.forEach((info, key) => {
					const top = info.entry.boundingClientRect.top;
					if (
						top < bestTop - 1 ||
						(Math.abs(top - bestTop) <= 1 && info.level > bestLevel)
					) {
						bestTop = top;
						bestLevel = info.level;
						best = key;
					}
				});

				if (best) {
					setActive(listEl, best);
				}
			},
			{
				root: null,
				rootMargin: CONFIG.rootMargin,
				threshold: CONFIG.threshold,
			}
		);

		headings.forEach((h) => {
			keyByNode.set(h.el, h.key);
			observer.observe(h.el);
		});
	}

	/**
	 * Mobile drawer toggle.
	 */
	function bindMobileToggle(tocRoot, toggleBtn) {
		if (!toggleBtn || !tocRoot) {
			return;
		}

		toggleBtn.addEventListener('click', () => {
			const open = tocRoot.classList.toggle('is-open');
			toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});

		// Close when a link is chosen (mobile)
		tocRoot.addEventListener('click', (e) => {
			if (e.target.closest('a[data-target-id]') && window.matchMedia('(max-width: 900px)').matches) {
				tocRoot.classList.remove('is-open');
				toggleBtn.setAttribute('aria-expanded', 'false');
			}
		});
	}

	/**
	 * Read optional config from data attributes on the root element.
	 */
	function readConfig(root) {
		if (!root) {
			return;
		}
		const n = parseInt(root.dataset.neighbourLimit, 10);
		if (!isNaN(n) && n >= 0) {
			CONFIG.neighbourLimit = n;
		}
		const min = parseInt(root.dataset.minHeadings, 10);
		if (!isNaN(min) && min >= 1) {
			CONFIG.minHeadings = min;
		}
	}

	/**
	 * Auto-mount sidebar shell when the theme has not emitted one.
	 * Wraps #page-show (+ #header-comments) in .ww-layout-with-toc.
	 */
	function ensureShell() {
		if (qs(CONFIG.tocRoot)) {
			return;
		}

		const page =
			document.getElementById('page-show') ||
			document.getElementById('section-content');
		if (!page || !page.parentElement) {
			return;
		}

		const wrap = document.createElement('div');
		wrap.className = 'ww-layout-with-toc';
		page.parentElement.insertBefore(wrap, page);

		const primary = document.createElement('div');
		primary.className = 'ww-content-primary';
		wrap.appendChild(primary);
		primary.appendChild(page);

		const comments = document.getElementById('header-comments');
		if (comments) {
			primary.appendChild(comments);
		}

		const nav = document.createElement('nav');
		nav.id = 'ww-sticky-toc';
		nav.className = 'ww-sticky-toc';
		nav.setAttribute('aria-label', 'Contents');
		nav.dataset.neighbourLimit = String(CONFIG.neighbourLimit);
		nav.dataset.minHeadings = String(CONFIG.minHeadings);
		nav.dataset.commentsLabel = 'Comments';
		nav.innerHTML =
			'<p class="ww-sticky-toc__title">Contents</p>' +
			'<ul id="ww-sticky-toc-list" class="ww-sticky-toc__list"></ul>';
		wrap.appendChild(nav);

		const btn = document.createElement('button');
		btn.type = 'button';
		btn.id = 'ww-sticky-toc-toggle';
		btn.className = 'ww-sticky-toc-toggle';
		btn.setAttribute('aria-controls', 'ww-sticky-toc');
		btn.setAttribute('aria-expanded', 'false');
		btn.setAttribute('title', 'Contents');
		btn.textContent = '☰';
		document.body.appendChild(btn);
	}

	function init() {
		ensureShell();

		const tocRoot = qs(CONFIG.tocRoot);
		const listEl = qs(CONFIG.tocList);
		const toggleBtn = qs(CONFIG.tocToggle);

		if (!tocRoot || !listEl) {
			return;
		}

		readConfig(tocRoot);

		const headings = collectHeadings();

		if (headings.length < CONFIG.minHeadings) {
			tocRoot.hidden = true;
			if (toggleBtn) {
				toggleBtn.hidden = true;
			}
			// Unwrap layout class if present
			const layout = tocRoot.closest('.ww-layout-with-toc');
			if (layout) {
				layout.classList.remove('ww-layout-with-toc');
			}
			return;
		}

		buildTocList(headings, listEl);
		observeSections(headings, listEl);
		bindMobileToggle(tocRoot, toggleBtn);

		// Initial active state by unique key (hash target or first entry)
		const hashId = location.hash
			? decodeURIComponent(location.hash.slice(1))
			: '';
		setActive(listEl, keyFromHash(headings, hashId));

		// ensureShell() may have moved #header-comments after the browser
		// already applied the URL hash scroll → re-apply it once layout is done
		if (hashId) {
			requestAnimationFrame(() => {
				restoreHashScroll();
				// Second frame: fonts/images/sticky layout can still shift
				requestAnimationFrame(restoreHashScroll);
			});
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
