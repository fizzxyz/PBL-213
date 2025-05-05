@extends('layouts.home')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-4">{{ $galeri->title }}</h1>
    <img src="{{ asset('storage/' . $galeri->path_image) }}" alt="{{ $galeri->title }}" class="w-full rounded-lg mb-6">
    <p class="text-lg text-gray-700">{{ $galeri->text }}</p>
</div>
@endsection
