# 🚴‍♂️ RENTANIOR - Rental Sepeda Junior

RENTANIOR adalah aplikasi berbasis web yang dirancang untuk mengelola sistem persewaan sepeda secara digital. Aplikasi ini mempermudah admin atau petugas dalam mengelola data produk sepeda, melakukan pencatatan transaksi rental, serta memproses autentikasi pengguna secara aman.

---

## 🛠️ Fitur Utama
* **Autentikasi Aman:** Sistem login admin menggunakan enkripsi password berbasis `password_hash()`.
* **Manajemen Produk (CRUD):** Tambah, lihat detail, edit, dan hapus data sepeda yang disewakan.
* **Upload Gambar:** Mendukung unggah foto produk sepeda langsung ke server lokal.
* **Arsitektur Bersih:** Pemisahan file koneksi database (`koneksi.php`) untuk kemudahan konfigurasi.

---

## 📂 Struktur Direktori Proyek

Berdasarkan struktur file pada server lokal Laragon, berikut adalah susunan berkas proyek:

```text
rentanior/
├── uploads/             # Folder penyimpanan file gambar produk sepeda
├── detail.php           # Halaman untuk melihat rincian spesifikasi sepeda
├── edit_produk.php      # Halaman untuk memperbarui data produk
├── hapus_produk.php     # Skrip untuk menghapus data produk dari database
├── index.php            # Halaman utama / Dashboard katalog sepeda
├── koneksi.php          # Skrip koneksi ke database MySQL
├── login.php            # Halaman autentikasi masuk admin
├── logout.php           # Skrip untuk mengakhiri sesi login
├── setup.php            # Skrip otomatis pembuat akun admin pertama
├── style.css            # Berkas desain tampilan aplikasi (CSS)
└── tambah.php           # Halaman formulir penambahan sepeda baru
