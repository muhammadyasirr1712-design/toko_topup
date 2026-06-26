<?php
// index.php
require_once 'config/koneksi.php';

// Gunakan global $pdo untuk memastikan koneksi dikenali
global $pdo;

try {
    // Pastikan tabel ada, jika tidak, berikan array kosong agar tidak error di loop
    $stmtBanner = $pdo->query("SELECT * FROM banner WHERE status = 'show'");
    $banners = $stmtBanner->fetchAll() ?: [];

    $stmtGame = $pdo->query("SELECT * FROM games WHERE status = 'active'");
    $games = $stmtGame->fetchAll() ?: [];
} catch (PDOException $e) {
    // Jika database error, kita beri nilai kosong agar tidak fatal error
    $banners = [];
    $games = [];
    error_log("Database Error: " . $e->getMessage());
}

include_once 'includes/header.php';
?>

<div class="container my-4">
    <div id="carouselExampleIndicators" class="carousel slide shadow-lg" data-bs-ride="carousel">
        <div class="carousel-inner rounded-3">
            <?php foreach ($banners as $index => $bn): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                    <div class="d-flex align-items-center justify-content-center text-center p-5" style="height: 280px; background: linear-gradient(135deg, #1E293B 0%, #6D28D9 100%);">
                        <div>
                            <h2 class="fw-bold text-white"><?= htmlspecialchars($bn['nama_banner']); ?></h2>
                            <p class="text-white-50">Dapatkan harga promo terbaik khusus hari ini secara instan!</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="border-left: 5px solid #6D28D9; padding-left: 10px;">Pilih Game Favorit</h4>
    </div>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
        <?php foreach ($games as $gm): ?>
            <div class="col">
                <a href="topup.php?game=<?= htmlspecialchars($gm['slug']); ?>" class="card h-100 game-card text-center p-2 rounded-3">
                    <div class="bg-dark rounded-3 mb-2 d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px; background-color: #0F172A !important;">
                        <span class="small fw-bold text-muted">🎮</span>
                    </div>
                    <div class="card-body p-1">
                        <h6 class="card-title text-white small fw-bold text-truncate m-0"><?= htmlspecialchars($gm['nama_game']); ?></h6>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="container my-5">
    <div class="row g-3 text-center">
        <div class="col-md-4">
            <div class="p-3 rounded-3" style="background-color: #1E293B;">
                <h5 class="fw-bold text-warning">⚡ Otomatis 24 Jam</h5>
                <p class="small text-white-50 m-0">Sistem memproses pesanan Anda langsung tanpa perlu menunggu admin.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 rounded-3" style="background-color: #1E293B;">
                <h5 class="fw-bold text-success">💳 Pembayaran Lengkap</h5>
                <p class="small text-white-50 m-0">Tersedia banyak pilihan bank transfer, e-wallet, hingga QRIS.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 rounded-3" style="background-color: #1E293B;">
                <h5 class="fw-bold text-info">🔒 Transaksi Aman</h5>
                <p class="small text-white-50 m-0">Jaminan data akun game Anda aman terlindungi 100%.</p>
            </div>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>