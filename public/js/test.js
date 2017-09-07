$(document).ready(function () {


    // Время начала

    var mounthStart = $('#mounthStartAuction').text();
    var dayStart = $('#dayStartAuction').text();
    var yearStart = $('#yearStartAuction').text();
    var timeStart = $('#timeStartAuction').text();
    var dateTimeStart = mounthStart + ' ' + dayStart + ' ' + yearStart + ' ' + timeStart;
    var countUpDate = new Date(dateTimeStart).getTime();

    // Время начала

    // Время конца

    var mounth = $('#mounthStopAuction').text();
    var day = $('#dayStopAuction').text();
    var year = $('#yearStopAuction').text();
    var time = $('#timeStopAuction').text();
    var dateTime = mounth + ' ' + day + ' ' + year + ' ' + time;
    var countDownDate = new Date(dateTime).getTime();

    // Время конца

    if (document.getElementById('timeStartText') !== null) {
        document.getElementById('timeStartText').innerHTML = 'До старта аукциона';
    }

    var y = setInterval(function() {
        var nowStart = new Date();
        var distanceStart = countUpDate - nowStart.getTime();
        var daysStart = Math.floor(distanceStart / (1000 * 60 * 60 * 24));
        var hoursStart = Math.floor((distanceStart % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutesStart = Math.floor((distanceStart % (1000 * 60 * 60)) / (1000 * 60));
        var secondsStart = Math.floor((distanceStart % (1000 * 60)) / 1000);

        if (document.getElementById('timer') !== null) {
            document.getElementById('timer').innerHTML = daysStart + ' <span> д. </span> ' + hoursStart + ' <span> ч. </span> '
                + minutesStart + ' <span> м. </span> ' + secondsStart + ' <span> с. </span> ';
        }

        if (distanceStart < 0) {
            document.getElementById('timer').innerHTML = '';
            document.getElementById('timer').classList.remove('active');
            document.getElementById('startTimer').className = 'active';
            $('.auction-card__full-bet').removeClass('bet__hide');
            document.getElementById('timeStartText').innerHTML = 'До конца аукциона';

            clearInterval(y);

        }

    }, 1000);

    var x = setInterval(function() {
        var now = new Date();
        var distance = countDownDate - now.getTime();
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (document.getElementById('startTimer') !== null) {
            document.getElementById('startTimer').innerHTML = days + ' <span> д. </span> ' + hours + ' <span> ч. </span> '
                + minutes + ' <span> м. </span> ' + seconds + ' <span> с. </span> ';
        }

        if (distance < 0) {
            var method = 'POST';
            var action = '/lot/check-time-stop';
            var lot_id = $('.bet input[name="lot_id"]').val();

            $.ajax({
                type: method,
                url: action,
                data: {
                    lot_id: lot_id,
                },

                success: function(data) {
                    var response = $.parseJSON(data);

                    if (response['status'] == 'success') {
                        clearInterval(x);
                        document.getElementById('startTimer').innerHTML = 'Аукцион закончен';

                        var winUser = $('#history-bets .bet:first-child').data('user-login');
                        var lot_status = $('.bet input[name="lot_status"]').val();
                        var user_id = $('#history-bets .bet:first-child').data('user-id');
                        var lot_id = $('.bet input[name="lot_id"]').val();

                        if (winUser && lot_status == 1) {
                            $('.auction-card__full-bet').remove();
                            $('.auction-card__full').append('<div id="winner">Лот выиграл ' + winUser + '</div>');
                            createWinner(user_id, lot_id);
                            changeLotStatus(lot_id);
                            notifyWinner();
                        } else if (!winUser && lot_status == 1) {
                            $('.auction-card__full-bet').remove();
                            $('.auction-card__full').append('<div id="winner">Победителей нет!</div>');
                            changeLotStatus(lot_id);
                        } else if (winUser && lot_status == 3) {
                            $('.auction-card__full-bet').remove();
                            $('.auction-card__full').append('<div id="winner">Лот выиграл ' + winUser + '</div>');
                        } else if (!winUser && lot_status == 3) {
                            $('.auction-card__full-bet').remove();
                            $('.auction-card__full').append('<div id="winner">Победителей нет!</div>');
                        }
                    }
                },

                error: function(e) {

                },
            });
        }
    }, 1000);


});