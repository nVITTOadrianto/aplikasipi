@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h1 class="mb-4 fw-bold">Surat Keluar</h1>
        @session('success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endsession
        <div class="mb-3">
            <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Surat Keluar
            </a>
        </div>
        <table class="table table-striped mt-3">
            <thead>
                <tr scope="col">
                    <th>No</th>
                    <th>Surat Kepada</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Perihal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suratSuratKeluar as $surat)
                    <tr>
                        <td scope="col">{{ $loop->iteration }}</td>
                        <td>{{ $surat->penerima }}</td>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->tanggal_surat }}</td>
                        <td>{{ $surat->perihal }}</td>
                        <td class="align-middle">
                            <div class="d-flex gap-1">
                                <a href="{{ route('surat-keluar.show', $surat->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('surat-keluar.edit', $surat->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('surat-keluar.destroy', $surat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection
