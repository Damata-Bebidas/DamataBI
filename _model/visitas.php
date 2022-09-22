<?php
include_once 'crudBasic.php';
class Visitas implements crudBasic {
    //atributos
    private $db,$CPF,$nome,$area,$video,$data,$placa,$equipamento;
    //metodo construtor
    public function __construct(\PDO $db) {
        $this->db = $db;
    }
    //metodos modificadores
    public function inserir() {
        $query = "INSERT INTO `visitas` (`CPF`, `Nome`, `area`, `video`, `data`,`placa`, `equipamentos`) 
                    VALUES (:cpf,:nome,:area,:video,now(),:placa,:equip)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf',$this->getCPF());
        $stmt->bindValue(':nome',$this->getNome());
        $stmt->bindValue(':area',$this->getArea());
        $stmt->bindValue(':video',$this->getVideo());
        $stmt->bindValue(':placa',$this->getPlaca());
        $stmt->bindValue(':equip',$this->getEquipamento());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `visitas` SET `Nome`=:nome,`area`=:area,`video`=:video,`data`=now(),
                `placa`=:placa,`equipamentos`=:equip WHERE `CPF`=:cpf;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome',$this->getNome());
        $stmt->bindValue(':area',$this->getArea());
        $stmt->bindValue(':video',$this->getVideo());
        $stmt->bindValue(':placa',$this->getPlaca());
        $stmt->bindValue(':equip',$this->getEquipamento());
        $stmt->bindValue(':cpf',$this->getCPF());
        $stmt->execute();
    }
    public function deletar($CPF) {
        $query = "delete from `visitas` where `CPF`=:cpf";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf', $CPF);
        $stmt->execute();
    }
    public function consultarVisitas($CPF){
        $query = "select * from `visitas` where `CPF`=:cpf ORDER BY `data` DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":cpf", $CPF);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function contarVisita($CPF){
        $query = "select count(*) from `visitas` where `CPF`=:cpf";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":cpf", $CPF);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function listaVisitas(){
        $query = "select * from `visitas`";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function find($id){
        $query = "SELECT * FROM `visitas` WHERE `CPF`=:cpf;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":cpf", $id);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function consult(){
        $query = "SELECT * FROM `visitas` WHERE;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    //metodos acessores
    function getCPF() {
        return $this->CPF;
    }

    function getNome() {
        return $this->nome;
    }

    function getArea() {
        return $this->area;
    }

    function getVideo() {
        return $this->video;
    }

    function getData() {
        return $this->data;
    }

    function getPlaca() {
        return $this->placa;
    }

    function getEquipamento() {
        return $this->equipamento;
    }

    function setCPF($CPF) {
        $this->CPF = $CPF;
        return $this;
    }

    function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    function setArea($area) {
        $this->area = $area;
        return $this;
    }

    function setVideo($video) {
        $this->video = $video;
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    function setPlaca($placa) {
        $this->placa = $placa;
    }

    function setEquipamento($equipamento) {
        $this->equipamento = $equipamento;
    }
}