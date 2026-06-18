<?php
include "koneksi.php";

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: tampil_produk.php");
    exit;
}

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    if (!empty($_FILES['gambar']['name'][0])) {
        $file_count = count($_FILES['gambar']['name']);
        $uploaded_files = [];
        $folder = './img/';

        // Hapus file fisik lama
        if (!empty($data['gambar'])) {
            $old_images = explode(',', $data['gambar']);
            foreach ($old_images as $old_img) {
                $target_old_file = $folder . trim($old_img);
                if (file_exists($target_old_file) && !empty($old_img)) {
                    unlink($target_old_file);
                }
            }
        }

        // Upload berkas baru
        for ($i = 0; $i < $file_count; $i++) {
            $nama_file = $_FILES['gambar']['name'][$i];
            $source = $_FILES['gambar']['tmp_name'][$i];
            
            if (!empty($nama_file)) {
                move_uploaded_file($source, $folder . $nama_file);
                $uploaded_files[] = $nama_file;
            }
        }

        $gambar_db = implode(',', $uploaded_files);
        $update = mysqli_query($conn, "UPDATE produk SET nama='$nama', harga='$harga', deskripsi='$deskripsi', gambar='$gambar_db' WHERE id=$id");
    } else {
        $update = mysqli_query($conn, "UPDATE produk SET nama='$nama', harga='$harga', deskripsi='$deskripsi' WHERE id=$id");
    }

    if ($update) {
        echo "<script>
                alert('Data produk berhasil diperbarui!');
                window.location.href = 'tampil_produk.php';
              </script>";
        exit;
    }
}
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
    <title>Edit Produk - RENTANIOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background-color: #111c24; padding-top: 20px; color: #fff; }
        .sidebar .brand { padding: 10px 25px; font-size: 24px; font-weight: bold; display: flex; align-items: center; gap: 10px; }
        .sidebar .brand i { color: #2ecc71; }
        .sidebar .nav-link { color: #a0aec0; padding: 12px 25px; display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .sidebar .nav-link.active { color: #fff; background-color: #198754; font-weight: bold; }
        .main-content { margin-left: 260px; padding: 0; }
        .top-navbar { background-color: #fff; padding: 20px 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 30px; }
        .content-container { padding: 0 30px 30px 30px; }
        .form-card { background: #fff; border-radius: 15px; padding: 30px; border: 1px solid #eef2f5; }
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
    </div>
</div>

<div class="main-content">
    <div class="top-navbar d-flex justify-content-between align-items-center">
        <h4>Edit Produk</h4>
    </div>

    <div class="content-container">
        <div class="form-card">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Produk</label>
                    <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Harga (Rp)</label>
                    <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label d-block fw-semibold">Gambar Saat Ini</label>
                    <div class="d-flex gap-2 flex-wrap bg-light p-3 border rounded mb-2">
                        <?php 
                        $images = explode(',', $data['gambar']);
                        foreach($images as $img) {
                            if(!empty($img)) {
                        ?>
                            <img src="img/<?= htmlspecialchars(trim($img)) ?>" width="80" height="80" style="object-fit: cover;" class="img-thumbnail">
                        <?php 
                            }
                        } 
                        ?>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Ganti Gambar Baru (Bisa Banyak)</label>
                    <input type="file" name="gambar[]" class="form-control" multiple>
                    <small class="text-muted">*Kosongkan jika tidak ingin mengganti gambar.</small>
                </div>
                <div class="pt-2">
                    <a href="tampil_produk.php" class="btn btn-secondary btn-sm px-3">Kembali</a>
                    <button type="submit" name="submit" class="btn btn-success btn-sm px-4" style="background-color: #198754; border: none;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>