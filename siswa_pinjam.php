<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikasi_perpustakaan_digital";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = mysqli_query($conn, "SELECT * FROM peminjaman WHERE PeminjamanID='$id'");
    $hasil = mysqli_fetch_array($data);
    if (!$hasil) {
        echo "Data tidak ditemukan.";
        exit();
    }
}

// Handle form submission for updating
if (isset($_POST['update'])) {
    $tanggal_pinjam = mysqli_real_escape_string($conn, $_POST['borrowDate']);
    $tanggal_pengembalian = mysqli_real_escape_string($conn, $_POST['returnDate']);
    $StatusPeminjaman = mysqli_real_escape_string($conn, $_POST['StatusPeminjaman']);  // Match the 'name' in the form

    $sql = "UPDATE peminjaman SET 
    TanggalPeminjaman='$tanggal_pinjam', 
    TanggalPengembalian='$tanggal_pengembalian', 
    StatusPeminjaman='$StatusPeminjaman' 
    WHERE PeminjamanID='$id'";


    if (mysqli_query($conn, $sql)) {
        header('Location: pinjaman.php');
        exit();
    } else {
        echo "Oups.... Maaf, proses penyimpanan data tidak berhasil: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Detail Peminjaman Buku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: white;
        }
        h1 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-bottom: 2px solid #ccc;
            background-color: white;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Peminjaman Buku</h1>

        <form method="post" action="">
            <label for="TanggalPeminjaman">Tanggal Peminjaman</label>
            <input type="date" id="TanggalPeminjaman" name="borrowDate" value="<?php echo $hasil['TanggalPeminjaman']; ?>" readonly>

            <label for="TanggalPengembalian">Tanggal Pengembalian</label>
            <input type="date" id="TanggalPengembalian" name="returnDate" value="<?php echo $hasil['TanggalPengembalian']; ?>" readonly>

            <label for="StatusPeminjaman">Status Peminjaman</label>
            <select id="StatusPeminjaman" name="StatusPeminjaman" required>
                <option value="tersedia">Tersedia</option>
                <option value="dipinjam">Dipinjam</option>
                <option value="sudah dikembalikan">Sudah Dikembalikan</option>
                <option value="lewat tempo">Lewat Tempo</option>
            </select>

            <div class="button-container">
                <button type="submit" name="update">Update</button>
                <a href="pinjaman.php" class="cancel-btn" style="display: inline-block; padding: 10px 15px; background-color: #f44336; color: white; text-decoration: none; border-radius: 4px;">Batal</a>
            </div>
        </form>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
