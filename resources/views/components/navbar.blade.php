<header id="navbar" class="fixed top-0 left-0 w-full z-10 bg-transparent bg-softyellow transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

        <!-- Logo + yayasan Name -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('storage/' . $yayasan->logo) }}" alt="Logo" class="h-10" />
            <span class="text-xl font-bold text-white text-change">{{ $yayasan->name }}</span>
        </div>

        <!-- Hamburger Icon (Mobile only) -->
        <button id="menu-btn" class="md:hidden text-white text-change focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ route('home.index') }}" class="text-white hover:text-yellow-300 text-change">Beranda</a>
            <a href="{{ route('home.yayasan') }}" class="text-white hover:text-yellow-300 text-change">Yayasan</a>
            <!-- Dropdown Unit Pendidikan -->
            <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative group">

                <!-- Trigger Button -->
                <button class="text-white hover:text-yellow-300 text-change focus:outline-none relative z-10">
                    Unit Pendidikan
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-cloak
                    class="absolute top-full left-0 mt-0 bg-white text-gray-800 rounded shadow-lg transition-all duration-200 z-50 min-w-[200px]">

                    @foreach ($units as $unit)
                        <div x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false"
                            class="relative group">

                            <a href="{{ route('unit.show', $unit->slug) }}"
                                class="flex items-center justify-between px-4 py-2 hover:bg-yellow-100 whitespace-nowrap">
                                {{ $unit->nama }}
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <!-- Submenu -->
                            <div x-show="subOpen" x-cloak
                                class="absolute left-full top-0 ml-1 w-48 bg-white text-gray-800 rounded shadow-lg z-40">

                                <!-- Tentang Option (Default) -->
                                <a href="{{ route('unit.tentang', $unit->slug) }}"
                                    class="block px-4 py-2 hover:bg-yellow-100 whitespace-nowrap border-b border-gray-200">
                                    TENTANG
                                </a>

                                <!-- Custom Navbar Options -->
                                @foreach ($unit->navbars as $nav)
                                    <a href="{{ url('artikel/' . $nav->cta_link) }}"
                                        class="block px-4 py-2 hover:bg-yellow-100 whitespace-nowrap">
                                        {{ strtoupper($nav->cta_text) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <a href="#" class="text-white hover:text-yellow-300 text-change">Galeri</a>
            <a href="{{ auth()->check() ? route('penerimaan') : route('register') }}" class="text-white hover:text-yellow-300 text-change">PPDB</a>
        </nav>
    </div>

    <!-- Mobile Menu -->
    <nav id="mobile-menu" class="md:hidden hidden px-4 pb-4 space-y-2 bg-transparent">
        <a href="{{ route('home.index') }}" class="block text-white hover:text-yellow-300 text-change">Beranda</a>
        <a href="{{ route('home.yayasan') }}" class="block text-white hover:text-yellow-300 text-change">Yayasan</a>

        <!-- Unit Pendidikan -->
        <div x-data="{ open: false }" class="text-white text-change">
            <button @click="open = !open" class="w-full text-left text-white text-change hover:text-yellow-300">
                Unit Pendidikan
            </button>

            <div x-show="open" x-cloak class="pl-4 mt-2 space-y-2">
                @foreach ($units as $index => $unit)
                    <div x-data="{ subOpen: false }" class="space-y-1">
                        <button @click="subOpen = !subOpen"
                            class="w-full text-left text-white text-change hover:text-yellow-300 flex justify-between items-center">
                            {{ $unit->nama }}
                            <svg :class="{ 'rotate-90': subOpen }" class="w-4 h-4 transform transition-transform"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div x-show="subOpen" x-cloak class="pl-4 space-y-1">
                            <!-- Tentang Option (Default) -->
                            <a href="{{ route('unit.tentang', $unit->slug) }}"
                                class="block text-white text-change hover:text-yellow-300 border-b border-gray-400 pb-1">
                                TENTANG
                            </a>

                            <!-- Custom Navbar Options -->
                            @foreach ($unit->navbars as $nav)
                                <a href="{{ url('artikel/' . $nav->cta_link) }}"
                                    class="block text-white text-change hover:text-yellow-300">
                                    {{ strtoupper($nav->cta_text) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <a href="#" class="block text-white hover:text-yellow-300 text-change">Galeri</a>
        <a href="{{ route('penerimaan') }}" class="text-white hover:text-yellow-300 text-change">PPDB</a>
    </nav>

</header>

@if(request()->has('verified') && request()->verified == 1)
    <div id="verif-alert" class="fixed top-[70px] left-1/2 transform -translate-x-1/2 z-50 bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-md shadow-md flex items-center space-x-3 animate-slide-down">
        <svg class="animate-spin h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <span>Email anda sudah terverifikasi</span>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('verif-alert');
            if(alert) alert.remove();
        }, 5000);
    </script>

    <style>
        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translate(-50%, -10px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        .animate-slide-down {
            animation: slide-down 0.3s ease-out;
        }
    </style>
@endif