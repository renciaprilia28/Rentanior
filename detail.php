<?php
include "koneksi.php";

// Tangkap ID dari URL dan amankan dari SQL Injection dasar
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data produk yang ID-nya sesuai
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id=$id");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan, alihkan kembali
if (!$data) {
    echo "<script>alert('Data produk tidak ditemukan!'); window.location.href='tampil_produk.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - RENTANIOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Sidebar Styling Sesuai Rentanior */
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111c24;
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
        .sidebar .brand i { color: #2ecc71; }
        .sidebar .nav-link {
            color: #a0aec0;
            padding: 12px 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover { color: #fff; background-color: rgba(255,255,255,0.05); }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #198754; /* Warna hijau menu aktif */
            font-weight: bold;
        }
        /* Main Content Styling */
        .main-content { margin-left: 260px; padding: 0; }
        .top-navbar {
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            margin-bottom: 30px;
        }
        .top-navbar h4 { margin: 0; font-weight: 600; }
        .content-container { padding: 0 30px 30px 30px; }
        
        /* Detail Section Custom Styling */
        .detail-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.01);
            border: 1px solid #eef2f5;
        }
        .product-img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .price-badge {
            background-color: #ecfdf5;
            color: #065f46;
            font-weight: 700;
            font-size: 1.15rem;
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
            border: 1px solid #a7f3d0;
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
        <div><span class="badge bg-success p-2 rounded-circle"><i class="fa-solid fa-user"></i></span></div>
    </div>

    <div class="content-container">
        <div class="detail-card">
            
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <div>
                    <h5 class="mb-1" style="font-weight: 700;">Detail Informasi Produk</h5>
                    <small class="text-muted">Melihat spesifikasi lengkap dari aset produk terpilih.</small>
                </div>
                <a href="tampil_produk.php" class="btn btn-secondary btn-sm px-3" style="border-radius: 20px;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <img src="img/<?= htmlspecialchars($data['gambar']) ?>" alt="Gambar Produk" class="product-img img-thumbnail">
                </div>
                
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <td width="25%" class="text-muted fw-semibold">Nama Produk</td>
                            <td width="5%">:</td>
                            <td class="fw-bold fs-5 text-dark"><?= htmlspecialchars($data['nama']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Harga Sewa / Nilai</td>
                            <td>:</td>
                            <td>
                                <div class="price-badge">
                                    Rp <?= number_format($data['harga'], 0, ',', '.') ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Deskripsi Lengkap</td>
                            <td>:</td>
                            <td class="text-secondary" style="line-height: 1.6;">
                                <?= nl2br(htmlspecialchars($data['deskripsi'])) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Status Aset</td>
                            <td>:</td>
                            <td>
                                <span class="badge bg-success px-3 py-2" style="border-radius: 6px;">Tersedia</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>