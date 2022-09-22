<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of prova3e6meses
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class prova3e6meses implements crudBasic {
    //put your code here
    private $db,$id, $matricula, $aplicacao, $tipo,$cargo;
    private $qt = array();
    //conexao
    function __construct(\PDO $db) {
        $this->db = $db;
    }
    //metodos modificadores
    public function find($id){
        $query = "SELECT * FROM `prova` WHERE `matricula`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function findCargo($id,$cargo){
        $query = "SELECT * FROM `prova` WHERE `matricula`=:id AND `cargo`=:cargo;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":cargo", $cargo);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findMatricula($nome){
        $query = "SELECT `matricula` FROM `cadastro` WHERE nome=:nome";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", $nome);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function consult(){
        $query = "SELECT * FROM `prova`";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function inserir() {
        $query = "INSERT INTO `prova`(`matricula`, `aplicacao`, `tipo`, `cargo` ,"
                . "`qt1`, `qt2`, `qt3`, `qt4`, `qt5`, `qt6`, `qt7`, `qt8`, `qt9`, `qt10`, `qt11`, `qt12`, `qt13`, `qt14`, `qt15`, "
                . "`qt16`, `qt17`, `qt18`, `qt19`, `qt20`, `qt21`, `qt22`, `qt23`) "
                . "VALUES (:matricula,:aplicacao,:tipo,:cargo,:qt1,:qt2,:qt3,:qt4,:qt5,:qt6,:qt7,:qt8,:qt9,:qt10,:qt11,:qt12,:qt13,"
                . ":qt14,:qt15,:qt16,:qt17,:qt18,:qt19,:qt20,:qt21,:qt22,:qt23)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':aplicacao',$this->getAplicacao());
        $stmt->bindValue(':tipo',$this->getTipo());
        $stmt->bindValue(':cargo',$this->getCargo());
        for ($i=0; $i < 23 ; $i++) { 
            $stmt->bindValue(':qt' . ($i + 1)   ,$this->getQt($i));
        }
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `prova` SET `aplicacao`=:aplicacao,`qt1`=:qt1,
        `qt2`=:qt2,`qt3`=:qt3,`qt4`=:qt4,`qt5`=:qt5,`qt6`=:qt6,`qt7`=:qt7,`qt8`=:qt8,
        `qt9`=:qt9,`qt10`=:qt10,`qt11`=:qt11,`qt12`=:qt12,`qt13`=:qt13,`qt14`=:qt14,
        `qt15`=:qt15,`qt16`=:qt16,`qt17`=:qt17,`qt18`=:qt18,`qt19`=:qt19,`qt20`=:qt20,
        `qt21`=:qt21,`qt22`=:qt22,`qt23`=:qt23 WHERE `id`=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':aplicacao',$this->getAplicacao());
        for ($i=0; $i < 23 ; $i++) { 
            $stmt->bindValue(':qt' . ($i + 1) ,$this->getQt($i));
        }
        $stmt->bindValue(':id', $this->getId());
        $stmt->execute();
        if($stmt->execute()){
            return true;
        }
    }
    public function deletar($id) {
        $query = "DELETE FROM `prova` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    //GET and Set
    function getId() {
        return $this->id;
    }

    function getMatricula() {
        return $this->matricula;
    }

    function getAplicacao() {
        return $this->aplicacao;
    }

    function getTipo() {
        return $this->tipo;
    }
    
    function getCargo() {
        return $this->cargo;
    }
    
    function getQt($pos) {
        return $this->qt[$pos];
    }

    function setId($id) {
        $this->id = $id;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    function setAplicacao($aplicacao) {
        $this->aplicacao = $aplicacao;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
        return $this;
    }
    
    function setQt($qt,$pos) {
        $this->qt[$pos] = $qt;
    }  
}