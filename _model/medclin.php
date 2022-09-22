<?php
/**
 * Description
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class medclin implements crudBasic {
    //put your code here
    private $db,$id,$dataAtend,$matricula,$prontuario,$tipo,$cid,
            $tempo, $unidtempo,$inicio,$fim,$obs;

//construtor    
function __construct(\PDO $db) {
    $this->db = $db;
}
//metodos modificadores
public function find($id){
    $query = "SELECT * FROM `medclin` WHERE `Id`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
public function consult(){
    $query = "SELECT `Data Atend`, `cadastro`.`matricula`,`cadastro`.`nome`, `cadastro`.`cargo`, "
            . "`Prontuario`, `medclin`.`Tipo`, `cid`.`DESCRABREV`, `Tempo`, `UnidTempo`, `Inicio`, `Fim`, `obs` "
            . "FROM ((`medclin` INNER JOIN `cid` ON `medclin`.`CID` = `cid`.`CAT` ) "
            . "INNER JOIN `cadastro` ON `medclin`.`Matricula` = `cadastro`.`matricula`) ORDER BY `medclin`.`Data Atend` ASC;";
    $stmt = $this->db->prepare($query);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function listar() {
    $query = "SELECT * FROM `medclin`;";
    $stmt = $this->db->query($query);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function listarCid() {
    $query = "SELECT * FROM `cid` ORDER BY `CAT` ASC";
    $stmt = $this->db->query($query);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function inserir() {
    $query = "INSERT INTO `medclin`(`Id`, `Data Atend`, `Matricula`, `Prontuario`,"
            . " `Tipo`, `CID`, `Tempo`, `UnidTempo`, `Inicio`, `Fim`, `obs`) "
            . "VALUES (:id,:data,:matricula,:prontuario,:tipo,:cid,:tempo,"
            . ":unidtempo,:inicio,:fim,:obs);";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id',$this->getId());
    $stmt->bindValue(':data',$this->getDataAtend());
    $stmt->bindValue(':matricula',$this->getMatricula());
    $stmt->bindValue(':prontuario',$this->getProntuario());
    $stmt->bindValue(':tipo',$this->getTipo());
    $stmt->bindValue(':cid',$this->getCid());
    $stmt->bindValue(':tempo',$this->getTempo());
    $stmt->bindValue(':unidtempo',$this->getUnidtempo());
    $stmt->bindValue(':inicio',$this->getInicio());
    $stmt->bindValue(':fim',$this->getFim());
    $stmt->bindValue(':obs',$this->getObs());
    $stmt->execute();
}
public function alterar() {
    $query = "UPDATE `medclin` SET `Prontuario`=:prontuario,`Tipo`=:tipo,`CID`=:cid,"
            . "`Tempo`=:tempo,`UnidTempo`=:unidtempo,`Inicio`=:inicio,`Fim`=:fim,"
            . "`obs`=:obs WHERE `Id`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':prontuario',$this->getProntuario());
    $stmt->bindValue(':tipo',$this->getTipo());
    $stmt->bindValue(':cid',$this->getCid());
    $stmt->bindValue(':tempo',$this->getTempo());
    $stmt->bindValue(':unidtempo',$this->getUnidtempo());
    $stmt->bindValue(':inicio',$this->getInicio());
    $stmt->bindValue(':fim',$this->getFim());
    $stmt->bindValue(':obs',$this->getObs());
    $stmt->bindValue(':id',$this->getId());
    $stmt->execute();
    if($stmt->execute()){
        return true;
    }
}

public function deletar($id) {
    $query = "DELETE FROM `medclin` WHERE=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id', $id);
    if($stmt->execute()){
        return true;
    }
}

// get and settes
    function getId() {
        return $this->id;
    }

    function getDataAtend() {
        return $this->dataAtend;
    }

    function getMatricula() {
        return $this->matricula;
    }

    function getProntuario() {
        return $this->prontuario;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getCid() {
        return $this->cid;
    }

    function getTempo() {
        return $this->tempo;
    }

    function getUnidtempo() {
        return $this->unidtempo;
    }

    function getInicio() {
        return $this->inicio;
    }

    function getFim() {
        return $this->fim;
    }

    function getObs() {
        return $this->obs;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setDataAtend($dataAtend) {
        $this->dataAtend = $dataAtend;
        return $this;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
        return $this;
    }

    function setProntuario($prontuario) {
        $this->prontuario = $prontuario;
        return $this;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    function setCid($cid) {
        $this->cid = $cid;
        return $this;
    }

    function setTempo($tempo) {
        $this->tempo = $tempo;
        return $this;
    }

    function setUnidtempo($unidtempo) {
        $this->unidtempo = $unidtempo;
        return $this;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
        return $this;
    }

    function setFim($fim) {
        $this->fim = $fim;
        return $this;
    }

    function setObs($obs) {
        $this->obs = $obs;
        return $this;
    }    
}