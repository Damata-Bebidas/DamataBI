<?php
/**
 * Description of boleto
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class boleto implements crudBasic {
    private $db,$numeroDocumento,$NB,$nome,$valor,$vencimento,$data,$danfe,$pj_pf,$cpf,$end,$bairro,$cidade,$uf,$cep,$codigoBarras,$indicadorBaseCentral;
//construtor
function __construct(\PDO $db) {
    $this->db = $db;
}
//metodos modificadores
public function find($id){
    $query = "select * from  `boleto` where `numDoc`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

public function consult(){
    $query = "select * from  `boleto`;";
    $stmt = $this->db->prepare($query);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultId($id){
    $query = "select * from  `boleto` where `NB`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function consultBoletoData($data){
    $query = "SELECT `numDoc`, `NB`, `nome`, `valor`, `vencimento`, `data`,`indicadorBaseCentral`, `codigoBarras` FROM `boleto` WHERE LEFT(boleto.data,10)=:data ORDER by indicadorBaseCentral ASC;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":data", $data);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function listar() {
    $query = "select * from `boleto`;";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function listarRecentes($data) {
    $query = "SELECT * FROM `boleto` WHERE LEFT(`data`,10) >= :data And boleto.codigoBarras='' And indicadorBaseCentral<>'NOSSO NUMERO JA EXISTENTE EM NOSSA BASE'";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':data',$data);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function listarRecentesTT($data) {
    $query = "SELECT * FROM `boleto` WHERE LEFT(`data`,10) >= :data And boleto.codigoBarras=''";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':data',$data);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function inserir() {
    $query = "INSERT INTO `boleto`(`numDoc`, `NB`, `nome`, `valor`, `vencimento`,`data`, `danfe`, `pj_pf`, `cpf`, `end`, `bairro`, `cidade`, `uf`, "
            . "`cep`, `indicadorBaseCentral`, `codigoBarras`) VALUES (:numDoc,:NB,:nome,:valor,:venc,"
            . "now(),:danfe, :pj_pf, :cpf,:end,:bairro,:cidade,:uf,:cep,:indicadorbasecentral,:codigobarras)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':numDoc',$this->getNumeroDocumento());
    $stmt->bindValue(':NB',$this->getNB());
    $stmt->bindValue(':nome',$this->getNome());
    $stmt->bindValue(':valor',$this->getValor());
    $stmt->bindValue(':venc',$this->getVencimento());
    $stmt->bindValue(':danfe',$this->getDanfe());
    $stmt->bindValue(':pj_pf',$this->getPj_pf());
    $stmt->bindValue(':cpf',$this->getCpf());
    $stmt->bindValue(':end',$this->getEnd());
    $stmt->bindValue(':bairro',$this->getBairro());
    $stmt->bindValue(':cidade',$this->getCidade());
    $stmt->bindValue(':uf',$this->getUf());
    $stmt->bindValue(':cep',$this->getCep());
    $stmt->bindValue(':indicadorbasecentral',$this->getIndicadorBaseCentral());
    $stmt->bindValue(':codigobarras',$this->getCodigoBarras());
    $stmt->execute();
}
public function alterar() {
    $query = "UPDATE `boleto` SET `valor`=:valor,`vencimento`=:venc,`cpf`=:cpf,`cidade`=:cidade,`uf`=:uf,`cep`=:cep,`indicadorBaseCentral`=:indicadorbasecentral,`codigoBarras`=:codigobarras,`data`=now() WHERE `numDoc`=:numDoc";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':valor',$this->getValor());
    $stmt->bindValue(':venc',$this->getVencimento());
    $stmt->bindValue(':cpf',$this->getCpf());
    $stmt->bindValue(':cidade',$this->getCidade());
    $stmt->bindValue(':uf',$this->getUf());
    $stmt->bindValue(':cep',$this->getCep());
    $stmt->bindValue(':indicadorbasecentral',$this->getIndicadorBaseCentral());
    $stmt->bindValue(':codigobarras',$this->getCodigoBarras());
    $stmt->bindValue(':numDoc',$this->getNumeroDocumento());
    $stmt->execute();
    if($stmt->execute()){return true;}
}

public function alterarStatus($codigoBarras,$id) {
    $query = "UPDATE `boleto` SET `indicadorBaseCentral`='',`codigoBarras`=:codigobarras , `data`=now()  WHERE `numDoc`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':codigobarras', $codigoBarras);
    $stmt->bindValue(':id', $id);
    if($stmt->execute()){return true;}
}
public function deletar($id) {
    $query = "delete from `boleto` where `numDoc`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id', $id);
    if($stmt->execute()){
        return true;
    }
}
// get and setter
    function getNumeroDocumento() {
        return $this->numeroDocumento;
    }

    function getNB() {
        return $this->NB;
    }

    function getNome() {
        return $this->nome;
    }

    function getValor() {
        return $this->valor;
    }

    function getVencimento() {
        return $this->vencimento;
    }

    function getData() {
        return $this->data;
    }

    function getDanfe() {
        return $this->danfe;
    }

    function getPj_pf() {
        return $this->pj_pf;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getEnd() {
        return $this->end;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getUf() {
        return $this->uf;
    }

    function getCep() {
        return $this->cep;
    }

    function getCodigoBarras() {
        return $this->codigoBarras;
    }

    function getIndicadorBaseCentral() {
        return $this->indicadorBaseCentral;
    }

    function setNumeroDocumento($numeroDocumento) {
        $this->numeroDocumento = $numeroDocumento;
        return $this;
    }

    function setNB($NB) {
        $this->NB = $NB;return $this;
    }

    function setNome($nome) {
        $this->nome = $nome;return $this;
    }

    function setValor($valor) {
        $this->valor = $valor;return $this;
    }

    function setVencimento($vencimento) {
        $this->vencimento = $vencimento;return $this;
    }

    function setData($data) {
        $this->data = $data;return $this;
    }

    function setDanfe($danfe) {
        $this->danfe = $danfe;return $this;
    }

    function setPj_pf($pj_pf) {
        $this->pj_pf = $pj_pf;return $this;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;return $this;
    }

    function setEnd($end) {
        $this->end = $end;return $this;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;return $this;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;return $this;
    }

    function setUf($uf) {
        $this->uf = $uf;return $this;
    }

    function setCep($cep) {
        $this->cep = $cep;return $this;
    }

    function setCodigoBarras($codigoBarras) {
        $this->codigoBarras = $codigoBarras;return $this;
    }

    function setIndicadorBaseCentral($indicadorBaseCentral) {
        $this->indicadorBaseCentral = $indicadorBaseCentral;return $this;
    }
}