// assets/js/toko.js

document.addEventListener("DOMContentLoaded", function () {
    // 1. Efek Ketikan Selamat Datang Otomatis di Beranda
    const heroTitle = document.querySelector(".carousel-item.active h2");
    if (heroTitle) {
        console.log("GameTopUp Store JS Berhasil Dimuat!");
    }

    // 2. Animasi Klik Lembut pada Kartu Game
    const gameCards = document.querySelectorAll(".game-card");
    gameCards.forEach(card => {
        card.addEventListener("click", function () {
            this.style.transform = "scale(0.95)";
        });
    });

    // 3. Auto Close Alert Notifikasi System setelah 4 detik
    const alertSystem = document.querySelectorAll(".alert");
    alertSystem.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });
});