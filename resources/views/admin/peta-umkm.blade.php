<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta UMKM Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        html, body {
            height: 100%;
        }

        #map {
            width: 100%;
            height: 100%;
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
            display: none !important;
        }

        .label-usaha span {
            font-weight: 700;
            font-size: 12px;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-white via-[#E6F4F3] to-[#FFF3D6] text-gray-800">

<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-72 bg-gradient-to-b from-[#2F9E97] to-[#186964] text-white flex flex-col shadow-xl">
        <div class="px-6 py-6 border-b border-teal-500">
            <h1 class="text-2xl font-bold">Admin WebGIS UMKM</h1>
            <p class="text-white text-sm mt-1">Kecamatan Sutojayan</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-3">
            <a href="{{ route('admin.dashboard') }}"
                class="block px-4 py-3 rounded-xl text-white hover:bg-[#2F9E97] font-semibold transition">
                Dashboard
            </a>

            <a href="{{ route('admin.data.umkm') }}"
               class="block px-4 py-3 rounded-xl text-white hover:bg-[#2F9E97] font-semibold transition">
                Data UMKM
            </a>

            <a href="{{ route('admin.map.umkm') }}"
               class="block px-4 py-3 rounded-xl bg-[#F5A623] text-white font-semibold shadow">
                Peta UMKM
            </a>

            <a href="{{ route('logout') }}"
               class="block px-4 py-3 rounded-xl text-white hover:bg-[#2F9E97] font-semibold transition">
                Logout
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <main class="flex-1 flex flex-col">

        <!-- HEADER -->
        <header class="bg-white border-b border-[#E6F4F3] shadow-sm">
            <div class="px-8 py-5 flex items-center justify-between">

                <!-- Kiri -->
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-[#2F9E97] leading-tight">
                        Peta UMKM Admin
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Persebaran lokasi UMKM yang sudah diinput
                    </p>
                </div>

                <!-- Kanan (Admin) -->
                <div class="flex items-center gap-3">
                    <div class="text-right leading-tight">
                        <p class="font-semibold text-gray-800">
                            {{ session('user_name') ?? 'Admin' }}
                        </p>
                        <p class="text-sm text-gray-500">Pengelola Sistem</p>
                    </div>

                    <div class="w-11 h-11 rounded-full bg-[#35A69F] text-white flex items-center justify-center font-bold text-lg shadow">
                        A
                    </div>
                </div>

            </div>
        </header>

        <!-- CONTENT -->
        <div class="p-8">
            <div class="bg-white rounded-2xl shadow-lg border border-[#E6F4F3] overflow-hidden">
                <div class="h-[600px]">
                    <div id="map"></div>
                </div>
            </div>
        </div>

    </main>

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

            let warnaText = '#2F9E97';

            if ((item.status_potensi || '').toLowerCase() === 'tinggi') {
                warnaText = '#22c55e';
            } else if ((item.status_potensi || '').toLowerCase() === 'sedang') {
                warnaText = '#F5A623';
            } else {
                warnaText = '#ef4444';
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
            const targetBounds = L.latLngBounds(bounds).extend(polygon.getBounds());

            map.fitBounds(targetBounds, {
                padding: [50, 50],
                maxZoom: 14
            });
        } else {
            map.fitBounds(polygon.getBounds(), {
                padding: [50, 50],
                maxZoom: 13
            });
        }
    }

    renderMarkers(umkmData);

    setTimeout(() => {
        map.invalidateSize();
    }, 300);
});
</script>

</body>
</html>
