<?php
session_start();
include "config/koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

// Query to fetch the user data based on the username
$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

// Check if the user exists
if ($user) {
    // Verify the password
    if (password_verify($password, $user['password'])) {
        // Store session data
        $_SESSION['username'] = $user['username'];
        $_SESSION['status'] = 'login';
        $_SESSION['role'] = $user['role']; // Store the role for role-based access

        // Redirect based on user role
        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        } elseif ($user['role'] == 'petugas') {
            header("Location: petugas_dashboard.php"); // Redirect to petugas dashboard
        } else {
            header("Location: peminjam_dashboard.php"); // Redirect to peminjam dashboard
        }
    } else {
        // Incorrect password
        echo 'error'; // Return error for incorrect password
    }
} else {
    // Username not found
    echo 'error'; // Return error if username does not exist
}
exit;
?>
