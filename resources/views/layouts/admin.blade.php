<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin IPH')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('styles')
</head>
<body class="bg-white text-gray-800 font-sans">

    {{-- Layout Wrapper --}}
    <div class="flex min-h-screen">

        <!-- SIDEBAR FIXED -->
        <aside class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-blue-900 via-blue-800 to-blue-950 text-white flex flex-col py-8 px-5 shadow-2xl z-50 overflow-hidden border-r border-blue-800">
            <!-- Background Image Layer -->
            <div class="absolute inset-0 z-0 pointer-events-none">
                <img src="{{ asset('images/bg-bps.jpg') }}" alt="Background BPS" class="w-full h-full object-cover opacity-20">
                <div class="absolute inset-0 bg-blue-950/80"></div>
            </div>

            <!-- Branding -->
            <div class="mb-8 text-center relative z-10">
                <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" class="mx-auto mb-3 w-20 h-20 object-contain drop-shadow-lg">
                <h1 class="text-2xl font-extrabold tracking-wide text-white drop-shadow">IPH Admin</h1>
                <p class="text-xs text-blue-200 mt-1">BPS Tasikmalaya</p>
            </div>

            <!-- Navigation Section -->
            <nav class="space-y-1 text-[15px] font-medium relative z-10">
                @php
                    $navItems = [
                        ['url' => '/admin/dashboard', 'label' => 'Dashboard', 'icon' => '🏠'],
                        ['url' => '/admin/iph/mingguan', 'label' => 'Input Mingguan', 'icon' => '🗓️'],
                        ['url' => '/admin/iph/view-mingguan', 'label' => 'View Mingguan', 'icon' => '📄'],
                        ['url' => '/admin/iph/bulanan', 'label' => 'Input Bulanan', 'icon' => '📅'],
                        ['url' => '/admin/iph/view-bulanan', 'label' => 'View Bulanan', 'icon' => '📄'],
                    ];
                    $settingItem = ['url' => '/admin/setting', 'label' => 'Pengaturan Tampilan', 'icon' => '⚙️'];
                @endphp

                <div class="mb-2">
                    <span class="uppercase text-xs text-blue-300 font-semibold pl-2">Menu Utama</span>
                </div>
                @foreach ($navItems as $item)
                    <a href="{{ $item['url'] }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-blue-800 {{ request()->is(ltrim($item['url'], '/')) ? 'bg-blue-800 font-bold shadow' : '' }}">
                        <span class="text-lg">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach

                <div class="mt-4 mb-2">
                    <span class="uppercase text-xs text-blue-300 font-semibold pl-2">Pengaturan</span>
                </div>
                <a href="{{ $settingItem['url'] }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-blue-800 {{ request()->is(ltrim($settingItem['url'], '/')) ? 'bg-blue-800 font-bold shadow' : '' }}">
                    <span class="text-lg">{{ $settingItem['icon'] }}</span>
                    <span>{{ $settingItem['label'] }}</span>
                </a>
            </nav>

            <!-- Logout Section -->
            <div class="mt-auto pt-8 border-t border-white/20 relative z-10">
                <form method="POST" action="/logout">
                    @csrf
                    <button class="w-full flex items-center gap-3 text-left px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-800 transition duration-200 font-semibold">
                        <span class="text-lg">🔒</span> <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="ml-64 flex-1 bg-white p-8 overflow-y-auto">
            @yield('content')
        </main>

    </div>

    @stack('script')

</body>
</html>
