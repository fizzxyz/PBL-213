@extends('layouts.penerimaan')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 w-full max-w-5xl px-4">
        <!-- Card Daftar -->
        <a href="{{ route('penerimaan.list') }}" class="group bg-white rounded-2xl shadow-md flex flex-col items-center justify-center py-16 px-8 transition transform hover:scale-105 hover:shadow-xl hover:bg-black duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-gray-700 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-800 group-hover:text-white transition">Daftar</h2>
            <p class="mt-2 text-gray-600 group-hover:text-white text-sm transition">Klik untuk melanjutkan ke form pendaftaran</p>
        </a>
        <!-- Card Riwayat -->
        <a href="{{ route('penerimaan.riwayat') }}" class="group bg-white rounded-2xl shadow-md flex flex-col items-center justify-center py-16 px-8 transition transform hover:scale-105 hover:shadow-xl hover:bg-black duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-gray-900 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1118 0 9 9 0 01-18 0zm9-4v4l3 3" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-900 group-hover:text-white transition">Riwayat</h2>
            <p class="mt-2 text-gray-600 group-hover:text-white text-sm transition">Cek riwayat pendaftaran anda disini</p>
        </a>
    </div>
</div>
@endsection


