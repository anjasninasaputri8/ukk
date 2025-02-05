<?php
$koneksi = mysqli_connect("localhost", "root", "", "aplikasi_perpustakaan_digital"); // Update with your actual database credentials

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}



// Fetching data from Buku and Peminjaman tables
$buku_sql = "SELECT * FROM Buku";
$buku_result = mysqli_query($koneksi, $buku_sql);

$pinjaman_sql = "SELECT * FROM peminjaman";
$pinjaman_result = mysqli_query($koneksi, $pinjaman_sql);

// Check if the download button is pressed
if (isset($_POST['download_pdf'])) {
  // Adjust this line to the correct path of the TCPDF library
  require_once('libs/tcpdf/tcpdf.php');
  $pdf = new TCPDF();
  $pdf->AddPage();
  $pdf->SetFont('helvetica', '', 12);
  $pdf->Cell(0, 10, 'Test PDF', 0, 1, 'C');
  $pdf->Output();
  
// Your code continues...


    // Add title
    $pdf->Cell(0, 10, 'Laporan Perpustakaan Digital', 0, 1, 'C');

    // Add Buku Data
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Daftar Buku', 0, 1, 'L');
    $pdf->Cell(30, 10, 'BukuID', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Judul', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Penulis', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Penerbit', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Tahun Terbit', 1, 1, 'C');

    while ($row = mysqli_fetch_assoc($buku_result)) {
        print_r($row); // Add this to debug the output
        $pdf->Cell(30, 10, $row['BukuID'], 1, 0, 'C');
        $pdf->Cell(50, 10, $row['Judul'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['Penulis'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['Penerbit'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['TahunTerbit'], 1, 1, 'C');
    }
    
    

    // Add Peminjaman Data
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Daftar Peminjaman', 0, 1, 'L');
    $pdf->Cell(40, 10, 'PeminjamanID', 1, 0, 'C');
    $pdf->Cell(40, 10, 'UserID', 1, 0, 'C');
    $pdf->Cell(40, 10, 'BukuID', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Tanggal Peminjaman', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Tanggal Pengembalian', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Status Peminjaman', 1, 1, 'C');

    while ($row = mysqli_fetch_assoc($pinjaman_result)) {
        $pdf->Cell(40, 10, $row['PeminjamanID'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['UserID'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['BukuID'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['TanggalPeminjaman'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['TanggalPengembalian'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['StatusPeminjaman'], 1, 1, 'C');
    }

    // Output PDF
    $pdf->Output('laporan_perpustakaan.pdf', 'I');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Perpustakaan Digital</title>
</head>
<body>

<h1>Laporan Perpustakaan Digital</h1>

<form method="post" action="">
    <button type="submit" name="download_pdf" style="background-color: skyblue;">Download Laporan PDF</button>
</form>

<h2>Daftar Buku</h2>
<table border="1">
    <tr>
        <th>No.</th>
        <th>BukuID</th>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Penerbit</th>
        <th>Tahun Terbit</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($buku_result)) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['BukuID'] . "</td>";
        echo "<td>" . $row['Judul'] . "</td>";
        echo "<td>" . $row['Penulis'] . "</td>";
        echo "<td>" . $row['Penerbit'] . "</td>";
        echo "<td>" . $row['TahunTerbit'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<h2>Daftar Peminjaman</h2>
<table border="1">
    <tr>
        <th>No.</th>
        <th>PeminjamanID</th>
        <th>UserID</th>
        <th>BukuID</th>
        <th>Tanggal Peminjaman</th>
        <th>Tanggal Pengembalian</th>
        <th>Status Peminjaman</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($pinjaman_result)) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['PeminjamanID'] . "</td>";
        echo "<td>" . $row['UserID'] . "</td>";
        echo "<td>" . $row['BukuID'] . "</td>";
        echo "<td>" . $row['TanggalPeminjaman'] . "</td>";
        echo "<td>" . $row['TanggalPengembalian'] . "</td>";
        echo "<td>" . $row['StatusPeminjaman'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
