<?php

// Config
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Connect files
define('ROOT', dirname(__FILE__));
//define('ROOT', '/home/i/inpkhost/inpk-trading.ru_trade/public_html');
require_once(ROOT . '/components/Router.php');

// Start router
$router = new Router();
$router->run();