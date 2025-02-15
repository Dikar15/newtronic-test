import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '95520a7c8473b7735ccc',
    cluster: 'mt1',
    forceTLS: true
});

function updateScore(team, score) {
    let teamElement = $(`[data-team='${team}']`);
    if (teamElement.length) {
        teamElement.text(score);

        teamElement.addClass('score-update');
        setTimeout(() => {
            teamElement.removeClass('score-update');
        }, 500);
    }
}

function listenToGameChannel(gameId) {
    window.Echo.channel(`game.${gameId}`)
        .listen('ScoreUpdated', (e) => {
            console.log(`Update dari Game ID: ${gameId}`, e);
            updateScore(e.team, e.score);
        });
}

$(document).ready(function() {
    console.log('Document ready, memulai listener WebSocket...');

    $('.game').each(function() {
        let gameId = $(this).data('game-id');
        console.log('Listening untuk Game ID:', gameId);
        if (gameId) {
            listenToGameChannel(gameId);
        }
    });
});
