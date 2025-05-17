@extends('layouts.penerimaan')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <div class="text-center mb-6">
            <svg class="w-24 h-24 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <h1 class="text-3xl font-bold text-gray-800 mt-4">Pembayaran Berhasil!</h1>
            <p class="text-gray-600 mt-2">Terima kasih! Pembayaran Anda telah kami terima.</p>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Detail Transaksi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Kode Transaksi</p>
                    <p class="font-medium">{{ $transaksi->kode_transaksi }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Pembayaran</p>
                    <p class="font-medium">{{ $transaksi->updated_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Metode Pembayaran</p>
                    <p class="font-medium">{{ ucfirst($transaksi->metode_pembayaran) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pembayaran</p>
                    <p class="font-medium">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Pendaftaran Dikonfirmasi</h3>
                    <div class="mt-2 text-sm text-green-700">
                        <p>Pendaftaran {{ $transaksi->pendaftaran->penerimaan->nama }} telah dikonfirmasi. Silakan cek email Anda untuk informasi selanjutnya.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-center space-y-3 md:space-y-0 md:space-x-3">
            <a href="{{ route('penerimaan.riwayat') }}" class="py-2 px-4 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-center">
                Riwayat Pendaftaran
            </a>
            <button
                onclick="window.print()"
                class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center justify-center"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Bukti Pembayaran
            </button>
        </div>
    </div>
</div>
@endsection