<?php 


Flight::route('POST /students/register', function(){
    $data= Flight::request()->data->getData();
    Flight::json(Flight::studentService()->register($data));
});

Flight::route('GET /students/confirm/@token', function($token){
    Flight::studentService()->confirm($token);
    Flight::json(["message" => "Token is valid"]);
});


?>