@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h1 class="mb-4 fw-bold">Tambah Data Pegawai Baru</h1>
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
        <h4 class="mb-4">Impor dari Excel</h4>
        <form action="{{ route('pegawai.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file_excel" class="form-label">Impor File<span class="text-danger">*</span></label>
                <input type="file" class="form-control" id="file_excel" name="file_excel" accept=".xls,.xlsx,.csv"
                    aria-describedby="fileHelp" required>
                <div id="fileHelp" class="form-text">File yang didukung: .xls .xlsx .csv (Maks. 5 MB)</div>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Impor Excel</button>
        </form>
        <h6 class="mb-4">Atau</h6>
        <h4 class="mb-4">Isi Form Data</h4>
        <form action="{{ route('pegawai.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                </div>
                <div class="col">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>
            </div>
            <div class="row mb-3">
                {{-- Kolom untuk Golongan --}}
                <div class="col-3">
                    <label for="golongan" class="form-label">Golongan</label>
                    <select class="form-control" id="golongan" name="golongan">
                        <option value="" disabled selected>-- Pilih --</option>
                        <option value="I">I</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                        <option value="VII">VII</option>
                        <option value="IX">IX</option>
                    </select>
                </div>

                {{-- Kolom untuk Ruang --}}
                <div class="col-3" id="ruang-wrapper">
                    <label for="ruang" class="form-label">Ruang</label>
                    <select class="form-control" id="ruang" name="ruang">
                        <option value="" disabled selected>-- Pilih --</option>
                        <option value="a">a</option>
                        <option value="b">b</option>
                        <option value="c">c</option>
                        <option value="d">d</option>
                        {{-- Opsi 'e' hanya untuk Golongan IV, kita akan atur dengan JS --}}
                        <option value="e" id="ruang_e" style="display: none;">e</option>
                    </select>
                </div>
                <div class="col-6">
                    <label for="pangkat" class="form-label">Pangkat</label>
                    <input type="text" class="form-control" id="pangkat" name="pangkat"
                        placeholder="Akan terisi otomatis..." readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
            </div>
            <div class="mb-3">
                <label for="jabatan_ttd" class="form-label">Jabatan untuk Tanda Tangan</label>
                <input type="text" class="form-control" id="jabatan_ttd" name="jabatan_ttd">
            </div>
            <div class="mb-3">
                <p class="text-danger">*wajib diisi</p>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
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

            // Untuk hasil terbaik, bungkus elemen <label> dan <select> untuk "ruang" dalam satu div.
            // Contoh: <div id="ruang-wrapper"> ... label dan select ... </div>
            const ruangWrapper = document.getElementById('ruang-wrapper') ||
            ruangSelect; // Fallback ke select jika wrapper tidak ada

            const pangkatWrapper = document.getElementById('pangkat-wrapper') ||
            pangkatInput; // Fallback jika wrapper tidak ada

            // Data mapping dari Golongan/Ruang ke Pangkat
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
                // Mapping untuk PPPK, hanya menggunakan Golongan sebagai kunci
                "V": "PPPK",
                "VII": "PPPK",
                "IX": "PPPK"
            };

            // Daftar golongan khusus untuk PPPK
            const pppkGolongan = ['V', 'VII', 'IX'];

            // 1. Fungsi untuk memperbarui Pangkat (DIMODIFIKASI)
            function updatePangkat() {
                const selectedGolongan = golonganSelect.value;
                const selectedRuang = ruangSelect.value;
                let key = '';

                // Cek apakah golongan yang dipilih adalah untuk PPPK
                if (pppkGolongan.includes(selectedGolongan)) {
                    key = selectedGolongan; // Kunci map hanya dari golongan
                }
                // Untuk golongan selain PPPK, pastikan ruang sudah dipilih
                else if (selectedGolongan && selectedRuang) {
                    key = `${selectedGolongan}/${selectedRuang}`; // Kunci map dari gabungan golongan dan ruang
                }

                // Atur nilai pangkat berdasarkan kunci, atau kosongkan jika tidak ada
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
                        // Jika ruang 'e' sedang terpilih, reset pilihannya
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
                // Panggil fungsi update pangkat setiap kali ruang berubah
                updatePangkat();
            });


            // --- KHUSUS UNTUK HALAMAN EDIT ---
            // Panggil event 'change' pada golonganSelect untuk mengatur kondisi awal halaman
            // Ini akan secara otomatis menjalankan semua logika di atas saat halaman dimuat
            if (golonganSelect.value) {
                golonganSelect.dispatchEvent(new Event('change'));
            }

        });
    </script>
@endsection
