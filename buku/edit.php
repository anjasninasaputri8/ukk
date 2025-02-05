<?php
include "../config/koneksi.php";

// Periksa apakah ID siswa diterima dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Jika formulir disubmit, proses update data
if (isset($_POST['simpan'])) {
    $BukuID = intval($_POST['BukuID']); // Pastikan ID di-cast ke integer
    $Judul = mysqli_real_escape_string($koneksi, $_POST['Judul']);
    $Penulis = mysqli_real_escape_string($koneksi, $_POST['Penulis']);
    $Penerbit = mysqli_real_escape_string($koneksi, $_POST['Penerbit']);
    $TahunTerbit = mysqli_real_escape_string($koneksi, $_POST['TahunTerbit']);

    // Handle file upload (sampul)
    if (isset($_FILES['sampul']) && $_FILES['sampul']['error'] == 0) {
        $sampul = $_FILES['sampul'];
        $targetDir = "uploads/"; // Specify your target directory for file uploads
        $targetFile = $targetDir . basename($sampul['name']);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate file type (optional)
        if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($sampul['tmp_name'], $targetFile)) {
                // Successfully uploaded file, store the file path
                $sampulPath = mysqli_real_escape_string($koneksi, $targetFile);
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit();
            }
        } else {
            echo "Only image files (JPG, JPEG, PNG, GIF) are allowed.";
            exit();
        }
    } else {
        // If no file is uploaded, retain the old file path
        // Ensure that 'sampul_old' is set before using it to prevent errors
        $sampulPath = isset($_POST['sampul_old']) ? mysqli_real_escape_string($koneksi, $_POST['sampul_old']) : '';
    }

    // Update the record in the database
    $sql = "UPDATE buku SET BukuID='$BukuID', sampul='$sampulPath', Judul='$Judul', Penulis='$Penulis', Penerbit='$Penerbit', TahunTerbit='$TahunTerbit' WHERE BukuID='$id'";

    if (mysqli_query($koneksi, $sql)) {
        // If successful, redirect to index.php
        header('Location:index.php');
        exit();
    } else {
        echo "Oups... Maaf, proses penyimpanan data tidak berhasil.";
    }
}

// Ambil data buku untuk ditampilkan di formulir
$data = mysqli_query($koneksi, "SELECT * FROM buku WHERE BukuID='$id'");
$hasil = mysqli_fetch_array($data);

// Periksa apakah data ditemukan untuk ID buku tersebut
if (!$hasil) {
    echo "Buku dengan ID $id tidak ditemukan.";
    exit();
}


?> 

<!DOCTYPE html>
<html>
<head>
    <title>Mengubah Data Buku</title>
</head>
<body>
    <h1>Ubah Data Buku</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <label>BukuID</label><br>
        <input type="text" name="BukuID" value="<?php echo htmlspecialchars($hasil['BukuID']); ?>"><br>
        <label>sampul</label><br>
        <input type="file" name="sampul"><br>
        <input type="hidden" name="sampul_old" value="<?php echo htmlspecialchars(isset($hasil['sampul']) ? $hasil['sampul'] : ''); ?>">
        <label>Judul</label><br>
        <input type="text" name="Judul" value="<?php echo htmlspecialchars($hasil['Judul']); ?>"><br>
        <label>Penulis</label><br>
        <input type="text" name="Penulis" value="<?php echo htmlspecialchars(isset($hasil['Penulis']) ? $hasil['Penulis'] : ''); ?>"><br>
        <label>Penerbit</label><br>
        <input type="text" name="Penerbit" value="<?php echo htmlspecialchars(isset($hasil['Penerbit']) ? $hasil['Penerbit'] : ''); ?>"><br>
        <label>TahunTerbit</label><br>
        <input type="text" name="TahunTerbit" value="<?php echo htmlspecialchars($hasil['TahunTerbit']); ?>"><br>
        
        <br>
        <button type="submit" name="simpan">Simpan</button> || <button><a href="index.php">Kembali</a></button>
    </form>

</body>
</html>
