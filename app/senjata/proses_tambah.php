<?php
require __DIR__ . '/../includes/helpers.php';
require __DIR__ . '/../includes/koneksi.php';

$nama = trim($_POST['nama'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$kerusakan = $_POST['kerusakan'] ?? '';
$durabilitas = $_POST['durabilitas'] ?? '';

// Validasi server-side — wajib ada meski sudah divalidasi JS di Jobsheet 5,
// karena validasi client bisa dilewati (nonaktifkan JS / kirim request manual).
$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($deskripsi === '') {
    $errors[] = "Deskripsi wajib diisi.";
}
if (!is_numeric($kerusakan) || $kerusakan < 0) {
    $errors[] = "Kerusakan tidak boleh negatif.";
}
if (!is_numeric($durabilitas) || $durabilitas < 0) {
    $errors[] = "Durabilitas tidak boleh negatif.";
}

if (!empty($errors)) {
    set_flash('error', implode(' ', $errors));
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO senjata (nama, deskripsi, kerusakan, durabilitas)
     VALUES (:nama, :deskripsi, :kerusakan, :durabilitas)
     RETURNING id"
);
$stmt->execute([
    'nama' => $nama,
    'deskripsi' => $deskripsi,
    'kerusakan' => (int) $kerusakan,
    'durabilitas' => (int) $durabilitas,
]);

set_flash('success', 'Senjata berhasil ditambahkan.');
header('Location: list.php');
exit;
