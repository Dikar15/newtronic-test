@extends('layouts.layout')
@section('css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div id="loader" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); z-index:9999;">
    <img src="https://i.gifer.com/ZZ5H.gif" alt="Loading..." style="width:100px;">
</div>

<div class="row">
    <h1 class="text-center mb-4">Operator Panel</h1>
</div>
<div class="row">
    @foreach($games as $game)
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">{{ $game->team1 }} vs {{ $game->team2 }}</h4>
                <h5 class="card-subtitle mb-3 text-muted">{{ ucfirst($game->sport) }}</h5>
                <p class="card-text fs-5">
                    <span id="score-{{ str_replace(' ', '-', $game->team1) }}">
                        {{ $game->score->team1_score ?? 0 }}
                    </span>
                    -
                    <span id="score-{{ str_replace(' ', '-', $game->team2) }}">
                        {{ $game->score->team2_score ?? 0 }}
                    </span>
                </p>

                @if(strtolower($game->sport) === 'basket')
                <div class="d-flex justify-content-between">
                    <div>
                        <button class="btn btn-primary" onclick="updateScore({{ $game->id }}, '{{ $game->team1 }}', 1)">
                            +1 {{ $game->team1 }}
                        </button>
                        <button class="btn btn-success" onclick="updateScore({{ $game->id }}, '{{ $game->team1 }}', 2)">
                            +2 {{ $game->team1 }}
                        </button>
                        <button class="btn btn-danger" onclick="updateScore({{ $game->id }}, '{{ $game->team1 }}', 3)">
                            +3 {{ $game->team1 }}
                        </button>
                    </div>

                    <div>
                        <button class="btn btn-primary" onclick="updateScore({{ $game->id }}, '{{ $game->team2 }}', 1)">
                            +1 {{ $game->team2 }}
                        </button>
                        <button class="btn btn-success" onclick="updateScore({{ $game->id }}, '{{ $game->team2 }}', 2)">
                            +2 {{ $game->team2 }}
                        </button>
                        <button class="btn btn-danger" onclick="updateScore({{ $game->id }}, '{{ $game->team2 }}', 3)">
                            +3 {{ $game->team2 }}
                        </button>
                    </div>
                </div>
                @else
                <div class="d-flex justify-content-between">
                    <!-- Tombol untuk olahraga umum -->
                    <button class="btn btn-primary" onclick="updateScore({{ $game->id }}, '{{ $game->team1 }}', 1)">
                        +1 {{ $game->team1 }}
                    </button>
                    <button class="btn btn-danger" onclick="updateScore({{ $game->id }}, '{{ $game->team2 }}', 1)">
                        +1 {{ $game->team2 }}
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function updateScore(gameId, teamName, score) {
        $('#loader').fadeIn();
        $.ajax({
            url: '/update-score',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                game_id: gameId,
                team_name: teamName,
                score: score
            },
            success: function(response) {
                console.log('Score updated successfully');

                let safeTeamName = teamName.replace(/\s+/g, '-');
                let scoreElement = $('#score-' + safeTeamName);

                if (scoreElement.length) {
                    let currentScore = parseInt(scoreElement.text());
                    scoreElement.text(currentScore + score);
                }

                showNotification('Skor Bertambah Untuk ' + teamName);

                $('#loader').fadeOut();
            },
            error: function(xhr) {
                console.log('Failed to update score');
                $('#loader').fadeOut();
            }
        });
    }

    function showNotification(message) {
        var notification = $('<div class="notification">' + message + '</div>');
        $('body').append(notification);

        notification.css({
            position: 'fixed',
            bottom: '20px',
            right: '20px',
            background: '#4caf50',
            color: 'white',
            padding: '10px 20px',
            borderRadius: '5px',
            boxShadow: '0 4px 8px rgba(0,0,0,0.2)',
            display: 'none',
            zIndex: 9999
        });

        notification.fadeIn(400).delay(2000).fadeOut(400, function() {
            $(this).remove();
        });
    }
</script>
@endsection