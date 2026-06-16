@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

.dashboard-wrap {
  font-family: 'Inter', sans-serif;
  padding: 0 0 20px 0;
}

/* ─── HEADER ─── */
.dash-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 32px;
  flex-wrap: wrap;
  gap: 12px;
}
.dash-header-left h1 {
  font-size: 28px;
  font-weight: 800;
  background: linear-gradient(135deg, #003366, #0066cc);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin: 0;
  letter-spacing: -0.5px;
}
.dash-header-left p {
  color: #5a6a8a;
  font-size: 14px;
  margin: 4px 0 0;
  font-weight: 400;
}
.dash-header-right {
  display: flex;
  gap: 10px;
}
.dash-header-right .date-badge {
  background: rgba(255,255,255,0.8);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.4);
  padding: 10px 18px;
  border-radius: 12px;
  font-size: 13px;
  font-weight: 500;
  color: #444;
  box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}

/* ─── STAT CARDS ─── */
.stat-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 32px;
}
@media (max-width: 992px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px) { .stat-grid { grid-template-columns: 1fr; } }

.stat-card {
  position: relative;
  background: rgba(255,255,255,0.85);
  backdrop-filter: blur(16px);
  border-radius: 20px;
  padding: 24px 22px;
  border: 1px solid rgba(255,255,255,0.6);
  box-shadow: 0 4px 24px rgba(0,0,0,0.04);
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.stat-card:hover {
  transform: translateY(-6px) scale(1.01);
  box-shadow: 0 12px 40px rgba(0,0,0,0.08);
}
.stat-card .stat-bg-icon {
  position: absolute;
  right: -10px;
  bottom: -10px;
  font-size: 80px;
  opacity: 0.06;
  color: inherit;
  pointer-events: none;
}
.stat-card .stat-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
}
.stat-card .stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  color: #fff;
}
.stat-card .stat-label {
  font-size: 13px;
  font-weight: 600;
  color: #8888a0;
  text-transform: uppercase;
  letter-spacing: 0.6px;
}
.stat-card .stat-number {
  font-size: 32px;
  font-weight: 800;
  color: #1a1a2e;
  line-height: 1.1;
  letter-spacing: -1px;
}
.stat-card .stat-trend {
  font-size: 12px;
  margin-top: 6px;
  color: #8888a0;
}
.stat-card .stat-trend span {
  font-weight: 700;
}

.stat-icon-blue { background: linear-gradient(135deg, #003366, #0055a5); }
.stat-icon-green { background: linear-gradient(135deg, #004d80, #0077be); }
.stat-icon-orange { background: linear-gradient(135deg, #0066cc, #3399ff); }
.stat-icon-purple { background: linear-gradient(135deg, #002b5e, #004d99); }

.stat-card:nth-child(1) { border-left: 3px solid #003366; }
.stat-card:nth-child(2) { border-left: 3px solid #004d80; }
.stat-card:nth-child(3) { border-left: 3px solid #0066cc; }
.stat-card:nth-child(4) { border-left: 3px solid #002b5e; }

/* ─── CHART ROW ─── */
.chart-row {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 20px;
  margin-bottom: 24px;
}
@media (max-width: 992px) { .chart-row { grid-template-columns: 1fr; } }

.chart-card {
  background: rgba(255,255,255,0.85);
  backdrop-filter: blur(16px);
  border-radius: 20px;
  padding: 24px 24px 20px;
  border: 1px solid rgba(255,255,255,0.6);
  box-shadow: 0 4px 24px rgba(0,0,0,0.04);
  transition: all 0.3s ease;
}
.chart-card:hover {
  box-shadow: 0 8px 32px rgba(0,0,0,0.06);
}
.chart-card .card-label {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
}
.chart-card .card-label h4 {
  font-size: 16px;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0;
}
.chart-card .card-label .badge-count {
  font-size: 12px;
  background: #f0f0ff;
  color: #5555cc;
  padding: 4px 12px;
  border-radius: 20px;
  font-weight: 600;
}
.chart-container {
  position: relative;
  width: 100%;
  height: 300px;
}

/* ─── STOCK MINI LIST (right sidebar chart) ─── */
.stock-mini-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.stock-mini-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 14px;
  background: rgba(245,247,255,0.6);
  border-radius: 12px;
  border: 1px solid rgba(230,235,255,0.5);
  transition: all 0.25s ease;
}
.stock-mini-item:hover {
  background: rgba(245,247,255,0.9);
  transform: translateX(4px);
}
.stock-mini-item .mini-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #f59e0b;
  flex-shrink: 0;
}
.stock-mini-item .mini-info {
  flex: 1;
  min-width: 0;
}
.stock-mini-item .mini-info .mini-name {
  font-size: 13px;
  font-weight: 600;
  color: #1a1a2e;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.stock-mini-item .mini-info .mini-code {
  font-size: 11px;
  color: #999;
}
.stock-mini-item .mini-stok {
  font-size: 14px;
  font-weight: 700;
  color: #dc2626;
  background: rgba(220,38,38,0.08);
  padding: 2px 10px;
  border-radius: 8px;
}
.stock-mini-empty {
  text-align: center;
  padding: 40px 20px;
  color: #aaa;
  font-size: 14px;
}
.stock-mini-empty i {
  font-size: 36px;
  display: block;
  margin-bottom: 10px;
  opacity: 0.3;
}

/* ─── TABLE ─── */
.table-card {
  background: rgba(255,255,255,0.85);
  backdrop-filter: blur(16px);
  border-radius: 20px;
  padding: 24px 24px 20px;
  border: 1px solid rgba(255,255,255,0.6);
  box-shadow: 0 4px 24px rgba(0,0,0,0.04);
}
.table-card .card-label {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}
.table-card .card-label h4 {
  font-size: 16px;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0;
}
.table-card .card-label a {
  font-size: 13px;
  color: #667eea;
  font-weight: 600;
  text-decoration: none;
}
.modern-table {
  width: 100%;
  border-collapse: collapse;
}
.modern-table thead th {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  color: #8888a0;
  padding: 12px 14px;
  text-align: left;
  border-bottom: 2px solid #f0f0ff;
}
.modern-table tbody td {
  padding: 14px;
  font-size: 14px;
  color: #333;
  border-bottom: 1px solid #f5f5ff;
}
.modern-table tbody tr:last-child td {
  border-bottom: none;
}
.modern-table tbody tr {
  transition: all 0.2s ease;
}
.modern-table tbody tr:hover {
  background: rgba(102,126,234,0.04);
}
.stok-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 700;
}
.stok-badge-danger {
  background: rgba(220,38,38,0.1);
  color: #dc2626;
}
.stok-badge-warning {
  background: rgba(245,158,11,0.12);
  color: #d97706;
}
.stok-badge-safe {
  background: rgba(16,185,129,0.1);
  color: #059669;
}

/* ─── FOOTER ─── */
.dash-footer {
  text-align: center;
  padding: 24px 0 8px;
  font-size: 12px;
  color: #aaa;
  border-top: 1px solid #f0f0ff;
  margin-top: 24px;
}

/* ─── ANIMATIONS ─── */
@keyframes fadeSlideUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.stat-card { animation: fadeSlideUp 0.6s ease forwards; opacity: 0; }
.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.1s; }
.stat-card:nth-child(3) { animation-delay: 0.15s; }
.stat-card:nth-child(4) { animation-delay: 0.2s; }
.chart-card { animation: fadeSlideUp 0.6s ease 0.2s forwards; opacity: 0; }
.table-card { animation: fadeSlideUp 0.6s ease 0.3s forwards; opacity: 0; }
</style>

<div class="dashboard-wrap">

  {{-- HEADER --}}
    <div class="dash-header">
    <div class="dash-header-left d-flex align-items-center" style="gap:16px;">
      <img src="{{ asset('assets/img/logo_sinarmax.jpg') }}" alt="Logo Sinarmax" style="width:auto;height:52px;border-radius:8px;object-fit:contain;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
      <div>
        <h1>Dashboard</h1>
        <p>Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>! Ringkasan sistem gudang hari ini.</p>
      </div>
    </div>
    <div class="dash-header-right">
      <div class="date-badge">
        <i class="far fa-calendar-alt mr-2"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
      </div>
    </div>
  </div>

  {{-- STAT CARDS --}}
  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-top">
        <div class="stat-icon stat-icon-blue"><i class="fas fa-cubes"></i></div>
        <span class="stat-label">Total Barang</span>
      </div>
      <div class="stat-number" id="count-barang">0</div>
      <div class="stat-trend"><span>Total</span> seluruh barang dalam gudang</div>
      <div class="stat-bg-icon"><i class="fas fa-cubes"></i></div>
    </div>
    <div class="stat-card">
      <div class="stat-top">
        <div class="stat-icon stat-icon-green"><i class="fas fa-arrow-right"></i></div>
        <span class="stat-label">Barang Masuk</span>
      </div>
      <div class="stat-number" id="count-masuk">0</div>
      <div class="stat-trend"><span>Total</span> transaksi barang masuk</div>
      <div class="stat-bg-icon"><i class="fas fa-arrow-right"></i></div>
    </div>
    <div class="stat-card">
      <div class="stat-top">
        <div class="stat-icon stat-icon-orange"><i class="fas fa-arrow-left"></i></div>
        <span class="stat-label">Barang Keluar</span>
      </div>
      <div class="stat-number" id="count-keluar">0</div>
      <div class="stat-trend"><span>Total</span> transaksi barang keluar</div>
      <div class="stat-bg-icon"><i class="fas fa-arrow-left"></i></div>
    </div>
    <div class="stat-card">
      <div class="stat-top">
        <div class="stat-icon stat-icon-purple"><i class="fas fa-users"></i></div>
        <span class="stat-label">Pengguna</span>
      </div>
      <div class="stat-number" id="count-user">0</div>
      <div class="stat-trend"><span>Total</span> pengguna terdaftar</div>
      <div class="stat-bg-icon"><i class="fas fa-users"></i></div>
    </div>
  </div>

  {{-- CHART + STOCK MINI --}}
  <div class="chart-row">
    <div class="chart-card">
      <div class="card-label">
        <h4><i class="fas fa-chart-bar mr-2" style="color:#003366;"></i> Grafik Barang Masuk & Keluar</h4>
        <span class="badge-count">{{ count($barangMasukData) }} bulan</span>
      </div>
      <div class="chart-container">
        <canvas id="summaryChart"></canvas>
      </div>
    </div>
    <div class="chart-card">
      <div class="card-label">
        <h4><i class="fas fa-exclamation-triangle mr-2" style="color:#cc6600;"></i> Stok Minimum</h4>
        <span class="badge-count">{{ count($barangMinimum) }} item</span>
      </div>
      <div class="stock-mini-list">
        @forelse($barangMinimum->take(6) as $item)
        <div class="stock-mini-item">
          @php
            $images = is_string($item->gambar) ? json_decode($item->gambar, true) : ($item->gambar ?? []);
            $imgSrc = !empty($images) ? '/storage/' . $images[0] : null;
          @endphp
          @if($imgSrc)
            <img src="{{ $imgSrc }}" alt="" style="width:32px;height:32px;border-radius:8px;object-fit:cover;flex-shrink:0;">
          @else
            <div class="mini-dot"></div>
          @endif
          <div class="mini-info">
            <div class="mini-name">{{ $item->nama_barang }}</div>
            <div class="mini-code">{{ $item->kode_barang }}</div>
          </div>
          <div class="mini-stok">{{ $item->stok }}</div>
        </div>
        @empty
        <div class="stock-mini-empty">
          <i class="fas fa-check-circle" style="color:#059669;"></i>
          Semua stok dalam keadaan aman
        </div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- TABLE --}}
  <div class="table-card">
    <div class="card-label">
      <h4><i class="fas fa-list mr-2" style="color:#003366;"></i> Detail Stok Minimum</h4>
      @if(count($barangMinimum) > 0)
      <a href="/barang"><span>Lihat Semua <i class="fas fa-arrow-right ml-1" style="font-size:11px;"></i></span></a>
      @endif
    </div>
    <div style="overflow-x:auto;">
      <table class="modern-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Stok Saat Ini</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($barangMinimum as $item)
          @php
            $images = is_string($item->gambar) ? json_decode($item->gambar, true) : ($item->gambar ?? []);
            $imgSrc = !empty($images) ? '/storage/' . $images[0] : null;
          @endphp
          <tr>
            <td style="color:#8888a0;font-weight:500;">{{ $loop->iteration }}</td>
            <td>
              @if($imgSrc)
                <img src="{{ $imgSrc }}" width="48" height="48" style="border-radius:8px;object-fit:cover;">
              @else
                <div style="width:48px;height:48px;background:#f1f1f1;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:10px;color:#999;">NoImg</div>
              @endif
            </td>
            <td style="font-weight:600;">{{ $item->kode_barang }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td><span class="stok-badge stok-badge-danger">{{ $item->stok }}</span></td>
            <td><span class="stok-badge stok-badge-warning"><i class="fas fa-exclamation-circle mr-1"></i>Minimum</span></td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="text-align:center;padding:40px 20px;color:#aaa;">
              <i class="fas fa-check-circle" style="font-size:28px;display:block;margin-bottom:8px;color:#059669;"></i>
              Semua stok dalam kondisi aman &mdash; tidak ada barang yang mencapai batas minimum.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- FOOTER --}}
  <div class="dash-footer">
    Inventaris Gudang Sinarmax &copy; {{ date('Y') }} &mdash; All rights reserved.
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ─── ANIMATED COUNTER ───
  function animateCounter(id, target, duration) {
    const el = document.getElementById(id);
    if (!el) return;
    const start = 0;
    const startTime = performance.now();
    function step(now) {
      const elapsed = now - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.floor(start + (target - start) * eased);
      if (progress < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }
  animateCounter('count-barang', {{ $barang }}, 1000);
  animateCounter('count-masuk', {{ $barangMasuk }}, 1000);
  animateCounter('count-keluar', {{ $barangKeluar }}, 1000);
  animateCounter('count-user', {{ $user }}, 1000);

  // ─── CHART ───
  try {
    const canvas = document.getElementById('summaryChart');
    if (!canvas) throw new Error('Canvas not found');
    const ctx = canvas.getContext('2d');
    const gradBlue = ctx.createLinearGradient(0, 0, 0, 280);
    gradBlue.addColorStop(0, 'rgba(0, 51, 102, 0.6)');
    gradBlue.addColorStop(1, 'rgba(0, 51, 102, 0.02)');
    const gradRed = ctx.createLinearGradient(0, 0, 0, 280);
    gradRed.addColorStop(0, 'rgba(0, 102, 204, 0.55)');
    gradRed.addColorStop(1, 'rgba(0, 102, 204, 0.02)');

    const labels = [
    @foreach($chartLabels as $label)
      '{{ $label }}',
    @endforeach
    ];
    const masukData = [
    @foreach($barangMasukData as $total)
      {{ $total }},
    @endforeach
    ];
    const keluarData = [
    @foreach($barangKeluarData as $total)
      {{ $total }},
    @endforeach
    ];

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Barang Masuk',
          data: masukData,
          backgroundColor: gradBlue,
          borderColor: 'rgba(102, 126, 234, 0.8)',
          borderWidth: 1,
          borderRadius: 6,
          borderSkipped: false,
        },
        {
          label: 'Barang Keluar',
          data: keluarData,
          backgroundColor: gradRed,
          borderColor: 'rgba(245, 87, 108, 0.8)',
          borderWidth: 1,
          borderRadius: 6,
          borderSkipped: false,
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: {
        duration: 1200,
        easing: 'easeOutQuart'
      },
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: '#666',
            boxWidth: 12,
            padding: 16,
            font: { size: 12, family: 'Inter' }
          }
        },
        tooltip: {
          backgroundColor: 'rgba(26,26,46,0.9)',
          titleColor: '#fff',
          bodyColor: '#fff',
          padding: 12,
          cornerRadius: 10,
          displayColors: true,
          boxPadding: 4,
        }
      },
      scales: {
        x: {
          grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
          ticks: { color: '#888', font: { size: 11, family: 'Inter' } }
        },
        y: {
          grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
          ticks: { color: '#888', font: { size: 11, family: 'Inter' }, stepSize: 1, precision: 0 },
          beginAtZero: true
        }
      }
    }
  });
  } catch(e) { console.error('Chart error:', e); }
});
</script>
@endpush
