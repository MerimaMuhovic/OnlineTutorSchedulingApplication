<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require dirname(__FILE__).'/../vendor/autoload.php';
require dirname(__FILE__).'/dao/StudentDao.class.php';
require dirname(__FILE__).'/dao/CourseDao.class.php';
require dirname(__FILE__).'/services/CourseService.class.php';
require dirname(__FILE__).'/services/StudentService.class.php';

Flight::map('error', function(Exception $ex){
  Flight::json(["message" => $ex->getMessage()], $ex->getCode() ? $ex->getCode() : 500);
});

/* utility function for reading query parameters from URL */
Flight::map('query', function($name, $default_value = NULL){
    $request = Flight::request();
    $query_param = @$request->query->getData()[$courseName];
    $query_param = $query_param ? $query_param : $default_value;
    return $query_param;
  });

  Flight::route('GET /swagger', function(){
    $openapi = @\OpenApi\scan(dirname(__FILE__)."/routes");
    header('Content-Type: application/json');
    echo $openapi->toJson();
  });
  
  Flight::route('GET /', function(){
    Flight::redirect('/docs');
  });

/* Register Business Logic layer services */
Flight::register('courseService', 'CourseService');
Flight::register('studentService', 'StudentService');

/* Include all routes */
require_once dirname(__FILE__)."/routes/students.php";
require_once dirname(__FILE__)."/routes/middleware.php";
require_once dirname(__FILE__)."/routes/courses.php"; 

Flight::start();
?>