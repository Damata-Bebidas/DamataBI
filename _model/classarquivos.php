<?php
include_once 'crudBasic.php';
class Arquivos implements crudBasic{
    //atributos
    private $db,$matricula,$arquivo,$data,$tipo;
    //metodo construtor
    public function __construct(\PDO $db) {
        $this->db = $db;
    }
    //metodos modificadores
    public function inserir() {
        $query = "INSERT INTO `arquivos` (`matricula`,`arquivo`, `data_envio`,`tipo`) 
                    VALUES (:matricula,:arquivo,now(), :tipo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':arquivo',$this->getArquivo());
        $stmt->bindValue(':tipo',$this->getTipo());
        $stmt->execute();
    }
    public function Alterar() {
        $query = "UPDATE `arquivos` SET `arquivo`=:arquivo,`data_envio`=now() WHERE `matricula`=:matricula";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':arquivo',$this->getArquivo());
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->execute();
    }
    public function deletar($matricula) {
        $query = "delete from `arquivos` where `matricula`=:matricula";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':matricula', $matricula);
        $stmt->execute();
    }
    public function consultarArquivos($matricula){
        $query = "select * from `arquivos` where matricula=:matricula";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":matricula", $matricula);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function contarArquivos($matricula){
        $query = "select count(*) from `arquivos` where matricula=:matricula";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":matricula", $matricula);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consult(){
        $query = "select * from `arquivos`";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id){
        $query = "select `matricula`, `arquivo`, `data_envio`, `tipo` from `arquivos` where matricula=:matricula";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":matricula", $id);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    //metodos acessores
    function getMatricula() {
        return $this->matricula;
    }

    function getArquivo() {
        return $this->arquivo;
    }

    function getData() {
        return $this->data;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
        return $this;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }
}