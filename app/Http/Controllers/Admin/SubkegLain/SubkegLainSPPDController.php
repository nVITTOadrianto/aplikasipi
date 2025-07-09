<?php

namespace App\Http\Controllers\Admin\SubkegLain;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\RincianBiayaSPPD;
use App\Models\SPPD;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SubkegLainSPPDController extends Controller
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
        $query = SPPD::query()->where('sub_kegiatan', 'Lain-Lain');

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

        return view('admin.subkeg-lain.sppd.index', compact('sppdSppd', 'search', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $pegawai = Pegawai::all();
        return view('admin.subkeg-lain.sppd.create', compact('pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
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
            'tanggal_tiba' => 'nullable|date',
            'pegawai_mengetahui' => 'nullable|exists:pegawai,id',
            'kepala_jabatan_di_tempat' => 'nullable|string|max:50',
            'nama_di_tempat' => 'nullable|string|max:50',
            'nip_di_tempat' => 'nullable|string|max:30',
            'biaya_pergi' => 'nullable|numeric',
            'biaya_pulang' => 'nullable|numeric',
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
        $pegawaiYangIkut = [
            $rincianBiaya->sppd->pelaksana,
            $rincianBiaya->sppd->pengikut_1,
            $rincianBiaya->sppd->pengikut_2,
            $rincianBiaya->sppd->pengikut_3,
        ];

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

        $subtotalPenginapan4 = $totalGolIV * $biayaPenginapan4;
        $subtotalPenginapan3 = $totalGolIII * $biayaPenginapan3;
        $subtotalPenginapan2 = $totalGolII * $biayaPenginapan2;
        $subtotalPenginapan1 = $totalGolI * $biayaPenginapan1;

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

        $biayaPelaksana = $uangHarian + $subtotalAngkutan + $subtotalLain;
        $biayaPengikut = $uangHarian;

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
            'biayaPengikut',
        ));

        // Simpan PDF ke direktori public/storage/uploads/sppd
        $pdf->save(public_path('storage/' . $filePath));

        // Simpan path file ke database
        $sppd->file_surat = $fileName;
        $sppd->save();

        return redirect()->route('subkeg-lain.sppd.index')->with('success', 'Surat Perjalanan Dinas berhasil ditambahkan.');
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
        return view('admin.subkeg-lain.sppd.edit', compact('sppd', 'pegawai', 'rincianBiaya'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
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
            'tanggal_tiba' => 'nullable|date',
            'pegawai_mengetahui' => 'nullable|exists:pegawai,id',
            'kepala_jabatan_di_tempat' => 'nullable|string|max:50',
            'nama_di_tempat' => 'nullable|string|max:50',
            'nip_di_tempat' => 'nullable|string|max:30',
            'biaya_pergi' => 'nullable|numeric',
            'biaya_pulang' => 'nullable|numeric',
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
        $pegawaiYangIkut = [
            $rincianBiaya->sppd->pelaksana,
            $rincianBiaya->sppd->pengikut_1,
            $rincianBiaya->sppd->pengikut_2,
            $rincianBiaya->sppd->pengikut_3,
        ];

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

        $subtotalPenginapan4 = $totalGolIV * $biayaPenginapan4;
        $subtotalPenginapan3 = $totalGolIII * $biayaPenginapan3;
        $subtotalPenginapan2 = $totalGolII * $biayaPenginapan2;
        $subtotalPenginapan1 = $totalGolI * $biayaPenginapan1;

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

        $biayaPelaksana = $uangHarian + $subtotalAngkutan + $subtotalLain;
        $biayaPengikut = $uangHarian;

        // Jangan lupa, saat menampilkan hasilnya di view, format kembali dengan titik
        // Contoh di view Blade:
        // <td>{{ number_format($subtotalAngkutan, 0, ',', '.') }}</td>

        if ($sppd->file_surat) {
            unlink(public_path('storage/uploads/sppd/' . $sppd->file_surat));
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
            'biayaPengikut',
        ));

        // Simpan PDF ke direktori public/storage/uploads/sppd
        $pdf->save(public_path('storage/' . $filePath));

        // Simpan path file ke database
        $sppd->file_surat = $fileName;
        $sppd->save();

        return redirect()->route('subkeg-lain.sppd.index')->with('success', 'Surat Perjalanan Dinas berhasil diperbarui.');
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
        return redirect()->route('subkeg-lain.sppd.index')->with('success', 'Surat Perjalanan Dinas berhasil dihapus.');
    }
}
