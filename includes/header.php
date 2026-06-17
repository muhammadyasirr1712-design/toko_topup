<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Memulai session jika belum aktif
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameTopUp Store - Modern Gaming Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #0F172A; color: #F8FAFC; } /* Tema Dark dari cloningwebsite.md */
        .navbar-custom { background-color: #1E293B; }
        .game-card { background-color: #1E293B; border: 2px solid transparent; transition: all 0.3s ease; text-decoration: none; }
        .game-card:hover { border-color: #6D28D9; transform: translateY(-5px); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase" href="index.php" style="color: #8B5CF6;">GameTopUp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="cek_transaksi.php">Cek Transaksi</a></li>
                    <li class="nav-item"><a class="nav-link" href="leaderboard.php">Leaderboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="artikel.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="kalkulator.php">Kalkulator</a></li>
                    
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-sm btn-outline-light" href="dashboard_user.php">Hi, <?= htmlspecialchars($_SESSION['username']); ?></a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-sm btn-danger" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="btn btn-sm text-white fw-bold" style="background-color: #6D28D9;" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>