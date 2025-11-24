{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-main">

    {{-- JUDUL + SUBTITLE --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-1">Dashboard Admin</h3>
            <div class="text-muted">Ringkasan toko buku & aktivitas terbaru</div>
        </div>
        <div class="text-end">
            <small class="text-muted">Hari ini: {{ now()->format('d M Y') }}</small>
        </div>
    </div>

    {{-- ALERT (JIKA ADA) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ================== ROW 1: STAT CARDS ================== --}}
    <div class="row g-3 mb-3">

        <div class="col-12 col-md-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Total Buku</div>
                            <h4 class="fw-bold mb-0">{{ $totalBuku ?? 0 }}</h4>
                        </div>
                        <div class="rounded-circle bg-primary-subtle p-3">
                            <i class="bi bi-book fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small mb-1">Berita</div>
                    <h4 class="fw-bold mb-0">{{ $totalBerita ?? 0 }}</h4>
                    <div class="small text-muted mt-1">Konten informasi di situs</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small mb-1">Pesanan Hari Ini</div>
                    <h4 class="fw-bold mb-0">{{ $totalPesananHariIni ?? 0 }}</h4>
                    <div class="small text-muted mt-1">Transaksi masuk</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small mb-1">Pendapatan Hari Ini</div>
                    <h4 class="fw-bold mb-0">
                        Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}
                    </h4>
                    <div class="small text-muted mt-1">Belum termasuk besok 😄</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================== ROW 2: GRAFIK + STOK RENDAH ================== --}}
    <div class="row g-3 mb-3">

        {{-- GRAFIK PENJUALAN (dummy data, bisa diisi dari controller) --}}
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h5 class="card-title mb-0">Penjualan 7 Hari Terakhir</h5>
                        <small class="text-muted">Grafik sederhana (demo)</small>
                    </div>
                    <canvas id="salesChart" height="120"></canvas>
                </div>
            </div>
        </div>

        {{-- STOK RENDAH --}}
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title mb-2">Stok Hampir Habis</h5>
                    <small class="text-muted d-block mb-2">
                        Buku dengan stok &lt;= 5
                    </small>

                    @if(!empty($bukuStokRendah) && count($bukuStokRendah) > 0)
                        <ul class="list-group list-group-flush small">
                            @foreach($bukuStokRendah as $b)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>{{ $b->judul }}</span>
                                    <span class="badge bg-danger-subtle text-danger">
                                        Stok: {{ $b->stok }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">Belum ada stok yang kritis.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ================== ROW 3: PESANAN TERBARU + BERITA TERBARU ================== --}}
    <div class="row g-3">

        {{-- PESANAN TERBARU --}}
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                        <small class="text-muted">5 pesanan terakhir</small>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pesananTerbaru ?? [] as $p)
                                    <tr>
                                        <td class="fw-semibold">{{ $p->kode_pesanan }}</td>
                                        <td>{{ $p->nama_pelanggan }}</td>
                                        <td>Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                                        <td>{{ $p->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success">
                                                Selesai
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Belum ada pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- BERITA TERBARU --}}
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title mb-2">Berita Terbaru</h5>
                    <small class="text-muted d-block mb-2">Update informasi toko</small>

                    @if(!empty($beritaTerbaru) && count($beritaTerbaru) > 0)
                        <ul class="list-group list-group-flush small">
                            @foreach($beritaTerbaru as $b)
                                <li class="list-group-item px-0">
                                    <div class="fw-semibold">{{ $b->judul }}</div>
                                    <div class="text-muted small">
                                        {{ $b->created_at->format('d M Y') }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">Belum ada berita.</p>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('berita.index') ?? '#' }}" class="btn btn-outline-primary btn-sm">
                            Kelola Berita
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@section('scripts')
    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data demo, nanti bisa kamu ganti dari controller
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labelPenjualan ?? ['Sen','Sel','Rab','Kam','Jum','Sab','Min']) !!},
                datasets: [{
                    label: 'Total Penjualan',
                    data: {!! json_encode($dataPenjualan ?? [5, 7, 3, 9, 4, 6, 8]) !!},
                    fill: false,
                    tension: 0.3,
                    borderWidth: 2
                }]
            },
        });
    </script>
@endsection
