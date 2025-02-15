@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card text-center ">
            <div class="card-head">
                <h3>Buat Transaksi</h3>
                @if (session('success-transaksi'))
                <div style="color: green;">{{ session('success-transaksi') }}</div>
                @endif

                @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="card-body">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Stok Tersedia</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produk as $item)
                                <tr>
                                    <td class="text-left">
                                        <input type="checkbox" name="id_produk[]" value="{{ $item->id }}">
                                        {{ $item->produk }}
                                    </td>
                                    <td>{{ $item->stok }}</td>
                                    <td>
                                        <input type="number" name="quantity[]" class="form-control" value="1" min="1" max="{{ $item->stok }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary">Checkout</button>
                </form>
            </div>
            <div class="card-footer text-left">
                <a href="{{route('menu.case1')}}"><button class="btn btn-danger">Kembali</button></a>
            </div>
        </div>
    </div>
</div>
@endsection