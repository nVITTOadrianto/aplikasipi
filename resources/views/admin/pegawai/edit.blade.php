@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h1 class="mb-4 fw-bold">Edit Data Pegawai</h1>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('pegawai.update', $pegawai->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip"
                    value="{{ old('nip', $pegawai->nip) }}">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama" name="nama"
                    value="{{ old('nama', $pegawai->nama) }}" required>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                        value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}" required>
                </div>
                <div class="col">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir->format('Y-m-d')) }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <label for="golongan" class="form-label">Golongan</label>
                    <select class="form-control" id="golongan" name="golongan">
                        <option value="" disabled {{ old('golongan', $pegawai->golongan) ? '' : 'selected' }}>-- Pilih
                            --</option>
                        <option value="I" {{ old('golongan', $pegawai->golongan) == 'I' ? 'selected' : '' }}>I</option>
                        <option value="II" {{ old('golongan', $pegawai->golongan) == 'II' ? 'selected' : '' }}>II
                        </option>
                        <option value="III" {{ old('golongan', $pegawai->golongan) == 'III' ? 'selected' : '' }}>III
                        </option>
                        <option value="IV" {{ old('golongan', $pegawai->golongan) == 'IV' ? 'selected' : '' }}>IV
                        </option>
                        <option value="V" {{ old('golongan', $pegawai->golongan) == 'V' ? 'selected' : '' }}>V
                        </option>
                        <option value="VII" {{ old('golongan', $pegawai->golongan) == 'VII' ? 'selected' : '' }}>VII
                        </option>
                        <option value="IX" {{ old('golongan', $pegawai->golongan) == 'IX' ? 'selected' : '' }}>IX
                        </option>
                    </select>
                </div>
                <div class="col-3" id="ruang-wrapper">
                    <label for="ruang" class="form-label">Ruang</label>
                    <select class="form-control" id="ruang" name="ruang">
                        <option value="" disabled {{ old('ruang', $pegawai->ruang) ? '' : 'selected' }}>-- Pilih --
                        </option>
                        <option value="a" {{ old('ruang', $pegawai->ruang) == 'a' ? 'selected' : '' }}>a</option>
                        <option value="b" {{ old('ruang', $pegawai->ruang) == 'b' ? 'selected' : '' }}>b</option>
                        <option value="c" {{ old('ruang', $pegawai->ruang) == 'c' ? 'selected' : '' }}>c</option>
                        <option value="d" {{ old('ruang', $pegawai->ruang) == 'd' ? 'selected' : '' }}>d</option>
                        <option value="e" id="ruang_e" style="display: none;"
                            {{ old('ruang', $pegawai->ruang) == 'e' ? 'selected' : '' }}>e</option>
                    </select>
                </div>
                <div class="col-6" id="pangkat-wrapper">
                    <label for="pangkat" class="form-label">Pangkat</label>
                    <input type="text" class="form-control" id="pangkat" name="pangkat"
                        value="{{ old('pangkat', $pegawai->pangkat) }}" placeholder="Akan terisi otomatis..." readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="jabatan" name="jabatan"
                    value="{{ old('jabatan', $pegawai->jabatan) }}" required>
            </div>
            <div class="mb-3">
                <label for="jabatan_ttd" class="form-label">Jabatan untuk Tanda Tangan</label>
                <input type="text" class="form-control" id="jabatan_ttd" name="jabatan_ttd"
                    value="{{ old('jabatan_ttd', $pegawai->jabatan_ttd) }}">
            </div>
            <div class="mb-3">
                <p class="text-danger">*wajib diisi</p>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua elemen yang kita butuhkan
            const golonganSelect = document.getElementById('golongan');
            const ruangSelect = document.getElementById('ruang');
            const pangkatInput = document.getElementById('pangkat');
            const ruangEOption = document.getElementById('ruang_e');

            // REKOMENDASI: Bungkus elemen <label> dan <select> untuk "ruang" dalam satu div
            // Contoh: <div id="ruang-wrapper"> ... label dan select ... </div>
            // Ini akan menyembunyikan label dan inputnya sekaligus.
            const ruangWrapper = document.getElementById('ruang-wrapper') ||
            ruangSelect; // Fallback jika wrapper tidak ada

            const pangkatWrapper = document.getElementById('pangkat-wrapper') ||
            pangkatInput; // Fallback jika wrapper tidak ada

            // Data mapping LENGKAP dari Golongan/Ruang ke Pangkat
            const pangkatMap = {
                "I/a": "Juru Muda",
                "I/b": "Juru Muda Tingkat I",
                "I/c": "Juru",
                "I/d": "Juru Tingkat I",
                "II/a": "Pengatur Muda",
                "II/b": "Pengatur Muda Tingkat I",
                "II/c": "Pengatur",
                "II/d": "Pengatur Tingkat I",
                "III/a": "Penata Muda",
                "III/b": "Penata Muda Tingkat I",
                "III/c": "Penata",
                "III/d": "Penata Tingkat I",
                "IV/a": "Pembina",
                "IV/b": "Pembina Tingkat I",
                "IV/c": "Pembina Utama Muda",
                "IV/d": "Pembina Utama Madya",
                "IV/e": "Pembina Utama",
                // Mapping untuk PPPK ditambahkan di sini
                "V": "PPPK",
                "VII": "PPPK",
                "IX": "PPPK"
            };

            // Buat daftar golongan khusus untuk PPPK agar kode lebih rapi
            const pppkGolongan = ['V', 'VII', 'IX'];

            // 1. Fungsi untuk memperbarui Pangkat (DIMODIFIKASI)
            function updatePangkat() {
                const selectedGolongan = golonganSelect.value;
                const selectedRuang = ruangSelect.value;
                let key = ''; // Kunci untuk mencari di pangkatMap

                // Cek apakah golongan yang dipilih adalah untuk PPPK
                if (pppkGolongan.includes(selectedGolongan)) {
                    key = selectedGolongan; // Jika ya, kunci hanya dari golongan
                }
                // Jika bukan PPPK, pastikan ruang juga sudah dipilih
                else if (selectedGolongan && selectedRuang) {
                    key = `${selectedGolongan}/${selectedRuang}`; // Jika tidak, kunci adalah gabungan
                }

                // Atur nilai pangkat berdasarkan kunci, atau kosongkan jika tidak cocok
                pangkatInput.value = pangkatMap[key] || '';
            }

            // 2. Event listener untuk dropdown Golongan (DIMODIFIKASI)
            golonganSelect.addEventListener('change', function() {
                const selectedGolongan = this.value;

                // Cek apakah golongan yang dipilih adalah untuk PPPK
                if (pppkGolongan.includes(selectedGolongan)) {
                    // Sembunyikan dropdown Ruang dan reset nilainya
                    ruangWrapper.style.display = 'none';
                    pangkatWrapper.classList.remove('col-6');
                    pangkatWrapper.classList.add('col-9');
                    ruangSelect.value = '';
                } else {
                    // Tampilkan kembali dropdown Ruang untuk golongan PNS
                    ruangWrapper.style.display = 'block';
                    pangkatWrapper.classList.remove('col-9');
                    pangkatWrapper.classList.add('col-6');

                    // Logika khusus untuk menampilkan Ruang 'e' pada Golongan IV
                    if (selectedGolongan === 'IV') {
                        ruangEOption.style.display = 'block';
                    } else {
                        ruangEOption.style.display = 'none';
                        // Jika ruang 'e' sedang terpilih saat golongan diubah, reset pilihannya
                        if (ruangSelect.value === 'e') {
                            ruangSelect.value = '';
                        }
                    }
                }

                // Panggil fungsi update pangkat setiap kali golongan berubah
                updatePangkat();
            });

            // 3. Event listener untuk dropdown Ruang (TETAP SAMA)
            ruangSelect.addEventListener('change', function() {
                updatePangkat();
            });

            // --- Inisialisasi Kondisi Awal Saat Halaman Dimuat (KHUSUS HALAMAN EDIT) ---
            // Pemicu event 'change' pada golonganSelect akan menjalankan semua logika
            // (menyembunyikan/menampilkan ruang dan mengisi pangkat) secara otomatis.
            // Ini lebih efektif daripada kode inisialisasi yang sebelumnya.
            if (golonganSelect.value) {
                golonganSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
