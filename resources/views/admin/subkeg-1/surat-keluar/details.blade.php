@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h4>Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat ></h4>
        <h1 class="mb-4 fw-bold">Detail Surat Keluar</h1>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Surat Kepada: {{ $suratKeluar->penerima }}</h5>
                <p class="card-text"><strong>Nomor Surat:</strong> {{ $suratKeluar->nomor_surat }}</p>
                <p class="card-text"><strong>Tanggal Surat:</strong> {{ $suratKeluar->tanggal_surat->isoFormat('D MMMM YYYY') }}</p>
                <p class="card-text"><strong>Perihal:</strong> {{ $suratKeluar->perihal }}</p>
                <p class="card-text"><strong>Sifat Surat:</strong> {{ $suratKeluar->sifat }}</p>
                @if ($suratKeluar->file_surat)
                    <p class="card-text"><strong>File Surat:</strong><a
                            href="{{ storage_path('app/public/uploads/surat_keluar/' . $suratKeluar->file_surat) }}"
                            target="_blank" class="btn btn-primary"><i class="bi bi-eye me-2"></i>Lihat File</a></p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('subkeg-1.surat-keluar.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </main>
@endsection
