<header id="navbar" class="fixed top-0 left-0 w-full z-10 bg-transparent bg-softyellow transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

        <!-- Logo + Company Name -->
        <div class="flex items-center space-x-2">
            <img src="{{ $company->logo }}" alt="Logo" class="h-10" />
            <span class="text-xl font-bold text-white text-change">{{ $company->name }}</span>
        </div>

        <!-- Hamburger Icon (Mobile only) -->
        <button id="menu-btn" class="md:hidden text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex space-x-6">
            <a href="#" class="text-white hover:text-yellow-300 text-change">Beranda</a>
            <a href="#" class="text-white hover:text-yellow-300 text-change">Yayasan</a>
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
                                @if ($unit->navbars->count())
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 5l7 7-7 7" />
                                    </svg>
                                @endif
                            </a>

                            <!-- Submenu -->
                            @if ($unit->navbars->count())
                                <div x-show="subOpen" x-cloak
                                    class="absolute left-full top-0 ml-1 w-48 bg-white text-gray-800 rounded shadow-lg z-40">
                                    @foreach ($unit->navbars as $nav)
                                        <a href="{{ url('artikel/' . $nav->cta_link) }}"
                                            class="block px-4 py-2 hover:bg-yellow-100 whitespace-nowrap">
                                            {{ strtoupper($nav->cta_text) }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <a href="#" class="text-white hover:text-yellow-300 text-change">Galeri</a>
            <a href="{{ route('penerimaan') }}" class="text-white hover:text-yellow-300 text-change">PPDB</a>
        </nav>
    </div>

    <!-- Mobile Menu -->
    <nav id="mobile-menu" class="md:hidden hidden px-4 pb-4 space-y-2 bg-transparent">
        <a href="#" class="block text-white hover:text-yellow-300 text-change">Beranda</a>
        <a href="#" class="block text-white hover:text-yellow-300 text-change">Yayasan</a>

        <!-- Unit Pendidikan -->
        <div x-data="{ open: false }" class="text-white">
            <button @click="open = !open" class="w-full text-left text-white hover:text-yellow-300">
                Unit Pendidikan
            </button>

            <div x-show="open" x-cloak class="pl-4 mt-2 space-y-2">
                @foreach ($units as $index => $unit)
                    <div x-data="{ subOpen: false }" class="space-y-1">
                        <button @click="subOpen = !subOpen"
                            class="w-full text-left text-white hover:text-yellow-300 flex justify-between items-center">
                            {{ $unit->nama }}
                            @if ($unit->navbars->count())
                                <svg :class="{ 'rotate-90': subOpen }" class="w-4 h-4 transform transition-transform"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 5l7 7-7 7" />
                                </svg>
                            @endif
                        </button>
                        @if ($unit->navbars->count())
                            <div x-show="subOpen" x-cloak class="pl-4 space-y-1">
                                @foreach ($unit->navbars as $nav)
                                    <a href="{{ url('artikel/' . $nav->cta_link) }}" class="block text-white hover:text-yellow-300">
                                        {{ strtoupper($nav->cta_text) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <a href="#" class="block text-white hover:text-yellow-300 text-change">Galeri</a>
        <a href="{{ route('penerimaan') }}" class="text-white hover:text-yellow-300 text-change">PPDB</a>
    </nav>

</header>
