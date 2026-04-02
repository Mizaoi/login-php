<?php
// =============================================
// FILE: register.php
// Fungsi: Halaman pendaftaran akun baru
// =============================================

session_start();
include "koneksi.php";

$pesan       = "";
$jenis_pesan = ""; // "sukses" atau "error"

// ---- REGISTER NJIR ----
if (isset($_POST['btn_register'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $konfirm  = trim($_POST['konfirmasi']);
    $role     = $_POST['role'];  // 'admin' atau 'mahasiswa'

    // --- KONFIRMASI ---
    if (empty($username) || empty($password) || empty($konfirm)) {
        $pesan       = "Semua field wajib diisi!";
        $jenis_pesan = "error";

    } elseif (strlen($username) < 4) {
        $pesan       = "Username minimal 4 karakter!";
        $jenis_pesan = "error";

    } elseif (strlen($password) < 6) {
        $pesan       = "Password minimal 6 karakter!";
        $jenis_pesan = "error";

    } elseif ($password !== $konfirm) {
        $pesan       = "Password dan konfirmasi password tidak cocok!";
        $jenis_pesan = "error";

    } else {
        $cek   = mysqli_query($koneksi, "SELECT * FROM tb_login WHERE username = '$username'");
        $exist = mysqli_num_rows($cek);

        if ($exist > 0) {
            $pesan       = "Username '$username' sudah digunakan. Pilih username lain!";
            $jenis_pesan = "error";
        } else {
            $password_hash = MD5($password);

            $query  = "INSERT INTO tb_login (username, password, role) 
                       VALUES ('$username', '$password_hash', '$role')";
            $simpan = mysqli_query($koneksi, $query);

            if ($simpan) {
                $pesan       = "Akun berhasil dibuat! Silakan login.";
                $jenis_pesan = "sukses";
            } else {
                $pesan       = "Gagal menyimpan data: " . mysqli_error($koneksi);
                $jenis_pesan = "error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Portal Kebersihan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #1a5f7a 0%, #0d3b4f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Container */
        .register-container {
            width: 100%;
            max-width: 460px;
        }

        /* Card */
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            backdrop-filter: blur(0px);
            transition: transform 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-5px);
        }

        /* gradien */
        .card-header {
            background: linear-gradient(135deg, #2c7a4d 0%, #1a5f3a 100%);
            padding: 32px 28px;
            text-align: center;
            color: white;
        }

        .icon-logo {
            font-size: 48px;
            margin-bottom: 12px;
            display: inline-block;
            background: rgba(255,255,255,0.2);
            width: 80px;
            height: 80px;
            line-height: 80px;
            border-radius: 50%;
        }

        .card-header h2 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .card-header .subtitle {
            font-size: 13px;
            opacity: 0.85;
            margin-top: 5px;
        }

        /* Body */
        .card-body {
            padding: 32px 32px 28px;
        }

        /* styling */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-style: normal;
            font-size: 16px;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 13px 15px 13px 42px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8fafc;
            font-family: inherit;
        }

        .input-group select {
            padding: 13px 15px 13px 42px;
            cursor: pointer;
            appearance: none;
            background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") no-repeat right 15px center;
            background-size: 18px;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #2c7a4d;
            background: white;
            box-shadow: 0 0 0 3px rgba(44, 122, 77, 0.1);
        }

        /* Hint */
        .hint {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 6px;
            margin-left: 5px;
        }

        /* notifikasi */
        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #e6f7ed;
            border: 1px solid #2c7a4d;
            color: #1a5f3a;
        }

        .alert-error {
            background: #fee2e2;
            border: 1px solid #dc2626;
            color: #991b1b;
        }

        /* Tombol */
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #2c7a4d 0%, #1a5f3a 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(44, 122, 77, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        /* Link login */
        .login-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .login-link p {
            font-size: 13px;
            color: #64748b;
        }

        .login-link a {
            color: #2c7a4d;
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: #1a5f3a;
            text-decoration: underline;
        }

        /* Demo info */
        .demo-info {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 12px 16px;
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .demo-info strong {
            color: #2c7a4d;
        }

        /* Icon */
        .icon-user:before { content: "👤"; }
        .icon-lock:before { content: "🔒"; }
        .icon-check:before { content: "✓"; }
        .icon-role:before { content: "👥"; }

        /* Responsive */
        @media (max-width: 480px) {
            .card-body {
                padding: 24px 20px;
            }
            .card-header {
                padding: 25px 20px;
            }
            .card-header h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-card">
       
        <div class="card-header">
            <div class="icon-logo">🌿</div>
            <h2>Daftar Akun Baru</h2>
            <p class="subtitle">Portal Kebersihan Tancak Panti</p>
        </div>

        <!-- Body -->
        <div class="card-body">

            <!-- Tampilkan pesan -->
            <?php if ($pesan != "") : ?>
                <div class="alert alert-<?= $jenis_pesan ?>">
                    <span><?= ($jenis_pesan == 'sukses') ? '✅' : '⚠️' ?></span>
                    <span><?= $pesan ?></span>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form method="POST" action="">

                <div class="form-group">
                    <label>👤 USERNAME</label>
                    <div class="input-group">
                        <i style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%);">👤</i>
                        <input type="text" name="username" 
                               placeholder="Masukkan username"
                               value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                               autocomplete="off">
                    </div>
                    <p class="hint">Minimal 4 karakter</p>
                </div>

                <div class="form-group">
                    <label>🔒 PASSWORD</label>
                    <div class="input-group">
                        <i style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%);">🔒</i>
                        <input type="password" name="password" 
                               placeholder="Masukkan password">
                    </div>
                    <p class="hint">Minimal 6 karakter</p>
                </div>

                <div class="form-group">
                    <label>✓ KONFIRMASI PASSWORD</label>
                    <div class="input-group">
                        <i style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%);">✓</i>
                        <input type="password" name="konfirmasi" 
                               placeholder="Ulangi password">
                    </div>
                </div>

                <div class="form-group">
                    <label>👥 ROLE / HAK AKSES</label>
                    <div class="input-group">
                        <i style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%);">👥</i>
                        <select name="role">
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>

                <button type="submit" name="btn_register" class="btn-register">
                    🌿 Daftar Sekarang anjay
                </button>

            </form>

            <div class="login-link">
                <p>Sudah punya akun?<a href="login.php">Login di sini</a></p>
            </div>

            <div class="demo-info">
                💡 <strong>Info:</strong> Akun Admin dapat mengelola semua user.<br>
                Mahasiswa hanya bisa melihat dashboard sendiri.
            </div>

        </div>
    </div>
</div>

</body>
</html>
