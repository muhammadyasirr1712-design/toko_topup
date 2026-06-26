<?php
// Pastikan tidak ada output sebelum session_start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/koneksi.php';
global $pdo;

if (!isset($_SESSION['admin_login'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil data transaksi
$stmt = $pdo->query("SELECT * FROM transaksi ORDER BY id DESC");
$transaksi_list = $stmt->fetchAll();

include_once '../includes/header.php';
?>

<div class="container-fluid mt-4">
    <h2 class="text-white mb-4">Dashboard Admin</h2>
    <div class="card bg-dark text-white mt-4 border-secondary">
        <div class="card-header bg-secondary">Transaksi Terbaru</div>
        <div class="card-body">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transaksi_list as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['invoice'] ?? $t['no_invoice'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($t['username_game'] ?? 'User') ?></td>
                        <td>
                            <span class="badge badge-<?= ($t['status_pesanan'] ?? '') == 'Pending' ? 'warning' : 'success' ?>">
                                <?= htmlspecialchars($t['status_pesanan'] ?? 'Pending') ?>
                            </span>
                        </td>
                        <td>
                            <a href="admin_aksi.php?id=<?= $t['id'] ?? 0 ?>&status=processing" class="btn btn-sm btn-info">Proses</a>
                            <a href="admin_aksi.php?id=<?= $t['id'] ?? 0 ?>&status=completed" class="btn btn-sm btn-success">Selesai</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once '../includes/footer.php'; ?>