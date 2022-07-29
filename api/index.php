<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require dirname(__FILE__).'/../vendor/autoload.php';

Flight::route('/', function(){
    echo 'hello !';
});

Flight::route('/hello2', function(){
    echo 'hello !';
});

Flight::start();
?>