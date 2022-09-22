<?php
/**
 * Description of area
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class area implements crudBasic {
    //put your code here
    private  $db, $id_area, $nome, $matricula;
    
    //acesso ao banco
    function __construct(\PDO $db) {
        $this->db = $db;
    }

    //metodos modificadores
    public function find($id){
        $query = "SELECT * FROM `area` WHERE `id_area`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function consult(){
        $query = "SELECT * FROM `area`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function inserir() {
        $query = "INSERT INTO `area`(`nome`, `matricula`) VALUES (:nome,:idresp)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome',$this->getNome());
        $stmt->bindValue(':idresp',$this->getMatricula());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `area` SET `nome`=:nome,`matricula`=:idresp WHERE `id_area`=:idarea";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome',$this->getNome());
        $stmt->bindValue(':idresp',$this->getMatricula());
        $stmt->bindValue(':idarea',$this->getId_area());
        $stmt->execute();
        if($stmt->execute()){
            return true;
        }
    }
    public function deletar($id) {
        $query = "DELETE FROM `area` WHERE `id_area`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    // Get and set    
    function getId_area() {
        return $this->id_area;
    }

    function getNome() {
        return $this->nome;
    }

    function getMatricula() {
        return $this->matricula;
    }

    function setId_area($id_area) {
        $this->id_area = $id_area;
        return $this;
    }

    function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
        return $this;
    }
}
