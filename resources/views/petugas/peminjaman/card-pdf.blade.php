<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Peminjaman - {{ $borrow->user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 10px;
            font-size: 10px;
        }

        .card-container {
            border: 2px solid #000;
            padding: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin: 0 auto 5px;
        }

        .logo img {
            width: 100%;
            height: 100%;
        }

        .title h1 {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin: 0 0 2px 0;
        }

        .title h2 {
            font-size: 12px;
            color: #333;
            font-weight: bold;
            margin: 0;
        }

        .info-table {
            width: 100%;
            margin-bottom: 10px;
            border: none;
        }

        .info-table td {
            padding: 3px 0;
            border: none;
            font-size: 10px;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            color: #000;
            width: 125px;
        }

        .info-value {
            color: #333;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #000;
            margin: 10px 0 5px 0;
            padding-bottom: 3px;
            border-bottom: 1px solid #000;
        }

        .books-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .books-table th,
        .books-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            font-size: 9px;
        }

        .books-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            color: #000;
        }

        .books-table td {
            color: #333;
        }

        .warning-box {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 6px;
            margin-top: 8px;
        }

        .warning-box h3 {
            color: #856404;
            font-size: 10px;
            margin-bottom: 4px;
            font-weight: bold;
        }

        .warning-box ul {
            margin-left: 15px;
            color: #856404;
            font-size: 8px;
            line-height: 1.3;
        }

        .warning-box li {
            margin-bottom: 2px;
        }

        .signature-table {
            width: 100%;
            margin-top: 12px;
            border: none;
            padding-top: 8px;
            border-top: 1px solid #ccc;
        }

        .signature-table td {
            border: none;
            text-align: center;
            font-size: 10px;
            vertical-align: top;
            padding-top: 30px;
        }

        .signature-name {
            border-top: 1px solid #000;
            padding-top: 3px;
            font-size: 9px;
            color: #333;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="header">
            <div class="logo">
                <img src="{{ public_path('img/logo.jpeg') }}" alt="Logo">
            </div>
            <div class="title">
                <h1>LANTERA</h1>
                <h2>KARTU PEMINJAMAN BUKU</h2>
            </div>
        </div>

        <table class="info-table" cellpadding="0" cellspacing="0">
            <tr>
                <td class="info-label">Nomor Peminjaman:</td>
                <td class="info-value">#{{ str_pad($borrow->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td class="info-label">Tanggal Peminjaman:</td>
                <td class="info-value">{{ \Carbon\Carbon::parse($borrow->tanggal_pinjam)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="info-label">Nama Peminjam:</td>
                <td class="info-value">{{ $borrow->user->name }}</td>
                <td class="info-label">Tanggal Kembali:</td>
                <td class="info-value">{{ \Carbon\Carbon::parse($borrow->tanggal_kembali)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="info-label">Nomor Identitas:</td>
                <td class="info-value">{{ $borrow->user->nomor_identitas ?? $borrow->user->email }}</td>
                <td class="info-label">Jumlah Buku:</td>
                <td class="info-value">1 Buku</td>
            </tr>
        </table>

        <div class="section-title">Daftar Buku yang Dipinjam</div>
        <table class="books-table" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="width: 8%;">No</th>
                    <th style="width: 18%;">Kode Buku</th>
                    <th style="width: 44%;">Judul Buku</th>
                    <th style="width: 30%;">Pengarang</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $borrow->bookItem->kode_buku }}</td>
                    <td>{{ $borrow->bookItem->book->judul }}</td>
                    <td>{{ $borrow->bookItem->book->penulis }}</td>
                </tr>
            </tbody>
        </table>

        <div class="warning-box">
            <h3>⚠️ PERHATIAN - KETENTUAN PEMINJAMAN:</h3>
            <ul>
                <li>Buku harus dikembalikan sesuai tanggal yang tertera di atas.</li>
                <li>Keterlambatan pengembalian dikenakan denda <strong>Rp 2.000 per hari</strong>.</li>
                <li>Kehilangan atau kerusakan buku dikenakan denda <strong>Rp 100.000</strong>.</li>
                <li>Kartu ini harus dibawa saat mengembalikan buku.</li>
                <li>Kartu peminjaman tidak dapat dipindahtangankan.</li>
            </ul>
        </div>

        <table class="signature-table" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 50%;">
                    <div>Peminjam</div>
                    <div class="signature-name">{{ $borrow->user->name }}</div>
                </td>
                <td style="width: 50%;">
                    <div>Petugas</div>
                    <div class="signature-name">{{ $borrow->petugas->name }}</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
