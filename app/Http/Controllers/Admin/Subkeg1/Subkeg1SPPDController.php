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
        //
        // $this->validate($request, [
        //     'sub_kegiatan' => 'required|string',
        //     'lembar' => 'nullable|integer',
        //     'kode' => 'nullable|integer',
        //     'nomor_surat' => 'nullable|string|max:20',
        //     'pegawai_pemberi_wewenang' => 'required|exists:pegawai,id',
        //     'pegawai_pelaksana' => 'required|exists:pegawai,id',
        //     'tingkat_biaya' => 'required|string|max:1',
        //     'maksud' => 'required|string|max:255',
        //     'alat_angkut' => 'required|string|max:50',
        //     'tempat_berangkat' => 'required|string|max:50',
        //     'tempat_kedudukan' => 'nullable|string|max:50',
        //     'tempat_tujuan' => 'required|string|max:50',
        //     'jumlah_hari' => 'required|integer',
        //     'tanggal_berangkat' => 'required|date',
        //     'tanggal_kembali' => 'required|date',
        //     'pegawai_pengikut_1' => 'nullable|exists:pegawai,id',
        //     'pegawai_pengikut_2' => 'nullable|exists:pegawai,id',
        //     'pegawai_pengikut_3' => 'nullable|exists:pegawai,id',
        //     'instansi_pembebanan_anggaran' => 'required|string',
        //     'akun_pembebanan_anggaran' => 'required|string',
        //     'keterangan' => 'nullable|string',
        //     'tanggal_tiba' => 'nullable|date',
        //     'pegawai_mengetahui' => 'nullable|exists:pegawai,id',
        //     'kepala_jabatan_di_tempat' => 'nullable|string|max:50',
        //     'nama_di_tempat' => 'nullable|string|max:50',
        //     'nip_di_tempat' => 'nullable|string|max:30',
        // ]);
        // $sppd = SPPD::create($request->all());

        // // Nama file unik berdasarkan ID dan timestamp
        // $fileName = 'sppd-' . $sppd->id . '-' . time() . '.pdf';
        // $filePath = 'uploads/sppd/' . $fileName;

        // // Menggunakan view blade sebagai template PDF
        // $pdf = PDF::loadView('admin.template.sppd', compact('sppd'));

        // // Simpan PDF ke direktori public/storage/uploads/sppd
        // $pdf->save(public_path('storage/' . $filePath));

        // // Simpan path file ke database
        // $sppd->file_surat = $fileName;
        // $sppd->save();

        // return redirect()->route('subkeg-1.sppd.index')->with('success', 'Surat Perjalanan Dinas berhasil ditambahkan.');
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

        // Nama file unik berdasarkan ID dan timestamp
        $fileName = 'sppd-' . $sppd->id . '-' . time() . '.pdf';
        $filePath = 'uploads/sppd/' . $fileName;

        // Menggunakan view blade sebagai template PDF
        $pdf = PDF::loadView('admin.template.sppd', compact('sppd', 'rincianBiaya'));

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
        $pegawai = Pegawai::all();
        return view('admin.subkeg-1.sppd.edit', compact('sppd', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
            'tanggal_tiba' => 'nullable|date',
            'pegawai_mengetahui' => 'nullable|exists:pegawai,id',
            'kepala_jabatan_di_tempat' => 'nullable|string|max:50',
            'nama_di_tempat' => 'nullable|string|max:50',
            'nip_di_tempat' => 'nullable|string|max:30',
        ]);
        $sppd = SPPD::findOrFail($id);

        unlink(public_path('storage/uploads/sppd/' . $sppd->file_surat));

        $sppd->update($request->all());

        // Nama file unik berdasarkan ID dan timestamp
        $fileName = 'sppd-' . $sppd->id . '-' . time() . '.pdf';
        $filePath = 'uploads/sppd/' . $fileName;

        // Menggunakan view blade sebagai template PDF
        $pdf = Pdf::loadView('admin.template.sppd', compact('sppd'));

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
        unlink(public_path('storage/uploads/sppd/' . $sppd->file_surat));
        $sppd->delete();
        return redirect()->route('subkeg-1.sppd.index')->with('success', 'Surat Perjalanan Dinas berhasil dihapus.');
    }
}
