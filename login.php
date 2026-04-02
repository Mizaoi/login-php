<?php
include "koneksi.php";

$pesan = "";

if (isset($_POST['btn_login'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  if (empty($username) || empty($password)) {
    $pesan = "Username dan password tidak boleh kosong!";
  } else {
    $query = "SELECT * FROM tb_login WHERE username = '$username' AND password = MD5('$password')";
    $hasil = mysqli_query($koneksi, $query);
    $jumlah = mysqli_num_rows($hasil);

  if ($jumlah == 1) {
    $data = mysqli_fetch_assoc($hasil);
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    if ($date['role'] == 'admin') {
      header("Location: dashboard_admin.php");
    } else {
      header("Location: dashboard_mahasiswa.php");
    }
    exit();
  } else {
    $pesan = "Username atau password salah!";
  }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.
      0">
  <title>Portal Admin Kebersihan - Login</title>
  <link rel="stylesheet" href="style.css">
</head>
  <body class="login-body">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>🧹 Portal Admin Kebersihan</h1>
                <p>Pantau dan kelola laporan sampah wisatawan Tancak Panti</p>
            </div>
          
           <?php if ($pesan != "") : ?>
                <div class="error-msg">⚠️ <?= htmlspecialchars($pesan) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
              <button type="submit" name="btn_login" class="btn_login">Masuk ke Dashboard</button>
            </form>
        <div class="demo-info">
          Demo: username <strong>admin</strong> - password <strong>tancak123</strong><br>
          <small style="color:#888;">atau <a href="register.php" style="color:#667eea;">Daftar akun baru</a></small>
        </div>
        </div>
    </div>
  </body>
</html>

                </head>
      
