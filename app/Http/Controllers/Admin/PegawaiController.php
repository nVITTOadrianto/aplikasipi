<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // Ambil input dari form pencarian
        $search = $request->input('search');

        // Query dasar
        $query = Pegawai::query();

        // Filter berdasarkan Nama atau Jabatan
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        // Ambil data dengan paginasi
        $pegawaiPegawai = $query->orderBy("created_at", "asc")->paginate(5);

        return view('admin.pegawai.index', compact('pegawaiPegawai', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $pegawai = $this->validate($request, [
            'nip' => 'required|string|max:30',
            'nama' => 'required|string|max:50',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'golongan' => 'required|string|max:5',
            'ruang' => 'required|string|max:1',
            'pangkat' => 'required|string|max:50',
            'jabatan' => 'required|string|max:100',
            'jabatan_ttd' => 'nullable|string|max:50',
        ]);
        Pegawai::create($pegawai);
        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil ditambahkan.');
    }

    /**
     * Import from excel newly created collective resources in storage.
     */
    public function import(Request $request)
    {
        //
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        $file = $request->file('file_excel');
        $path = $file->getRealPath();


        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $header = true;
        foreach ($rows as $row) {
            if ($header) {
                $header = false;
                continue;
            }
            Pegawai::create([
                'nip'           => $row['A'] ?? '',
                'nama'          => $row['B'] ?? '',
                'tempat_lahir'  => $row['C'] ?? '',
                'tanggal_lahir' => $row['D'] ?? '',
                'golongan'      => $row['E'] ?? '',
                'ruang'         => $row['F'] ?? '',
                'pangkat'       => $row['G'] ?? '',
                'jabatan'       => $row['H'] ?? '',
                'jabatan_ttd'   => $row['I'] ?? null,
            ]);
        }

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil diimpor dan ditambahkan.');
    }

    /**
     * Export to excel the collective resources in storage.
     */
    public function export()
    {
        $pegawai = Pegawai::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'NIP');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Tempat Lahir');
        $sheet->setCellValue('D1', 'Tanggal Lahir');
        $sheet->setCellValue('E1', 'Golongan');
        $sheet->setCellValue('F1', 'Ruang');
        $sheet->setCellValue('G1', 'Pangkat');
        $sheet->setCellValue('H1', 'Jabatan');
        $sheet->setCellValue('I1', 'Jabatan TTD');

        // Fill data
        $row = 2;
        foreach ($pegawai as $data) {
            $sheet->setCellValue('A' . $row, $data->nip);
            $sheet->setCellValue('B' . $row, $data->nama);
            $sheet->setCellValue('C' . $row, $data->tempat_lahir);
            $sheet->setCellValue('D' . $row, $data->tanggal_lahir);
            $sheet->setCellValue('E' . $row, $data->golongan);
            $sheet->setCellValue('F' . $row, $data->ruang);
            $sheet->setCellValue('G' . $row, $data->pangkat);
            $sheet->setCellValue('H' . $row, $data->jabatan);
            $sheet->setCellValue('I' . $row, $data->jabatan_ttd);
            $row++;
        }

        // Download response
        $writer = new Xlsx($spreadsheet);
        $filename = 'data_pegawai.xlsx';

        // Set headers for download
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $pegawai = Pegawai::findOrFail($id);
        return view('admin.pegawai.details', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $pegawai = Pegawai::findOrFail($id);
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $pegawai = $this->validate($request, [
            'nip' => 'required|string|max:30',
            'nama' => 'required|string|max:50',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'golongan' => 'required|string|max:5',
            'ruang' => 'required|string|max:1',
            'pangkat' => 'required|string|max:50',
            'jabatan' => 'required|string|max:100',
            'jabatan_ttd' => 'nullable|string|max:50',
        ]);
        $pegawaiOld = Pegawai::findOrFail($id);

        $pegawaiOld->update($pegawai);
        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil dihapus.');
    }
}
