<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Wizard Pendaftaran Interaktif</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100" x-data="{ step: 1 }">

  <!-- Header -->
  <div class="bg-yellow-300 p-4 flex justify-between items-center shadow">
    <div class="flex items-center gap-2">
      <img src="logo.png" alt="Logo" class="h-10 w-10">
      <span class="font-bold text-black text-lg">Pendaftaran Siswa</span>
    </div>
    <div class="flex items-center gap-2">
      <div class="h-8 w-8 bg-blue-500 text-white rounded-full flex items-center justify-center">👤</div>
      <span class="font-medium text-sm">Hi, HAFIZ ATAMA ROMADHONI</span>
    </div>
  </div>

  <!-- Stepper Wizard -->
  <div class="bg-white py-6 px-6 shadow">
    <div class="flex justify-between items-center max-w-4xl mx-auto relative">

      <template x-for="n in 3" :key="n">
        <div class="flex-1 relative z-10">
          <div class="flex flex-col items-center group">
            <!-- Circle -->
            <div
              class="w-16 h-16 rounded-full flex items-center justify-center text-xl font-bold transition-all duration-300 ease-in-out cursor-pointer group-hover:scale-105"
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
            <span class="mt-2 text-sm font-semibold text-center w-24"
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
      <div class="absolute top-8 left-0 right-0 flex justify-between z-0 px-10">
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
  <div class="p-6 max-w-4xl mx-auto">
    <!-- Step 1 -->
    <div x-show="step === 1" x-transition class="bg-white p-6 rounded shadow grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block font-semibold mb-1">Nama Lengkap</label>
        <input type="text" class="w-full border rounded px-3 py-2 mb-4" placeholder="Hafiz Atama Romadhoni">

        <label class="block font-semibold mb-1">Waktu Pendaftaran</label>
        <input type="text" class="w-full border rounded px-3 py-2 mb-4" placeholder="23-04-2025 12:34:00">

        <label class="block font-semibold mb-1">Total Biaya</label>
        <input type="text" class="w-full border rounded px-3 py-2" placeholder="Rp. 200.000,00">
      </div>
      <div>
        <label class="block font-semibold mb-1">Pendaftaran yang dipilih</label>
        <input type="text" class="w-full border rounded px-3 py-2 mb-4" placeholder="Pendaftaran SMA IT 01, Tahun 2025">

        <label class="block font-semibold mb-1">Tanggal Pelaksanaan Ujian</label>
        <input type="date" class="w-full border rounded px-3 py-2">
      </div>
    </div>

    <!-- Step 2 -->
    <div x-show="step === 2" x-transition class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-semibold mb-4">Formulir Pendaftaran</h2>
      <p class="text-gray-600">Silakan isi form berikut...</p>
      <!-- Tambahkan konten -->
    </div>

    <!-- Step 3 -->
    <div x-show="step === 3" x-transition class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-semibold mb-4">Informasi Pembayaran</h2>
      <p class="text-gray-600">Silakan lakukan pembayaran sesuai petunjuk berikut...</p>
      <!-- Tambahkan konten -->
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-between mt-6">
      <button
        class="bg-gray-300 text-black font-semibold px-6 py-2 rounded shadow hover:bg-gray-400 disabled:opacity-50"
        @click="if (step > 1) step--"
        :disabled="step === 1"
      >
        Sebelumnya
      </button>
      <button
        class="bg-yellow-400 text-black font-semibold px-6 py-2 rounded shadow hover:bg-yellow-500"
        @click="step < 3 ? step++ : alert('Form selesai!')"
        x-text="step === 3 ? 'Selesai' : 'Selanjutnya'"
      ></button>
    </div>
  </div>

</body>
</html>
