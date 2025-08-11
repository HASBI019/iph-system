<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin IPH')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    @yield('styles')
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- Wrapper Layout --}}
    <div class="flex min-h-screen">

        <!-- SIDEBAR FIXED -->
        <aside class="fixed top-0 left-0 h-screen w-64 bg-blue-900 text-white flex flex-col py-6 px-4 shadow-lg z-50">

            <!-- Branding -->
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold tracking-wide">IPH Admin</h1>
                <p class="text-sm text-blue-200">BPS Tasikmalaya</p>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-2 text-[15px] font-medium">
                <a href="/admin/dashboard"
                   class="block px-4 py-2 rounded hover:bg-blue-800 transition {{ request()->is('admin/dashboard') ? 'bg-blue-800' : '' }}">
                   🏠 Dashboard
                </a>
                <a href="/admin/iph/mingguan"
                   class="block px-4 py-2 rounded hover:bg-blue-800 transition {{ request()->is('admin/iph/mingguan') ? 'bg-blue-800' : '' }}">
                   📥 Input Mingguan
                </a>
                <a href="/admin/iph/view-mingguan"
                   class="block px-4 py-2 rounded hover:bg-blue-800 transition {{ request()->is('admin/iph/view-mingguan') ? 'bg-blue-800' : '' }}">
                   📄 View Mingguan
                </a>
                <a href="/admin/iph/bulanan"
                   class="block px-4 py-2 rounded hover:bg-blue-800 transition {{ request()->is('admin/iph/bulanan') ? 'bg-blue-800' : '' }}">
                   📥 Input Bulanan
                </a>
                <a href="/admin/iph/view-bulanan"
                   class="block px-4 py-2 rounded hover:bg-blue-800 transition {{ request()->is('admin/iph/view-bulanan') ? 'bg-blue-800' : '' }}">
                   📄 View Bulanan
                </a>
                <a href="/admin/setting"
                   class="block px-4 py-2 rounded hover:bg-blue-800 transition {{ request()->is('admin/setting') ? 'bg-blue-800' : '' }}">
                   ⚙️ Pengaturan Tampilan
                </a>
            </nav>

            <!-- Logout -->
            <div class="mt-auto pt-6 border-t border-white/20">
                <form method="POST" action="/logout">
                    @csrf
                    <button class="w-full text-left px-4 py-2 rounded bg-red-600 hover:bg-red-700 transition">
                        🔒 Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="ml-64 flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>

    @stack('script')

</body>
</html>
