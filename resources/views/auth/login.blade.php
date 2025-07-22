<!DOCTYPE html>
<html lang="id" x-data="themeController()" x-init="initTheme()">
<head>
    <meta charset="UTF-8">
    <title>Login Admin IPH</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1'
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Script Tema -->
    <script>
        function themeController() {
            return {
                activeTheme: 'theme-indigo',
                initTheme() {
                    const savedTheme = localStorage.getItem('themeColor') || 'theme-indigo';
                    this.activeTheme = savedTheme;
                    document.body.classList.add(this.activeTheme);
                },
                setColor(themeClass) {
                    document.body.classList.remove(this.activeTheme);
                    document.body.classList.add(themeClass);
                    this.activeTheme = themeClass;
                    localStorage.setItem('themeColor', themeClass);
                }
            }
        }
    </script>

    <!-- Gradien Background -->
    <style>
        .theme-indigo { background-image: linear-gradient(to right, #6366f1, #8b5cf6); }
        .theme-blue { background-image: linear-gradient(to right, #3b82f6, #2563eb); }
        .theme-rose { background-image: linear-gradient(to right, #f43f5e, #e11d48); }
        .theme-emerald { background-image: linear-gradient(to right, #10b981, #059669); }

        .theme-indigo .bg-primary { background-color: #6366f1; }
        .theme-blue .bg-primary { background-color: #3b82f6; }
        .theme-rose .bg-primary { background-color: #f43f5e; }
        .theme-emerald .bg-primary { background-color: #10b981; }

        body {
            background-size: cover;
            background-repeat: no-repeat;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center text-gray-800 animate-fade-in">

<div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8 space-y-6">

    <!-- Header -->
    <div class="text-center">
        <h1 class="text-2xl font-bold text-primary">Login Admin IPH</h1>
        <p class="text-sm text-gray-600">Kelola data IPH mingguan & bulanan</p>
    </div>

    <!-- Pilihan Tema -->
    <div class="text-sm">
        <label class="block mb-1">🌈 Pilih tema warna:</label>
        <select @change="setColor($event.target.value)" class="w-full p-2 border rounded">
            <option value="theme-indigo">Indigo</option>
            <option value="theme-blue">Blue</option>
            <option value="theme-rose">Rose</option>
            <option value="theme-emerald">Emerald</option>
        </select>
    </div>

    <!-- Flash Error -->
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded animate-fade-in">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Login -->
    <form method="POST" action="/login" onsubmit="return validateLogin()" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" name="email" id="email" required class="w-full mt-1 p-2 border rounded focus:ring-primary focus:border-primary">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium">Password</label>
            <input type="password" name="password" id="password" required class="w-full mt-1 p-2 border rounded focus:ring-primary focus:border-primary">
        </div>

        <div id="errorMsg" class="text-sm text-red-500 hidden">⚠️ Semua field wajib diisi!</div>
        <div id="loadingBox" class="hidden text-center text-sm text-gray-600 mt-2">
            🔄 Login sedang diproses...
        </div>

        <button type="submit" onclick="showLoader()" class="w-full bg-primary text-white py-2 rounded hover:brightness-90 transition">
            🔐 Login Sekarang
        </button>
    </form>

    <p class="text-xs text-center text-gray-500 mt-4">
        &copy; {{ date('Y') }} IPH System – BPS Tasikmalaya
    </p>
</div>

<!-- JS Validasi -->
<script>
    function validateLogin() {
        const email = document.getElementById('email').value.trim();
        const pass = document.getElementById('password').value.trim();
        if (!email || !pass) {
            document.getElementById('errorMsg').classList.remove('hidden');
            return false;
        }
        return true;
    }

    function showLoader() {
        document.getElementById('loadingBox').classList.remove('hidden');
    }
</script>

</body>
</html>
