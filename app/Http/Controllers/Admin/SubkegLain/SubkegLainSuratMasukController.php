<?php

namespace App\Http\Controllers\Admin\SubkegLain;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SubkegLainSuratMasukController extends Controller
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
        $query = SuratMasuk::query()->where('sub_kegiatan', 'Lain-Lain');;

        // Filter berdasarkan pengirim atau perihal
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('pengirim', 'like', "%{$search}%")
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
        $suratSuratMasuk = $query->orderBy("created_at", "desc")->paginate(5);

        return view('admin.subkeg-lain.surat-masuk.index', compact('suratSuratMasuk', 'search', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.subkeg-lain.surat-masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'pengirim' => 'required|string|max:100',
            'nomor_surat' => 'required|string|max:50|unique:surat_masuk,nomor_surat',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'nomor_agenda' => 'required|string|max:11',
            'sifat' => 'required|in:Segera,Biasa',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ],[
            'pengirim.required' => 'Pengirim wajib diisi.',
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'nomor_surat.unique' => 'Nomor surat sudah ada.',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
            'tanggal_diterima.required' => 'Tanggal diterima wajib diisi.',
            'nomor_agenda.required' => 'Nomor agenda wajib diisi.',
            'sifat.required' => 'Sifat surat wajib dipilih.',
            'perihal.required' => 'Perihal wajib diisi.',
            'file_surat.required' => 'File surat wajib ada.',
            'file_surat.mimes' => 'File surat harus berupa file PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
            'file_surat.max' => 'Ukuran file surat maksimal 2MB.',
        ]);
        $suratMasuk = SuratMasuk::create($request->all());
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/surat_masuk'), $filename);
            $suratMasuk->file_surat = $filename;
            $suratMasuk->save();
        }
        return redirect()->route('subkeg-lain.surat-masuk.index')->with('success', 'Surat Masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $suratMasuk = SuratMasuk::find($id);
        return view('admin.subkeg-lain.surat-masuk.details', compact('suratMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $suratMasuk = SuratMasuk::find($id);
        return view('admin.subkeg-lain.surat-masuk.edit', compact('suratMasuk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->validate($request, [
            'pengirim' => 'required|string|max:255',
            'nomor_surat' => 'required|string|max:255|unique:surat_masuk,nomor_surat,' . $id,
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'nomor_agenda' => 'required|string|max:255',
            'sifat' => 'required|in:Segera,Biasa',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ],[
            'pengirim.required' => 'Pengirim wajib diisi.',
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'nomor_surat.unique' => 'Nomor surat sudah ada.',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
            'tanggal_diterima.required' => 'Tanggal diterima wajib diisi.',
            'nomor_agenda.required' => 'Nomor agenda wajib diisi.',
            'sifat.required' => 'Sifat surat wajib dipilih.',
            'perihal.required' => 'Perihal wajib diisi.',
            'file_surat.mimes' => 'File surat harus berupa file PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
            'file_surat.max' => 'Ukuran file surat maksimal 2MB.',
        ]);
        $suratMasuk = SuratMasuk::find($id);
        if ($request->hasFile('file_surat')) {
            if ($suratMasuk->file_surat) {
                unlink(storage_path('app/public/uploads/surat_masuk/' . $suratMasuk->file_surat));
            }
        }
        $suratMasuk->update($request->all());
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/surat_masuk'), $filename);
            $suratMasuk->file_surat = $filename;
            $suratMasuk->save();
        }
        return redirect()->route('subkeg-lain.surat-masuk.index')->with('success', 'Surat Masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $suratMasuk = SuratMasuk::find($id);
        if ($suratMasuk->file_surat) {
            unlink(storage_path('app/public/uploads/surat_masuk/' . $suratMasuk->file_surat));
        }
        $suratMasuk->delete();
        return redirect()->route('subkeg-lain.surat-masuk.index')->with('success', 'Surat Masuk berhasil dihapus.');
    }
}
