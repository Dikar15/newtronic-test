@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card text-center ">
            <div class="card-head">
                <h3>Ubah Transaksi</h3>
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
                <form action="{{ route('transaksi.update', $transaksi->id) }}" method="post">
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $index => $item)
                            @php
                            $detail = $transaksi->detail->firstWhere('id_produk', $item->id);
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->produk }}</td>
                                <td>
                                    <input type="checkbox" class="toggle-quantity"
                                        data-target="quantity-{{ $item->id }}"
                                        {{ $detail ? 'checked' : '' }}>

                                    <input type="number"
                                        id="quantity-{{ $item->id }}"
                                        name="produk[{{ $item->id }}]"
                                        value="{{ $detail ? $detail->quantity : 0 }}"
                                        min="0"
                                        class="form-control quantity"
                                        {{ $detail ? '' : 'disabled' }}>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
            <div class="card-footer text-left">
                <a href="{{route('transaksi.detil', $id)}}"><button class="btn btn-danger">Kembali</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    document.querySelectorAll('.toggle-quantity').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);

            input.disabled = !this.checked;

            if (!this.checked) {
                input.value = 0;
            }
        });
    });
</script>
@endsection