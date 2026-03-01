<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password | UPZ Semen Padang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg {
            background: linear-gradient(135deg, #022c22 0%, #065f46 100%);
        }
        .btn-gold {
            background: #facc15;
            color: #064e3b;
            font-weight: 600;
            transition: all .3s ease;
            box-shadow: 0 10px 25px rgba(250,204,21,.4);
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            background: #eab308;
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center px-6">

    <div class="bg-white w-full max-w-md p-10 rounded-3xl shadow-2xl">

        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-upz.png') }}" class="w-14 mx-auto mb-4">
            <h1 class="text-2xl font-extrabold text-emerald-900">
                Lupa Password?
            </h1>
            <p class="text-gray-500 text-sm mt-2">
                Masukkan email Anda untuk menerima instruksi reset password.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 text-green-600 text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="#">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-emerald-800 mb-2">
                    Email
                </label>
                <input type="email"
                       name="email"
                       required
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-xl btn-gold">
                Kirim Link Reset
            </button>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}"
                   class="text-sm text-emerald-800 hover:text-yellow-500 font-medium transition">
                    ← Kembali ke Login
                </a>
            </div>

        </form>

    </div>

</body>
</html>
