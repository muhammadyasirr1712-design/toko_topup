<?php
session_start();
require_once '../config/koneksi.php';
global $pdo; // Memanggil koneksi database global

// Proteksi akses
if (!isset($_SESSION['admin_login'])) {
    header("Location: login_admin.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Update status menggunakan PDO global
    $stmt = $pdo->prepare("UPDATE transaksi SET status_pesanan = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}

header("Location: dashboardadmin.php");
exit();
?>