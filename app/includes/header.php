<?php
// $base di-set oleh api/index.php ('/'); bisa diganti lewat env APP_BASE.
require_once __DIR__ . '/helpers.php';
$base = $base ?? (getenv('APP_BASE') ?: '/');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Game Database<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="<?php echo e($base); ?>assets/css/style.css">
</head>
<body>
    <header>
        <h1>Game Database</h1>
        <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
        <nav>
            <ul>
                <li><a href="<?php echo e($base); ?>index.php">Beranda</a></li>
                <li><a href="<?php echo e($base); ?>senjata/list.php">Daftar Senjata</a></li>
                <li><a href="<?php echo e($base); ?>senjata/tambah.php">Tambah Senjata</a></li>
                <li><a href="<?php echo e($base); ?>karakter/list.php">Daftar Karakter</a></li>
                <li><a href="<?php echo e($base); ?>karakter/tambah.php">Tambah Karakter</a></li>
            </ul>
        </nav>
    </header>

    <main>
