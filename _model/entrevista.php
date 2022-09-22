<?php
/**
 * Description of colaborador
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class entrevista implements crudBasic {
    //put your code here
    private $db,$id,$matricula, $data, $tipo,$motivo,$semjust,$comprevia,
            $justicomp,$acao,$acatada,$alinhada,$diadescontado,$inicio,$fim,$obs;

//construtor    
function __construct(\PDO $db) {
    $this->db = $db;
}
//metodos modificadores
public function find($id){
    $query = "SELECT * FROM `entrevista` WHERE `id`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
public function consult(){
    $query = "SELECT `data`,`cadastro`.`setor`,`cadastro`.`nome`, `cadastro`.`cargo` , "
            . "`entrevista`.`tipo`, `motivo`, `semjust`, `comprevia`, `justicomp`, "
            . "`acao`, `acatada`, `alinhada`, `diadescontado`, `inicio`, `fim`, `obs` "
            . "FROM `entrevista` INNER JOIN `cadastro` ON `entrevista`.`id`=`cadastro`.`matricula` ORDER BY `data`ASC;";
    $stmt = $this->db->prepare($query);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function listar() {
    $query = "SELECT * FROM `entrevista`;";
    $stmt = $this->db->query($query);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function inserir() {
    $query = "INSERT INTO `entrevista`(`id`, `matricula`, `data`, `tipo`, `motivo`, `semjust`, `comprevia`, `justicomp`, `acao`, `acatada`, `alinhada`, "
            . "`diadescontado`, `inicio`, `fim`, `obs`) VALUES (:id,:matricula,:data,:tipo,:motivo,:semjust,:comprevia,:justicomp,:acao,:acatada,"
            . ":alinhada,:diadescontado,:inicio,:fim,:obs);";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id',$this->getId());
    $stmt->bindValue(':matricula',$this->getMatricula());
    $stmt->bindValue(':data',$this->getData());
    $stmt->bindValue(':tipo',$this->getTipo());
    $stmt->bindValue(':motivo',$this->getMotivo());
    $stmt->bindValue(':semjust',$this->getSemjust());
    $stmt->bindValue(':comprevia',$this->getComprevia());
    $stmt->bindValue(':justicomp',$this->getJusticomp());
    $stmt->bindValue(':acao',$this->getAcao());
    $stmt->bindValue(':acatada',$this->getAcatada());
    $stmt->bindValue(':alinhada',$this->getAlinhada());
    $stmt->bindValue(':diadescontado',$this->getDiadescontado());
    $stmt->bindValue(':inicio',$this->getInicio());
    $stmt->bindValue(':fim',$this->getFim());
    $stmt->bindValue(':obs',$this->getObs());
    $stmt->execute();
}
public function alterar() {
    $query = "UPDATE `entrevista` SET `tipo`=:tipo,`motivo`=:motivo,`semjust`=:semjust,"
            . "`comprevia`=:comprevia,`justicomp`=:justicomp,`acao`=:acao,`acatada`=:acatada,"
            . "`alinhada`=:alinhada,`diadescontado`=:diadescontado,`inicio`=:inicio,`fim`=:fim,`obs`=:obs WHERE `id`=:id";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':tipo',$this->getTipo());
    $stmt->bindValue(':motivo',$this->getMotivo());
    $stmt->bindValue(':semjust',$this->getSemjust());
    $stmt->bindValue(':comprevia',$this->getComprevia());
    $stmt->bindValue(':justicomp',$this->getJusticomp());
    $stmt->bindValue(':acao',$this->getAcao());
    $stmt->bindValue(':acatada',$this->getAcatada());
    $stmt->bindValue(':alinhada',$this->getAlinhada());
    $stmt->bindValue(':diadescontado',$this->getDiadescontado());
    $stmt->bindValue(':inicio',$this->getInicio());
    $stmt->bindValue(':fim',$this->getFim());
    $stmt->bindValue(':obs',$this->getObs());
    $stmt->bindValue(':id',$this->getId());
    $stmt->execute();
    if($stmt->execute()){return true;}
}

public function deletar($id) {
    $query = "DELETE FROM `entrevista` WHERE=:id;";
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

    function getMatricula() {
        return $this->matricula;
    }

    function getData() {
        return $this->data;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getMotivo() {
        return $this->motivo;
    }

    function getSemjust() {
        return $this->semjust;
    }

    function getComprevia() {
        return $this->comprevia;
    }

    function getJusticomp() {
        return $this->justicomp;
    }

    function getAcao() {
        return $this->acao;
    }

    function getAcatada() {
        return $this->acatada;
    }

    function getAlinhada() {
        return $this->alinhada;
    }

    function getDiadescontado() {
        return $this->diadescontado;
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

    function setMatricula($matricula) {
        $this->matricula = $matricula;
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

    function setMotivo($motivo) {
        $this->motivo = $motivo;
        return $this;
    }

    function setSemjust($semjust) {
        $this->semjust = $semjust;
        return $this;
    }

    function setComprevia($comprevia) {
        $this->comprevia = $comprevia;
        return $this;
    }

    function setJusticomp($justicomp) {
        $this->justicomp = $justicomp;
        return $this;
    }

    function setAcao($acao) {
        $this->acao = $acao;
        return $this;
    }

    function setAcatada($acatada) {
        $this->acatada = $acatada;
        return $this;
    }

    function setAlinhada($alinhada) {
        $this->alinhada = $alinhada;
        return $this;
    }

    function setDiadescontado($diadescontado) {
        $this->diadescontado = $diadescontado;
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