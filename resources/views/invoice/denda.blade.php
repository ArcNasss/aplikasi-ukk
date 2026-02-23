<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Denda - {{ $invoiceNumber }}</title>
    <style>
        /* Standar A4 Portrait */
        @page {
            size: portrait;
            margin: 0;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 1cm;
            color: #333;
            background-color: #fff;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 1px solid #999;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .brand-logo {
            width: 100px;
            vertical-align: middle;
        }

        .brand-text {
            padding-left: 15px;
            vertical-align: middle;
        }

        .brand-text h1 {
            font-size: 26pt;
            margin: 0;
            color: #F59E0B; /* Orange Lantera */
            text-transform: uppercase;
        }

        .brand-text h1 span {
            color: #1E3A8A; /* Biru Lantera */
        }

        .brand-text p {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            color: #000;
        }

        .invoice-label {
            font-size: 32pt;
            font-weight: bold;
            color: #1E3A8A;
            text-align: right;
            vertical-align: middle;
        }

        /* Meta Info */
        .meta-table {
            width: 100%;
            margin-bottom: 30px;
            font-size: 10pt;
        }

        .meta-table td { vertical-align: top; }

        .label-upper {
            text-transform: uppercase;
            color: #333;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Table */
        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table th {
            background-color: #3B82F6; /* Biru terang sesuai gambar */
            color: #ffffff;
            text-align: left;
            padding: 10px;
            font-size: 10pt;
            border: 1px solid #3B82F6;
        }

        .main-table td {
            padding: 10px;
            border: 1px solid #E5E7EB;
            font-size: 10pt;
        }


        /* Container row agar bersih dari border default */
        .subtotal-row td {
            border: none !important;
            padding: 0 !important;
        }

        /* Pembungkus agar pill bisa didorong ke kanan */
        .pill-wrapper {
            text-align: right; /* Menarik pill ke ujung kanan tabel */
            width: 100%;
        }

        .subtotal-pill {
            background-color: #3B82F6;
            color: #ffffff;
            display: inline-block; /* Agar lebar menyesuaikan konten internal */
            padding: 12px 30px;
            min-width: 280px; /* Menyesuaikan proporsi gambar */
            font-weight: bold;
            font-size: 11pt;
            /* Lengkungan setengah lingkaran (Pill Shape) di sisi kiri saja */
            border-radius: 50px 0 0 50px;
            box-sizing: border-box;
            line-height: 1;
        }

        .label-text {
            float: left;
            margin-right: 40px; /* Memberi jarak antara label dan nominal */
        }

        .value-text {
            float: right;
        }

        /* .subtotal-label {
            float: left;
            margin-right: 20px;
        }

        .subtotal-value {
            float: right;
        } */

        /* Footer Text */
        .content-footer {
            margin-top: 40px;
            font-size: 10pt;
            line-height: 1.5;
        }

        .admin-section {
            width: 100%;
            margin-top: 30px;
        }

        .signature-area {
            text-align: right;
            padding-right: 50px;
        }

        .signature-space {
            height: 60px;
        }

        /* Bottom Contact Bar */
        .contact-bar {
            position: absolute;
            bottom: 1cm;
            width: 89%; /* Menyesuaikan padding body */
            border-top: 1px solid #E5E7EB;
            padding-top: 10px;
        }

        .contact-item {
            width: 33.33%;
            font-size: 9pt;
            color: #333;
            text-align: center;
        }

        .icon {
            width: 12px;
            margin-right: 5px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="70">
                <img src="{{ public_path('img/logoClean.png') }}" class="brand-logo">
            </td>
            <td class="brand-text">
                <h1>LAN<span>TERA</span></h1>
                <p>SMP NEGERI 1 Balen</p>
            </td>
            <td class="invoice-label">INVOICE</td>
        </tr>
    </table>

    <table class="meta-table">
        <tr>
            <td width="50%">
                <div class="label-upper">INVOICE TO:</div>
                <div style="font-weight: bold; font-size: 11pt;">{{ $user->name }}</div>
                <div>{{ $user->nomor_identitas }}</div>
                <div>{{ $user->email }}</div>
            </td>
            <td align="right">
                <div style="font-weight: bold;">INVOICE NO: {{ $invoiceNumber }}</div>
                <div>{{ date('d F Y') }}</div>
            </td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Buku</th>
                <th width="100">Jenis Denda</th>
                <th width="120">Hari Terlambat</th>
                <th width="120">Jumlah Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dendaItems as $index => $item)
            <tr @if($index % 2 == 1) style="background-color: #EFF6FF;" @endif>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $item['book_title'] }}</td>
                <td>{{ ucfirst($item['status']) }}</td>
                <td>
                    @if($item['hari_terlambat'])
                        {{ $item['hari_terlambat'] }} Hari
                    @else
                        -
                    @endif
                </td>
                <td>Rp {{ number_format($item['denda'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5" class="subtotal-row">
                    <div class="pill-wrapper">
                        <div class="subtotal-pill">
                            <span class="label-text">Sub Total :</span>
                            <span class="value-text">
                                Rp {{ number_format(array_sum(array_column($dendaItems, 'denda')), 0, ',', '.') }}
                            </span>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="content-footer">
        <p>Terima kasih telah menggunakan layanan perpustakaan kami.</p>
        <p style="color: #4B5563; width: 80%;">
            Tagihan ini merupakan biaya administrasi perpustakaan yang timbul akibat keterlambatan pengembalian atau kehilangan buku. Mohon segera melakukan pembayaran sesuai jumlah yang tertera.
        </p>
    </div>

    <table class="admin-section">
        <tr>
            <td align="right" class="signature-area">
                <div style="font-weight: bold;">Perpustakaan LANTERA</div>
                <div class="signature-space">
                    </div>
                <div style="font-weight: bold;">Admin</div>
            </td>
        </tr>
    </table>

    <table class="contact-bar">
        <tr>
            <td class="contact-item">📞 +62 1234567890</td>
            <td class="contact-item">✉️ spensaba@gmail.com</td>
            <td class="contact-item">📍 Kec. Balen, Bojonegoro</td>
        </tr>
    </table>

</body>
</html>
