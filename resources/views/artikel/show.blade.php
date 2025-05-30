@extends('layouts.home')

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<section style="padding: 200px 20px; background: url({{ asset('storage/' . $artikel->thumbnail) }}) center/cover no-repeat; color: white; text-align: center;">
    <h1 style="font-size: 2.5em; font-weight: bold; color: #FFD700;">Artikel Yayasan {{ $yayasan->name }}</h1>
</section>

<!-- Section Card Utama -->
<section class="relative -mt-20">
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg px-6 md:px-12 py-12 space-y-8">
        <!-- Atas: Header & Metadata Artikel -->
        <div class="grid md:grid-cols-5 gap-8">
            <!-- Tanggal -->
            <div class="md:col-span-1">
                <h2 class="text-yellow-600 font-bold text-2xl md:text-3xl leading-snug">
                    {{ \Carbon\Carbon::parse($artikel->created_at)->format('d M Y') }}
                </h2>
            </div>

            <!-- Judul & Metadata -->
            <div class="md:col-span-4 border-l-2 border-gray-300 pl-6">
                <h3 class="text-gray-800 font-bold text-xl md:text-2xl mb-4 leading-tight">
                    {{ $artikel->judul }}
                </h3>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
                    <div class="flex items-center gap-1">
                        <span class="text-gray-500">By</span>
                        <span class="font-medium">{{ $artikel->user->name ?? 'Admin' }}</span>
                    </div>

                    @if($artikel->category)
                        <div class="flex items-center gap-1">
                            <span class="text-gray-500">•</span>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                {{ $artikel->category->name }}
                            </span>
                        </div>
                    @endif

                    @if ( $artikel->unitPendidikans)
                        <div class="flex items-center gap-1">
                            <span class="text-gray-500">•</span>
                            @foreach ( $artikel->unitPendidikans as $tag )
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $tag->nama }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex items-center gap-1">
                        <span class="text-gray-500">•</span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span>{{ $artikel->comments->count() }} Komentar</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bawah: Isi Artikel -->
        <div class="prose prose-lg max-w-none">
            {!! $artikel->isi !!}
        </div>

        <!-- Previous/Next Post Navigation -->
        <div class="flex justify-between items-center py-8 border-t border-gray-200">
            <!-- Previous Post -->
            @if($previousPost)
                <a href="{{ route('artikel.show', $previousPost->slug) }}" class="flex items-center text-gray-600 hover:text-gray-800 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="font-medium">PREVIOUS POST</span>
                </a>
            @else
                <div></div>
            @endif

            <!-- Next Post -->
            @if($nextPost)
                <a href="{{ route('artikel.show', $nextPost->slug) }}" class="flex items-center text-gray-600 hover:text-gray-800 transition">
                    <span class="font-medium">NEXT POST</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <div></div>
            @endif
        </div>
    </div>
</section>

<!-- Related Posts Section -->
@if($relatedPosts && $relatedPosts->count() > 0)
<section class="py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">RELATED POST</h2>

        <!-- Grid Related Posts -->
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($relatedPosts as $relatedPost)
                <a href="{{ route('artikel.show', $relatedPost->slug) }}"
                   class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $relatedPost->thumbnail) }}"
                             class="w-full h-52 object-cover"
                             alt="{{ $relatedPost->judul }}">
                        <span class="absolute top-2 right-2 bg-yellow-300 text-black px-3 py-1 text-sm font-semibold rounded-full">
                            Informasi
                        </span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $relatedPost->judul }}</h3>
                        <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($relatedPost->created_at)->format('F d, Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Comments Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">
            Komentar {{ count($artikel->comments) }}
        </h2>

        <!-- Comment Form -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tinggalkan Komentar</h3>
            <form action="{{ route('komentar.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="artikel_id" value="{{ $artikel->id }}">

                @auth
                    <!-- User yang sudah login -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                            <input type="text"
                                   value="{{ auth()->user()->name }}"
                                   readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email"
                                   value="{{ auth()->user()->email }}"
                                   readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600">
                        </div>
                    </div>
                @else
                    <!-- Guest user -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-2">Nama *</label>
                            <input type="text"
                                   id="guest_name"
                                   name="guest_name"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label for="guest_email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email"
                                   id="guest_email"
                                   name="guest_email"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Masukkan email Anda">
                        </div>
                    </div>
                @endauth

                <div>
                    <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">Komentar *</label>
                    <textarea id="isi"
                              name="isi"
                              rows="4"
                              required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Tulis komentar Anda..."></textarea>
                </div>

                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition font-medium">
                    Kirim Komentar
                </button>
            </form>
        </div>

        <!-- Comments List -->
        <div class="space-y-6">
            @forelse($artikel->comments as $komentar)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <!-- Comment Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ strtoupper(substr($komentar->guest_name ?? $komentar->user->name ?? 'A', 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">
                                    {{ $komentar->guest_name ?? $komentar->user->name ?? 'Anonymous' }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ $komentar->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Comment Content -->
                    <div class="mb-4">
                        <p class="text-gray-700 leading-relaxed">{{ $komentar->isi }}</p>
                    </div>

                    <!-- Reply Button -->
                    <button onclick="toggleReplyForm({{ $komentar->id }})"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Balas
                    </button>

                    <!-- Reply Form (Hidden by default) -->
                    <div id="reply-form-{{ $komentar->id }}" class="hidden mt-4 bg-gray-50 rounded-lg p-4">
                        <form action="{{ route('balasan.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="komentar_id" value="{{ $komentar->id }}">

                            @auth
                                <!-- User yang sudah login -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <input type="text"
                                               value="{{ auth()->user()->name }}"
                                               readonly
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 text-sm"
                                               placeholder="Nama Anda">
                                    </div>
                                    <div>
                                        <input type="email"
                                               value="{{ auth()->user()->email }}"
                                               readonly
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 text-sm"
                                               placeholder="Email Anda">
                                    </div>
                                </div>
                            @else
                                <!-- Guest user -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <input type="text"
                                               name="guest_name"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                               placeholder="Nama Anda">
                                    </div>
                                    <div>
                                        <input type="email"
                                               name="guest_email"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                               placeholder="Email Anda">
                                    </div>
                                </div>
                            @endauth

                            <div>
                                <textarea name="isi"
                                          rows="3"
                                          required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                          placeholder="Tulis balasan Anda..."></textarea>
                            </div>

                            <div class="flex space-x-2">
                                <button type="submit"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm font-medium">
                                    Kirim Balasan
                                </button>
                                <button type="button"
                                        onclick="toggleReplyForm({{ $komentar->id }})"
                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition text-sm font-medium">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Replies -->
                    @if($komentar->balasans->count() > 0)
                        <div class="mt-6 ml-6 space-y-4">
                            @foreach($komentar->balasans as $balasan)
                                <div class="bg-gray-50 border-l-4 border-blue-200 p-4 rounded">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-xs">
                                                {{ strtoupper(substr($balasan->guest_name ?? $balasan->user->name ?? 'A', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h5 class="font-medium text-gray-800 text-sm">
                                                {{ $balasan->guest_name ?? $balasan->user->name ?? 'Anonymous' }}
                                            </h5>
                                            <p class="text-xs text-gray-500">
                                                {{ $balasan->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-sm leading-relaxed">{{ $balasan->isi }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
function toggleReplyForm(komentarId) {
    const form = document.getElementById(`reply-form-${komentarId}`);
    form.classList.toggle('hidden');
}
</script>
@endif