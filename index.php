<?php
/*
 * ITFlow Docs - every address comes here: /, /billing/invoices, the search index.
 *
 * Apache uses .htaccess; nginx needs  try_files $uri $uri/ /index.php?$query_string;
 * To try it on your own computer:  php -S localhost:8000 index.php
 */

define('ITFLOW_DOCS', true);
require __DIR__ . '/includes/docs.php';

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = rawurldecode($path);
$base = rtrim($docs['base'], '/');
if ($base !== '' && strpos($path, $base) === 0) {
    $path = substr($path, strlen($base));
}
$path = trim($path, '/');

// PHP's own web server: hand real files (CSS, pictures) straight back
if (PHP_SAPI === 'cli-server' && $path !== '' && is_file(__DIR__ . '/' . $path) && strpos($path, '..') === false) {
    return false;
}

header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

// The search index, made from the pages and kept until one changes
if ($path === 'assets/search-index.js') {
    $newest = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/content', FilesystemIterator::SKIP_DOTS)) as $f) {
        $newest = max($newest, $f->getMTime());
    }
    $newest = max($newest, filemtime(__DIR__ . '/nav.php'));
    $cache = sys_get_temp_dir() . '/itflow-docs-index-' . md5(__DIR__) . '-' . $newest . '.js';
    if (!is_file($cache)) {
        foreach (glob(sys_get_temp_dir() . '/itflow-docs-index-' . md5(__DIR__) . '-*.js') ?: [] as $old) {
            @unlink($old);
        }
        file_put_contents($cache, docsSearchScript(), LOCK_EX);
    }
    header('Content-Type: text/javascript; charset=utf-8');
    header('Cache-Control: public, max-age=300');
    readfile($cache);
    exit;
}

// Old addresses
if (isset($redirects[$path])) {
    $to = $redirects[$path];
    if (!preg_match('#^https?://#', $to)) {
        $parts = explode('#', $to, 2);
        $to = docHref($parts[0], $parts[1] ?? '');
    }
    header('Location: ' . $to, true, 301);
    exit;
}

header('Content-Type: text/html; charset=utf-8');

if ($path === '' || $path === 'index.php') {
    echo docsRenderHome();
    exit;
}

// A section on its own opens its first page
global $nav;
if (isset($nav[$path])) {
    header('Location: ' . docHref(docsFirstPage($path)), true, 302);
    exit;
}

$path = preg_replace('/\.html$/', '', $path);
if (isset(docsPages()[$path]) && ($html = docsRenderPage($path)) !== null) {
    echo $html;
    exit;
}

http_response_code(404);
echo docsRenderNotFound();
