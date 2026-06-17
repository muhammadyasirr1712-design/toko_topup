<?php
// config/koneksi.php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Memulai session aman untuk login
}

try {
    // Menghubungkan ke database MySQL XAMPP Anda
    $pdo = new PDO("mysql:host=localhost;dbname=gametopup_db;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>