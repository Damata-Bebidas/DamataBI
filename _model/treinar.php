<?php
/**
 * Description of treinar
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class treinar implements crudBasic {
    //put your code here
    private $db,$id_tr_freq,$id_treinar,$matricula,$id_tr,$conclusao,$previsao;
    //construtor
    function __construct(\PDO $db) {
        $this->db = $db;
    }
    //metodos de consulta
    public function find($id){
        $query = "select * from `treinar` where `Id_tr_freq`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function consult(){
        $query = "select * from `treinar`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function inserir() {
        $query = "INSERT INTO `treinar`(`Id_tr_freq`,`id_treinar`, `matricula`, `id_tr`, `data`,`previsao`) "
                . "VALUES (:id_treinar_key, :id_treinar, :matricula, :id_tr, :data, :previsao);";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_treinar_key', $this->getId_tr_freq());
        $stmt->bindValue(':id_treinar', $this->getId_treinar());
        $stmt->bindValue(':id_tr',$this->getId_tr());
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':data',$this->getConclusao());
        $stmt->bindValue(':previsao',$this->getPrevisao());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `treinar` SET `id_treinar`=:id_treinar,`matricula`=:matricula,"
                . "`id_tr`=:id_tr,`data`=:data, `previsao`=:previsao  WHERE `Id_tr_freq`=:id_treinar_key";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_treinar', $this->getId_treinar());
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':id_tr',$this->getId_tr());
        $stmt->bindValue(':data',$this->getConclusao());
        $stmt->bindValue(':previsao',$this->getPrevisao());
        $stmt->bindValue(':id_treinar_key', $this->getId_tr_freq());
        $stmt->execute();
        if($stmt->execute()){
            return true;
        }
    }
    public function deletar($id) {
        $query = "delete from `treinar` where `Id_tr_freq`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    // get and set
    function getId_treinar() {
        return $this->id_treinar;
    }

    function getMatricula() {
        return $this->matricula;
    }

    function getId_tr() {
        return $this->id_tr;
    }

    function getConclusao() {
        return $this->conclusao;
    }

    function setId_treinar($id_treinar) {
        $this->id_treinar = $id_treinar;
        return $this;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
        return $this;
    }

    function setId_tr($id_tr) {
        $this->id_tr = $id_tr;
        return $this;
    }

    function setConclusao($conclusao) {
        $this->conclusao = $conclusao;
        return $this;
    }
    
    function getId_tr_freq() {
        return $this->id_tr_freq;
    }

    function getPrevisao() {
        return $this->previsao;
    }

    function setId_tr_freq($id_tr_freq) {
        $this->id_tr_freq = $id_tr_freq;
        return $this;
    }

    function setPrevisao($previsao) {
        $this->previsao = $previsao;
        return $this;
    }
  }
