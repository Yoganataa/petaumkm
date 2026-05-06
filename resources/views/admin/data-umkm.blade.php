<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data UMKM - WebGIS UMKM Sutojayan</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

<div class="min-h-screen flex">

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
               class="block px-4 py-3 rounded-xl bg-[#F5A623] text-white font-semibold shadow">
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

        <div class="flex-1 flex flex-col">

        <header class="bg-white shadow-md border-b border-[#E6F4F3]">
            <div class="px-8 py-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#2F9E97]">
                        Modul Data UMKM
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Sistem Informasi Pemetaan UMKM Kecamatan Sutojayan
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right">
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

        <main class="flex-1 px-8 py-10">
            <div class="bg-white rounded-2xl shadow-md border border-primary-100 p-6 md:p-8">

                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-teal-700">Tabel Data UMKM</h2>
                    <p class="text-gray-600 mt-1">
                        Modul ini digunakan untuk mengelola data UMKM secara terstruktur, cepat, dan terintegrasi dengan peta WebGIS.
                    </p>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead class="bg-[#2F9E97] text-white">
                            <tr>
                                <th class="px-3 py-3 text-left">No</th>
                                <th class="px-3 py-3 text-left">Nama Usaha</th>
                                <th class="px-3 py-3 text-left">Pemilik</th>
                                <th class="px-3 py-3 text-left">Bidang</th>
                                <th class="px-3 py-3 text-left">Kel/Desa</th>
                                <th class="px-3 py-3 text-left">Latitude</th>
                                <th class="px-3 py-3 text-left">Longitude</th>
                                <th class="px-3 py-3 text-left">Status</th>
                                <th class="px-3 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($umkms as $umkm)
                            <tr class="hover:bg-[#E6F4F3] transition">
                                <td class="px-3 py-2">{{ $loop->iteration }}</td>

                                <td class="px-3 py-2 font-medium max-w-[150px] truncate">
                                    {{ $umkm->nama_usaha }}
                                </td>

                                <td class="px-3 py-2">{{ $umkm->pemilik ?? '-' }}</td>

                                <td class="px-3 py-2">{{ $umkm->bidang_usaha }}</td>

                                <td class="px-3 py-2">{{ $umkm->desa }}</td>

                                <td class="px-3 py-2 text-xs">{{ $umkm->latitude }}</td>

                                <td class="px-3 py-2 text-xs">{{ $umkm->longitude }}</td>

                                <td class="px-3 py-2">
                                    @if($umkm->status_potensi == 'tinggi')
                                        <span class="bg-[#E6F4F3] text-[#2F9E97] px-2 py-1 rounded-full text-xs">tinggi</span>
                                    @elseif($umkm->status_potensi == 'sedang')
                                        <span class="bg-[#FFF3D6] text-[#F5A623] px-2 py-1 rounded-full text-xs">sedang</span>
                                    @else
                                        <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs">rendah</span>
                                    @endif
                                </td>

                                <td class="px-3 py-2">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('umkm.edit', $umkm->id) }}"
                                        class="bg-[#F5A623] hover:bg-[#F39C12] text-white px-2 py-1 rounded text-xs">
                                            Edit
                                        </a>

                                        <form action="{{ route('umkm.destroy', $umkm->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-[#F5A623] hover:bg-[#F39C12] text-white px-2 py-1 rounded text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-8 flex flex-wrap justify-center items-center gap-4">
                    <a href="{{ route('umkm.create') }}"
                       class="bg-[#F5A623] text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition">
                        Tambah UMKM
                    </a>

                    <form action="{{ route('umkm.import') }}" method="POST" enctype="multipart/form-data"
                          class="flex flex-wrap justify-center items-center gap-3">
                        @csrf

                        <input type="file" name="file"
                               class="bg-white border border-primary-300 rounded-lg px-3 py-2 text-gray-700"
                               required>

                    <button type="submit"
                            class="bg-[#35A69F] hover:bg-[#2F9E97] text-white px-6 py-3 rounded-xl font-semibold shadow-md hover:shadow-lg transition">
                        Import Excel
                    </button>
                    </form>

                    <a href="{{ route('umkm.export') }}"
                    class="bg-[#F5A623] hover:bg-[#F39C12] text-white px-6 py-3 rounded-xl font-semibold shadow-md hover:shadow-lg transition">
                        Export Data
                    </a>
                </div>

            </div>
        </main>

    </div>
</div>

</body>
</html>
