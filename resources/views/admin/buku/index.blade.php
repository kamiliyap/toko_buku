@extends('layouts.admin')

@section('title', 'Daftar Buku')

@section('content')
<div class="container-main">

    {{-- JUDUL --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">📚 Daftar Buku</h3>

        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            + Tambah Buku
        </a>
    </div>

    {{-- SWEETALERT SUKSES --}}
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Berhasil!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    timer: 1800,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    {{-- TABEL --}}
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">

            <table class="table table-hover">
                <thead class="table-light">
                <tr>
                    <th width="5%">#</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Penerbit</th>
                    <th width="8%">Stok</th>
                    <th width="15%">Harga</th>
                    <th width="12%">Gambar</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @forelse($buku as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $b->judul }}</td>
                        <td>{{ $b->penulis ?? '-' }}</td>
                        <td>{{ $b->kategori ?? '-' }}</td>
                        <td>{{ $b->penerbit ?? '-' }}</td>
                        <td>{{ $b->stok }}</td>
                        <td>Rp {{ number_format($b->harga,0,',','.') }}</td>

                        <td>
                            @if($b->gambar)
                                <img src="{{ asset('storage/'.$b->gambar) }}" 
                                     style="width:60px; height:70px; object-fit:cover;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td class="text-center">

                            {{-- EDIT --}}
                            <a href="{{ route('buku.edit', $b->id) }}" 
                               class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            {{-- HAPUS + SWEETALERT --}}
                            <button class="btn btn-sm btn-danger"
                                    onclick="hapusBuku({{ $b->id }})">
                                Hapus
                            </button>

                            <form id="form-hapus-{{ $b->id }}"
                                  action="{{ route('buku.destroy', $b->id) }}"
                                  method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-3">
                            Belum ada data buku.
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>
@endsection


{{-- ===================== JS SWEETALERT ===================== --}}
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function hapusBuku(id) {
    Swal.fire({
        title: "Yakin Hapus?",
        text: "Data buku ini akan hilang permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-hapus-' + id).submit();
        }
    });
}
</script>
@endsection
