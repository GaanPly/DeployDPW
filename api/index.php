<?php
// Front controller untuk Vercel (vercel-php). Semua request non-statis
// masuk ke sini, lalu dipetakan ke file halaman di folder app/.
// Aset statis (CSS/JS) dilayani langsung dari folder public/.

$root = dirname(__DIR__);
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

// Mode lokal (`php -S ... -t public api/index.php`): biarkan file statis dilayani PHP.
if (PHP_SAPI === 'cli-server') {
    $static = realpath($root . '/public' . $path);
    if ($static !== false && is_file($static) && strpos($static, $root . '/public/') === 0) {
        return false;
    }
}

$rel = trim($path, '/');
if ($rel === '') {
    $rel = 'index.php';
} elseif (substr($rel, -4) !== '.php') {
    $rel .= '.php'; // /senjata/list -> senjata/list.php
}

// Whitelist: hanya nama file sederhana, bukan folder includes/, tanpa "..".
$valid = preg_match('#^[A-Za-z0-9_\-/]+\.php$#', $rel) === 1
    && strpos($rel, '..') === false
    && strpos($rel, 'includes/') !== 0;

$file = $valid ? realpath($root . '/app/' . $rel) : false;
if ($file === false || strpos($file, $root . '/app/') !== 0 || !is_file($file)) {
    http_response_code(404);
    echo '404 - Halaman tidak ditemukan';
    exit;
}

$base = '/';
chdir(dirname($file));
require $file;
