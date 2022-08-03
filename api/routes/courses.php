<?php 

/**
 * @OA\Info(title="Online Tutor API", version="0.1")
*  @OA\OpenApi(
*  @OA\Server(url="http://localhost/onlinetutor/api/",description="Development Enviroment")
 * ),
  * @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authentication" )
 
 */

/**
* @OA\Get(path="/courses", tags={"courses"},
*     @OA\Parameter(type="integer",in="query",name="offset",default=0, description ="Offset for pagination"),
*     @OA\Parameter(type="integer",in="query",name="limit",default=25, description ="Limit for pagination"),
*     @OA\Parameter(type="string",in="query",name="search", description ="Search for pagination"),
*     @OA\Response(response="200", description="List all courses")
 * )
 */
Flight::route('GET /courses', function(){

    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $search = Flight::request()->query['search'];


    Flight::json(Flight::courseService()->get_courses($search, $offset , $limit));
});

/**
 * @OA\Get( path="/courses/{id}", tags={"courses"},  security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"),in="path", allowReserved=true,name="id",example="1"),
 *     @OA\Response(response="200", description="Get courses by id"),
 * )
 */
Flight::route('GET /courses/@id', function($id){
    Flight::json(Flight::courseService()->get_by_id($id));
});

/**
* @OA\Post( path="/courses", tags={"courses"},
* @OA\RequestBody(description="Course info",required=true,
*       @OA\MediaType(mediaType="application/json",
*    	     @OA\Schema(
*     			 @OA\Property(property="courseName",required = "true", type="string",example="Test",description=""),
*    		     @OA\Property(property="description",type="string",example="For Testing Purpose",description=""),
*    		     @OA\Property(property="tutorID",type="string",example="1",description=""),
*    				)
*                  )
*    				),
*     @OA\Response(response="200", description="Add courses"),
* )
*/
Flight::route('POST /courses', function(){
    $data= Flight::request()->data->getData();
    Flight::json(Flight::courseService()->add($data));
});

/**
 * @OA\Put( path="/courses/{id}", tags={"courses"},
 *     @OA\Parameter(@OA\Schema(type="integer"),in="path",name="id",default="1", description="Id of account"),
 * @OA\RequestBody(description="Info is going to be updated ",required=true,
*       @OA\MediaType(mediaType="application/json",
*    	     @OA\Schema(
*     			 @OA\Property(property="courseName",required = "true", type="string",example="Test",description=""),
*    		     @OA\Property(property="description",type="string",example="For Testing Purpose",description=""),
*    		     @OA\Property(property="tutorID",type="string",example="1",description=""),
*    				)
*                  )
*    				),
 *     @OA\Response(response="200", description="Fetch Account"),
 * )
 */
Flight::route('PUT /courses/@id', function($id) {
    $data= Flight::request()->data->getData();
    Flight::json(Flight::courseService()->update($id, $data));
});

/**
* @OA\Delete(
*     path="/courses/{id}", security={{"ApiKeyAuth": {}}},
*     description="Soft delete courses",
*     tags={"courses"},
*     @OA\Parameter(in="path", name="id", example=1, description="Note ID"),
*     @OA\Response(
*         response=200,
*         description="Note deleted"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/

Flight::route('DELETE /courses/@id', function($id){
    Flight::courseService()->delete($id);
    Flight::json(["message" => "deleted"]);
  });

?>