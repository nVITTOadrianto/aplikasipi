<?php

namespace App\Http\Controllers\Admin\Subkeg1;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class Subkeg1SuratKeluarController extends Controller
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
        $query = SuratKeluar::query()->where('sub_kegiatan', 'Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat');

        // Filter berdasarkan penerima atau perihal
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('penerima', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan rentang tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_surat', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('tanggal_surat', $startDate);
        }

        // Ambil data dengan paginasi
        $suratSuratKeluar = $query->orderBy("created_at", "desc")->paginate(5);

        return view('admin.subkeg-1.surat-keluar.index', compact('suratSuratKeluar', 'search', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.subkeg-1.surat-keluar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'sub_kegiatan' => 'required|string',
            'penerima' => 'required|string|max:100',
            'nomor_surat' => 'required|string|max:50|unique:surat_keluar,nomor_surat',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'sifat' => 'required|in:Segera,Biasa',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ],[
            'sub_kegiatan.required' => 'Sub kegiatan wajib diisi.',
            'penerima.required' => 'Penerima wajib diisi.',
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'nomor_surat.unique' => 'Nomor surat sudah ada.',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
            'perihal.required' => 'Perihal wajib diisi.',
            'sifat.required' => 'Sifat surat wajib dipilih.',
            'file_surat.required' => 'File surat wajib ada.',
            'file_surat.mimes' => 'File surat harus berupa file PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
            'file_surat.max' => 'Ukuran file surat maksimal 5MB.',
        ]);
        $suratKeluar = SuratKeluar::create($request->all());
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/surat_keluar'), $filename);
            $suratKeluar->file_surat = $filename;
            $suratKeluar->save();
        }
        return redirect()->route('subkeg-1.surat-keluar.index')->with('success', 'Surat Keluar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $suratKeluar = SuratKeluar::find($id);
        return view('admin.subkeg-1.surat-keluar.details', compact('suratKeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $suratKeluar = SuratKeluar::find($id);
        return view('admin.subkeg-1.surat-keluar.edit', compact('suratKeluar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->validate($request, [
            'penerima' => 'required|string|max:255',
            'nomor_surat' => 'required|string|max:255|unique:surat_keluar,nomor_surat,' . $id,
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'sifat' => 'required|in:Segera,Biasa',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ],[
            'penerima.required' => 'Penerima wajib diisi.',
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'nomor_surat.unique' => 'Nomor surat sudah ada.',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
            'perihal.required' => 'Perihal wajib diisi.',
            'sifat.required' => 'Sifat surat wajib dipilih.',
            'file_surat.mimes' => 'File surat harus berupa file PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
            'file_surat.max' => 'Ukuran file surat maksimal 5MB.',
        ]);
        $suratKeluar = SuratKeluar::find($id);
        if ($request->hasFile('file_surat')) {
            if ($suratKeluar->file_surat) {
                unlink(public_path('storage/uploads/surat_keluar/' . $suratKeluar->file_surat));
            }
        }
        $suratKeluar->update($request->all());
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/surat_keluar'), $filename);
            $suratKeluar->file_surat = $filename;
            $suratKeluar->save();
        }
        return redirect()->route('subkeg-1.surat-keluar.index')->with('success', 'Surat Keluar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $suratKeluar = SuratKeluar::find($id);
        if ($suratKeluar->file_surat) {
            unlink(public_path('storage/uploads/surat_keluar/' . $suratKeluar->file_surat));
        }
        $suratKeluar->delete();
        return redirect()->route('subkeg-1.surat-keluar.index')->with('success', 'Surat Keluar berhasil dihapus.');
    }
}
