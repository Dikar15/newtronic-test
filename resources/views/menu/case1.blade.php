@extends('layouts.layout')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card text-center ">
            <div class="card-head">
                <h3>Data Transaksi</h3>
                @if (session('success-transaksi'))
                <div style="color: green;">{{ session('success-transaksi') }}</div>
                @endif
            </div>
            <div class="card-body">
            <table id="transaksi-table" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->kode_transaksi }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>
                                <a href="{{ route('transaksi.detil', $item->id) }}"><button class="btn btn-warning"> Detail </button></a>
                                <form action="{{ route('transaksi.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{route('transaksi.index')}}"><button class="btn btn-primary">Buat Transaksi</button></a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card text-center ">
            <div class="card-head">
                <h3>Data Produk</h3>
                @if (session('success-produk'))
                <div style="color: green;">{{ session('success-produk') }}</div>
                @endif
            </div>
            <div class="card-body">
                <table id="produk-table" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Produk</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->produk }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('produk.edit', $item->id) }}"><button class="btn btn-warning"> Ubah </button></a>
                                <form action="{{ route('produk.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{route('produk.index')}}"><button class="btn btn-primary">Tambah Produk</button></a>
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
        $('#transaksi-table').DataTable();
    });
</script>

@endsection