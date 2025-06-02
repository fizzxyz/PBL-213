@extends('layouts.daftar')

<body style="background: url('{{ asset('storage/home/yayasan/background.png') }}') center center / cover no-repeat;" class="min-h-screen flex items-center justify-center p-5 relative overflow-hidden">
    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-opacity-40 backdrop-blur-sm z-0"></div>

    <!-- Floating Background Elements -->
    <div class="absolute -top-1/2 -right-1/4 w-96 h-96 bg-gradient-radial from-yellow-300 to-transparent opacity-20 rounded-full pulse-bg"></div>
    <div class="absolute -bottom-1/3 -left-1/4 w-80 h-80 bg-gradient-radial from-orange-300 to-transparent opacity-10 rounded-full floating-circle"></div>

    <!-- Main Container -->
    <div class="glass-card rounded-2xl mt-10 shadow-2xl overflow-hidden max-w-4xl w-full flex relative z-10 max-h-[520px]">

        <!-- Email Verification Section -->
        <div class="flex-1 glass p-4 flex flex-col justify-center items-center text-center">
            <!-- Icon -->
            <div class="mb-4">
                <div class="bg-gradient-to-r from-orange-400 to-yellow-400 p-4 rounded-full inline-block">
                    <i class="fas fa-envelope-open-text text-white text-3xl"></i>
                </div>
            </div>

            <!-- Header -->
            <div class="mb-3">
                <h3 class="text-2xl font-bold text-white drop-shadow-lg mb-1">Verifikasi Email</h3>
                <p class="text-white text-opacity-90 text-base">
                    Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan kepada Anda.
                </p>
            </div>

            <!-- Status Messages -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-3 bg-green-500 bg-opacity-20 border border-green-400 text-green-100 px-3 py-2 rounded-lg text-sm">
                    <i class="fas fa-check-circle mr-2"></i>
                    Link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif

            @if (session('status'))
                <div class="mb-3 bg-blue-500 bg-opacity-20 border border-blue-400 text-blue-100 px-3 py-2 rounded-lg text-sm">
                    <i class="fas fa-info-circle mr-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Email Address Display -->
            <div class="mb-4 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-lg p-3 text-sm">
                <p class="text-white mb-1">Email verifikasi dikirim ke:</p>
                <p class="text-yellow-200 font-semibold">{{ auth()->user()->email }}</p>
            </div>

            <!-- Instructions -->
            <div class="mb-3 text-white text-opacity-80 text-sm">
                <p class="mb-1">Silakan cek email Anda dan klik link verifikasi yang tersedia.</p>
                <p>Jika Anda tidak menerima email, silakan klik tombol di bawah untuk mengirim ulang.</p>
            </div>

            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                @csrf
                <button type="submit"
                        class="glass-button px-6 py-2 rounded-lg text-white text-sm font-medium cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-3 focus:ring-orange-400 focus:ring-opacity-30">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <!-- Alternative Actions -->
            <div class="flex flex-col sm:flex-row gap-3 items-center text-sm">
                <a href="{{ route('login') }}"
                   class="text-yellow-200 hover:text-yellow-100 hover:underline transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali ke Login
                </a>

                <span class="text-white text-opacity-50 hidden sm:block">|</span>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="text-red-300 hover:text-red-200 hover:underline transition-colors duration-300">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        Logout
                    </button>
                </form>
            </div>

            <!-- Help Section -->
            <div class="mt-4 text-center text-xs text-white text-opacity-60">
                <p class="mb-1">Tidak menerima email?</p>
                <div class="text-white text-opacity-80 space-y-1">
                    <p>• Periksa folder spam/junk email Anda</p>
                    <p>• Pastikan alamat email yang digunakan benar</p>
                    <p>• Tunggu beberapa menit untuk email masuk</p>
                </div>
            </div>
        </div>
    </div>
</body>

<style>
.pulse-bg {
    animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.floating-circle {
    animation: float 6s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 0.2;
    }
    50% {
        opacity: 0.4;
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

.glass-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.glass {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
}

.glass-button {
    background: linear-gradient(135deg, rgba(255, 165, 0, 0.8), rgba(255, 140, 0, 0.9));
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
}

.glass-button:hover {
    background: linear-gradient(135deg, rgba(255, 165, 0, 0.9), rgba(255, 140, 0, 1));
    transform: translateY(-2px);
    box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.5);
}
</style>
