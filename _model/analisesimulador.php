<?php
/**
 * Description of analisesimulador
 * @author welingtonmarquezini
 */
require_once 'crudBasic.php';
class analisesimulador {
    private $db, $id, $simulador, $qtd, $data, $serasa, $status, 
            $motivo, $aprovador ,$log;   
//construtor
    function __construct(\PDO $db) {
        $this->db = $db;
    }
    
    public function consult() {
        $query = "SELECT `analise_simulador`.`id`, `simulador`.`nb`, `nome` ,`simulador`.`vasilhame` , `analise_simulador`.`data`, `analise_simulador`.`status`
	FROM ((`simulador` INNER JOIN `saneamento` on `simulador`.`nb`=`saneamento`.`NB`) 
        INNER JOIN `analise_simulador` ON `simulador`.`id` = `analise_simulador`.`simulador`);";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function consultData($data) {
        $query = "SELECT * FROM `analise_simulador` WHERE `data` >= :data;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":data", $data);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function findIdSimulador($id) {
        $query = "SELECT * FROM `simulador` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function alterarApiSimulador($classerisco,$docs,$inad,$giro,$comodato,$ttcompracxs,$id) {
        $query = "UPDATE `analise_simulador` SET `classerisco`=:classerisco,`docs`=:docs,"
                . "`inad`=:inad, `giro`=:giro,`comodato`=:comodato,`ttcompracxs`=:ttcompracxs "
                . "WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":classerisco", $classerisco);
        $stmt->bindValue(":docs", $docs);
        $stmt->bindValue(":inad", $inad);
        $stmt->bindValue(":giro", $giro);
        $stmt->bindValue(":comodato", $comodato);
        $stmt->bindValue(":ttcompracxs", $ttcompracxs);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function find($id) {
        $query = "SELECT * FROM `analise_simulador` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function findStatus($nb,$vasilhame,$descr) {
        $query = "SELECT * FROM `simulador` WHERE `nb`=:nb "
                . "and `vasilhame`=:vasilhame and `descr`=:descr;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nb", $nb);
        $stmt->bindValue(":vasilhame", $vasilhame);
        $stmt->bindValue(":descr", $descr);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function findData($inicio,$fim) {
        $query = "SELECT `analise_simulador`.`id`, `simulador`.`nb`, `nome` ,`simulador`.`vasilhame` , `analise_simulador`.`data`, `analise_simulador`.`status`
        FROM ((`simulador` INNER JOIN `saneamento` on `simulador`.`nb`=`saneamento`.`NB`) 
            INNER JOIN `analise_simulador` ON `simulador`.`id` = `analise_simulador`.`simulador`)
            WHERE `analise_simulador`.`data`>=:inicio and `analise_simulador`.`data`<=:fim;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":inicio", $inicio);
        $stmt->bindValue(":fim", $fim);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findSimulador($nb,$vasilhame) {
        $query = "SELECT `id`, `simulador`.`nb`, `nome`, `vasilhame`, `descr`, `classerisco`, "
                . "`docs`, `inad`, `giro`, sum(`comodato`) as comodato, `ttcompracxs`, `metagiro` "
                . "FROM `simulador` INNER JOIN `saneamento` on `simulador`.`nb`=`saneamento`.`NB` "
                . "WHERE `simulador`.`nb`=:nb and `vasilhame`=:vasilhame GROUP BY `descr`;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nb", $nb);
        $stmt->bindValue(":vasilhame", $vasilhame);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function inserir() {
        $query = "INSERT INTO `analise_simulador`(`simulador`, `qtd`, `data`, `serasa`, `status`, `motivo`, `aprovador`) "
                . "VALUES (:simulador,:qtd,now(),:serasa,:status,:motivo,:aprovador);";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':simulador',$this->getSimulador());
        $stmt->bindValue(':qtd',$this->getQtd());
        $stmt->bindValue(':serasa',$this->getSerasa());
        $stmt->bindValue(':status',$this->getStatus());
        $stmt->bindValue(':motivo',$this->getMotivo());
        $stmt->bindValue(':aprovador',$this->getAprovador());
        $stmt->execute();
    }
    
    public function alterar() {
        $query = "UPDATE `analise_simulador` SET `qtd`=:qtd,`data`=now(),`serasa`=:serasa,"
                . "`status`=:status,`motivo`=:motivo, `aprovador`=:aprovador WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':qtd',$this->getQtd());
        $stmt->bindValue(':serasa',$this->getSerasa());
        $stmt->bindValue(':status',$this->getStatus());
        $stmt->bindValue(':motivo',$this->getMotivo());
        $stmt->bindValue(':aprovador',$this->getAprovador());
        $stmt->bindValue(':id',$this->getId());
        if($stmt->execute()){return true;}
    }
    
    public function aprovar($id,$aprovador) {
        $query = "UPDATE `analise_simulador` SET `aprovador`=:aprovador,`log`= md5(now()) WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':aprovador',$aprovador);
        $stmt->bindValue(':id',$id);
        if($stmt->execute()){return true;}
    }

    public function deletar($id) {
        $query = "DELETE FROM `analise_simulador` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        if($stmt->execute()){return true;}
    }
    
    public function inserirSimulador($nb,$vasilhame,$descr,$classe,$docs,$inad,$giro,$comodato,$ttcaixas,$meta) {
        $query = "INSERT INTO `simulador`(`nb`, `vasilhame`, `descr`, `classerisco`, `docs`, `inad`, `giro`, `comodato`, `ttcompracxs`, `metagiro`) "
                . "VALUES (:nb,:vasilhame,:descr,:classerisco,:docs,:inad,:giro,:comodato,:ttcompracxs,:metagiro)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nb',$nb);
        $stmt->bindValue(':vasilhame',$vasilhame);
        $stmt->bindValue(':descr', $descr);
        $stmt->bindValue(':classerisco',$classe);
        $stmt->bindValue(':docs',$docs);
        $stmt->bindValue(':inad',$inad);
        $stmt->bindValue(':giro',$giro);
        $stmt->bindValue(':comodato',$comodato);
        $stmt->bindValue(':ttcompracxs',$ttcaixas);
        $stmt->bindValue(':metagiro',$meta);
        $stmt->execute();
    }
    
    //get and set
    function getId() {
        return $this->id;
    }

    function getSimulador() {
        return $this->simulador;
    }

    function getQtd() {
        return $this->qtd;
    }

    function getData() {
        return $this->data;
    }

    function getSerasa() {
        return $this->serasa;
    }

    function getStatus() {
        return $this->status;
    }

    function getMotivo() {
        return $this->motivo;
    }

    function getAprovador() {
        return $this->aprovador;
    }

    function getLog() {
        return $this->log;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setSimulador($simulador) {
        $this->simulador = $simulador;
        return $this;
    }

    function setQtd($qtd) {
        $this->qtd = $qtd;
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    function setSerasa($serasa) {
        $this->serasa = $serasa;
        return $this;
    }

    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    function setMotivo($motivo) {
        $this->motivo = $motivo;
        return $this;
    }

    function setAprovador($aprovador) {
        $this->aprovador = $aprovador;
        return $this;
    }

    function setLog($log) {
        $this->log = $log;
        return $this;
    }
}
