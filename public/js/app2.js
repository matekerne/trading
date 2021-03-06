function addCharacteristics() {
   var button = $('.add_characteristics');
  
   if ($('[name="characteristics[]"]').length <= 9) {
   button.before('<input type="text" name="characteristics[]" placeholder="Характеристики">');}
}

function loadTable() {
	// hide all content
	$('.table-collapse-item').hide();

	$('.table-collapse').click(function(){
		$(this).parent().parent().toggleClass('active').siblings().removeClass('active');
		$('.table-collapse-item').slideUp();

		if(!$(this).parent().next().is(":visible")) {
			$(this).parent().next().slideDown();
		}
	});
}

function openMenu() {
	$('.user-name').on('click', function() {
		$('.header-nav__mobile').toggleClass('menu-active');
	});
}

var mobileMq = window.matchMedia('(max-width: 640px)');

var userAgent = window.navigator.userAgent;




$(document).ready(function() {

	
		
	loadTable();

	if (mobileMq.matches || userAgent.match(/iPad/i) || userAgent.match(/iPhone/i)) {
		
		openMenu();
	}





	var betLast = parseInt($("#lastBet").text());
	var startPrice = parseInt($('#startPrice').text());


	$("#betLastSum").prepend(accounting.formatNumber(betLast, {
		thousand : " "
	}));
	$('#startPriceSum').prepend(accounting.formatNumber(startPrice, {
		thousand : " "
	}));

	// Стартовая цена
	$(".bet-sum").val(betLast);
	betStart = $(".bet-sum").val();


	$(".betCount").text(accounting.formatNumber(betLast, {
		thousand : " "
	}));

	// Карточка лота на главной
	var startCardPrice = $('#startLotPrice').text();
	$('#startLotCost').text(accounting.formatNumber(startCardPrice, {
		thousand: " "
	}));

	var currentCardPrice = $('#currentCost').text();
	$('#currentLotCost').text(accounting.formatNumber(currentCardPrice, {
		thousand: " "
	}));
	// Карточка лота на главной

	$("body").on("click", ".add_characteristics", function() {
		addCharacteristics();
	});


	$("body").on("click", ".auction-card__full-bet-value-change .add", function() {
	    var betSum = $(this).parent().find('input');
	    var betStep = betSum.attr("step");
	    var betCount = parseInt(betSum.val()) + parseInt(betStep);
	    var betPrev = betCount - parseInt(betStep);
	    
	    $('.betCount').text(accounting.formatNumber(betCount, {
			thousand : " "
		}));
	    
	    betSum.val(betCount);
	    
	    betSum.change();
	    
	    var formBet = betSum.val();
	    $("form.bet input[name='bet']").val(formBet);
	    $("form.bet input[name='previous_bet']").val(betPrev);
	    $(".error-bet").text("");
	 	return false;
	});

	$("body").on("click", ".auction-card__full-bet-value-change .remove", function() {
	    var betSum = $(this).parent().find('input');
	    var betStart = parseInt($("#lastBet").text());
	    var betStep = betSum.attr("step");
	    
	    var betCount = parseInt(betSum.val()) - parseInt(betStep);
	    betCount = betCount > betStart ? betCount : betStart;
	    var betPrev = betCount - parseInt(betStep);
	    betSum.val(betCount);

	    $('.betCount').text(accounting.formatNumber(betCount, {
			thousand : " "
		}));
	    
	    betSum.change();
	    var formBet = betSum.val();
	    $("form.bet input[name='bet']").val(formBet);
	    $("form.bet input[name='previous_bet']").val(betPrev);
	 	return false;
	});

	$("body").on("click", ".edit_user", function(e) {
		e.preventDefault();
		var id = $(this).parent().parent().attr("id");

		$(".ajax-form").attr("action", "/user/update");

		$.ajax({
	      url: '/user/edit/' + id,
	      type: 'POST',
	      data: {
	      	user_id: id
	      },

			  success: function(data) {
				var response = $.parseJSON(data);
				console.log(response);
				var groups = response['groups'];
				var groupId = groups.split(', ');
				
				$(".ajax-form [name='user_id']").val(response['id']);
				$(".ajax-form [name='login']").val(response['login']);
				$(".js-example-basic-multiple").select2().val(groupId).trigger('change'); //.val(response['groups']).trigger("change");
				$(".ajax-form [name='name']").val(response['name']);
				$(".ajax-form [name='email']").val(response['email']);
				$(".ajax-form .create_user").text('Обновить');
			  },

			  error: function(e) {
				var response = $.parseJSON(e.responseText);
				console.log(response);
			  },
		});
	});


	$("body").on("click", ".delete_user", function(e) {
		e.preventDefault();
		var id = $(this).parent().parent().attr("id");

		$.ajax({
			url: '/user/delete',
			type: 'POST',
			data: {
				user_id: id
			},

			success: function(data) {
				var response = $.parseJSON(data);
				console.log(response);
				$('.user-list .table tbody').load('users .user-item');
			},

			error: function(e) {
				var response = $.parseJSON(e.responseText);
				console.log(response);
			},
		});
	});



	$("body").on("click", ".edit_lot", function(e) {
		e.preventDefault();
		var id = $(this).parent().parent().attr("id");

		$(".ajax-form").attr("action", "/lot/update");

		$.ajax({
			url: '/lot/edit/' + id,
			type: 'POST',
			data: {
				lot_id: id
			},

			success: function(data) {
				var response = $.parseJSON(data);
				console.log(response);
				var groups = response['groups'];
				var groupId = groups.split(', ');
				console.log(groupId);

				$(".ajax-form [name='lot_id']").val(id);
				$(".ajax-form [name='name']").val(response['name']);
				var characteristics = response['characteristics'].split(', ');

				var char = '';
				for (key in characteristics) {
					char += '<input type="text" name="characteristics[]" placeholder="Характеристики" value="' + characteristics[key] + '">';
				}
				$("[name='characteristics[]']").remove();
				$('.characteristics_list label').append(char);
				$('[name="price"]').val(response['price']);
				$('[name="price_type"]').val(response['price_type']);
				$(".js-example-basic-multiple").select2().val(groupId).trigger('change');
				$('[name="step_bet"]').val(response['step_bet']);
				$('[name="count"]').val(response['count']);
				$('[name="count_type"]').val(response['count_type']);
				$('[name="conditions_payment"]').val(response['conditions_payment']);
				$('[name="conditions_shipment"]').val(response['conditions_shipment']);
				$('[name="terms_shipment"]').val(response['terms_shipment']);
				$('[name="start"]').val(response['start']);
				$('[name="stop"]').val(response['stop']);
				$('[name="status"]').val(response['status']);


				$(".ajax-form .lot_update").text('Обновить');
			},

			error: function(e) {
				var response = $.parseJSON(e.responseText);
				console.log(response);
			},
		});
	});


	$("body").on("click", ".delete_lot", function(e) {
		e.preventDefault();
		var id = $(this).parent().parent().attr("id");

		$.ajax({
			url: '/lot/delete',
			type: 'POST',
			data: {
				lot_id: id
			},

			success: function(data) {
				var response = $.parseJSON(data);
				console.log(response);
				$('.lot-list').load('lots .table', function() {
					loadTable();
				});

			},

			error: function(e) {
				var response = $.parseJSON(e.responseText);
				console.log(response);
			},
		});
	});




	$("body").on("click", ".edit_group", function(e) {
		e.preventDefault();
		var id = $(this).parent().parent().attr("id");

		$(".ajax-form").attr("action", "/group/update");

		$.ajax({
			url: '/group/edit/' + id,
			type: 'POST',
			data: {
				id: id
			},

			success: function(data) {
				var response = $.parseJSON(data);
				console.log(response);
				$(".ajax-form [name='id']").val(response['id']);
				$(".ajax-form [name='name']").val(response['name']);
				$(".ajax-form .create_group").text('Обновить');
			},

			error: function(e) {
				var response = $.parseJSON(e.responseText);
				console.log(response);
			},
		});
	});

	$("body").on("click", ".delete_group", function(e) {
		e.preventDefault();
		var id = $(this).parent().parent().attr("id");

		$.ajax({
			url: '/group/delete',
			type: 'POST',
			data: {
				id: id
			},

			success: function(data) {
				var response = $.parseJSON(data);
				console.log(response);
				$('.grid-expand').load('groups .table');
			},

			error: function(e) {
				var response = $.parseJSON(e.responseText);
				console.log(response);
			},
		});
	});

});