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
    biayaDasar: {{ $penerimaan->biaya ?? 0 }},
    pendaftaranId: null,
    snapToken: null,
    isLoadingPayment: false,
    get biayaTotal() {
      return this.biayaDasar + 5000;
    },
    async submitData() {
      // Check if we're already processing to prevent multiple submissions
      if (this.isLoadingPayment) return;
      this.isLoadingPayment = true;

      const formData = new FormData();

      // Ambil nilai input
      formData.append('nama_lengkap', document.querySelector('input[name="nama_lengkap"]').value);
      formData.append('usia', document.querySelector('input[name="usia"]').value);
      formData.append('jenis_kelamin', document.querySelector('select[name="jenis_kelamin"]').value);
      formData.append('unit_pendidikan', document.querySelector('input[name="unit_pendidikan"]').value);
      formData.append('nomor_pendaftaran', document.querySelector('input[name="nomor_pendaftaran"]').value);
      formData.append('alamat', document.querySelector('textarea[name="alamat"]').value);
      formData.append('penerimaan_id', '{{ $penerimaan->id ?? 1 }}');

      // Add total_biaya field to avoid dependency on penerimaan table
      formData.append('total_biaya', this.biayaTotal);

      // Ambil file
      const ijazah = document.querySelector('input[name="ijazah"]').files[0];
      const pasFoto = document.querySelector('input[name="pas_foto"]').files[0];
      const skhu = document.querySelector('input[name="skhu"]').files[0];

      // Validasi apakah file sudah dipilih
      if (!ijazah || !pasFoto || !skhu) {
        alert('Semua file wajib diunggah.');
        this.isLoadingPayment = false;
        return;
      }

      formData.append('ijazah', ijazah);
      formData.append('pas_foto', pasFoto);
      formData.append('skhu', skhu);

      try {
        console.log("Submitting form to pendaftaran/store");

        // Explicitly use the correct URL instead of route helper
        // You can change this URL to match your actual pendaftaran store endpoint
        const storeUrl = '/pendaftaran/store';

        const response = await fetch(storeUrl, {
          method: "POST",
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json' // Added this header to ensure JSON response
          },
          body: formData
        });

        console.log("Response status:", response.status);

        // Check content type
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
          // If not JSON, get the text response for debugging
          const textResponse = await response.text();
          console.error("Server returned non-JSON response:", textResponse.substring(0, 500));
          throw new Error("Server returned an invalid response format. Please check server logs.");
        }

        // Parse the JSON response
        const result = await response.json();
        console.log("Response data:", result);

        if (!response.ok) {
          let errorMessage = result.message || 'Gagal menyimpan data.';
          if (result.errors) {
            errorMessage += '\n' + Object.entries(result.errors)
              .map(([field, errors]) => `${field}: ${errors.join(', ')}`)
              .join('\n');
          }
          throw new Error(errorMessage);
        }

        // Ekstrak ID pendaftaran dan ID transaksi dari response
        if (result && result.pendaftaran_id) {
          this.pendaftaranId = result.pendaftaran_id;
        } else if (result && result.pendaftaran && result.pendaftaran.id) {
          this.pendaftaranId = result.pendaftaran.id;
        } else if (result && result.id) {
          this.pendaftaranId = result.id;
        } else {
          console.log("Response data:", result);
          throw new Error("Tidak dapat menemukan ID pendaftaran dalam response");
        }

        console.log("Pendaftaran ID tersimpan:", this.pendaftaranId);

        // Simpan transaksi ID jika ada
        if (result && result.transaksi_id) {
          this.transaksiId = result.transaksi_id;
          console.log("Transaksi ID tersimpan:", this.transaksiId);
        }

        this.showModal = false;
        this.step = 3;
      } catch (error) {
        console.error("Error during submission:", error);
        alert("Terjadi kesalahan saat menyimpan data:\n" + error.message);
      } finally {
        this.isLoadingPayment = false;
      }
    },
    async processPayment() {
      if (!this.pendaftaranId) {
        alert('ID pendaftaran tidak ditemukan. Silakan kembali ke formulir dan coba lagi.');
        return;
      }

      this.isLoadingPayment = true;

      try {
        console.log("Mengirim request pembayaran dengan ID:", this.pendaftaranId);

        // Dapatkan informasi tambahan untuk pembayaran
        const nama = document.querySelector('input[name="nama_lengkap"]').value || 'Pendaftar';
        const totalBiaya = this.biayaTotal;
        const unitPendidikan = document.querySelector('input[name="unit_pendidikan"]').value || '';
        const pendaftaran = document.querySelector('input[name="pendaftaran"]').value || '';

        // Data untuk request pembayaran
        const paymentData = {
          pendaftaran_id: this.pendaftaranId,
          nama_lengkap: nama,
          total_biaya: totalBiaya,
          unit_pendidikan: unitPendidikan,
          nama_pendaftaran: pendaftaran
        };

        console.log("Data pembayaran:", paymentData);

        // Request untuk mendapatkan snap token
        // You can change this URL to match your actual transaksi create-payment endpoint
        const paymentUrl = '/transaksi/create-payment';

        const response = await fetch(paymentUrl, {
          method: "POST",
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: JSON.stringify(paymentData)
        });

        console.log("Status response:", response.status);

        // Check content type
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
          // If not JSON, get the text response for debugging
          const textResponse = await response.text();
          console.error("Payment server returned non-JSON response:", textResponse.substring(0, 500));
          throw new Error("Payment server returned an invalid response format. Please check server logs.");
        }

        // Parse JSON response
        const data = await response.json();
        console.log("Payment response data:", data);

        if (!response.ok) {
          throw new Error(`Gagal memproses pembayaran: ${response.status} - ${data.message || 'Unknown error'}`);
        }

        // Cek dan ambil snap token
        if (!data) {
          throw new Error("Response data kosong");
        }

        // Coba temukan token dari berbagai kemungkinan lokasi
        const possibleTokenLocations = [
          data?.snap_token,
          data?.token,
          data?.data?.snap_token,
          data?.data?.token,
          data?.transaction?.snap_token,
          data?.result?.snap_token,
          data?.result?.token
        ];

        this.snapToken = possibleTokenLocations.find(token => token && typeof token === 'string');

        if (!this.snapToken) {
          throw new Error(`Token pembayaran tidak ditemukan dalam response: ${JSON.stringify(data)}`);
        }

        console.log("Snap token ditemukan:", this.snapToken);

        // Tampilkan Snap Payment Page
        window.snap.pay(this.snapToken, {
        onSuccess: function(result) {
            console.log("Pembayaran sukses:", result);
            // Create a URL with all the necessary information from result
            let successUrl = "/checkout/success?order_id=" + result.order_id +
                            "&payment_type=" + result.payment_type;

            // Add additional result data as JSON string in a parameter
            // This will include transaction_id, pdf_url and other details from Midtrans
            successUrl += "&transaction_data=" + encodeURIComponent(JSON.stringify(result));

            window.location.href = successUrl;
        },
          onPending: function(result) {
            console.log("Pembayaran tertunda:", result);
            alert("Pembayaran tertunda! Silakan selesaikan pembayaran Anda.");
          },
          onError: function(result) {
            console.error("Pembayaran error:", result);
            alert("Pembayaran gagal! Detail: " + JSON.stringify(result));
          },
          onClose: function() {
            console.log("Popup pembayaran ditutup");
            alert('Anda menutup popup tanpa menyelesaikan pembayaran');
          }
        });

      } catch (error) {
        console.error("Error dalam proses pembayaran:", error);
        alert("Error: " + error.message);
      } finally {
        this.isLoadingPayment = false;
      }
    }
  };
}
</script>

@endsection