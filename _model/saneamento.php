<?php
/**
 * Description of saneamento
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class saneamento implements crudBasic {
    private $db, $NB, $Nome, $PJ_PF, $GV, $SV, $VDE, $End, $Compl, $Bairro,$Cidade, $CEP, $Tel, $Cadastro, $UltimaCompra, $Categoria,$Anomalias, $Base, $Tipo, $Status; 
//construtor
function __construct(\PDO $db) {$this->db = $db;}
//metodos modificadores
public function find($id){
    $query = "SELECT * FROM `saneamento` WHERE `NB`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

public function consult(){
    $query = "SELECT `NB`, `Status`, `obs`, `data` FROM `saneamento`;";
    $stmt = $this->db->prepare($query);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function inserir() {
    $query = "INSERT INTO `saneamento`(`NB`, `Nome`, `PJ_PF`, `GV`, `SV`, `VDE`,"
            . " `End`, `Compl`, `Bairro`, `Cidade`, `CEP`, `Tel`, `Cadastro`, "
            . "`UltimaCompra`, `Categoria`, `Anomalias`, `Base`, `Tipo`, `Status`) "
            . "VALUES (:NB,:Nome,:PJ_PF,:GV,:SV,:VDE,:End,:Compl,:Bairro,:Cidade,"
            . ":Cep,:Tel,:Cadastro,:UltimaCompra,:Categoria,:Anomalias,:Base,:Tipo,DEFAULT);";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':NB',$this->getNB()); $stmt->bindValue(':Nome',$this->getNome());
    $stmt->bindValue(':PJ_PF',$this->getPJ_PF()); 
    $stmt->bindValue(':GV',$this->getGV()); $stmt->bindValue(':SV',$this->getSV());$stmt->bindValue(':VDE',$this->getVDE());
    $stmt->bindValue(':End',$this->getEnd()); $stmt->bindValue(':Compl',$this->getCompl());
    $stmt->bindValue(':Bairro',$this->getBairro()); $stmt->bindValue(':Cidade',$this->getCidade());
    $stmt->bindValue(':Cep',$this->getCep());
    $stmt->bindValue(':Tel',$this->getTel());
    $stmt->bindValue(':Cadastro',$this->getCadastro());
    $stmt->bindValue(':UltimaCompra',$this->getUltimaCompra());
    $stmt->bindValue(':Categoria',$this->getCategoria());
    $stmt->bindValue(':Anomalias',$this->getAnomalias());
    $stmt->bindValue(':Base',$this->getBase());
    $stmt->bindValue(':Tipo',$this->getTipo());
    $stmt->execute();
}
public function alterar() {
    $query = "UPDATE `saneamento` SET `Nome`=:Nome,`PJ_PF`=:PJ_PF,`GV`=:GV,"
            . "`SV`=:SV,`VDE`=:VDE,`End`=:End,`Compl`=:Compl,`Bairro`=:Bairro,"
            . "`Cidade`=:Cidade,`CEP`=:Cep,`Tel`=:Tel,`Cadastro`=:Cadastro,"
            . "`UltimaCompra`=:UltimaCompra,`Categoria`=:Categoria,"
            . "`Anomalias`=:Anomalias,`Base`=:Base,`Tipo`=:Tipo WHERE `NB`=:NB;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':Nome',$this->getNome()); $stmt->bindValue(':PJ_PF',$this->getPJ_PF());
    $stmt->bindValue(':GV',$this->getGV()); $stmt->bindValue(':SV',$this->getSV());
    $stmt->bindValue(':VDE',$this->getVDE());
    $stmt->bindValue(':End',$this->getEnd()); $stmt->bindValue(':Compl',$this->getCompl());
    $stmt->bindValue(':Bairro',$this->getBairro()); $stmt->bindValue(':Cidade',$this->getCidade());
    $stmt->bindValue(':Cep',$this->getCep()); $stmt->bindValue(':Tel',$this->getTel());
    $stmt->bindValue(':Cadastro',$this->getCadastro()); $stmt->bindValue(':UltimaCompra',$this->getUltimaCompra());
    $stmt->bindValue(':Categoria',$this->getCategoria());
    $stmt->bindValue(':Anomalias',$this->getAnomalias());
    $stmt->bindValue(':Base',$this->getBase());
    $stmt->bindValue(':Tipo',$this->getTipo());
    $stmt->bindValue(':NB',$this->getNB());
    $stmt->execute();
    if($stmt->execute()){return true;}
}

public function alterarStatus($status,$obs,$id) {
    $query = "UPDATE `saneamento` SET `Status`=:status, `obs`=:obs, `data`=now() WHERE `NB`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':obs', $obs);
    $stmt->bindValue(':id', $id);
    if($stmt->execute()){return true;}
}
public function deletar($id) {
    $query = "DELETE FROM `saneamento` WHERE `NB`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id', $id);
    if($stmt->execute()){
        return true;
    }
}
// get and setter
    function getNB() {
        return $this->NB;
    }

    function getNome() {
        return $this->Nome;
    }

    function getPJ_PF() {
        return $this->PJ_PF;
    }

    function getGV() {
        return $this->GV;
    }

    function getSV() {
        return $this->SV;
    }

    function getVDE() {
        return $this->VDE;
    }

    function getEnd() {
        return $this->End;
    }

    function getCompl() {
        return $this->Compl;
    }

    function getBairro() {
        return $this->Bairro;
    }

    function getCidade() {
        return $this->Cidade;
    }

    function getCEP() {
        return $this->CEP;
    }

    function getTel() {
        return $this->Tel;
    }

    function getCadastro() {
        return $this->Cadastro;
    }

    function getUltimaCompra() {
        return $this->UltimaCompra;
    }

    function getCategoria() {
        return $this->Categoria;
    }

    function getAnomalias() {
        return $this->Anomalias;
    }

    function getBase() {
        return $this->Base;
    }

    function getTipo() {
        return $this->Tipo;
    }

    function getStatus() {
        return $this->Status;
    }

    function setNB($NB) {
        $this->NB = $NB;
    }

    function setNome($Nome) {
        $this->Nome = $Nome;
    }

    function setPJ_PF($PJ_PF) {
        $this->PJ_PF = $PJ_PF;
    }

    function setGV($GV) {
        $this->GV = $GV;
    }

    function setSV($SV) {
        $this->SV = $SV;
    }

    function setVDE($VDE) {
        $this->VDE = $VDE;
    }

    function setEnd($End) {
        $this->End = $End;
    }

    function setCompl($Compl) {
        $this->Compl = $Compl;
    }

    function setBairro($Bairro) {
        $this->Bairro = $Bairro;
    }

    function setCidade($Cidade) {
        $this->Cidade = $Cidade;
    }

    function setCEP($CEP) {
        $this->CEP = $CEP;
    }

    function setTel($Tel) {
        $this->Tel = $Tel;
    }

    function setCadastro($Cadastro) {
        $this->Cadastro = $Cadastro;
    }

    function setUltimaCompra($UltimaCompra) {
        $this->UltimaCompra = $UltimaCompra;
    }

    function setCategoria($Categoria) {
        $this->Categoria = $Categoria;
    }

    function setAnomalias($Anomalias) {
        $this->Anomalias = $Anomalias;
    }

    function setBase($Base) {
        $this->Base = $Base;
    }

    function setTipo($Tipo) {
        $this->Tipo = $Tipo;
    }

    function setStatus($Status) {
        $this->Status = $Status;
    }
}