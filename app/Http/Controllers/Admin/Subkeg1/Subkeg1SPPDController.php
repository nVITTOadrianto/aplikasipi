<?php

namespace App\Http\Controllers\Admin\Subkeg1;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\RincianBiayaSPPD;
use App\Models\SPPD;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Subkeg1SPPDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil input dari form pencarian
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query dasar
        $query = SPPD::query()->where('sub_kegiatan', 'Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat');

        // Filter berdasarkan maksud atau tempat tujuan
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('maksud', 'like', "%{$search}%")
                    ->orWhere('tempat_tujuan', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan rentang tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_dibuat_surat', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('tanggal_dibuat_surat', $startDate);
        }

        // Ambil data dengan paginasi
        $sppdSppd = $query->orderBy("created_at", "desc")->paginate(10);

        return view('admin.subkeg-1.sppd.index', compact('sppdSppd', 'search', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $pegawai = Pegawai::all();
        return view('admin.subkeg-1.sppd.create', compact('pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'sub_kegiatan' => 'required|string',
            'lembar' => 'nullable|integer',
            'kode' => 'nullable|integer',
            'nomor_surat' => 'nullable|string|max:20',
            'pegawai_pemberi_wewenang' => 'required|exists:pegawai,id',
            'pegawai_pelaksana' => 'required|exists:pegawai,id',
            'tingkat_biaya' => 'required|string|max:1',
            'maksud' => 'required|string|max:255',
            'alat_angkut' => 'required|string|max:50',
            'tempat_berangkat' => 'required|string|max:50',
            'tempat_kedudukan' => 'nullable|string|max:50',
            'tempat_tujuan' => 'required|string|max:50',
            'jumlah_hari' => 'required|integer',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'pegawai_pengikut_1' => 'nullable|exists:pegawai,id',
            'pegawai_pengikut_2' => 'nullable|exists:pegawai,id',
            'pegawai_pengikut_3' => 'nullable|exists:pegawai,id',
            'instansi_pembebanan_anggaran' => 'required|string',
            'akun_pembebanan_anggaran' => 'required|string',
            'keterangan' => 'nullable|string',
            'tanggal_dibuat_surat' => 'required|date',
            'tanggal_tiba' => 'nullable|date',
            'pegawai_mengetahui' => 'nullable|exists:pegawai,id',
            'kepala_jabatan_di_tempat' => 'nullable|string|max:50',
            'nama_di_tempat' => 'nullable|string|max:50',
            'nip_di_tempat' => 'nullable|string|max:30',
            'biaya_pergi' => 'nullable|numeric',
            'biaya_pulang' => 'nullable|numeric',
            'menginap' => 'nullable|boolean',
            'jumlah_hari_penginapan' => 'nullable|integer',
            'biaya_penginapan_4' => 'nullable|numeric',
            'biaya_penginapan_3' => 'nullable|numeric',
            'biaya_penginapan_2' => 'nullable|numeric',
            'biaya_penginapan_1' => 'nullable|numeric',
            'uang_harian' => 'nullable|numeric',
            'keterangan_penerbangan' => 'nullable|string',
            'keterangan_tol' => 'nullable|string',
            'keterangan_lain' => 'nullable|string',
            'biaya_penerbangan' => 'nullable|numeric',
            'biaya_tol' => 'nullable|numeric',
            'biaya_lain' => 'nullable|numeric',
            'pegawai_bendahara' => 'nullable|exists:pegawai,id',
        ],[
            'sub_kegiatan.required' => 'Sub kegiatan wajib diisi.',
            'lembar.integer' => 'Lembar harus berupa angka.',
            'kode.integer' => 'Kode harus berupa angka.',
            'nomor_surat.max' => 'Nomor surat maksimal 20 karakter.',
            'pegawai_pemberi_wewenang.required' => 'Pegawai pemberi wewenang wajib dipilih.',
            'pegawai_pemberi_wewenang.exists' => 'Pegawai pemberi wewenang tidak ditemukan.',
            'pegawai_pelaksana.required' => 'Pegawai pelaksana wajib dipilih.',
            'pegawai_pelaksana.exists' => 'Pegawai pelaksana tidak ditemukan.',
            'tingkat_biaya.required' => 'Tingkat biaya wajib diisi.',
            'tingkat_biaya.max' => 'Tingkat biaya maksimal 1 karakter.',
            'maksud.required' => 'Maksud perjalanan wajib diisi.',
            'maksud.max' => 'Maksud perjalanan maksimal 255 karakter.',
            'alat_angkut.required' => 'Alat angkut wajib diisi.',
            'alat_angkut.max' => 'Alat angkut maksimal 50 karakter.',
            'tempat_berangkat.required' => 'Tempat berangkat wajib diisi.',
            'tempat_berangkat.max' => 'Tempat berangkat maksimal 50 karakter.',
            'tempat_kedudukan.max' => 'Tempat kedudukan maksimal 50 karakter.',
            'tempat_tujuan.required' => 'Tempat tujuan wajib diisi.',
            'tempat_tujuan.max' => 'Tempat tujuan maksimal 50 karakter.',
            'jumlah_hari.required' => 'Jumlah hari wajib diisi.',
            'jumlah_hari.integer' => 'Jumlah hari harus berupa angka.',
            'tanggal_berangkat.required' => 'Tanggal berangkat wajib diisi.',
            'tanggal_berangkat.date' => 'Tanggal berangkat tidak valid.',
            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.date' => 'Tanggal kembali tidak valid.',
            'pegawai_pengikut_1.exists' => 'Pegawai pengikut 1 tidak ditemukan.',
            'pegawai_pengikut_2.exists' => 'Pegawai pengikut 2 tidak ditemukan.',
            'pegawai_pengikut_3.exists' => 'Pegawai pengikut 3 tidak ditemukan.',
            'instansi_pembebanan_anggaran.required' => 'Instansi pembebanan anggaran wajib diisi.',
            'akun_pembebanan_anggaran.required' => 'Akun pembebanan anggaran wajib diisi.',
            'tanggal_dibuat_surat.required' => 'Tanggal dibuat surat wajib diisi.',
            'tanggal_dibuat_surat.date' => 'Tanggal dibuat surat tidak valid.',
            'tanggal_tiba.date' => 'Tanggal tiba tidak valid.',
            'pegawai_mengetahui.exists' => 'Pegawai mengetahui tidak ditemukan.',
            'kepala_jabatan_di_tempat.max' => 'Kepala jabatan di tempat maksimal 50 karakter.',
            'nama_di_tempat.max' => 'Nama di tempat maksimal 50 karakter.',
            'nip_di_tempat.max' => 'NIP di tempat maksimal 30 karakter.',
            'biaya_pergi.numeric' => 'Biaya pergi harus berupa angka.',
            'biaya_pulang.numeric' => 'Biaya pulang harus berupa angka.',
            'menginap.boolean' => 'Menginap harus berupa nilai benar/salah.',
            'jumlah_hari_penginapan.integer' => 'Jumlah hari penginapan harus berupa angka.',
            'biaya_penginapan_4.numeric' => 'Biaya penginapan golongan IV harus berupa angka.',
            'biaya_penginapan_3.numeric' => 'Biaya penginapan golongan III harus berupa angka.',
            'biaya_penginapan_2.numeric' => 'Biaya penginapan golongan II harus berupa angka.',
            'biaya_penginapan_1.numeric' => 'Biaya penginapan golongan I harus berupa angka.',
            'uang_harian.numeric' => 'Uang harian harus berupa angka.',
            'biaya_penerbangan.numeric' => 'Biaya penerbangan harus berupa angka.',
            'biaya_tol.numeric' => 'Biaya tol harus berupa angka.',
            'biaya_lain.numeric' => 'Biaya lain harus berupa angka.',
            'pegawai_bendahara.exists' => 'Pegawai bendahara tidak ditemukan.',
        ]);
        $sppd = SPPD::create($request->except([
            'biaya_pergi',
            'biaya_pulang',
            'menginap',
            'jumlah_hari_penginapan',
            'biaya_penginapan_4',
            'biaya_penginapan_3',
            'biaya_penginapan_2',
            'biaya_penginapan_1',
            'uang_harian',
            'keterangan_penerbangan',
            'keterangan_tol',
            'keterangan_lain',
            'biaya_penerbangan',
            'biaya_tol',
            'biaya_lain',
            'pegawai_bendahara'
        ]));

        $rincianBiaya = RincianBiayaSPPD::create([
            'id_sppd' => $sppd->id,
            'biaya_pergi' => $request->biaya_pergi,
            'biaya_pulang' => $request->biaya_pulang,
            'menginap' => $request->menginap,
            'jumlah_hari_penginapan' => $request->jumlah_hari_penginapan,
            'biaya_penginapan_4' => $request->biaya_penginapan_4,
            'biaya_penginapan_3' => $request->biaya_penginapan_3,
            'biaya_penginapan_2' => $request->biaya_penginapan_2,
            'biaya_penginapan_1' => $request->biaya_penginapan_1,
            'uang_harian' => $request->uang_harian,
            'keterangan_penerbangan' => $request->keterangan_penerbangan,
            'keterangan_tol' => $request->keterangan_tol,
            'keterangan_lain' => $request->keterangan_lain,
            'biaya_penerbangan' => $request->biaya_penerbangan,
            'biaya_tol' => $request->biaya_tol,
            'biaya_lain' => $request->biaya_lain,
            'id_pegawai_bendahara' => $request->pegawai_bendahara,
        ]);

        // Perhitungan Biaya dan Lain-Lain
        $pegawaiYangIkut = [];
        // Tambahkan pelaksana (selalu ada)
        if ($rincianBiaya->sppd->pelaksana) {
            $pegawaiYangIkut[] = $rincianBiaya->sppd->pelaksana;
        }
        // Tambahkan pengikut jika ada di database (tidak null)
        if ($rincianBiaya->sppd->pengikut_1) {
            $pegawaiYangIkut[] = $rincianBiaya->sppd->pengikut_1;
        }
        if ($rincianBiaya->sppd->pengikut_2) {
            $pegawaiYangIkut[] = $rincianBiaya->sppd->pengikut_2;
        }
        if ($rincianBiaya->sppd->pengikut_3) {
            $pegawaiYangIkut[] = $rincianBiaya->sppd->pengikut_3;
        }

        $totalPengikut = count($pegawaiYangIkut);
        $totalGolIV = 0;
        $totalGolIII = 0;
        $totalGolII = 0;
        $totalGolI = 0;

        foreach ($pegawaiYangIkut as $p) {
            if (!$p) continue;
            $golongan = $p->golongan ?? null;
            switch ($golongan) {
                case 'I':
                    $totalGolI++;
                    break;
                case 'III':
                case 'IX':
                    $totalGolIII++;
                    break;
                case 'IV':
                    $totalGolIV++;
                    break;
                case 'II':
                case 'V':
                case 'VII':
                case null:
                case '':
                    $totalGolII++;
                    break;
            }
        }

        // Gunakan preg_replace untuk menghapus semua karakter selain angka
        $biayaPergi = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_pergi);
        $biayaPulang = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_pulang);

        $subtotalPergi = $totalPengikut * $biayaPergi;
        $subtotalPulang = $totalPengikut * $biayaPulang;

        $subtotalAngkutan = $subtotalPergi + $subtotalPulang;

        // Terapkan hal yang sama untuk semua variabel biaya
        $biayaPenginapan4 = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_penginapan_4);
        $biayaPenginapan3 = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_penginapan_3);
        $biayaPenginapan2 = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_penginapan_2);
        $biayaPenginapan1 = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_penginapan_1);
        $uangHarian = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->uang_harian);

        $menginap = $request->menginap;
        $discount = 0;
        if ($menginap > 0) {
            $discount = 1;
        } else {
            $discount = 0.3;
        }

        $jumlahHariPenginapan = $request->jumlah_hari_penginapan ?? 0;

        $subtotalPenginapan4 = $totalGolIV * $biayaPenginapan4 * $discount * $jumlahHariPenginapan;
        $subtotalPenginapan3 = $totalGolIII * $biayaPenginapan3 * $discount * $jumlahHariPenginapan;
        $subtotalPenginapan2 = $totalGolII * $biayaPenginapan2 * $discount * $jumlahHariPenginapan;
        $subtotalPenginapan1 = $totalGolI * $biayaPenginapan1 * $discount * $jumlahHariPenginapan;

        $subtotalPenginapan = $subtotalPenginapan4 + $subtotalPenginapan3 + $subtotalPenginapan2 + $subtotalPenginapan1;

        $jumlahHari = $request->jumlah_hari ?? 0;

        $subtotalHarian4 = $totalGolIV * $uangHarian * $jumlahHari;
        $subtotalHarian3 = $totalGolIII * $uangHarian * $jumlahHari;
        $subtotalHarian2 = $totalGolII * $uangHarian * $jumlahHari;
        $subtotalHarian1 = $totalGolI * $uangHarian * $jumlahHari;

        $subtotalHarian = $subtotalHarian4 + $subtotalHarian3 + $subtotalHarian2 + $subtotalHarian1;

        $biayaPenerbangan = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_penerbangan);
        $biayaTol = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_tol);
        $biayaLain = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_lain);

        $subtotalLain = $biayaPenerbangan + $biayaTol + $biayaLain;

        $totalBiaya = $subtotalAngkutan + $subtotalPenginapan + $subtotalHarian + $subtotalLain;

        $biayaPelaksana = 0;
        $biayaPenginapanPengikut1 = 0;
        $biayaPenginapanPengikut2 = 0;
        $biayaPenginapanPengikut3 = 0;

        if ($rincianBiaya->sppd->pelaksana) {
            $golPelaksana = $rincianBiaya->sppd->pelaksana->golongan ?? null;
            switch ($golPelaksana) {
            case 'IV':
                $biayaPenginapanPelaksana = $biayaPenginapan4;
                break;
            case 'III':
            case 'IX':
                $biayaPenginapanPelaksana = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPelaksana = $biayaPenginapan1;
                break;
            case 'II':
            case 'V':
            case 'VII':
            case null:
            case '':
            default:
                $biayaPenginapanPelaksana = $biayaPenginapan2;
                break;
            }
        }

        // Pengikut 1
        if ($rincianBiaya->sppd->pengikut_1) {
            $golPengikut1 = $rincianBiaya->sppd->pengikut_1->golongan ?? null;
            switch ($golPengikut1) {
            case 'IV':
                $biayaPenginapanPengikut1 = $biayaPenginapan4;
                break;
            case 'III':
            case 'IX':
                $biayaPenginapanPengikut1 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut1 = $biayaPenginapan1;
                break;
            case 'II':
            case 'V':
            case 'VII':
            case null:
            case '':
            default:
                $biayaPenginapanPengikut1 = $biayaPenginapan2;
                break;
            }
        }
        // Pengikut 2
        if ($rincianBiaya->sppd->pengikut_2) {
            $golPengikut2 = $rincianBiaya->sppd->pengikut_2->golongan ?? null;
            switch ($golPengikut2) {
            case 'IV':
                $biayaPenginapanPengikut2= $biayaPenginapan4;
                break;
            case 'III':
            case 'IX':
                $biayaPenginapanPengikut2 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut2 = $biayaPenginapan1;
                break;
            case 'II':
            case 'V':
            case 'VII':
            case null:
            case '':
            default:
                $biayaPenginapanPengikut2 = $biayaPenginapan2;
                break;
            }
        }
        // Pengikut 3
        if ($rincianBiaya->sppd->pengikut_3) {
            $golPengikut3 = $rincianBiaya->sppd->pengikut_3->golongan ?? null;
            switch ($golPengikut3) {
            case 'IV':
                $biayaPenginapanPengikut3 = $biayaPenginapan4;
                break;
            case 'III':
            case 'IX':
                $biayaPenginapanPengikut3 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut3 = $biayaPenginapan1;
                break;
            case 'II':
            case 'V':
            case 'VII':
            case null:
            case '':
            default:
                $biayaPenginapanPengikut3 = $biayaPenginapan2;
                break;
            }
        }

        $biayaPelaksana = $uangHarian * $jumlahHari + $biayaPenginapanPelaksana * $jumlahHariPenginapan + $subtotalAngkutan + $subtotalLain;
        $biayaPengikut1 = $uangHarian * $jumlahHari + $biayaPenginapanPengikut1 * $jumlahHariPenginapan;
        $biayaPengikut2 = $uangHarian * $jumlahHari + $biayaPenginapanPengikut2 * $jumlahHariPenginapan;
        $biayaPengikut3 = $uangHarian * $jumlahHari + $biayaPenginapanPengikut3 * $jumlahHariPenginapan;

        // Jangan lupa, saat menampilkan hasilnya di view, format kembali dengan titik
        // Contoh di view Blade:
        // <td>{{ number_format($subtotalAngkutan, 0, ',', '.') }}</td>

        // Nama file unik berdasarkan ID dan timestamp
        $fileName = 'sppd-' . $sppd->id . '-' . time() . '.pdf';
        $filePath = 'uploads/sppd/' . $fileName;

        // Menggunakan view blade sebagai template PDF
        $pdf = PDF::loadView('admin.template.sppd', compact(
            'sppd',
            'rincianBiaya',
            'totalPengikut',
            'totalGolIV',
            'totalGolIII',
            'totalGolII',
            'totalGolI',
            'subtotalPergi',
            'subtotalPulang',
            'subtotalAngkutan',
            'menginap',
            'subtotalPenginapan4',
            'subtotalPenginapan3',
            'subtotalPenginapan2',
            'subtotalPenginapan1',
            'subtotalPenginapan',
            'subtotalHarian4',
            'subtotalHarian3',
            'subtotalHarian2',
            'subtotalHarian1',
            'subtotalHarian',
            'subtotalLain',
            'totalBiaya',
            'biayaPelaksana',
            'biayaPengikut1',
            'biayaPengikut2',
            'biayaPengikut3',
        ));

        if (!Storage::exists('uploads/sppd')) {
            Storage::makeDirectory('uploads/sppd');
        }

        // Simpan PDF ke direktori public/storage/uploads/sppd
        Storage::put($filePath, $pdf->output());

        // Simpan path file ke database
        $sppd->file_surat = $fileName;
        $sppd->save();

        return redirect()->route('subkeg-1.sppd.index')->with('success', 'Surat Perjalanan Dinas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $sppd = SPPD::findOrFail($id);
        $path = 'uploads/sppd/' . $sppd->file_surat;

        // Check if the file exists in the private storage
        if (!Storage::exists($path)) {
            abort(404);
        }

        // Get the full path to the file
        $filePath = Storage::path($path);

        // Get the file's mime type
        $mimeType = Storage::mimeType($path);

        // Return the file as a response
        return response()->file($filePath, ['Content-Type' => $mimeType]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $sppd = SPPD::findOrFail($id);
        $rincianBiaya = RincianBiayaSPPD::find($id);
        $pegawai = Pegawai::all();
        return view('admin.subkeg-1.sppd.edit', compact('sppd', 'pegawai', 'rincianBiaya'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'sub_kegiatan' => 'required|string',
            'lembar' => 'nullable|integer',
            'kode' => 'nullable|integer',
            'nomor_surat' => 'nullable|string|max:20',
            'pegawai_pemberi_wewenang' => 'required|exists:pegawai,id',
            'pegawai_pelaksana' => 'required|exists:pegawai,id',
            'tingkat_biaya' => 'required|string|max:1',
            'maksud' => 'required|string|max:255',
            'alat_angkut' => 'required|string|max:50',
            'tempat_berangkat' => 'required|string|max:50',
            'tempat_kedudukan' => 'nullable|string|max:50',
            'tempat_tujuan' => 'required|string|max:50',
            'jumlah_hari' => 'required|integer',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'pegawai_pengikut_1' => 'nullable|exists:pegawai,id',
            'pegawai_pengikut_2' => 'nullable|exists:pegawai,id',
            'pegawai_pengikut_3' => 'nullable|exists:pegawai,id',
            'instansi_pembebanan_anggaran' => 'required|string',
            'akun_pembebanan_anggaran' => 'required|string',
            'keterangan' => 'nullable|string',
            'tanggal_dibuat_surat' => 'required|date',
            'tanggal_tiba' => 'nullable|date',
            'pegawai_mengetahui' => 'nullable|exists:pegawai,id',
            'kepala_jabatan_di_tempat' => 'nullable|string|max:50',
            'nama_di_tempat' => 'nullable|string|max:50',
            'nip_di_tempat' => 'nullable|string|max:30',
            'biaya_pergi' => 'nullable|numeric',
            'biaya_pulang' => 'nullable|numeric',
            'menginap' => 'nullable|boolean',
            'jumlah_hari_penginapan' => 'nullable|integer',
            'biaya_penginapan_4' => 'nullable|numeric',
            'biaya_penginapan_3' => 'nullable|numeric',
            'biaya_penginapan_2' => 'nullable|numeric',
            'biaya_penginapan_1' => 'nullable|numeric',
            'uang_harian' => 'nullable|numeric',
            'keterangan_penerbangan' => 'nullable|string',
            'keterangan_tol' => 'nullable|string',
            'keterangan_lain' => 'nullable|string',
            'biaya_penerbangan' => 'nullable|numeric',
            'biaya_tol' => 'nullable|numeric',
            'biaya_lain' => 'nullable|numeric',
            'pegawai_bendahara' => 'nullable|exists:pegawai,id',
        ], [
            'sub_kegiatan.required' => 'Sub kegiatan wajib diisi.',
            'lembar.integer' => 'Lembar harus berupa angka.',
            'kode.integer' => 'Kode harus berupa angka.',
            'nomor_surat.max' => 'Nomor surat maksimal 20 karakter.',
            'pegawai_pemberi_wewenang.required' => 'Pegawai pemberi wewenang wajib dipilih.',
            'pegawai_pemberi_wewenang.exists' => 'Pegawai pemberi wewenang tidak ditemukan.',
            'pegawai_pelaksana.required' => 'Pegawai pelaksana wajib dipilih.',
            'pegawai_pelaksana.exists' => 'Pegawai pelaksana tidak ditemukan.',
            'tingkat_biaya.required' => 'Tingkat biaya wajib diisi.',
            'tingkat_biaya.max' => 'Tingkat biaya maksimal 1 karakter.',
            'maksud.required' => 'Maksud perjalanan wajib diisi.',
            'maksud.max' => 'Maksud perjalanan maksimal 255 karakter.',
            'alat_angkut.required' => 'Alat angkut wajib diisi.',
            'alat_angkut.max' => 'Alat angkut maksimal 50 karakter.',
            'tempat_berangkat.required' => 'Tempat berangkat wajib diisi.',
            'tempat_berangkat.max' => 'Tempat berangkat maksimal 50 karakter.',
            'tempat_kedudukan.max' => 'Tempat kedudukan maksimal 50 karakter.',
            'tempat_tujuan.required' => 'Tempat tujuan wajib diisi.',
            'tempat_tujuan.max' => 'Tempat tujuan maksimal 50 karakter.',
            'jumlah_hari.required' => 'Jumlah hari wajib diisi.',
            'jumlah_hari.integer' => 'Jumlah hari harus berupa angka.',
            'tanggal_berangkat.required' => 'Tanggal berangkat wajib diisi.',
            'tanggal_berangkat.date' => 'Tanggal berangkat tidak valid.',
            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.date' => 'Tanggal kembali tidak valid.',
            'pegawai_pengikut_1.exists' => 'Pegawai pengikut 1 tidak ditemukan.',
            'pegawai_pengikut_2.exists' => 'Pegawai pengikut 2 tidak ditemukan.',
            'pegawai_pengikut_3.exists' => 'Pegawai pengikut 3 tidak ditemukan.',
            'instansi_pembebanan_anggaran.required' => 'Instansi pembebanan anggaran wajib diisi.',
            'akun_pembebanan_anggaran.required' => 'Akun pembebanan anggaran wajib diisi.',
            'tanggal_dibuat_surat.required' => 'Tanggal dibuat surat wajib diisi.',
            'tanggal_dibuat_surat.date' => 'Tanggal dibuat surat tidak valid.',
            'tanggal_tiba.date' => 'Tanggal tiba tidak valid.',
            'pegawai_mengetahui.exists' => 'Pegawai mengetahui tidak ditemukan.',
            'kepala_jabatan_di_tempat.max' => 'Kepala jabatan di tempat maksimal 50 karakter.',
            'nama_di_tempat.max' => 'Nama di tempat maksimal 50 karakter.',
            'nip_di_tempat.max' => 'NIP di tempat maksimal 30 karakter.',
            'biaya_pergi.numeric' => 'Biaya pergi harus berupa angka.',
            'biaya_pulang.numeric' => 'Biaya pulang harus berupa angka.',
            'menginap.boolean' => 'Menginap harus berupa nilai benar/salah.',
            'jumlah_hari_penginapan.integer' => 'Jumlah hari penginapan harus berupa angka.',
            'biaya_penginapan_4.numeric' => 'Biaya penginapan golongan IV harus berupa angka.',
            'biaya_penginapan_3.numeric' => 'Biaya penginapan golongan III harus berupa angka.',
            'biaya_penginapan_2.numeric' => 'Biaya penginapan golongan II harus berupa angka.',
            'biaya_penginapan_1.numeric' => 'Biaya penginapan golongan I harus berupa angka.',
            'uang_harian.numeric' => 'Uang harian harus berupa angka.',
            'biaya_penerbangan.numeric' => 'Biaya penerbangan harus berupa angka.',
            'biaya_tol.numeric' => 'Biaya tol harus berupa angka.',
            'biaya_lain.numeric' => 'Biaya lain harus berupa angka.',
            'pegawai_bendahara.exists' => 'Pegawai bendahara tidak ditemukan.',
        ]);

        $sppd = SPPD::findOrFail($id);
        $sppd->update($request->except([
            'biaya_pergi',
            'biaya_pulang',
            'menginap',
            'jumlah_hari_penginapan',
            'biaya_penginapan_4',
            'biaya_penginapan_3',
            'biaya_penginapan_2',
            'biaya_penginapan_1',
            'uang_harian',
            'keterangan_penerbangan',
            'keterangan_tol',
            'keterangan_lain',
            'biaya_penerbangan',
            'biaya_tol',
            'biaya_lain',
            'pegawai_bendahara'
        ]));
        $rincianBiaya = RincianBiayaSPPD::findOrFail($id);
        $rincianBiaya->update([
            'id_sppd' => $sppd->id,
            'biaya_pergi' => $request->biaya_pergi,
            'biaya_pulang' => $request->biaya_pulang,
            'menginap' => $request->menginap,
            'jumlah_hari_penginapan' => $request->jumlah_hari_penginapan,
            'biaya_penginapan_4' => $request->biaya_penginapan_4,
            'biaya_penginapan_3' => $request->biaya_penginapan_3,
            'biaya_penginapan_2' => $request->biaya_penginapan_2,
            'biaya_penginapan_1' => $request->biaya_penginapan_1,
            'uang_harian' => $request->uang_harian,
            'keterangan_penerbangan' => $request->keterangan_penerbangan,
            'keterangan_tol' => $request->keterangan_tol,
            'keterangan_lain' => $request->keterangan_lain,
            'biaya_penerbangan' => $request->biaya_penerbangan,
            'biaya_tol' => $request->biaya_tol,
            'biaya_lain' => $request->biaya_lain,
            'id_pegawai_bendahara' => $request->pegawai_bendahara,
        ]);

        // Perhitungan Biaya dan Lain-Lain
        $pegawaiYangIkut = [];
        // Tambahkan pelaksana (selalu ada)
        if ($rincianBiaya->sppd->pelaksana) {
            $pegawaiYangIkut[] = $rincianBiaya->sppd->pelaksana;
        }
        // Tambahkan pengikut jika ada di database (tidak null)
        if ($rincianBiaya->sppd->pengikut_1) {
            $pegawaiYangIkut[] = $rincianBiaya->sppd->pengikut_1;
        }
        if ($rincianBiaya->sppd->pengikut_2) {
            $pegawaiYangIkut[] = $rincianBiaya->sppd->pengikut_2;
        }
        if ($rincianBiaya->sppd->pengikut_3) {
            $pegawaiYangIkut[] = $rincianBiaya->sppd->pengikut_3;
        }

        $totalPengikut = count($pegawaiYangIkut);
        $totalGolIV = 0;
        $totalGolIII = 0;
        $totalGolII = 0;
        $totalGolI = 0;

        foreach ($pegawaiYangIkut as $p) {
            if (!$p) continue;
            $golongan = $p->golongan ?? null;
            switch ($golongan) {
                case 'I':
                    $totalGolI++;
                    break;
                case 'III':
                case 'IX':
                    $totalGolIII++;
                    break;
                case 'IV':
                    $totalGolIV++;
                    break;
                case 'II':
                case 'V':
                case 'VII':
                case null:
                case '':
                    $totalGolII++;
                    break;
            }
        }

        // Gunakan preg_replace untuk menghapus semua karakter selain angka
        $biayaPergi = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_pergi);
        $biayaPulang = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_pulang);

        $subtotalPergi = $totalPengikut * $biayaPergi;
        $subtotalPulang = $totalPengikut * $biayaPulang;

        $subtotalAngkutan = $subtotalPergi + $subtotalPulang;

        // Terapkan hal yang sama untuk semua variabel biaya
        $biayaPenginapan4 = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_penginapan_4);
        $biayaPenginapan3 = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_penginapan_3);
        $biayaPenginapan2 = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_penginapan_2);
        $biayaPenginapan1 = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_penginapan_1);
        $uangHarian = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->uang_harian);

        $menginap = $request->menginap;
        $discount = 0;
        if ($menginap > 0) {
            $discount = 1;
        } else {
            $discount = 0.3;
        }

        $jumlahHariPenginapan = $request->jumlah_hari_penginapan ?? 0;

        $subtotalPenginapan4 = $totalGolIV * $biayaPenginapan4 * $discount * $jumlahHariPenginapan;
        $subtotalPenginapan3 = $totalGolIII * $biayaPenginapan3 * $discount * $jumlahHariPenginapan;
        $subtotalPenginapan2 = $totalGolII * $biayaPenginapan2 * $discount * $jumlahHariPenginapan;
        $subtotalPenginapan1 = $totalGolI * $biayaPenginapan1 * $discount * $jumlahHariPenginapan;

        $subtotalPenginapan = $subtotalPenginapan4 + $subtotalPenginapan3 + $subtotalPenginapan2 + $subtotalPenginapan1;

        $jumlahHari = $request->jumlah_hari ?? 0;

        $subtotalHarian4 = $totalGolIV * $uangHarian * $jumlahHari;
        $subtotalHarian3 = $totalGolIII * $uangHarian * $jumlahHari;
        $subtotalHarian2 = $totalGolII * $uangHarian * $jumlahHari;
        $subtotalHarian1 = $totalGolI * $uangHarian * $jumlahHari;

        $subtotalHarian = $subtotalHarian4 + $subtotalHarian3 + $subtotalHarian2 + $subtotalHarian1;

        $biayaPenerbangan = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_penerbangan);
        $biayaTol = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_tol);
        $biayaLain = (int) preg_replace('/[^0-9]/', '', $rincianBiaya->biaya_lain);

        $subtotalLain = $biayaPenerbangan + $biayaTol + $biayaLain;

        $totalBiaya = $subtotalAngkutan + $subtotalPenginapan + $subtotalHarian + $subtotalLain;

        // Hitung biaya penginapan pelaksana dan pengikut berdasarkan golongan
        $biayaPenginapanPelaksana = 0;
        $biayaPenginapanPengikut1 = 0;
        $biayaPenginapanPengikut2 = 0;
        $biayaPenginapanPengikut3 = 0;

        if ($rincianBiaya->sppd->pelaksana) {
            $golPelaksana = $rincianBiaya->sppd->pelaksana->golongan ?? null;
            switch ($golPelaksana) {
            case 'IV':
                $biayaPenginapanPelaksana = $biayaPenginapan4;
                break;
            case 'III':
            case 'IX':
                $biayaPenginapanPelaksana = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPelaksana = $biayaPenginapan1;
                break;
            case 'II':
            case 'V':
            case 'VII':
            case null:
            case '':
            default:
                $biayaPenginapanPelaksana = $biayaPenginapan2;
                break;
            }
        }

        // Pengikut 1
        if ($rincianBiaya->sppd->pengikut_1) {
            $golPengikut1 = $rincianBiaya->sppd->pengikut_1->golongan ?? null;
            switch ($golPengikut1) {
            case 'IV':
                $biayaPenginapanPengikut1 = $biayaPenginapan4;
                break;
            case 'III':
            case 'IX':
                $biayaPenginapanPengikut1 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut1 = $biayaPenginapan1;
                break;
            case 'II':
            case 'V':
            case 'VII':
            case null:
            case '':
            default:
                $biayaPenginapanPengikut1 = $biayaPenginapan2;
                break;
            }
        }
        // Pengikut 2
        if ($rincianBiaya->sppd->pengikut_2) {
            $golPengikut2 = $rincianBiaya->sppd->pengikut_2->golongan ?? null;
            switch ($golPengikut2) {
            case 'IV':
                $biayaPenginapanPengikut2= $biayaPenginapan4;
                break;
            case 'III':
            case 'IX':
                $biayaPenginapanPengikut2 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut2 = $biayaPenginapan1;
                break;
            case 'II':
            case 'V':
            case 'VII':
            case null:
            case '':
            default:
                $biayaPenginapanPengikut2 = $biayaPenginapan2;
                break;
            }
        }
        // Pengikut 3
        if ($rincianBiaya->sppd->pengikut_3) {
            $golPengikut3 = $rincianBiaya->sppd->pengikut_3->golongan ?? null;
            switch ($golPengikut3) {
            case 'IV':
                $biayaPenginapanPengikut3 = $biayaPenginapan4;
                break;
            case 'III':
            case 'IX':
                $biayaPenginapanPengikut3 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut3 = $biayaPenginapan1;
                break;
            case 'II':
            case 'V':
            case 'VII':
            case null:
            case '':
            default:
                $biayaPenginapanPengikut3 = $biayaPenginapan2;
                break;
            }
        }

        $biayaPelaksana = $uangHarian * $jumlahHari + $biayaPenginapanPelaksana * $jumlahHariPenginapan + $subtotalAngkutan + $subtotalLain;
        $biayaPengikut1 = $uangHarian * $jumlahHari + $biayaPenginapanPengikut1 * $jumlahHariPenginapan;
        $biayaPengikut2 = $uangHarian * $jumlahHari + $biayaPenginapanPengikut2 * $jumlahHariPenginapan;
        $biayaPengikut3 = $uangHarian * $jumlahHari + $biayaPenginapanPengikut3 * $jumlahHariPenginapan;

        // Jangan lupa, saat menampilkan hasilnya di view, format kembali dengan titik
        // Contoh di view Blade:
        // <td>{{ number_format($subtotalAngkutan, 0, ',', '.') }}</td>

        if (Storage::exists('uploads/sppd/' . $sppd->file_surat)) {
            Storage::delete('uploads/sppd/' . $sppd->file_surat);
            $sppd->file_surat = null;
        }

        // Nama file unik berdasarkan ID dan timestamp
        $fileName = 'sppd-' . $sppd->id . '-' . time() . '.pdf';
        $filePath = 'uploads/sppd/' . $fileName;

        // Menggunakan view blade sebagai template PDF
        $pdf = PDF::loadView('admin.template.sppd', compact(
            'sppd',
            'rincianBiaya',
            'totalPengikut',
            'totalGolIV',
            'totalGolIII',
            'totalGolII',
            'totalGolI',
            'subtotalPergi',
            'subtotalPulang',
            'subtotalAngkutan',
            'menginap',
            'subtotalPenginapan4',
            'subtotalPenginapan3',
            'subtotalPenginapan2',
            'subtotalPenginapan1',
            'subtotalPenginapan',
            'subtotalHarian4',
            'subtotalHarian3',
            'subtotalHarian2',
            'subtotalHarian1',
            'subtotalHarian',
            'subtotalLain',
            'totalBiaya',
            'biayaPelaksana',
            'biayaPengikut1',
            'biayaPengikut2',
            'biayaPengikut3',
        ));

        if (!Storage::exists('uploads/sppd')) {
            Storage::makeDirectory('uploads/sppd');
        }

        // Simpan PDF ke direktori public/storage/uploads/sppd
        Storage::put($filePath, $pdf->output());

        // Simpan path file ke database
        $sppd->file_surat = $fileName;
        $sppd->save();

        return redirect()->route('subkeg-1.sppd.index')->with('success', 'Surat Perjalanan Dinas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $sppd = SPPD::find($id);
        if ($sppd->file_surat) {
            Storage::delete('uploads/sppd/' . $sppd->file_surat);
        }
        $sppd->delete();
        return redirect()->route('subkeg-1.sppd.index')->with('success', 'Surat Perjalanan Dinas berhasil dihapus.');
    }
}
