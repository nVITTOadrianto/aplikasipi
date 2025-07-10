<?php

namespace App\Http\Controllers\Admin\Subkeg1;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\RincianBiayaSPPD;
use App\Models\SPPD;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', $startDate);
        }

        // Ambil data dengan paginasi
        $sppdSppd = $query->orderBy("created_at", "desc")->paginate(5);

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
        ]);
        $sppd = SPPD::create($request->except([
            'biaya_pergi',
            'biaya_pulang',
            'menginap',
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
            'biaya_lain'
        ]));

        $rincianBiaya = RincianBiayaSPPD::create([
            'id_sppd' => $sppd->id,
            'biaya_pergi' => $request->biaya_pergi,
            'biaya_pulang' => $request->biaya_pulang,
            'menginap' => $request->menginap,
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
                    $totalGolIII++;
                    break;
                case 'IV':
                    $totalGolIV++;
                    break;
                case 'II':
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

        $subtotalPenginapan4 = $totalGolIV * $biayaPenginapan4 * $discount;
        $subtotalPenginapan3 = $totalGolIII * $biayaPenginapan3 * $discount;
        $subtotalPenginapan2 = $totalGolII * $biayaPenginapan2 * $discount;
        $subtotalPenginapan1 = $totalGolI * $biayaPenginapan1 * $discount;

        $subtotalPenginapan = $subtotalPenginapan4 + $subtotalPenginapan3 + $subtotalPenginapan2 + $subtotalPenginapan1;

        $subtotalHarian4 = $totalGolIV * $uangHarian;
        $subtotalHarian3 = $totalGolIII * $uangHarian;
        $subtotalHarian2 = $totalGolII * $uangHarian;
        $subtotalHarian1 = $totalGolI * $uangHarian;

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
                $biayaPenginapanPelaksana = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPelaksana = $biayaPenginapan1;
                break;
            case 'II':
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
                $biayaPenginapanPengikut1 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut1 = $biayaPenginapan1;
                break;
            case 'II':
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
                $biayaPenginapanPengikut2 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut2 = $biayaPenginapan1;
                break;
            case 'II':
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
                $biayaPenginapanPengikut3 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut3 = $biayaPenginapan1;
                break;
            case 'II':
            case null:
            case '':
            default:
                $biayaPenginapanPengikut3 = $biayaPenginapan2;
                break;
            }
        }

        $biayaPelaksana = $uangHarian + $biayaPenginapanPelaksana + $subtotalAngkutan + $subtotalLain;
        $biayaPengikut1 = $uangHarian + $biayaPenginapanPengikut1;
        $biayaPengikut2 = $uangHarian + $biayaPenginapanPengikut2;
        $biayaPengikut3 = $uangHarian + $biayaPenginapanPengikut3;

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

        // Simpan PDF ke direktori public/storage/uploads/sppd
        $pdf->save(public_path('storage/' . $filePath));

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
        return redirect('storage/uploads/sppd/' . $sppd->file_surat);
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
        ]);

        $sppd = SPPD::findOrFail($id);
        $sppd->update($request->except([
            'biaya_pergi',
            'biaya_pulang',
            'menginap',
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
            'biaya_lain'
        ]));
        $rincianBiaya = RincianBiayaSPPD::findOrFail($id);
        $rincianBiaya->update([
            'id_sppd' => $sppd->id,
            'biaya_pergi' => $request->biaya_pergi,
            'biaya_pulang' => $request->biaya_pulang,
            'menginap' => $request->menginap,
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
                    $totalGolIII++;
                    break;
                case 'IV':
                    $totalGolIV++;
                    break;
                case 'II':
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

        $subtotalPenginapan4 = $totalGolIV * $biayaPenginapan4 * $discount;
        $subtotalPenginapan3 = $totalGolIII * $biayaPenginapan3 * $discount;
        $subtotalPenginapan2 = $totalGolII * $biayaPenginapan2 * $discount;
        $subtotalPenginapan1 = $totalGolI * $biayaPenginapan1 * $discount;

        $subtotalPenginapan = $subtotalPenginapan4 + $subtotalPenginapan3 + $subtotalPenginapan2 + $subtotalPenginapan1;

        $subtotalHarian4 = $totalGolIV * $uangHarian;
        $subtotalHarian3 = $totalGolIII * $uangHarian;
        $subtotalHarian2 = $totalGolII * $uangHarian;
        $subtotalHarian1 = $totalGolI * $uangHarian;

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
                $biayaPenginapanPelaksana = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPelaksana = $biayaPenginapan1;
                break;
            case 'II':
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
                $biayaPenginapanPengikut1 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut1 = $biayaPenginapan1;
                break;
            case 'II':
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
                $biayaPenginapanPengikut2 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut2 = $biayaPenginapan1;
                break;
            case 'II':
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
                $biayaPenginapanPengikut3 = $biayaPenginapan3;
                break;
            case 'I':
                $biayaPenginapanPengikut3 = $biayaPenginapan1;
                break;
            case 'II':
            case null:
            case '':
            default:
                $biayaPenginapanPengikut3 = $biayaPenginapan2;
                break;
            }
        }

        $biayaPelaksana = $uangHarian + $biayaPenginapanPelaksana + $subtotalAngkutan + $subtotalLain;
        $biayaPengikut1 = $uangHarian + $biayaPenginapanPengikut1;
        $biayaPengikut2 = $uangHarian + $biayaPenginapanPengikut2;
        $biayaPengikut3 = $uangHarian + $biayaPenginapanPengikut3;

        // Jangan lupa, saat menampilkan hasilnya di view, format kembali dengan titik
        // Contoh di view Blade:
        // <td>{{ number_format($subtotalAngkutan, 0, ',', '.') }}</td>

        if ($sppd->file_surat) {
            unlink(public_path('storage/uploads/sppd/' . $sppd->file_surat));
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

        // Simpan PDF ke direktori public/storage/uploads/sppd
        $pdf->save(public_path('storage/' . $filePath));

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
            unlink(public_path('storage/uploads/sppd/' . $sppd->file_surat));
        }
        $sppd->delete();
        return redirect()->route('subkeg-1.sppd.index')->with('success', 'Surat Perjalanan Dinas berhasil dihapus.');
    }
}
