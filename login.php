<?php
// Wajib ditaruh paling atas untuk memulai session
session_start();
include "koneksi.php";

// Kalau tombol login ditekan
if (isset($_POST['login'])) {
    // Ambil data input dan bersihkan dari karakter aneh (anti SQL Injection)
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = $_POST['password'];

    // 1. Cari user berdasarkan username
    $cek = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    
    if (!$cek) {
        // Fitur debug otomatis jika tabel atau database bermasalah
        $error = "Error Query: " . mysqli_error($conn);
    } else {
        // 2. Cek apakah username ditemukan
        if (mysqli_num_rows($cek) === 1) {
            
            // Ambil data user tersebut
            $data = mysqli_fetch_assoc($cek);
            
            // 3. COCOKKAN LANGSUNG TEKS BIASA (Tanpa Enkripsi Hash)
            if ($password === $data['password']) {
                // Jika cocok, buat session
                $_SESSION['status'] = "login";
                $_SESSION['username'] = $username;
                
                // Pindahkan ke halaman utama manajemen produk
                header("Location: tampil_produk.php");
                exit; // Hentikan script
            } else {
                $error = "Password yang Anda masukkan salah!";
            }
        } else {
            $error = "Username tidak ditemukan! Periksa kembali database Anda.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RENTANIOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #111c24; /* Background gelap khas sidebar Rentanior */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
        }
        .login-card {
            background: #fff;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border: none;
        }
        .brand-title {
            font-size: 28px;
            font-weight: bold;
            color: #111c24;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .brand-title i {
            color: #198754; /* Hijau khas Rentanior */
        }
        .btn-login {
            background-color: #198754;
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: #146c43;
            color: white;
        }
        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }
    </style>
</head>
<body class="d-flex align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card login-card">
                <div class="card-body">
                    <div class="text-center mb-2">
                        <div class="brand-title">
                            <i class="fa-solid fa-bicycle"></i> RENTANIOR
                        </div>
                        <small class="text-muted">Rental Sepeda Junior</small>
                    </div>
                    
                    <hr class="mb-4">
                    
                    <?php if(isset($error)) { ?>
                        <div class="alert alert-danger d-flex align-items-center py-2" role="alert" style="font-size: 14px;">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>
                            <div><?= $error ?></div>
                        </div>
                    <?php } ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required style="border-radius: 0 6px 6px 0;">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required style="border-radius: 0 6px 6px 0;">
                            </div>
                        </div>
                        <button type="submit" name="login" class="btn btn-login w-100 py-2" style="border-radius: 6px;">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>