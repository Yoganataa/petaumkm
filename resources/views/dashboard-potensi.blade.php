<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Potensi Ekonomi UMKM - Sutojayan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

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
        <div class="mt-10 no-print">
            <div class="bg-white border border-teal-100 rounded-2xl p-5 shadow-sm">
                <h3 class="text-lg font-bold text-primary-700 mb-4">
                    Download Data Dashboard
                </h3>

                <div class="flex flex-wrap justify-center gap-4">

                    <button onclick="window.print()"
                        class="bg-white border border-[#35A69F] text-[#35A69F] hover:bg-[#E6F4F3] px-6 py-3 rounded-xl font-semibold shadow-sm transition">
                        Download PDF
                    </button>

                    <a href="{{ route('umkm.export') }}"
                        class="bg-[#F5A623] hover:bg-[#F39C12] text-white px-6 py-3 rounded-xl font-semibold shadow-md transition">
                        Export Semua
                    </a>

                    <div class="relative">
                        <button onclick="togglePotensiMenu()"
                            class="bg-[#35A69F] hover:bg-[#2F9E97] text-white px-6 py-3 rounded-xl font-semibold shadow-md transition">
                            Data per Potensi
                        </button>

                        <div id="potensiMenu"
                            class="hidden absolute left-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-200 z-50 overflow-hidden">
                            <a href="{{ route('umkm.export.potensi', 'rendah') }}" class="block px-4 py-3 hover:bg-gray-100">Potensi Rendah</a>
                            <a href="{{ route('umkm.export.potensi', 'sedang') }}" class="block px-4 py-3 hover:bg-gray-100">Potensi Sedang</a>
                            <a href="{{ route('umkm.export.potensi', 'tinggi') }}" class="block px-4 py-3 hover:bg-gray-100">Potensi Tinggi</a>
                        </div>
                    </div>

                    <div class="relative">
                        <button onclick="toggleDesaMenu()"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold shadow-md transition">
                            Data per Desa
                        </button>

                        <div id="desaMenu"
                            class="hidden absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-50 overflow-hidden max-h-72 overflow-y-auto">
                            @foreach($chartLabels as $desa)
                                <a href="{{ route('umkm.export.desa', $desa) }}" class="block px-4 py-3 hover:bg-gray-100">
                                    {{ $desa }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative">
                        <button onclick="toggleSektorMenu()"
                            class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-xl font-semibold shadow-md transition">
                            Data per Sektor
                        </button>

                        <div id="sektorMenu"
                            class="hidden absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-50 overflow-hidden">
                            @foreach($pieLabels as $sektor)
                                <a href="{{ route('umkm.export.sektor', $sektor) }}" class="block px-4 py-3 hover:bg-gray-100">
                                    {{ $sektor }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
    function togglePotensiMenu() {
        document.getElementById('potensiMenu').classList.toggle('hidden');
    }

    function toggleDesaMenu() {
        document.getElementById('desaMenu').classList.toggle('hidden');
    }

    function toggleSektorMenu() {
        document.getElementById('sektorMenu').classList.toggle('hidden');
    }
    </script>

    <script>
        const labels = @json($chartLabels ?? []);
        const data = @json($chartData ?? []);

        const pieLabels = @json($pieLabels ?? []);
        const pieData = @json($pieData ?? []);

        const barColors = [
            '#14B8A6', // Kembangarum - cyan teal
            '#F43F5E', // Sutojayan - rose
            '#8B5CF6', // Kalipang - violet
            '#F97316', // Bacem - orange soft
            '#84CC16', // Kedungbunder - lime
            '#6366F1', // Jingglong - indigo
            '#EC4899', // Sukorejo - pink
            '#0EA5E9', // Sumberjo - sky blue
            '#A855F7', // Jegu - purple
            '#78716C', // Pandanarum - stone
            '#E11D48'  // Kaulon - ruby
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
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverBackgroundColor: barColors,
                        hoverBorderColor: '#ffffff',
                        hoverBorderWidth: 3,
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

        const pieColors = [
            '#2563EB', // Kuliner - Blue
            '#A855F7', // Perdagangan - Purple
            '#0EA5E9',// Industri/Produksi - Sky
            '#64748B', // Jasa - Slate
            '#EC4899', // Kecantikan - Pink
            '#B45309', // Lainnya - Mocha/Brown
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
    <footer style="background:#1a5c57;color:#fff;padding:48px 0 0;margin-top:40px;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-9 pb-9">
                <!-- Kolom 1: Tentang -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wide text-[#a8e6e0] mb-4"><i class="fas fa-building mr-2"></i>Tentang</h4>
                    <p class="text-sm leading-relaxed text-white/85">
                        Sistem Informasi Pemetaan UMKM Potensial Kecamatan Sutojayan — platform digital untuk pemetaan dan analisis potensi ekonomi UMKM di wilayah Kecamatan Sutojayan, Kabupaten Blitar.
                    </p>
                </div>

                <!-- Kolom 2: Navigasi -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wide text-[#a8e6e0] mb-4"><i class="fas fa-compass mr-2"></i>Navigasi</h4>
                    <ul class="space-y-2.5 text-sm text-white/85">
                        <li><a href="{{ url('/') }}" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ url('/peta-umkm') }}" class="hover:text-white">Peta UMKM</a></li>
                        <li><a href="{{ url('/dashboard-potensi') }}" class="hover:text-white">Dashboard Potensi</a></li>
                        <li><a href="https://kec-sutojayan.blitarkab.go.id/" target="_blank" class="hover:text-white">Website Kecamatan</a></li>
                        <li><a href="https://www.blitarkab.go.id" target="_blank" class="hover:text-white">Website Kab. Blitar</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Kontak -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wide text-[#a8e6e0] mb-4"><i class="fas fa-headset mr-2"></i>Kontak</h4>
                    <div class="flex items-start gap-2.5 mb-3 text-sm text-white/85">
                        <i class="fas fa-map-marker-alt mt-1 text-[#a8e6e0] w-4"></i>
                        <span>Jl. Raya Barat No.27, Kec. Sutojayan, Kab. Blitar, Jawa Timur</span>
                    </div>
                    <div class="flex items-start gap-2.5 mb-3 text-sm text-white/85">
                        <i class="fas fa-phone mt-1 text-[#a8e6e0] w-4"></i>
                        <span>082142773816</span>
                    </div>
                    <div class="flex items-start gap-2.5 mb-3 text-sm text-white/85">
                        <i class="fas fa-envelope mt-1 text-[#a8e6e0] w-4"></i>
                        <span><a href="mailto:sutojayancamat@gmail.com" class="text-white/85 hover:text-white">sutojayancamat@gmail.com</a></span>
                    </div>
                    <div class="flex items-start gap-2.5 mb-3 text-sm text-white/85">
                        <i class="fab fa-instagram mt-1 text-[#a8e6e0] w-4"></i>
                        <span><a href="https://www.instagram.com/sutojayankecamatan" target="_blank" class="text-white/85 hover:text-white">@sutojayankecamatan</a></span>
                    </div>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="border-t border-white/15 py-4 flex flex-col md:flex-row justify-between items-center text-xs text-white/70 gap-2">
                <span>© 2026 Kecamatan Sutojayan, Kabupaten Blitar. Semua Hak Dilindungi.</span>
                <span>Dibuat oleh <a href="https://github.com/Racheliam5" target="_blank" class="text-[#a8e6e0] hover:text-white">Racheliam5</a></span>
            </div>
        </div>
    </footer>

</body>
</html>
