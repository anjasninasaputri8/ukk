<?php
$host = "localhost";
$username = "root";  // Sesuaikan dengan username database Anda
$password = "";      // Sesuaikan dengan password database Anda
$database = "aplikasi_perpustakaan_digital";  // Nama database harus sesuai dengan yang ada di MySQL


// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
