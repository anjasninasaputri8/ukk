<?php
session_start();

// Jika user belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header('Location: signin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan Digital</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar Menu -->
        <aside class="sidebar">
        <div class="logo">
            <img src="logoperpus.png" alt="Logo" style="display: block; margin: 20% auto; width: 50%; height: auto; padding-top: 20px;">
        </div>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="../buku/index.php">Buku</a></li>
                <li><a href="../pinjaman.php">Peminjaman</a></li>
                <li><a href="../laporan.php">Laporan</a></li>
                <li><a href="../signin.php">logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1>Selamat datang di Dashboard Perpustakaan Digital</h1>

            <h2>Daftar Buku</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
