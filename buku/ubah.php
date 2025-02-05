<?php
include "../config/koneksi.php";
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM buku WHERE id='$id'");
$hasil = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html> 
<head>
    <title>Mengubah Data Mahasiswa</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 1200px; /* Increased width */
}

h1 {
    font-size: 28px; /* Increased font size */
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #555;
}

input[type="text"], input[type="number"], input[type="email"], input[type="date"], select {
    width: 100%;
    padding: 10px 15px; /* Adjusted padding for a more streamlined look */
    margin-bottom: 20px;
    border: none; /* Remove default border */
    border-bottom: 2px solid #ccc; /* Add bottom border */
    border-radius: 0; /* Remove border radius for a straight line */
    box-sizing: border-box;
}

input[type="text"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="date"]:focus, select:focus {
    border-bottom-color: #4CAF50; /* Change border color on focus */
    outline: none; /* Remove default outline */
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr) repeat(3, 1fr);
    grid-template-rows: auto auto;
    gap: 20px;
    align-items: start;
}

.form-grid .input-group {
    display: flex;
    flex-direction: column;
    padding: 0 15px;
    background: #fff;
}

.form-grid .input-group:nth-child(-n+3) {
    grid-column: span 1;
}

.form-grid .input-group:nth-child(4), .form-grid .input-group:nth-child(5) {
    grid-column: span 2;
}

.form-grid .input-group:nth-child(6), .form-grid .input-group:nth-child(7) {
    grid-column: span 3;
}

.button-container {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

button[type="submit"], .cancel-btn, .delete-btn {
    padding: 15px 30px; /* Increased padding */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    font-size: 18px; /* Increased font size */
    transition: background-color 0.3s ease;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: white;
}

.cancel-btn {
    background-color: #ff9800;
    color: white;
}

.delete-btn {
    background-color: #f44336;
    color: white;
    text-decoration: none;
}

button[type="submit"]:hover, .cancel-btn:hover, .delete-btn:hover {
    opacity: 0.9;
}
</style>
</head>
<body>
    <div class="container">
        <h1>Ubah Data</h1>
        <form method="post" action="">
            <div class="form-grid">
                <!-- Left Column (2 items) -->
                <div class="input-group">
                    <label for="BukuID">BukuID</label>
                    <input type="text" id="BukuID" name="BukuID" value="<?php echo htmlspecialchars($hasil['BukuID']);?>" readonly>
                </div>
                <div class="input-group">
                    <label for="sampul">sampul</label>
                    <input type="file" id="sampul" name="sampul" value="<?php echo htmlspecialchars($hasil['sampul']);?>" 
                </div>
                <div class="input-group">
                    <label for="Judul">Judul</label>
                    <input type="text" id="Judul" name="Judul" value="<?php echo htmlspecialchars($hasil['Judul']);?>">
                </div>

                <!-- Center Column (4 items) -->
                <div class="input-group">
                    <label for="Penulis">Penulis</label>
                    <input type="text" id="Penulis" name="Penulis" value="<?php echo htmlspecialchars($hasil['Penulis']);?>">
                </div>
                <div class="input-group">
                    <label for="Penerbit">Penerbit</label>
                    <input type="text" id="Penerbit" name="Penerbit" value="<?php echo htmlspecialchars($hasil['Penerbit']);?>">
                </div>
               
                <label for="TanggalTerbit">TanggalTerbit</label>
                    <input type="date" id="TanggalTerbit" name="TanggalTerbit" value="<?php echo date('Y-m-d'); ?>">
                </div>

              
               

               
            </div>

        
            <div class="button-container">
                <a href="../../button.php" class="cancel-btn">Batal</a>
                <a onclick="return confirm('Yakin ingin menghapus data ini?')" href="hapus.php?id=<?php echo urlencode($hasil['id']); ?>" class="delete-btn">Hapus</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['simpan'])) {
    $BukuID = mysqli_real_escape_string($koneksi, $_POST['BukuID']);
    $sampul = mysqli_real_escape_string($koneksi, $_POST['sampul']);
    $Judul = mysqli_real_escape_string($koneksi, $_POST['Judul']);
    $Penulis = mysqli_real_escape_string($koneksi, $_POST['Penulis']);
    $Penerbit = mysqli_real_escape_string($koneksi, $_POST['Penerbit']);
    $TahunTerbit = mysqli_real_escape_string($koneksi, $_POST['TahunTerbit']);
   

    $sql = "UPDATE siswa SET 
        BukuID='$BukuID', sampul='$sampul', Judul='$Judul', Penulis='$Penulis', Penerbit='$Penerbit', TahunTerbit='$TahunTerbit',
        foto='$foto', 
        WHERE id='$id'";

    if (mysqli_query($koneksi, $sql)) {
        header('Location: ../perpustakaan/index.php');
        exit();
    } else {
        echo "Oupss....Maaf proses penyimpanan data tidak berhasil: " . mysqli_error($koneksi);
    }
}
?>