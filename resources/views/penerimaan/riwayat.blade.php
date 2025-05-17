@extends('layouts.penerimaan')

@section('content')
<div class="bg-[#f8fbff] min-h-screen py-8 pt-28 flex justify-center">
    <div class="w-full max-w-6xl bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Riwayat Pendaftaran</h1>

        @if($riwayat->isEmpty())
            <p class="text-gray-600 text-center">Anda belum memiliki riwayat pendaftaran.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="py-3 px-4 border-b">Nomor Pendaftaran</th>
                            <th class="py-3 px-4 border-b">Nama Lengkap</th>
                            <th class="py-3 px-4 border-b">Penerimaan</th>
                            <th class="py-3 px-4 border-b">Unit Pendidikan</th>
                            <th class="py-3 px-4 border-b">Status Pendaftaran</th>
                            <th class="py-3 px-4 border-b">Status Pembayaran</th>
                            <th class="py-3 px-4 border-b text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $item->nomor_pendaftaran }}</td>
                            <td class="py-2 px-4 border-b">{{ $item->nama_lengkap }}</td>
                            <td class="py-2 px-4 border-b">{{ $item->penerimaan->nama }}</td>
                            <td class="py-2 px-4 border-b">{{ $item->penerimaan->unitPendidikan->nama ?? '-' }}</td>

                            {{-- Status Pendaftaran --}}
                            <td class="py-2 px-4 border-b">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold shadow-sm ring-1 ring-inset
                                    @if($item->status_pendaftaran == 'pending') bg-yellow-400 text-gray-900 ring-yellow-400
                                    @elseif($item->status_pendaftaran == 'diterima') bg-green-500 text-white ring-green-500
                                    @elseif($item->status_pendaftaran == 'ditolak') bg-red-500 text-white ring-red-500
                                    @else bg-gray-200 text-gray-700 ring-gray-400
                                    @endif">
                                    {{ ucfirst($item->status_pendaftaran) }}
                                </span>
                            </td>


                            {{-- Status Pembayaran --}}
                            <td class="py-2 px-4 border-b">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold shadow-sm ring-1 ring-inset
                                    @if($item->transaksi && $item->transaksi->is_paid) bg-green-500 text-white ring-green-500
                                    @elseif($item->transaksi) bg-red-500 text-white ring-red-500
                                    @else bg-gray-200 text-gray-700 ring-gray-400
                                    @endif">
                                    @if($item->transaksi)
                                        {{ $item->transaksi->is_paid ? 'Sudah Bayar' : 'Belum Bayar' }}
                                    @else
                                        Tidak Ada Transaksi
                                    @endif
                                </span>
                            </td>


                            {{-- Tombol Cetak --}}
                            <td class="py-2 px-4 border-b text-center">
                                <a href=
                                {{-- "{{ route('penerimaan.cetak_kartu', $item->id) }}" --}}
                                   target="_blank"
                                   class="inline-block bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 transition">
                                    Cetak Kartu Ujian
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
