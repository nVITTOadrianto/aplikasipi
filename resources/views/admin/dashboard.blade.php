@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h1 class="mb-4 fw-bold">Dashboard</h1>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between" style="min-height: 9rem;">
                        <div class="fs-5">
                            <i class="bi bi-envelope-arrow-down"></i>
                            Surat Masuk
                        </div>
                        <div class="fw-bold fs-1">
                            {{ $suratMasukCount }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between" style="min-height: 9rem;">
                        <div class="fs-5">
                            <i class="bi bi-envelope-arrow-up"></i>
                            Surat Keluar
                        </div>
                        <div class="fw-bold fs-1">
                            {{ $suratKeluarCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
