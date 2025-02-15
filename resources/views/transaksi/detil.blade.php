@extends('layouts.layout')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card text-center ">
            <div class="card-head">
                <h3>Detail Transaksi</h3>
                @if (session('success-transaksi'))
                <div style="color: green;">{{ session('success-transaksi') }}</div>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-left ">
                            <th colspan="6">KODE TRANSAKSI : {{ $detailTransaksi->kode_transaksi }}</th>
                        </tr>
                        <tr class="text-left ">
                            <th colspan="6">TANGGAL : {{ $detailTransaksi->tanggal }}</th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Quantity</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailTransaksi->detail as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->produk->produk }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp. {{ number_format($item->produk->harga , 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($item->quantity * $item->produk->harga , 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('transaksiDetil.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-left">
                <a href="{{route('transaksi.edit', $id)}}"><button class="btn btn-warning">Ubah</button></a>
                <a href="{{route('menu.case1')}}"><button class="btn btn-danger">Kembali</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#produk-table').DataTable();
    });
</script>

@endsection