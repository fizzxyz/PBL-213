@extends('layouts.daftar')

<body style="background: url('{{ asset('storage/' . $homeContent->hero_image) }}') center center / cover no-repeat;"
    class="min-h-screen flex items-center justify-center p-2 sm:p-5 relative overflow-hidden">
    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-opacity-40 backdrop-blur-sm z-0"></div>

    <!-- Floating Background Elements -->
    <div
        class="absolute -top-1/2 -right-1/4 w-96 h-96 bg-gradient-radial from-yellow-300 to-transparent opacity-20 rounded-full pulse-bg hidden md:block">
    </div>
    <div
        class="absolute -bottom-1/3 -left-1/4 w-80 h-80 bg-gradient-radial from-orange-300 to-transparent opacity-10 rounded-full floating-circle hidden md:block">
    </div>

    <!-- Main Container - Responsive -->
    <div
        class="glass-card rounded-2xl mt-2 sm:mt-7 shadow-2xl overflow-hidden w-full max-w-sm sm:max-w-2xl lg:max-w-6xl min-h-[480px] sm:min-h-[480px] flex flex-col lg:flex-row relative z-10 mx-2 sm:mx-0">

        <!-- Welcome Section -->
        <div
            class="flex-1 welcome-bg p-6 sm:p-8 lg:p-12 flex flex-col justify-center text-white relative overflow-hidden border-b lg:border-b-0 lg:border-r border-white border-opacity-20">
            <!-- Floating Circle - Hidden on mobile -->
            <div
                class="absolute -top-8 -right-8 w-48 h-48 bg-white bg-opacity-20 rounded-full floating-circle hidden lg:block">
            </div>

            <!-- Welcome Text -->
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2 drop-shadow-lg">Selamat Datang!</h1>
                <h2 class="text-lg sm:text-xl font-normal mb-3 sm:mb-4 opacity-90">Login ke Akun Anda</h2>
                <p class="text-xs sm:text-sm leading-relaxed opacity-80 mb-4 sm:mb-6">
                    Masukkan email dan password untuk mengakses dashboard Anda.
                </p>

                <!-- Social Links -->
                <div class="flex gap-2 sm:gap-3">
                    <a href="#"
                        class="text-white text-sm sm:text-lg p-2 bg-white bg-opacity-10 rounded-full hover:bg-opacity-20 transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#"
                        class="text-white text-sm sm:text-lg p-2 bg-white bg-opacity-10 rounded-full hover:bg-opacity-20 transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#"
                        class="text-white text-sm sm:text-lg p-2 bg-white bg-opacity-10 rounded-full hover:bg-opacity-20 transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#"
                        class="text-white text-sm sm:text-lg p-2 bg-white bg-opacity-10 rounded-full hover:bg-opacity-20 transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Login Section -->
        <div
            class="flex-1 glass p-6 sm:p-8 lg:p-10 flex flex-col justify-center border-t lg:border-t-0 lg:border-l border-white border-opacity-20">
            <!-- Header -->
            <div class="text-center mb-6 sm:mb-8">
                <h3 class="text-xl sm:text-2xl font-semibold text-white drop-shadow-lg mb-2">Masuk Akun</h3>
                <p class="text-white text-opacity-80 text-xs sm:text-sm">Silakan masukkan kredensial Anda</p>
            </div>

            <!-- Form -->
            <form id="loginForm" action="{{ route('login') }}" method="POST" class="space-y-4 sm:space-y-5">
                @csrf

                <!-- Email -->
                <div class="relative group">
                    <label for="email" class="block mb-2 text-sm font-medium text-white drop-shadow">Email</label>
                    <div class="relative">
                        <i
                            class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-80 text-sm"></i>
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required
                            value="{{ old('email') }}"
                            class="glass-input w-full pl-10 pr-4 py-3 sm:py-4 rounded-lg text-white text-sm placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-opacity-30 transition-all duration-300">
                    </div>
                    @error('email')
                        <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="relative group">
                    <label for="password" class="block mb-2 text-sm font-medium text-white drop-shadow">Password</label>
                    <div class="relative">
                        <i
                            class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-80 text-sm"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password Anda"
                            required
                            class="glass-input w-full pl-10 pr-4 py-3 sm:py-4 rounded-lg text-white text-sm placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-opacity-30 transition-all duration-300">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-70 hover:text-opacity-100 transition-colors duration-300">
                            <i id="toggleIcon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-xs sm:text-sm">
                    <label class="flex items-center text-white cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="mr-2 rounded bg-white bg-opacity-20 border-white border-opacity-30 text-orange-400 focus:ring-orange-400 focus:ring-opacity-30">
                        <span class="drop-shadow">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}"
                        class="text-yellow-200 hover:text-yellow-100 hover:underline transition-colors duration-300 drop-shadow">
                        Lupa password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="glass-button w-full py-3 sm:py-4 px-4 rounded-lg text-white text-sm sm:text-base font-semibold cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-3 focus:ring-orange-400 focus:ring-opacity-30 mt-6">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </button>
            </form>

            <!-- Register Link -->
            <div class="text-center mt-4 sm:mt-6">
                <p class="text-white drop-shadow text-xs sm:text-sm">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                        class="text-yellow-200 font-semibold hover:text-yellow-100 hover:underline transition-colors duration-300">
                        Daftar Sekarang
                    </a>
                </p>
            </div>

            <!-- Divider -->
            <div class="flex items-center my-4 sm:my-6">
                <div class="flex-1 h-px bg-white bg-opacity-20"></div>
                <span class="px-3 text-white text-opacity-70 text-xs">atau</span>
                <div class="flex-1 h-px bg-white bg-opacity-20"></div>
            </div>

            <!-- Social Login Buttons -->
            <div class="space-y-2 sm:space-y-3">
                <button type="button"
                    class="w-full py-2.5 sm:py-3 px-4 rounded-lg bg-white bg-opacity-10 hover:bg-opacity-20 text-white text-sm font-medium transition-all duration-300 hover:-translate-y-0.5 flex items-center justify-center">
                    <i class="fab fa-google mr-2"></i>
                    Masuk dengan Google
                </button>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
