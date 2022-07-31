<?php 

require_once dirname(__FILE__)."/BaseDao.class.php";

class TutorDao extends BaseDao {

    public function __construct(){
        parent::__construct("tutors");
    }

    public function get_tutor_by_email($email) {
        return $this-> query_unique("SELECT * FROM tutors WHERE email = :email", ["email" => $email]);

    }

    public function update_tutor_by_email($email, $tutor){
        $this->update("tutors", $email, $tutor, "email");
    }
}

?>