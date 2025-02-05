<?php
include "../config/koneksi.php";

if(isset($_POST['simpan'])){
    $BukuID = $_POST['BukuID'];
    $sampul = $_POST['sampul'];
    $Judul = $_POST['Judul'];
    $Penulis = $_POST['Penulis'];
    $Penerbit = $_POST['Penerbit'];
    $TahunTerbit = $_POST['TahunTerbit'];

    // Check if BukuID already exists in the database
    $check_sql = "SELECT * FROM Buku WHERE BukuID = '$BukuID'";
    $result = mysqli_query($koneksi, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // BukuID already exists
        echo "Error: BukuID already exists!";
    } else {
        // Insert the new record
        $sql = "INSERT INTO Buku(Judul, Penulis, Penerbit, TahunTerbit) 
        VALUES('$Judul', '$Penulis', '$Penerbit', '$TahunTerbit')";

        if(mysqli_query($koneksi, $sql)){
            header('location:index.php');
        } else {
            echo "Oupss....Maaf proses penyimpanan data tidak berhasil";
        }
    }
}


?>
