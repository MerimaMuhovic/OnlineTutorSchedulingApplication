<?php 

require_once dirname(__FILE__)."/BaseDao.class.php";

class TutorDao extends BaseDao {

    public function __construct(){
        parent::__construct("tutors");
    }
    
    public function get_tutors($search, $offset, $limit){        
        return $this->query("SELECT *
                             FROM tutors
                             WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
                             LIMIT ${limit} OFFSET ${offset}",
                             ["name" => strtolower($search)]);
      }

    //   public function delete_courses($id) {
    //     return $this->query("DELETE * FROM ".$this->table. " WHERE id = :id", ["id" => $id]);
    //   }
}

?>