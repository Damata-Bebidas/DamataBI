<?php
/**
 * Description of apiconfig
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class apiconfig implements crudBasic {
    //put your code here
    private  $db, $id, $api,$dataConfig;
    
    //acesso ao banco
    function __construct(\PDO $db) {
        $this->db = $db;
    }

    //modificadores
    public function find($id){
        $query = "SELECT * FROM `apiconfig` WHERE `id` = :id ;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function consult(){
        $query = "SELECT * FROM `apiconfig` WHERE `id` = (SELECT MAX(`id`) FROM `apiconfig`);";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function inserir() {
        $query = "INSERT INTO `apiconfig`(`api`, `data`) VALUES (:api , now());";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':api',$this->getApi());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `apiconfig` SET `api`=:api WHERE `id`=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':api',$this->getApi());
        $stmt->bindValue(':id',$this->getId());
        $stmt->execute();
        if($stmt->execute()){
            return true;
        }
    }
    public function deletar($id) {
        $query = "DELETE FROM `apiconfig` WHERE `id`=:id;";
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

    public function getApi() {
        return $this->api;
    }

    public function getDataConfig() {
        return $this->dataConfig;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setApi($api) {
        $this->api = $api;
        return $this;
    }

    public function setDataConfig($dataConfig) {
        $this->dataConfig = $dataConfig;
        return $this;
    }
}
