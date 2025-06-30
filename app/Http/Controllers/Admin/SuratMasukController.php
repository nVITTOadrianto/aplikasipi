<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $suratSuratMasuk = SuratMasuk::orderBy("created_at","desc")->paginate(10);
        return view('admin.surat-masuk.index', compact('suratSuratMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.surat-masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'pengirim' => 'required|string|max:255',
            'nomor_surat' => 'required|string|max:255|unique:surat_masuk,nomor_surat',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'nomor_agenda' => 'required|string|max:255',
            'sifat' => 'required|in:Biasa,Penting,Segera,Rahasia',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        $suratMasuk = SuratMasuk::create($request->all());
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/surat_masuk'), $filename);
            $suratMasuk->file_surat = $filename;
            $suratMasuk->save();
        }
        return redirect()->route('surat-masuk.index')->with('success', 'Surat Masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $suratMasuk = SuratMasuk::find($id);
        return view('admin.surat-masuk.details', compact('suratMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $suratMasuk = SuratMasuk::find($id);
        return view('admin.surat-masuk.edit', compact('suratMasuk'));
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
            'sifat' => 'required|in:Biasa,Penting,Segera,Rahasia',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        $suratMasuk = SuratMasuk::find($id);
        if ($request->hasFile('file_surat')) {
            if ($suratMasuk->file_surat) {
                unlink(public_path('storage/uploads/surat_masuk/' . $suratMasuk->file_surat));
            }
        }
        $suratMasuk->update($request->all());
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/surat_masuk'), $filename);
            $suratMasuk->file_surat = $filename;
            $suratMasuk->save();
        }
        return redirect()->route('surat-masuk.index')->with('success', 'Surat Masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $suratMasuk = SuratMasuk::find($id);
        if ($suratMasuk->file_surat) {
            unlink(public_path('storage/uploads/surat_masuk/' . $suratMasuk->file_surat));
        }
        $suratMasuk->delete();
        return redirect()->route('surat-masuk.index')->with('success', 'Surat Masuk berhasil dihapus.');
    }
}
