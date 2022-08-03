<?php 

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/TutorDao.class.php';

class TutorService extends BaseService {

    public function __construct(){
        $this->dao = new TutorDao();
    }

    public function get_tutors($search, $offset , $limit) {
        if ($search){   
            return $this->dao->get_tutors($search, $offset, $limit);
        }else{
            return $this->dao->get_all($offset, $limit);
        }
    }
}

?>