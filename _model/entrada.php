<?php
/**
 * Description of entrada
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class entrada implements crudBasic {
    private  $db, $matricula, $hora;
    
    //acesso ao banco
    function __construct(\PDO $db) {
        $this->db = $db;
    }

    //metodos modificadores
    public function find($id){
        $query = "SELECT * FROM `entrada` WHERE `matricula`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function consult(){
        $query = "SELECT * FROM `entrada`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function inserir() {
        $query = "INSERT INTO `entrada`(`matricula`, `hora`) VALUES (:matricula,:hora);";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':hora',$this->getHora());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `entrada` SET `hora`=:hora WHERE `matricula`=:matricula;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':hora',$this->getHora());
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->execute();
    }
    public function deletar($id) {
        $query = "DELETE FROM `entrada` WHERE `matricula`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    // Get and set    
    public function getMatricula() {
        return $this->matricula;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
        return $this;
    }

    public function setHora($hora) {
        $this->hora = $hora;
        return $this;
    }
}
