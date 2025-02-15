@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card text-center ">
            <div class="card-head">
                <h1>Websocket Live Score</h1>
            </div>
            <div class="card-body">
                <a href="{{route('operator')}}" target="_blank"><button class="btn btn-primary">Panel Operator</button></a>
                <a href="{{route('scoreboard')}}" target="_blank"><button class="btn btn-primary">Panel Scoreboard</button></a>
            </div>
        </div>
    </div>
</div>
@endsection