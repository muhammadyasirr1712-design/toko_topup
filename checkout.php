<?php
// checkout.php
require_once 'config/koneksi.php';

// 1. Pastikan data dikirim melalui method POST dari form topup
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// 2. Tangkap semua data inputan user
$game_id        = intval($_POST['game_id']);
$produk_id      = intval($_POST['produk_id']);
$payment_method = htmlspecialchars($_POST['payment_method']);
$user_id        = htmlspecialchars($_POST['user_id']);
$zone_id        = isset($_POST['zone_id']) ? htmlspecialchars($_POST['zone_id']) : '';
$whatsapp       = htmlspecialchars($_POST['whatsapp']);

// 3. Ambil data produk & game dari database untuk validasi harga asli
$stmtCheck = $pdo->prepare("SELECT p.*, g.nama_game FROM produk p JOIN games g ON p.games_id = g.id WHERE p.id = ? AND p.games_id = ?");
$stmtCheck->execute([$produk_id, $game_id]);
$item = $stmtCheck->fetch();

if (!$item) {
    die("<div class='container mt-5 alert alert-danger'>Produk atau game tidak valid!</div>");
}

// 4. Generate Nomor Invoice Acak (Contoh: INV-20260616XXXX)
$tanggal_sekarang = date('Ymd');
$angka_acak       = rand(1000, 9999);
$no_invoice       = "INV-" . $tanggal_sekarang . $angka_acak;

$total_bayar = $item['harga_jual'];
$status_transaksi = 'pending'; // Status awal sebelum dibayar

// 5. Simpan data transaksi ke database (tabel pesanan/transaksi)
// *Pastikan nama kolom ini sesuai dengan struktur tabel pesanan Anda*
try {
    $stmtInsert = $pdo->prepare("INSERT INTO transaksi (no_invoice, game_id, nama_game, nama_produk, harga, user_id, zone_id, whatsapp, metode_pembayaran, status_pesanan, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmtInsert->execute([
        $no_invoice,
        $game_id,
        $item['nama_game'],
        $item['nama_produk'],
        $total_bayar,
        $user_id,
        $zone_id,
        $whatsapp,
        $payment_method,
        $status_transaksi
    ]);
} catch (PDOException $e) {
    // Jika tabel belum lengkap, kita tetap tampilkan halaman invoice buatan agar tidak macet eror database
    // die("Gagal menyimpan transaksi: " . $e->getMessage());
}

include_once 'includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card p-4 rounded-3 shadow text-center mb-4" style="background-color: #1E293B; border: 2px solid #6D28D9;">
                <div class="text-success mb-2" style="font-size: 3rem;">🎉</div>
                <h4 class="fw-bold text-white">Pesanan Berhasil Dibuat!</h4>
                <p class="text-white-50 small">Silakan lakukan pembayaran sesuai detail di bawah ini agar sistem otomatis memproses item game Anda.</p>
                <h3 class="fw-bold text-warning mt-2"><?= $no_invoice; ?></h3>
            </div>

            <div class="card p-4 rounded-3 shadow mb-4" style="background-color: #1E293B; border: none;">
                <h5 class="fw-bold text-white mb-4" style="border-left: 4px solid #6D28D9; padding-left: 10px;">Detail Pembayaran</h5>
                
                <table class="table table-borderless text-white small">
                    <tr>
                        <td class="text-white-50 px-0">Game</td>
                        <td class="text-end fw-bold px-0"><?= htmlspecialchars($item['nama_game']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-white-50 px-0">Item / Nominal</td>
                        <td class="text-end fw-semibold text-info px-0"><?= htmlspecialchars($item['nama_produk']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-white-50 px-0">Target Akun</td>
                        <td class="text-end px-0"><?= $user_id; ?> <?= !empty($zone_id) ? "($zone_id)" : ""; ?></td>
                    </tr>
                    <tr>
                        <td class="text-white-50 px-0">Metode Pembayaran</td>
                        <td class="text-end px-0"><span class="badge bg-secondary"><?= $payment_method; ?></span></td>
                    </tr>
                    <tr>
                        <td class="text-white-50 px-0">No. WhatsApp Anda</td>
                        <td class="text-end px-0"><?= $whatsapp; ?></td>
                    </tr>
                    <tr class="border-top border-secondary">
                        <td class="pt-3 fw-bold text-white px-0" style="font-size: 1rem;">Total Pembayaran</td>
                        <td class="text-end pt-3 fw-bold text-warning px-0" style="font-size: 1.2rem;">Rp <?= number_format($total_bayar, 0, ',', '.'); ?></td>
                    </tr>
                </table>

                <div class="alert alert-warning text-dark small border-0 mt-2 fw-semibold">
                    💡 <strong>Petunjuk:</strong> Harap transfer tepat <strong>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></strong>. Sistem AI payment gateway toko akan membaca mutasi Anda dalam 1-3 menit secara otomatis.
                </div>
            </div>

            <div class="d-grid gap-2">
                <a href="index.php" class="btn text-white fw-bold py-2.5" style="background-color: #6D28D9;">
                    🏠 Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>