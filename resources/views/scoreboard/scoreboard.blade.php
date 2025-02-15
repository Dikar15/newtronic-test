@extends('layouts.layout')

@section('css')
    <style>
        .team-score {
            font-size: 2.5em;
            font-weight: bold;
            transition: transform 0.3s ease;
        }

        .score-update {
            color: #28a745;
            transform: scale(1.3);
        }

        .team-name {
            font-size: 1.2em;
            font-weight: bold;
            color: #6c757d;
        }

        .game-card {
            transition: box-shadow 0.3s;
        }

        .game-card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Live Scoreboard</h2>

        <div class="row">
            @foreach($games as $game)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm game-card game" data-game-id="{{ $game->id }}">
                        <div class="card-body text-center">
                            <h4 class="card-title">{{ $game->team1 }} vs {{ $game->team2 }}</h4>
                            <h6 class="card-subtitle mb-3 text-muted">{{ ucfirst($game->sport) }}</h6>
                            
                            <div class="d-flex justify-content-around align-items-center">
                                <div>
                                    <span class="team-name">{{ $game->team1 }}</span>
                                    <div class="team-score" 
                                         data-team="{{ addslashes($game->team1) }}" 
                                         id="score-{{ str_replace(' ', '-', $game->team1) }}">
                                        {{ $game->score->team1_score ?? 0 }}
                                    </div>
                                </div>

                                <div class="fs-1">-</div>

                                <div>
                                    <span class="team-name">{{ $game->team2 }}</span>
                                    <div class="team-score" 
                                         data-team="{{ addslashes($game->team2) }}" 
                                         id="score-{{ str_replace(' ', '-', $game->team2) }}">
                                        {{ $game->score->team2_score ?? 0 }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
