<?php
/**
 * Description of token
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class token implements crudBasic {
    //put your code here
    private $db, $id, $token, $dataToken;
    
    //acesso ao banco
    function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function find($id){
        $query = "SELECT * FROM `tokenSicoob` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function consult(){
        $query = "SELECT * FROM `tokenSicoob` WHERE `id`=(SELECT MAX(`id`) FROM `tokenSicoob`);";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function inserir() {
        $query = "INSERT INTO `tokenSicoob`(`token`, `data`) VALUES (:token, now());";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':token',$this->getToken());
        $stmt->execute();
    }
    public function alterar() {
        $query = "INSERT INTO `tokenSicoob`(`token`, `data`) VALUES (:token) WHERE `id`=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':token',$this->getToken());
        $stmt->bindValue(':id',$this->getId());
        $stmt->execute();
        if($stmt->execute()){
            return true;
        }
    }
    public function deletar($id) {
        $query = "DELETE FROM `tokenSicoob` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    // Get and set    
    public function getId() {
        return $this->id;
    }

    public function getToken() {
        return $this->token;
    }

    public function getDataToken() {
        return $this->dataToken;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    public function setDataToken($dataToken) {
        $this->dataToken = $dataToken;
        return $this;
    }
}
