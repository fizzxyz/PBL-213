@extends('layouts.home')

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Hero Section -->
<section style="padding: 150px 20px 100px; background: linear-gradient(135deg, rgba(238, 255, 1, 0.208), rgba(247, 255, 4, 0.515)), url({{ asset('storage/' . $unit->image) }}) center/cover no-repeat; color: white; text-align: center;">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">{{ $unit->nama }}</h1>
    </div>
</section>

<!-- Main Content Section -->
<section class="relative -mt-16 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- About Unit Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12">
            <!-- Header with Logo -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-6 md:px-8 py-6">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $unit->logo) }}" alt="Logo Unit" class="w-16 h-16 md:w-20 md:h-20 rounded-xl shadow-lg border-4 border-white">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                            Tentang Unit Pendidikan {{ $unit->nama }}
                        </h2>
                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                            <div class="flex items-center gap-2 bg-white px-3 py-1 rounded-full shadow-sm">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-medium">{{ $unit->alamat }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 md:px-8 py-8">
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! $unit->about !!}
                </div>
            </div>
        </div>

        <!-- Vision & Mission Section -->
        <div class="grid lg:grid-cols-2 gap-8">

            <!-- Vision Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-xl overflow-hidden text-white transform hover:scale-105 transition-all duration-300">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="bg-white bg-opacity-20 p-3 rounded-xl mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold">Visi</h3>
                    </div>
                    <div class="bg-white bg-opacity-10 rounded-xl p-6 backdrop-blur-sm">
                        <div class="prose prose-lg prose-invert max-w-none">
                            {!! $unit->visi !!}
                        </div>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white bg-opacity-5 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white bg-opacity-5 rounded-full -ml-12 -mb-12"></div>
            </div>

            <!-- Mission Card -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl shadow-xl overflow-hidden text-white transform hover:scale-105 transition-all duration-300">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="bg-white bg-opacity-20 p-3 rounded-xl mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold">Misi</h3>
                    </div>
                    <div class="bg-white bg-opacity-10 rounded-xl p-6 backdrop-blur-sm">
                        <div class="prose prose-lg prose-invert max-w-none">
                            {!! $unit->misi !!}
                        </div>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white bg-opacity-5 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white bg-opacity-5 rounded-full -ml-12 -mb-12"></div>
            </div>
        </div>

        <!-- Additional Info Cards (Optional) -->
        <div class="grid md:grid-cols-3 gap-6 mt-12">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow duration-300">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Prestasi Akademik</h4>
                <p class="text-sm text-gray-600">Berbagai pencapaian dalam bidang akademik</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow duration-300">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Ekstrakurikuler</h4>
                <p class="text-sm text-gray-600">Kegiatan pengembangan bakat dan minat siswa</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow duration-300">
                <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Fasilitas Lengkap</h4>
                <p class="text-sm text-gray-600">Sarana dan prasarana pendukung pembelajaran</p>
            </div>
        </div>
    </div>
</section>

<style>
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: inherit;
        font-weight: 600;
    }

    .prose-invert h1, .prose-invert h2, .prose-invert h3, .prose-invert h4, .prose-invert h5, .prose-invert h6 {
        color: white;
    }

    .prose p {
        margin-bottom: 1rem;
        line-height: 1.7;
    }

    .prose ul, .prose ol {
        margin: 1rem 0;
    }

    .prose li {
        margin: 0.5rem 0;
    }
</style>