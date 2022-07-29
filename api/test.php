<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/StudentDao.class.php";

$student_dao = new StudentDao();

// $student = $student_dao-> get_student_by_email("merima.muhovic@hotmail.com");

$student1 = [
    
    "password" => "444",
    "name" => "Ademir",
    "surname" => "Ahmetovic",
    "email" => "hellohello1234@gmail.com"
];


$students = $student_dao->add_student($student1);

print_r($students);
?>