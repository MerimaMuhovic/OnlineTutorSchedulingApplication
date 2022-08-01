<?php 

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/StudentDao.class.php';

use \Firebase\JWT\JWT;


class StudentService extends BaseService {

    public function __construct(){
        $this->studentDao = new StudentDao();
    }

    public function register($student){
        
        $student = $this->studentDao->add([
            "name" => $student["name"],
            "surname" => $student["surname"],
            "email" => $student["email"],
            "password" => md5($student["password"]),
            "token" => md5(random_bytes(16))
        ]);
    }
    public function login($student){
        $db_sudent = $this->studentDao->get_student_by_email($student['email']);
    
        if (!isset($db_sudent['id'])) throw new Exception("Student doesn't exists", 400);
            
        if ($db_sudent['password'] != md5($student['password'])) throw new Exception("Invalid password", 400);

        $jwt = JWT::encode(["id" => $db_sudent["id"], 
                            "email" => $db_sudent["email"], 
                            "name" => $db_sudent["name"]],
                            "JWT SECRET", "HS256" );

        return ["token" => $jwt];

    }
    public function confirm($token){
        $student = $this->studentDao->get_student_by_token($token);

        if (!isset($student["id"])) throw Exception("Invalid Token");
        // Ako je validan ...
    }
}
?>