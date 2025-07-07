@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h1 class="mb-4 fw-bold">Dashboard</h1>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between" style="min-height: 9rem;">
                        <div class="fs-5">
                            <i class="bi bi-folder"></i>
                            Koordinasi, Sinkronisasi, dan Pelaksanaan
                        </div>
                        <div class="fw-bold fs-1">
                            <i class="bi bi-envelope-arrow-down"></i>
                            {{ $suratMasuk1Count }}
                            <i class="bi bi-envelope-arrow-up"></i>
                            {{ $suratKeluar1Count }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between" style="min-height: 9rem;">
                        <div class="fs-5">
                            <i class="bi bi-collection"></i>
                            Lain-Lain
                        </div>
                        <div class="fw-bold fs-1">
                            <i class="bi bi-envelope-arrow-down"></i>
                            {{ $suratMasukLainCount }}
                            <i class="bi bi-envelope-arrow-up"></i>
                            {{ $suratKeluarLainCount }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between" style="min-height: 9rem;">
                        <div class="fs-5">
                            <i class="bi bi-mailbox"></i>
                            Semua Subkegiatan
                        </div>
                        <div class="fw-bold fs-1">
                            <i class="bi bi-envelope-arrow-down"></i>
                            {{ $suratMasukTotal }}
                            <i class="bi bi-envelope-arrow-up"></i>
                            {{ $suratKeluarTotal }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex p-5">
                <img src="{{asset('logo_pi.png')}}" alt="Logo Pemberdayaan Industri" width="125px">
                <div class="ms-5">
                    <h1>Halo, <span class="fw-bold">{{auth()->user()->name}}</span>!</h1>
                    <h5>Selamat Datang di <span class="fw-bold">Aplikasi Arsip Digital Surat Bidang Pemberdayaan Industri</span></h5>
                    <h6>Dinas Perindustrian dan Perdagangan Provinsi Lampung</h6>
                </div>
            </div>
        </div>
    </main>
@endsection
