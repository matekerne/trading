<!DOCTYPE html>
<html lang="ru">
  <head>
    <noscript>Для полной функциональности этого сайта необходимо включить JavaScript.</noscript>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auction</title>
    
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Condensed:100,400,500,600&amp;subset=cyrillic" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/public/plugins/select2/dist/css/select2.min.css">
    <link type="text/css" rel="stylesheet" href="/public/css/app.css.php">
    <link type="text/css" rel="stylesheet" href="/public/plugins/datetimepicker/jquery.datetimepicker.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <?php if (isset($_SESSION['user'])): ?>
    <header class="header">
      <div class="header-logo">
        <a href="/"><img src="/public/image/logo/logo_inpk_trading.svg"></a>
      </div>
      <div class="header-nav">
        <?php if ($_SESSION['role'] == 'admin'): ?>
          <a href="/users">Пользователи</a>
          <a href="/lots">Лоты</a>
          <a href="/groups">Группы</a>
        <?php endif; ?>
      </div>
      <div class="header-user">
        <div class="user-name"><?php print $_SESSION['user_login']; ?></div>
      </div>
      <div class="header-logout">
        <a href="/logout"><img src="/public/image/icon/site/exit.svg"></a>
      </div>
    </header>
  <?php endif; ?>
  
  
    
  
     
