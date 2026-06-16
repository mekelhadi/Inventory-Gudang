<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Surat Jalan</title>
<style>
@page { margin: 30px 50px; }
body {
  font-family: 'Helvetica', Arial, sans-serif;
  font-size: 12px;
  color: #222;
}
.header {
  text-align: center;
  border-bottom: 3px double #333;
  padding-bottom: 14px;
  margin-bottom: 20px;
}
.header h1 {
  font-size: 22px;
  margin: 0 0 4px;
  letter-spacing: 2px;
}
.header p {
  margin: 2px 0;
  color: #555;
  font-size: 11px;
}
.title-section {
  text-align: center;
  margin: 18px 0;
}
.title-section h2 {
  font-size: 17px;
  text-transform: uppercase;
  letter-spacing: 4px;
  border: 2px solid #222;
  display: inline-block;
  padding: 6px 28px;
  margin: 0;
}
.info-table {
  width: 100%;
  margin-bottom: 20px;
}
.info-table td {
  padding: 4px 6px;
  vertical-align: top;
}
.info-table .label {
  font-weight: 600;
  width: 120px;
}
.items-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 30px;
}
.items-table th {
  background: #222;
  color: #fff;
  padding: 8px 10px;
  text-align: left;
  font-size: 11px;
  text-transform: uppercase;
}
.items-table td {
  padding: 8px 10px;
  border-bottom: 1px solid #ddd;
}
.items-table tbody tr:nth-child(even) {
  background: #f9f9f9;
}
.ttd-section {
  margin-top: 40px;
  width: 100%;
}
.ttd-section td {
  text-align: center;
  padding: 10px 20px;
}
.ttd-section .ttd-line {
  margin-top: 50px;
  border-top: 1px solid #333;
  padding-top: 6px;
  font-weight: 600;
}
.footer {
  text-align: center;
  margin-top: 20px;
  font-size: 10px;
  color: #999;
  border-top: 1px solid #ddd;
  padding-top: 10px;
}
</style>
</head>
<body>

<div class="header">
  <div style="display:flex;align-items:center;justify-content:center;gap:16px;">
    <img src="{{ public_path('assets/img/logo_sinarmax.jpg') }}" style="height:52px;width:auto;object-fit:contain;">
    <h1>INVENTARIS GUDANG SINARMAX</h1>
  </div>
  <p>Pergudangan Surya Grand Cisoka, Jl. Raya Cisoka No.03 Blok D, Cibugel, Kec. Cisoka, Kabupaten Tangerang, Banten 15730</p>
  <p>Telp: 08111208007 | Email: sinarmaxx@gmail.com</p>
</div>

<div class="title-section">
  <h2>SURAT JALAN</h2>
</div>

<table class="info-table">
  <tr>
    <td class="label">No. Transaksi</td>
    <td>: {{ $barangKeluar->kode_transaksi }}</td>
  </tr>
  <tr>
    <td class="label">Tanggal Keluar</td>
    <td>: {{ \Carbon\Carbon::parse($barangKeluar->tanggal_keluar)->isoFormat('D MMMM Y') }}</td>
  </tr>
  <tr>
    <td class="label">Customer</td>
    <td>: {{ $customer->customer ?? '-' }}</td>
  </tr>
  <tr>
    <td class="label">Alamat</td>
    <td>: {{ $customer->alamat ?? '-' }}</td>
  </tr>
</table>

<table class="items-table">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Barang</th>
      <th>Jumlah</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td>{{ $barangKeluar->nama_barang }}</td>
      <td>{{ $barangKeluar->jumlah_keluar }}</td>
      <td>{{ $barangKeluar->keterangan ?? '-' }}</td>
  
    </tr>
  </tbody>
</table>

<table class="ttd-section">
  <tr>
    <td>Pengirim,</td>
    <td>Penerima,</td>
    <td>Mengetahui,</td>
  </tr>
  <tr>

    <td class="ttd">( _________________ )</td>
    <td class="ttd">( _________________ )</td>
    <td class="ttd">( _________________ )</td>
  </tr>
</table>

<div class="footer">
  Dicetak pada {{ now()->isoFormat('D MMMM Y HH:mm') }} | Inventaris Gudang Sinarmax
</div>

</body>
</html>
