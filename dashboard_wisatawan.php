<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: dashboard_admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Wisatawan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f3ece0; }

        .navbar {
            background-color: #1b3322;
            color: white;
            padding: 14px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .judul { font-size: 18px; font-weight: bold; }
        .navbar a.btn-logout {
            background-color: #dc3545;
            color: white;
            padding: 7px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
        }

        .konten { max-width: 750px; margin: 40px auto; padding: 0 15px; }

        .kartu-welcome {
            background: linear-gradient(135deg, #1b3322, #2d5a3c);
            color: white;
            padding: 30px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
        }

        .kartu-welcome .icon { font-size: 48px; margin-bottom: 12px; }

        .kartu-info {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 22px 25px;
            margin-bottom: 20px;
        }

        .kartu-info h3 {
            color: #1b3322;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f3ece0;
        }

        table { width: 100%; border-collapse: collapse; }
        td { padding: 12px 5px; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
        td:first-child { color: #7f8c8d; width: 40%; font-weight: bold; }

        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .kartu-akses {
            background: #fff9e6;
            border: 1px solid #f1c40f;
            border-radius: 8px;
            padding: 18px 22px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="judul">🌿 Portal Wisatawan</div>
    <div>
        <span style="font-size: 13px; margin-right: 10px;">Login: <strong><?= $_SESSION['username'] ?></strong></span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<div class="konten">
    <div class="kartu-welcome">
        <div class="icon">🌿</div>
        <h2>Halo, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
        <p>Anda masuk sebagai <strong>Wisatawan</strong> Air Terjun Tancak.</p>
    </div>

    <div class="kartu-info">
        <h3>📄 Detail Akun Wisata</h3>
        <table>
            <tr>
                <td>ID Akun</td>
                <td>#USR-<?= $_SESSION['id_user'] ?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><?= htmlspecialchars($_SESSION['username']) ?></td>
            </tr>
            <tr>
                <td>Role / Hak Akses</td>
                <td><span class="badge">Wisatawan Aktif</span></td>
            </tr>
            <tr>
                <td>Status Kebersihan</td>
                <td>✅ Belum ada pelanggaran</td>
            </tr>
        </table>
    </div>

    <div class="kartu-akses">
        <h3 style="color: #d68910; margin-bottom: 10px;">⚠️ Panduan Wisatawan</h3>
        <ul style="margin-left: 20px; font-size: 14px; color: #7d6608; line-height: 1.8;">
            <li>Jangan meninggalkan sampah di area air terjun.</li>
            <li>Laporkan sampah yang Anda bawa saat keluar gerbang.</li>
            <li>Gunakan tiket digital ini untuk verifikasi data di pos akhir.</li>
        </ul>
    </div>
</div>
</body>
</html>