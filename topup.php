<?php
require_once 'config/koneksi.php';
global $pdo;

$game_slug = $_GET['game'] ?? '';

// 1. Ambil data game
$stmt = $pdo->prepare("SELECT * FROM games WHERE slug = ?");
$stmt->execute([$game_slug]);
$game = $stmt->fetch();

if (!$game) {
    die("<div class='container mt-5 text-white'>Game tidak ditemukan!</div>");
}

// 2. Ambil produk berdasarkan ID game
$stmtProduk = $pdo->prepare("SELECT * FROM produk WHERE game_id = ?");
$stmtProduk->execute([$game['id']]);
$produk_list = $stmtProduk->fetchAll();

include_once 'includes/header.php';
?>

<div class="container my-5">
    <h3 class="text-white mb-4">Top Up <?= htmlspecialchars($game['nama_game']); ?></h3>
    <form action="checkout.php" method="POST">
        <input type="hidden" name="game_id" value="<?= $game['id']; ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="text-white">User ID:</label>
                <input type="text" name="user_id" class="form-control" required placeholder="Masukkan User ID">
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-white">Server ID:</label>
                <input type="text" name="zone_id" class="form-control" placeholder="Masukkan Server ID">
            </div>
        </div>

        <div class="mb-3">
            <label class="text-white">Pilih Nominal:</label>
            <div class="row g-2">
                <?php foreach ($produk_list as $p): ?>
                    <div class="col-md-4">
                        <input type="radio" name="produk_id" value="<?= $p['id']; ?>" id="p<?= $p['id']; ?>" class="btn-check" required>
                        <label class="btn btn-outline-light w-100" for="p<?= $p['id']; ?>">
                            <?= htmlspecialchars($p['nama_produk']); ?> <br> Rp <?= number_format($p['harga'], 0, ',', '.'); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mb-3">
            <label class="text-white">Metode Pembayaran:</label>
            <select name="payment_method" class="form-control" required>
                <option value="">-- Pilih Metode --</option>
                <option value="Dana">Dana</option>
                <option value="Gopay">Gopay</option>
                <option value="QRIS">QRIS</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="text-white">Nomor WhatsApp (Wajib):</label>
            <input type="number" name="whatsapp" class="form-control" required placeholder="08xxxxxxxxxx">
        </div>

        <div class="mb-3">
            <label class="text-white">Email (Opsional):</label>
            <input type="email" name="email" class="form-control" placeholder="opsional@email.com">
        </div>

        <button type="submit" class="btn btn-primary w-100">Proses Pembayaran</button>
    </form>
</div>

<script>
    function cekUsername() {
        let user_id = document.getElementById('user_id').value;
        let zone_id = document.getElementById('zone_id').value;

        if (user_id.length > 5 && zone_id.length > 2) {
            // Panggil mock-api.php
            fetch('mock-api.php?id=' + user_id + '&zone=' + zone_id)
                .then(response => response.json())
                .then(data => {
                    let res = document.getElementById('username_result');
                    if (data.status === 'success') {
                        res.innerHTML = "<b>Username:</b> " + data.username;
                        res.style.color = "green";
                        // Masukkan ke input tersembunyi agar tersimpan saat checkout
                        document.getElementById('hidden_username').value = data.username;
                    } else {
                        res.innerHTML = "User tidak ditemukan";
                        res.style.color = "red";
                    }
                });
        }
    }
</script>

<input type="text" id="user_id" onkeyup="cekUsername()" placeholder="Masukkan ID">
<input type="text" id="zone_id" onkeyup="cekUsername()" placeholder="Masukkan Zone ID">
<div id="username_result"></div>
<input type="hidden" name="username_game" id="hidden_username">

<?php include_once 'includes/footer.php'; ?>