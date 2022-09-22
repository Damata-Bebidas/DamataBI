<?php
/**
 * Description of plano
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class plano implements crudBasic {
    
    private $db, $id_tr, $previsao, $tipo,$lista,$custo;
    
    //construtor
    function __construct(\PDO $db) {
        $this->db = $db;
    }
    //metodos acessores
    public function find($id){
        $query = "select * from `plano` where id_tr=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function findTreinar($id){
        $query = "select * from `treinar` where `Id_tr_freq`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function consult(){
        $query = "select * from `plano`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function listar() {
        $query = "select * from `plano`;";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function findDate($id) {
        $query = "SELECT `previsao` FROM `plano` WHERE id_tr=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function inserir() {
        $query = "INSERT INTO `plano`(`id_tr`, `previsao`) VALUES (:id_tr,:previsao);";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_tr',$this->getId_tr());
        $stmt->bindValue(':previsao',$this->getPrevisao());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `plano` SET `previsao`=:previsao,`custo`=:custo,`tipo`=:tipo WHERE `id_tr`=:id_tr";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':previsao',$this->getPrevisao());
        $stmt->bindValue(':custo',$this->getCusto());
        $stmt->bindValue(':tipo',$this->getTipo());
        $stmt->bindValue(':id_tr',$this->getId_tr());
        $stmt->execute();
        if($stmt->execute()){
            return true;
        }
    }
    public function alterarPlan() {
        $query = "UPDATE `plano` SET `previsao`=:previsao  WHERE `id_tr`=:id_tr";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':previsao',$this->getPrevisao());
        $stmt->bindValue(':id_tr',$this->getId_tr());
        $stmt->execute();
        if($stmt->execute()){
            return true;
        }
    }
    public function deletar($id) {
        $query = "delete from `plano` where id_tr=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    public function findFrequencia($id){
        $query = "SELECT `frequencia` FROM `treinamento` WHERE `id_tr`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function nomeTreinamento($id){
        $query = "SELECT `Treinamento`, `cargos`, `frequencia`, `carga`, `responsavel` FROM `treinamento` WHERE `id_tr`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    //get and set
    function getId_tr() {
        return $this->id_tr;
    }

    function getPrevisao() {
        return $this->previsao;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getLista() {
        return $this->lista;
    }

    function getCusto() {
        return $this->custo;
    }

    function setId_tr($id_tr) {
        $this->id_tr = $id_tr;
        return $this;
    }

    function setPrevisao($previsao) {
        $this->previsao = $previsao;
        return $this;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    function setLista($lista) {
        $this->lista = $lista;
        return $this;
    }

    function setCusto($custo) {
        $this->custo = $custo;
        return $this;
    }
}