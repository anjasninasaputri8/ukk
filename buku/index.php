<?php
include "../config/koneksi.php";

if(isset($_POST['simpan'])){
    $BukuID = $_POST['BukuID'];
    $sampul = $_FILES['sampul']['name'];  // Nama file gambar yang diunggah
    $Judul = $_POST['Judul'];
    $Penulis = $_POST['Penulis'];
    $Penerbit = $_POST['Penerbit'];
    $TahunTerbit = $_POST['TahunTerbit'];

    // Memindahkan gambar ke folder uploads
    $target_dir = "uploads/";  // Tentukan folder tujuan
    $target_file = $target_dir . basename($_FILES["sampul"]["name"]);
    move_uploaded_file($_FILES["sampul"]["tmp_name"], $target_file);  // Menyimpan gambar di server

    // Check if BukuID already exists in the database
    $check_sql = "SELECT * FROM Buku WHERE BukuID = '$BukuID'";
    $result = mysqli_query($koneksi, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // BukuID already exists
        echo "Error: BukuID already exists!";
    } else {
        // Insert the new record
        $sql = "INSERT INTO Buku(BukuID, sampul, Judul, Penulis, Penerbit, TahunTerbit) 
        VALUES('$BukuID', '$sampul', '$Judul', '$Penulis', '$Penerbit', '$TahunTerbit')";

        if(mysqli_query($koneksi, $sql)){
            header('location:index.php');
        } else {
            echo "Oupss....Maaf proses penyimpanan data tidak berhasil";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Buku</title>
    <style>
        /* Sidebar styles */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111;
            padding-top: 20px;
            color: white;
            padding-left: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        /* Page content */
        .content {
            margin-left: 270px; /* Adjust this to prevent content overlap with the sidebar */
            padding: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: pink;
        }
    </style>
</head>
<body>

<!-- Sidebar Menu -->
<aside class="sidebar">
    <div class="logo">
            <img src="logoperpus.png" alt="Logo" style="display: block; margin: 20% auto; width: 50%; height: auto; padding-top: 20px;">
        </div>
            <ul>
                <li><a href="../perpustakaan/index.php">Dashboard</a></li>
                <li><a href="../buku/index.php">Buku</a></li>
                <li><a href="../pinjaman.php">Peminjaman</a></li>
                <li><a href="../laporan.php">Laporan</a></li>
                <li><a href="../signin.php">logout</a></li>
            </ul>
</aside>

<!-- Page Content -->
<div class="content">
    <h1 style="text-align:center;"><strong>PERPUSTAKAAN DIGITAL</strong></h1>

    <button style="background-color: skyblue;"><a href="form_tambah.php" style="text-decoration: none; color: black;">Tambah</a></button>
    <br>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th> No. </th>
                <th> BukuID</th>
                <th> sampul</th>
                <th> Judul</th>
                <th> Penulis</th>
                <th> Penerbit</th>
                <th> TahunTerbit</th>
                <th> Aksi</th>
            </tr>
        </thead>
        <tbody>
    <?php
    include "../config/koneksi.php";

    $no = 1;
    $data = mysqli_query($koneksi, "SELECT * FROM buku");
    while ($hasil = mysqli_fetch_array($data)) {
    ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $hasil['BukuID']; ?></td>
            <td>
    <!-- Menampilkan gambar dengan ukuran lebih besar -->
    <img src="uploads/<?php echo $hasil['sampul']; ?>" alt="Sampul Buku" style="width: 200px; height: auto;">
</td>

            <td><?php echo $hasil['Judul']; ?></td>
            <td><?php echo isset($hasil['Penulis']) ? $hasil['Penulis'] : 'N/A'; ?></td>
            <td><?php echo isset($hasil['Penerbit']) ? $hasil['Penerbit'] : 'N/A'; ?></td>
            <td><?php echo $hasil['TahunTerbit']; ?></td>
            <td align="center">
                <a href="edit.php?id=<?php echo $hasil['BukuID']; ?>">Edit</a> ||
                <a onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data ini?')" href="hapus.php?id=<?php echo $hasil['BukuID']; ?>">Hapus</a>
            </td>
        </tr>
    </tbody>
    <?php } ?>
</table>

            <?php ?>
    </table>
</div>

</body>
</html>
