@extends('layouts.wizard')

@section('content')
<div class="max-w-4xl mx-auto" x-data="wizardForm()">

  <!-- Stepper Wizard -->
  <div class="bg-white py-4 px-4 rounded shadow mb-6">
    <div class="flex justify-between items-center relative">
      <template x-for="n in 3" :key="n">
        <div class="flex-1 relative z-10">
          <div class="flex flex-col items-center group">
            <!-- Circle -->
            <div
              class="w-12 h-12 rounded-full flex items-center justify-center text-base font-semibold transition-all duration-300 ease-in-out cursor-pointer group-hover:scale-105"
              :class="{
                'bg-yellow-400 text-white shadow-lg': step === n,
                'bg-green-500 text-white': step > n,
                'bg-gray-300 text-gray-700': step < n
              }"
              x-text="n"
              @click="step = n"
              :title="'Step ' + n"
            ></div>
            <!-- Label -->
            <span class="mt-2 text-xs font-medium text-center w-20"
              :class="{
                'text-yellow-600': step === n,
                'text-green-600': step > n,
                'text-gray-500': step < n
              }"
              x-text="['Informasi', 'Formulir', 'Pembayaran'][n - 1]"
            ></span>
          </div>
        </div>
      </template>

      <!-- Progress Lines -->
      <div class="absolute top-6 left-0 right-0 flex justify-between z-0 px-6">
        <template x-for="n in 2" :key="'line-' + n">
          <div class="w-full h-1 mx-2 rounded bg-gray-300 overflow-hidden">
            <div
              class="h-full transition-all duration-500"
              :class="step > n ? 'bg-green-500' : 'bg-gray-300'"
            ></div>
          </div>
        </template>
      </div>
    </div>
  </div>

  <!-- Form Content -->
  <div class="p-6 bg-white rounded shadow grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Step 1 -->
    <div x-show="step === 1" x-transition class="col-span-full grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block font-semibold mb-1">Username</label>
        <input type="text" name="username" class="w-full border rounded px-3 py-2 mb-4" value="{{ auth()->user()->name ?? '' }}" readonly>

        <label class="block font-semibold mb-1">Total Biaya</label>
        <input type="text" name="total_biaya" class="w-full border rounded px-3 py-2" value="{{ $penerimaan->biaya ?? '' }}" readonly>
      </div>
      <div>
        <label class="block font-semibold mb-1">Pendaftaran yang dipilih</label>
        <input type="text" name="pendaftaran" class="w-full border rounded px-3 py-2 mb-4" value="{{ $penerimaan->nama ?? '' }}" readonly>
      </div>
      <!-- Tombol Step 1 -->
      <div class="col-span-full flex justify-end mt-4">
        <button
          class="bg-yellow-400 text-black font-semibold px-6 py-2 rounded shadow hover:bg-yellow-500"
          @click="step++"
        >
          Selanjutnya
        </button>
      </div>
    </div>

    <!-- Step 2 -->
    <div x-show="step === 2" x-transition class="col-span-full grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block font-semibold mb-1">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="w-full border rounded px-3 py-2 mb-4" placeholder="Nama Lengkap">

        <label class="block font-semibold mb-1">Usia</label>
        <input type="number" name="usia" class="w-full border rounded px-3 py-2 mb-4" placeholder="Contoh: 17">

        <label class="block font-semibold mb-1">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="w-full border rounded px-3 py-2 mb-4">
          <option value="">-- Pilih Jenis Kelamin --</option>
          <option value="laki-laki">Laki-laki</option>
          <option value="perempuan">Perempuan</option>
        </select>

        <label class="block font-semibold mb-1">Unit Pendidikan</label>
        <input type="text" name="unit_pendidikan" class="w-full border rounded px-3 py-2 mb-4" value="{{ $penerimaan->unitPendidikan->nama ?? '' }}" readonly>
      </div>

      <div>
        <label class="block font-semibold mb-1">Nomor Pendaftaran</label>
        <input type="text" name="nomor_pendaftaran" class="w-full border rounded px-3 py-2 mb-4" value="{{ $nomorPendaftaran }}" readonly>

        <label class="block font-semibold mb-1">Alamat</label>
        <textarea name="alamat" rows="4" class="w-full border rounded px-3 py-2 mb-4" placeholder="Alamat Lengkap"></textarea>

        <label class="block font-semibold mb-1">Upload Ijazah</label>
        <input type="file" name="ijazah" class="w-full border rounded px-3 py-2 mb-4">

        <label class="block font-semibold mb-1">Upload Pas Foto</label>
        <input type="file" name="pas_foto" class="w-full border rounded px-3 py-2 mb-4">

        <label class="block font-semibold mb-1">Upload SKHU</label>
        <input type="file" name="skhu" class="w-full border rounded px-3 py-2">
      </div>
      <!-- Tombol Step 2 -->
      <div class="col-span-full flex justify-between mt-4">
        <button
          class="bg-gray-300 text-black font-semibold px-6 py-2 rounded shadow hover:bg-gray-400"
          @click="step--"
        >
          Sebelumnya
        </button>
        <button
          class="bg-yellow-400 text-black font-semibold px-6 py-2 rounded shadow hover:bg-yellow-500"
          @click="showModal = true"
        >
          Lanjut Ke Pembayaran
        </button>
      </div>
    </div>

    <!-- Step 3 -->
    <div x-show="step === 3" x-transition class="col-span-full">
        <div>
            <label class="block font-semibold mb-1">Pendaftaran yang dipilih</label>
            <input type="text" name="pendaftaran" class="w-full border rounded px-3 py-2 mb-4" value="{{ $penerimaan->nama ?? '' }}" readonly>

            <label class="block font-semibold mb-1">Unit Pendidikan yang dipilih</label>
            <input type="text" name="unit_pendidikan" class="w-full border rounded px-3 py-2 mb-4" value="{{ $penerimaan->unitPendidikan->nama ?? '' }}" readonly>

            <label class="block font-semibold mb-1">Harga Formulir</label>
            <input type="text" name="harga" class="w-full border rounded px-3 py-2 mb-4" value="{{ $penerimaan->biaya ?? '' }}" readonly>

            <label class="block font-semibold mb-1">Total Biaya</label>
            <input type="text" name="total" class="w-full border rounded px-3 py-2 mb-4" :value="biayaTotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })" readonly>

            <div class="p-4 bg-yellow-50 rounded border border-yellow-200 mb-4">
                <h3 class="font-semibold text-yellow-700 mb-2">Informasi Pembayaran</h3>
                <p class="text-sm text-yellow-800">Klik tombol "Bayar Sekarang" untuk melanjutkan proses pembayaran melalui berbagai metode pembayaran yang tersedia.</p>
            </div>
        </div>

      <div class="col-span-full flex justify-between mt-4">
        <button
          class="bg-gray-300 text-black font-semibold px-6 py-2 rounded shadow hover:bg-gray-400"
          @click="step--"
        >
          Sebelumnya
        </button>
        <button
          id="pay-button"
          class="bg-green-500 text-white font-semibold px-6 py-2 rounded shadow hover:bg-green-600"
          @click="processPayment()"
          :disabled="isLoadingPayment"
        >
          <span x-show="isLoadingPayment" class="inline-block mr-2">
            <svg class="animate-spin h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </span>
          <span x-text="isLoadingPayment ? 'Memproses...' : 'Bayar Sekarang'"></span>
        </button>
      </div>
    </div>
  </div>

  <!-- Modal Konfirmasi -->
  <div
    x-show="showModal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    style="display: none;"
  >
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
      <h2 class="text-lg font-semibold mb-4">Konfirmasi</h2>
      <p>Apakah Anda yakin ingin melanjutkan ke pembayaran? Data akan disimpan.</p>
      <div class="flex justify-end mt-4 space-x-2">
        <button @click="showModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
        <button
          @click="submitData()"
          class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600"
        >
          Ya, Simpan & Lanjut
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Midtrans Snap.js Script -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>

<!-- AlpineJS Script -->
<script>
    function wizardForm() {
  return {
    step: 1,
    showModal: false,
    isLoadingPayment: false,
    biayaTotal: {{ $penerimaan->biaya ?? 0 }},
    pendaftaranId: null,

    submitData() {
      const formData = new FormData();

      formData.append('user_id', {{ auth()->id() }});
      formData.append('penerimaan_id', {{ $penerimaan->id }});
      formData.append('nomor_pendaftaran', document.querySelector('[name=nomor_pendaftaran]').value);
      formData.append('nama_lengkap', document.querySelector('[name=nama_lengkap]').value);
      formData.append('usia', document.querySelector('[name=usia]').value);
      formData.append('jenis_kelamin', document.querySelector('[name=jenis_kelamin]').value);
      formData.append('alamat', document.querySelector('[name=alamat]').value);
      formData.append('ijazah', document.querySelector('[name=ijazah]').files[0]);
      formData.append('pas_foto', document.querySelector('[name=pas_foto]').files[0]);
      formData.append('skhu', document.querySelector('[name=skhu]').files[0]);
      formData.append('_token', '{{ csrf_token() }}');

      fetch('{{ route('pendaftaran.store') }}', {
        method: 'POST',
        body: formData,
      })
      .then(async response => {
        if (!response.ok) throw await response.text();
        return response.json();
      })
      .then(data => {
        this.pendaftaranId = data.id;
        this.showModal = false;
        this.step = 3;
      })
      .catch(error => {
        alert('Gagal menyimpan data. Periksa kembali formulir atau coba lagi nanti.');
        console.error(error);
      });
    },

    processPayment() {
      if (!this.pendaftaranId) {
        alert('Data pendaftaran belum tersedia. Silakan kembali dan isi formulir terlebih dahulu.');
        return;
      }

      this.isLoadingPayment = true;

      fetch(`/payment/snap-token/${this.pendaftaranId}`)
        .then(res => {
          if (!res.ok) throw new Error('Failed to get snap token');
          return res.json();
        })
        .then(data => {
          this.isLoadingPayment = false;

          // Konfigurasi callback untuk Midtrans Snap
          window.snap.pay(data.snap_token, {
            onSuccess: (result) => {
              console.log('Payment success:', result);
              // Redirect ke halaman sukses atau reload page
              window.location.href = '{{ route('payment.finish') }}';
            },
            onPending: (result) => {
              console.log('Payment pending:', result);
              alert('Pembayaran pending. Silakan selesaikan pembayaran Anda.');
            },
            onError: (result) => {
              console.log('Payment error:', result);
              alert('Terjadi kesalahan dalam pembayaran. Silakan coba lagi.');
            },
            onClose: () => {
              console.log('Payment popup closed');
              // User menutup popup pembayaran
            }
          });
        })
        .catch(error => {
          this.isLoadingPayment = false;
          console.error('Error:', error);
          alert('Gagal memuat pembayaran. Silakan coba lagi.');
        });
    }
  };
}

    </script>


@endsection