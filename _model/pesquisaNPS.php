<?php
/**
 * Description of pesquisaNFS
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class pesquisaNPS implements crudBasic {
  
    private $db, $ID, $NB, $MatFunc, $Data, $Nota, $Motivo, $Comentario;
    
    //construtor
    function __construct(\PDO $db) {
        $this->db = $db;
    }
    
    public function consult() {
        $query = "SELECT * FROM `pesquisaNPS`;";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function find($id) {
        $query = "SELECT * FROM `pesquisaNPS` WHERE `NB`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function findNB($id) {
        $query = "SELECT `NB`,`Nome`, `End`, `Bairro`, `Cidade` FROM `saneamento` WHERE `NB`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function inserir() {
        $query = "INSERT INTO `pesquisaNPS`(`NB`, `MatFunc`, `Data`, `Nota`, `Motivo`, `Comentario`) "
                . "VALUES (:NB, :MatFunc, :Data, :Nota, :Motivo,:Comentario);";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':NB',$this->getNB());
        $stmt->bindValue(':MatFunc',$this->getMatFunc());
        $stmt->bindValue(':Data',$this->getData());
        $stmt->bindValue(':Nota',$this->getNota());
        $stmt->bindValue(':Motivo',$this->getMotivo());
        $stmt->bindValue(':Comentario',$this->getComentario());
        $stmt->execute();
    }
    
    public function alterar() {
        $query = "UPDATE `pesquisaNPS` SET `NB`=:NB,`MatFunc`=:MatFunc,`Data`=:Data,"
                . "`Nota`=:Nota,`Motivo`=:Motivo ,`Comentario`=:Comentario WHERE `ID`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':NB',$this->getNB());
        $stmt->bindValue(':MatFunc',$this->getMatFunc());
        $stmt->bindValue(':Data',$this->getData());
        $stmt->bindValue(':Nota',$this->getNota());
        $stmt->bindValue(':Motivo',$this->getMotivo());
        $stmt->bindValue(':Comentario',$this->getComentario());
        $stmt->bindValue(':id',$this->getId());
        if($stmt->execute()){return true;}
    }

    public function deletar($id) {
        $query = "DELETE FROM `pesquisaNPS` WHERE `ID`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        if($stmt->execute()){return true;}
    }
    
    //get and set
    function getID() {
        return $this->ID;
    }

    function getNB() {
        return $this->NB;
    }

    function getMatFunc() {
        return $this->MatFunc;
    }

    function getData() {
        return $this->Data;
    }

    function getNota() {
        return $this->Nota;
    }

    function getMotivo() {
        return $this->Motivo;
    }

    function getComentario() {
        return $this->Comentario;
    }

    function setID($ID) {
        $this->ID = $ID;
        return $this;
    }

    function setNB($NB) {
        $this->NB = $NB;
        return $this;
    }

    function setMatFunc($MatFunc) {
        $this->MatFunc = $MatFunc;
        return $this;
    }

    function setData($Data) {
        $this->Data = $Data;
        return $this;
    }

    function setNota($Nota) {
        $this->Nota = $Nota;
        return $this;
    }

    function setMotivo($Motivo) {
        $this->Motivo = $Motivo;
        return $this;
    }

    function setComentario($Comentario) {
        $this->Comentario = $Comentario;
        return $this;
    }

}
