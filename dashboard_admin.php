<?php
session_start();
include "koneksi.php";

// 1. Proteksi Halaman
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// 2. Ambil Statistik Nyata dari Database
// Hitung Total User
$query_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_login");
$data_total = mysqli_fetch_assoc($query_total);

// Hitung Jumlah Wisatawan (role mahasiswa)
$query_wisatawan = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_login WHERE role = 'mahasiswa'");
$data_wisatawan = mysqli_fetch_assoc($query_wisatawan);

// Hitung Jumlah Admin
$query_admin_count = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_login WHERE role = 'admin'");
$data_admin_count = mysqli_fetch_assoc($query_admin_count);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Portal Kebersihan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; }
        .top-bar { background-color: #1b3322; color: white; padding: 12px 25px; display: flex; justify-content: space-between; align-items: center; }
        .header-white { background: white; padding: 20px; border-bottom: 1px solid #ddd; margin-bottom: 20px; }
        .stats-box { background: white; border-radius: 8px; padding: 20px; border-left: 5px solid #1b3322; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .table-container { background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .badge-user { background-color: #d1e7dd; color: #0f5132; padding: 5px 12px; border-radius: 15px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="fw-bold"><i class="bi bi-droplets-fill"></i> PORTAL ADMIN KEBERSIHAN</div>
        <div class="d-flex align-items-center">
            <span class="me-3 small">Halo, <strong><?= $_SESSION['username'] ?></strong></span>
            <a href="logout.php" class="btn btn-sm btn-danger px-3">Keluar</a>
        </div>
    </div>

    <div class="header-white">
        <div class="container-fluid">
            <h4 class="fw-bold text-dark">Data Monitoring User & Wisatawan</h4>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stats-box">
                    <small class="text-muted text-uppercase">Total Pengguna Sistem</small>
                    <h3><?= $data_total['total']; ?> User</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-box" style="border-left-color: #198754;">
                    <small class="text-muted text-uppercase">Jumlah Wisatawan</small>
                    <h3><?= $data_wisatawan['total']; ?> Orang</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-box" style="border-left-color: #0d6efd;">
                    <small class="text-muted text-uppercase">Jumlah Admin</small>
                    <h3><?= $data_admin_count['total']; ?> Akun</h3>
                </div>
            </div>
        </div>

        <div class="table-container">
            <h5 class="fw-bold mb-3">Daftar Pengguna Terdaftar</h5>
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID USER</th>
                        <th>USERNAME</th>
                        <th>ROLE / HAK AKSES</th>
                        <th>STATUS LOGIN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Ambil data user asli dari tabel tb_login
                    $tampil = mysqli_query($koneksi, "SELECT * FROM tb_login ORDER BY id_user DESC");
                    while($row = mysqli_fetch_array($tampil)) :
                    ?>
                    <tr>
                        <td>#USR-0<?= $row['id_user']; ?></td>
                        <td><strong><?= $row['username']; ?></strong></td>
                        <td>
                            <span class="badge <?= $row['role'] == 'admin' ? 'bg-primary' : 'bg-success' ?>">
                                <?= strtoupper($row['role']); ?>
                            </span>
                        </td>
                        <td><span class="badge-user">✅ Terdaftar</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-dark"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>