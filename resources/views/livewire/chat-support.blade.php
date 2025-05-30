<div class="fixed bottom-4 left-4 z-50">
    <!-- Admin List Card -->
    @if($showAdminList)
    <div class="admin-card absolute bottom-full left-0 mb-4 bg-white rounded-lg shadow-lg border border-gray-200 w-80 max-h-96 overflow-y-auto">
        <div class="bg-green-500 text-white p-4 rounded-t-lg relative">
            <button wire:click="toggleAdminList"
                    type="button"
                    class="absolute top-2 right-2 text-white hover:text-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 rounded p-1 hover:rotate-90 transform">
                <svg class="w-6 h-6 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h3 class="font-semibold text-sm pr-8">Salam !!! Klik salah satu perwakilan kami di bawah ini dan kami akan menghubungi Anda sesegera mungkin.</h3>
        </div>

        <!-- Call Centre Header -->
        <div class="p-3 border-b border-gray-100 flex items-center">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 animate-pulse">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.485 3.287"/>
                </svg>
            </div>
            <span class="text-gray-700 font-medium">CALL CENTRE</span>
        </div>

        <!-- Admin List -->
        <div class="max-h-64 overflow-y-auto">
            @forelse($admins as $admin)
                <div wire:click="contactAdmin('{{ $admin['nomor_hp'] ?? '' }}')"
                     class="admin-item p-3 border-b border-gray-50 hover:bg-gray-50 cursor-pointer transition-all duration-300 flex items-center hover:translate-x-1 hover:shadow-sm"
                     style="animation-delay: {{ $loop->index * 0.1 }}s;">
                    <div class="relative mr-3">
                        <!-- Admin Avatar/Icon -->
                        <div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-green-100 group-hover:ring-green-200 transition-all duration-200">
                            @if($admin['avatar'] && file_exists(storage_path('app/public/' . $admin['avatar'])))
                                <img src="{{ asset('storage/' . $admin['avatar']) }}"
                                     alt="{{ $admin['name'] }}"
                                     class="w-full h-full object-cover"
                                     loading="lazy"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <!-- Fallback avatar -->
                                <div class="w-full h-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center" style="display: none;">
                                    <span class="text-white font-semibold text-lg">{{ substr($admin['name'], 0, 1) }}</span>
                                </div>
                            @else
                                <!-- Default avatar with initial -->
                                <div class="w-full h-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                                    <span class="text-white font-semibold text-lg">{{ substr($admin['name'], 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- WhatsApp Online Indicator -->
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full flex items-center justify-center animate-pulse">
                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.485 3.287"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 mb-1">Admin</div>
                        <div class="text-gray-800 font-medium text-sm">{{ $admin['name'] }}</div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-gray-500 text-sm">
                    Tidak ada admin yang tersedia
                </div>
            @endforelse
        </div>
    </div>
    @endif

    <!-- Floating WhatsApp Button -->
    <button wire:click="toggleAdminList"
            type="button"
            class="whatsapp-button bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-3 group focus:outline-none focus:ring-4 focus:ring-green-300 relative overflow-hidden {{ $showAdminList ? 'rotate-45' : 'rotate-0' }}">

        <!-- Ripple Effect Background -->
        <div class="ripple-container">
            <div class="ripple-effect"></div>
        </div>

        <!-- Pulse Ring -->
        <div class="absolute inset-0 rounded-full bg-green-400 opacity-75 animate-ping"></div>

        <!-- WhatsApp Icon -->
        <svg class="w-6 h-6 transition-transform duration-300 relative z-10 {{ $showAdminList }}" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.485 3.287"/>
        </svg>

        <!-- Text -->
        <span class="text-sm font-medium whitespace-nowrap transition-all duration-300 relative z-10">
            {{ $showAdminList ? 'Tutup' : 'Butuh Bantuan Kami?' }}
        </span>
    </button>
</div>
