<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('/courses/*', function(){
    $token = Flight::header('Authentication');
    
    try {
        $user = (array)\Firebase\JWT\JWT::decode(strval($token), new Key(Config::JWT_SECRET(), 'HS256'));
        Flight::set("user", $user);

        return TRUE; 
    } catch (\Exception $e) {
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }
 });


?>