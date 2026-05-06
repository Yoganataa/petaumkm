<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta UMKM - WebGIS Sutojayan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
                                500: '#35A69F', // utama
                                600: '#2F9E97',
                                700: '#278E87',
                                800: '#207C76',
                                900: '#186964'
                            },
                            accent: {
                                400: '#F8B84E',
                                500: '#F5A623', // kuning
                                600: '#F39C12'  // orange
                            }
                        }
                }
            }
        }
    </script>

    <style>
        html, body {
            height: 100%;
        }

        #map {
            height: 100%;
            width: 100%;
            min-height: 500px;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 14px;
        }

        .leaflet-popup-content {
            margin: 14px 16px;
        }

        .label-usaha {
            background: transparent !important;
            border: none !important;
        }

        .label-usaha::before {
            display: none !important; /* hilangkan panah */
        }

        .label-usaha span {
            font-weight: 700;
            font-size: 12px;
        }

    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="h-screen flex">

        <!-- Sidebar Filter -->
        <aside class="w-72 bg-gradient-to-b from-teal-600 to-teal-700 text-white shadow-md flex flex-col">
            <div class="px-6 py-5 border-b border-teal-500">
                <h1 class="text-xl font-bold"> Filter Peta UMKM</h1>
                <p class="text-sm text-teal-100 mt-1">Kecamatan Sutojayan</text-sm>
            </div>

            <div class="p-6 space-y-5 overflow-y-auto">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">
                        Kategori Usaha
                    </label>
                    <select id="filterKategori"
                        class="w-full border border-primary-400 bg-white text-black rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-500">
                        <option value="semua" class="text-black">Semua Kategori</option>
                        <option value="Kuliner" class="text-black">Kuliner</option>
                        <option value="Perdagangan" class="text-black">Perdagangan</option>
                        <option value="Industri/Produksi" class="text-black">Industri/Produksi</option>
                        <option value="Jasa" class="text-black">Jasa</option>
                        <option value="Kecantikan" class="text-black">Kecantikan</option>
                        <option value="Lainnya" class="text-black">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white mb-2">
                        Wilayah
                    </label>
                   <select id="filterWilayah"
                        class="w-full border border-primary-400 bg-white text-black rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-500">
                        <option value="semua" class="text-black">Semua Wilayah</option>
                        <option value="Sutojayan" class="text-black">Sutojayan</option>
                        <option value="Kalipang" class="text-black">Kalipang</option>
                        <option value="Kembangarum" class="text-black">Kembangarum</option>
                        <option value="Kedungbunder" class="text-black">Kedungbunder</option>
                        <option value="Jingglong" class="text-black">Jingglong</option>
                        <option value="Jegu" class="text-black">Jegu</option>
                        <option value="Bacem" class="text-black">Bacem</option>
                        <option value="Pandanarum" class="text-black">Pandanarum</option>
                        <option value="Kaulon" class="text-black">Kaulon</option>
                        <option value="Sukorejo" class="text-black">Sukorejo</option>
                        <option value="Sumberjo" class="text-black">Sumberjo</option>
                    </select>
                </div>

                <div>
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">
                        Status Potensi
                    </label>
                    <select id="filterStatus"
                        class="w-full border border-primary-400 bg-white text-black rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-500">
                        <option value="semua" class="text-black">Semua Potensi</option>
                        <option value="tinggi" class="text-black">Tinggi</option>
                        <option value="sedang" class="text-black">Sedang</option>
                        <option value="rendah" class="text-black">Rendah</option>
                    </select>
                </div>

            <div class="pt-2 space-y-3">
            <button id="btnFilter" type="button"
                class="w-full bg-accent-500 text-white py-3 rounded-2xl font-semibold shadow-md hover:bg-accent-600 transition">
                Terapkan Filter
            </button>

            <button id="btnReset" type="button"
                class="w-full bg-accent-500 text-white py-3 rounded-2xl font-semibold shadow-md hover:bg-accent-600 transition">
                Reset Filter
            </button>
</div>

                <div class="pt-4 border-t border-gray-200">
                    <h3 class="font-bold text-[#E6F4F3] mb-3">Informasi Modul</h3>
                    <p class="text-sm text-white leading-relaxed">
                        Halaman ini digunakan untuk menampilkan persebaran UMKM secara geografis.
                        Pengguna dapat memfilter data berdasarkan kategori usaha, wilayah, dan status data,
                        lalu melihat detail setiap titik UMKM melalui pop-up marker pada peta.
                    </p>
                </div>

                <div class="pt-4">
                    <a href="{{ route('home') }}"
                       class="block text-center bg-accent-500 hover:bg-accent-600 text-white py-3 rounded-xl font-semibold transition">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </aside>

        <!-- Area Peta -->
        <main class="flex-1 p-5 bg-gray-100">
            <div class="h-full bg-white rounded-2xl shadow-md border border-primary-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-primary-700">Modul Peta Interaktif UMKM</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Visualisasi persebaran UMKM berbasis lokasi di Kecamatan Sutojayan
                        </p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Leaflet WebGIS
                    </div>
                </div>

                <div class="h-[calc(100%-81px)]">
                    <div id="map"></div>
                </div>
            </div>
        </main>
    </div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sutojayanCenter = [-8.1690904, 112.211385];

    const map = L.map('map').setView(sutojayanCenter, 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const umkmData = @json($umkms ?? []);

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

    let markerLayer = L.layerGroup().addTo(map);
    let bounds = [];

    function getMarkerColor(status) {
        status = (status || '').toLowerCase();

        if (status === 'tinggi') return 'green';
        if (status === 'sedang') return 'orange';
        return 'red';
    }

    function renderMarkers(data) {
        markerLayer.clearLayers();
        bounds = [];

        data.forEach(item => {
            if (!item.latitude || !item.longitude) return;

            const lat = parseFloat(item.latitude);
            const lng = parseFloat(item.longitude);

            if (isNaN(lat) || isNaN(lng)) return;

            const color = getMarkerColor(item.status_potensi);

            const icon = L.icon({
                iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${color}.png`,
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            const marker = L.marker([lat, lng], { icon }).addTo(markerLayer);

            let warnaText = '#2F9E97'; // default

            if (item.status_potensi === 'tinggi') {
                warnaText = '#22c55e'; // hijau
            } else if (item.status_potensi === 'sedang') {
                warnaText = '#F5A623'; // orange
            } else {
                warnaText = '#ef4444'; // merah
            }

            marker.bindTooltip(
                `
                <div style="
                    background:white;
                    padding:4px 8px;
                    border-radius:8px;
                    box-shadow:0 2px 6px rgba(0,0,0,0.2);
                    font-weight:600;
                    font-size:12px;
                    color:${warnaText};
                    white-space:nowrap;
                ">
                    ${item.nama_usaha ?? '-'}
                </div>
                `,
                {
                    permanent: true,
                    direction: 'right',
                    offset: [10, 0],
                    className: 'label-usaha',
                }
            );

            function getPopupIcon(kategori, status) {
                const warna = getPotensiColor(status);

                if (kategori === 'Kuliner') {
                    return `<i class="fa-solid fa-utensils" style="color:${warna};"></i>`;
                } else if (kategori === 'Perdagangan') {
                    return `<i class="fa-solid fa-bag-shopping" style="color:${warna};"></i>`;
                } else if (kategori === 'Industri/Produksi') {
                    return `<i class="fa-solid fa-industry" style="color:${warna};"></i>`;
                } else if (kategori === 'Jasa') {
                    return `<i class="fa-solid fa-handshake" style="color:${warna};"></i>`;
                } else if (kategori === 'Kecantikan') {
                    return `<i class="fa-solid fa-spa" style="color:${warna};"></i>`;
                } else {
                    return `<i class="fa-solid fa-ellipsis" style="color:${warna};"></i>`;
                }
            }

            function getPotensiColor(status) {
                status = (status || '').toLowerCase();

                if (status === 'tinggi') return '#22c55e'; // hijau
                if (status === 'sedang') return '#f59e0b'; // orange
                return '#ef4444'; // merah (rendah)
            }

            const popupIcon = getPopupIcon(item.bidang_usaha, item.status_potensi);

            marker.bindPopup(`
                <div style="width:260px; font-family:Arial, sans-serif; display:flex;">

                <div style="flex:1;">

                    <!-- HEADER FLEX -->
                    <div style="
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                        gap:10px;
                        margin-bottom:8px;
                    ">

                        <!-- NAMA USAHA -->
                        <div style="
                            background:${getPotensiColor(item.status_potensi)};
                            color:white;
                            padding:8px 12px;
                            border-radius:10px;
                            font-weight:700;
                            flex:1;
                        ">
                            ${item.nama_usaha ?? '-'}
                        </div>

                        <!-- ICON -->
                        <div style="
                            width:60px;
                            height:60px;
                            border-radius:50%;
                            background:${getPotensiColor(item.status_potensi)}20;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            box-shadow:0 4px 10px rgba(0,0,0,0.15);
                            font-size:24px;
                        ">
                            ${popupIcon}
                        </div>

                    </div>

                        <div style="padding:10px; background:white; border-radius:0 0 10px 10px;">
                            <p style="margin:4px 0;"><b>Pemilik:</b> ${item.pemilik ?? '-'}</p>
                            <p style="margin:4px 0;"><b>Bidang:</b> ${item.bidang_usaha ?? '-'}</p>
                            <p style="margin:4px 0;"><b>Desa:</b> ${item.desa ?? '-'}</p>
                            <p style="margin:4px 0;"><b>Alamat:</b> ${item.alamat ?? '-'}</p>
                            <p style="margin:4px 0;"><b>Potensi:</b> ${item.status_potensi ?? '-'}</p>
                        </div>
                    </div>

                </div>
            `);
            bounds.push([lat, lng]);
        });

        if (bounds.length > 0) {
    map.fitBounds(bounds, {
        padding: [50, 50],
        maxZoom: 14
    });
} else {
    map.setView(sutojayanCenter, 13);
}

    }

    renderMarkers(umkmData);

document.getElementById('btnFilter').addEventListener('click', function () {
    const kategori = document.getElementById('filterKategori').value;
    const wilayah = document.getElementById('filterWilayah').value;
    const status = document.getElementById('filterStatus').value;

    const filtered = umkmData.filter(item => {
        const cocokKategori = kategori === 'semua' || item.bidang_usaha === kategori;
        const cocokWilayah = wilayah === 'semua' || item.desa === wilayah;
        const cocokStatus = status === 'semua' || (item.status_potensi || '').toLowerCase() === status;

        return cocokKategori && cocokWilayah && cocokStatus;
    });

    renderMarkers(filtered);
});

document.getElementById('btnReset').addEventListener('click', function () {
    document.getElementById('filterKategori').value = 'semua';
    document.getElementById('filterWilayah').value = 'semua';
    document.getElementById('filterStatus').value = 'semua';

    renderMarkers(umkmData);
});

    setTimeout(() => {
        map.invalidateSize();
    }, 300);
});
</script>

</body>
</html>
