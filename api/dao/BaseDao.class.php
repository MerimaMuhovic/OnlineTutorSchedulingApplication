<?php 

require_once dirname(__FILE__)."/../config.php";

class BaseDao {

    protected $connection;

    private $table;
    
    public function __construct($table){
        $this->table = $table;
        try {
          $this->connection = new PDO("mysql:host=".Config::DB_HOST().";port=".Config::DB_PORT().";dbname=".Config::DB_SCHEME(), Config::DB_USERNAME(), Config::DB_PASSWORD());
          $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //$this->connection->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
        } catch(PDOException $e) {
          throw $e;
        }
      }
    
    protected function insert($table, $entity){
         
        $query = "INSERT INTO ${table} (";
        foreach ($entity as $column => $value) {
            $query .= $column.", ";
        }
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        foreach ($entity as $column => $value) {
            $query .= ":".$column.", ";
        }
        $query = substr($query, 0,-2);
        $query .=")";
        
        $stmt = $this-> connection-> prepare($query);
        $stmt->execute($entity);
        $entity["id"] = $this -> connection -> lastInsertId();
        return $entity;
    }

    protected function execute_update($table , $id, $entity, $id_column = "id"){
        $query = "UPDATE ${table} SET ";
        foreach($entity as $name => $value) {
            $query .= $name ."= :". $name. ", "; 
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE ${id_column} = :id";
       
        $stmt = $this-> connection-> prepare($query);
        $entity["id"] = $id;
        $stmt->execute($entity);
    }

    protected function query($query , $params) {
        $stmt = $this-> connection -> prepare($query);
        $stmt->execute($params); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params){
        $results = $this->query($query, $params);
        return reset($results);
    }

    public function add($entity){
      return $this->insert($this->table, $entity);
      }

    public function update($id, $entity) {
        $this->execute_update($this->table, $id, $entity);
    }

    public function get_by_id($id) {
        return $this->query_unique("SELECT * FROM ".$this->table. " WHERE id = :id", ["id" => $id]);
    }

    public function delete($id){
        $stmt = $this->connection->prepare("DELETE FROM ".$this->table." WHERE id=:id");
        $stmt->bindParam(':id', $id); // SQL injection prevention
        $stmt->execute();
      }

    public function get_all($offset = 0, $limit = 20) {
        return $this-> query("SELECT * FROM ". $this->table." LIMIT ${limit} OFFSET ${offset} " , []);
    }
}

?>
