<?php

namespace App\Http\Controllers\Admin\SubkegLain;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubkegLainSuratKeluarController extends Controller
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
        $query = SuratKeluar::query()->where('sub_kegiatan', 'Lain-Lain');

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
        $suratSuratKeluar = $query->orderBy("created_at", "desc")->paginate(10);

        return view('admin.subkeg-lain.surat-keluar.index', compact('suratSuratKeluar', 'search', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.subkeg-lain.surat-keluar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'penerima' => 'required|string|max:100',
            'nomor_surat' => 'required|string|max:50|unique:surat_keluar,nomor_surat',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'sifat' => 'required|in:Segera,Biasa',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ],[
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
            $fileName = 'surat_keluar-' . $suratKeluar->id . '-' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/surat_keluar/' . $fileName;

            if (!Storage::exists('uploads/surat_keluar')) {
                Storage::makeDirectory('uploads/surat_keluar');
            }

            Storage::put($filePath, file_get_contents($file));
            $suratKeluar->file_surat = $fileName;
            $suratKeluar->save();
        }
        return redirect()->route('subkeg-lain.surat-keluar.index')->with('success', 'Surat Keluar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $suratKeluar = SuratKeluar::find($id);
        return view('admin.subkeg-lain.surat-keluar.details', compact('suratKeluar'));
    }
    public function file(string $id)
    {
        //
        $suratKeluar = SuratKeluar::findOrFail($id);
        $path = 'uploads/surat_keluar/' . $suratKeluar->file_surat;

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
        $suratKeluar = SuratKeluar::find($id);
        return view('admin.subkeg-lain.surat-keluar.edit', compact('suratKeluar'));
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
            if (Storage::exists('uploads/surat_keluar/' . $suratKeluar->file_surat)) {
                Storage::delete('uploads/surat_keluar/' . $suratKeluar->file_surat);
            }
        }
        $suratKeluar->update($request->all());
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = 'surat_keluar-' . $suratKeluar->id . '-' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/surat_keluar/' . $fileName;

            if (!Storage::exists('uploads/surat_keluar')) {
                Storage::makeDirectory('uploads/surat_keluar');
            }

            Storage::put($filePath, file_get_contents($file));
            $suratKeluar->file_surat = $fileName;
            $suratKeluar->save();
        }
        return redirect()->route('subkeg-lain.surat-keluar.index')->with('success', 'Surat Keluar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $suratKeluar = SuratKeluar::find($id);
        if (Storage::exists('uploads/surat_keluar/' . $suratKeluar->file_surat)) {
            Storage::delete('uploads/surat_keluar/' . $suratKeluar->file_surat);
        }
        $suratKeluar->delete();
        return redirect()->route('subkeg-lain.surat-keluar.index')->with('success', 'Surat Keluar berhasil dihapus.');
    }
}
