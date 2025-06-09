@extends('layouts.home')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- Quill Rich Text Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Edit Mode Toggle -->
@auth
    @if (auth()->user()->hasAnyRole(['admin', 'super_admin']))
        <div class="edit-toggle">
            <span>Edit Mode</span>
            <label class="switch">
                <input type="checkbox" id="editModeToggle">
                <span class="slider"></span>
            </label>
        </div>
    @endif
@endauth


<!-- Hero Section -->
<section class="relative h-screen bg-cover bg-center editable-section"
    style="background-image: url('{{ asset('storage/' . $homeContent->hero_image) }}')">
    <button class="edit-btn" onclick="openEditModal('hero')">Edit Hero</button>
    <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>

    <div class="relative z-10 flex flex-col items-center justify-center text-center h-full text-white px-4">
        <p class="text-sm md:text-base mb-2">{{ $homeContent->hero_title }}</p>
        <h1 class="text-2xl md:text-4xl font-bold text-yellow-400 mb-4">{{ $homeContent->hero_sm_title }}</h1>
        <p class="text-sm md:text-lg max-w-xl">
            <span class="text-yellow-300">{{ $homeContent->hero_text }} </span>
        </p>
    </div>
</section>

<!-- Section Below Hero (2 Kolom) -->
<section class="relative -mt-20">
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg px-12 py-12 grid md:grid-cols-5 gap-8 editable-section">
        <button class="edit-btn" onclick="openEditModal('card')">Edit Card</button>

        <!-- Left Column (2/5) -->
        <div class="md:col-span-1">
            <h2 class="text-yellow-600 font-bold text-2xl md:text-3xl leading-snug">
                {{ $homeContent->card_title }}
            </h2>
        </div>

        <!-- Right Column (3/5) with left border -->
        <div class="md:col-span-4 border-l-2 border-gray-300 pl-6 text-gray-700 text-base leading-relaxed">
            <p>
                {{ $homeContent->card_text }}
            </p>
        </div>

    </div>
</section>

<section class="bg-[#EAF6FF] py-16 mt-9 relative editable-section">
    <button class="edit-btn" onclick="openEditModal('pengantar')">Edit Pengantar</button>
    <div class="justify-center text-center mb-8">
        <h3 class="text-blue-600 uppercase text-sm font-semibold tracking-widest">{{ $homeContent->pengantar_title }}
        </h3>
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $homeContent->pengantar_sm_title }}</h2>
    </div>

    <div class="max-w-6xl mx-auto py-10 grid md:grid-cols-5 gap-10 items-start relative z-10">

        <!-- Foto & Nama -->
        <div class="md:col-span-2 relative flex flex-col items-center text-center md:text-left">
            <img src="{{ asset('storage/' . $homeContent->pengantar_image) }}" alt="Ketua Yayasan"
                class="rounded-lg size-60 mb-4 shadow-lg z-0">

            <!-- Card nama/jabatan nimpa gambar -->
            <div
                class="absolute -bottom-6 left-1/2 -translate-x-1/2 bg-yellow-300 rounded-full text-base font-semibold text-black shadow-lg z-10 w-60 text-center">
                <span class="w-full text-normal">{{ $homeContent->pengantar_sm_text1 }}</span>
                </br>
                <span class="text-xs font-normal">{{ $homeContent->pengantar_sm_text2 }}</span>
            </div>
        </div>

        <!-- Sambutan -->
        <div class="md:col-span-3 space-y-4">
            <div class="text-yellow-500 text-5xl leading-none">"</div>
            <div class="text-gray-700 leading-relaxed px-4">
                {!! $homeContent->pengantar_text !!}
            </div>
        </div>
    </div>

    <!-- Spacer agar tidak ketimpa section bawah -->
    <div class="h-16"></div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Judul Section -->
        <div class="mb-6 text-center">
            <h2 class="text-yellow-500 text-3xl font-bold">Kabar Kami</h2>
            <p class="text-gray-500 mt-1">Kabar Terbaru Tentang Kami</p>
        </div>

        <!-- Filter Unit Pendidikan -->
        <div class="flex flex-wrap justify-center gap-4">
            <button class="filter-unit-btn text-yellow-500 font-semibold border-b-2 border-yellow-500 pb-1"
                data-unit="all">Semua</button>
            @foreach ($units as $unit)
                <button class="filter-unit-btn text-gray-600 hover:text-yellow-500" data-unit="{{ $unit->slug }}">
                    {{ $unit->nama }}
                </button>
            @endforeach
        </div>

        <div class="mb-2"></div>

        <!-- Filter Kategori -->
        <div class="flex flex-wrap justify-center gap-4 mb-10 border-b pb-4">
            <button class="filter-category-btn text-yellow-500 font-semibold border-b-2 border-yellow-500 pb-1"
                data-category="all">Semua</button>
            @foreach ($categories as $category)
                <button class="filter-category-btn text-gray-600 font-semibold pb-1 hover:text-yellow-500"
                    data-category="{{ $category->slug }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Grid Artikel -->
        <div class="grid md:grid-cols-3 gap-6" id="artikel-container">
            @foreach ($artikels as $artikel)
                @php
                    $unitSlugs = $artikel->unitPendidikans->pluck('slug')->implode(',');
                @endphp
                <a href="{{ route('artikel.show', $artikel->slug) }}"
                    class="block artikel-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition"
                    data-unit="{{ $unitSlugs }}">
                    <div class="relative">
                        <img src="{{ asset($artikel->thumbnail) }}" class="w-full h-52 object-cover" alt="">
                        <span
                            class="absolute top-2 right-2 bg-yellow-300 text-black px-3 py-1 text-sm font-semibold rounded-full">
                            {{ $artikel->category->name }}
                        </span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-1">{{ $artikel->judul }}</h3>
                        <p class="text-gray-500 text-sm">
                            {{ \Carbon\Carbon::parse($artikel->created_at)->format('F d, Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="mt-20 px-4 md:px-16 bg-contain bg-center py-10 rounded-xl"
    style="background-image: url('/home/pengumuman.png');">
    <h2 class="text-2xl font-bold text-yellow-500">Pengumuman & Event</h2>
    <p class="text-gray-600 mb-6">Berikut ini adalah pengumuman dan event yang terjadi di yayasan Darussalam Batam</p>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 bg-blue-100 rounded-xl p-6">
        @forelse ($pengumuman as $item)
            <div class="bg-white rounded-xl p-4 shadow artikel-card">
                <h3 class="font-semibold text-gray-800 mb-32">
                    {{ $item->judul }}
                </h3>
                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($item->created_at)->format('F, d Y') }}
                </p>
            </div>
        @empty
            <p>Tidak ada pengumuman saat ini.</p>
        @endforelse
    </div>
</section>

<section id="galeri" class="py-16 bg-white text-center editable-section">
    <button class="edit-btn" onclick="openEditModal('galeri')">Edit Galeri</button>
    <div class="max-w-6xl mx-auto px-4">
        <p class="text-yellow-500 font-semibold tracking-widest mb-2">{{ $homeContent->galeri_title }}</p>
        <h2 class="text-3xl font-bold mb-10">{{ $homeContent->galeri_sm_title }}</h2>

        <div class="glide">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach ($galeris->chunk(4) as $chunk)
                        <li class="glide__slide">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                                @foreach ($chunk as $galeri)
                                    <a href="{{ route('galeri.show', $galeri->slug) }}"
                                        class="block relative group rounded-xl overflow-hidden shadow-lg">
                                        <img src="{{ asset('storage/' . $galeri->path_image) }}"
                                            alt="{{ $galeri->title }}"
                                            class="w-full h-[400px] object-cover transition-transform group-hover:scale-105 duration-300">
                                        <div
                                            class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-transparent to-transparent p-4 text-white">
                                            <p class="font-bold text-sm">{{ $galeri->text }}</p>
                                            <small class="text-xs">{{ $galeri->title }}</small>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Dots -->
            <div class="glide__bullets mt-6" data-glide-el="controls[nav]">
                @foreach ($galeris->chunk(4) as $index => $chunk)
                    <button class="glide__bullet w-3 h-3 rounded-full bg-gray-400 mx-1"
                        data-glide-dir="={{ $index }}"></button>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section id="galeri-video" class="py-16 bg-white text-center editable-section">
    <button class="edit-btn" onclick="openEditModal('video')">Edit Video</button>
    <div class="max-w-4xl mx-auto px-4">
        <p class="text-yellow-500 font-semibold tracking-widest mb-2">{{ $homeContent->video_title }}</p>
        <h2 class="text-3xl font-bold mb-10">{{ $homeContent->video_sm_title }}</h2>

        @foreach ($videos as $video)
            <div class="relative rounded-xl overflow-hidden shadow-lg mb-10">
                @if (Str::contains($video->path_video, 'youtube.com') || Str::contains($video->path_video, 'youtu.be'))
                    @php
                        // Extract video ID
                        preg_match(
                            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                            $video->path_video,
                            $matches,
                        );
                        $youtubeId = $matches[1] ?? null;
                    @endphp

                    @if ($youtubeId)
                        <iframe class="w-full aspect-video rounded-xl"
                            src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                            allowfullscreen></iframe>
                    @else
                        <p>Invalid YouTube URL</p>
                    @endif
                @else
                    <video class="w-full rounded-xl object-cover" controls preload="metadata"
                        poster="{{ asset('storage/' . $video->path_video) }}">
                        <source src="{{ asset('storage/' . $video->path_video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif

                <div class="mt-4">
                    <h3 class="font-semibold text-lg">{{ $video->title }}</h3>
                    <p class="text-gray-600 text-sm">{{ $video->text }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-yellow-500 mb-1">Kalender Akademik</h2>
        <p class="text-gray-500 mb-8">Berikut ini adalah kalender yayasan Darussalam Batam</p>
        <div class="flex flex-wrap justify-center gap-4 mb-6">
            <button class="filter-unit-btn text-yellow-500 font-semibold border-b-2 border-yellow-500 pb-1"
                data-unit="all">Semua</button>
            @foreach ($units as $unit)
                <button class="filter-unit-btn text-gray-600 hover:text-yellow-500" data-unit="{{ $unit->slug }}">
                    {{ $unit->nama }}
                </button>
            @endforeach
        </div>

        <div class="border p-6 rounded-md shadow-md grid grid-cols-2 gap-4">
            <!-- Kalender -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <button onclick="changeMonth(-1)" class="text-xl">&larr;</button>
                    <h3 id="calendar-month" class="text-xl font-bold"></h3>
                    <button onclick="changeMonth(1)" class="text-xl">&rarr;</button>
                </div>
                <div class="grid grid-cols-7 text-center font-semibold text-gray-400">
                    <div>Mo</div>
                    <div>Tu</div>
                    <div>We</div>
                    <div>Th</div>
                    <div>Fr</div>
                    <div>Sa</div>
                    <div>Su</div>
                </div>
                <div id="calendar-days"
                    class="grid grid-cols-7 text-center gap-y-4 mt-2 text-lg font-medium text-black">
                    <!-- Hari-hari akan di-render di sini -->
                </div>
            </div>

            <!-- Event List -->
            <div>
                <h3 class="text-xl font-bold mb-2">Event</h3>
                <ul id="event-list" class="text-left space-y-3 text-gray-700">
                    <!-- Event akan muncul di sini -->
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Edit Modals -->
<!-- Hero Modal -->
<div id="heroModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Hero Section</h2>
            <span class="close" onclick="closeModal('heroModal')">&times;</span>
        </div>
        <form id="heroForm" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label>Hero Title</label>
                <input type="text" name="hero_title" value="{{ $homeContent->hero_title }}">
            </div>
            <div class="form-group">
                <label>Hero Small Title</label>
                <input type="text" name="hero_sm_title" value="{{ $homeContent->hero_sm_title }}">
            </div>
            <div class="form-group">
                <label>Hero Text</label>
                <textarea name="hero_text" rows="4">{{ $homeContent->hero_text }}</textarea>
            </div>
            <div class="form-group">
                <label>Hero Image</label>
                <div class="media-upload-container">
                    <input type="file" 
                           name="hero_image" 
                           id="hero_image_input"
                           accept="image/jpeg,image/png,image/jpg,image/gif"
                           onchange="previewImage(this, 'heroImagePreview')">
                    <div class="current-image" id="heroImagePreview">
                        @if ($homeContent->hero_image)
                            <img src="{{ $homeContent->hero_image }}" 
                                 alt="Current Image"
                                 style="max-width: 200px; max-height: 150px; object-fit: cover;">
                            <p><small>Current: {{ basename($homeContent->hero_image) }}</small></p>
                        @else
                            <p><small>Tidak ada gambar</small></p>
                        @endif
                    </div>
                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                    <small class="text-info">📁 Disimpan di: storage/app/public/home/hero/</small>
                </div>
            </div>
            <div class="loading" id="heroLoading" style="display: none;">
                <div class="spinner"></div>
                <span>Menyimpan...</span>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-primary" onclick="saveContent('hero')">Simpan</button>
                <button type="button" class="btn-secondary" onclick="closeModal('heroModal')">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Card Modal -->
<div id="cardModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Card Section</h2>
            <span class="close" onclick="closeModal('cardModal')">&times;</span>
        </div>
        <form id="cardForm" enctype="multipart/form-data">
            <div class="form-group">
                <label>Card Title</label>
                <input type="text" name="card_title" value="{{ $homeContent->card_title }}">
            </div>
            <div class="form-group">
                <label>Card Text</label>
                <input type="text" name="card_text" value="{{ $homeContent->card_text }}">
            </div>
            <div class="loading" id="cardLoading">Menyimpan...</div>
            <button type="button" class="btn-primary" onclick="saveContent('card')">Simpan</button>
            <button type="button" class="btn-secondary" onclick="closeModal('cardModal')">Batal</button>
        </form>
    </div>
</div>

<!-- Pengantar Modal -->
<div id="pengantarModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Pengantar Section</h2>
            <span class="close" onclick="closeModal('pengantarModal')">&times;</span>
        </div>
        <form id="pengantarForm" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label>Pengantar Title</label>
                <input type="text" name="pengantar_title" value="{{ $homeContent->pengantar_title }}">
            </div>
            <div class="form-group">
                <label>Pengantar Small Title</label>
                <input type="text" name="pengantar_sm_title" value="{{ $homeContent->pengantar_sm_title }}">
            </div>
            <div class="form-group">
                <label>Pengantar Text</label>
                <div id="pengantarEditor" class="rich-editor" style="min-height: 200px;">{!! $homeContent->pengantar_text !!}</div>
                <input type="hidden" name="pengantar_text">
            </div>
            <div class="form-group">
                <label>Pengantar Image</label>
                <div class="media-upload-container">
                    <input type="file" 
                           name="pengantar_image" 
                           id="pengantar_image_input"
                           accept="image/jpeg,image/png,image/jpg,image/gif"
                           onchange="previewImage(this, 'pengantarImagePreview')">
                    <div class="current-image" id="pengantarImagePreview">
                        @if ($homeContent->pengantar_image)
                            <img src="{{ $homeContent->pengantar_image }}" 
                                 alt="Current Image"
                                 style="max-width: 200px; max-height: 150px; object-fit: cover;">
                            <p><small>Current: {{ basename($homeContent->pengantar_image) }}</small></p>
                        @else
                            <p><small>Tidak ada gambar</small></p>
                        @endif
                    </div>
                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                    <small class="text-info">📁 Disimpan di: storage/app/public/home/pengantar/</small>
                </div>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="pengantar_sm_text1" value="{{ $homeContent->pengantar_sm_text1 }}">
            </div>
            <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="pengantar_sm_text2" value="{{ $homeContent->pengantar_sm_text2 }}">
            </div>
            <div class="loading" id="pengantarLoading" style="display: none;">
                <div class="spinner"></div>
                <span>Menyimpan...</span>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-primary" onclick="saveContent('pengantar')">Simpan</button>
                <button type="button" class="btn-secondary" onclick="closeModal('pengantarModal')">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Galeri Modal -->
<div id="galeriModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Galeri Section</h2>
            <span class="close" onclick="closeModal('galeriModal')">&times;</span>
        </div>
        <form id="galeriForm" enctype="multipart/form-data">
            <div class="form-group">
                <label>Galeri Title</label>
                <input type="text" name="galeri_title" value="{{ $homeContent->galeri_title }}">
            </div>
            <div class="form-group">
                <label>Galeri Small Title</label>
                <input type="text" name="galeri_sm_title" value="{{ $homeContent->galeri_sm_title }}">
            </div>
            <div class="loading" id="galeriLoading">Menyimpan...</div>
            <button type="button" class="btn-primary" onclick="saveContent('galeri')">Simpan</button>
            <button type="button" class="btn-secondary" onclick="closeModal('galeriModal')">Batal</button>
        </form>
    </div>
</div>

<!-- Video Modal -->
<div id="videoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Video Section</h2>
            <span class="close" onclick="closeModal('videoModal')">&times;</span>
        </div>
        <form id="videoForm" enctype="multipart/form-data">
            <div class="form-group">
                <label>Video Title</label>
                <input type="text" name="video_title" value="{{ $homeContent->video_title }}">
            </div>
            <div class="form-group">
                <label>Video Small Title</label>
                <input type="text" name="video_sm_title" value="{{ $homeContent->video_sm_title }}">
            </div>
            <div class="loading" id="videoLoading">Menyimpan...</div>
            <button type="button" class="btn-primary" onclick="saveContent('video')">Simpan</button>
            <button type="button" class="btn-secondary" onclick="closeModal('videoModal')">Batal</button>
        </form>
    </div>
</div>

@if (session('show_role_modal') &&
        auth()->check() &&
        (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin')))
    <div id="roleModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full shadow-lg text-gray-800">
            <h2 class="text-lg font-semibold mb-4">Pilih Dashboard</h2>
            <p class="mb-6">Kamu login sebagai <strong>{{ auth()->user()->getRoleNames()->first() }}</strong>, pilih
                halaman yang ingin dibuka:</p>
            <div class="flex justify-end space-x-3">
                <a href="{{ route('filament.admin.pages.dashboard') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Dashboard Admin</a>
                <a href="{{ route('home.index') }}"
                    class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">Dashboard Umum</a>
            </div>
        </div>
    </div>

    <script>
        // Auto-dismiss session flag after modal shown
        fetch("{{ route('hide.role.modal') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>
@endif

<script>
    let quillEditor;

    // Toggle edit mode
    document.getElementById('editModeToggle').addEventListener('change', function() {
        const body = document.body;
        if (this.checked) {
            body.classList.add('edit-mode');
        } else {
            body.classList.remove('edit-mode');
        }
    });

    // Open edit modal
    function openEditModal(type) {
        const modal = document.getElementById(type + 'Modal');
        modal.style.display = 'block';

        // Register font whitelist dulu
        var Font = Quill.import('formats/font');
        Font.whitelist = ['arial', 'times-new-roman', 'courier', 'serif', 'sans-serif'];
        Quill.register(Font, true);

        // Register size whitelist
        var Size = Quill.import('formats/size');
        Size.whitelist = ['small', false, 'large', 'huge'];
        Quill.register(Size, true);

        if (type === 'pengantar') {
            setTimeout(() => {
                quillEditor = new Quill('#pengantarEditor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{
                                'font': Font.whitelist
                            }], // Tambah dropdown font
                            [{
                                'size': Size.whitelist
                            }], // Tambah dropdown size
                            [{
                                'header': [1, 2, 3, false]
                            }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{
                                'color': []
                            }, {
                                'background': []
                            }],
                            [{
                                'align': []
                            }],
                            ['link', 'blockquote'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            ['clean']
                        ]
                    }
                });
            }, 100);
        }
    }

    // Close modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        if (quillEditor) {
            quillEditor = null;
        }
    }

    // Tambahkan function untuk preview image
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML =
                    `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 150px;">`;
            };
            reader.readAsDataURL(file);

            console.log('File selected:', {
                name: file.name,
                size: file.size,
                type: file.type
            });
        }
    }

    // Perbaikan function saveContent
    async function saveContent(type) {
        const form = document.getElementById(type + 'Form');
        const loading = document.getElementById(type + 'Loading');
        const formData = new FormData(form);

        console.log('Saving content for type:', type);

        // Debug: log semua data form
        for (let [key, value] of formData.entries()) {
            if (value instanceof File) {
                console.log(`${key}: File - ${value.name} (${value.size} bytes)`);
            } else {
                console.log(`${key}: ${value}`);
            }
        }

        // Ambil konten dari Quill editor jika pengantar
        if (type === 'pengantar' && quillEditor) {
            const content = quillEditor.root.innerHTML;
            formData.set('pengantar_text', content);
            console.log('Quill content set:', content);
        }

        loading.style.display = 'block';

        try {
            console.log('Sending request to /home-content/update');

            const response = await fetch(`/home-content/update`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);

            const result = await response.json();
            console.log('Response data:', result);

            if (result.success) {
                alert('Konten berhasil diperbarui!');
                closeModal(type + 'Modal');

                // Reload halaman setelah delay singkat
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                let errorMessage = 'Gagal memperbarui konten: ' + (result.message || 'Unknown error');

                if (result.errors) {
                    console.error('Validation errors:', result.errors);
                    errorMessage += '\n\nDetail error:\n';
                    for (const [field, messages] of Object.entries(result.errors)) {
                        errorMessage += `${field}: ${messages.join(', ')}\n`;
                    }
                }

                alert(errorMessage);
            }
        } catch (error) {
            console.error('Network/Parse Error:', error);
            alert('Terjadi kesalahan jaringan. Silakan periksa koneksi internet dan coba lagi.\nDetail: ' + error
                .message);
        } finally {
            loading.style.display = 'none';
        }
    }


    // Close modal when clicking outside
    window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
                if (quillEditor) {
                    quillEditor = null;
                }
            }
        });
    }

    // Existing calendar code
    const allEvents = @json($calendars);
    let currentDate = new Date();
    let filteredEvents = allEvents;

    function stripTime(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }

    function filterByUnitSlug(slug) {
        document.querySelectorAll('.filter-unit-btn').forEach(btn => {
            btn.classList.remove('text-yellow-500', 'font-semibold', 'border-b-2', 'border-yellow-500', 'pb-1');
            btn.classList.add('text-gray-600');
        });

        const activeBtn = document.querySelector(`.filter-unit-btn[data-unit="${slug}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('text-gray-600');
            activeBtn.classList.add('text-yellow-500', 'font-semibold', 'border-b-2', 'border-yellow-500', 'pb-1');
        }

        filteredEvents = slug === 'all' ?
            allEvents :
            allEvents.filter(e => e.unit_pendidikan?.slug === slug);

        renderCalendar();
    }

    function renderCalendar() {
        const monthEl = document.getElementById('calendar-month');
        const daysEl = document.getElementById('calendar-days');
        const eventList = document.getElementById('event-list');
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDay = (firstDay.getDay() + 6) % 7;

        daysEl.innerHTML = '';
        monthEl.textContent = currentDate.toLocaleString('default', {
            month: 'long',
            year: 'numeric'
        });

        for (let i = 0; i < startDay; i++) {
            daysEl.innerHTML += `<div></div>`;
        }

        for (let d = 1; d <= lastDay.getDate(); d++) {
            const current = stripTime(new Date(year, month, d));

            const hasEvent = filteredEvents.some(e => {
                const start = stripTime(new Date(e.start_date));
                const end = stripTime(new Date(e.end_date || e.start_date));
                return current >= start && current <= end;
            });

            daysEl.innerHTML += `<div class="${hasEvent ? 'text-yellow-500 font-bold' : ''}">${d}</div>`;
        }

        const thisMonth = `${year}-${(month + 1).toString().padStart(2, '0')}`;
        const thisMonthEvents = filteredEvents.filter(e => e.start_date.startsWith(thisMonth));

        eventList.innerHTML = thisMonthEvents.length ?
            thisMonthEvents.map(e =>
                `<li><strong>${e.title}</strong><br><small>${e.start_date}${e.end_date ? ' – ' + e.end_date : ''}</small></li>`
            ).join('') :
            '<li class="text-gray-400">Tidak ada event</li>';
    }

    function changeMonth(offset) {
        currentDate.setMonth(currentDate.getMonth() + offset);
        renderCalendar();
    }

    // Initialize calendar and filters
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.filter-unit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const unitSlug = btn.getAttribute('data-unit');
                filterByUnitSlug(unitSlug);
            });
        });

        filterByUnitSlug('all');
    });
</script>
