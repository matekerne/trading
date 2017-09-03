function redirect(url='') {
  var protocol = window.location.protocol + '//';
  var host = window.location.host;
  var defaultUrl = '/';

  if (url) {
    window.location.replace(protocol + host + url);
  } else {
    window.location.replace(protocol + host + defaultUrl);
  }
}

$(document).on('submit', '.auth', function(e) {
  e.preventDefault();
  // if (e.preventDefault) {
  //   e.preventDefault();
  // } else {
  //   event.returnValue = false;
  // }
  // console.log(1);

  var form = $(this);
  var action = form.attr('action');
  var method = form.attr('method');
  var data = new FormData(form[0]);

  $.ajax({
    url: action,
    type: method,
    data: data,
    processData: false,
    cache: false,
    contentType: false,

    success: function(data) {
      var response = $.parseJSON(data);
      var errorMessage = $('.error').text();

      redirect();
    },

    error: function(e) {
      var error = $.parseJSON(e.responseText);
      $('.error').text(error.message).show();
    }

  });
});