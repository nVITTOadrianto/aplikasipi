<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Rincian Biaya Perjalanan Dinas</title>
    <style>
        /* Font untuk DomPDF */
        @font-face {
            font-family: 'Calibri';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/calibri.ttf') }}) format('truetype');
        }

        @font-face {
            font-family: 'Calibri';
            font-style: normal;
            font-weight: bold;
            src: url({{ storage_path('fonts/calibri_bold.ttf') }}) format('truetype');
        }

        @font-face {
            font-family: 'Arial';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/arial.ttf') }}) format('truetype');
        }

        @font-face {
            font-family: 'Arial';
            font-style: normal;
            font-weight: bold;
            src: url({{ storage_path('fonts/arial_bold.ttf') }}) format('truetype');
        }

        /* Mengatur font dan ukuran dasar */
        body {
            font-size: 11pt;
        }

        .text-small {
            font-size: 9pt;
        }

        /* Kontainer untuk setiap halaman */
        .page {
            width: 100%;
            page-break-after: always;
            /* Memberi jeda halaman saat dicetak */
            position: relative;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        /* Tabel utama */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
        }

        /* Styling khusus untuk halaman DOP */
        .dop-page {
            font-family: "Calibri", sans-serif;
        }

        .dop-page .header {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            padding-bottom: 10px;
        }

        .dop-page .no-border,
        .dop-page .no-border td {
            border: none;
        }

        .dop-page .main-table,
        .dop-page .main-table td {
            border-right: 1px solid black;
        }

        /* Styling khusus untuk halaman Rincian */
        .rincian-page {
            font-family: Arial, sans-serif;
        }

        .rincian-page .header {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            padding-bottom: 20px;
        }

        .rincian-page .main-table,
        .rincian-page .main-table td,
        .rincian-page .main-table th {
            border: 1px solid black;
        }

        .rincian-page .main-table th {
            font-weight: normal;
        }

        .rincian-page .nama-column {
            text-align: left;
        }

        .rincian-page .ttd-column {
            text-align: left;
        }

        /* Utility classes */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .font-italic {
            font-style: italic;
        }

        .underline {
            text-decoration: underline;
        }

        .small-text {
            font-size: 9pt;
        }

        .signature-space {
            height: 60px;
        }
    </style>
</head>

<body>
    <div class="page dop-page">
        <div class="header" style="margin-bottom: 10px">
            RINCIAN BIAYA PERJALANAN DINAS
        </div>
        <table class="no-border" style="margin-bottom: 20px">
            <tr>
                <td style="width: 25%">Lampiran SPD Nomor</td>
                <td style="width: 75%">: {{$rincianBiaya->sppd->nomor_surat}}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $rincianBiaya->sppd->tanggal_pulang?->isoFormat('D MMMM YYYY') }}</td>
            </tr>
        </table>

        <table class="main-table" style="border: 1px solid black">
            <tr class="text-center font-bold" style="border: 1px solid black">
                <td style="width: 5%">NO</td>
                <td style="width: 55%" colspan="12">PERINCIAN BIAYA</td>
                <td style="width: 15%" colspan="2">JUMLAH</td>
                <td style="width: 35%">KETERANGAN</td>
            </tr>
            <tr>
                <td class="text-center">1.</td>
                <td colspan="12">Biaya Angkutan Pegawai dengan:</td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr style="font-weight: bold">
                <td></td>
                <td colspan="12">Plane, KA, Kapal Laut, Taksi/Bus</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td style="font-weight: normal">An :</td>
            </tr>
            <tr>
                <td></td>
                <td style="border-right: none">- Pergi</td>
                <td style="border-right: none">:</td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">org</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">Rp.</td>
                <td colspan="6">{{$rincianBiaya->biaya_pergi}}</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td style="padding-left: 30px">1. {{ $rincianBiaya->sppd->pelaksana->nama }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="border-right: none">- Pulang</td>
                <td style="border-right: none">:</td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">org</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">Rp.</td>
                <td colspan="6">{{$rincianBiaya->biaya_pulang}}</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                @if ($rincianBiaya->sppd->pengikut_1)
                    <td style="padding-left: 30px">2. {{ $rincianBiaya->sppd->pengikut_1->nama }}</td>
                @endif
            </tr>
            <tr>
                <td></td>
                <td colspan="12"></td>
                <td colspan="2"></td>
                @if ($rincianBiaya->sppd->pengikut_2)
                    <td style="padding-left: 30px">3. {{ $rincianBiaya->sppd->pengikut_2->nama }}</td>
                @endif
            </tr>
            <tr>
                <td class="text-center">2.</td>
                <td colspan="12">Biaya Harian:</td>
                <td colspan="2"></td>
                @if ($rincianBiaya->sppd->pengikut_3)
                    <td style="padding-left: 30px">4. {{ $rincianBiaya->sppd->pengikut_3->nama }}</td>
                @endif
            </tr>
            <tr style="font-weight: bold">
                <td></td>
                <td colspan="12">- Penginapan</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol IV
                </td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">org</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">Hari</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">Rp.</td>
                <td style="border-right: none">{{$rincianBiaya->biaya_penginapan_4}}</td>
                <td style="border-right: none">x</td>
                <td>30%</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol III
                </td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">org</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">Hari</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">Rp.</td>
                <td style="border-right: none">{{$rincianBiaya->biaya_penginapan_3}}</td>
                <td style="border-right: none">x</td>
                <td>30%</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol II
                </td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">org</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">Hari</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">Rp.</td>
                <td style="border-right: none">{{$rincianBiaya->biaya_penginapan_2}}</td>
                <td style="border-right: none">x</td>
                <td>30%</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol I
                </td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">org</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">Hari</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">Rp.</td>
                <td style="border-right: none">{{$rincianBiaya->biaya_penginapan_1}}</td>
                <td style="border-right: none">x</td>
                <td>30%</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-bottom: 12px"></td>
                <td colspan="12"></td>
                <td colspan="2"></td>
            </tr>
            <tr style="font-weight: bold">
                <td></td>
                <td colspan="12">- Uang Harian</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol IV
                </td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">org</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">Hari</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">Rp.</td>
                <td colspan="3">{{$rincianBiaya->uang_harian}}</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol III
                </td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">org</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">Hari</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">Rp.</td>
                <td colspan="3">{{$rincianBiaya->uang_harian}}</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol II
                </td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">org</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">Hari</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">Rp.</td>
                <td colspan="3">{{$rincianBiaya->uang_harian}}</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol I
                </td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">org</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">-</td>
                <td style="border-right: none">Hari</td>
                <td style="border-right: none">x</td>
                <td style="border-right: none">Rp.</td>
                <td colspan="3">{{$rincianBiaya->uang_harian}}</td>
                <td style="border-right: none">Rp.</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-bottom: 12px"></td>
                <td colspan="12"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td class="text-center">3.</td>
                <td colspan="12">BIAYA :</td>
                <span style="font-weight: bold">
                    <td style="border-right: none">Rp.</td>
                    <td>-</td>
                </span>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="12">- Penerbangan {{$rincianBiaya->keterangan_penerbangan}}</td>
                <td style="border-right: none">Rp.</td>
                <td>{{$rincianBiaya->biaya_penerbangan}}</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="12">- Biaya Tol {{$rincianBiaya->keterangan_tol}}</td>
                <td style="border-right: none">Rp.</td>
                <td>{{$rincianBiaya->biaya_tol}}</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="12">- Biaya Lain-Lain {{$rincianBiaya->keterangan_lain}}</td>
                <td style="border-right: none">Rp.</td>
                <td>{{$rincianBiaya->biaya_lain}}</td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-bottom: 12px"></td>
                <td colspan="12"></td>
                <td colspan="2"></td>
            </tr>
            <tr style="border: 1px solid black">
                <td></td>
                <td class="text-center font-bold" style="vertical-align: middle" colspan="12">
                    JUMLAH
                </td>
                <td class="text-left font-bold" style="vertical-align: middle; border-right: none">
                    Rp.
                </td>
                <td class="text-left font-bold" style="vertical-align: middle">
                    -
                </td>
                <td class="text-left text-small">
                    Satu Juta Empat Ratus Delapan Puluh Lima Ribu Rupiah
                </td>
            </tr>
        </table>
        <table class="no-border" style="margin-top: 20px">
            <tr>
                <td style="width: 60%">
                    <br />
                    Telah dibayar sejumlah :<br />
                    <strong>Rp. [Total Biaya Dibayar]</strong>
                </td>
                <td style="width: 40%" class="text-left">
                    Bandar Lampung, [Tanggal Sekarang]<br />
                    Telah menerima jumlah uang sebesar :<br />
                    <strong>Rp. [Total Biaya Diterima]</strong>
                </td>
            </tr>
            <tr>
                <td>
                    Bendahara Pengeluaran
                    <div class="signature-space"></div>
                    <b class="underline">ELMA KAISI, S.E.</b><br />
                    NIP. 19771215 200604 2 011
                </td>
                <td class="text-left">
                    Yang Menerima
                    <div class="signature-space"></div>
                    <b class="underline">{{$rincianBiaya->sppd->pelaksana->nama}}</b><br />
                    NIP. {{$rincianBiaya->sppd->pelaksana->nip}}
                </td>
            </tr>
            <tr>
                <td colspan="2"
                    style="
                            font-weight: bold;
                            border-top: 1px solid black;
                            text-align: center;
                        ">
                    PERHITUNGAN SPD RAMPUNG
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="no-border" style="width: 40%">
                        <tr>
                            <td style="width: 60%">Ditetapkan Sejumlah</td>
                            <td style="width: 1%;">Rp.</td>
                            <td class="text-right" style="padding: 0 12px;">-</td>
                        </tr>
                        <tr>
                            <td>Yang telah dibayar semula</td>
                            <td style="border-bottom: 1px solid black;">Rp.</td>
                            <td class="text-right" style="padding: 0 12px; border-bottom: 1px solid black;">-</td>
                        </tr>
                        <tr>
                            <td>Sisa Kurang/Lebih</td>
                            <td>Rp.</td>
                            <td class="text-right" style="padding: 0 12px;">-</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center" style="padding-top: 20px">
                    Pengguna Anggaran
                    <div class="signature-space"></div>
                    <b class="underline">{{$rincianBiaya->sppd->pemberi_wewenang->nama}}</b><br />
                    NIP. {{$rincianBiaya->sppd->pemberi_wewenang->nip}}
                </td>
            </tr>
        </table>
    </div>

    <div class="page rincian-page">
        <table class="no-border" style="margin-bottom: 60px">
            <tr>
                <td colspan="2">Rincian biaya perjalanan Dinas</td>
            </tr>
            <tr>
                <td style="width: 20%">Berdasarkan</td>
                <td style="width: 80%">: [Nomor SPT]</td>
            </tr>
            <tr>
                <td>Atas Nama</td>
                <td>: {{ $rincianBiaya->sppd->pelaksana->nama }}</td>
            </tr>
            <tr>
                <td>Pengikut</td>
                <td>: [Jumlah Pengikut] orang</td>
            </tr>
            <tr>
                <td>Selama</td>
                <td>: {{$rincianBiaya->sppd->jumlah_hari}} hari</td>
            </tr>
            <tr>
                <td>Dari tanggal</td>
                <td>: {{ $rincianBiaya->sppd->tanggal_pulang?->isoFormat('D MMMM YYYY') }}</td>
            </tr>
        </table>

        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 5%">No.</th>
                    <th style="width: 40%">N a m a</th>
                    <th style="width: 10%">Gol.</th>
                    <th style="width: 20%">Besar Biaya</th>
                    <th style="width: 25%">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1.</td>
                    <td class="nama-column">[Nama Pegawai 1]</td>
                    <td class="text-center">[Gol. 1]</td>
                    <td class="text-right">Rp. [Biaya 1]</td>
                    <td class="ttd-column">1. ....................</td>
                </tr>
                <tr>
                    <td class="text-center">2.</td>
                    <td class="nama-column">[Nama Pegawai 2]</td>
                    <td class="text-center">[Gol. 2]</td>
                    <td class="text-right">Rp. [Biaya 2]</td>
                    <td class="ttd-column">2. ....................</td>
                </tr>
                <tr>
                    <td class="text-center">3.</td>
                    <td class="nama-column">[Nama Pegawai 3]</td>
                    <td class="text-center">[Gol. 3]</td>
                    <td class="text-right">Rp. [Biaya 3]</td>
                    <td class="ttd-column">3. ....................</td>
                </tr>
                <tr class="font-bold">
                    <td colspan="2" class="text-center">JUMLAH</td>
                    <td class="text-center">:</td>
                    <td class="text-right">Rp. [Total Biaya]</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5" class="nama-column font-bold font-italic">
                        Terbilang: [Total Terbilang]
                    </td>
                </tr>
            </tbody>
        </table>

        <div
            style="
                    width: 40%;
                    float: right;
                    text-align: center;
                    margin-top: 30px;
                ">
            Bandar Lampung, [Tanggal Sekarang]<br />
            Ketua Rombongan,
            <div class="signature-space"></div>
            <b class="underline">[Nama Ketua Rombongan]</b><br />
            NIP. [NIP Ketua Rombongan]
        </div>
    </div>
</body>

</html>
