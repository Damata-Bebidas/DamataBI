<?php
/**
 * Description of check
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class check implements crudBasic {
    private $db,$id_check, $id_key_check, $id_tr, $freq,$Questao, $A, $B, $C, $D, $Gabarito, $Status,$instrutor;
//construtor
function __construct(\PDO $db) {
    $this->db = $db;
}
//metodos modificadores
public function find($id){
    $query = "SELECT * FROM `check` WHERE `id_key_check`=:id ORDER BY `id_check` ASC;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function vericarStatus($id){
    $query = "SELECT * FROM `check` WHERE `id_check`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

public function listarChecks($id){
    $query = "select treinamento.id_tr,treinamento.Treinamento from (treinamento inner join aplicabilidade on treinamento.id_tr=aplicabilidade.id_tr) 
        where aplicabilidade.matricula=:id order by treinamento.Treinamento ASC;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function respCheck($id){
    $query = "SELECT * FROM `checkResp` WHERE `id_check`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

public function checkResp($id,$tr){
    $query = "select max(`checkResp`.`freq`) from (`check` inner join `checkResp` on `check`.`id_key_check`=`checkResp`.`id_key_check`) 
    where `checkResp`.`matricula`=:id and `checkResp`.`id_tr`=:tr;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":tr", $tr);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

public function checkAbertos($id){
    $query = "SELECT MAX(`check`.`freq`) FROM `check` WHERE `check`.`id_tr`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

public function checkGabarito($id){
    $query = "SELECT `Gabarito` FROM `check` WHERE `id_check`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
public function findTreinamento($id){
    $query = "SELECT `treinamento`.`Treinamento`, `plano`.`custo`,`plano`.`tipo` "
            . "FROM (`treinamento` INNER JOIN `plano` ON `treinamento`.`id_tr` = `plano`.`id_tr`) WHERE `treinamento`.`id_tr`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

public function consult(){
    $query = "select * from `check`;";
    $stmt = $this->db->prepare($query);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function alterarCustoTipo($custo,$tipo) {
    $query = "UPDATE `plano` SET `custo`=:custo,`tipo`=:tipo WHERE `id_tr`=:id_tr;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':custo',$custo);
    $stmt->bindValue(':tipo',$tipo);
    $stmt->bindValue(':id_tr',$this->getId_tr());
    $stmt->execute();
    if($stmt->execute()){return true;}
}
public function consultInstrutores(){
    $query = "SELECT `matricula`, `nome` FROM `cadastro` WHERE (`tipo`='GESTOR' OR `tipo`='GENTE') AND `status`='ATIVO' ORDER BY `nome` ASC;";
    $stmt = $this->db->prepare($query);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultTrei($nome_tr){
    $query = "SELECT `id_tr` FROM `treinamento` WHERE `Treinamento`='Autenticidade';";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $nome_tr);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

public function inserir() {
    $query = "INSERT INTO `check`(`id_check`, `id_key_check`, `id_tr`, `freq`, `Questao`, `A`, `B`, `C`, `D`, `Gabarito`, `Status`,`instrutor`) "
            . "VALUES (:id_check,:id_key_check,:id_tr,:freq,:Questao,:A,:B,:C,:D,:Gabarito,:Status);";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id_check',$this->getId_check());
    $stmt->bindValue(':id_key_check',$this->getId_key_check());
    $stmt->bindValue(':id_tr',$this->getId_tr());
    $stmt->bindValue(':freq',$this->getFreq());
    $stmt->bindValue(':Questao',$this->getQuestao());
    $stmt->bindValue(':A',$this->getA()); $stmt->bindValue(':B',$this->getB());
    $stmt->bindValue(':C',$this->getC()); $stmt->bindValue(':D',$this->getD());
    $stmt->bindValue(':Gabarito',$this->getGabarito());
    $stmt->bindValue(':Status',$this->getStatus());
    $stmt->bindValue(':instrutor',$this->getInstrutor());
    $stmt->execute();
}
public function alterar() {
    $query = "UPDATE `check` SET `id_key_check`=:id_key_check ,`id_tr`=:id_tr,`freq`=:freq,`Questao`=:Questao,`A`=:A,`B`=:B,`C`=:C,`D`=:D,"
            . "`Gabarito`=:Gabarito,`Status`=:Status, `instrutor`=:instrutor WHERE `id_check`=:id_check";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id_key_check',$this->getId_key_check());
    $stmt->bindValue(':id_tr',$this->getId_tr()); $stmt->bindValue(':freq',$this->getFreq());
    $stmt->bindValue(':Questao',$this->getQuestao());
    $stmt->bindValue(':A',$this->getA()); $stmt->bindValue(':B',$this->getB());
    $stmt->bindValue(':C',$this->getC()); $stmt->bindValue(':D',$this->getD());
    $stmt->bindValue(':Gabarito',$this->getGabarito());
    $stmt->bindValue(':Status',$this->getStatus());
    $stmt->bindValue(':instrutor',$this->getInstrutor());
    $stmt->bindValue(':id_check',$this->getId_check());
    $stmt->execute();
    if($stmt->execute()){ return true;}
}
public function deletar($id) {
    $query = "DELETE FROM `check` WHERE `id_key_check`=:id;";
    $stmt = $this->db->prepare($query); $stmt->bindValue(':id', $id);
    if($stmt->execute()){ return true;}
}
// get and setter
    function getId_check() {
        return $this->id_check;
    }

    function getId_key_check() {
        return $this->id_key_check;
    }

    function getId_tr() {
        return $this->id_tr;
    }

    function getFreq() {
        return $this->freq;
    }

    function getQuestao() {
        return $this->Questao;
    }

    function getA() {
        return $this->A;
    }

    function getB() {
        return $this->B;
    }

    function getC() {
        return $this->C;
    }

    function getD() {
        return $this->D;
    }

    function getGabarito() {
        return $this->Gabarito;
    }

    function getStatus() {
        return $this->Status;
    }
    
    function getInstrutor() {return $this->instrutor;
    }
    
    function setId_check($id_check) {
        $this->id_check = $id_check;return $this;
    }

    function setId_key_check($id_key_check) {
        $this->id_key_check = $id_key_check;return $this;
    }

    function setId_tr($id_tr) {
        $this->id_tr = $id_tr;return $this;
    }

    function setFreq($freq) {
        $this->freq = $freq;return $this;
    }

    function setQuestao($Questao) {
        $this->Questao = $Questao;return $this;
    }

    function setA($A) {
        $this->A = $A;return $this;
    }

    function setB($B) {
        $this->B = $B;return $this;
    }

    function setC($C) {
        $this->C = $C;return $this;
    }

    function setD($D) {
        $this->D = $D;return $this;
    }

    function setGabarito($Gabarito) {
        $this->Gabarito = $Gabarito;return $this;
    }

    function setStatus($Status) {
        $this->Status = $Status;return $this;
    }
    
    function setInstrutor($instrutor) {
        $this->instrutor = $instrutor;return $this;
    }
}