<?php 

/**
 * @OA\Info(title="My First API", version="0.1")
 */

/**
 * @OA\Get( path="/courses",
 *     @OA\Response(response="200", description="An example resource")
 * )
 */
Flight::route('GET /courses', function(){

    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 5);
    $search = Flight::query('search');

    Flight::json(Flight::courseService()->get_courses($search, $offset , $limit));
});

/**
 * @OA\Get(path="/courses/{id}",
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Id of account"),
 *     @OA\Response(response="200", description="Fetch individual account")
 * )
 */
Flight::route('GET /courses/@id', function($id){
    Flight::json(Flight::courseService()->get_by_id($id));
});

Flight::route('POST /courses', function(){
    $data= Flight::request()->data->getData();
    Flight::json(Flight::courseService()->add($data));
});

Flight::route('PUT /courses/@id', function($id) {
    $data= Flight::request()->data->getData();
    Flight::json(Flight::courseService()->update($id, $data));
});


?>