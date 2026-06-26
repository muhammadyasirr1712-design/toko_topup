<?php
session_start();

// Cek apakah user_id ada (artinya user sudah login) DAN levelnya admin
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
    // Arahkan ke login jika belum login atau bukan admin
    header("Location: /SIRSHOP/login.php");
    exit;
}
?>