<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Perjalanan Dinas (SPD)</title>
    <style>
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

        body {
            font-family: "Bookman Old Style", Georgia, serif;
            font-size: 11pt;
            line-break: strict;
            padding: 0px;
        }

        .container {
            margin: auto;
            background-color: white;
        }

        .page-2 {
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            vertical-align: top;
        }

        .header-table {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
        }

        .header-table .agency2 {
            font-size: 18pt;
            font-weight: bold;
        }

        .header-table .agency1 {
            font-size: 16pt;
            letter-spacing: 5px;
            font-weight: bold;

        }

        .header-table .address {
            font-size: 10pt;
        }

        .main-title {
            text-align: center;
            font-size: 11pt;
            text-decoration: underline;
            margin-bottom: 10px;
        }

        .top-right {
            text-align: left;
        }

        .main-table,
        .log-table {
            border: 2px solid black;
        }

        .main-table td,
        .log-table td {
            border: 1px solid black;
        }

        .main-table .label-col {
            width: 5%;
            text-align: right;
            padding-right: 10px;
        }

        .main-table .desc-col {
            width: 35%;
        }

        .main-table .content-col {
            width: 60%;
        }

        .log-table {
            margin-top: 10px;
        }

        .no-border,
        .no-border td,
        .no-border th {
            border: none !important;
        }

        .signature-section {
            height: 40px;
        }

        .page-2,
        .attention-section {
            text-align: justify;
        }

        .nested-input-table td {
            padding: 0;
        }
    </style>
</head>

<body>

    <div class="container">

        <table class="header-table no-border">
            <tr>
                <td style="width: 15%; text-align: center;">
                    <img src="/public/lampung.png" alt="Logo Lampung" style="width: 60px;">
                </td>
                <td>
                    <div class="agency1">PEMERINTAH PROVINSI LAMPUNG</div>
                    <div class="agency2">DINAS PERINDUSTRIAN DAN PERDAGANGAN</div>
                    <div class="address">Jln. Cut Mutia No.44 Telp/Fax. 0721-474331 Telukbetung 35214</div>
                    <div class="address">Email: disperindag@lampungprov.go.id Website : disperindag.lampungprov.go.id
                    </div>
                </td>
            </tr>
        </table>

        <hr style="border: 2px solid black;">
        <hr style="border: 0.5px solid black; margin-bottom: 10px;">

        <table class="no-border" style="margin-bottom: 10px;">
            <tr>
                <td style="width: 60%;"></td>
                <td class="top-right">
                    Lembar ke : {{ $sppd->lembar_ke ?? '………………………….. ' }}<br>
                    Kode No. &nbsp;: {{ $sppd->kode ?? '………………………….. ' }}<br>
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
                        {{ $sppd->pelaksana->jabatan }}<br>
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
                        {{ $sppd->jumlah_hari }} hari<br>
                        {{ $sppd->tanggal_berangkat->isoFormat('D MMMM YYYY') }}<br>
                        {{ $sppd->tanggal_kembali->isoFormat('D MMMM YYYY') }}
                    </td>
                </tr>
                <tr>
                    <td class="label-col">8.</td>
                    <td style="text-align:left; padding-left:5px;">Pengikut : Nama</td>
                    <td style="text-align:left;">Tanggal Lahir</td>
                    <td style="text-align:left;">Keterangan</td>
            <tbody>
                <tr>
                    <td rowspan="3" class="label-col">9.</td>
                    <td>{{ $sppd->pengikut_1->nama ?? '' }}</td>
                    <td>{{ $sppd->pengikut_1?->tanggal_lahir?->isoFormat('D MMMM YYYY') ?? '' }}</td>
                    <td>{{ $sppd->pengikut_1->jabatan ?? '' }}</td>
                </tr>
                <tr>
                    <td>{{ $sppd->pengikut_2->nama ?? '' }}</td>
                    <td>{{ $sppd->pengikut_2?->tanggal_lahir?->isoFormat('D MMMM YYYY') ?? '' }}</td>
                    <td>{{ $sppd->pengikut_2->jabatan ?? '' }}</td>
                </tr>
                <tr>
                    <td>{{ $sppd->pengikut_3->nama ?? '' }}</td>
                    <td>{{ $sppd->pengikut_3?->tanggal_lahir?->isoFormat('D MMMM YYYY') ?? '' }}</td>
                    <td>{{ $sppd->pengikut_3->jabatan ?? '' }}</td>
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
                    Tanggal : {{ $sppd->created_at->isoFormat('D MMMM YYYY') }}<br>
                    <b>{{ strtoupper($sppd->pemberi_wewenang->jabatan_ttd) }},</b><br>
                    <div class="signature-section"></div>
                    <b><u>{{ $sppd->pemberi_wewenang->nama }}</u></b><br>
                    NIP. {{ $sppd->pemberi_wewenang->nip }}
                </td>
            </tr>
        </table>

        <br>

        <table class="page-2 no-border">
            <tbody>
                <tr>
                    <td>

                    </td>
                    <td style="width:50%; border-left: none;">

                    </td>
                    <td>
                        I.
                    </td>
                    <td style="width:50%; border-right: none;">
                        Berangkat dari: {{ $sppd->tempat_berangkat }}<br>
                        (Tempat Kedudukan):{{ $sppd->tempat_kedudukan }}<br>
                        Ke: {{ $sppd->tempat_tujuan }}<br>
                        Pada Tanggal: {{ $sppd->tanggal_berangkat->isoFormat('D MMMM YYYY') }}<br>
                        <b>Pejabat Pelaksana<br>Teknis Kegiatan</b><br>
                        <div class="signature-section"></div>
                        <b><u>{{ $sppd->mengetahui->nama ?? '(…………………………………….……….)' }}</u></b><br>
                        NIP. {{ $sppd->mengetahui->nip ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td>II.</td>
                    <td>
                        Tiba di : {{ $sppd->tempat_tujuan }}<br>
                        Pada Tanggal : {{ $sppd->tanggal_tiba?->isoFormat('D MMMM YYYY') ?? '' }}<br>
                        Kepala : {{ $sppd->kepala_jabatan_di_tempat ?? '' }}<br>
                        <div class="signature-section" style="height:40px"></div><br>
                        ({{ $sppd->nama_di_tempat ?? '…………………………………….……….' }})<br>
                        NIP. {{ $sppd->nip_di_tempat ?? '' }}
                    </td>
                    <td></td>
                    <td>
                        Berangkat dari : {{ $sppd->tempat_tujuan }}<br>
                        Ke : {{ $sppd->tempat_berangkat }}<br>
                        Pada tanggal : {{ $sppd->tanggal_kembali->isoFormat('D MMMM YYYY') }}<br>
                        Kepala : {{ $sppd->kepala_jabatan_di_tempat ?? '' }}<br>
                        <div class="signature-section" style="height:40px"></div>
                        ({{ $sppd->nama_di_tempat ?? '…………………………………….……….' }})<br>
                        NIP. {{ $sppd->nip_di_tempat ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td>III.</td>
                    <td>
                        Tiba di : <br>
                        Pada Tanggal : <br>
                        Kepala : <br>
                        <div class="signature-section" style="height:40px"></div><br>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                    <td></td>
                    <td>
                        Berangkat dari : <br>
                        Ke : <br>
                        Pada tanggal : <br>
                        Kepala : <br>
                        <div class="signature-section" style="height:40px"></div>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                </tr>
                <tr>
                    <td>IV.</td>
                    <td>
                        Tiba di : <br>
                        Pada Tanggal : <br>
                        Kepala : <br>
                        <div class="signature-section" style="height:40px"></div><br>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                    <td></td>
                    <td>
                        Berangkat dari : <br>
                        Ke : <br>
                        Pada tanggal : <br>
                        Kepala : <br>
                        <div class="signature-section" style="height:40px"></div>
                        (…………………………………….……….)<br>
                        NIP.
                    </td>
                </tr>
                <tr>
                    <td>V.</td>
                    <td>
                        Tiba di: <br>
                        Pada Tanggal: <br><br>
                        Pejabat yang berwenang,<br>
                        <div class="signature-section"></div>
                        <b><u>{{ $sppd->pemberi_wewenang->nama }}</u></b><br>
                        NIP. {{ $sppd->pemberi_wewenang->nip }}
                    </td>
                    <td></td>
                    <td>
                        Telah diperiksa, dengan keterangan bahwa perjalanan tersebut di atas benar dilakukan atas
                        perintahnya dan semata-mata untuk kepentingan Jabatan dalam waktu sesingkat-singkatnya.
                    </td>
                </tr>
                <tr>
                    <td colspan="2">VI. CATATAN LAIN-LAIN</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <u>VII. PERHATIAN : </u>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">
                        PPK yang menerbitkan SPD, Pegawai yang melakukan Perjalanan Dinas, para pejabat yang mengesahkan
                        tanggal berangkat/tiba serta Bendahara Pengeluaran bertanggung jawab berdasarkan
                        peraturan-peraturan Keuangan Negara, apabila Negara menderita rugi akibat kesalahan, kelalaian
                        dan kealpaannya.
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

</body>

</html>
