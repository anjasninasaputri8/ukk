<?php

$host     = "localhost";
$username = "root";
$password = "";
$database = "aplikasi_perpustakaan_digital";

$koneksi = new mysqli($host, $username, $password, $database);
if ($koneksi){
    echo "";
}else{
	echo "database tidak terkoneksi";
}
?>