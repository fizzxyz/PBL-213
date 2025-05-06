<header id="navbar" class="fixed top-0 left-0 w-full z-10 bg-softyellow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

        <!-- Logo + Company Name -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="h-10" />
            <span class="text-xl font-bold text-black">{{ $company->name }}</span>
        </div>

        <!-- Profile (Desktop) -->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ route('show.profile') }}" class="flex items-center hover:text-blue-600 transition-colors duration-200">
                <i class="fas fa-user"></i>
                <span class="text-gray-800 mx-1">Hi,</span>
                <span class="text-gray-800">{{ auth()->user()->name }}</span>
            </a>
        </nav>
    </div>
</header>


