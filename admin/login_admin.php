<?php
// Pastikan memanggil koneksi dengan path yang benar
require_once '../config/koneksi.php';

// Inisialisasi variabel untuk menampung pesan
$error = ''; 

// Cek jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi sederhana
    if ($username === 'admin' && $password === 'khususadmin123') {
        $_SESSION['admin_login'] = true;
        header("Location: dashboardadmin.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>body { background-color: #121212; color: #fff; }</style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card bg-dark border-warning p-4">
                <h4 class="text-center text-warning">Login Admin</h4>
                
                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="login_admin.php">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-warning w-100 font-weight-bold">MASUK</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>