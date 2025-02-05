<?php
include "config/koneksi.php";

if (isset($_GET['id'])) {
    // Ambil PeminjamanID dari URL
    $PeminjamanID = $_GET['id'];

    // Query untuk menghapus data berdasarkan PeminjamanID
    $sql = "DELETE FROM peminjaman WHERE PeminjamanID = '$PeminjamanID'";

    if (mysqli_query($koneksi, $sql)) {
        // Redirect kembali ke halaman peminjaman setelah penghapusan
        header('Location: pinjaman.php');
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "No ID provided!";
}
?>
