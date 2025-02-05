<?php
include "../config/koneksi.php";

if(isset($_POST['simpan'])){
    $PinjamanID = $_POST['PinjamanID'];
    $UserID = $_POST['UserID'];
    $BukuID = $_POST['BukuID'];
    $TanggalPeminjaman = $_POST['TanggalPeminjaman'];
    $TanggalPengembalian = $_POST['TanggalPengembalian'];
    $StatusPeminjaman = $_POST['StatusPeminjaman'];

    // Check if BukuID already exists in the database
    $check_sql = "SELECT * FROM peminjaman WHERE PeminjamanID = '$PeminjamanID'";
    $result = mysqli_query($koneksi, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // BukuID already exists
        echo "Error:  PeminjamanID already exists!";
    } else {
        // Insert the new record
        $sql = "INSERT INTO peminjaman(TanggalPeminjaman, TanggalPengembalian, StatusPeminjaman) 
        VALUES('$TanggalPeminjaman', '$TanggalPengembalian', '$StatusPeminjaman')";

        if(mysqli_query($koneksi, $sql)){
            header('location:peminjaman.php');
        } else {
            echo "Oupss....Maaf proses penyimpanan data tidak berhasil";
        }
    }
}


?>
