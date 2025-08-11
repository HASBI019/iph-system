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
        <aside class="fixed top-0 left-0 h-screen w-64 bg-blue-900 text-white flex flex-col py-6 px-4 shadow-xl z-50 overflow-hidden">

            <!-- Background Image Layer -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/bg-bps.jpg') }}" alt="Background BPS" class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-blue-900/80"></div>
            </div>

            <!-- Branding -->
            <div class="mb-6 text-center relative z-10">
                <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" class="mx-auto mb-2 w-16 h-16 object-contain drop-shadow-md">
                <h1 class="text-2xl font-bold tracking-wide">IPH Admin</h1>
                <p class="text-sm text-blue-200">BPS Tasikmalaya</p>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2 text-[15px] font-medium relative z-10">
                @php
                    $navItems = [
                        ['url' => '/admin/dashboard', 'label' => '🏠 Dashboard'],
                        ['url' => '/admin/iph/mingguan', 'label' => '📥 Input Mingguan'],
                        ['url' => '/admin/iph/view-mingguan', 'label' => '📄 View Mingguan'],
                        ['url' => '/admin/iph/bulanan', 'label' => '📥 Input Bulanan'],
                        ['url' => '/admin/iph/view-bulanan', 'label' => '📄 View Bulanan'],
                        ['url' => '/admin/setting', 'label' => '⚙️ Pengaturan Tampilan'],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <a href="{{ $item['url'] }}"
                       class="block px-4 py-2 rounded transition-all duration-200 hover:bg-blue-800 {{ request()->is(ltrim($item['url'], '/')) ? 'bg-blue-800' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <!-- Logout -->
            <div class="mt-auto pt-6 border-t border-white/20 relative z-10">
                <form method="POST" action="/logout">
                    @csrf
                    <button class="w-full text-left px-4 py-2 rounded bg-blue-600 hover:bg-blue-800 transition duration-200">
                        🔒 Logout
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
