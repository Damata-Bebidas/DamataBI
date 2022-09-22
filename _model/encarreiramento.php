<?php
/**
 * Description of encarraramento
 * extinção do Cargo
 * @author welingtonmarquezini
 */
require_once 'crudBasic.php';
class encarreiramento implements crudBasic{
    private  $db, $id, $matricula , $data, $cargo; 
   
    function __construct(\PDO $db) {
        $this->db = $db;
    }

    //metodos modificadores
    public function find($id){
        $query = "SELECT * FROM `encarreiramento` WHERE `matricula`=:id ORDER BY `data` DESC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function findDate($id,$data){
        $query = "SELECT * FROM `encarreiramento` WHERE `matricula`=:id AND `data`=:data_p ORDER BY `data` DESC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":data_p", $data);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findFilter($inicio,$fim) {
        $query = "SELECT `encarreiramento`.`matricula`, `cadastro`.`nome`, `data`, `encarreiramento`.`cargo`
            FROM `encarreiramento` INNER JOIN `cadastro` ON `encarreiramento`.`matricula` = `cadastro`.`matricula` 
            WHERE `data` >= :inicio AND `data` <= :fim ORDER BY `data` ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":inicio", $inicio);
        $stmt->bindValue(":fim", $fim);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consult(){
        $query = "SELECT * FROM `encarreiramento`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function inserir() {
        $query = "INSERT INTO `encarreiramento`(`matricula`, `data`, `cargo`) VALUES (:matricula,:data_p,:cargo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':data_p',$this->getData());
        $stmt->bindValue(':cargo',$this->getCargo());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `encarreiramento` SET `matricula`=:matricula,`data`=:data_p,`cargo`=:cargo WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':data_p',$this->getData());
        $stmt->bindValue(':cargo',$this->getCargo());
        $stmt->bindValue(':id',$this->getId());
        $stmt->execute();
    }
    public function deletar($id) {
        $query = "DELETE FROM `encarreiramento` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    public function getCargos() {
        $query = "SELECT DISTINCT `cargo` FROM `cadastro` WHERE `status`='Ativo' AND `cargo`<>'0' ORDER BY `cargo` ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    // Get and set
    function getId() {
        return $this->id;
    }

    function getMatricula() {
        return $this->matricula;
    }

    function getData() {
        return $this->data;
    }

    function getCargo() {
        return $this->cargo;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
        return $this;
    }
}
