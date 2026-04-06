<?php
// FILE: koneksi.php
// Fungsi: Menghubungkan ke database MySQL

$host     = "localhost";
$user     = "root";
$password = "";        // kosong jika belum diset password di XAMPP
$database = "db_login"; // sesuaikan nama database

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi GAGAL: " . mysqli_connect_error());
}
mysqli_set_charset($koneksi, "utf8");

// Jika berhasil yaaa berhasil gitu aja sih
?>