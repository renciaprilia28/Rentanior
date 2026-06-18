<?php
include "koneksi.php";

// Menyesuaikan username dengan identitas admin/petugas RENTANIOR
$username = "admin";
$password_asli = "admin"; // Password default yang digunakan pada sistem login sebelumnya

// Mengenkripsi password menggunakan algoritma BCRYPT demi keamanan sistem
$password_hash = password_hash($password_asli, PASSWORD_DEFAULT);

// Masukkan ke database db_rentanior_sepeda pada tabel user
$query = "INSERT INTO user (username, password) VALUES ('$username', '$password_hash')";

if (mysqli_query($conn, $query)) {
    echo "<div style='font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #198754; border-radius: 8px; background-color: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05);'>";
    echo "<h3 style='color: #111c24; display: flex; align-items: center; gap: 8px; margin-bottom: 5px;'>RENTANIOR</h3>";
    echo "<small style='color: #6c757d; display: block; margin-bottom: 15px;'>Rental Sepeda Junior</small>";
    echo "<p style='color: #198754; font-weight: bold; font-size: 16px; margin-bottom: 15px;'>Akun Admin Berhasil Dibuat!</p>";
    echo "<table style='width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 14px;'>
            <tr><td style='padding: 5px 0; color: #6c757d; width: 120px;'>Username</td><td style='width: 10px;'>:</td><td style='font-weight: 600; color: #111c24;'>$username</td></tr>
            <tr><td style='padding: 5px 0; color: #6c757d;'>Password Asli</td><td>:</td><td style='font-weight: 600; color: #dc3545;'>$password_asli</td></tr>
          </table>";
    echo "<hr style='border: 0; border-top: 1px solid #dee2e6; margin: 15px 0;'>";
    echo "<a href='login.php' style='display: inline-block; background-color: #198754; color: white; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 14px; font-weight: bold;'>Buka Halaman Login</a>";
    echo "<small style='color: #dc3545; display: block; margin-top: 15px; font-size: 12px;'>*PENTING: Demi keamanan aplikasi, segera hapus atau amankan file ini dari server lokal Laragon Anda jika akun sudah terbuat!</small>";
    echo "</div>";
} else {
    echo "Gagal membuat akun admin RENTANIOR: " . mysqli_error($conn);
}
?>