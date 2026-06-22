<?php

require_once 'config/koneksi.php'; 
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username'])); // Proteksi XSS
    $email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if ($username && $email && !empty($password)) {
        $stmtCek = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmtCek->execute([$username, $email]);
        
        if ($stmtCek->rowCount() > 0) {
            $error = "Username atau Email sudah digunakan!";
        } else {
            $password_aman = password_hash($password, PASSWORD_BCRYPT);
            $stmtInsert = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmtInsert->execute([$username, $email, $password_aman])) {
                $success = "Registrasi berhasil! Silakan <a href='login.php' class='text-purple-400'>Login di sini</a>.";
            } else {
                $error = "Gagal mendaftarkan akun.";
            }
        }
    } else {
        $error = "Semua data wajib diisi dengan benar!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - GameTopUp Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0F172A; color: #F8FAFC; } /* Sesuai Tema Dark di berkas Anda */
        .card-custom { background-color: #1E293B; border: none; }
    </style>
</head>
<body class="d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card card-custom p-4 rounded-3 shadow">
                    <h3 class="fw-bold text-center mb-4" style="color: #8B5CF6;">DAFTAR AKUN</h3>
                    
                    <?php if($error): ?> <div class="alert alert-danger"><?= $error; ?></div> <?php endif; ?>
                    <?php if($success): ?> <div class="alert alert-success"><?= $success; ?></div> <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <button type="submit" class="btn w-100 fw-bold text-white mb-3" style="background-color: #6D28D9;">Register</button>
                        <p class="text-center mb-0 small">Sudah punya akun? <a href="login.php" style="color: #8B5CF6;">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>