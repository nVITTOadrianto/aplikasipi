<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Perjalanan Dinas (SPD)</title>
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

        @font-face {
            font-family: 'Bookman Old Style';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/bookmanoldstyle.ttf') }}) format('truetype');
        }

        @font-face {
            font-family: 'Bookman Old Style';
            font-style: normal;
            font-weight: bold;
            src: url({{ storage_path('fonts/bookmanoldstyle_bold.ttf') }}) format('truetype');
        }

        @page {
            margin: 0.9cm;
        }

        body {
            font-family: "Bookman Old Style", Georgia, serif;
            font-size: 11pt;
            line-height: 10pt;
            padding: 0px;
            background-color: white;
        }

        /* Kontainer untuk setiap halaman */
        .page {
            width: 100%;
            page-break-after: always;
            /* Memberi jeda halaman saat dicetak */
            position: relative;
            height: 98%;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        .dop-page {
            font-family: "Calibri", sans-serif;
        }

        .rincian-page {
            font-family: Arial, sans-serif;
        }

        .appendix-page {
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            vertical-align: center;
        }

        .main-title {
            text-align: center;
            font-size: 12pt;
            text-decoration: underline;
            margin-bottom: 10px;
        }

        .top-right {
            text-align: left;
        }

        .main-table {
            margin-left: 20px;
        }

        .main-table,
        .main-table td {
            border: 1px solid black;
            padding: 6px;
        }

        .main-table .label-col {
            width: 5%;
            text-align: right;
            vertical-align: center;
            padding-right: 10px;
        }

        .main-table .desc-col {
            width: 35%;
        }

        .main-table .content-col {
            width: 60%;
        }

        .no-border,
        .no-border td,
        .no-border th {
            border: none;
        }

        .signature-section {
            height: 60px;
        }

        .attention-section {
            text-align: justify;
        }

        /* Styling khusus untuk halaman DOP */
        .dop-page {
            font-family: "Calibri", sans-serif;
        }

        .dop-page .header {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            padding-bottom: 10px;
        }

        /* Styling khusus untuk halaman Rincian */
        .rincian-page {
            font-family: Arial, sans-serif;
            font-size: 12pt;
        }

        .rincian-page .nama-column {
            text-align: left;
        }

        .rincian-page .ttd-column {
            text-align: left;
        }

        /* Tabel DOP */
        .dop-table,
        .dop-table td {
            border-right: 1px solid black;
        }

        /* Tabel Rincian */
        .rincian-table,
        .rincian-table td,
        .rincian-table th {
            border: 1px solid black;
            line-height: 12pt;
        }

        .rincian-table th {
            font-weight: bold;
        }

        .rincian-table td {
            padding: 6px 3px;
        }
        
        /* ============== BKP PAGE STYLES ============== */
        /* The BKP page now uses a background image. */
        /* Ensure you have 'bkp_background.png' in your public/images folder. */
        .bkp-page {
            background-size: 100% 100%;
            background-repeat: no-repeat;
            position: relative;
            font-family: 'Times New Roman', serif;
            font-size: 10pt;
            line-height: 1.2;
        }
        /* ============== END BKP PAGE STYLES ============== */


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
            font-size: 7pt;
        }

        .signature-space {
            height: 60px;
        }
    </style>
</head>

<body>

    <div class="page main-page">

        <img src="/public/header_surat.png" alt="Header" style="width:100%; height:auto; max-height:170px;">

        <table class="no-border" style="margin-bottom: 12px;">
            <tr>
                <td style="width: 60%;"></td>
                <td class="top-right">
                    Lembar ke : {{ $sppd->lembar_ke ?? '………………………….. ' }}<br>
                    Kode No.: {{ $sppd->kode ?? '………………………….. ' }}<br>
                    Nomor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $sppd->nomor_surat ?? '………………………….. ' }}
                </td>
            </tr>
        </table>

        <div class="main-title">SURAT PERJALANAN DINAS (SPD)</div>

        <table class="main-table">
            <tbody>
                <tr>
                    <td class="label-col">1.</td>
                    <td class="desc-col">Pejabat berwenang yang memberi Perintah</td>
                    <td colspan="2" class="content-col">{{ $sppd->pemberi_wewenang->jabatan }}
                    </td>
                </tr>
                <tr>
                    <td class="label-col">2.</td>
                    <td class="desc-col">Nama/NIP Pegawai yang melaksanakan perjalanan dinas</td>
                    <td colspan="2" class="content-col">
                        {{ $sppd->pelaksana->nama }}<br>
                        NIP. {{ $sppd->pelaksana->nip }}
                    </td>
                </tr>
                <tr>
                    <td class="label-col">3.</td>
                    <td class="desc-col">
                        a. Pangkat dan Golongan<br>
                        b. Jabatan/Instansi<br>
                        c. Tingkat Biaya Perjalanan Dinas
                    </td>
                    <td colspan="2" class="content-col">
                        {{ $sppd->pelaksana->golongan }}/{{ $sppd->pelaksana->ruang }}<br>
                        {{ $sppd->pelaksana->jabatan_ttd }}<br>
                        {{ $sppd->tingkat_biaya }}
                    </td>
                </tr>
                <tr>
                    <td class="label-col">4.</td>
                    <td class="desc-col">Maksud Perjalanan Dinas</td>
                    <td colspan="2" class="content-col">{{ $sppd->maksud }}</td>
                </tr>
                <tr>
                    <td class="label-col">5.</td>
                    <td class="desc-col">Alat angkut yang dipergunakan</td>
                    <td colspan="2" class="content-col">{{ $sppd->alat_angkut }}</td>
                </tr>
                <tr>
                    <td class="label-col">6.</td>
                    <td class="desc-col">
                        a. Tempat berangkat<br>
                        b. Tempat Tujuan
                    </td>
                    <td colspan="2" class="content-col">
                        {{ $sppd->tempat_berangkat }}<br>
                        {{ $sppd->tempat_tujuan }}
                    </td>
                </tr>
                <tr>
                    <td class="label-col">7.</td>
                    <td class="desc-col">
                        a. Lamanya Perjalanan Dinas<br>
                        b. Tanggal berangkat<br>
                        c. Tanggal harus kembali/tiba di tempat baru *)
                    </td>
                    <td colspan="2" class="content-col">
                        {{ $sppd->jumlah_hari . ' (' . Number::spell($sppd->jumlah_hari, 'id') . ')' }} hari<br>
                        {{ $sppd->tanggal_berangkat->isoFormat('D MMMM YYYY') }}<br>
                        {{ $sppd->tanggal_kembali->isoFormat('D MMMM YYYY') }}
                    </td>
                </tr>
                <tr>
                    <td class="label-col">8.</td>
                    <td style="text-align:left; padding-left:5px;">Pengikut : Nama</td>
                    <td style="text-align:left; width: 20%;">Tanggal Lahir</td>
                    <td style="text-align:left; width: 40%;">Keterangan</td>
            <tbody>
                <tr>
                    <td rowspan="3" class="label-col">9.</td>
                    <td>{{ $sppd->pengikut_1 ? '1. ' . $sppd->pengikut_1->nama : '' }}</td>
                    <td>{{ $sppd->pengikut_1?->tanggal_lahir?->isoFormat('D MMMM YYYY') ?? '' }}</td>
                    <td>{{ $sppd->pengikut_1->jabatan_ttd ?? '' }}</td>
                </tr>
                <tr>
                    <td>{{ $sppd->pengikut_2 ? '2. ' . $sppd->pengikut_2->nama : '' }}</td>
                    <td>{{ $sppd->pengikut_2?->tanggal_lahir?->isoFormat('D MMMM YYYY') ?? '' }}</td>
                    <td>{{ $sppd->pengikut_2->jabatan_ttd ?? '' }}</td>
                </tr>
                <tr>
                    <td>{{ $sppd->pengikut_3 ? '3. ' . $sppd->pengikut_3->nama : '' }}</td>
                    <td>{{ $sppd->pengikut_3?->tanggal_lahir?->isoFormat('D MMMM YYYY') ?? '' }}</td>
                    <td>{{ $sppd->pengikut_3->jabatan_ttd ?? '' }}</td>
                </tr>
            </tbody>
            </td>
            </tr>
            <tr>
                <td class="label-col">10.</td>
                <td class="desc-col">
                    Pembebanan Anggaran<br>
                    a. Instansi<br>
                    b. Akun
                </td>
                <td colspan="2" class="content-col"><br>
                    {{ $sppd->instansi_pembebanan_anggaran }}<br>
                    {{ $sppd->akun_pembebanan_anggaran }}
                </td>
            </tr>
            <tr>
                <td class="label-col">11.</td>
                <td class="desc-col">Keterangan lain-lain</td>
                <td colspan="2" class="content-col">{{ $sppd->keterangan ?? '' }}</td>
            </tr>
            </tbody>
        </table>
        <div style="text-align: left; padding-left: 10px;">*coret yang tidak perlu</div>

        <table class="no-border">
            <tr>
                <td style="width: 50%;"></td>
                <td>
                    Dikeluarkan di : Bandar Lampung<br>
                    Tanggal : {{ $sppd->tanggal_dibuat_surat->isoFormat('D MMMM YYYY') }}<br>
                    <b>{{ strtoupper($sppd->pemberi_wewenang->jabatan_ttd) }},</b><br>
                    <div class="signature-section"></div>
                    <b><u>{{ $sppd->pemberi_wewenang->nama }}</u></b><br>
                    NIP. {{ $sppd->pemberi_wewenang->nip }}
                </td>
            </tr>
        </table>

    </div>
    <div class="page appendix-page">

        <table class="no-border">
            <tbody>
                <tr>
                    <td style="width: 5%;">

                    </td>
                    <td style="width: 30%;">

                    </td>
                    <td style="width: 60%;"></td>
                    <td style="width: 5%;">
                        I.
                    </td>
                    <td style="width: 30%;">
                        Berangkat dari<br>
                        (Tempat Kedudukan)<br>
                        Ke<br>
                        Pada Tanggal<br>
                    </td>
                    <td style="width: 60%">
                        : {{ $sppd->tempat_berangkat }}<br>
                        : {{ $sppd->tempat_kedudukan }}<br><br>
                        :
                        <span style="color: white;">
                        {{ $sppd->tempat_tujuan }}<br>
                        </span>
                        :
                        <span style="color: white;">
                        {{ $sppd->tanggal_berangkat->isoFormat('D MMMM YYYY') }}<br>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2"></td>
                    <td></td>
                    <td colspan="2">
                        <b>Pejabat Pelaksana<br>Teknis Kegiatan</b><br>
                        <div class="signature-section"></div>
                        <b><u>{{ $sppd->mengetahui->nama ?? '(…………………………………….……….)' }}</u></b><br>
                        NIP. {{ $sppd->mengetahui->nip ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td>II.</td>
                    <td>
                        Tiba di<br>
                        Pada Tanggal<br>
                        Kepala<br>

                    </td>
                    <td>
                        : 
                        <span style="color: white;">
                            {{ $sppd->tempat_tujuan }}<br>
                        </span>
                        : 
                        <span style="color: white;">
                            {{ $sppd->tanggal_tiba?->isoFormat('D MMMM YYYY') ?? '' }}<br>
                        </span>
                        :
                        <span style="color: white;">
                            {{ $sppd->kepala_jabatan_di_tempat ?? '' }}<br>
                        </span>
                    </td>
                    <td></td>
                    <td>
                        Berangkat dari<br>
                        Ke<br>
                        Pada tanggal<br>
                        Kepala<br>
                    </td>
                    <td>
                        : 
                        <span style="color: white;">
                        {{ $sppd->tempat_tujuan }}<br>
                        </span>
                        : 
                        <span style="color: white;">
                        {{ $sppd->tempat_berangkat }}<br>
                        </span>
                        : 
                        <span style="color: white;">
                        {{ $sppd->tanggal_kembali->isoFormat('D MMMM YYYY') }}<br>
                        </span>
                        :
                        <span style="color: white;">
                            {{ $sppd->kepala_jabatan_di_tempat ?? '' }}<br>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px; color: white;">
                        <div class="signature-section"></div>
                        ({{ $sppd->nama_di_tempat ?? '…………………………………….……….' }})<br>
                        NIP. {{ $sppd->nip_di_tempat ?? '' }}
                    </td>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px; color: white;">
                        <div class="signature-section"></div>
                        ({{ $sppd->nama_di_tempat ?? '…………………………………….……….' }})<br>
                        NIP. {{ $sppd->nip_di_tempat ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td>III.</td>
                    <td>
                        Tiba di<br>
                        Pada Tanggal<br>
                        Kepala<br>
                    </td>
                    <td>
                        : <br>
                        : <br>
                        : <br>
                    </td>
                    <td></td>
                    <td>
                        Berangkat dari<br>
                        Ke<br>
                        Pada tanggal<br>
                        Kepala<br>
                    </td>
                    <td>
                        : <br>
                        : <br>
                        : <br>
                        : <br>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px; color: white;">
                        <div class="signature-section"></div>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px; color: white;">
                        <div class="signature-section"></div>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                </tr>
                <tr>
                    <td>IV.</td>
                    <td>
                        Tiba di<br>
                        Pada Tanggal<br>
                        Kepala<br>
                    </td>
                    <td>
                        : <br>
                        : <br>
                        : <br>
                    </td>
                    <td></td>
                    <td>
                        Berangkat dari<br>
                        Ke<br>
                        Pada tanggal<br>
                        Kepala<br>
                    </td>
                    <td>
                        : <br>
                        : <br>
                        : <br>
                        : <br>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px; color: white;">
                        <div class="signature-section"></div>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px; color: white;">
                        <div class="signature-section"></div>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                </tr>
                <tr>
                    <td>V.</td>
                    <td>
                        Tiba di<br><br>
                        Pada Tanggal<br>
                        Kepala<br><br>
                    </td>
                    <td>
                        : <br><br>
                        : <br>
                        : <br><br>
                    </td>
                    <td></td>
                    <td colspan="2" class="attention-section">
                        Telah diperiksa, dengan keterangan bahwa perjalanan tersebut di atas benar dilakukan atas
                        perintahnya dan semata-mata untuk kepentingan Jabatan dalam waktu sesingkat-singkatnya.
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <b>Pejabat yang berwenang,</b><br>
                        <div class="signature-section"></div>
                        <b><u>{{ $sppd->pemberi_wewenang->nama }}</u></b><br>
                        NIP. {{ $sppd->pemberi_wewenang->nip }}
                    </td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>VI.</td>
                    <td colspan="5">CATATAN LAIN-LAIN</td>
                </tr>
                <tr>
                    <td>VII.</td>
                    <td colspan="5">
                        <u>PERHATIAN : </u>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="5" class="attention-section">
                        PPK yang menerbitkan SPD, Pegawai yang melakukan Perjalanan Dinas, para pejabat yang mengesahkan
                        tanggal berangkat/tiba serta Bendahara Pengeluaran bertanggung jawab berdasarkan
                        peraturan-peraturan Keuangan Negara, apabila Negara menderita rugi akibat kesalahan, kelalaian
                        dan kealpaannya.
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="page dop-page">
        <div class="header" style="margin-bottom: 10px">
            RINCIAN BIAYA PERJALANAN DINAS
        </div>
        <table class="no-border" style="margin-bottom: 20px">
            <tr>
                <td style="width: 25%">Lampiran SPD Nomor</td>
                <td style="width: 75%">: {{ $rincianBiaya->sppd->nomor_surat }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $rincianBiaya->sppd->tanggal_kembali?->isoFormat('D MMMM YYYY') }}</td>
            </tr>
        </table>

        <table class="dop-table" style="border: 1px solid black">
            <tr class="text-center font-bold" style="border: 1px solid black">
                <td style="width: 5%">NO</td>
                <td style="width: 60%" colspan="12">PERINCIAN BIAYA</td>
                <td style="width: 15%" colspan="2">JUMLAH</td>
                <td style="width: 30%">KETERANGAN</td>
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
                @if ($totalPengikut != 0 && ((int) trim($rincianBiaya->biaya_pergi) > 0 || (int) trim($rincianBiaya->biaya_pulang) > 0))
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalAngkutan, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td style="font-weight: normal">An :</td>
            </tr>
            <tr>
                <td></td>
                <td style="border-right: none">- Pergi</td>
                @if ($totalPengikut != 0 && (int) trim($rincianBiaya->biaya_pergi) > 0)
                    <td style="border-right: none">:</td>
                    <td style="border-right: none">{{ $totalPengikut }}</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td colspan="6">{{ $rincianBiaya->biaya_pergi }}</td>
                    <td style="border-right: none">Rp.</td>
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalPergi, 0, ',', '.') }}</td>
                @else
                    <td style="border-right: none">:</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td colspan="6">-</td>
                    <td style="border-right: none">Rp.</td>
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td style="padding-left: 25px">1. {{ $rincianBiaya->sppd->pelaksana->nama }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="border-right: none">- Pulang</td>
                @if ($totalPengikut != 0 && (int) trim($rincianBiaya->biaya_pulang) > 0)
                    <td style="border-right: none">:</td>
                    <td style="border-right: none">{{ $totalPengikut }}</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td colspan="6">{{ $rincianBiaya->biaya_pulang }}</td>
                    <td style="border-right: none">Rp.</td>
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalPulang, 0, ',', '.') }}</td>
                @else
                    <td style="border-right: none">:</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td colspan="6">-</td>
                    <td style="border-right: none">Rp.</td>
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                @if ($rincianBiaya->sppd->pengikut_1)
                    <td style="padding-left: 25px">2. {{ $rincianBiaya->sppd->pengikut_1->nama }}</td>
                @else
                    <td></td>
                @endif
            </tr>
            <tr>
                <td></td>
                <td colspan="12"></td>
                <td colspan="2"></td>
                @if ($rincianBiaya->sppd->pengikut_2)
                    <td style="padding-left: 25px">3. {{ $rincianBiaya->sppd->pengikut_2->nama }}</td>
                @else
                    <td></td>
                @endif
            </tr>
            <tr>
                <td class="text-center">2.</td>
                <td colspan="12">Biaya Harian:</td>
                <td colspan="2"></td>
                @if ($rincianBiaya->sppd->pengikut_3)
                    <td style="padding-left: 25px">4. {{ $rincianBiaya->sppd->pengikut_3->nama }}</td>
                @else
                    <td></td>
                @endif
            </tr>
            <tr style="font-weight: bold">
                <td></td>
                <td colspan="12">- Penginapan</td>
                <td style="border-right: none">Rp.</td>
                @if (
                    $totalPengikut != 0 &&
                        ((int) trim($rincianBiaya->biaya_penginapan_4) > 0 ||
                            (int) trim($rincianBiaya->biaya_penginapan_3) > 0 ||
                            (int) trim($rincianBiaya->biaya_penginapan_2) > 0 ||
                            (int) trim($rincianBiaya->biaya_penginapan_1) > 0))
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalPenginapan, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol IV
                </td>
                @if ($totalGolIV != 0 && (int) trim($rincianBiaya->biaya_penginapan_4) > 0)
                    <td style="border-right: none">{{ $totalGolIV }}</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">{{ $rincianBiaya->jumlah_hari_penginapan }}</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">{{ $rincianBiaya->biaya_penginapan_4 }}</td>
                @else
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">-</td>
                @endif
                @if ($menginap > 0)
                    <td style="border-right: none"></td>
                    <td></td>
                @else
                    <td style="border-right: none">x</td>
                    <td>30%</td>
                @endif
                <td style="border-right: none">Rp.</td>
                @if ($totalGolIV != 0 && (int) trim($rincianBiaya->biaya_penginapan_4) > 0)
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalPenginapan4, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol III
                </td>
                @if ($totalGolIII != 0 && (int) trim($rincianBiaya->biaya_penginapan_3) > 0)
                    <td style="border-right: none">{{ $totalGolIII }}</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">{{ $rincianBiaya->jumlah_hari_penginapan }}</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">{{ $rincianBiaya->biaya_penginapan_3 }}</td>
                @else
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">-</td>
                @endif
                @if ($menginap > 0)
                    <td style="border-right: none"></td>
                    <td></td>
                @else
                    <td style="border-right: none">x</td>
                    <td>30%</td>
                @endif
                <td style="border-right: none">Rp.</td>
                @if ($totalGolIII != 0 && (int) trim($rincianBiaya->biaya_penginapan_3) > 0)
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalPenginapan3, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol II
                </td>
                @if ($totalGolII != 0 && (int) trim($rincianBiaya->biaya_penginapan_2) > 0)
                    <td style="border-right: none">{{ $totalGolII }}</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">{{ $rincianBiaya->jumlah_hari_penginapan }}</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">{{ $rincianBiaya->biaya_penginapan_2 }}</td>
                @else
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">-</td>
                @endif
                @if ($menginap > 0)
                    <td style="border-right: none"></td>
                    <td></td>
                @else
                    <td style="border-right: none">x</td>
                    <td>30%</td>
                @endif
                <td style="border-right: none">Rp.</td>
                @if ($totalGolII != 0 && (int) trim($rincianBiaya->biaya_penginapan_2) > 0)
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalPenginapan2, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol I
                </td>
                @if ($totalGolI != 0 && (int) trim($rincianBiaya->biaya_penginapan_1) > 0)
                    <td style="border-right: none">{{ $totalGolI }}</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">{{ $rincianBiaya->jumlah_hari_penginapan }}</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">{{ $rincianBiaya->biaya_penginapan_1 }}</td>
                @else
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">-</td>
                @endif
                @if ($menginap > 0)
                    <td style="border-right: none"></td>
                    <td></td>
                @else
                    <td style="border-right: none">x</td>
                    <td>30%</td>
                @endif
                <td style="border-right: none">Rp.</td>
                @if ($totalGolI != 0 && (int) trim($rincianBiaya->biaya_penginapan_1) > 0)
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalPenginapan1, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td style="padding-bottom: 12px"></td>
                <td colspan="12"></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr style="font-weight: bold">
                <td></td>
                <td colspan="12">- Uang Harian</td>
                <td style="border-right: none">Rp.</td>
                @if ($totalPengikut != 0 && (int) trim($rincianBiaya->uang_harian))
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalHarian, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol IV
                </td>
                @if ($totalGolIV != 0 && (int) trim($rincianBiaya->uang_harian) > 0)
                    <td style="border-right: none">{{ $totalGolIV }}</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">{{ $rincianBiaya->sppd->jumlah_hari }}</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">{{ $rincianBiaya->uang_harian }}</td>
                    <td style="border-right: none"></td>
                    <td></td>
                @else
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none"></td>
                    <td></td>
                @endif
                <td style="border-right: none">Rp.</td>
                @if ($totalGolIV != 0 && (int) trim($rincianBiaya->uang_harian) > 0)
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalHarian4, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol III
                </td>
                @if ($totalGolIII != 0 && (int) trim($rincianBiaya->uang_harian) > 0)
                    <td style="border-right: none">{{ $totalGolIII }}</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">{{ $rincianBiaya->sppd->jumlah_hari }}</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">{{ $rincianBiaya->uang_harian }}</td>
                    <td style="border-right: none"></td>
                    <td></td>
                @else
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none"></td>
                    <td></td>
                @endif
                <td style="border-right: none">Rp.</td>
                @if ($totalGolIII != 0 && (int) trim($rincianBiaya->uang_harian) > 0)
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalHarian3, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol II
                </td>
                @if ($totalGolII != 0 && (int) trim($rincianBiaya->uang_harian) > 0)
                    <td style="border-right: none">{{ $totalGolII }}</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">{{ $rincianBiaya->sppd->jumlah_hari }}</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">{{ $rincianBiaya->uang_harian }}</td>
                    <td style="border-right: none"></td>
                    <td></td>
                @else
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none"></td>
                    <td></td>
                @endif
                <td style="border-right: none">Rp.</td>
                @if ($totalGolII != 0 && (int) trim($rincianBiaya->uang_harian) > 0)
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalHarian2, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 12px; border-right: none" colspan="2">
                    Gol I
                </td>
                @if ($totalGolI != 0 && (int) trim($rincianBiaya->uang_harian) > 0)
                    <td style="border-right: none">{{ $totalGolI }}</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">{{ $rincianBiaya->sppd->jumlah_hari }}</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">{{ $rincianBiaya->uang_harian }}</td>
                    <td style="border-right: none"></td>
                    <td></td>
                @else
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">org</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none">Hari</td>
                    <td style="border-right: none">x</td>
                    <td style="border-right: none">Rp.</td>
                    <td style="border-right: none">-</td>
                    <td style="border-right: none"></td>
                    <td></td>
                @endif
                <td style="border-right: none">Rp.</td>
                @if ($totalGolI != 0 && (int) trim($rincianBiaya->uang_harian) > 0)
                    <td class="text-right" style="padding-right: 6px">
                        {{ number_format($subtotalHarian1, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td style="padding-bottom: 12px"></td>
                <td colspan="12"></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center">3.</td>
                <td colspan="12">BIAYA :</td>
                <td style="border-right: none; font-weight: bold;">Rp.</td>
                @if (
                    $totalPengikut != 0 &&
                        ((int) trim($rincianBiaya->biaya_penerbangan) > 0 ||
                            (int) trim($rincianBiaya->biaya_tol) > 0 ||
                            (int) trim($rincianBiaya->biaya_lain) > 0))
                    <td class="text-right" style="font-weight: bold; padding-right: 6px;">
                        {{ number_format($subtotalLain, 0, ',', '.') }}</td>
                @else
                    <td class="text-right" style="font-weight: bold; padding-right: 12px;">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="12">- Penerbangan {{ $rincianBiaya->keterangan_penerbangan }}</td>
                <td style="border-right: none">Rp.</td>
                @if ((int) trim($rincianBiaya->biaya_penerbangan) > 0)
                    <td class="text-right" style="padding-right: 6px">{{ $rincianBiaya->biaya_penerbangan }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="12">- Biaya Tol {{ $rincianBiaya->keterangan_tol }}</td>
                <td style="border-right: none">Rp.</td>
                @if ((int) trim($rincianBiaya->biaya_tol) > 0)
                    <td class="text-right" style="padding-right: 6px">{{ $rincianBiaya->biaya_tol }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="12">- Biaya Lain-Lain {{ $rincianBiaya->keterangan_lain }}</td>
                <td style="border-right: none">Rp.</td>
                @if ((int) trim($rincianBiaya->biaya_lain) > 0)
                    <td class="text-right" style="padding-right: 6px">{{ $rincianBiaya->biaya_lain }}</td>
                @else
                    <td class="text-right" style="padding-right: 12px">-</td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td style="padding-bottom: 12px"></td>
                <td colspan="12"></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr style="border: 1px solid black">
                <td></td>
                <td class="text-center font-bold" style="vertical-align: middle" colspan="12">
                    JUMLAH
                </td>
                <td class="text-left font-bold" style="vertical-align: middle; border-right: none">
                    Rp.
                </td>
                <td class="text-right font-bold" style="vertical-align: middle; padding-right: 6px">
                    {{ number_format($totalBiaya, 0, ',', '.') }}
                </td>
                <td class="text-left text-small">
                    {{ ucwords(Number::spell($totalBiaya, 'id')) }} Rupiah
                </td>
            </tr>
        </table>
        <table class="no-border" style="margin-top: 20px">
            <tr>
                <td style="width: 60%">
                    <br />
                    Telah dibayar sejumlah :<br />
                    <strong>Rp. {{ number_format($totalBiaya, 0, ',', '.') }}</strong>
                </td>
                <td style="width: 40%" class="text-left">
                    Bandar Lampung,
                    &nbsp;&nbsp;&nbsp;&nbsp;{{ $sppd->tanggal_dibuat_surat->isoFormat('MMMM YYYY') }}<br />
                    Telah menerima jumlah uang sebesar :<br />
                    <strong>Rp. {{ number_format($totalBiaya, 0, ',', '.') }}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    Bendahara Pengeluaran
                    <div class="signature-space"></div>
                    <b class="underline">{{ $rincianBiaya->pegawai_bendahara->nama }}</b><br />
                    <b>NIP. {{ $rincianBiaya->pegawai_bendahara->nip }}</b>
                </td>
                <td class="text-left">
                    Yang Menerima
                    <div class="signature-space"></div>
                    <b class="underline">{{ $rincianBiaya->sppd->pelaksana->nama }}</b><br />
                    <b>NIP. {{ $rincianBiaya->sppd->pelaksana->nip }}</b>
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
                    <b class="underline">{{ $rincianBiaya->sppd->pemberi_wewenang->nama }}</b><br />
                    <b>NIP. {{ $rincianBiaya->sppd->pemberi_wewenang->nip }}</b>
                </td>
            </tr>
        </table>
    </div>

    <div class="page rincian-page">
        <table class="no-border" style="margin-top: 30px; margin-left: 30px; margin-bottom: 60px">
            <tr>
                <td colspan="2">Rincian biaya perjalanan Dinas</td>
            </tr>
            <tr>
                <td style="width: 20%">Berdasarkan</td>
                <td style="width: 80%">: </td>
            </tr>
            <tr>
                <td>Atas Nama</td>
                <td>: {{ $rincianBiaya->sppd->pelaksana->nama }}</td>
            </tr>
            <tr>
                <td>Pengikut</td>
                <td>: {{ $totalPengikut - 1 }} orang</td>
            </tr>
            <tr>
                <td>Selama</td>
                <td>: {{ $rincianBiaya->sppd->jumlah_hari }} hari</td>
            </tr>
            <tr>
                <td>Dari tanggal</td>
                <td>: {{ $rincianBiaya->sppd->tanggal_kembali?->isoFormat('D MMMM YYYY') }}</td>
            </tr>
        </table>

        <table class="rincian-table">
            <thead>
                <tr>
                    <th style="width: 5%">No.</th>
                    <th style="width: 40%">N a m a</th>
                    <th style="width: 10%">Gol.</th>
                    <th colspan="2" style="width: 20%">Besar Biaya</th>
                    <th colspan="2" style="width: 25%">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1.</td>
                    <td class="nama-column">{{ $rincianBiaya->sppd->pelaksana->nama }}</td>
                    <td class="text-center">
                        @if ($rincianBiaya->sppd->pelaksana->golongan && $rincianBiaya->sppd->pelaksana->ruang)
                            {{ $rincianBiaya->sppd->pelaksana->golongan }}/{{ $rincianBiaya->sppd->pelaksana->ruang }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-left" style="border-right: none;">Rp.</td>
                    <td class="text-right" style="border-left: none;">
                        {{ number_format($biayaPelaksana, 0, ',', '.') }}</td>
                    <td class="ttd-column">1. .........</td>
                    <td class="ttd-column"></td>
                </tr>
                @if ($rincianBiaya->sppd->pengikut_1)
                    <tr>
                        <td class="text-center">2.</td>
                        <td class="nama-column">{{ $rincianBiaya->sppd->pengikut_1->nama }}</td>
                        <td class="text-center">
                            @if ($rincianBiaya->sppd->pengikut_1->golongan && $rincianBiaya->sppd->pengikut_1->ruang)
                                {{ $rincianBiaya->sppd->pengikut_1->golongan }}/{{ $rincianBiaya->sppd->pengikut_1->ruang }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-left" style="border-right: none;">Rp.</td>
                        <td class="text-right" style="border-left: none;">
                            {{ number_format($biayaPengikut1, 0, ',', '.') }}</td>
                        <td class="ttd-column"></td>
                        <td class="ttd-column">2. .........</td>
                    </tr>
                @endif
                @if ($rincianBiaya->sppd->pengikut_2)
                    <tr>
                        <td class="text-center">3.</td>
                        <td class="nama-column">{{ $rincianBiaya->sppd->pengikut_2->nama }}</td>
                        <td class="text-center">
                            @if ($rincianBiaya->sppd->pengikut_2->golongan && $rincianBiaya->sppd->pengikut_2->ruang)
                                {{ $rincianBiaya->sppd->pengikut_2->golongan }}/{{ $rincianBiaya->sppd->pengikut_2->ruang }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-left" style="border-right: none;">Rp.</td>
                        <td class="text-right" style="border-left: none;">
                            {{ number_format($biayaPengikut2, 0, ',', '.') }}</td>
                        <td class="ttd-column">3. .........</td>
                        <td class="ttd-column"></td>

                    </tr>
                @endif
                @if ($rincianBiaya->sppd->pengikut_3)
                    <tr>
                        <td class="text-center">4.</td>
                        <td class="nama-column">{{ $rincianBiaya->sppd->pengikut_3->nama }}</td>
                        <td class="text-center">
                            @if ($rincianBiaya->sppd->pengikut_3->golongan && $rincianBiaya->sppd->pengikut_3->ruang)
                                {{ $rincianBiaya->sppd->pengikut_3->golongan }}/{{ $rincianBiaya->sppd->pengikut_3->ruang }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-left" style="border-right: none;">Rp.</td>
                        <td class="text-right" style="border-left: none;">
                            {{ number_format($biayaPengikut3, 0, ',', '.') }}</td>
                        <td class="ttd-column"></td>
                        <td class="ttd-column">4. .........</td>
                    </tr>
                @endif
                <tr class="font-bold">
                    <td colspan="2" class="text-right" style="padding-right: 12px">JUMLAH</td>
                    <td class="text-right">:</td>
                    <td class="text-left" style="border-right: none;">Rp.</td>
                    <td class="text-right" style="border-left: none;">{{ number_format($totalBiaya, 0, ',', '.') }}
                    </td>
                    <td class="ttd-column"></td>
                    <td class="ttd-column"></td>
                </tr>
            </tbody>
        </table>
        <div style="width: 60%; float: right; margin-top: 30px;">

            {{-- Bagian Terbilang --}}
            <table class="no-border" style="width: 100%; margin-bottom: 30px; padding-right: 30px;">
                <tr>
                    <td style="width: 25%;">Terbilang</td>
                    <td>
                        {{ ucwords(Number::spell($totalBiaya, 'id')) }} Rupiah
                    </td>
                </tr>
            </table>

            {{-- Bagian Tanda Tangan --}}
            <div style="width: 100%; text-align: center; padding-left: 100px; line-height: 12pt;">
                Bandar Lampung,
                &nbsp;&nbsp;&nbsp;&nbsp;{{ $sppd->tanggal_dibuat_surat->isoFormat('MMMM YYYY') }}<br /><br />
                Ketua Rombongan,
                <div class="signature-space"></div>
                <b class="underline">{{ $rincianBiaya->sppd->pelaksana->nama }}</b><br />
                NIP. {{ $rincianBiaya->sppd->pelaksana->nip }}
            </div>

        </div>

        <div style="clear: both;"></div>
    </div>
    <div class="page appendix-page" style="color: white;">

        <table class="no-border">
            <tbody>
                <tr>
                    <td style="width: 5%;">

                    </td>
                    <td style="width: 30%;">

                    </td>
                    <td style="width: 60%;"></td>
                    <td style="width: 5%;">
                        I.
                    </td>
                    <td style="width: 30%;">
                        Berangkat dari<br>
                        (Tempat Kedudukan)<br>
                        Ke<br>
                        Pada Tanggal<br>
                    </td>
                    <td style="width: 60%">
                        : {{ $sppd->tempat_berangkat }}<br>
                        : {{ $sppd->tempat_kedudukan }}<br><br>
                        :
                        <span style="color: black;">
                            {{ $sppd->tempat_tujuan }}<br>
                        </span>
                        :
                        <span style="color: black;">
                            {{ $sppd->tanggal_berangkat->isoFormat('D MMMM YYYY') }}<br>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2"></td>
                    <td></td>
                    <td colspan="2">
                        <b>Pejabat Pelaksana<br>Teknis Kegiatan</b><br>
                        <div class="signature-section"></div>
                        <b><u>{{ $sppd->mengetahui->nama ?? '(…………………………………….……….)' }}</u></b><br>
                        NIP. {{ $sppd->mengetahui->nip ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td>II.</td>
                    <td>
                        Tiba di<br>
                        Pada Tanggal<br>
                        Kepala<br>

                    </td>
                    <td>
                        :
                        <span style="color: black;">
                            {{ $sppd->tempat_tujuan }}<br>
                        </span>
                        :
                        <span style="color: black;">
                            {{ $sppd->tanggal_tiba?->isoFormat('D MMMM YYYY') ?? '' }}<br>
                        </span>
                        :
                        <span style="color: black;">
                            {{ $sppd->kepala_jabatan_di_tempat ?? '' }}<br>
                        </span>
                    </td>
                    <td></td>
                    <td>
                        Berangkat dari<br>
                        Ke<br>
                        Pada tanggal<br>
                        Kepala<br>
                    </td>
                    <td>
                        :
                        <span style="color: black;">
                            {{ $sppd->tempat_tujuan }}<br>
                        </span>
                        :
                        <span style="color: black;">
                            {{ $sppd->tempat_berangkat }}<br>
                        </span>
                        :
                        <span style="color: black;">
                            {{ $sppd->tanggal_kembali->isoFormat('D MMMM YYYY') }}<br>
                        </span>
                        :
                        <span style="color: black;">
                            {{ $sppd->kepala_jabatan_di_tempat ?? '' }}<br>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px; color: black;">
                        <div class="signature-section"></div>
                        ({{ $sppd->nama_di_tempat ?? '…………………………………….……….' }})<br>
                        NIP. {{ $sppd->nip_di_tempat ?? '' }}
                    </td>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px; color: black;">
                        <div class="signature-section"></div>
                        ({{ $sppd->nama_di_tempat ?? '…………………………………….……….' }})<br>
                        NIP. {{ $sppd->nip_di_tempat ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td>III.</td>
                    <td>
                        Tiba di<br>
                        Pada Tanggal<br>
                        Kepala<br>
                    </td>
                    <td>
                        : <br>
                        : <br>
                        : <br>
                    </td>
                    <td></td>
                    <td>
                        Berangkat dari<br>
                        Ke<br>
                        Pada tanggal<br>
                        Kepala<br>
                    </td>
                    <td>
                        : <br>
                        : <br>
                        : <br>
                        : <br>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px;">
                        <div class="signature-section"></div>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px;">
                        <div class="signature-section"></div>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                </tr>
                <tr>
                    <td>IV.</td>
                    <td>
                        Tiba di<br>
                        Pada Tanggal<br>
                        Kepala<br>
                    </td>
                    <td>
                        : <br>
                        : <br>
                        : <br>
                    </td>
                    <td></td>
                    <td>
                        Berangkat dari<br>
                        Ke<br>
                        Pada tanggal<br>
                        Kepala<br>
                    </td>
                    <td>
                        : <br>
                        : <br>
                        : <br>
                        : <br>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px;">
                        <div class="signature-section"></div>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                    <td></td>
                    <td class="text-center" colspan="2" style="padding-right: 50px;">
                        <div class="signature-section"></div>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                </tr>
                <tr>
                    <td>V.</td>
                    <td>
                        Tiba di<br><br>
                        Pada Tanggal<br>
                        Kepala<br><br>
                    </td>
                    <td>
                        : <br><br>
                        : <br>
                        : <br><br>
                    </td>
                    <td></td>
                    <td colspan="2" class="attention-section">
                        Telah diperiksa, dengan keterangan bahwa perjalanan tersebut di atas benar dilakukan atas
                        perintahnya dan semata-mata untuk kepentingan Jabatan dalam waktu sesingkat-singkatnya.
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <b>Pejabat yang berwenang,</b><br>
                        <div class="signature-section"></div>
                        <b><u>{{ $sppd->pemberi_wewenang->nama }}</u></b><br>
                        NIP. {{ $sppd->pemberi_wewenang->nip }}
                    </td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>VI.</td>
                    <td colspan="5">CATATAN LAIN-LAIN</td>
                </tr>
                <tr>
                    <td>VII.</td>
                    <td colspan="5">
                        <u>PERHATIAN : </u>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="5" class="attention-section">
                        PPK yang menerbitkan SPD, Pegawai yang melakukan Perjalanan Dinas, para pejabat yang mengesahkan
                        tanggal berangkat/tiba serta Bendahara Pengeluaran bertanggung jawab berdasarkan
                        peraturan-peraturan Keuangan Negara, apabila Negara menderita rugi akibat kesalahan, kelalaian
                        dan kealpaannya.
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="page bkp-page" style="background-image: url('{{ public_path('BKP.jpg') }}');">

        <!-- Header -->
        <div style="position: absolute; top: 3.25%; left: 83%;">{{ $sppd->tanggal_dibuat_surat->isoFormat('YYYY') }}</div>

        <!-- Main Content -->
        <div style="position: absolute; top: 5.5%; left: 37%;">{{ $sppd->instansi_pembebanan_anggaran }}</div>
        <div style="position: absolute; top: 8.5%; left: 25%; font-style: italic; font-weight: bold;">{{ ucwords(Number::spell($totalBiaya, 'id')) . ' Rupiah' ?? '' }}</div>
        <div style="position: absolute; top: 10.5%; left: 29%; width: 66%; line-height: 1.75;">{{ $sppd->maksud }}</div>

        <!-- Terbilang -->
        <div style="position: absolute; top: 19.5%; left: 22%;">{{ number_format($totalBiaya, 0, ',', '.') ?? 0 }}</div>

        <!-- Signatures Top -->
        <div style="position: absolute; top: 19.5%; left: 50%; text-align: center; width: 25%;">Bandar Lampung,</div>
        <div style="position: absolute; top: 28.75%; left: 3%; text-align: center; width: 25%; font-size: 9pt;">
            <div>{{ $sppd->pemberi_wewenang->nama }}</div>
            <div>NIP. {{ $sppd->pemberi_wewenang->nip }}</div>
        </div>
        <div style="position: absolute; top: 28.75%; left: 26%; text-align: center; width: 25%; font-size: 9pt;">
            <div>{{ $sppd->mengetahui->nama ?? '' }}</div>
            <div>NIP. {{ $sppd->mengetahui->nip ?? '' }}</div>
        </div>
        <div style="position: absolute; top: 28.75%; left: 48%; text-align: center; width: 25%; font-size: 9pt;">
            <div>{{ $rincianBiaya->pegawai_bendahara->nama }}</div>
            <div>NIP. {{ $rincianBiaya->pegawai_bendahara->nip }}</div>
        </div>     
        <div style="position: absolute; top: 28.75%; left: 70%; text-align: center; width: 25%; font-size: 9pt;">
            <div>{{ $sppd->pelaksana->nama ?? '' }}</div>
            <div>NIP. {{ $sppd->pelaksana->nip ?? '' }}</div>
        </div>   
        <!-- Telah Dibukukan -->
        <div style="position: absolute; top: 35.6%; left: 70%;">{{ $sppd->akun_pembebanan_anggaran }}</div>
        <div style="position: absolute; top: 37.2%; left: 70%;">{{ $sppd->tanggal_dibuat_surat->isoFormat('YYYY') }}</div>

        {{-- END OF BKP PAGE --}}
    </div>
</body>

</html>
