<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-teal-600 p-8">

<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg border border-teal-100">

    <!-- Judul -->
    <h2 class="text-2xl font-bold text-teal-700 mb-6">
        Tambah Data UMKM
    </h2>

    <form action="{{ route('umkm.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Nama Usaha</label>
            <input type="text" name="nama_usaha"
                class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-teal-400 focus:outline-none"
                required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Pemilik</label>
            <input type="text" name="pemilik"
                class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-teal-400 focus:outline-none"
                required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Bidang Usaha</label>
            <select name="bidang_usaha"
                class="w-full border border-gray-300 p-2 rounded-lg text-black focus:ring-2 focus:ring-teal-400 focus:outline-none"
                required>
                <option value="">-- Pilih Bidang Usaha --</option>
                        <option value="Kuliner" class="text-black">Kuliner</option>
                        <option value="Perdagangan" class="text-black">Perdagangan</option>
                        <option value="Industri/Produksi" class="text-black">Industri/Produksi</option>
                        <option value="Jasa" class="text-black">Jasa</option>
                        <option value="Kecantikan" class="text-black">Kecantikan</option>
                        <option value="Lainnya" class="text-black">Lainnya</option>
                    </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Desa / Kelurahan</label>
            <select name="desa"
                class="w-full border border-gray-300 p-2 rounded-lg text-black focus:ring-2 focus:ring-teal-400 focus:outline-none"
                required>
                <option value="">-- Pilih Wilayah --</option>
                <option value="Sutojayan">Sutojayan</option>
                <option value="Kalipang">Kalipang</option>
                <option value="Kedungbunder">Kedungbunder</option>
                <option value="Kembangarum">Kembangarum</option>
                <option value="Jegu">Jegu</option>
                <option value="Sukorejo">Sukorejo</option>
                <option value="Jingglong">Jingglong</option>
                <option value="Kaulon">Kaulon</option>
                <option value="Sumberjo">Sumberjo</option>
                <option value="Bacem">Bacem</option>
                <option value="Pandanarum">Pandanarum</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Alamat</label>
            <textarea name="alamat"
                class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-teal-400 focus:outline-none"
                rows="3"></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Status Potensi</label>
            <select name="status_potensi"
                class="w-full border border-gray-300 p-2 rounded-lg text-black focus:ring-2 focus:ring-teal-400 focus:outline-none"
                required>
                <option value="tinggi">Tinggi</option>
                <option value="sedang">Sedang</option>
                <option value="rendah">Rendah</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700">Latitude</label>
                <input type="text" name="latitude"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-teal-400 focus:outline-none"
                    placeholder="-8.1724563">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700">Longitude</label>
                <input type="text" name="longitude"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-teal-400 focus:outline-none"
                    placeholder="112.2122597">
            </div>
        </div>

        <div class="mb-6 text-sm text-gray-600">
            Isi latitude dan longitude agar titik UMKM bisa tampil di peta.
        </div>

        <!-- BUTTON -->
        <div class="flex gap-3">
            <button type="submit"
                class="bg-orange-500 text-white px-5 py-2 rounded-lg font-semibold hover:bg-orange-600 transition">
                Simpan
            </button>

            <a href="{{ route('admin.data.umkm') }}"
               class="bg-teal-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-teal-700 transition">
               Batal
            </a>
        </div>

    </form>
</div>

</body>
</html>
