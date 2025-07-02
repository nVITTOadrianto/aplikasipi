@extends('layouts.app')

@section('content')
@include('layouts.header')
<div class="py-5">
    <img src="{{asset('logo_pi.png')}}" alt="Logo Pemberdayaan Industri" class="img-fluid mx-auto d-block mt-5" style="width: 256px; height: auto;">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="fw-bold display-4">Aplikasi Arsip Surat Digital Bidang Pemberdayaan Industri</h1>
            <p class="fw-semibold lead">Dinas Perindustrian dan Perdagangan Provinsi Lampung</p>
            <p class="text-center">Aplikasi ini dirancang untuk mempermudah pengelolaan arsip surat masuk dan keluar di Bidang Pemberdayaan Industri. Dengan sistem ini, Anda dapat mengakses berbagai fitur seperti pengelolaan dokumen, laporan, dan informasi terkait arsip surat dengan mudah dan efisien.</p>
            <p class="text-center">Untuk memulai, silakan masuk ke akun Anda dengan mengklik tombol di bawah ini.</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-3">
                <i class="bi bi-box-arrow-in-right"></i>
                Masuk Dashboard
            </a>
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection
