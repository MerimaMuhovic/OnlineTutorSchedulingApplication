<?php 

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/CourseDao.class.php';

class CourseService extends BaseService {

    public function __construct(){
        $this->dao = new CourseDao();
    }

    public function get_courses($search, $offset , $limit) {
        if ($search){   
            return $this->dao->get_courses($search, $offset, $limit);
        }else{
            return $this->dao->get_all($offset, $limit);
        }
    }

    public function add($course) {
        if(!isset($course["courseName"])) throw new Exception("Course Name is missing");
        return parent::add($course);
    }


    public function delete($user, $id){
    $note = $this->dao->get_by_id($id);
    if ($note['id'] != $user['id']){
      throw new Exception("This is hack you will be traced, be prepared :)");
    }
    parent::update($user, $id, ['status' => 'ARCHIVED']);
  }
}

?>