<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-teal-700 via-teal-500 to-teal-300 p-8">

    <div class="max-w-2xl mx-auto bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-xl border border-teal-100">

        <h2 class="text-2xl font-bold text-teal-700 mb-6">
            Edit Data UMKM
        </h2>

        <form action="{{ route('umkm.update', $umkm->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 text-gray-700 font-medium">Nama Usaha</label>
                <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $umkm->nama_usaha) }}"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-gray-700 font-medium">Pemilik</label>
                <input type="text" name="pemilik" value="{{ old('pemilik', $umkm->pemilik) }}"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Bidang Usaha</label>
                <select name="bidang_usaha"
                    class="w-full border border-gray-300 p-2 rounded-lg text-black focus:ring-2 focus:ring-teal-400 focus:outline-none"
                    required>
                    <option value="">-- Pilih Bidang Usaha --</option>
                    <option value="Kuliner" class="text-black" {{ old('bidang_usaha', $umkm->bidang_usaha) == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                    <option value="Perdagangan" class="text-black" {{ old('bidang_usaha', $umkm->bidang_usaha) == 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                    <option value="Industri/Produksi" class="text-black" {{ old('bidang_usaha', $umkm->bidang_usaha) == 'Industri/Produksi' ? 'selected' : '' }}>Industri/Produksi</option>
                    <option value="Jasa" class="text-black" {{ old('bidang_usaha', $umkm->bidang_usaha) == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                    <option value="Kecantikan" class="text-black" {{ old('bidang_usaha', $umkm->bidang_usaha) == 'Kecantikan' ? 'selected' : '' }}>Kecantikan</option>
                    <option value="Lainnya" class="text-black" {{ old('bidang_usaha', $umkm->bidang_usaha) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Desa / Kelurahan</label>
                <select name="desa"
                    class="w-full border border-gray-300 p-2 rounded-lg text-black focus:ring-2 focus:ring-teal-400 focus:outline-none"
                    required>
                    <option value="">-- Pilih Wilayah --</option>
                    <option value="Sutojayan" {{ old('desa', $umkm->desa) == 'Sutojayan' ? 'selected' : '' }}>Sutojayan</option>
                    <option value="Kalipang" {{ old('desa', $umkm->desa) == 'Kalipang' ? 'selected' : '' }}>Kalipang</option>
                    <option value="Kedungbunder" {{ old('desa', $umkm->desa) == 'Kedungbunder' ? 'selected' : '' }}>Kedungbunder</option>
                    <option value="Kembangarum" {{ old('desa', $umkm->desa) == 'Kembangarum' ? 'selected' : '' }}>Kembangarum</option>
                    <option value="Jegu" {{ old('desa', $umkm->desa) == 'Jegu' ? 'selected' : '' }}>Jegu</option>
                    <option value="Sukorejo" {{ old('desa', $umkm->desa) == 'Sukorejo' ? 'selected' : '' }}>Sukorejo</option>
                    <option value="Jingglong" {{ old('desa', $umkm->desa) == 'Jingglong' ? 'selected' : '' }}>Jingglong</option>
                    <option value="Kaulon" {{ old('desa', $umkm->desa) == 'Kaulon' ? 'selected' : '' }}>Kaulon</option>
                    <option value="Sumberjo" {{ old('desa', $umkm->desa) == 'Sumberjo' ? 'selected' : '' }}>Sumberjo</option>
                    <option value="Bacem" {{ old('desa', $umkm->desa) == 'Bacem' ? 'selected' : '' }}>Bacem</option>
                    <option value="Pandanarum" {{ old('desa', $umkm->desa) == 'Pandanarum' ? 'selected' : '' }}>Pandanarum</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Alamat</label>
                <textarea name="alamat"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-teal-400 focus:outline-none"
                    rows="3">{{ old('alamat', $umkm->alamat) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Status Potensi</label>
                <select name="status_potensi"
                    class="w-full border border-gray-300 p-2 rounded-lg text-black focus:ring-2 focus:ring-teal-400 focus:outline-none"
                    required>
                    <option value="tinggi" {{ old('status_potensi', $umkm->status_potensi) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="sedang" {{ old('status_potensi', $umkm->status_potensi) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="rendah" {{ old('status_potensi', $umkm->status_potensi) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Latitude</label>
                    <input type="text" name="latitude" value="{{ old('latitude', $umkm->latitude) }}"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-teal-400 focus:outline-none"
                        placeholder="-8.1724563">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Longitude</label>
                    <input type="text" name="longitude" value="{{ old('longitude', $umkm->longitude) }}"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-teal-400 focus:outline-none"
                        placeholder="112.2122597">
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg font-semibold transition shadow">
                    Simpan
                </button>

                <a href="{{ route('admin.data.umkm') }}"
                    class="bg-white border border-teal-300 text-teal-700 px-5 py-2 rounded-lg font-semibold hover:bg-teal-50 transition">
                    Batal
                </a>
            </div>
        </form>

    </div>

</body>
</html>
