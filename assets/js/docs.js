/*
 * ITFlow Docs - the menu on a phone, light or dark, search, zooming a
 * screenshot and "On this page" following along. Everything works without it,
 * apart from search.
 */
(function () {
    'use strict';

    var doc = document.documentElement;
    var me = document.currentScript || document.querySelector('script[data-index]');
    var root = (me && me.hasAttribute('data-root')) ? me.getAttribute('data-root') : (doc.getAttribute('data-root') || '/');
    var ext = (me && me.hasAttribute('data-ext')) ? me.getAttribute('data-ext') : (doc.getAttribute('data-ext') || '');
    var home = me ? me.getAttribute('data-home') : null;

    function store(key, value) {
        try {
            if (value === undefined) { return localStorage.getItem(key); }
            if (value === null) { localStorage.removeItem(key); } else { localStorage.setItem(key, value); }
        } catch (err) { /* private window or storage switched off */ }
        return null;
    }

    function pageHref(slug, anchor) {
        var href = slug === '' ? (home || root + (ext ? 'index' + ext : '')) : root + slug + ext;
        return href + (anchor ? '#' + anchor : '');
    }

    /* ------------------------------------------------------------ Menu on a phone */

    var navButton = document.querySelector('[data-nav-button]');
    function setNav(open) {
        document.body.classList.toggle('nav-open', open);
        if (navButton) { navButton.setAttribute('aria-expanded', open ? 'true' : 'false'); }
    }
    if (navButton) {
        navButton.addEventListener('click', function () { setNav(!document.body.classList.contains('nav-open')); });
    }
    var backdrop = document.querySelector('[data-nav-backdrop]');
    if (backdrop) { backdrop.addEventListener('click', function () { setNav(false); }); }

    // Sections open and close; the one you are in starts open
    document.querySelectorAll('[data-nav-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            var section = button.closest('[data-nav-section]');
            var open = !section.classList.contains('is-open');
            section.classList.toggle('is-open', open);
            button.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    });

    // Keep the current page in view in a long menu
    var current = document.querySelector('.nav-pages a.is-current');
    if (current && current.scrollIntoView) {
        var scroller = document.querySelector('.sidebar-scroll');
        if (scroller && current.offsetTop > scroller.clientHeight - 80) {
            scroller.scrollTop = current.offsetTop - scroller.clientHeight / 3;
        }
    }

    /* ------------------------------------------------------------ Light or dark */

    var themeButton = document.querySelector('[data-theme-button]');
    var themes = ['auto', 'light', 'dark'];
    var themeIcons = { auto: 'fa-circle-half-stroke', light: 'fa-sun', dark: 'fa-moon' };
    var themeNames = { auto: 'as your system', light: 'light', dark: 'dark' };

    function showTheme(theme) {
        if (!themeButton) { return; }
        var icon = themeButton.querySelector('[data-theme-icon]');
        icon.className = 'fas ' + themeIcons[theme];
        themeButton.title = 'Theme: ' + themeNames[theme] + ' (click to change)';
        themeButton.querySelector('[data-theme-label]').textContent = 'Theme: ' + themeNames[theme];
    }
    var theme = store('docs-theme') || 'auto';
    if (themes.indexOf(theme) < 0) { theme = 'auto'; }
    showTheme(theme);
    if (themeButton) {
        themeButton.addEventListener('click', function () {
            theme = themes[(themes.indexOf(theme) + 1) % themes.length];
            if (theme === 'auto') { doc.removeAttribute('data-theme'); store('docs-theme', null); } else { doc.setAttribute('data-theme', theme); store('docs-theme', theme); }
            showTheme(theme);
        });
    }

    /* ------------------------------------------------------------ Search */

    var dialog = document.querySelector('[data-search-dialog]');
    var input = document.querySelector('[data-search-input]');
    var results = document.querySelector('[data-search-results]');
    var indexUrl = me ? me.getAttribute('data-index') : null;
    var loading = null;
    var active = 0;
    var shown = [];

    function loadIndex(then) {
        if (window.DOCS_INDEX) { then(); return; }
        if (!loading) {
            loading = [];
            var s = document.createElement('script');
            s.src = indexUrl;
            s.onload = function () { loading.forEach(function (f) { f(); }); };
            s.onerror = function () { results.innerHTML = '<div class="search-empty">Search couldn\'t load. Try the menu on the left.</div>'; };
            document.head.appendChild(s);
        }
        loading.push(then);
    }

    function esc(s) {
        return String(s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; });
    }

    function fold(s) {
        return String(s).toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '');
    }

    function mark(text, terms) {
        var out = esc(text);
        terms.forEach(function (t) {
            if (t.length < 2) { return; }
            var re = new RegExp('(' + t.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'ig');
            out = out.replace(re, '<mark>$1</mark>');
        });
        return out;
    }

    function snippet(text, terms) {
        var lower = fold(text);
        var at = -1;
        for (var i = 0; i < terms.length && at < 0; i++) { at = lower.indexOf(terms[i]); }
        if (at < 0) { return text.slice(0, 160); }
        var start = Math.max(0, at - 60);
        var piece = text.slice(start, start + 180);
        if (start > 0) { piece = '…' + piece.replace(/^\S*\s/, ''); }
        return piece + '…';
    }

    function search(query) {
        var terms = fold(query).split(/\s+/).filter(Boolean);
        if (!terms.length) { return []; }
        var found = [];
        window.DOCS_INDEX.forEach(function (page) {
            var title = fold(page.t), section = fold(page.s), desc = fold(page.d), text = fold(page.x);
            var heads = page.h.map(function (h) { return fold(h[1]); });
            var score = 0, bestHead = null, bestHeadScore = 0;
            for (var i = 0; i < terms.length; i++) {
                var t = terms[i], s = 0;
                if (title.indexOf(t) >= 0) { s += title.split(/\W+/).indexOf(t) >= 0 ? 30 : 18; }
                if (section.indexOf(t) >= 0) { s += 4; }
                if (desc.indexOf(t) >= 0) { s += 6; }
                heads.forEach(function (h, n) {
                    if (h.indexOf(t) >= 0) {
                        s += 5;
                        var hs = (h.split(/\W+/).indexOf(t) >= 0 ? 2 : 1);
                        if (hs > bestHeadScore || (hs === bestHeadScore && bestHead === null)) { bestHeadScore = hs; bestHead = n; }
                    }
                });
                var count = 0, from = 0;
                while (count < 20 && (from = text.indexOf(t, from)) >= 0) { count++; from += t.length; }
                s += Math.min(count, 10);
                if (s === 0) { return; }
                score += s;
            }
            // The whole phrase together counts for more
            if (terms.length > 1) {
                var phrase = terms.join(' ');
                if (title.indexOf(phrase) >= 0) { score += 25; }
                if (text.indexOf(phrase) >= 0) { score += 8; }
            }
            found.push({ page: page, score: score, head: bestHead });
        });
        found.sort(function (a, b) { return b.score - a.score; });
        return found.slice(0, 12).map(function (r) { r.terms = terms; return r; });
    }

    function render() {
        var q = input.value.trim();
        if (!q) {
            shown = [];
            results.innerHTML = '<div class="search-hint">Try</div>' + ['recurring invoice', 'canned response', 'reconcile', 'two-step sign-in', 'unbilled time', 'request form'].map(function (s) {
                return '<a class="search-result" href="#" data-suggest="' + esc(s) + '"><span class="search-result-title"><i class="fas fa-magnifying-glass" style="color:var(--muted);margin-right:8px;font-size:.8em"></i>' + esc(s) + '</span></a>';
            }).join('');
            results.querySelectorAll('[data-suggest]').forEach(function (a) {
                a.addEventListener('click', function (ev) { ev.preventDefault(); input.value = a.getAttribute('data-suggest'); render(); input.focus(); });
            });
            return;
        }
        shown = search(q);
        active = 0;
        if (!shown.length) {
            results.innerHTML = '<div class="search-empty">Nothing found for <strong>' + esc(q) + '</strong>. Try fewer or other words.</div>';
            return;
        }
        results.innerHTML = shown.map(function (r, n) {
            var p = r.page;
            var anchor = r.head !== null ? p.h[r.head][0] : '';
            var heading = r.head !== null ? '<span class="search-result-heading"># ' + mark(p.h[r.head][1], r.terms) + '</span>' : '';
            return '<a class="search-result' + (n === 0 ? ' is-active' : '') + '" role="option" href="' + esc(pageHref(p.u, anchor)) + '" data-n="' + n + '">'
                + '<span class="search-result-top"><span class="search-result-title">' + mark(p.t, r.terms) + '</span><span class="search-result-where">' + esc(p.s) + '</span>' + heading + '</span>'
                + '<div class="search-result-text">' + mark(snippet(p.d && fold(p.d).indexOf(r.terms[0]) >= 0 ? p.d : p.x, r.terms), r.terms) + '</div></a>';
        }).join('');
        results.querySelectorAll('.search-result').forEach(function (a) {
            a.addEventListener('mousemove', function () { setActive(+a.getAttribute('data-n')); });
            a.addEventListener('click', function () { dialog.close(); });
        });
    }

    function setActive(n) {
        var items = results.querySelectorAll('.search-result');
        if (!items.length) { return; }
        active = (n + items.length) % items.length;
        items.forEach(function (el, i) { el.classList.toggle('is-active', i === active); });
        items[active].scrollIntoView({ block: 'nearest' });
    }

    function openSearch() {
        if (!dialog || !dialog.showModal) { return; }
        setNav(false);
        if (!dialog.open) { dialog.showModal(); }
        input.select();
        loadIndex(render);
    }

    if (dialog && input) {
        document.querySelectorAll('[data-search-open]').forEach(function (b) { b.addEventListener('click', openSearch); });
        document.querySelector('[data-search-close]').addEventListener('click', function () { dialog.close(); });
        dialog.addEventListener('click', function (ev) { if (ev.target === dialog) { dialog.close(); } });
        input.addEventListener('input', function () { loadIndex(render); });
        input.addEventListener('keydown', function (ev) {
            if (ev.key === 'ArrowDown') { ev.preventDefault(); setActive(active + 1); }
            else if (ev.key === 'ArrowUp') { ev.preventDefault(); setActive(active - 1); }
            else if (ev.key === 'Enter') {
                var items = results.querySelectorAll('.search-result');
                if (items[active]) {
                    ev.preventDefault();
                    if (items[active].hasAttribute('data-suggest')) { items[active].click(); return; }
                    if (ev.ctrlKey || ev.metaKey) { window.open(items[active].href, '_blank'); } else { window.location.href = items[active].href; dialog.close(); }
                }
            }
        });
        document.addEventListener('keydown', function (ev) {
            var typing = /^(INPUT|TEXTAREA|SELECT)$/.test((ev.target && ev.target.tagName) || '') || (ev.target && ev.target.isContentEditable);
            if ((ev.key === 'k' || ev.key === 'K') && (ev.ctrlKey || ev.metaKey)) { ev.preventDefault(); openSearch(); }
            else if (ev.key === '/' && !typing) { ev.preventDefault(); openSearch(); }
        });
        // Mac keys
        if (/Mac|iPhone|iPad/.test(navigator.platform || navigator.userAgent)) {
            document.querySelectorAll('.search-button-keys kbd:first-child').forEach(function (k) { k.textContent = '⌘'; });
        }
    }

    /* ------------------------------------------------------------ Zoom a screenshot */

    var zoom = document.querySelector('[data-zoom-dialog]');
    if (zoom && zoom.showModal) {
        var zoomImg = zoom.querySelector('[data-zoom-img]');
        var zoomCaption = zoom.querySelector('[data-zoom-caption]');
        document.querySelectorAll('[data-zoom]').forEach(function (link) {
            link.addEventListener('click', function (ev) {
                if (ev.ctrlKey || ev.metaKey || ev.shiftKey) { return; }
                ev.preventDefault();
                var img = link.querySelector('img');
                var cap = link.parentNode.querySelector('figcaption');
                zoomImg.src = link.getAttribute('href');
                zoomImg.alt = img ? img.alt : '';
                zoomCaption.textContent = cap ? cap.textContent : '';
                zoom.showModal();
                zoom.scrollTop = 0;
            });
        });
        zoom.addEventListener('click', function (ev) {
            if (ev.target === zoom || ev.target === zoomImg || ev.target.closest('[data-zoom-close]')) { zoom.close(); }
        });
    }

    /* ------------------------------------------------------------ On this page */

    var tocLinks = document.querySelectorAll('[data-toc-link]');
    if (tocLinks.length && 'IntersectionObserver' in window) {
        var byId = {};
        tocLinks.forEach(function (a) { byId[a.getAttribute('href').slice(1)] = a; });
        var headings = Array.prototype.filter.call(document.querySelectorAll('.doc-body h2[id], .doc-body h3[id]'), function (h) { return byId[h.id]; });
        var visible = {};
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) { visible[en.target.id] = en.isIntersecting; });
            var top = null;
            for (var i = 0; i < headings.length; i++) {
                if (visible[headings[i].id]) { top = headings[i]; break; }
            }
            if (!top) {
                // Between headings: the last one above the top of the screen
                for (var j = headings.length - 1; j >= 0; j--) {
                    if (headings[j].getBoundingClientRect().top < 120) { top = headings[j]; break; }
                }
            }
            tocLinks.forEach(function (a) { a.classList.toggle('is-active', top && a === byId[top.id]); });
        }, { rootMargin: '-70px 0px -60% 0px' });
        headings.forEach(function (h) { observer.observe(h); });
    }
})();
