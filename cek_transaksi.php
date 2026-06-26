<?php
require_once 'config/koneksi.php';
include_once 'includes/header.php'; // Pastikan header ini berisi link Bootstrap
global $pdo;

$hasil = null;
$error = null;

if (isset($_GET['invoice']) && !empty($_GET['invoice'])) {
    $invoice = $_GET['invoice'];
    $stmt = $pdo->prepare("SELECT * FROM transaksi WHERE invoice = ?");
    $stmt->execute([$invoice]);
    $hasil = $stmt->fetch();
    
    if (!$hasil) {
        $error = "Nomor Invoice tidak ditemukan.";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white border-secondary shadow">
                <div class="card-header bg-secondary">Cek Status Pesanan</div>
                <div class="card-body">
                    <form method="GET">
                        <div class="form-group">
                            <label>Masukkan Nomor Invoice</label>
                            <input type="text" name="invoice" class="form-control" placeholder="Contoh: INV-17824..." required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 font-weight-bold">CARI PESANAN</button>
                    </form>
                </div>
            </div>

            <?php if ($hasil): ?>
                <div class="card bg-dark text-white border-warning mt-4">
                    <div class="card-body">
                        <h5 class="text-warning">Detail Pesanan</h5>
                        <hr class="border-secondary">
                        <p>Invoice: <strong><?= htmlspecialchars($hasil['invoice']) ?></strong></p>
                        <p>User: <?= htmlspecialchars($hasil['username_game']) ?></p>
                        <p>Status: 
                            <span class="badge badge-<?= ($hasil['status_pesanan'] == 'Completed') ? 'success' : 'info' ?>">
                                <?= htmlspecialchars($hasil['status_pesanan']) ?>
                            </span>
                        </p>
                    </div>
                </div>
            <?php elseif ($error): ?>
                <div class="alert alert-danger mt-4"><?= $error ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>