@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card text-center ">
            <div class="card-head">
                <h3>Crawling Data</h3>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" id="crawlBtn">Klik untuk mengambil data</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card text-center ">
            <div class="card-body">
                <div id="jsonOutput" class="json-result" style="display: none;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#crawlBtn').click(function() {
            $('#jsonOutput').html('Sedang mengambil data...').show();

            $.ajax({
                url: "{{ route('crawl.data') }}",
                method: 'GET',
                success: function(response) {
                    let jsonPretty = JSON.stringify(response, null, 4);
                    $('#jsonOutput').html(jsonPretty);
                },
                error: function() {
                    $('#jsonOutput').html('Gagal mengambil data.');
                }
            });
        });
    });
</script>
@endsection