<?php
/*
 * ITFlow Docs - loads the settings and the menu, finds pages and draws them.
 *
 * Pages are drawn two ways with the same code:
 *  - live, by index.php, at addresses like /billing/invoices
 *  - exported, by build.php, as plain .html files with relative links, to put on
 *    any web host or open straight from a folder
 */

defined('ITFLOW_DOCS') || exit;

define('DOCS_ROOT', dirname(__DIR__));

require DOCS_ROOT . '/config.php';
require __DIR__ . '/markdown.php';

$nav = require DOCS_ROOT . '/nav.php';

/* How pages are being drawn: 'live' or 'export', and for an export, how deep the page is.
   $docsHomeIsFolder links home as the folder rather than index.html - for hosts that serve the home page at / */
$docsMode = 'live';
$docsDepth = 0;
$docsHomeIsFolder = false;

function e($s)
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* Every page in menu order: slug => [title, section slug, section title] */
function docsPages()
{
    global $nav;
    static $pages = null;
    if ($pages === null) {
        $pages = [];
        foreach ($nav as $sectionSlug => $section) {
            foreach ($section['pages'] as $pageSlug => $title) {
                $pages[$sectionSlug . '/' . $pageSlug] = [
                    'title' => $title,
                    'section' => $sectionSlug,
                    'section_title' => $section['title'],
                ];
            }
        }
    }
    return $pages;
}

/* What is in front of every address on this page: '/' live, '../' or '' exported */
function docsRoot()
{
    global $docsMode, $docsDepth, $docs;
    if ($docsMode === 'export') {
        return $docsDepth > 0 ? str_repeat('../', $docsDepth) : '';
    }
    return rtrim($docs['base'], '/') . '/';
}

/* A link to a page, with an optional #anchor. '' is the home page. */
function docHref($slug, $anchor = '')
{
    global $docsMode, $docsHomeIsFolder;
    $slug = trim($slug, '/');
    if ($docsMode === 'export' && $slug === '' && $docsHomeIsFolder) {
        $href = docsRoot() !== '' ? docsRoot() : './';
    } elseif ($docsMode === 'export') {
        $href = docsRoot() . ($slug === '' ? 'index' : $slug) . '.html';
    } else {
        $href = docsRoot() . $slug;
    }
    return $href . ($anchor !== '' ? '#' . $anchor : '');
}

/* A link written in a page, such as /billing/invoices#batch, for where it is shown */
function docLink($href)
{
    if ($href[0] === '#') {
        return $href;
    }
    $parts = explode('#', $href, 2);
    $slug = trim($parts[0], '/');
    if ($slug !== '' && !isset(docsPages()[$slug])) {
        docsWarn("Link to a page that doesn't exist: $href");
    }
    return docHref($slug, $parts[1] ?? '');
}

/* A file under assets/, with its date on the end live so a change is picked up */
function asset($path)
{
    global $docsMode;
    $file = DOCS_ROOT . '/' . $path;
    $version = ($docsMode === 'live' && is_file($file)) ? '?v=' . filemtime($file) : '';
    return docsRoot() . $path . $version;
}

/* A screenshot by its file name; with $file, where it is on disk */
function shotHref($name, $file = false)
{
    if (preg_match('#^(https?:)?//#', $name)) {
        return $file ? '' : $name;
    }
    $path = strpos($name, '/') === false ? 'assets/img/shots/' . $name : ltrim($name, '/');
    if ($file) {
        return DOCS_ROOT . '/' . $path;
    }
    if (!is_file(DOCS_ROOT . '/' . $path)) {
        docsWarn("Missing screenshot: $name");
    }
    return docsRoot() . $path;
}

/* Problems found while drawing pages, for build.php to list */
function docsWarn($message)
{
    global $docsWarnings;
    $docsWarnings[] = $message;
}

/* A page's file, front matter and HTML. Null when there is no such page. */
function docsLoad($slug)
{
    $file = DOCS_ROOT . '/content/' . ($slug === '' ? 'index' : $slug) . '.md';
    if (!is_file($file)) {
        return null;
    }
    [$meta, $markdown] = DocsMarkdown::split(file_get_contents($file));
    $md = new DocsMarkdown('docLink', 'shotHref');
    $html = $md->render($markdown);
    return [
        'slug' => $slug,
        'file' => $file,
        'meta' => $meta,
        'html' => $html,
        'toc' => $md->toc,
    ];
}

/* The page before and after this one in the menu */
function docsNeighbours($slug)
{
    $slugs = array_keys(docsPages());
    $i = array_search($slug, $slugs, true);
    if ($i === false) {
        return [null, null];
    }
    return [$slugs[$i - 1] ?? null, $slugs[$i + 1] ?? null];
}

/* Every page as search data, for assets/search-index.js */
function docsSearchIndex()
{
    $index = [];
    foreach (docsPages() as $slug => $info) {
        $page = docsLoad($slug);
        if (!$page) {
            continue;
        }
        $text = $page['html'];
        $text = preg_replace('#<(h[1-4]|figcaption)[^>]*>.*?</\1>#s', ' ', $text);
        $text = preg_replace('#<[^>]+>#', ' ', $text);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = trim(preg_replace('/\s+/u', ' ', $text));
        $index[] = [
            'u' => $slug,
            't' => $page['meta']['title'] ?? $info['title'],
            's' => $info['section_title'],
            'd' => $page['meta']['description'] ?? '',
            'h' => array_map(function ($h) {
                return [$h['id'], $h['text']];
            }, $page['toc']),
            'x' => mb_substr($text, 0, 20000),
        ];
    }
    return $index;
}

function docsSearchScript()
{
    return '/* ITFlow Docs search index - made by the site, do not edit */' . "\n"
        . 'window.DOCS_INDEX = ' . json_encode(docsSearchIndex(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ";\n";
}

/* ------------------------------------------------------------ Drawing */

function docsLogo()
{
    return '<span class="logo"><i class="fas fa-paper-plane logo-plane" aria-hidden="true"></i><span class="logo-it">IT</span><span class="logo-flow">Flow</span></span>';
}

/* The whole page around $body. $slug is '' for the home page, null for a page that isn't found. */
function docsLayout($slug, $title, $description, $body, array $toc = [])
{
    global $docs, $nav, $docsMode;
    $pages = docsPages();
    $current = $slug !== null && isset($pages[$slug]) ? $pages[$slug] : null;
    $isHome = $slug === '';
    $fullTitle = $isHome ? $docs['name'] : $title . ' - ' . $docs['name'];
    $canonical = rtrim($docs['url'], '/') . '/' . ($slug ?? '');

    ob_start(); ?>
<!doctype html>
<html lang="en" data-root="<?= e(docsRoot()) ?>" data-ext="<?= $docsMode === 'export' ? '.html' : '' ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($fullTitle) ?></title>
    <meta name="description" content="<?= e($description) ?>">
    <?php if ($slug !== null) { ?><link rel="canonical" href="<?= e($canonical) ?>"><?php } ?>
    <meta name="color-scheme" content="light dark">
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= e($fullTitle) ?>">
    <meta property="og:description" content="<?= e($description) ?>">
    <link rel="icon" href="<?= e(asset('assets/img/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= e(asset('assets/vendor/fontawesome/css/all.min.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('assets/css/docs.css')) ?>">
    <script>
        (function () {
            var d = document.documentElement, t = null;
            d.classList.add('js');
            try { t = localStorage.getItem('docs-theme'); } catch (err) {}
            if (t === 'light' || t === 'dark') { d.setAttribute('data-theme', t); }
        })();
    </script>
</head>
<body class="<?= $isHome ? 'is-home' : 'is-page' ?>">
<a class="skip" href="#content">Skip to the content</a>

<header class="topbar">
    <button class="icon-button nav-button" type="button" aria-label="Menu" aria-expanded="false" aria-controls="sidebar" data-nav-button>
        <i class="fas fa-bars" aria-hidden="true"></i>
    </button>
    <a class="brand" href="<?= e(docHref('')) ?>" aria-label="<?= e($docs['name']) ?> home">
        <?= docsLogo() ?><span class="brand-docs">Docs</span>
    </a>
    <button class="search-button" type="button" data-search-open>
        <i class="fas fa-magnifying-glass" aria-hidden="true"></i>
        <span class="search-button-text">Search the docs</span>
        <span class="search-button-keys" aria-hidden="true"><kbd>Ctrl</kbd><kbd>K</kbd></span>
    </button>
    <nav class="topbar-links" aria-label="ITFlow">
        <a href="<?= e($docs['website_url']) ?>">itflow.org</a>
        <a href="<?= e($docs['forum_url']) ?>">Forum</a>
        <a class="topbar-github" href="<?= e($docs['github_url']) ?>" title="ITFlow on GitHub"><i class="fab fa-github" aria-hidden="true"></i><span class="visually-hidden">GitHub</span></a>
    </nav>
    <button class="icon-button theme-button" type="button" data-theme-button title="Light or dark">
        <i class="fas fa-circle-half-stroke" aria-hidden="true" data-theme-icon></i>
        <span class="visually-hidden" data-theme-label>Theme: as your system</span>
    </button>
</header>

<div class="shell">
    <aside class="sidebar" id="sidebar" aria-label="Documentation">
        <div class="sidebar-scroll">
            <a class="sidebar-home<?= $isHome ? ' is-current' : '' ?>" href="<?= e(docHref('')) ?>"><i class="fas fa-house" aria-hidden="true"></i>Home</a>
            <?php foreach ($nav as $sectionSlug => $section) {
                $open = $current && $current['section'] === $sectionSlug; ?>
                <div class="nav-section<?= $open ? ' is-open' : '' ?>" data-nav-section>
                    <button class="nav-section-title" type="button" aria-expanded="<?= $open ? 'true' : 'false' ?>" data-nav-toggle>
                        <i class="fas fa-<?= e($section['icon']) ?> nav-icon" aria-hidden="true"></i>
                        <span><?= e($section['title']) ?></span>
                        <i class="fas fa-chevron-right nav-caret" aria-hidden="true"></i>
                    </button>
                    <ul class="nav-pages">
                        <?php foreach ($section['pages'] as $pageSlug => $pageTitle) {
                            $s = $sectionSlug . '/' . $pageSlug; ?>
                            <li><a href="<?= e(docHref($s)) ?>"<?= $s === $slug ? ' class="is-current" aria-current="page"' : '' ?>><?= e($pageTitle) ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </aside>
    <div class="nav-backdrop" data-nav-backdrop></div>

    <main id="content" class="main<?= $toc ? ' has-toc' : '' ?>">
        <?= $body ?>
    </main>
</div>

<footer class="footer">
    <div class="footer-row">
        <span class="footer-brand"><?= docsLogo() ?> <span>Docs for ITFlow <?= e($docs['version']) ?></span></span>
        <nav aria-label="More from ITFlow">
            <a href="<?= e($docs['website_url']) ?>">itflow.org</a>
            <a href="<?= e($docs['demo_url']) ?>">Demo</a>
            <a href="<?= e($docs['forum_url']) ?>">Forum</a>
            <a href="<?= e($docs['github_url']) ?>">GitHub</a>
        </nav>
    </div>
    <p class="footer-note">ITFlow is free and open source, under the GPL. Screenshots show made-up demo data.</p>
</footer>

<dialog class="search-dialog" data-search-dialog aria-label="Search the docs">
    <div class="search-box">
        <i class="fas fa-magnifying-glass" aria-hidden="true"></i>
        <input type="search" placeholder="Search the docs" autocomplete="off" spellcheck="false" aria-label="Search the docs" data-search-input>
        <button class="search-close" type="button" data-search-close><kbd>Esc</kbd></button>
    </div>
    <div class="search-results" data-search-results role="listbox" aria-label="Results"></div>
    <div class="search-foot"><span><kbd>↑</kbd><kbd>↓</kbd> to pick</span><span><kbd>Enter</kbd> to open</span></div>
</dialog>

<dialog class="zoom-dialog" data-zoom-dialog aria-label="Screenshot">
    <button class="zoom-close" type="button" data-zoom-close aria-label="Close"><i class="fas fa-xmark" aria-hidden="true"></i></button>
    <img alt="" data-zoom-img>
    <p class="zoom-caption" data-zoom-caption></p>
</dialog>

<script src="<?= e(asset('assets/js/docs.js')) ?>" data-index="<?= e(asset('assets/search-index.js')) ?>" data-root="<?= e(docsRoot()) ?>" data-ext="<?= $docsMode === 'export' ? '.html' : '' ?>" data-home="<?= e(docHref('')) ?>" defer></script>
</body>
</html>
<?php
    return ob_get_clean();
}

/* A documentation page */
function docsRenderPage($slug, $placeholder = false)
{
    global $docs;
    $page = docsLoad($slug);
    if (!$page && $placeholder && isset(docsPages()[$slug])) {
        $page = ['slug' => $slug, 'file' => '', 'meta' => [], 'toc' => [],
            'html' => '<div class="callout callout-note"><div class="callout-title"><i class="fas fa-circle-info" aria-hidden="true"></i>On its way</div><p>This page is still being written.</p></div>'];
    }
    if (!$page) {
        return null;
    }
    $info = docsPages()[$slug];
    $title = $page['meta']['title'] ?? $info['title'];
    $description = $page['meta']['description'] ?? '';
    [$prev, $next] = docsNeighbours($slug);
    $pages = docsPages();

    ob_start(); ?>
    <article class="doc">
        <nav class="crumbs" aria-label="You are here">
            <a href="<?= e(docHref('')) ?>">Docs</a>
            <i class="fas fa-chevron-right" aria-hidden="true"></i>
            <a href="<?= e(docHref(docsFirstPage($info['section']))) ?>"><?= e($info['section_title']) ?></a>
        </nav>
        <h1><?= e($title) ?></h1>
        <?php if ($description !== '') { ?><p class="lead"><?= e($description) ?></p><?php } ?>
        <?php if (!empty($page['meta']['where']) || !empty($page['meta']['access'])) { ?>
            <div class="page-facts">
                <?php if (!empty($page['meta']['where'])) { ?>
                    <span class="fact"><i class="fas fa-location-arrow" aria-hidden="true"></i><span class="fact-label">In ITFlow</span><?= docsPath($page['meta']['where']) ?></span>
                <?php } ?>
                <?php if (!empty($page['meta']['access'])) { ?>
                    <span class="fact"><i class="fas fa-user-shield" aria-hidden="true"></i><span class="fact-label">Who</span><?= e($page['meta']['access']) ?></span>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="doc-body">
            <?= $page['html'] ?>
        </div>

        <?php if (!empty($docs['edit_url'])) { ?>
            <p class="edit-link"><a href="<?= e(str_replace('{path}', $slug . '.md', $docs['edit_url'])) ?>"><i class="fas fa-pen" aria-hidden="true"></i>Suggest a change to this page</a></p>
        <?php } ?>

        <nav class="pager" aria-label="Next and previous">
            <?php if ($prev) { ?>
                <a class="pager-prev" href="<?= e(docHref($prev)) ?>"><span class="pager-label"><i class="fas fa-arrow-left" aria-hidden="true"></i>Previous</span><span class="pager-title"><?= e($pages[$prev]['title']) ?></span></a>
            <?php } else { ?><span></span><?php } ?>
            <?php if ($next) { ?>
                <a class="pager-next" href="<?= e(docHref($next)) ?>"><span class="pager-label">Next<i class="fas fa-arrow-right" aria-hidden="true"></i></span><span class="pager-title"><?= e($pages[$next]['title']) ?></span></a>
            <?php } ?>
        </nav>
    </article>
    <?php if ($page['toc']) { ?>
        <aside class="toc" aria-label="On this page">
            <div class="toc-title">On this page</div>
            <ul>
                <?php foreach ($page['toc'] as $h) { ?>
                    <li class="toc-<?= (int) $h['level'] ?>"><a href="#<?= e($h['id']) ?>" data-toc-link><?= e($h['text']) ?></a></li>
                <?php } ?>
            </ul>
        </aside>
    <?php }
    $body = ob_get_clean();

    return docsLayout($slug, $title, $description ?: $docs['description'], $body, $page['toc']);
}

/* "Billing > Invoices" as a path with arrows */
function docsPath($path)
{
    $parts = array_map('trim', explode('>', $path));
    return '<span class="path">' . implode('<i class="fas fa-chevron-right" aria-hidden="true"></i>', array_map('e', $parts)) . '</span>';
}

function docsFirstPage($sectionSlug)
{
    global $nav;
    return $sectionSlug . '/' . array_key_first($nav[$sectionSlug]['pages']);
}

/* The home page: content/index.md, then a card for each section */
function docsRenderHome()
{
    global $docs, $nav;
    $page = docsLoad('');
    ob_start(); ?>
    <div class="home">
        <section class="home-hero">
            <h1><?= e($page['meta']['title'] ?? 'ITFlow documentation') ?></h1>
            <?php if (!empty($page['meta']['description'])) { ?><p class="lead"><?= e($page['meta']['description']) ?></p><?php } ?>
            <button class="home-search" type="button" data-search-open>
                <i class="fas fa-magnifying-glass" aria-hidden="true"></i>
                <span>Search the docs: invoices, SLA, two-step sign-in...</span>
                <span class="search-button-keys" aria-hidden="true"><kbd>Ctrl</kbd><kbd>K</kbd></span>
            </button>
        </section>

        <section class="home-sections" aria-label="Sections">
            <?php foreach ($nav as $sectionSlug => $section) { ?>
                <div class="home-card">
                    <a class="home-card-head" href="<?= e(docHref(docsFirstPage($sectionSlug))) ?>">
                        <span class="home-card-icon"><i class="fas fa-<?= e($section['icon']) ?>" aria-hidden="true"></i></span>
                        <span class="home-card-title"><?= e($section['title']) ?></span>
                    </a>
                    <p><?= e($section['summary']) ?></p>
                    <ul>
                        <?php foreach (array_slice($section['pages'], 0, 5, true) as $pageSlug => $pageTitle) { ?>
                            <li><a href="<?= e(docHref($sectionSlug . '/' . $pageSlug)) ?>"><?= e($pageTitle) ?></a></li>
                        <?php } ?>
                        <?php if (count($section['pages']) > 5) { ?>
                            <li class="home-card-more"><a href="<?= e(docHref(docsFirstPage($sectionSlug))) ?>"><?= count($section['pages']) - 5 ?> more<i class="fas fa-arrow-right" aria-hidden="true"></i></a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </section>

        <?php if ($page && trim(strip_tags($page['html'])) !== '') { ?>
            <section class="home-body doc-body">
                <?= $page['html'] ?>
            </section>
        <?php } ?>
    </div>
    <?php
    $body = ob_get_clean();
    return docsLayout('', $page['meta']['title'] ?? $docs['name'], $page['meta']['description'] ?? $docs['description'], $body);
}

function docsRenderNotFound()
{
    global $docs;
    $body = '<article class="doc not-found"><h1>That page isn\'t here</h1>'
        . '<p class="lead">It may have moved. Search for what you were after, or start from the home page.</p>'
        . '<p><button class="button" type="button" data-search-open><i class="fas fa-magnifying-glass" aria-hidden="true"></i>Search the docs</button> '
        . '<a class="button button-quiet" href="' . e(docHref('')) . '">Docs home</a></p></article>';
    return docsLayout(null, 'Not found', $docs['description'], $body);
}
