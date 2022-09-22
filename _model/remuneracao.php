<?php
/**
 * Description of Remuneracao
 *
 * @author WillianMarquezini
 */
require_once '../_model/crudBasic.php';
class Remuneracao implements crudBasic {
    private $db, $id, $data, $setor, $tipo, $matricula_colaborador, $status,
            $dias_trabalhados, $atributo, $valor, $gratificacao;
  //construtor
  function __construct(\PDO $db) {
      $this->db = $db;
  }
  //queries
    public function consult() {
        $query = "SELECT * FROM `remuneracao`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  
    }

    public function find($id) {
      $query = "SELECT * FROM `remuneracao` WHERE `matricula_colaborador`= :id;";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":id",$id);
      $stmt->execute();         
      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function findData($id, $data, $tipo) {
      $query = "SELECT * FROM `remuneracao` WHERE `matricula_colaborador`= :id AND `data`=:data_rem AND `tipo`= :tipo ;";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":id",$id);
      $stmt->bindValue(':data_rem', $data);
      $stmt->bindValue(':tipo', $tipo);
      $stmt->execute();         
      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function inserir() {
     $query = "INSERT INTO `remuneracao`(`data`,`setor`,`tipo`, `matricula_colaborador`,`status`, `dias_trabalhados`,`atributo`, `valor`, `gratificacao`)
        VALUES(:data_rem, :setor, :tipo, :matricula_colaborador, :status_rem, :dias_trabalhados, :atributo, :valor, :gratificacao);";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':data_rem', $this->getData());
        $stmt->bindValue(':setor', $this->getsetor());
        $stmt->bindValue(':tipo', $this->getTipo());
        $stmt->bindValue(':matricula_colaborador', $this->getMatricula_colaborador());
        $stmt->bindValue(':status_rem', $this->getstatus());
        $stmt->bindValue(':dias_trabalhados', $this->getdias_trabalhados());
        $stmt->bindValue(':atributo', $this->getatributo());
        $stmt->bindValue(':valor', $this->getvalor());
        $stmt->bindValue(':gratificacao', $this->getgratificacao());
        $stmt->execute();
    }

    public function alterar() {
        $query = "UPDATE `remuneracao` SET `setor` = :setor, `tipo` = :tipo, `status` = :status_rem, 
            `dias_trabalhados` = :dias_trabalhados, `atributo` = :atributo, `valor` = :valor, `gratificacao` = :gratificacao 
        WHERE `matricula_colaborador` = :matricula_colaborador AND `data` = :data_rem;" ;
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':data_rem', $this->getData());
        $stmt->bindValue(':setor', $this->getsetor());
        $stmt->bindValue(':tipo', $this->getTipo());
        $stmt->bindValue(':matricula_colaborador', $this->getMatricula_colaborador());
        $stmt->bindValue(':status_rem', $this->getstatus());
        $stmt->bindValue(':dias_trabalhados', $this->getdias_trabalhados());
        $stmt->bindValue(':atributo', $this->getatributo());
        $stmt->bindValue(':valor', $this->getvalor());
        $stmt->bindValue(':gratificacao', $this->getgratificacao());
        if($stmt->execute()){
            return true;
        }     
    }

    public function deletar($id) {
        $query = "DELETE FROM `remuneracao` WHERE 'id'=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindColumn(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    //gets and sets
    public function getId() {
        return $this->id;
    }

    public function getData() {
        return $this->data;
    }

    public function getSetor() {
        return $this->setor;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getMatricula_colaborador() {
        return $this->matricula_colaborador;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDias_trabalhados() {
        return $this->dias_trabalhados;
    }

    public function getAtributo() {
        return $this->atributo;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getGratificacao() {
        return $this->gratificacao;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function setSetor($setor) {
        $this->setor = $setor;
        return $this;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    public function setMatricula_colaborador($matricula_colaborador) {
        $this->matricula_colaborador = $matricula_colaborador;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setDias_trabalhados($dias_trabalhados) {
        $this->dias_trabalhados = $dias_trabalhados;
        return $this;
    }

    public function setAtributo($atributo) {
        $this->atributo = $atributo;
        return $this;
    }

    public function setValor($valor) {
        $this->valor = $valor;
        return $this;
    }

    public function setGratificacao($gratificacao) {
        $this->gratificacao = $gratificacao;
        return $this;
    }
}