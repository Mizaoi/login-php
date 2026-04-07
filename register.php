<?php
session_start();
include "koneksi.php";
$pesan = ""; $tipe = "";

if (isset($_POST['btn_register'])) {
    $user = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass = $_POST['password'];
    $konf = $_POST['konfirmasi'];
    $role = $_POST['role'];

    if ($pass !== $konf) {
        $pesan = "Konfirmasi password tidak cocok!"; $tipe = "danger";
    } else {
        $cek = mysqli_query($koneksi, "SELECT * FROM tb_login WHERE username = '$user'");
        if (mysqli_num_rows($cek) > 0) {
            $pesan = "Username sudah terpakai!"; $tipe = "danger";
        } else {
            $pass_md5 = MD5($pass);
            mysqli_query($koneksi, "INSERT INTO tb_login (username, password, role) VALUES ('$user', '$pass_md5', '$role')");
            $pesan = "Registrasi Berhasil! Silakan login."; $tipe = "success";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hades - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1350&q=80'); background-size: cover; height: 100vh; display: flex; align-items: center; }
        .register-card { border-radius: 30px; overflow: hidden; border: none; width: 100%; max-width: 450px; margin: auto; }
        .card-header { background-color: #1b3322; color: white; padding: 30px; text-align: center; }
        .card-body { background-color: #fff9f0; padding: 35px; }
        .form-control, .form-select { background-color: #f3ece0; border-radius: 12px; border: 1px solid #d1c7b7; }
        .btn-green { background-color: #1b3322; color: white; border-radius: 12px; width: 100%; padding: 12px; font-weight: bold; border: none; }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="card-header">
            <i class="bi bi-person-plus-fill fs-1"></i>
            <h4 class="fw-bold">Daftar Akun Hades</h4>
        </div>
        <div class="card-body">
            <?php if($pesan): ?>
                <div class="alert alert-<?= $tipe ?> py-2 small text-center"><?= $pesan ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="fw-bold small">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="fw-bold small">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="fw-bold small">Konfirmasi</label>
                        <input type="password" name="konfirmasi" class="form-control" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="fw-bold small">Pilih Role</label>
                    <select name="role" class="form-select">
                        <option value="mahasiswa">Wisatawan (Pengunjung)</option>
                        <option value="admin">Admin (Pengelola)</option>
                    </select>
                </div>
                <button type="submit" name="btn_register" class="btn-green">DAFTAR SEKARANG</button>
            </form>
            <div class="text-center mt-3 small">
                Sudah punya akun? <a href="login.php" class="text-success fw-bold text-decoration-none">Login</a>
            </div>
        </div>
    </div>
</body>
</html>