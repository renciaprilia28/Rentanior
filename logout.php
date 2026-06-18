<?php
// Wajib ditaruh paling atas untuk mengakses session yang sedang aktif
session_start();

// 1. Kosongkan semua variabel session yang tersimpan
session_unset();

// 2. Hancurkan/hapus session dari server secara total
session_destroy();

// 3. Tampilkan pesan berhasil logout (opsional namun baik untuk UX) dan alihkan ke login.php
echo "<script>
        alert('Anda telah berhasil keluar dari sistem RENTANIOR.');
        window.location.href = 'login.php';
      </script>";
exit;
?>