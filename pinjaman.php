<?php
include "config/koneksi.php";

$host = "localhost"; // or your host
$user = "root"; // your database username
$pass = ""; // your database password
$dbname = "aplikasi_perpustakaan_digital"; // your database name

$koneksi = mysqli_connect($host, $user, $pass, $dbname);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['simpan'])) {
    // Ambil data dari form
    $PeminjamanID = $_POST['PeminjamanID'];
    $UserID = $_POST['UserID'];
    $BukuID = $_POST['BukuID'];
    $TanggalPeminjaman = $_POST['TanggalPeminjaman'];
    $TanggalPengembalian = $_POST['TanggalPengembalian'];
    $StatusPeminjaman = $_POST['StatusPeminjaman'];

    // Validasi jika PeminjamanID sudah ada di database
    $check_sql = "SELECT * FROM peminjaman WHERE PeminjamanID = '$PeminjamanID'";
    $result = mysqli_query($koneksi, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        echo "Error: PeminjamanID sudah ada!";
    } else {
        // Query untuk memasukkan data baru
        $sql = "INSERT INTO peminjaman (PeminjamanID, UserID, BukuID, TanggalPeminjaman, TanggalPengembalian, StatusPeminjaman) 
        VALUES ('$PeminjamanID', '$UserID', '$BukuID', '$TanggalPeminjaman', '$TanggalPengembalian', '$StatusPeminjaman')";

        if (mysqli_query($koneksi, $sql)) {
            // Redirect setelah berhasil menambah data
            header('Location: pinjaman.php');
        } else {
            echo "Oupss.... Maaf, proses penyimpanan data tidak berhasil.";
        }
    }
}

// Query to fetch pinjaman records
$sql_pinjaman = "SELECT * FROM peminjaman";
$result = mysqli_query($koneksi, $sql_pinjaman);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: cyan;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            position: fixed;
            height: 100%;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }

        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1, h2 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .search-container {
            margin-bottom: 20px;
        }

        /* Remove underline from status column */
        .no-underline {
            text-decoration: none;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="logoperpus.png" alt="Logo" style="display: block; margin: 20% auto; width: 50%; height: auto; padding-top: 20px;">
        </div>
   
        <ul>
            <li><a href="perpustakaan/index.php">Dashboard</a></li>
            <li><a href="buku/index.php">Buku</a></li>
            <li><a href="pinjaman.php">Peminjaman</a></li>
            <li><a href="laporan.php">Laporan</a></li>
            <li><a href="signin.php">logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container">
            <h1>Pinjaman Perpustakaan</h1>
            <div class="table-container">
                <h2>Daftar Pinjaman</h2>
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Cari..." onkeyup="filterTable()">
                    <button style="background-color: skyblue;"><a href="form_tambah_peminjaman.php">Tambah</a></button>
                </div>

                <table id="pinjamanTable">
                    <thead>
                        <tr>
                            <th>PeminjamanID</th>
                            <th>UserID</th>
                            <th>BukuID</th>
                            <th>Tanggal peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Status peminjaman</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="pinjamanTableBody">
    <?php
    // Check if records exist
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr onclick='redirectToPage(" . $row['PeminjamanID'] . ")'>";
            echo "<td>" . htmlspecialchars($row['PeminjamanID']) . "</td>";
            echo "<td>" . htmlspecialchars($row['UserID']) . "</td>";
            echo "<td>" . htmlspecialchars($row['BukuID']) . "</td>";  
            echo "<td>" . htmlspecialchars($row['TanggalPeminjaman']) . "</td>"; 
            echo "<td>" . htmlspecialchars($row['TanggalPengembalian']) . "</td>";
            echo "<td class='no-underline'>" . htmlspecialchars($row['StatusPeminjaman']) . "</td>"; 
            // Add the delete button in a new column
            echo "<td><a href='hapus_pinjaman.php?id=" . $row['PeminjamanID'] . "' class='btn btn-danger btn-sm'>Hapus</a></td>";

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No records found</td></tr>";
    }
    ?>
</tbody>

                </table>
            </div>

            <script>
                function redirectToPage(bookId) {
                    window.location.href = 'siswa_pinjam.php?id=' + bookId;
                }

                function filterTable() {
                    const input = document.getElementById("searchInput");
                    const filter = input.value.toLowerCase();
                    const table = document.getElementById("pinjamanTable");
                    const rows = table.getElementsByTagName("tr");

                    for (let i = 1; i < rows.length; i++) {
                        const cells = rows[i].getElementsByTagName("td");
                        let found = false;

                        for (let j = 0; j < cells.length; j++) {
                            if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                                found = true;
                                break;
                            }
                        }

                        rows[i].style.display = found ? "" : "none";
                    }
                }
            </script>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
