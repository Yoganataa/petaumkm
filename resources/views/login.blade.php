<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WebGIS UMKM Sutojayan</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(to right, #2F9E97, #35A69F);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center relative">

    <!-- BUTTON BACK -->
    <div class="absolute top-5 left-5">
        <a href="{{ url('/') }}"
           class="bg-white px-4 py-2 rounded-lg text-[#35A69F] font-semibold shadow hover:bg-gray-100 transition">
            ← Beranda
        </a>
    </div>

    <!-- TITLE -->
    <h1 class="text-white text-xl md:text-2xl font-bold mb-8 text-center px-4">
        Sistem Informasi Pemetaan UMKM Potensial Kecamatan Sutojayan
    </h1>

    <!-- CARD -->
    <div class="bg-white/95 backdrop-blur-md w-full max-w-xl rounded-2xl shadow-xl p-10 border border-[#E6F4F3]">

        @if(session('success'))
            <div id="alert-success" class="mb-4 bg-[#E6F4F3] text-[#2F9E97] p-3 rounded text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div id="alert-error" class="mb-4 bg-[#FFF3D6] text-[#F39C12] p-3 rounded text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}" class="space-y-6">
            @csrf

            <!-- EMAIL -->
            <div>
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="Email"
                    class="w-full text-center px-4 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#35A69F] focus:outline-none text-lg @error('email') border-[#F5A623] @enderror">

                @error('email')
                    <p class="text-[#F5A623] text-sm mt-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div>
                <input type="password" name="password"
                    placeholder="Password"
                    class="w-full text-center px-4 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#35A69F] focus:outline-none text-lg @error('password') border-[#F5A623] @enderror">

                @error('password')
                    <p class="text-[#F5A623] text-sm mt-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <!-- ACTION -->
            <div class="flex justify-center items-center gap-6 pt-2 flex-wrap">
                <span class="text-gray-600 font-medium">
                    Login Admin Kecamatan Sutojayan
                </span>

                <button type="submit"
                    class="bg-[#F5A623] hover:bg-[#F39C12] text-white px-6 py-3 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                    Login
                </button>
            </div>
        </form>
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('alert-success')?.remove();
            document.getElementById('alert-error')?.remove();
        }, 3000);
    </script>

</body>
</html>
