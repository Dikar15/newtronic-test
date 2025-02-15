@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card text-center ">
            <div class="card-head">
                Tambah Produk
                @if (session('success'))
                <div style="color: green;">{{ session('success') }}</div>
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
                <form action="{{ route('produk.update', $produk->id) }}" method="POST">
                    @csrf 
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="produk" value="{{ $produk->produk }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Harga</label>
                            <input type="number" class="form-control" name="harga" value="{{ $produk->harga }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Stok</label>
                            <input type="number" class="form-control" name="stok" value="{{ $produk->stok }}" required>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Ubah Produk</button>
                </form>
                <div class="card-footer text-left">
                    <a href="{{route('menu.case1')}}"><button class="btn btn-danger">Kembali</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection