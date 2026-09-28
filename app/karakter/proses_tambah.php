<?php
require __DIR__ . '/../includes/helpers.php';
require __DIR__ . '/../includes/koneksi.php';

$nama = trim($_POST['nama'] ?? '');
$nyawa = trim($_POST['nyawa'] ?? '');
$perlindungan = trim($_POST['perlindungan'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($nyawa === '') {
    $errors[] = "Nyawa wajib diisi.";
}
if ($perlindungan === '') {
    $errors[] = "Perlindungan wajib diisi.";
}

if (!empty($errors)) {
    set_flash('error', implode(' ', $errors));
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO karakter (nama, nyawa, perlindungan)
     VALUES (:nama, :nyawa, :perlindungan)
     RETURNING id"
);
$stmt->execute([
    'nama' => $nama,
    'nyawa' => $nyawa,
    'perlindungan' => $perlindungan,
]);

set_flash('success', 'Karakter berhasil ditambahkan.');
header('Location: list.php');
exit;
