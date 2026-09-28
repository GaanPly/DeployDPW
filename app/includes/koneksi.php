<?php
// Koneksi PostgreSQL. Di Vercel gunakan environment variable DATABASE_URL
// (mis. dari Neon/Supabase): postgresql://user:pass@host:5432/dbname?sslmode=require
// Bila tidak diset, dipakai default lokal di bawah.
$url = getenv('DATABASE_URL') ?: (getenv('POSTGRES_URL') ?: ($_SERVER['DATABASE_URL'] ?? ''));

if ($url !== '') {
    $p = parse_url($url);
    $host = $p['host'] ?? 'localhost';
    $port = $p['port'] ?? 5432;
    $db   = ltrim($p['path'] ?? '', '/');
    $user = rawurldecode($p['user'] ?? '');
    $pass = rawurldecode($p['pass'] ?? '');
    parse_str($p['query'] ?? '', $q);
    $ssl = $q['sslmode'] ?? (in_array($host, ['localhost', '127.0.0.1'], true) ? 'prefer' : 'require');
} else {
    $host = "localhost";
    $port = "5432";
    $db   = "game_database";
    $user = "postgres";
    $pass = "postgres";
    $ssl  = "prefer";
}

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db;sslmode=$ssl", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Koneksi database gagal: " . $e->getMessage());
    http_response_code(500);
    die("Koneksi database gagal. Periksa environment variable DATABASE_URL.");
}
