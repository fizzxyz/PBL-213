@extends('layouts.home')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Welcome Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-gray-600">
                        Terimakasih sudah memverifikasi email anda.
                    </p>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-check-circle text-4xl"></i>
                </div>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Akun</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="flex items-center">
                        <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded flex-1">{{ auth()->user()->email }}</p>
                        <span class="ml-2 text-green-500" title="Email Terverifikasi">
                            <i class="fas fa-check-circle"></i>
                        </span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded">{{ auth()->user()->nomor_hp }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bergabung</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded">{{ auth()->user()->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Verification Success Alert -->
        @if (session('verified'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('verified') }}</span>
                </div>
            </div>
        @endif

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="text-red-500 mb-4">
                    <i class="fas fa-sign-out-alt text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Logout</h3>
                <p class="text-gray-600 text-sm mb-4">Keluar dari akun Anda</p>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection