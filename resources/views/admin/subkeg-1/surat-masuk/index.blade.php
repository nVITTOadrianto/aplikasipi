@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h4>Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat ></h4>
        <h1 class="mb-4 fw-bold">Surat Masuk</h1>
        @session('success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endsession
        <div class="mb-3">
            <a href="{{ route('subkeg-1.surat-masuk.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tambah Surat Masuk
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('subkeg-1.surat-masuk.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="search" class="form-label">Cari (Pengirim/Perihal)</label>
                                <input type="text" class="form-control" id="search" name="search" value="{{ $search ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('subkeg-1.surat-masuk.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-striped mt-3">
            <thead>
                <tr scope="col">
                    <th>No</th>
                    <th>Surat Dari</th>
                    <th>No. Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Tanggal Diterima</th>
                    <th>No. Agenda</th>
                    <th>Sifat</th>
                    <th>Perihal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suratSuratMasuk as $surat)
                    <tr>
                        <td scope="col">{{ $loop->iteration }}</td>
                        <td>{{ $surat->pengirim }}</td>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->tanggal_surat }}</td>
                        <td>{{ $surat->tanggal_diterima }}</td>
                        <td>{{ $surat->nomor_agenda }}</td>
                        <td>{{ $surat->sifat }}</td>
                        <td>{{ $surat->perihal }}</td>
                        <td class="align-middle">
                            <div class="d-flex gap-1">
                                <a href="{{ route('subkeg-1.surat-masuk.show', $surat->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('subkeg-1.surat-masuk.edit', $surat->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('subkeg-1.surat-masuk.destroy', $surat->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $suratSuratMasuk->appends(request()->query())->links() }}
        </div>
    </main>
@endsection
