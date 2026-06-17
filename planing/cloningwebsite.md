{
  "project": {
    "name": "GameTopUp Store",
    "type": "Website Top Up Game",
    "stack": {
      "frontend": ["HTML5", "CSS3", "JavaScript", "Bootstrap 5"],
      "backend": "PHP Native",
      "database": "MySQL",
      "server": "Apache",
      "payment_gateway": ["Midtrans", "Tripay"]
    }
  },
  "theme": {
    "style": "Modern Gaming Store",
    "mode": "Dark",
    "font": "Poppins",
    "colors": {
      "primary": "#6D28D9",
      "secondary": "#8B5CF6",
      "background": "#0F172A",
      "card": "#1E293B",
      "text": "#F8FAFC",
      "success": "#10B981",
      "warning": "#F59E0B",
      "danger": "#EF4444"
    }
  },
  "pages": {
    "home": {
      "sections": [
        {
          "name": "navbar",
          "items": [
            "Logo",
            "Home",
            "Semua Game",
            "Cek Transaksi",
            "Leaderboard",
            "Artikel",
            "Kalkulator",
            "Login",
            "Register"
          ]
        },
        {
          "name": "hero_banner",
          "type": "slider",
          "slides": [
            "Promo Diamond Murah",
            "Top Up Cepat dan Otomatis",
            "Bonus Voucher Setiap Hari"
          ]
        },
        {
          "name": "game_categories",
          "title": "Pilih Game Favorit",
          "display": "grid",
          "items": [
            "Mobile Legends",
            "Free Fire",
            "PUBG Mobile",
            "Valorant",
            "Genshin Impact",
            "Honkai Star Rail",
            "Roblox",
            "Call Of Duty Mobile",
            "Arena Breakout",
            "Blood Strike",
            "Magic Chess Go Go",
            "FC Mobile"
          ]
        },
        {
          "name": "popular_products",
          "title": "Produk Terlaris",
          "display": "cards"
        },
        {
          "name": "advantages",
          "title": "Kenapa Memilih Kami",
          "items": [
            "Proses Otomatis 24 Jam",
            "Pembayaran Lengkap",
            "Harga Kompetitif",
            "Customer Service Cepat",
            "Transaksi Aman"
          ]
        },
        {
          "name": "leaderboard",
          "title": "Top Spender",
          "display": "table"
        },
        {
          "name": "latest_articles",
          "title": "Artikel Terbaru",
          "display": "cards"
        },
        {
          "name": "testimonials",
          "title": "Testimoni Pelanggan",
          "display": "slider"
        },
        {
          "name": "footer",
          "items": [
            "Tentang Kami",
            "Kontak",
            "Syarat dan Ketentuan",
            "Kebijakan Privasi",
            "Media Sosial"
          ]
        }
      ]
    },
    "topup": {
      "title": "Top Up Game",
      "steps": [
        {
          "step": 1,
          "title": "Pilih Game"
        },
        {
          "step": 2,
          "title": "Masukkan User ID"
        },
        {
          "step": 3,
          "title": "Pilih Produk"
        },
        {
          "step": 4,
          "title": "Pilih Metode Pembayaran"
        },
        {
          "step": 5,
          "title": "Masukkan Nomor WhatsApp"
        },
        {
          "step": 6,
          "title": "Gunakan Voucher"
        },
        {
          "step": 7,
          "title": "Checkout"
        }
      ],
      "components": [
        "Game Information",
        "User ID Form",
        "Product Selection",
        "Payment Selection",
        "Voucher Form",
        "Order Summary"
      ]
    },
    "cek_transaksi": {
      "fields": [
        "Invoice Number",
        "Nomor WhatsApp"
      ],
      "results": [
        "Status",
        "Tanggal",
        "Nominal",
        "Metode Pembayaran",
        "Game",
        "Invoice"
      ]
    },
    "leaderboard": {
      "filters": [
        "Harian",
        "Mingguan",
        "Bulanan",
        "Tahunan"
      ],
      "columns": [
        "Ranking",
        "Username",
        "Total Top Up"
      ]
    },
    "artikel": {
      "features": [
        "Kategori",
        "Pencarian",
        "Artikel Terkait",
        "Komentar"
      ]
    },
    "kalkulator": {
      "modules": [
        {
          "name": "Kalkulator Diamond",
          "inputs": [
            "Jumlah Diamond",
            "Harga Per Diamond"
          ],
          "output": "Total Harga"
        },
        {
          "name": "Kalkulator Diskon",
          "inputs": [
            "Harga Awal",
            "Diskon Persen"
          ],
          "output": "Harga Setelah Diskon"
        }
      ]
    },
    "login": {
      "fields": [
        "Username",
        "Password"
      ],
      "features": [
        "Remember Me",
        "Lupa Password"
      ]
    },
    "register": {
      "fields": [
        "Username",
        "Email",
        "Password",
        "Konfirmasi Password"
      ]
    }
  },
  "dashboard_user": {
    "menu": [
      "Dashboard",
      "Riwayat Transaksi",
      "Profil",
      "Pengaturan",
      "Logout"
    ],
    "widgets": [
      "Total Top Up",
      "Total Pengeluaran",
      "Transaksi Terakhir",
      "Status Pesanan"
    ]
  },
  "dashboard_admin": {
    "sidebar": [
      "Dashboard",
      "Game",
      "Kategori Game",
      "Produk",
      "Metode Pembayaran",
      "Transaksi",
      "Artikel",
      "Banner",
      "Testimoni",
      "User",
      "Admin",
      "Pengaturan"
    ],
    "widgets": [
      "Total User",
      "Total Transaksi",
      "Total Pendapatan",
      "Total Artikel",
      "Total Game"
    ],
    "reports": [
      "Penjualan Harian",
      "Penjualan Bulanan",
      "Penjualan Tahunan"
    ]
  },
  "database": {
    "tables": [
      "users",
      "games",
      "kategori_game",
      "produk",
      "transaksi",
      "artikel",
      "voucher",
      "leaderboard",
      "metode_pembayaran",
      "banner",
      "testimoni",
      "settings",
      "admin"
    ]
  },
  "integrations": {
    "payment_gateway": [
      "Midtrans",
      "Tripay"
    ],
    "whatsapp_gateway": [
      "Fonnte",
      "Wablas"
    ]
  },
  "features": {
    "authentication": true,
    "topup_system": true,
    "transaction_tracking": true,
    "leaderboard": true,
    "article_management": true,
    "calculator": true,
    "voucher_system": true,
    "banner_management": true,
    "testimonial_management": true,
    "dark_mode": true,
    "responsive_design": true,
    "seo_friendly": true,
    "payment_gateway": true,
    "whatsapp_notification": true
  },
  "development_timeline": {
    "week_1": [
      "Analisis Sistem",
      "Flowchart",
      "Use Case Diagram"
    ],
    "week_2": [
      "Desain Database",
      "ERD",
      "Desain UI/UX"
    ],
    "week_3": [
      "Setup Project",
      "Login",
      "Register"
    ],
    "week_4": [
      "Home Page",
      "Banner",
      "Game List"
    ],
    "week_5": [
      "Top Up System",
      "Checkout",
      "Invoice"
    ],
    "week_6": [
      "Leaderboard",
      "Artikel",
      "Kalkulator",
      "Cek Transaksi"
    ],
    "week_7": [
      "Dashboard User",
      "Dashboard Admin"
    ],
    "week_8": [
      "Payment Gateway",
      "WhatsApp Gateway",
      "Testing",
      "Deployment"
    ]
  }
}