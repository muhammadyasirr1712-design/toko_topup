{
  "project": {
    "nama": "GameTopUp Store",
    "teknologi": {
      "frontend": ["HTML5", "CSS3", "JavaScript", "Bootstrap 5"],
      "backend": "PHP Native",
      "database": "MySQL",
      "server": "Apache (XAMPP/Laragon)",
      "payment_gateway": ["Midtrans", "Tripay"]
    }
  },
  "tahapan_pengerjaan": [
    {
      "id": 1,
      "nama_tahap": "Analisis Kebutuhan Sistem",
      "estimasi": "1 Hari",
      "aktivitas": [
        "Menentukan fitur user",
        "Menentukan fitur admin",
        "Menyusun kebutuhan sistem",
        "Membuat flow bisnis top up"
      ],
      "output": [
        "Dokumen kebutuhan sistem",
        "Flowchart sistem"
      ]
    },
    {
      "id": 2,
      "nama_tahap": "Perancangan Database",
      "estimasi": "1 Hari",
      "aktivitas": [
        "Membuat ERD",
        "Membuat relasi tabel",
        "Membuat struktur database"
      ],
      "output": [
        "Database MySQL",
        "ERD Sistem"
      ],
      "tabel": [
        "users",
        "games",
        "produk",
        "transaksi",
        "artikel",
        "voucher"
      ]
    },
    {
      "id": 3,
      "nama_tahap": "Desain UI/UX",
      "estimasi": "2 Hari",
      "aktivitas": [
        "Membuat wireframe",
        "Membuat mockup halaman",
        "Menentukan warna dan font"
      ],
      "output": [
        "Desain Home",
        "Desain Top Up",
        "Desain Dashboard User",
        "Desain Dashboard Admin"
      ]
    },
    {
      "id": 4,
      "nama_tahap": "Setup Project",
      "estimasi": "1 Hari",
      "aktivitas": [
        "Membuat struktur folder",
        "Membuat koneksi database",
        "Menambahkan Bootstrap",
        "Menambahkan Font Awesome"
      ],
      "output": [
        "Project siap dikembangkan"
      ]
    },
    {
      "id": 5,
      "nama_tahap": "Login dan Register",
      "estimasi": "2 Hari",
      "aktivitas": [
        "Membuat form login",
        "Membuat form register",
        "Implementasi session",
        "Hash password"
      ],
      "output": [
        "Sistem autentikasi user"
      ]
    },
    {
      "id": 6,
      "nama_tahap": "Halaman Home",
      "estimasi": "2 Hari",
      "aktivitas": [
        "Membuat navbar",
        "Membuat banner promo",
        "Menampilkan game populer",
        "Menampilkan artikel terbaru",
        "Menampilkan leaderboard"
      ],
      "output": [
        "Landing page toko top up"
      ]
    },
    {
      "id": 7,
      "nama_tahap": "Modul Top Up",
      "estimasi": "4 Hari",
      "aktivitas": [
        "Pilih game",
        "Input user ID",
        "Pilih nominal",
        "Pilih metode pembayaran",
        "Checkout",
        "Generate invoice"
      ],
      "output": [
        "Sistem top up game"
      ]
    },
    {
      "id": 8,
      "nama_tahap": "Modul Cek Transaksi",
      "estimasi": "1 Hari",
      "aktivitas": [
        "Pencarian transaksi",
        "Menampilkan status transaksi"
      ],
      "output": [
        "Halaman cek transaksi"
      ]
    },
    {
      "id": 9,
      "nama_tahap": "Modul Leaderboard",
      "estimasi": "1 Hari",
      "aktivitas": [
        "Menghitung total top up user",
        "Menampilkan ranking user"
      ],
      "output": [
        "Leaderboard top up"
      ]
    },
    {
      "id": 10,
      "nama_tahap": "Modul Artikel",
      "estimasi": "2 Hari",
      "aktivitas": [
        "CRUD artikel",
        "Kategori artikel",
        "Pencarian artikel"
      ],
      "output": [
        "Portal artikel game"
      ]
    },
    {
      "id": 11,
      "nama_tahap": "Modul Kalkulator",
      "estimasi": "1 Hari",
      "aktivitas": [
        "Kalkulator diamond",
        "Kalkulator diskon"
      ],
      "output": [
        "Halaman kalkulator"
      ]
    },
    {
      "id": 12,
      "nama_tahap": "Dashboard User",
      "estimasi": "2 Hari",
      "aktivitas": [
        "Menampilkan riwayat transaksi",
        "Menampilkan statistik user",
        "Edit profil"
      ],
      "output": [
        "Dashboard user"
      ]
    },
    {
      "id": 13,
      "nama_tahap": "Dashboard Admin",
      "estimasi": "3 Hari",
      "aktivitas": [
        "Statistik penjualan",
        "CRUD game",
        "CRUD produk",
        "CRUD transaksi",
        "CRUD artikel",
        "CRUD user"
      ],
      "output": [
        "Dashboard admin lengkap"
      ]
    },
    {
      "id": 14,
      "nama_tahap": "Integrasi Payment Gateway",
      "estimasi": "2 Hari",
      "aktivitas": [
        "Integrasi Midtrans",
        "Integrasi Tripay",
        "Implementasi callback pembayaran"
      ],
      "output": [
        "Pembayaran otomatis"
      ]
    },
    {
      "id": 15,
      "nama_tahap": "Integrasi WhatsApp",
      "estimasi": "1 Hari",
      "aktivitas": [
        "Notifikasi transaksi",
        "Konfirmasi pembayaran"
      ],
      "output": [
        "Notifikasi WhatsApp otomatis"
      ]
    },
    {
      "id": 16,
      "nama_tahap": "Voucher dan Promo",
      "estimasi": "1 Hari",
      "aktivitas": [
        "Sistem voucher",
        "Banner promo"
      ],
      "output": [
        "Promo dan diskon"
      ]
    },
    {
      "id": 17,
      "nama_tahap": "Keamanan Sistem",
      "estimasi": "1 Hari",
      "aktivitas": [
        "Proteksi SQL Injection",
        "Proteksi XSS",
        "Proteksi CSRF",
        "Manajemen session"
      ],
      "output": [
        "Sistem aman"
      ]
    },
    {
      "id": 18,
      "nama_tahap": "Testing Sistem",
      "estimasi": "2 Hari",
      "aktivitas": [
        "Testing user",
        "Testing admin",
        "Bug fixing"
      ],
      "output": [
        "Sistem stabil"
      ]
    },
    {
      "id": 19,
      "nama_tahap": "Deployment",
      "estimasi": "1 Hari",
      "aktivitas": [
        "Upload ke hosting",
        "Konfigurasi domain",
        "Konfigurasi SSL"
      ],
      "output": [
        "Website online"
      ]
    }
  ],
  "timeline_total": {
    "estimasi_hari": 28,
    "estimasi_minggu": 4
  },
  "urutan_pengembangan": [
    "Analisis Sistem",
    "Database",
    "UI/UX",
    "Setup Project",
    "Login dan Register",
    "Home",
    "Top Up",
    "Cek Transaksi",
    "Leaderboard",
    "Artikel",
    "Kalkulator",
    "Dashboard User",
    "Dashboard Admin",
    "Payment Gateway",
    "WhatsApp Gateway",
    "Voucher dan Promo",
    "Keamanan Sistem",
    "Testing",
    "Deployment"
  ]
}