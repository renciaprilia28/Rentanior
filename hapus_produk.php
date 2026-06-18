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

include "koneksi.php";

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil string gambar
$query = mysqli_query($conn, "SELECT gambar FROM produk WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if ($data) {
    $folder = './img/';
    $images = explode(',', $data['gambar']);
    
    // Hapus semua file fisik gambar yang terhubung dari server
    foreach ($images as $img) {
        $target_file = $folder . trim($img);
        if (file_exists($target_file) && !empty($img)) {
            unlink($target_file);
        }
    }
}

// Hapus baris data dari database
$delete = mysqli_query($conn, "DELETE FROM produk WHERE id=$id");

if ($delete) {
    echo "<script>
            alert('Produk dan semua file gambar berhasil dihapus!');
            window.location.href = 'tampil_produk.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus data.');
            window.location.href = 'tampil_produk.php';
          </script>";
}
exit;
?>