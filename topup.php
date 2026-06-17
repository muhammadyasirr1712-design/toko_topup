<?php
// 1. MEMPERTAHANKAN MESIN UTAMA PHP ANDA
require_once 'config/koneksi.php'; // Memanggil koneksi PDO Anda

if (!isset($_GET['game']) || empty($_GET['game'])) {
    header("Location: index.php");
    exit();
}

$game_slug = htmlspecialchars($_GET['game']);

// Ambil data game berdasarkan slug dari database
$stmtGame = $pdo->prepare("SELECT * FROM games WHERE slug = ? AND status = 'active'");
$stmtGame->execute([$game_slug]);
$game = $stmtGame->fetch();

if (!$game) {
    die("<div class='container mt-5 alert alert-danger'>Game tidak ditemukan atau sedang tidak aktif!</div>");
}

// Ambil daftar produk/nominal koin untuk game ini
$stmtProduk = $pdo->prepare("SELECT * FROM produk WHERE games_id = ? ORDER BY harga ASC");
$stmtProduk->execute([$game['id']]);
$products = $stmtProduk->fetchAll();

// Ambil semua metode pembayaran yang aktif
$stmtPayment = $pdo->query("SELECT * FROM metode_pembayaran");
$payments = $stmtPayment->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up <?= htmlspecialchars($game['nama_game'] ?? 'Game'); ?> - Gametopup</title>

    <!-- Link Pendukung UI -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0f172a;
            font-family: 'Poppins', sans-serif;
            color: #f8fafc;
        }

        .bg-custom-card {
            background-color: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* INPUT DATA AKUN FIX: Memaksa Input Box Tetap Gelap & Tulisan Putih (Anti-Putih) */
        .input-gelap-kustom {
            background-color: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        .input-gelap-kustom:focus {
            background-color: #0f172a !important;
            border-color: #6D28D9 !important;
            color: #ffffff !important;
            box-shadow: 0 0 5px rgba(109, 40, 217, 0.5) !important;
        }

        /* KOTAK PRODUK DI-COMPACT ALA TAKAPEDIA */
        .kotak-item-game {
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            position: relative !important;
            width: 100% !important;
            min-height: 64px !important;
            padding: 8px 10px !important;
            background-color: #1e293b !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 6px !important;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .kotak-item-game:hover {
            background-color: #243147 !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        .nama-diamond-teks {
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #ffffff !important;
            display: block !important;
            text-align: left !important;
        }

        .harga-gold-teks {
            font-size: 0.8rem !important;
            font-weight: 700 !important;
            color: #fbbf24 !important;
        }

        .lencana-instan {
            position: absolute !important;
            bottom: 4px !important;
            right: 4px !important;
            background-color: rgba(255, 255, 255, 0.05) !important;
            padding: 0px 3px !important;
            border-radius: 2px !important;
        }

        .lencana-instan span {
            color: rgba(255, 255, 255, 0.3) !important;
            font-weight: 700 !important;
            font-size: 0.45rem !important;
            display: block !important;
        }

        /* EFEK SELEKSI KLIK UNGU */
        .input-nominal-takapedia:checked+.kotak-item-game {
            border-color: #6D28D9 !important;
            background: linear-gradient(135deg, #1e293b 50%, rgba(109, 40, 217, 0.15) 100%) !important;
            box-shadow: 0 0 8px rgba(109, 40, 217, 0.3) !important;
        }

        /* WIDGET RATING */
        .rating-box {
            background-color: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }

        .rating-score {
            font-size: 2.8rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
        }

        .rating-stars {
            color: #fbbf24;
            font-size: 1.1rem;
            margin: 8px 0;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        <!-- BARIS ATAS: FORM DATA AKUN (KIRI) & POSTER GAME (KANAN) -->
        <div class="row g-4 mb-4">

            <!-- SEBELAH KIRI: INPUT DATA AKUN + FITUR TOMBOL CEK USERNAME -->
            <div class="col-12 col-md-8">
                <div class="card bg-custom-card text-white p-4 rounded-3 h-100">
                    <h5 class="fw-bold mb-3">
                        <span class="badge me-2" style="background-color: #6D28D9;">1</span> Masukkan Data Akuan
                    </h5>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small text-white-50">User ID</label>
                            <input type="text" id="user_id" class="form-control bg-dark border-secondary text-white" placeholder="Masukkan User ID">
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-white-50">Zone ID / Server</label>
                            <input type="text" id="zone_id" class="form-control bg-dark border-secondary text-white" placeholder="Zone ID">
                        </div>
                        <div id="status_username" style="display:none; margin-top: 10px; padding: 10px; border-radius: 5px;"></div>
                    </div>

                    <div id="status_username" class="mt-3 p-2 rounded small" style="display:none;"></div>
                </div>
            </div>

            <!-- SEBELAH KANAN: DETAIL INFO MOBILE LEGENDS -->
            <div class="col-12 col-md-4">
                <div class="card bg-custom-card text-white p-4 rounded-3 h-100 text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="bg-dark rounded-3 d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-gamepad fa-2xl text-secondary"></i>
                    </div>
                    <h4 class="fw-bold m-0"><?= htmlspecialchars($game['nama_game']); ?></h4>
                    <p class="text-white-50 small mt-2 px-2 m-0" style="font-size: 0.78rem;">
                        Top up instan otomatis 24 jam aman dan terpercaya. Masukkan data akun Anda dengan benar untuk menghindari kesalahan proses otomatis.
                    </p>
                </div>
            </div>

        </div>

        <!-- BARIS BAWAH: PILIH NOMINAL (KIRI) & RATING BOX (KANAN) -->
        <div class="row g-4">

            <!-- SEBELAH KIRI: DAFTAR ITEM PRODUK -->
            <div class="col-12 col-md-8">
                <div class="card bg-custom-card text-white p-4 rounded-3">
                    <h5 class="fw-bold mb-3">
                        <span class="badge me-2" style="background-color: #6D28D9;">2</span> Pilih Nominal Produk
                    </h5>

                    <div class="row g-2 g-md-3">
                        <?php if (empty($products)): ?>
                            <div class="col-12 text-white-50 small py-2">Belum ada item produk untuk game ini.</div>
                        <?php else: ?>
                            <?php foreach ($products as $prod): ?>
                                <?php
                                $nama_lowercase = strtolower($prod['nama_produk']);
                                $icon_class = "fa-solid fa-gem text-info";
                                if (strpos($nama_lowercase, 'pass') !== false || strpos($nama_lowercase, 'weekly') !== false) {
                                    $icon_class = "fa-solid fa-id-card text-warning";
                                }
                                ?>
                                <div class="col-6 col-md-4">
                                    <input type="radio"
                                        class="btn-check"
                                        name="produk_id"
                                        id="prod_<?php echo $prod['id']; ?>"
                                        value="<?php echo $prod['id']; ?>"
                                        autocomplete="off">

                                    <label class="kotak-item-game" for="prod_<?php echo $prod['id']; ?>" style="cursor: pointer;">
                                        <div class="w-100">
                                            <span class="nama-diamond-teks"><?php echo htmlspecialchars($prod['nama_produk']); ?></span>
                                            <div class="w-100 d-flex align-items-center gap-2 mt-1">
                                                <i class="fa-solid fa-gem text-info"></i>
                                                <span class="harga-gold-teks">Rp <?php echo number_format($prod['harga'], 0, ',', '.'); ?></span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>
                <div class="card bg-custom-card text-white p-4 rounded-3 mt-4">
                    <h5 class="fw-bold mb-3">Pilih Metode Pembayaran</h5>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <input type="radio" name="payment" id="pay1" class="d-none">
                            <label for="pay1" class="card p-2 text-center border-secondary bg-dark text-white" style="cursor: pointer;">
                                QRIS
                            </label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="radio" name="payment" id="pay2" class="d-none">
                            <label for="pay2" class="card p-2 text-center border-secondary bg-dark text-white">Dana</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn p-3 w-100 text-white fw-bold" style="background-color: #6D28D9; border-radius: 8px;">
                        <i class="fa-solid fa-bolt me-2"></i> Beli Sekarang & Checkout
                    </button>
                    </form>
                </div>
            </div>

            <!-- SEBELAH KANAN: WIDGET RATING JIPLAK TAKAPEDIA -->
            <div class="col-12 col-md-4">
                <div class="rating-box text-white">
                    <div class="text-white-50 small mb-1 text-start fw-semibold">Ulasan dan rating</div>
                    <div class="d-flex align-items-center justify-content-start gap-3 mt-2">
                        <div class="rating-score">4.99</div>
                        <div class="text-start">
                            <div class="rating-stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="text-white-50" style="font-size: 0.75rem;">Berdasarkan total 21.95jt rating</div>
                        </div>
                    </div>
                </div>

                <!-- Box Bantuan Admin -->
                <div class="bg-custom-card rounded-3 p-3 mt-3 d-flex align-items-center gap-3 border border-secondary border-opacity-10">
                    <i class="fa-solid fa-headset fa-xl text-white-50"></i>
                    <div class="text-start">
                        <div class="fw-bold small">Butuh Bantuan?</div>
                        <div class="text-white-50" style="font-size: 0.72rem;">Kamu bisa hubungi admin disini.</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Ambil elemen input
        const userIdInput = document.getElementById('user_id');
        const zoneIdInput = document.getElementById('zone_id');
        const statusDiv = document.getElementById('status_username');

        function checkUsername() {
            let userId = userIdInput.value;
            let zoneId = zoneIdInput.value;

            // Hanya cek jika ID sudah cukup panjang (misal lebih dari 5 digit)
            if (userId.length > 5 && zoneId.length > 2) {
                statusDiv.style.display = 'block';
                statusDiv.innerHTML = "Sedang mengecek...";

                let formData = new FormData();
                formData.append('user_id', userId);
                formData.append('zone_id', zoneId);

                fetch('cek-username.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Tampilan muncul tepat di bawah sesuai contoh
                            statusDiv.style.backgroundColor = '#2d3436';
                            statusDiv.style.color = '#00ff00'; // Warna hijau khas contoh
                            statusDiv.innerHTML = `Your account is <strong>${data.username}</strong> from <strong>${data.server}</strong>`;
                        } else {
                            statusDiv.style.backgroundColor = '#2d3436';
                            statusDiv.style.color = '#ff4757';
                            statusDiv.innerHTML = "Akun tidak ditemukan";
                        }
                    });
            } else {
                statusDiv.style.display = 'none'; // Sembunyikan jika belum lengkap
            }
        }

        // Event listener 'input' membuat pengecekan otomatis saat diketik
        userIdInput.addEventListener('input', checkUsername);
        zoneIdInput.addEventListener('input', checkUsername);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>