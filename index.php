<?php
include "koneksi.php";

// Ambil semua data dari tabel produk
$query = mysqli_query($conn, "SELECT * FROM produk");
?>

<?php
session_start();

// Cek apakah user sudah punya tiket login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    // Kalau belum login, tendang balik ke halaman login
    header("Location: login.php");
    exit(); // Hentikan eksekusi kode di bawahnya
}

include "koneksi.php";
// ... (kode index.php yang lama dilanjutkan di sini) ...
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - RENTANIOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111c24; /* Warna gelap sidebar Rentanior */
            padding-top: 20px;
            color: #fff;
        }
        .sidebar .brand {
            padding: 10px 25px;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .brand i {
            color: #2ecc71;
        }
        .sidebar .nav-link {
            color: #a0aec0;
            padding: 12px 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 0;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,0.05);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #198754; /* Latar hijau menu aktif Rentanior */
            font-weight: bold;
        }
        /* Main Content Styling */
        .main-content {
            margin-left: 260px;
            padding: 0;
        }
        .top-navbar {
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            margin-bottom: 30px;
        }
        .top-navbar h4 {
            margin: 0;
            font-weight: 600;
        }
        .content-container {
            padding: 0 30px 30px 30px;
        }
        /* Table Card Box */
        .data-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.01);
            border: 1px solid #eef2f5;
        }
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
            background-color: #f8fafc !important;
            color: #4a5568 !important;
            border-bottom: 2px solid #e2e8f0;
        }
        .table td {
            vertical-align: middle;
            color: #2d3748;
            font-size: 14px;
        }
        .btn-export {
            background-color: #e2e8f0;
            color: #4a5568;
            border: none;
            font-size: 13px;
            padding: 6px 15px;
            border-radius: 5px;
            margin-right: 5px;
        }
        .btn-export:hover {
            background-color: #cbd5e1;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="brand">
        <i class="fa-solid fa-bicycle"></i> RENTANIOR
    </div>
    <div class="nav flex-column mt-4">
        <a href="#" class="nav-link"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="#" class="nav-link"><i class="fa-solid fa-users"></i> Data Penyewa</a>
        <a href="#" class="nav-link active"><i class="fa-solid fa-box"></i> Data Produk</a>
        <a href="#" class="nav-link"><i class="fa-solid fa-exchange-alt"></i> Transaksi</a>
        <a href="#" class="nav-link"><i class="fa-solid fa-signature"></i> Signature</a>
        <a href="#" class="nav-link mt-5 text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    
    <div class="top-navbar d-flex justify-content-between align-items-center">
        <h4>Dashboard Manajemen Produk</h4>
        <div class="user-profile">
            <span class="badge bg-success p-2 rounded-circle"><i class="fa-solid fa-user"></i></span>
        </div>
    </div>

    <div class="content-container">
        <div class="data-card">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-1" style="font-weight: 700;">Kelola Data Produk</h5>
                    <small class="text-muted">Kelola data informasi produk secara real-time.</small>
                </div>
                <div>
                    <button class="btn btn-primary btn-sm px-3" style="border-radius: 20px; background-color: #0284c7; border: none;">
                        <i class="fa-solid fa-plus"></i> Tambah Produk
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <button class="btn btn-export"><i class="fa-solid fa-print"></i> Cetak</button>
                    <button class="btn btn-export"><i class="fa-solid fa-file-excel"></i> Excel</button>
                    <button class="btn btn-export"><i class="fa-solid fa-file-pdf"></i> PDF</button>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label for="search" class="mb-0 text-muted" style="font-size: 14px;">Search:</label>
                    <input type="text" id="search" class="form-control form-control-sm" style="width: 200px; border-radius: 5px;">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Nama Produk</th>
                            <th width="20%">Harga</th>
                            <th width="35%">Deskripsi</th>
                            <th width="15%">Gambar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($data = mysqli_fetch_assoc($query)) { 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-bold" style="color: #0284c7;"><?= htmlspecialchars($data['nama']) ?></td>
                            <td><span class="badge bg-light text-dark border px-3 py-2">Rp <?= number_format($data['harga'], 0, ',', '.') ?></span></td>
                            <td class="text-muted"><?= htmlspecialchars($data['deskripsi']) ?></td>
                            <td>
                                <img src="img/<?= htmlspecialchars($data['gambar']) ?>" width="65" class="img-thumbnail rounded shadow-sm">
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Showing 1 to <?= mysqli_num_rows($query); ?> entries</small>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#" style="background-color: #198754; border-color: #198754;">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>