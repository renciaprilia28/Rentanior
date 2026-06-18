<?php
include "koneksi.php";

// Proses simpan data jika form disubmit via modal
if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Logika multiple upload
    $file_count = count($_FILES['gambar']['name']);
    $uploaded_files = [];
    $folder = './img/';

    for ($i = 0; $i < $file_count; $i++) {
        $nama_file = $_FILES['gambar']['name'][$i];
        $source = $_FILES['gambar']['tmp_name'][$i];
        
        if (!empty($nama_file)) {
            move_uploaded_file($source, $folder . $nama_file);
            $uploaded_files[] = $nama_file;
        }
    }

    $gambar_db = implode(',', $uploaded_files);

    $insert = mysqli_query($conn, "INSERT INTO produk (nama, harga, deskripsi, gambar) VALUES ('$nama', '$harga', '$deskripsi', '$gambar_db')");

    if ($insert) {
        echo "<script>
                alert('Data produk dan berkas gambar berhasil disimpan!');
                window.location.href = 'tampil_produk.php';
              </script>";
        exit;
    }
}

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
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background-color: #111c24; padding-top: 20px; color: #fff; }
        .sidebar .brand { padding: 10px 25px; font-size: 24px; font-weight: bold; display: flex; align-items: center; gap: 10px; }
        .sidebar .brand i { color: #2ecc71; }
        .sidebar .nav-link { color: #a0aec0; padding: 12px 25px; display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .sidebar .nav-link:hover { color: #fff; background-color: rgba(255,255,255,0.05); }
        .sidebar .nav-link.active { color: #fff; background-color: #198754; font-weight: bold; }
        .main-content { margin-left: 260px; padding: 0; }
        .top-navbar { background-color: #fff; padding: 20px 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 30px; }
        .content-container { padding: 0 30px 30px 30px; }
        .data-card { background: #fff; border-radius: 15px; padding: 25px; border: 1px solid #eef2f5; }
        .btn-export { background-color: #e2e8f0; color: #4a5568; border: none; font-size: 13px; padding: 6px 15px; border-radius: 5px; margin-right: 5px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="brand"><i class="fa-solid fa-bicycle"></i> RENTANIOR</div>
    <div class="nav flex-column mt-4">
        <a href="#" class="nav-link"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="#" class="nav-link"><i class="fa-solid fa-users"></i> Data Penyewa</a>
        <a href="tampil_produk.php" class="nav-link active"><i class="fa-solid fa-box"></i> Data Produk</a>
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
        <div class="data-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-1" style="font-weight: 700;">Kelola Data Produk</h5>
                    <small class="text-muted">Kelola informasi produk secara real-time.</small>
                </div>
                <div>
                    <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambahProduk" style="border-radius: 20px; background-color: #0284c7; border: none;">
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
                    <input type="text" id="search" class="form-control form-control-sm" style="width: 200px;">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Produk</th>
                            <th width="15%">Harga</th>
                            <th width="25%">Deskripsi</th>
                            <th width="20%">Gambar</th>
                            <th width="15%" class="text-center">Aksi</th>
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
                                <div class="d-flex gap-1 flex-wrap">
                                    <?php 
                                    $images = explode(',', $data['gambar']);
                                    foreach($images as $img) {
                                        if(!empty($img)) {
                                    ?>
                                        <img src="img/<?= htmlspecialchars(trim($img)) ?>" width="50" height="50" style="object-fit: cover;" class="img-thumbnail rounded shadow-sm">
                                    <?php 
                                        }
                                    } 
                                    ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="edit_produk.php?id=<?= $data['id']; ?>" class="btn btn-warning btn-sm text-white" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="hapus_produk.php?id=<?= $data['id']; ?>" class="btn btn-danger btn-sm ms-1" title="Hapus" onclick="return confirm('Yakin hapus produk ini?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background-color: #f8fafc;">
                <h5 class="modal-title" style="font-weight: 700;">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Gambar (Bisa Banyak)</label>
                        <input type="file" name="gambar[]" class="form-control" multiple required>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f8fafc;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn btn-success btn-sm px-4" style="background-color: #198754; border: none;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>