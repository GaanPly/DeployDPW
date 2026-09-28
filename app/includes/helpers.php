<?php
// Escape output HTML.
function e($v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

// Flash message berbasis cookie (session PHP tidak andal di serverless,
// karena tiap request bisa dilayani instance berbeda).
function set_flash(string $type, string $pesan): void
{
    setcookie('flash', json_encode(['type' => $type, 'pesan' => $pesan]), [
        'expires'  => time() + 60,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

// Ambil lalu hapus flash. Panggil SEBELUM ada output HTML.
function ambil_flash(): ?array
{
    if (!isset($_COOKIE['flash'])) {
        return null;
    }
    setcookie('flash', '', ['expires' => time() - 3600, 'path' => '/']);
    $f = json_decode($_COOKIE['flash'], true);
    if (!is_array($f) || !isset($f['type'], $f['pesan']) || !in_array($f['type'], ['success', 'error'], true)) {
        return null;
    }
    return $f;
}
