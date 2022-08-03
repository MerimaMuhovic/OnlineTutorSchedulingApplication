<?php 

/**
 * @OA\Info(title="Online Tutor API", version="0.1")
*  @OA\OpenApi(
*  @OA\Server(url="http://localhost/onlinetutor/api/",description="Development Enviroment"),
*    @OA\Server(url="https://lionfish-app-o8vkz.ondigitalocean.app/api/", description="Production Environment" )
 * )
 
 */

 /**
 * @OA\Post(path="/students/register", tags={"students"},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="My Test Account",	description="Name of the account" ),
 *     				 @OA\Property(property="surname", required="true", type="string", example="First Last Name",	description="Name of the user`" ),
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *                   @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */
Flight::route('POST /students/register', function(){
    $data= Flight::request()->data->getData();
    Flight::studentService()->register($data);
    Flight::json(["message"=> "You are registrated"]);

});

 /**
 * @OA\Post(path="/students/login", tags={"students"},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *                   @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */

Flight::route('POST /students/login', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::studentService()->login($data));
});

/**
 * @OA\Get(path="/confirm/confirm/{token}", tags={"students"},
 *     @OA\Parameter(type="string", in="path", name="token", default=123, description="Temporary token for activating account"),
 *     @OA\Response(response="200", description="Message upon successfull activation.")
 * )
 */
Flight::route('GET /students/confirm/@token', function($token){
    Flight::studentService()->confirm($token);
    Flight::json(["message" => "Token is valid"]);
});

/**
 * @OA\Get( path="/students/{id}", tags={"students"},  security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"),in="path", allowReserved=true,name="id",example="1"),
 *     @OA\Response(response="200", description="Get students by id"),
 * )
 */
Flight::route('GET /students/@id', function($id){
    Flight::json(Flight::studentService()->get_by_id($id));
});

?>