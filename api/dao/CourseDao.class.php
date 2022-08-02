<?php 

require_once dirname(__FILE__)."/BaseDao.class.php";

class CourseDao extends BaseDao {

    public function __construct(){
        parent::__construct("courses");
    }
    
    public function get_courses($search, $offset, $limit){        
        return $this->query("SELECT *
                             FROM courses
                             WHERE LOWER(courseName) LIKE CONCAT('%', :courseName, '%')
                             LIMIT ${limit} OFFSET ${offset}",
                             ["courseName" => strtolower($search)]);
      }

    //   public function delete_courses($id) {
    //     return $this->query("DELETE * FROM ".$this->table. " WHERE id = :id", ["id" => $id]);
    //   }
}

?>