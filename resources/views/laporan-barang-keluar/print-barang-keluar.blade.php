<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Barang Keluar</title>

  <style>
    @page {
      size: A4 portrait;
      margin: 1.8cm;
    }

    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: #fff;
      margin: 0;
      padding: 0;
      color: #222;
      font-size: 12px;
    }

    .page-wrapper {
      max-width: 100%;
      margin: 0;
      padding: 0;
    }

    /* ===== HEADER ===== */
    .header {
      text-align: center;
      border-bottom: 3px double #333;
      padding-bottom: 14px;
      margin-bottom: 18px;
    }
    .header-logo {
      height: 65px;
      width: auto;
      object-fit: contain;
      display: block;
      margin: 0 auto 4px;
    }
    .header h1 {
      font-size: 20px;
      margin: 0 0 4px;
      letter-spacing: 1.5px;
      font-weight: 700;
    }
    .header p {
      margin: 2px 0;
      color: #555;
      font-size: 11px;
      line-height: 1.5;
    }

    .title-section {
      text-align: center;
      margin: 6px 0 14px;
    }
    .title-section h2 {
      font-size: 15px;
      text-transform: uppercase;
      letter-spacing: 3px;
      border: 2px solid #333;
      display: inline-block;
      padding: 5px 22px;
      margin: 0;
    }

    .sub-title {
      text-align: center;
      font-size: 11.5px;
      color: #666;
      margin-top: 4px;
      margin-bottom: 14px;
    }

    /* ===== TABLE ===== */
    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
    }

    thead th {
      background: #f2f4f7;
      font-size: 12px;
      font-weight: 600;
      text-align: center;
      padding: 8px 6px;
      border: 1px solid #ddd;
      color: #111;
    }

    tbody td {
      border: 1px solid #e1e1e1;
      padding: 7px 6px;
      font-size: 11.5px;
      text-align: center;
      color: #333;
    }

    tbody td:nth-child(4) {
      text-align: left;
      padding-left: 8px;
    }

    tbody tr:nth-child(even) {
      background: #fafafa;
    }

    /* ===== TTD ===== */
    .ttd-wrapper {
      margin-top: 30px;
      text-align: right;
    }
    .ttd-wrapper .ttd-city-date {
      font-size: 12px;
      color: #333;
      margin-bottom: 4px;
    }
    .ttd-wrapper .ttd-name {
      font-size: 13px;
      font-weight: 700;
      color: #000;
      margin-top: 70px;
    }
    .ttd-wrapper .ttd-title {
      font-size: 11px;
      color: #555;
      margin-top: 2px;
    }

    /* ===== PRINT ===== */
    @media print {
      body {
        background: #fff;
      }

      thead th {
        background: #f2f4f7 !important;
        -webkit-print-color-adjust: exact;
      }

      tbody tr:nth-child(even) {
        background: #fafafa !important;
      }

    }
  </style>
</head>

<body>

  <div class="page-wrapper">

    <div class="header">
      <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo_sinarmax.jpg'))) }}" class="header-logo">
      <h1>INVENTARIS GUDANG SINARMAX</h1>
      <p>Pergudangan Surya Grand Cisoka, Jl. Raya Cisoka No.03 Blok D, Cibugel, Kec. Cisoka, Kabupaten Tangerang, Banten 15730</p>
      <p>Telp: 08111208007 | Email: sinarmaxx@gmail.com</p>
    </div>

    <div class="title-section">
      <h2>Laporan Barang Keluar</h2>
    </div>

    @if ($tanggalMulai && $tanggalSelesai)
      <div class="sub-title">
        Rentang Tanggal: {{ $tanggalMulai }} - {{ $tanggalSelesai }}
      </div>
    @else
      <div class="sub-title">
        Rentang Tanggal: Semua
      </div>
    @endif

    <table>
      <thead>
        <tr>
          <th style="width:5%">No</th>
          <th style="width:16%">Kode Transaksi</th>
          <th style="width:12%">Tanggal</th>
          <th style="width:35%">Nama Barang</th>
          <th style="width:8%">Jumlah</th>
          <th style="width:24%">Customer</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $index => $item)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $item->kode_transaksi ?? '-' }}</td>
          <td>{{ $item->tanggal_keluar ?? '-' }}</td>
          <td>{{ $item->nama_barang ?? '-' }}</td>
          <td>{{ $item->jumlah_keluar ?? 0 }}</td>
          <td>{{ $item->customer->customer ?? '-' }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center;">Tidak ada data sesuai filter</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <div class="ttd-wrapper">
      <div class="ttd-city-date">Tangerang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</div>
      <div class="ttd-name">Muhamad Iqbal Said</div>
      <div class="ttd-title">Direktur</div>
    </div>

  </div>

</body>
</html>
