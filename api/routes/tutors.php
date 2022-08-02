<?php 

/**
 * @OA\Info(title="Online Tutor API", version="0.1")
*  @OA\OpenApi(
*  @OA\Server(url="http://localhost/onlinetutor/api/",description="Development Enviroment")
 * ),
  * @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authentication" )
 
 */

/**
* @OA\Get(path="/tutors", tags={"tutors"},
*     @OA\Parameter(type="integer",in="query",name="offset",default=0, description ="Offset for pagination"),
*     @OA\Parameter(type="integer",in="query",name="limit",default=25, description ="Limit for pagination"),
*     @OA\Parameter(type="string",in="query",name="search", description ="Search for pagination"),
*     @OA\Response(response="200", description="List all courses")
 * )
 */
Flight::route('GET /tutors', function(){

    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $search = Flight::request()->query['search'];

    Flight::json(Flight::tutorService()->get_tutors($search, $offset , $limit));
});

?>