<?php
session_start();
include "koneksi.php";
$pesan = "";

if (isset($_POST['btn_login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = "SELECT * FROM tb_login WHERE username = '$username' AND password = MD5('$password')";
    $hasil = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($hasil) == 1) {
        $data = mysqli_fetch_assoc($hasil);
        $_SESSION['id_user']  = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role'];

        // Cek Role dan arahkan ke file yang benar
        if ($data['role'] == 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_wisatawan.php");
        }
        exit();
    } else {
        $pesan = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Portal Kebersihan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?auto=format&fit=crop&w=1350&q=80');
            background-size: cover; height: 100vh; display: flex; align-items: center;
        }
        .login-card { border-radius: 20px; overflow: hidden; border: none; width: 100%; max-width: 400px; margin: auto; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .card-header { background-color: #1b3322; color: white; padding: 30px; text-align: center; }
        .card-body { background-color: #fff9f0; padding: 30px; }
        .input-group-custom { position: relative; margin-bottom: 20px; }
        .input-group-custom i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #555; z-index: 10; }
        .input-group-custom .form-control { padding-left: 45px; background-color: #f3ece0; border: 1px solid #d1c7b7; border-radius: 10px; height: 45px; }
        .btn-green { background-color: #1b3322; color: white; border-radius: 10px; padding: 12px; width: 100%; font-weight: bold; border: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="card-header">
            <i class="bi bi-shield-check fs-1"></i>
            <h5 class="mt-2 fw-bold">Portal Kebersihan Tancak Panti</h5>
            <p class="small mb-0 opacity-75">Manajemen Sampah Wisatawan</p>
        </div>
        <div class="card-body">
            <?php if($pesan): ?>
                <div class="alert alert-danger py-2 small text-center"><?= $pesan ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="input-group-custom">
                    <i class="bi bi-person"></i>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="input-group-custom">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" name="btn_login" class="btn-green">Masuk ke Dashboard</button>
            </form>
            <div class="text-center mt-3 small">
                Belum punya akun? <a href="register.php" class="text-success fw-bold text-decoration-none">Daftar</a>
            </div>
        </div>
    </div>
</body>
</html>