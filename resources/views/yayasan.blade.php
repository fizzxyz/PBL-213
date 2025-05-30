@extends('layouts.home')

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<section style="padding: 200px 20px; background: url('home/yayasan/background.png') center/cover no-repeat; color: white; text-align: center;">
    <h1 style="font-size: 2.5em; font-weight: bold; color: #FFD700;">Tentang Yayasan {{ $yayasan->name }}</h1>
</section>

<section style="padding: 80px 90px; max-width margin: auto;">
    <p style="color: #f9b934; font-size: 1.5rem; font-weight: 600; margin-bottom: 8px;">Sejarah Yayasan</p>
    <p style="color: gray; margin-bottom: 30px;">Berikut ini adalah sejarah Yayasan Darussalam Batam</p>

    <div style="margin-bottom: 60px;">
        {!! $yayasan->sejarah !!}
    </div>
</section>

<section style="position: relative; background: url('{{ asset('home/yayasan/background3.png') }}') center/cover no-repeat; padding: 100px 20px;">
    <!-- Overlay abu-abu transparan -->
    <div style="position: absolute; inset: 0; background-color: rgba(128, 128, 128, 0.588); z-index: 1;"></div>

    <div style="position: relative; z-index: 2; max-width: 1000px; margin: auto;">
        <h2 style="text-align: center; font-size: 2rem; margin-bottom: 40px;">
            <span style="color: #c7a003; font-weight: 600;">VISI</span>
            <span style="color: #1e3a8a; font-weight: 600;">& MISI</span>
        </h2>

        <!-- Render HTML dari rich text editor -->
        <div style="font-size: 1.3rem; color: #000; font-weight: bold;">
            {!! $yayasan->vision !!}
        </div>
    </div>
</section>


<!-- Tentang Yayasan Section -->
<section style="margin-top: 100px">
    <div style="margin: 0 auto; position: relative; z-index: 2; padding: 80px 90px;
    background: url('home/yayasan/background2.png') center top / contain no-repeat;
    background-repeat: no-repeat;
    background-position: top center;
    background-size: contain;
    min-height: 980px;
    position: relative;">
        <h2 style="font-size: 2rem; font-weight: bold; color: #1a1a1a; margin-bottom: 40px; text-align: left;">
            Tentang Yayasan
        </h2>

        <div style="color: #333; line-height: 1.8; font-size: 1rem; text-align: justify;">
            {!! $yayasan->tentang !!}
        </div>
    </div>
</section>