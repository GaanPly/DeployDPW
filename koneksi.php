<?php
// Ambil dari environment variable (Render/Supabase) kalau ada,
// kalau tidak fallback ke setting lokal (Laragon/dev).
$host = getenv('DB_HOST') ?: "localhost";
$port = getenv('DB_PORT') ?: "5432";
$db   = getenv('DB_NAME') ?: "game_database";
$user = getenv('DB_USER') ?: "postgres";
$pass = getenv('DB_PASS') ?: "postgres";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
