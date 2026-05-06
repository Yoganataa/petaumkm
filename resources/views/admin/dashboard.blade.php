<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - WebGIS UMKM Sutojayan</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

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
        }
    </script>
</head>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const adminMapElement = document.getElementById('adminMap');
        if (!adminMapElement) return;

        const adminMap = L.map('adminMap').setView([-8.1690904, 112.211385], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(adminMap);

        const umkmData = @json($mapUmkms);

        const batasKecamatan = [
            [-8.1560, 112.1950],
            [-8.1485, 112.2140],
            [-8.1490, 112.2400],
            [-8.1560, 112.2785],
            [-8.1730, 112.2795],
            [-8.1955, 112.2460],
            [-8.2010, 112.2240],
            [-8.1880, 112.1980],
            [-8.1730, 112.1930]
        ];

        const polygon = L.polygon(batasKecamatan, {
            color: '#F5A623',
            weight: 3,
            dashArray: '10, 8',
            fillOpacity: 0
        }).addTo(adminMap);

        const bounds = [];

        umkmData.forEach(item => {
            if (!item.latitude || !item.longitude) return;

            let color = 'red';
            const status = (item.status_potensi || '').toLowerCase();

            if (status === 'tinggi') color = 'green';
            else if (status === 'sedang') color = 'orange';

            const icon = L.icon({
                iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${color}.png`,
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            const marker = L.marker(
                [parseFloat(item.latitude), parseFloat(item.longitude)],
                { icon: icon }
            ).addTo(adminMap);

            marker.bindPopup(`
                <div style="min-width:220px">
                    <strong>${item.nama_usaha}</strong><br>
                    Pemilik: ${item.pemilik ?? '-'}<br>
                    Bidang: ${item.bidang_usaha ?? '-'}<br>
                    Wilayah: ${item.desa ?? '-'}<br>
                    Potensi: ${item.status_potensi ?? '-'}
                </div>
            `);

            bounds.push([parseFloat(item.latitude), parseFloat(item.longitude)]);
        });

        if (bounds.length > 0) {
            adminMap.fitBounds(bounds, { padding: [20, 20] });
        } else {
            adminMap.fitBounds(polygon.getBounds(), { padding: [20, 20] });
        }

        setTimeout(() => {
            adminMap.invalidateSize();
        }, 300);
    });
</script>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="w-72 bg-gradient-to-b from-[#2F9E97] to-[#186964] text-white flex flex-col shadow-xl">
            <div class="px-6 py-6 border-b border-teal-500">
                <h1 class="text-2xl font-bold leading-snug">Admin WebGIS UMKM</h1>
                <p class="text-white text-sm mt-1">Kecamatan Sutojayan</p>
            </div>

    <nav class="flex-1 px-4 py-6 space-y-3">
        <a href="{{ route('admin.dashboard') }}"
           class="block px-4 py-3 rounded-xl bg-[#F5A623] text-white font-semibold shadow">
            Dashboard
        </a>

        <a href="{{ route('admin.data.umkm') }}"
           class="block px-4 py-3 rounded-xl text-white hover:bg-[#2F9E97] font-semibold transition">
            Data UMKM
        </a>

        <a href="{{ route('admin.map.umkm') }}"
           class="block px-4 py-3 rounded-xl text-white hover:bg-[#2F9E97] font-semibold transition">
            Peta UMKM
        </a>

        <a href="{{ route('logout') }}"
           class="block px-4 py-3 rounded-xl text-white hover:bg-[#2F9E97] font-semibold transition">
            Logout
        </a>
    </nav>
</aside>

        <!-- Main Area -->
        <div class="flex-1 flex flex-col">

            <!-- Topbar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-primary-700">
                            Sistem Informasi Pemetaan UMKM Kecamatan Sutojayan
                        </h2>
                        <p class="text-sm text-gray-500">
                            Dashboard Admin
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">
                                {{ session('user_name') ?? 'Admin' }}
                            </p>
                            <p class="text-sm text-gray-500">Pengelola Sistem</p>
                        </div>
                        <div class="w-11 h-11 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-lg">
                            A
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6">

                <!-- Heading -->
                <main class="flex-1 bg-gray-100 p-8">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-teal-700">Ringkasan Dashboard</h2>
                    <p class="text-gray-600 mt-2">
                     Monitoring awal data UMKM sebagai alat bantu analisis dan pengambilan keputusan.
                    </p>
                </div>

    <!-- Card Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-8 shadow border border-primary-100">
            <p class="text-sm uppercase tracking-wide text-primary-600">Total UMKM</p>
            <h3 class="text-5xl font-bold text-slate-800 mt-3">{{ $totalUmkm }}</h3>
            <p class="text-gray-500 mt-3">Jumlah keseluruhan UMKM terdata</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow border border-primary-100">
            <p class="text-sm uppercase tracking-wide text-primary-600">UMKM Aktif</p>
            <h3 class="text-5xl font-bold text-slate-800 mt-3">{{ $umkmAktif }}</h3>
            <p class="text-gray-500 mt-3">UMKM yang aktif menjalankan usaha</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow border border-primary-100">
            <p class="text-sm uppercase tracking-wide text-primary-600">Total Desa/Kelurahan</p>
            <h3 class="text-5xl font-bold text-slate-800 mt-3">{{ $totalWilayah }}</h3>
            <p class="text-gray-500 mt-3">Wilayah administrasi yang terdata</p>
        </div>
    </div>

    <!-- Modul -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <a href="{{ route('admin.data.umkm') }}"
           class="block bg-[#F5A623] text-white rounded-3xl p-8 shadow-md hover:bg-[#F39C12] transition">
            <h3 class="text-2xl font-bold mb-4">Modul Data UMKM</h3>
            <p class="text-lg leading-relaxed">
                Kelola data UMKM, tambah data, ubah data, dan hapus data.
            </p>
        </a>

        <a href="{{ route('admin.map.umkm') }}"
           class="block bg-[#F5A623] text-white rounded-3xl p-8 shadow-md hover:bg-[#2F9E97] transition">
            <h3 class="text-2xl font-bold mb-4">Modul Peta UMKM</h3>
            <p class="text-lg leading-relaxed">
                Lihat persebaran lokasi UMKM dan analisis spasial berbasis WebGIS.
            </p>
        </a>
    </div>

    <!-- Statistik per Sektor -->
    <div class="bg-white rounded-3xl p-8 shadow border border-[#E6F4F3] mb-8">
        <h3 class="text-2xl font-bold text-[#2F9E97] mb-6">
            Statistik UMKM per Sektor
        </h3>

        <div class="h-[400px]">
            <canvas id="sektorChart"></canvas>
        </div>
    </div>

    <!-- Komposisi UMKM -->
    <div class="bg-white rounded-3xl p-8 shadow border border-primary-100">
        <h3 class="text-2xl font-bold text-primary-700 mb-6">Komposisi UMKM</h3>
        <div class="h-[400px] flex items-center justify-center">
            <canvas id="komposisiChart"></canvas>
        </div>
    </div>
</main>
        </div>
    </div>

<script>
    const komposisiLabels = @json($komposisiLabels);
    const komposisiData = @json($komposisiData);

    const komposisiCtx = document.getElementById('komposisiChart').getContext('2d');

    new Chart(komposisiCtx, {
        type: 'doughnut',
        data: {
            labels: komposisiLabels,
            datasets: [{
                data: komposisiData,
                backgroundColor: [
                    '#16a34a', // tinggi
                    '#f59e0b', // sedang
                    '#dc2626'  // rendah
                ],
                borderWidth: 2,
                borderColor: '#E6F4F3'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '58%',
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>

<script>
    const sektorLabels = @json($sektorLabels ?? []);
    const sektorData = @json($sektorData ?? []);

    const sektorCanvas = document.getElementById('sektorChart');

    if (sektorCanvas) {
        new Chart(sektorCanvas, {
            type: 'bar',
            data: {
                labels: sektorLabels,
            datasets: [{
                label: 'Jumlah UMKM',
                data: sektorData,
                backgroundColor: [
                    '#35A69F',
                    '#4FB0AA',
                    '#6FBDB7',
                    '#9FD3CF',
                    '#F5A623',
                    '#F8B84E'
                ],
                borderColor: '#ffffff',
                borderWidth: 2,
                borderRadius: 12,
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
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: '#E6F4F3'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
</script>
</body>
</html>
