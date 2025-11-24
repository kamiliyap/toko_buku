{{-- resources/views/pembelian/nota_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota {{ $pesanan->kode_pesanan }}</title>
    <style>
        body{
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 12px;
        }
        .title{
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .subtitle{
            font-size: 11px;
            color: #555;
            margin-bottom: 16px;
        }
        .box{
            border: 1px solid #ddd;
            padding: 12px 14px;
            border-radius: 6px;
            margin-bottom: 14px;
        }
        .label{
            font-weight: bold;
        }
        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td{
            border: 1px solid #ddd;
            padding: 6px 8px;
        }
        th{
            background: #f3f3f3;
        }
        .text-right{
            text-align: right;
        }
        .mt-2{ margin-top: 8px; }
        .mt-3{ margin-top: 12px; }
    </style>
</head>
<body>

    <div class="title">Toko Buku Pintar</div>
    <div class="subtitle">Nota Pembelian</div>

    <div class="box">
        <div><span class="label">Kode Pesanan:</span> {{ $pesanan->kode_pesanan }}</div>
        <div><span class="label">Nama:</span> {{ $pesanan->nama_pelanggan }}</div>
        <div><span class="label">No HP:</span> {{ $pesanan->no_hp ?? '-' }}</div>
        <div><span class="label">Alamat:</span> {{ $pesanan->alamat ?? '-' }}</div>
        <div class="mt-2"><span class="label">Tanggal:</span> {{ $pesanan->created_at->format('d-m-Y H:i') }}</div>
    </div>

    <div class="box">
        <div class="label">Detail Buku</div>

        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th style="width:40px;">Qty</th>
                    <th style="width:90px;">Harga</th>
                    <th style="width:100px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->details as $detail)
                    <tr>
                        <td>{{ $detail->buku->judul ?? '-' }}</td>
                        <td class="text-right">{{ $detail->qty }}</td>
                        <td class="text-right">
                            Rp {{ number_format($detail->harga, 0, ',', '.') }}
                        </td>
                        <td class="text-right">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3 text-right">
            <div>Subtotal: Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</div>
            <div>PPN (10%): Rp {{ number_format($pesanan->ppn, 0, ',', '.') }}</div>
            <div class="label mt-2">
                Total: Rp {{ number_format($pesanan->total, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div style="margin-top:30px;font-size:11px;color:#666;">
        Terima kasih telah berbelanja di Toko Buku Pintar.
    </div>

</body>
</html>
