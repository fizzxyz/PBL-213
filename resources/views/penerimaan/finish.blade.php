@extends('layouts.penerimaan')

@section('content')
<div class="max-w-2xl mx-auto py-12">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="mb-6">
            <svg class="w-16 h-16 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-4">Pembayaran Berhasil!</h1>

        <p class="text-gray-600 mb-8">
            Terima kasih! Pembayaran Anda telah berhasil diproses.
            Kami akan mengirimkan konfirmasi ke email Anda dalam beberapa menit.
        </p>

        <div class="space-y-4">
            <a href="" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                Kembali ke Dashboard
            </a>

            <div class="text-sm text-gray-500">
                <p>Jika Anda memiliki pertanyaan, silakan hubungi customer service kami.</p>
            </div>
        </div>
    </div>
</div>
@endsection