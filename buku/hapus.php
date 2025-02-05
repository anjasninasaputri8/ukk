<?php
include "../config/koneksi.php";

// Capture the 'id' from the URL and sanitize it
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Construct the DELETE query with a WHERE condition to specify which record to delete
$data = mysqli_query($koneksi, "DELETE FROM buku WHERE BukuID = '$id'");

if ($data) {
    // If the deletion was successful, redirect to the list of books
    header('Location: index.php');
    exit;  // Make sure the script stops here after redirection
} else {
    // If the deletion failed, show an error message
    echo "Maaf, data tidak berhasil dihapus.";
}
?>
