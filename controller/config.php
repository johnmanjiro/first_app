<?php

//ブラウザにエラー表示してくれる
ini_set('display_errors', 1);

require_once(__DIR__ . '/../twitteroauth/autoload.php');

define('CONSUMER_KEY', 'euPlVSBmuXOm0Qb9rItNMOxWl');
define('CONSUMER_SECRET', 'mXjuHeHNWJqNaWxwj3sRJgq7DOjuKT1epmO4qjtVFEORD6fmaX');
define('CALLBACK_URL', 'http://dot-install-johnmanjiro.c9.io/devAid-v1.2/controller/login.php');

define('DSN', 'mysql:host=localhost;dbname=dotinstall_tw_connect_php');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'cloud9');

session_start();

require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/autoload.php');
require_once(__DIR__ . '/Twitterlogin.php');
require_once(__DIR__ . '/Register.php');