@extends('layouts.daftar')
<body style="background: url('{{ asset('storage/' . $homeContent->hero_image) }}') center center / cover no-repeat;" class="min-h-screen flex items-center justify-center p-2 sm:p-5 relative overflow-hidden">
    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-opacity-40 backdrop-blur-sm z-0"></div>

    <!-- Floating Background Elements -->
    <div class="absolute -top-1/2 -right-1/4 w-96 h-96 bg-gradient-radial from-yellow-300 to-transparent opacity-20 rounded-full pulse-bg hidden md:block"></div>
    <div class="absolute -bottom-1/3 -left-1/4 w-80 h-80 bg-gradient-radial from-orange-300 to-transparent opacity-10 rounded-full floating-circle hidden md:block"></div>

    <!-- Main Container - Responsive -->
    <div class="glass-card rounded-2xl mt-2 sm:mt-7 shadow-2xl overflow-hidden w-full max-w-sm sm:max-w-2xl lg:max-w-7xl min-h-[480px] sm:min-h-[480px] flex flex-col lg:flex-row relative z-10 mx-2 sm:mx-0">

        <!-- Welcome Section -->
        <div class="flex-1 welcome-bg p-6 sm:p-8 lg:p-12 flex flex-col justify-center text-white relative overflow-hidden border-b lg:border-b-0 lg:border-r border-white border-opacity-20">
            <!-- Floating Circle - Hidden on mobile -->
            <div class="absolute -top-8 -right-8 w-48 h-48 bg-white bg-opacity-20 rounded-full floating-circle hidden lg:block"></div>

            <!-- Logo -->
            <div class="flex items-center mb-4 sm:mb-6 text-lg sm:text-xl font-bold relative z-10">
                <div class="bg-white bg-opacity-20 p-2 rounded-lg mr-3">
                    <img src="{{ asset('storage/' . $yayasan->logo) }}" alt="Logo" class="h-8 w-8 sm:h-10 sm:w-10 rounded-full">
                </div>
                <span class="truncate">{{ $yayasan->name }}</span>
            </div>

            <!-- Welcome Text -->
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2 drop-shadow-lg">Salam!</h1>
                <h2 class="text-lg sm:text-xl font-normal mb-3 sm:mb-4 opacity-90">Daftarkan Akun Sekarang</h2>
                <p class="text-xs sm:text-sm leading-relaxed opacity-80 mb-4 sm:mb-6">
                    Register akun terlebih dahulu sebelum mengakses halaman ini.
                </p>

                <!-- Social Links -->
                <div class="flex gap-2 sm:gap-3">
                    <a href="#" class="text-white text-sm sm:text-lg p-2 bg-white bg-opacity-10 rounded-full hover:bg-opacity-20 transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-white text-sm sm:text-lg p-2 bg-white bg-opacity-10 rounded-full hover:bg-opacity-20 transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-white text-sm sm:text-lg p-2 bg-white bg-opacity-10 rounded-full hover:bg-opacity-20 transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-white text-sm sm:text-lg p-2 bg-white bg-opacity-10 rounded-full hover:bg-opacity-20 transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Register Section -->
        <div class="flex-1 glass p-6 sm:p-8 lg:p-10 flex flex-col justify-center border-t lg:border-t-0 lg:border-l border-white border-opacity-20">
            <!-- Header -->
            <div class="text-center mb-4 sm:mb-6">
                <h3 class="text-xl sm:text-2xl font-semibold text-white drop-shadow-lg mb-2">Buat Akun</h3>
            </div>

            <!-- Form - Responsive Grid -->
            <form id="registerForm" action="{{ route('register') }}" method="POST" class="space-y-3 sm:space-y-4">
                @csrf

                <!-- Row 1: Name and Email - Stack on mobile -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <!-- Nama Lengkap -->
                    <div class="relative group">
                        <label for="name" class="block mb-1 text-xs font-medium text-white drop-shadow">Nama Lengkap</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-80 text-sm"></i>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   placeholder="Nama lengkap"
                                   required
                                   value="{{ old('name') }}"
                                   class="glass-input w-full pl-8 pr-3 py-2.5 sm:py-3 rounded-lg text-white text-sm placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-opacity-30 transition-all duration-300">
                        </div>
                        @error('name')
                            <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="relative group">
                        <label for="email" class="block mb-1 text-xs font-medium text-white drop-shadow">Email</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-80 text-sm"></i>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   placeholder="Email"
                                   required
                                   value="{{ old('email') }}"
                                   class="glass-input w-full pl-8 pr-3 py-2.5 sm:py-3 rounded-lg text-white text-sm placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-opacity-30 transition-all duration-300">
                        </div>
                        @error('email')
                            <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Row 2: Phone -->
                <div class="relative group">
                    <label for="phone" class="block mb-1 text-xs font-medium text-white drop-shadow">Nomor HP</label>
                    <div class="relative">
                        <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-80 text-sm"></i>
                        <input type="tel"
                               id="phone"
                               name="phone"
                               placeholder="Nomor HP"
                               required
                               value="{{ old('phone') }}"
                               class="glass-input w-full pl-8 pr-3 py-2.5 sm:py-3 rounded-lg text-white text-sm placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-opacity-30 transition-all duration-300">
                    </div>
                    @error('phone')
                        <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Row 3: Passwords - Stack on mobile -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <!-- Password -->
                    <div class="relative group">
                        <label for="password" class="block mb-1 text-xs font-medium text-white drop-shadow">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-80 text-sm"></i>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   placeholder="Password"
                                   required
                                   class="glass-input w-full pl-8 pr-3 py-2.5 sm:py-3 rounded-lg text-white text-sm placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-opacity-30 transition-all duration-300">
                        </div>
                        @error('password')
                            <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="relative group">
                        <label for="password_confirmation" class="block mb-1 text-xs font-medium text-white drop-shadow">Konfirmasi Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-80 text-sm"></i>
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Konfirmasi password"
                                   required
                                   class="glass-input w-full pl-8 pr-3 py-2.5 sm:py-3 rounded-lg text-white text-sm placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-opacity-30 transition-all duration-300">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="glass-button w-full py-2.5 sm:py-3 px-4 rounded-lg text-white text-sm sm:text-base font-semibold cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-3 focus:ring-orange-400 focus:ring-opacity-30 mt-4">
                    <i class="fas fa-user-plus mr-2"></i>
                    Buat Akun
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-3 sm:mt-4">
                <p class="text-white drop-shadow text-xs sm:text-sm">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-yellow-200 font-semibold hover:text-yellow-100 hover:underline transition-colors duration-300">
                        Login
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>