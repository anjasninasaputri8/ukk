<?php
// Mulai sesi
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Alihkan ke halaman login atau halaman lain setelah logout
header("Location:signin.php");
exit;
?>
