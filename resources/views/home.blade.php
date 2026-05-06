<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Pemetaan UMKM</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

    <style>
        :root {
            --primary: #35A69F;       /* hijau tosca utama */
            --primary-dark: #2F9E97;  /* hijau lebih gelap */
            --primary-soft: #E6F4F3;  /* hijau soft */

            --accent: #F5A623;        /* kuning */
            --accent-dark: #F39C12;   /* orange */

            --text-dark: #1d2a39;
            --text-muted: #667085;
            --border-soft: #e6efee;
            --white: #ffffff;
            --bg-light: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* NAVBAR */
        .navbar {
            background: var(--white);
            border-bottom: 1px solid var(--border-soft);
            height: 78px;
            display: flex;
            align-items: center;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
        }

        .brand-text h1 {
            font-size: 15px;
            color: var(--primary);
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 3px;
        }

        .brand-text p {
            font-size: 12px;
            color: #6f6f6f;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 28px;
            font-size: 15px;
            font-weight: 600;
            color: #2d3748;
        }

        .menu a.active {
            color: var(--primary);
        }

        /* HERO */
        .hero {
            position: relative;
            min-height: 430px;
            overflow: hidden;
            background:
                linear-gradient(rgba(53, 166, 159, 0.80), rgba(47, 158, 151, 0.65)),
                url('https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?q=80&w=1600&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                rgba(30, 120, 115, 0.5)0%,
                rgba(42, 157, 143, 0.22) 55%,
                rgba(255, 255, 255, 0.06) 100%
            );
            pointer-events: none;
        }

        .hero .container {
            position: relative;
            z-index: 2;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1.05fr 1fr;
            gap: 28px;
            align-items: center;
            padding: 28px 0 34px;
        }

        .hero-left {
            color: #fff;
            padding-top: 10px;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.18);
            color: #fff;
            font-size: 13px;
            padding: 10px 16px;
            border-radius: 24px;
            margin-bottom: 18px;
            font-weight: 600;
            backdrop-filter: blur(2px);
        }

        .hero-left h2 {
            font-size: 44px;
            line-height: 1.08;
            font-weight: 800;
            margin-bottom: 18px;
            max-width: 580px;
        }

        .hero-left p {
            font-size: 16px;
            line-height: 1.75;
            max-width: 560px;
            color: rgba(255,255,255,0.92);
        }

        .hero-map-card {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.26);
            border-radius: 18px;
            padding: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            margin-top: 6px;
            backdrop-filter: blur(4px);
        }

        .hero-map-title {
            color: #18443f;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 10px;
            padding-left: 4px;
            color: #f7fffe;
        }

        #heroMap {
            width: 100%;
            height: 320px;
            min-height: 320px;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.50);
        }

        /* CTA */
        .cta-section {
            background: transparent;
            padding: 42px 0 20px;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .btn-red {
            color: #fff;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            padding: 14px 24px;
            min-width: 220px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.10);
            transition: .25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .cta-buttons .btn-red:first-child {
            background: linear-gradient(135deg, #35A69F, #5FC3BC);
            box-shadow: 0 8px 18px rgba(42, 157, 143, 0.24);
        }

        .cta-buttons .btn-red:last-child {
            background: linear-gradient(135deg, #F5A623, #F8B84E);
            box-shadow: 0 8px 18px rgba(244, 162, 97, 0.28);
        }

        .cta-buttons .btn-red:first-child:hover {
            background: linear-gradient(135deg, var(--primary-dark), #3ca99d);
            transform: translateY(-2px);
        }

        .cta-buttons .btn-red:last-child:hover {
            background: linear-gradient(135deg, var(--accent-dark), #eea14d);
            transform: translateY(-2px);
        }

        /* STATS */
        .stats-section {
            padding: 34px 0 54px;
            text-align: center;
        }

        .stats-section h3 {
            font-size: 26px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .stats-section .subtitle {
            color: #667085;
            font-size: 16px;
            margin-bottom: 34px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            text-align: left;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 22px 18px;
            min-height: 124px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
            border: 1px solid var(--border-soft);
        }

        .card-red {
            background: linear-gradient(180deg, #2A9D8F 0%, #23897d 100%);
            color: #fff;
            border: none;
            box-shadow: 0 10px 24px rgba(42, 157, 143, 0.18);
        }

        .card-white {
            border-left: 4px solid var(--accent);
        }

        .card-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .3px;
            margin-bottom: 12px;
            color: inherit;
            opacity: 0.96;
            font-weight: 700;
        }

        .card-white .card-label {
            color: var(--accent);
        }

        .card-value {
            font-size: 22px;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 8px;
        }

        .card-desc {
            font-size: 15px;
            line-height: 1.55;
            color: inherit;
            opacity: 0.95;
        }

        .card-white .card-value {
            color: var(--text-dark);
        }

        .card-white .card-desc {
            color: var(--text-muted);
        }

        /* FOOTER */
        footer {
            background: #2F9E97;
            color: #fff;
            padding: 22px 0 20px;
            text-align: center;
            margin-top: 8px;
        }

        footer .footer-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        footer .footer-sub {
            font-size: 15px;
            margin-bottom: 10px;
        }

        footer .footer-copy {
            font-size: 14px;
            opacity: 0.95;
        }

        /* LEAFLET */
        .leaflet-popup-content {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }

        #heroMap .leaflet-control-zoom a {
            width: 34px;
            height: 34px;
            line-height: 34px;
            font-size: 20px;
        }

        #heroMap .leaflet-popup-content-wrapper {
            border-radius: 12px;
        }

        #heroMap .leaflet-container {
            font-family: Arial, Helvetica, sans-serif;
        }

        @media (max-width: 992px) {
            .hero-content {
                grid-template-columns: 1fr;
            }

            .hero-left h2 {
                font-size: 36px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                height: auto;
                padding: 14px 0;
            }

            .navbar-inner {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .menu {
                gap: 16px;
                flex-wrap: wrap;
            }

            .hero-left h2 {
                font-size: 30px;
            }

            .hero-left p {
                font-size: 15px;
            }

            #heroMap {
                height: 260px;
                min-height: 260px;
            }

            .btn-red {
                min-width: 180px;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container navbar-inner">
            <div class="brand">
                <div class="brand-icon">U</div>
                <div class="brand-text">
                    <h1>Sistem Informasi Pemetaan UMKM</h1>
                    <p>Kecamatan Sutojayan</p>
                </div>
            </div>

            <div class="menu">
                <a href="{{ url('/') }}" class="active">Beranda</a>
                <a href="{{ url('/login') }}">Login</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-left">
                    <div class="hero-badge">WebGIS UMKM Kecamatan Sutojayan</div>

                    <h2>Sistem Informasi<br>Pemetaan UMKM<br>Kecamatan Sutojayan</h2>

                    <p>
                        Platform berbasis WebGIS untuk mendukung pemetaan, pendataan, dan
                        analisis potensi UMKM di Kecamatan Sutojayan secara interaktif,
                        informatif, dan terintegrasi.
                    </p>
                </div>

                <div class="hero-right">
                    <div class="hero-map-card">
                        <div class="hero-map-title">Ilustrasi Peta Kecamatan Sutojayan</div>
                        <div id="heroMap">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126375.87298760725!2d112.14670725186036!3d-8.177951728665716!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78eab02c260a89%3A0xee10358bf49a398d!2sKec.%20Sutojayan%2C%20Kabupaten%20Blitar%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1777639193568!5m2!1sid!2sid"
                                width="100%"
                                height="100%"
                                style="border:0; border-radius:14px;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-buttons">
                <a href="{{ url('/peta-umkm') }}" class="btn-red">Lihat Peta UMKM</a>
                <a href="{{ url('/dashboard-potensi') }}" class="btn-red">Dashboard Potensi</a>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <h3>Statistik Ringkas UMKM</h3>
            <p class="subtitle">Gambaran awal kondisi UMKM di Kecamatan Sutojayan</p>

            <div class="cards">
                <div class="card card-red">
                    <div class="card-label">Jumlah UMKM</div>
                    <div class="card-value">{{ $totalUmkm }}</div>
                    <div class="card-desc">Total keseluruhan UMKM terdata di Kecamatan Sutojayan</div>
                </div>

                <div class="card card-white">
                    <div class="card-label">Sektor Usaha Terbanyak</div>
                    <div class="card-value">{{ $sektorDominan }}</div>
                    <div class="card-desc">
                        Sektor dominan yang paling banyak dijalankan pelaku UMKM
                        ({{ $jumlahSektorDominan }} UMKM)
                    </div>
                </div>

                <div class="card card-white">
                    <div class="card-label">Total Potensi Ekonomi</div>
                    <div class="card-value">Belum tersedia</div>
                    <div class="card-desc">Estimasi kontribusi ekonomi UMKM terhadap wilayah</div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-title">Sistem Informasi Pemetaan UMKM Kecamatan Sutojayan</div>
            <div class="footer-sub">Instansi Pengembang / Penelitian WebGIS UMKM</div>
            <div class="footer-copy">© 2026 - Semua Hak Dilindungi</div>
        </div>
    </footer>
</body>
</html>
