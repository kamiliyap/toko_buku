@extends('layouts.admin')

@section('title', 'Semua Pesanan')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-secondary">📦 Semua Pesanan</h3>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $p)
                        <tr>
                            <td>{{ $loop->iteration + ($pesanan->currentPage() - 1) * $pesanan->perPage() }}</td>
                            <td>{{ $p->kode_pesanan ?? $p->id }}</td>
                            <td>{{ $p->nama_pelanggan ?? '-' }}</td>
                            <td>Rp {{ number_format($p->total ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $p->status ?? '-' }}</td>
                            <td>{{ $p->created_at?->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                Belum ada pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- pagination --}}
    <div class="mt-3">
        {{ $pesanan->links() }}
    </div>

</div>
@endsection
