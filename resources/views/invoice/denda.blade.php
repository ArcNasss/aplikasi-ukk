<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice Denda - {{ $invoiceNumber }}</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: Arial, Helvetica, sans-serif;
    background:#f5f7fb;
    padding:40px;
}

.container{
    max-width:900px;
    margin:auto;
    background:#fff;
    padding:40px 50px;
}

/* ================= HEADER ================= */

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding-bottom:25px;
    border-bottom:1.5px solid #dcdcdc;
    margin-bottom:35px;
}

.logo-section{
    display:flex;
    align-items:center;
    gap:20px;
}

.logo{
    width:85px;
}

.company-name h1{
    font-size:38px;
    letter-spacing:1px;
    line-height:1;
}

.company-name .lan{ color:#FDB913; }
.company-name .tera{ color:#4361EE; }

.company-name p{
    font-size:16px;
    margin-top:6px;
    color:#444;
}

.invoice-title{
    font-size:52px;
    font-weight:bold;
    color:#4361EE;
    letter-spacing:3px;
}

/* ================= INVOICE INFO ================= */

.invoice-info{
    display:flex;
    justify-content:space-between;
    margin-bottom:35px;
}

.invoice-to h3{
    font-size:13px;
    letter-spacing:1px;
    margin-bottom:10px;
}

.invoice-to p{
    font-size:14px;
    line-height:1.7;
    color:#333;
}

.invoice-details{
    text-align:right;
    font-size:14px;
    line-height:1.8;
}

.invoice-details strong{
    font-size:15px;
}

/* ================= TABLE ================= */

.invoice-table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

.invoice-table thead{
    background:linear-gradient(90deg,#4361EE,#2d52c7);
    color:#fff;
}

.invoice-table th{
    padding:14px 12px;
    font-size:14px;
    font-weight:600;
    text-align:left;
}

.invoice-table th:last-child,
.invoice-table th:nth-child(4){
    text-align:right;
}

.invoice-table td{
    padding:14px 12px;
    font-size:14px;
    border-bottom:1px solid #eaeaea;
}

.invoice-table tbody tr:nth-child(even){
    background:#eef3ff;
}

.invoice-table td:last-child,
.invoice-table td:nth-child(4){
    text-align:right;
}

/* ================= SUBTOTAL ================= */

.subtotal-row{
    display:flex;
    justify-content:flex-end;
    margin-top:25px;
}

.subtotal-box{
    background:linear-gradient(90deg,#4361EE,#2d52c7);
    color:#fff;
    padding:12px 30px;
    font-size:16px;
    font-weight:600;
    border-radius:4px;
    min-width:300px;
    text-align:right;
}

/* ================= FOOTER ================= */

.footer-text{
    margin-top:40px;
    padding-top:25px;
    border-top:1.5px solid #dcdcdc;
}

.footer-text p{
    font-size:14px;
    line-height:1.8;
    color:#444;
}

.signature{
    margin-top:50px;
    text-align:right;
}

.signature p{
    font-size:14px;
}

.admin-name{
    font-weight:bold;
    margin-top:60px;
}

/* ================= CONTACT ================= */

.contact-info{
    display:flex;
    justify-content:space-between;
    margin-top:50px;
    padding-top:20px;
    border-top:1.5px solid #dcdcdc;
    font-size:14px;
    color:#444;
}

.contact-item{
    display:flex;
    align-items:center;
    gap:8px;
}

.icon{
    width:18px;
    height:18px;
    color:#4361EE;
}

</style>
</head>

<body>
<div class="container">

<!-- HEADER -->
<div class="header">
    <div class="logo-section">
        <img src="{{ public_path('img/logoClean.png') }}" class="logo">
        <div class="company-name">
            <h1><span class="lan">LAN</span><span class="tera">TERA</span></h1>
            <p>SMP NEGERI 1 Balen</p>
        </div>
    </div>
    <div class="invoice-title">INVOICE</div>
</div>

<!-- INFO -->
<div class="invoice-info">
    <div class="invoice-to">
        <h3>INVOICE TO:</h3>
        <p><strong>{{ $user->name }}</strong></p>
        <p>{{ $user->nomor_identitas }}</p>
        <p>{{ $user->email }}</p>
    </div>

    <div class="invoice-details">
        <p><strong>INVOICE NO: {{ $invoiceNumber }}</strong></p>
        <p>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
    </div>
</div>

<!-- TABLE -->
<table class="invoice-table">
<thead>
<tr>
<th>No</th>
<th>Nama Buku</th>
<th>Jenis Denda</th>
<th>Jumlah Keterlambatan</th>
<th>Jumlah Keseluruhan</th>
</tr>
</thead>
<tbody>
@php $total = 0; @endphp
@foreach($dendaItems as $index => $item)
<tr>
<td>{{ $index + 1 }}</td>
<td>{{ $item['book_title'] }}</td>
<td>{{ ucfirst($item['status']) }}</td>
<td>
    @if($item['status'] == 'terlambat' && isset($item['hari_terlambat']))
        Rp. 2.000
    @elseif($item['status'] == 'hilang')
        Rp. 100.000
    @elseif($item['status'] == 'rusak')
        Rp. 50.000
    @else
        -
    @endif
</td>
<td>Rp. {{ number_format($item['denda'],0,',','.') }}</td>
</tr>
@php $total += $item['denda']; @endphp
@endforeach
</tbody>
</table>

<!-- SUBTOTAL -->
<div class="subtotal-row">
<div class="subtotal-box">
Sub Total : Rp. {{ number_format($total,0,',','.') }}
</div>
</div>

<!-- FOOTER TEXT -->
<div class="footer-text">
<p><strong>Terima kasih telah menggunakan layanan perpustakaan kami.</strong></p>
<p>Tagihan ini merupakan biaya administrasi akibat keterlambatan atau kehilangan buku. Mohon segera melakukan pembayaran sesuai jumlah yang tertera.</p>
</div>

<!-- SIGNATURE -->
<div class="signature">
<p>Perpustakaan LANTERA</p>
<p class="admin-name">Admin</p>
</div>

<!-- CONTACT -->
<div class="contact-info">
<div class="contact-item">+62 1234567890</div>
<div class="contact-item">spensaba@gmail.com</div>
<div class="contact-item">Jl. Raya Balen No.46, Bojonegoro</div>
</div>

</div>
</body>
</html>
