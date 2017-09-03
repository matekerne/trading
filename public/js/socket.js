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
		let message = JSON.parse(event.data);

		$('#lastBet').text(`${message.bet}`);
		$('.bet-sum').val(`${message.bet}`);

		$('#history-bets').prepend(`
			<tr class="bet table-item" data-user-email="${message.userEmail}" 
				data-user-login="${message.userLogin}" 
				data-user-id="${message.userId}">
				
				<td class="table-align-left">${message.userLogin}</td>
				<td class="table-align-center">${message.bet} руб.</td>
				<td class="table-align-right">${message.dateBet}</td>
			</tr>
		`);
	};

	// socket.onerror = function(event) {
	// 	status.innerHTML = "ошибка " + event.message;
	// };

	formName = $('form').attr('name');

	if (formName == 'messages') {
		document.forms['messages'].onsubmit = function() {
			let message = {
			   userId: this.user_id.value,
			   userLogin: this.user_login.value,
			   userEmail: this.user_email.value,
			   dateBet: this.date_bet.value,
			   bet: this.bet.value,
			}

			// console.log(message);

			let lastBet = $('#lastBet').text();
			
			if (Number(this.bet.value) > Number($.trim(lastBet)) && Number(this.bet.value) != Number($.trim(lastBet))) {		
				socket.send(JSON.stringify(message));
			}

			return false;
		}
	}
}