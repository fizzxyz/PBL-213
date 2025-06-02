<!-- Navbar with Responsive Dropdown -->
<header id="navbar" class="fixed top-0 left-0 w-full z-10 bg-softyellow shadow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Logo + Yayasan Name -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('home.index') }}" class="flex items-center space-x-2">
            <img src="{{ asset('storage/' . $yayasan->logo) }}" alt="Logo" class="h-10" />
            <span class="text-xl font-bold text-black">{{ $yayasan->name }}</span>
            </a>
        </div>

        <!-- Hamburger Icon (Mobile) -->
        <div class="md:hidden" x-data="{ open: false }">
            <button @click="open = !open" class="text-gray-800 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Mobile Dropdown -->
            <div x-show="open" x-cloak class="absolute top-full right-0 mt-2 w-56 bg-white rounded-md shadow-md py-2 z-50">
                <div class="px-4 py-2 text-sm text-gray-700 font-medium">
                    Hi, {{ auth()->user()->name }}
                </div>
                <a href="{{ route('show.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Lihat Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Profile Dropdown (Desktop) -->
        <div class="hidden md:block relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-2 text-gray-800 hover:text-blue-600">
                <i class="fas fa-user"></i>
                <span>Hi, {{ auth()->user()->name }}</span>
                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-md py-2 z-50">
                <a href="{{ route('show.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Lihat Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
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