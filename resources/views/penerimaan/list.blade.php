@extends('layouts.penerimaan')

@section('content')
<div class="bg-[#f8fbff] min-h-screen py-8 pt-28">
    <div class="max-w-6xl mx-auto">
        <div class="px-4"> <!-- Tambahkan pembungkus dengan padding yang sama -->
            <div class="text-center mb-8 bg-white rounded-lg shadow-md p-2">
                <h2 class="text-2xl font-bold text-[#232e4d]">Pendaftaran Yang Tersedia</h2>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
            @forelse ($penerimaans as $penerimaan)
            <div class="bg-white border border-yellow-100 rounded-lg shadow-md p-6 flex flex-col justify-between w-full">
                <div>
                    <div class="flex items-center gap-2 mb-2 text-[#232e4d] font-bold">
                        <i class="fas fa-file-alt"></i>
                        {{ $penerimaan->unitPendidikan->nama ?? 'Unit Tidak Diketahui' }}
                    </div>
                    <div class="font-bold text-lg text-[#232e4d] mb-2">
                        {{ $penerimaan->nama }}
                    </div>
                    <div class="flex justify-between items-start text-sm text-[#232e4d] mb-6">
                        <div>
                            <div class="font-semibold">Waktu Pendaftaran:</div>
                            <div>
                                {{ \Carbon\Carbon::parse($penerimaan->dibuka_pada)->format('d F Y') }}<br>
                                s/d<br>
                                {{ \Carbon\Carbon::parse($penerimaan->ditutup_pada)->format('d F Y') }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold">Biaya:</div>
                            <div class="font-bold">Rp. {{ number_format($penerimaan->biaya, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('penerimaan.wizard', $penerimaan->id) }}"
                  class="bg-yellow-200 hover:bg-yellow-300 text-[#232e4d] font-bold py-2 rounded shadow-md transition text-center">
                  Daftar
                </a>

            </div>
            @empty
            <p class="text-center text-gray-500 col-span-full">Belum ada pendaftaran yang tersedia saat ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
