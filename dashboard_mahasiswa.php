<?php
// =============================================
// FILE: dashboard_mahasiswa.php
// Fungsi: Dashboard Mahasiswa dengan style Air Terjun Tancak
// Style mengacu pada cuplikan layar yang diberikan
// =============================================

session_start();
include "koneksi.php";

// Proteksi halaman
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: dashboard_admin.php");
    exit();
}

// Ambil data user yang login
$username = $_SESSION['username'];
$query_user = mysqli_query($koneksi, "SELECT * FROM tb_login WHERE username = '$username'");
$user = mysqli_fetch_assoc($query_user);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - Air Terjun Tancak</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
        }

        /* ========== NAVBAR UTAMA ========== */
        .navbar {
            background: linear-gradient(135deg, #1a5f3a, #2e8b57);
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar .logo h1 {
            font-size: 26px;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 30px;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
            padding: 8px 0;
        }

        .nav-links a:hover {
            border-bottom: 2px solid white;
            opacity: 0.9;
        }

        .btn-login {
            background-color: #ff9800;
            padding: 8px 22px;
            border-radius: 25px;
        }

        .btn-login:hover {
            background-color: #e68900;
            border-bottom: none !important;
        }

        /* ========== SUB NAVBAR ========== */
        .sub-navbar {
            background-color: white;
            padding: 12px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            border-bottom: 1px solid #e0e0e0;
        }

        .sub-nav-links a {
            text-decoration: none;
            color: #555;
            margin-right: 30px;
            font-size: 14px;
            font-weight: 500;
            padding-bottom: 8px;
        }

        .sub-nav-links a.active {
            color: #2e8b57;
            border-bottom: 3px solid #2e8b57;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .user-info span {
            font-size: 14px;
            color: #333;
        }

        .btn-logout {
            background-color: #e74c3c;
            color: white;
            padding: 6px 18px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .btn-logout:hover {
            background-color: #c0392b;
        }

        /* ========== DASHBOARD CONTAINER ========== */
        .dashboard-container {
            max-width: 1300px;
            margin: 30px auto;
            padding: 0 25px;
        }

        /* ========== STATS GRID (Kartu seperti gambar) ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 22px 20px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 18px rgba(0,0,0,0.12);
        }

        .stat-icon {
            font-size: 45px;
            background: #e8f5e9;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
        }

        .stat-info h3 {
            font-size: 15px;
            color: #777;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #2e8b57;
        }

        /* ========== ALERT OTOMATIS (seperti di gambar) ========== */
        .alert-auto {
            background-color: #fff8e1;
            border-left: 5px solid #ffc107;
            padding: 14px 22px;
            border-radius: 10px;
            margin-bottom: 30px;
            font-size: 14px;
            color: #856404;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .alert-auto strong {
            color: #d68910;
        }

        /* ========== DASHBOARD MENU (Admin Style) ========== */
        .dashboard-menu {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
            margin-bottom: 35px;
        }

        .menu-card {
            background: white;
            padding: 22px 18px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            text-align: center;
            transition: all 0.2s;
            border: 1px solid #eef2f7;
        }

        .menu-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .menu-card h3 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .menu-card p {
            font-size: 13px;
            color: #999;
            margin-bottom: 18px;
        }

        .btn-menu {
            display: inline-block;
            background-color: #2e8b57;
            color: white;
            padding: 8px 22px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: 0.2s;
        }

        .btn-menu:hover {
            background-color: #1a5f3a;
        }

        /* ========== JUDUL DASHBOARD ADMIN ========== */
        .dashboard-title {
            margin-bottom: 20px;
        }

        .dashboard-title h2 {
            color: #2c3e50;
            font-size: 22px;
            font-weight: 600;
        }

        .dashboard-title p {
            color: #7f8c8d;
            font-size: 13px;
            margin-top: 5px;
        }

        /* ========== TABEL DATA KUNJUNGAN ========== */
        .table-container {
            background: white;
            border-radius: 12px;
            padding: 0;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            overflow-x: auto;
            margin-bottom: 25px;
        }

        .table-container h3 {
            padding: 18px 22px;
            margin: 0;
            color: #2c3e50;
            font-size: 18px;
            border-bottom: 1px solid #ecf0f1;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .data-table th {
            background-color: #f8f9fc;
            color: #2c3e50;
            padding: 14px 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #ecf0f1;
        }

        .data-table td {
            padding: 12px 12px;
            border-bottom: 1px solid #f0f0f0;
            color: #555;
        }

        .data-table tr:hover td {
            background-color: #fafbfe;
        }

        /* Badge status */
        .badge {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .status-belum {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-masih {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-sudah {
            background-color: #d4edda;
            color: #155724;
        }

        /* Warna baris */
        .row-belum-checkin {
            background-color: #fffef7;
        }

        .row-masih-wisata {
            background-color: #f0f7ff;
        }

        .row-sudah-pulang {
            background-color: #f0fff4;
        }

        /* Denda text */
        .denda-positive {
            color: #e74c3c;
            font-weight: 600;
        }

        /* ========== FOOTER ========== */
        .footer {
            text-align: center;
            padding: 25px;
            font-size: 12px;
            color: #aaa;
            border-top: 1px solid #e0e0e0;
            margin-top: 20px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1000px) {
            .stats-grid, .dashboard-menu {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .navbar, .sub-navbar {
                flex-direction: column;
                gap: 12px;
                padding: 15px 20px;
            }
            
            .nav-links a {
                margin: 0 12px;
            }
            
            .stats-grid, .dashboard-menu {
                grid-template-columns: 1fr;
            }
            
            .data-table {
                font-size: 11px;
            }
            
            .data-table th, .data-table td {
                padding: 8px 6px;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR - style Air Terjun Tancak -->
<div class="navbar">
    <div class="logo">
        <h1>🌊 AIR TERJUN TANCAK</h1>
    </div>
    <div class="nav-links">
        <a href="#">Beranda</a>
        <a href="#">Profil</a>
        <a href="#">Narahubung</a>
        <a href="#">Rating</a>
        <a href="login.php" class="btn-login">Login</a>
    </div>
</div>

<!-- SUB NAVBAR Dashboard -->
<div class="sub-navbar">
    <div class="sub-nav-links">
        <a href="dashboard_mahasiswa.php" class="active">Dashboard Mahasiswa</a>
        <a href="#">Profil Saya</a>
        <a href="#">Riwayat Kunjungan</a>
        <a href="#">Cek Denda</a>
    </div>
    <div class="user-info">
        <span>👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="dashboard-container">
    
    <!-- Kartu Statistik seperti di gambar -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">🎫</div>
            <div class="stat-info">
                <h3>Belum Check-in</h3>
                <p class="stat-number">1 tiket</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🚶</div>
            <div class="stat-info">
                <h3>Masih di Wisata</h3>
                <p class="stat-number">1 tiket</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🏠</div>
            <div class="stat-info">
                <h3>Sudah Pulang</h3>
                <p class="stat-number">6 tiket</p>
            </div>
        </div>
    </div>

    <!-- Alert otomatis (persis seperti di gambar cuplikan layar) -->
    <div class="alert-auto">
        ⚠️ 1 data wisatawan dihapus otomatis — tidak check-in dalam 24 jam. (<strong>Andi Wijaya</strong>)
    </div>

    <!-- Dashboard Admin Title (seperti di gambar) -->
    <div class="dashboard-title">
        <h2>📋 Dashboard Admin</h2>
        <p>Wisata Air Terjun Tancak Panti</p>
    </div>

    <!-- Menu Dashboard Admin Style -->
    <div class="dashboard-menu">
        <div class="menu-card">
            <h3>📊 Data Wisatawan</h3>
            <p>Lihat dan kelola data wisatawan</p>
            <a href="#" class="btn-menu">Lihat →</a>
        </div>
        <div class="menu-card">
            <h3>📈 Rekap Wisatawan</h3>
            <p>Statistik kunjungan wisata</p>
            <a href="#" class="btn-menu">Lihat →</a>
        </div>
        <div class="menu-card">
            <h3>💰 Rekap Denda</h3>
            <p>Data denda dan pembayaran</p>
            <a href="#" class="btn-menu">Lihat →</a>
        </div>
        <div class="menu-card">
            <h3>⭐ Moderasi Ulasan</h3>
            <p>Kelola rating dan komentar</p>
            <a href="#" class="btn-menu">Kelola →</a>
        </div>
    </div>

    <!-- Tabel Data Kunjungan (persis seperti di gambar cuplikan layar) -->
    <div class="table-container">
        <h3>📝 Data Kunjungan Terbaru</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal Kunjungan</th>
                    <th>ID Tiket</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Orang</th>
                    <th>Telepon 1</th>
                    <th>Telepon 2</th>
                    <th>Bukti Transfer</th>
                    <th>Sampah</th>
                    <th>Denda</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="row-belum-checkin">
                    <td>22 Februari 2026</td>
                    <td>#5182</td>
                    <td>Ahmad Fauzi</td>
                    <td>Suci</td>
                    <td>5</td>
                    <td>089555555555</td>
                    <td>082666666666</td>
                    <td>item</td>
                    <td>3</td>
                    <td><span class="denda-positive">+ Denda</span></td>
                    <td><span class="badge status-belum">❌ Belum Check-in</span></td>
                </tr>
                <tr class="row-masih-wisata">
                    <td>22 Februari 2026</td>
                    <td>#3741</td>
                    <td>Rina Putri</td>
                    <td>Jember</td>
                    <td>2</td>
                    <td>081333333333</td>
                    <td>085444444444</td>
                    <td>item</td>
                    <td>3</td>
                    <td><span class="denda-positive">+ Denda</span></td>
                    <td><span class="badge status-masih">🚶 Masih di Wisata</span></td>
                </tr>
                <tr class="row-sudah-pulang">
                    <td>22 Februari 2026</td>
                    <td>#2895</td>
                    <td>Budi Susanto</td>
                    <td>Panti</td>
                    <td>3</td>
                    <td>082111111111</td>
                    <td>082222222222</td>
                    <td>item</td>
                    <td>6</td>
                    <td><span class="denda-positive">+ Denda</span></td>
                    <td><span class="badge status-sudah">✅ Sudah Pulang</span></td>
                </tr>
                <tr class="row-sudah-pulang">
                    <td>21 Februari 2026</td>
                    <td>#4455</td>
                    <td>Dewi Sartika</td>
                    <td>Sumbersari</td>
                    <td>4</td>
                    <td>087777777777</td>
                    <td>081888888888</td>
                    <td>item</td>
                    <td>3</td>
                    <td><span class="denda-positive">Rp 30.000</span></td>
                    <td><span class="badge status-sudah">✅ Sudah Pulang</span></td>
                </tr>
                <tr class="row-sudah-pulang">
                    <td>21 Februari 2026</td>
                    <td>#3392</td>
                    <td>Yoga Pratama</td>
                    <td>Patrang</td>
                    <td>3</td>
                    <td>082999999999</td>
                    <td>085000000000</td>
                    <td>item</td>
                    <td>2</td>
                    <td><span class="denda-positive">+ Denda</span></td>
                    <td><span class="badge status-sudah">✅ Sudah Pulang</span></td>
                </tr>
                <tr class="row-sudah-pulang">
                    <td>20 Februari 2026</td>
                    <td>#2187</td>
                    <td>Sari Indah</td>
                    <td>Kaliwates</td>
                    <td>2</td>
                    <td>085111222333</td>
                    <td>081333444555</td>
                    <td>item</td>
                    <td>2</td>
                    <td><span class="denda-positive">Rp 20.000</span></td>
                    <td><span class="badge status-sudah">✅ Sudah Pulang</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer (seperti di gambar) -->
    <div class="footer">
        <p>Do not sell or share my personal info | © 2026 Air Terjun Tancak</p>
    </div>
</div>

</body>
</html>