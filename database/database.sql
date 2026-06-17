-- =========================================================================
-- 1. INSALISASI DATABASE
-- =========================================================================
CREATE DATABASE IF NOT EXISTS gametopup_db;
USE gametopup_db;

-- Pastikan tabel lama dihapus terlebih dahulu jika ingin mengulang dari nol
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS settings, testimoni, banner, artikel, leaderboard, voucher;
DROP TABLE IF EXISTS transaksi, metode_pembayaran, produk, games, kategori_game;
DROP TABLE IF EXISTS admin, users;
SET FOREIGN_KEY_CHECKS = 1;

-- =========================================================================
-- 2. KELOMPOK AKUN & OTENTIKASI (TABEL MASTER UTAMA)
-- =========================================================================

-- Menyimpan data akun pelanggan / member toko
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Menggunakan enkripsi password_hash() PHP
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Menyimpan data akun administrator pengelola dashboard backend
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Menggunakan enkripsi password_hash() PHP
    nama_admin VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =========================================================================
-- 3. KELOMPOK KATALOG TOKO GAME
-- =========================================================================

-- Memisahkan jenis game (Contoh: Game Mobile, Game PC, Console)
CREATE TABLE kategori_game (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Menyimpan daftar game resmi yang tersedia untuk di-top up
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori_game_id INT,
    nama_game VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    logo_url VARCHAR(255) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    FOREIGN KEY (kategori_game_id) REFERENCES kategori_game(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daftar item/nominal/diamond beserta harganya yang terikat ke setiap game
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    games_id INT,
    nama_produk VARCHAR(100) NOT NULL, -- Contoh: "86 Diamonds"
    sku_code VARCHAR(50) NOT NULL,      -- Kode sinkronisasi ke provider API luar (Digiflazz/VIP)
    harga INT NOT NULL,                 -- Harga jual ke pelanggan
    status ENUM('ready', 'empty') DEFAULT 'ready',
    FOREIGN KEY (games_id) REFERENCES games(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =========================================================================
-- 4. KELOMPOK METODE PEMBAYARAN & TRANSAKSI
-- =========================================================================

-- Menyimpan konfigurasi jalur pembayaran otomatis (Midtrans / Tripay)
CREATE TABLE metode_pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_channel VARCHAR(100) NOT NULL,   -- Contoh: OVO, QRIS, BCA VA, Mandiri VA
    provider ENUM('Midtrans', 'Tripay') NOT NULL, 
    kode_channel VARCHAR(50) NOT NULL,    -- Kode spesifik gateway, misal: "QRIS", "BRIVA"
    status ENUM('active', 'inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Log dan detail lengkap atas riwayat transaksi yang dilakukan oleh pengguna
CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(100) NOT NULL UNIQUE, -- Digunakan untuk form pencarian cek transaksi
    whatsapp_number VARCHAR(20) NOT NULL,        -- Tujuan pengiriman notifikasi gateway otomatis
    users_id INT NULL,                           -- Relasi ke tabel user (Bisa NULL jika checkout tanpa login/Guest)
    games_id INT,
    produk_id INT,
    target_id VARCHAR(50) NOT NULL,              -- User ID Akun Game Player
    zone_id VARCHAR(50) DEFAULT NULL,            -- Server ID Game (Jika ada, seperti di MLBB)
    total_price INT NOT NULL,
    metode_pembayaran_id INT,
    voucher_code VARCHAR(50) DEFAULT NULL,       -- Menyimpan rekam jejak kode voucher yang digunakan
    status_pembayaran ENUM('pending', 'success', 'failed', 'expired') DEFAULT 'pending',
    status_topup ENUM('pending', 'processing', 'success', 'failed') DEFAULT 'pending', -- Status injeksi ke dalam game
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (games_id) REFERENCES games(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (produk_id) REFERENCES produk(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (metode_pembayaran_id) REFERENCES metode_pembayaran(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =========================================================================
-- 5. KELOMPOK MARKETING, SETTING & KONTEN PENDUKUNG
-- =========================================================================

-- Menyimpan data kupon potongan harga atau diskon belanja harian
CREATE TABLE voucher (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_voucher VARCHAR(50) NOT NULL UNIQUE,
    diskon_persen INT DEFAULT 0,
    max_potongan INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Akumulasi total belanja pengguna untuk ditampilkan pada fitur papan peringkat toko (Leaderboard)
CREATE TABLE leaderboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_id INT,
    username VARCHAR(50) NOT NULL,
    total_topup INT NOT NULL DEFAULT 0,
    periode ENUM('Harian', 'Mingguan', 'Bulanan', 'Tahunan') NOT NULL, -- Pilihan filter periode pencarian
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Portal berita, tutorial game, atau artikel SEO pendukung optimasi website
CREATE TABLE artikel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul_artikel VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    kategori_artikel VARCHAR(100) NOT NULL, -- Contoh: "Tips & Trick", "Update Game"
    konten TEXT NOT NULL,
    gambar VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Mengelola banner gambar bergulir (Slider Promo) pada Halaman Utama website
CREATE TABLE banner (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_banner VARCHAR(100) NOT NULL,
    gambar_url VARCHAR(255) NOT NULL,
    status ENUM('show', 'hide') DEFAULT 'show'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Menyimpan ulasan balik / testimoni kepuasan langsung dari pelanggan website
CREATE TABLE testimoni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(100) NOT NULL,
    ulasan TEXT NOT NULL,
    bintang INT DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Pengaturan terpusat parameter sistem global, kredensial API WhatsApp & Payment Gateway
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_website VARCHAR(100) NOT NULL DEFAULT 'GameTopUp Store',
    midtrans_client_key VARCHAR(255) DEFAULT NULL,
    midtrans_server_key VARCHAR(255) DEFAULT NULL,
    tripay_api_key VARCHAR(255) DEFAULT NULL,
    whatsapp_api_token VARCHAR(255) DEFAULT NULL, -- Token integrasi gateway Fonnte / Wablas
    cs_number VARCHAR(20) DEFAULT NULL            -- Nomor kontak pusat bantuan CS Toko
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;