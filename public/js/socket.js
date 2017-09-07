window.onload = function() {
	var socket = new WebSocket("ws://socket.inpk-security.com:8080");
	var status = document.querySelector("#history-bets");
	
	// socket.onopen = function() {
	// 	status.innerHTML = "cоединение установлено<br>";
	// };

	// socket.onclose = function(event) {
	// 	if (event.wasClean) {
	// 	  status.innerHTML = 'cоединение закрыто';
	// 	} else {
	// 	  status.innerHTML = 'соединения как-то закрыто';
	// 	}

	// 	status.innerHTML += '<br>код: ' + event.code + ' причина: ' + event.reason;
	// };

	socket.onmessage = function(event) {
		// let message = JSON.parse(event.data);
		// $('#lastBet').text(`${message.bet}`);
		// $('.bet-sum').val(`${message.bet}`);

		// let newFormatBet = (parseInt(message.bet)).toLocaleString();

		// $('#history-bets').prepend(`
		// 	<tr class="bet table-item user-bet-item" data-user-login="${message.userLogin}" 
		// 	data-user-id="${message.userId}">
		// 		<td class="table-align-left">${message.userLogin}</td>
		// 		<td class="table-align-center"><div class="user-bet">${message.bet}</div> руб.<span class="user-bet-count"></span></td>
		// 		<td class="table-align-right">${message.dateBet}</td>
		// 	</tr>
		// `);

		var message = JSON.parse(event.data);
		//var betSum = parseInt(message['bet']).toLocaleString();
		var betSum = accounting.formatNumber(message['bet'], {
			thousand : " "
		});
		
		$('#lastBet').text(message['bet']);
		$('.bet-sum').val(message['bet']);
		$('#currentCost').text(message['bet']);
		$('#currentLotCost').text(accounting.formatNumber(message['bet'], {
			thousand: " "
		}));
		$('.betCount').text(betSum);

		// $('#history-bets').prepend(`
		// 	<tr class="bet table-item user-bet-item" data-user-login="${message.userLogin}" 
		// 	data-user-id="${message.userId}">
		// 		<td class="table-align-left">${message.userLogin}</td>
		// 		<td class="table-align-center"><div class="user-bet-value" style="display: none;">${message.bet}</div><div class="user-bet"></div> руб.<span class="user-bet-count"></span></td>
		// 		<td class="table-align-right">${message.dateBet}</td>
		// 	</tr>
		// `);

		$('#history-bets').prepend(
			'<tr class="bet table-item user-bet-item" data-user-login="' + message['userLogin'] + '" data-user-id="' + message['userId'] + '">'+ 
				'<td class="table-align-left">' + message['userLogin'] + '</td>'+
				'<td class="table-align-center"><div class="user-bet-value" style="display: none;">' + message['bet'] + '</div><div class="user-bet"></div> руб.<span class="user-bet-count"></span></td>'+
				'<td class="table-align-right">' + message['dateBet'] + '</td>'+
			'</tr>'
		);

		userBetCount();

	};

	// socket.onerror = function(event) {
	// 	status.innerHTML = "ошибка " + event.message;
	// };

	formName = $('form').attr('name');

	if (formName == 'messages') {
		document.forms['messages'].onsubmit = function() {
			var message = {
			   userId: this.user_id.value,
			   userLogin: this.user_login.value,
			   userEmail: this.user_email.value,
			   dateBet: this.date_bet.value,
			   // previousBet: this.previous_bet.value,
			   bet: this.bet.value,
			}

			var lastBet = $('#lastBet').text();
			
			if (Number(this.bet.value) > Number($.trim(lastBet)) && Number(this.bet.value) != Number($.trim(lastBet))) {		
				socket.send(JSON.stringify(message));
			}

			return false;
		}
	}
}