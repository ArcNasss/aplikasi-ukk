<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: landscape;
            margin: 0;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 1cm 1.5cm;
            background-color: #fff;
            color: #2D3748;
        }

        /* HEADER SECTION */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #E2E8F0;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .logo-img { width: 75px; vertical-align: middle; }

        .brand-box { padding-left: 15px; vertical-align: middle; }
        .brand-box h1 {
            font-size: 26pt; margin: 0; color: #F59E0B;
            text-transform: uppercase; letter-spacing: 1px;
        }
        .brand-box h1 span { color: #1E3A8A; }
        .brand-box p { margin: 0; font-size: 11pt; font-weight: bold; color: #4A5568; }

        .doc-title {
            font-size: 24pt; font-weight: bold; color: #1E3A8A;
            text-align: right; vertical-align: middle;
            text-transform: uppercase;
        }

        /* DATA ANGGOTA */
        .data-section {
            width: 100%;
            margin-bottom: 30px;
            font-size: 11pt;
        }
        .data-section td { padding: 4px 0; }
        .label { width: 180px; color: #4A5568; }
        .value { font-weight: bold; }

        /* MODERN TABLE WITH SHADOW */
        .card-container {
            background: white;
            border-radius: 15px;
            /* Simulasi shadow untuk PDF */
            border: 1px solid #E2E8F0;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table th {
            background-color: #4A72E5; /* Biru cerah sesuai referensi */
            color: white;
            padding: 15px;
            font-size: 10.5pt;
            font-weight: 500;
            text-align: center;
        }

        .main-table td {
            padding: 18px 15px;
            font-size: 10pt;
            text-align: center;
            border-bottom: 1px solid #EDF2F7;
        }

        .main-table tr:last-child td { border-bottom: none; }

        /* FOOTER & SIGNATURE */
        .footer-table {
            width: 100%;
            margin-top: 20px;
        }

        .signature-box {
            text-align: center;
            width: 250px;
        }

        .sig-space { height: 70px; }
        .admin-name { font-weight: bold; border-top: 1px solid #2D3748; display: inline-block; padding: 5px 40px; }

        /* NOTICE BOX */
        .notice {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9pt;
            color: #4A5568;
            line-height: 1.6;
        }
        .warning-icon { color: #F59E0B; font-weight: bold; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="80">
                <img src="{{ public_path('img/logoClean.png') }}" class="logo-img">
            </td>
            <td class="brand-box">
                <h1>LAN<span>TERA</span></h1>
                <p>SMP Negeri 1 Balen</p>
            </td>
            <td class="doc-title">KARTU PEMINJAMAN BUKU</td>
        </tr>
    </table>

    <table class="data-section">
        <tr>
            <td class="label">Nomor</td>
            <td width="10">:</td>
            <td class="value">{{ str_pad($borrow->id, 10, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="label">Nama Peminjam</td>
            <td>:</td>
            <td class="value">{{ $borrow->user->name }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Identitas</td>
            <td>:</td>
            <td class="value">{{ $borrow->user->nomor_identitas }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Peminjaman</td>
            <td>:</td>
            <td class="value">{{ $borrow->tanggal_pinjam->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Kembali</td>
            <td>:</td>
            <td class="value">{{ $borrow->tanggal_kembali->format('d F Y') }}</td>
        </tr>
    </table>

    <div class="card-container">
        <table class="main-table">
            <thead>
                <tr>
                    <th width="60">No.</th>
                    <th>Judul Buku</th>
                    <th width="150">Kode Buku</th>
                    <th width="180">Tanggal Pinjam</th>
                    <th width="180">Tanggal Tempo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $borrow->bookItem->book->judul }}</td>
                    <td>{{ $borrow->bookItem->kode_buku }}</td>
                    <td>{{ $borrow->tanggal_pinjam->format('d F Y') }}</td>
                    <td>{{ $borrow->tanggal_kembali->format('d F Y') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <table class="footer-table">
        <tr>
            <td></td>
            <td class="signature-box" align="right">
                <p style="margin-bottom: 5px;">Perpustakaan LANTERA</p>
                <div class="sig-space">
                    </div>
                <div class="admin-name">Admin</div>
            </td>
        </tr>
    </table>

    <div class="notice">
        <span class="warning-icon">⚠️ Perhatian!</span><br>
        Jika terlambat mengembalikan buku akan dikenakan denda Rp2.000 per hari.<br>
        Buku yang hilang wajib mengganti sebesar Rp100.000 per buku.
    </div>

</body>
</html>
