<?php 

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/StudentDao.class.php';

class StudentService extends BaseService {

    public function __construct(){
        $this->studentDao = new StudentDao();
    }

    public function register($student){
        
        $student = $this->studentDao->add([
            "name" => $student["name"],
            "surname" => $student["surname"],
            "email" => $student["email"],
            "password" => $student["password"],
            "token" => md5(random_bytes(16))
        ]);

    }

    public function confirm($token){
        $student = $this->studentDao->get_student_by_token($token);

        if (!isset($student["id"])) throw Exception("Invalid Token");
        // Ako je validan ...

    }
}
?>