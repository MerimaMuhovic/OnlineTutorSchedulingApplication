<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



require dirname(__FILE__).'/../vendor/autoload.php';
require dirname(__FILE__).'/dao/StudentDao.class.php';
require dirname(__FILE__).'/dao/CourseDao.class.php';
require dirname(__FILE__).'/services/CourseService.class.php';
require dirname(__FILE__).'/services/StudentService.class.php';
require dirname(__FILE__).'/services/TutorService.class.php';
use \Firebase\JWT\JWT;


/* utility function for reading query parameters from URL */
Flight::map('query', function($name, $default_value = NULL){
    $request = Flight::request();
    $query_param = @$request->query->getData()[$courseName];
    $query_param = $query_param ? $query_param : $default_value;
    return $query_param;
  });

  // middleware method for login
/*Flight::route('/*', function(){
  //return TRUE;
  //perform JWT decode
  $path = Flight::request()->url;
  if ($path == '/students/login' || $path == '/docs.json' || $path == '/students/register') return TRUE; // exclude login route from middleware

  $headers = getallheaders();
  if (@!$headers['Authorization']){
    Flight::json(["message" => "Authorization is missing"], 403);
    return FALSE;
  }else{
    try {
      $decoded = (array)JWT::decode($headers['Authorization'], new Key(Config::JWT_SECRET(), 'HS256'));
      Flight::set('course', $decoded);
      return TRUE;
    } catch (\Exception $e) {
      Flight::json(["message" => "Authorization token is not valid"], 403);
      return FALSE;
    }
  }
}); */ 

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
Flight::register('tutorService', 'TutorService');

/* Include all routes */
require_once dirname(__FILE__)."/routes/middleware.php";
require_once dirname(__FILE__)."/routes/students.php";
require_once dirname(__FILE__)."/routes/tutors.php";
require_once dirname(__FILE__)."/routes/courses.php"; 

Flight::start();
?>