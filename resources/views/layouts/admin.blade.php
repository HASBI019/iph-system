<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin IPH')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="min-h-screen flex">

    <!-- SIDEBAR FULL MENU -->
    <aside class="w-64 bg-blue-800 text-white flex flex-col py-6 px-4 shadow-lg">

        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold">IPH Admin</h1>
            <p class="text-sm">BPS Tasikmalaya</p>
        </div>

        <nav class="space-y-3 text-lg font-semibold">
            <a href="/admin/dashboard"
               class="block px-3 py-2 rounded hover:bg-blue-700 {{ request()->is('admin/dashboard') ? 'bg-blue-700' : '' }}">
               🏠 Dashboard
            </a>
            <a href="/admin/iph/mingguan"
               class="block px-3 py-2 rounded hover:bg-blue-700 {{ request()->is('admin/iph/mingguan') ? 'bg-blue-700' : '' }}">
               📥 Input Mingguan
            </a>
            <a href="/admin/iph/view-mingguan"
               class="block px-3 py-2 rounded hover:bg-blue-700 {{ request()->is('admin/iph/view-mingguan') ? 'bg-blue-700' : '' }}">
               📄 View Mingguan
            </a>
            <a href="/admin/iph/bulanan"
               class="block px-3 py-2 rounded hover:bg-blue-700 {{ request()->is('admin/iph/bulanan') ? 'bg-blue-700' : '' }}">
               📥 Input Bulanan
            </a>
            <a href="/admin/iph/view-bulanan"
               class="block px-3 py-2 rounded hover:bg-blue-700 {{ request()->is('admin/iph/view-bulanan') ? 'bg-blue-700' : '' }}">
               📄 View Bulanan
            </a>
            <a href="/admin/setting"
               class="block px-3 py-2 rounded hover:bg-blue-700 {{ request()->is('admin/setting') ? 'bg-blue-700' : '' }}">
               ⚙️ Pengaturan Tampilan
            </a>
        </nav>

        <div class="mt-auto pt-6 border-t border-white/30">
            <form method="POST" action="/logout">
                @csrf
                <button class="w-full text-left px-3 py-2 rounded bg-red-600 hover:bg-red-700">
                    🔒 Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-6 overflow-y-auto">
        @yield('content')
    </main>

</div>
</body>
</html>
