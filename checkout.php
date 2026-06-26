<?php
require_once 'config/koneksi.php';
global $pdo;

// Cek akses POST agar tidak diakses langsung
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// Tangkap & Sanitasi Input
$game_id        = intval($_POST['game_id'] ?? 0);
$produk_id      = intval($_POST['produk_id'] ?? 0);
$payment_method = htmlspecialchars($_POST['payment_method'] ?? 'QRIS');
$user_id        = htmlspecialchars($_POST['user_id'] ?? '');
$zone_id        = htmlspecialchars($_POST['zone_id'] ?? '');
$whatsapp       = htmlspecialchars($_POST['whatsapp'] ?? '');

// Ambil Data Produk
$stmtCheck = $pdo->prepare("SELECT p.*, g.nama_game FROM produk p JOIN games g ON p.game_id = g.id WHERE p.id = ?");
$stmtCheck->execute([$produk_id]);
$item = $stmtCheck->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("Data produk tidak ditemukan.");
}

// Generate Invoice Unik (menggunakan time() untuk mencegah duplikasi)
$no_invoice = "INV-" . time() . "-" . rand(1000, 9999);
$total = $item['harga'];

// 1. Tangkap username dari form (pastikan nama inputnya 'username_game')
$username_game = htmlspecialchars($_POST['username_game'] ?? 'Wanminaire x DELLV');

// 1. Simpan Transaksi (INSERT)
$sql = "INSERT INTO transaksi (no_invoice, game_id, nama_game, nama_produk, harga, user_id, zone_id, whatsapp, metode_pembayaran, username_game, status_pesanan, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";
$stmtInsert = $pdo->prepare($sql);
$stmtInsert->execute([$no_invoice, $game_id, $item['nama_game'], $item['nama_produk'], $total, $user_id, $zone_id, $whatsapp, $payment_method, $username_game]);

// 2. AMBIL DATA SETELAH INSERT BERHASIL (SELECT)
$stmtGet = $pdo->prepare("SELECT * FROM transaksi WHERE no_invoice = ?");
$stmtGet->execute([$no_invoice]);
$transaksi = $stmtGet->fetch(PDO::FETCH_ASSOC);

// 3. Baru tampilkan header
include_once 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="alert alert-success text-center">
                <h4>Pesanan Berhasil Dibuat!</h4>
                <p>Nomor Invoice: <b><?= htmlspecialchars($no_invoice) ?></b></p>
            </div>

            <div class="card bg-dark text-white border-warning mb-3">
                <div class="card-header bg-warning text-dark font-weight-bold">Informasi Akun</div>
                <div class="card-body">
                    <p class="mb-1">Nickname: <b><?= htmlspecialchars($transaksi['username_game'] ?? 'Tidak ditemukan') ?></b></p>
                    <p class="mb-0">ID: <?= htmlspecialchars($transaksi['user_id'] ?? '') ?> (<?= htmlspecialchars($transaksi['zone_id'] ?? '') ?>)</p>
                </div>
            </div>
            <style>
                .progress-track {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 20px;
                    position: relative;
                }

                .step {
                    text-align: center;
                    font-size: 12px;
                    color: #6c757d;
                }

                .step.active {
                    color: #ffc107;
                    font-weight: bold;
                }

                /* Warna kuning aksen */
                .step.active i {
                    color: #ffc107;
                }
            </style>

            <div class="card bg-dark text-white mt-3 p-3">
                <h6 class="text-warning">Progress Transaksi</h6>
                <div class="progress-track">
                    <div class="step <?= in_array($transaksi['status_pesanan'], ['pending', 'processing', 'completed']) ? 'active' : '' ?>">
                        <i class="fa fa-circle"></i><br>Dibuat
                    </div>
                    <div class="step <?= in_array($transaksi['status_pesanan'], ['pending', 'processing', 'completed']) ? 'active' : '' ?>">
                        <i class="fa fa-circle"></i><br>Pembayaran
                    </div>
                    <div class="step <?= in_array($transaksi['status_pesanan'], ['processing', 'completed']) ? 'active' : '' ?>">
                        <i class="fa fa-circle"></i><br>Diproses
                    </div>
                    <div class="step <?= $transaksi['status_pesanan'] == 'completed' ? 'active' : '' ?>">
                        <i class="fa fa-check-circle"></i><br>Selesai
                    </div>
                </div>
            </div>

            <div class="card bg-dark text-white">
                <div class="card-body text-center">
                    <h5 class="text-warning">Scan Kode QR</h5>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($no_invoice) ?>" alt="QR" class="img-fluid bg-white p-2">
                    <button class="btn btn-warning mt-3 w-100 font-weight-bold">Unduh Kode QR</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; // Footer website Anda 
?>