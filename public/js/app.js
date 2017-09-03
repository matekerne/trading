// $(document).ready(function() {

  if ($('.auction-card').length < 4) {
    $('.auction-card').parent().parent().addClass('center');
  }

  $("body").on("focus", ".ajax-form input", function() {
    if ($(this).hasClass('error')) {
      //$(this).removeClass('error');
      $(this).removeClass('error').val('');
    }
    $('.ajax-form input[name="password"]').on('click', function() {
      $(this).attr('type', 'password');
    });
  });

  function createUser(method, action, data) {

    var login = $('[name="login"]').val();
    var password = $('[name="password"]').val();
    var name = $('[name="name"]').val();
    var email = $('[name="email"]').val();

    $('.ajax-form input')
      .val('')
      .removeAttr('checked')
      .removeAttr('selected');

    $.ajax({
      url: action,
      type: method,
      data: data,
      contentType: false,
      cache: false,
      processData: false,

      success: function(data) {
        var response = $.parseJSON(data);
        console.log(response);
        $(".js-example-basic-multiple").val("").val(null).trigger("change");
        $(".ajax-form input").removeClass("error");
        $('.user-list .table tbody').load('users .user-item');
      },

      error: function(e) {
        var response = $.parseJSON(e.responseText);
        console.log(response);
        $(".ajax-form input").addClass("error");

        var loginPassword = /^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/i;

        if (login == '') {
          $(".ajax-form [name='login']").val('Введите логин');
        } else if (!loginPassword.test(login)) {
          $(".ajax-form [name='login']").val('Введенный логин не корректный');
        } else {
          $(".ajax-form [name='login']").removeClass('error').val(login);
        }

        if (password == '') {
          $(".ajax-form [name='password']")
              .attr('type', 'text')
              .val('Введите пароль');
        }

        if (name == '') {
          $(".ajax-form [name='name']").val('Введите имя');
        } else {
          $(".ajax-form [name='name']").removeClass('error').val(name);
        }

        var re = /^[\w-\.]+@[\w-]+\.[a-z]{2,3}$/i;

        if (email == '') {
          $(".ajax-form [name='email']").val('Введите email');
        } else if (!re.test(email)) {
          $(".ajax-form [name='email']").val('Введенный email некорректный');
        } else {
          $(".ajax-form [name='email']").removeClass('error').val(email);
        }

      }
    });
  }

  // function redirect(url='') {
  //     var protocol = window.location.protocol + '//';
  //     var host = window.location.host;
  //     var defaultUrl = '/';

  //     if (url) {
  //       window.location.replace(protocol + host + url);
  //     } else {
  //       window.location.replace(protocol + host + defaultUrl);
  //     }
  // }

  function createWinner(user_id, lot_id) {
    var action = '/winner/create';
    var method = 'POST';

    $.ajax({
      url: action,
      type: method,
      data: {
        user_id: user_id,
        lot_id: lot_id
      },

      success: function(data) {
        var response = $.parseJSON(data);
        console.log(response);
      },

      error: function(e) {
        var error = $.parseJSON(e.responseText);
        console.log(error);
      }
    });
  }

  function changeLotStatus(lot_id) {
    var action = '/lot/change-status';
    var method = 'POST';

    $.ajax({
      url: action,
      type: method,
      data: {
        lot_id: lot_id
      },

      success: function(data) {
        var response = $.parseJSON(data);
        console.log(response);
      },

      error: function(e) {
        var error = $.parseJSON(e.responseText);
        console.log(error);
      }
    });
  }

  function notifyWinner() {
    var action = '/winner/notify';
    var method = 'POST';

    var email = $('#history-bets .bet:first-child').data('user-email');

    $.ajax({
      url: action,
      type: method,
      data: {
        email: email,
      },

      success: function(data) {
        var response = $.parseJSON(data);
        console.log(response);
      },

      error: function(e) {
        var error = $.parseJSON(e.responseText);
        console.log(error);
      },
    });
  }

  // Общий для всех остальных форм
  $(document).on('submit', '.ajax-form', function(e) {
    e.preventDefault();

    var form = $(this);
    var method = form.attr('method');
    var action = form.attr('action');
    var data = new FormData(form[0]);

    if (action == '/user/create') {
        createUser(method, action, data);
    } else {
      $('.ajax-form input')
        .val('')
        .removeAttr('checked')
        .removeAttr('selected');
      $(".js-example-basic-multiple").val("").val(null).trigger("change");

      $.ajax({
        url: action,
        type: method,
        data: data,
        cache: false,
        contentType: false,
        processData: false,

        success: function(data) {
          var response = $.parseJSON(data);
          console.log(response);

          if (action == '/user/update') {
            form.attr('action', '/user/create');
            $(".ajax-form .create_user").text('Создать');
            $('.user-list .table tbody').load('users .user-item');
          }

          if (action == '/lot/create') {
            $('.lot-list').load('lots .table', function () {
              loadTable();
            });
          }

          if (action == '/lot/update') {
            form.attr('action', '/lot/create');
            $(".ajax-form .lot_update").text('Создать');
            $('.lot-list').load('lots .table', function () {
              loadTable();
            });
          }

          if (action == '/group/create') {
            $('.grid-expand').load('groups .table');
          }

          if (action == '/group/update') {
            form.attr('action', '/group/create');
            $(".ajax-form .create_group").text('Создать');
            $('.grid-expand').load('groups .table');
          }

        },

        error: function(e) {
          var response = $.parseJSON(e.responseText);
          console.log(response);
        },
      });
    }
  })

  // Отдельный ajax для обработка ставки
  $(document).on('submit', '.bet', function(e) {
    e.preventDefault();

    var form = $(this);
    var method = form.attr('method');
    var action = form.attr('action');

    var bet = $('.bet input[name=bet]').val();
    var last_bet = $.trim($('#lastBet').text());
    var lot_id = $('.bet input[name=lot_id]').val();

    $.ajax({
      url: action,
      type: method,
      data: {
        lot_id: lot_id,
        bet: bet,
        last_bet: last_bet,
      },
      
      success: function(data) {
        var response = $.parseJSON(data);
        console.log(response);
      },

      error: function(e) {
        var error = $.parseJSON(e.responseText);
        $('.error-bet').text(error.message).show();
      },

    });
  })

  // // Отдельный ajax для авторизации
  // $(document).on('submit', '.auth', function(e) {
  // // $('.button-login').on('click', function(e) {
  //   e.preventDefault();
  //   // if (e.preventDefault) {
  //   //   e.preventDefault();
  //   // } else {
  //   //   event.returnValue = false;
  //   // }
  //   // console.log(1);

  //   var form = $(this);
  //   var action = form.attr('action');
  //   var method = form.attr('method');
  //   var data = new FormData(form[0]);

  //   $.ajax({
  //     url: action,
  //     type: method,
  //     data: data,
  //     processData: false,
  //     cache: false,
  //     contentType: false,

  //     success: function(data) {
  //       var response = $.parseJSON(data);
  //       var errorMessage = $('.error').text();

  //       redirect();
  //     },

  //     error: function(e) {
  //       var error = $.parseJSON(e.responseText);
  //       $('.error').text(error.message).show();
  //     }

  //   });
  // });

  // Work with datatime
  $.datetimepicker.setLocale('ru');
  $('.datetimepicker').datetimepicker({
   i18n:{
    ru:{
     months:[
      'Январь','Февраль','Март','Апрель',
      'Май','Июнь','Июль','Август',
      'Сентябрь','Октябрь','Ноябрь','Декабрь'
     ],
     dayOfWeek:[
      'Понедельник','Вторник','Среда','Четверг',
      'Пятница','Суббота','Воскресенье'
     ],
    }
   },
   timepicker: true,
   format: 'd-m-Y H:i'
  });

  var mounthStart = $('#mounthStartAuction').text();
  var dayStart = $('#dayStartAuction').text();
  var yearStart = $('#yearStartAuction').text();
  var timeStart = $('#timeStartAuction').text();

  var mounth = $('#mounthStopAuction').text();
  var day = $('#dayStopAuction').text();
  var year = $('#yearStopAuction').text();
  var time = $('#timeStopAuction').text();
  var dateTime = mounth + ' ' + day + ' ' + year + ' ' + time;
  var dateTimeStart = mounthStart + ' ' + dayStart + ' ' + yearStart + ' ' + timeStart;
  var countDownDate = new Date(dateTime).getTime();
  var countDownDateStart = new Date(dateTimeStart).getTime();

  var x = setInterval(function() {
    var now = new Date();
    var distance = countDownDateStart - now.getTime();
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    if (document.getElementById('timer') !== null) {  
      document.getElementById('timer').innerHTML = days + ' <span> д. </span> ' + hours + ' <span> ч. </span> '
      + minutes + ' <span> м. </span> ' + seconds + ' <span> с. </span> ';
    }

    if (distance < 0) {
      var method = 'POST';
      var action = '/lot/check-time-stop';
      var lot_id = $('.bet input[name=lot_id]').val();

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
            document.getElementById('timer').innerHTML = 'Аукцион закончен';

            var winUser = $('#history-bets .bet:first-child').data('user-login');
            var lot_status = $('.bet input[name=lot_status]').val();
            var user_id = $('#history-bets .bet:first-child').data('user-id');
            var lot_id = $('.bet input[name=lot_id]').val();

            if (winUser && lot_status == 1) {
              // document.getElementById('winner').innerHTML = '<div id="winner">Лот выиграл ' + winUser + '</div>';
              $('.auction-card__full').append('<div id="winner">Лот выиграл ' + winUser + '</div>');
              createWinner(user_id, lot_id);
              changeLotStatus(lot_id);
              notifyWinner();
            } else if (!winUser && lot_status == 1) {
              document.getElementById('winner').innerHTML = 'Победителей нет!';
              changeLotStatus(lot_id);
            } else if (winUser && lot_status == 3) {
              document.getElementById('winner').innerHTML = 'Лот выиграл ' + winUser;
            } else if (!winUser && lot_status == 3) {
              document.getElementById('winner').innerHTML = 'Победителей нет!';
            }
          }
        },

        error: function(e) {

        },
      });
    }
  }, 1000);

// });