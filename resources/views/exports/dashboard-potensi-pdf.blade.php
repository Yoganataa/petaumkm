<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard Potensi UMKM</title>
    <style>
        @media print {
            header,
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            main {
                padding: 0 !important;
                margin: 0 !important;
            }

            .shadow-md,
            .shadow-sm,
            .shadow-xl {
                box-shadow: none !important;
            }
        }
                body { font-family: Arial, sans-serif; color: #1d2a39; }
        h1 { color: #2F9E97; }
        .card {
            border: 1px solid #CDE9E7;
            padding: 14px;
            margin-bottom: 12px;
            border-radius: 8px;
        }
        .label { color: #35A69F; font-weight: bold; }
        .value { font-size: 24px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Dashboard Potensi Ekonomi UMKM</h1>
    <p>Sistem Informasi Pemetaan UMKM Kecamatan Sutojayan</p>

    <div class="card">
        <div class="label">Total UMKM</div>
        <div class="value">{{ $totalUmkm }}</div>
    </div>

    <div class="card">
        <div class="label">Kelurahan/Desa Dominan</div>
        <div class="value">{{ $wilayahDominan }}</div>
        <p>{{ $jumlahDominan }} UMKM</p>
    </div>

    <div class="card">
        <div class="label">Sektor Dominan</div>
        <div class="value">{{ $sektorDominan }}</div>
        <p>{{ $jumlahSektorDominan }} UMKM</p>
    </div>
</body>
</html>
