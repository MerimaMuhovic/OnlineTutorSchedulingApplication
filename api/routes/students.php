<?php 


Flight::route('POST /students/register', function(){
    $data= Flight::request()->data->getData();
    Flight::studentService()->register($data);
    Flight::json(["message"=> "You are registrated"]);

});

Flight::route('POST /students/login', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::studentService()->login($data));
});

Flight::route('GET /students/confirm/@token', function($token){
    Flight::studentService()->confirm($token);
    Flight::json(["message" => "Token is valid"]);
});


Flight::route('GET /students/@id', function($id){

    
    $student = Flight::studentService()->get_by_id($id);
    Flight::json($stdent);
});


?>