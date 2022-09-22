<?php

/**
 * Description of penalidades
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class penalidades implements crudBasic {
    private  $db, $id, $colaborador, $data, $motivo, $tipo, $aplicador;
   
    function __construct(\PDO $db) {
        $this->db = $db;
    }

    //metodos modificadores
    public function find($id){
        $query = "SELECT * FROM `penalidades` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function findDate($id,$data){
        $query = "SELECT * FROM `penalidades` WHERE `colaborador`=:id AND `data`=:data_p;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":data_p", $data);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function findNome($nome){
        $query = "SELECT `matricula` FROM `cadastro` WHERE `nome`= :id ;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $nome);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findMat($id){
        $query = "SELECT `nome` FROM `cadastro` WHERE `matricula`= :id ;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findFilter($inicio,$fim) {
        $query = "SELECT `id`, `colaborador` ,`nome` , `data`, `motivo`, `penalidades`.`tipo`, `aplicador` FROM `penalidades` 
            INNER JOIN `cadastro` ON `penalidades`.`colaborador` = `cadastro`.`matricula` 
            WHERE `data` >= :inicio AND `data` <= :fim ORDER BY `data` ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":inicio", $inicio);
        $stmt->bindValue(":fim", $fim);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findFilterNome($inicio,$fim,$nome) {
        $query = "SELECT `id`, `colaborador` ,`nome` , `data`, `motivo`, `penalidades`.`tipo`, `aplicador` FROM `penalidades` 
            INNER JOIN `cadastro` ON `penalidades`.`colaborador` = `cadastro`.`matricula` 
            WHERE `data` >= :inicio AND `data` <= :fim AND `nome` = :nome ORDER BY `data` ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":inicio", $inicio);
        $stmt->bindValue(":fim", $fim);
        $stmt->bindValue(":nome", $nome);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consult(){
        $query = "SELECT * FROM `penalidades`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function gestores(){
        $query = "SELECT `matricula`, `nome` FROM `cadastro` WHERE `tipo` = 'GESTOR' OR `tipo` = 'GENTE' OR `tipo` = 'LOG' ORDER BY `nome` ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function inserir() {
        $query = "INSERT INTO `penalidades`(`colaborador`, `data`, `motivo`, `tipo`, `aplicador`) VALUES (:colaborador, :data_p, :motivo , :tipo, :aplicador);";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':colaborador',$this->getColaborador());
        $stmt->bindValue(':data_p',$this->getData());
        $stmt->bindValue(':motivo',$this->getMotivo());
        $stmt->bindValue(':tipo',$this->getTipo());
        $stmt->bindValue(':aplicador',$this->getAplicador());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `penalidades` SET `colaborador`=:colaborador,`data`=:data_p,`motivo`=:motivo,`tipo`=:tipo,`aplicador`=:aplicador WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':colaborador',$this->getColaborador());
        $stmt->bindValue(':data_p',$this->getData());
        $stmt->bindValue(':motivo',$this->getMotivo());
        $stmt->bindValue(':tipo',$this->getTipo());
        $stmt->bindValue(':aplicador',$this->getAplicador());
        $stmt->bindValue(':id',$this->getId());
        $stmt->execute();
    }
    public function deletar($id) {
        $query = "DELETE FROM `penalidades` WHERE `id`=:id;";
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

    public function getColaborador() {
        return $this->colaborador;
    }

    public function getData() {
        return $this->data;
    }

    public function getMotivo() {
        return $this->motivo;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getAplicador() {
        return $this->aplicador;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setColaborador($colaborador) {
        $this->colaborador = $colaborador;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function setMotivo($motivo) {
        $this->motivo = $motivo;
        return $this;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    public function setAplicador($aplicador) {
        $this->aplicador = $aplicador;
        return $this;
    }
}
