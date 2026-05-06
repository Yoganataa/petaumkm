<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Potensi Ekonomi UMKM - Sutojayan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#E6F4F3',
                        100: '#CDE9E7',
                        200: '#9FD3CF',
                        300: '#6FBDB7',
                        400: '#4FB0AA',
                        500: '#35A69F',
                        600: '#2F9E97',
                        700: '#278E87',
                        800: '#207C76',
                        900: '#186964'
                    },
                    accent: {
                        400: '#F8B84E',
                        500: '#F5A623',
                        600: '#F39C12'
                    }
                }
        }
    }
</script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">

    <!-- Header -->
    <header class="bg-gradient-to-r from-[#2F9E97] to-[#35A69F] shadow-md border-b border-[#2F9E97]">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">
                    Dashboard Potensi Ekonomi UMKM
                </h1>
                <p class="text-sm text-primary-100 mt-1">
                    Sistem Informasi Pemetaan UMKM Kecamatan Sutojayan
                </p>
            </div>

            <a href="{{ route('home') }}"
            class="bg-[#F5A623] hover:bg-[#F39C12] text-white px-5 py-2 rounded-lg font-semibold shadow-md transition">
                Kembali ke Beranda
            </a>
        </div>
    </header>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="bg-white rounded-2xl shadow-md border border-teal-100 p-6 md:p-8">

            <div class="mb-6">
                <h2 class="text-3xl font-bold text-primary-700">Visualisasi Potensi Ekonomi UMKM</h2>
                <p class="text-gray-600 mt-2">
                    Halaman ini menampilkan grafik dan diagram untuk membantu analisis jumlah UMKM per Kelurahan/Desa dan sektor usaha dominan di Kecamatan Sutojayan.
                </p>
            </div>

            <!-- Area Grafik -->
            <div class="bg-teal-50 border border-teal-100 rounded-2xl p-5 shadow-sm">
                <div class="bg-gray-50 border border-red-100 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-lg font-bold text-primary-700 mb-4">
                        Grafik Jumlah UMKM per Kelurahan/Desa
                    </h3>
                    <div class="h-80">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                <div class="bg-primary-50 border border-primary-100 rounded-2xl p-5">
                    <h3 class="text-lg font-bold text-primary-700 mb-4">
                        Diagram Sektor Usaha Dominan
                    </h3>
                    <div class="h-80 flex items-center justify-center">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Ringkasan singkat -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-primary-50 border border-primary-100 rounded-2xl p-5">
                    <p class="text-sm uppercase tracking-wide text-teal-600">Total UMKM</p>
                    <h4 class="text-3xl font-bold mt-2 text-gray-800">{{ $totalUmkm }}</h4>
                    <p class="text-sm text-gray-600 mt-2">Jumlah keseluruhan UMKM terdata.</p>
                </div>

            <div class="bg-primary-50 border border-primary-100 rounded-2xl p-5">
                <p class="text-sm uppercase tracking-wide text-primary-600">Kelurahan/Desa Dominan</p>
                <h4 class="text-3xl font-bold mt-2 text-gray-800">{{ $wilayahDominan }}</h4>
                <p class="text-sm text-gray-600 mt-2">
                        Wilayah dengan jumlah UMKM terbanyak ({{ $jumlahDominan }} UMKM).
                </p>
            </div>

            <div class="bg-primary-50 border border-primary-100 rounded-2xl p-5">
                <p class="text-sm uppercase tracking-wide text-primary-600">Sektor Dominan</p>
                <h4 class="text-3xl font-bold mt-2 text-gray-800">{{ $sektorDominan }}</h4>
                <p class="text-sm text-gray-600 mt-2">
                        Sektor usaha paling banyak dijalankan ({{ $jumlahSektorDominan }} UMKM).
                </p>
            </div>
        </div>

            <!-- Tombol Export -->
            <div class="flex flex-wrap justify-end gap-4 no-print">
            <button onclick="window.print()"
                class="bg-white border border-[#35A69F] text-[#35A69F] hover:bg-[#E6F4F3] px-6 py-3 rounded-xl font-semibold shadow-sm">
                Download PDF
            </button>

                <a href="{{ route('umkm.export') }}"
                class="bg-[#F5A623] hover:bg-[#F39C12] text-white px-6 py-3 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                    Export Excel
                </a>
                </a>
            </div>

        </div>
    </main>

<script>
    const labels = @json($chartLabels ?? []);
    const data = @json($chartData ?? []);

    const pieLabels = @json($pieLabels ?? []);
    const pieData = @json($pieData ?? []);

    // ─── Palet warna baru untuk Bar Chart ───────────────────────────────────
    // Menggunakan kombinasi ungu, biru tua, merah bata, oranye hangat, dan hijau zaitun
    // agar kontras jelas dengan background teal/putih namun tidak bertabrakan
    const barColors = [
        '#6366F1', // indigo
        '#8B5CF6', // violet
        '#EF4444', // merah
        '#F97316', // oranye
        '#EAB308', // kuning
        '#14B8A6', // teal aksen
        '#06B6D4', // cyan
        '#3B82F6', // biru
        '#A855F7', // purple
        '#10B981', // emerald
        '#F59E0B', // amber
    ];

    const barCtx = document.getElementById('barChart');

    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah UMKM',
                    data: data,
                    backgroundColor: barColors,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: '#E6F4F3'
                        }
                    }
                }
            }
        });
    }

    // ─── Palet warna baru untuk Doughnut Chart ──────────────────────────────
    // Warna-warna solid dan cerah yang berbeda dari teal, tetap enak dipandang
    const pieColors = [
        '#6366F1', // indigo
        '#F97316', // oranye
        '#EF4444', // merah
        '#EAB308', // kuning emas
        '#3B82F6', // biru
        '#A855F7', // purple
    ];

    const pieCtx = document.getElementById('pieChart');

    if (pieCtx) {
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Jumlah UMKM',
                    data: pieData,
                    backgroundColor: pieColors,
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '55%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
</script>
</body>
</html>
