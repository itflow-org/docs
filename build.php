<?php
/*
 * ITFlow Docs - export every page as plain HTML.
 *
 *   php build.php            writes the site to dist/
 *   php build.php /var/www   writes it there instead
 *   php build.php --check    writes nothing, lists broken links and missing screenshots
 *
 * The export works from any web host, or opened straight from the folder:
 * every link is relative, and search works without a server.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

define('ITFLOW_DOCS', true);
require __DIR__ . '/includes/docs.php';

$docsWarnings = [];
$check = in_array('--check', $argv, true);
// --draft shows pages not written yet as "on its way"; --artifact also writes the home page without its
// own <html> and <head>, for a host that wraps the page in its own, and links home as the folder
$draft = in_array('--draft', $argv, true) || in_array('--artifact', $argv, true);
$artifact = in_array('--artifact', $argv, true);
$args = array_values(array_filter(array_slice($argv, 1), function ($a) {
    return $a[0] !== '-';
}));
$out = rtrim($args[0] ?? __DIR__ . '/dist', '/');

$docsMode = 'export';
$docsHomeIsFolder = $artifact;
$written = 0;

function put($file, $content)
{
    global $check, $written;
    if ($check) {
        return;
    }
    if (!is_dir(dirname($file))) {
        mkdir(dirname($file), 0775, true);
    }
    file_put_contents($file, $content);
    $written++;
}

function copyTree($from, $to)
{
    global $check;
    if ($check) {
        return;
    }
    $items = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
    foreach ($items as $item) {
        $target = $to . '/' . substr($item->getPathname(), strlen($from) + 1);
        if ($item->isDir()) {
            is_dir($target) || mkdir($target, 0775, true);
        } else {
            copy($item->getPathname(), $target);
        }
    }
}

if (!$check) {
    if (is_dir($out) && realpath($out) === realpath(__DIR__)) {
        fwrite(STDERR, "Pick a folder other than the site itself.\n");
        exit(1);
    }
    is_dir($out) || mkdir($out, 0775, true);
    copyTree(__DIR__ . '/assets', $out . '/assets');
}

// Home and the 404 page are at the top
$docsDepth = 0;
$home = docsRenderHome();
if ($artifact) {
    // The host adds <!doctype>, <html>, <head> and <body>: keep what was in them, and set the body's class from a script
    preg_match('#<html([^>]*)>#', $home, $htmlTag);
    preg_match('#<body class="([^"]*)"#', $home, $bodyClass);
    $home = preg_replace('#^.*?<head>#s', '', $home);
    $home = str_replace(['</head>', '</body>', '</html>'], '', $home);
    $home = preg_replace('#<body[^>]*>#', '<script>document.body.className = ' . json_encode($bodyClass[1] ?? '') . ';</script>', $home, 1);
    $home = '<meta name="claude:viewport-fit-sides" content="cover">' . "\n" . trim($home) . "\n";
}
put($out . '/index.html', $home);
put($out . '/404.html', docsRenderNotFound());

$missing = [];
foreach (docsPages() as $slug => $info) {
    $docsDepth = substr_count($slug, '/');
    $html = docsRenderPage($slug, $draft);
    if (!is_file(__DIR__ . '/content/' . $slug . '.md')) {
        $missing[] = $slug;
    }
    if ($html === null) {
        continue;
    }
    put($out . '/' . $slug . '.html', $html);

    // #anchors on other pages
    preg_match_all('/href="([^"#]*)\.html#([^"]+)"/', $html, $m, PREG_SET_ORDER);
    foreach ($m as $link) {
        $target = $link[1];
        // Back to a slug from the relative link
        $abs = preg_replace('#^(\.\./)+#', '', $target);
        $page = docsLoad($abs === 'index' ? '' : $abs);
        if ($page && !in_array($link[2], array_column($page['toc'], 'id'), true) && strpos($page['html'], 'id="' . $link[2] . '"') === false) {
            docsWarn("$slug links to #{$link[2]} on $abs, which has no such heading");
        }
    }
}

$docsDepth = 0;
put($out . '/assets/search-index.js', docsSearchScript());

// Old addresses (config.php): each has to land on a page and heading that exist, and the export gets a
// small page at each one that sends the reader on - a static host has no rewrite rules to do it
foreach ($redirects as $from => $to) {
    if (preg_match('#^https?://#', $to)) {
        $href = $to;
    } else {
        [$page_slug, $anchor] = array_pad(explode('#', $to, 2), 2, '');
        $page = docsLoad($page_slug);
        if (!$page) {
            docsWarn("The old address /$from goes to $page_slug, which isn't a page");
            continue;
        }
        if ($anchor !== '' && !in_array($anchor, array_column($page['toc'], 'id'), true) && strpos($page['html'], 'id="' . $anchor . '"') === false) {
            docsWarn("The old address /$from goes to #$anchor on $page_slug, which has no such heading");
        }
        $href = str_repeat('../', substr_count($from, '/') + 1) . $page_slug . '.html' . ($anchor !== '' ? "#$anchor" : '');
    }
    if (!$artifact) {
        $h = htmlspecialchars($href, ENT_QUOTES);
        put($out . '/' . $from . '/index.html', "<!doctype html>\n<meta charset=\"utf-8\">\n<title>Moved</title>\n<meta http-equiv=\"refresh\" content=\"0; url=$h\">\n<link rel=\"canonical\" href=\"$h\">\n<p>This page has moved to <a href=\"$h\">$h</a>.</p>\n");
    }
}

// Screenshots no page uses
$used = [];
foreach (docsPages() as $slug => $info) {
    $f = __DIR__ . '/content/' . $slug . '.md';
    if (is_file($f) && preg_match_all('/!\[[^\]]*\]\(([^)\s]+)/', file_get_contents($f), $m)) {
        $used = array_merge($used, $m[1]);
    }
}
$unused = array_diff(array_map('basename', glob(__DIR__ . '/assets/img/shots/*') ?: []), $used);

foreach ($missing as $slug) {
    echo "No file yet for $slug (content/$slug.md)\n";
}
foreach (array_unique($docsWarnings) as $w) {
    echo "$w\n";
}
foreach ($unused as $u) {
    echo "Screenshot not used on any page: $u\n";
}
echo $check
    ? count(docsPages()) . " pages checked.\n"
    : "Wrote $written files to $out\n";
exit(empty($missing) && empty($docsWarnings) ? 0 : 1);
