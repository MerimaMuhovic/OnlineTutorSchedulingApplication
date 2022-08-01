<?php 

Flight::route('/students/*', function(){
    try {
      $student = (array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
      if (Flight::request()->method != "GET" && $student["r"] == "STUDENT_READ_ONLY"){
        throw new Exception("Read only student can't change anything.", 403);
      }
      Flight::set('student', $student);
      return TRUE;
    } catch (\Exception $e) {
      Flight::json(["message" => $e->getMessage()], 401);
      die;
    }
  });

?>