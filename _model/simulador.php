<?php
/**
 * Description of simulador
 *
 * @author welingtonmarquezini
 */
require_once 'crudBasic.php';
class simulador implements crudBasic {
    private $db, $id ,$nb, $vasilhame, $descr, $classerisco, $docs, $inad, $giro, 
            $comodato, $ttcompracxs, $metagiro;
    //construtor
    function __construct(\PDO $db) {
        $this->db = $db;
    }
    
    public function consult() {
        $query = "SELECT * FROM `simulador`;";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function find($nb) {
        $query = "SELECT * FROM `simulador` WHERE `nb`=:nb;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nb", $nb);
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
    
    public function inserir() {
        $query = "INSERT INTO `simulador`(`nb`, `vasilhame`, `descr`, `classerisco`, `docs`, `inad`, `giro`, `comodato`, `ttcompracxs`, `metagiro`) "
                . "VALUES (:nb,:vasilhame,:descr,:classerisco,:docs,:inad,:giro,:comodato,:ttcompracxs,:metagiro)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nb',$this->getNb());
        $stmt->bindValue(':vasilhame',$this->getVasilhame());
        $stmt->bindValue(':descr',$this->getDescr());
        $stmt->bindValue(':classerisco',$this->getClasserisco());
        $stmt->bindValue(':docs',$this->getDocs());
        $stmt->bindValue(':inad',$this->getInad());
        $stmt->bindValue(':giro',$this->getGiro());
        $stmt->bindValue(':comodato',$this->getComodato());
        $stmt->bindValue(':ttcompracxs',$this->getTtcompracxs());
        $stmt->bindValue(':metagiro',$this->getMetagiro());
        $stmt->execute();
    }
    
    public function alterar() {
        $query = "UPDATE `simulador` SET `classerisco`=:classerisco,`docs`=:docs,"
                . "`inad`=:inad,`giro`=:giro,`comodato`=:comodato,"
                . "`ttcompracxs`=:ttcompracxs,`metagiro`=:metagiro WHERE`id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':classerisco',$this->getClasserisco());
        $stmt->bindValue(':docs',$this->getDocs());
        $stmt->bindValue(':inad',$this->getInad());
        $stmt->bindValue(':giro',$this->getGiro());
        $stmt->bindValue(':comodato',$this->getComodato());
        $stmt->bindValue(':ttcompracxs',$this->getTtcompracxs());
        $stmt->bindValue(':metagiro',$this->getMetagiro());
        $stmt->bindValue(':id',$this->getId());
        if($stmt->execute()){return true;}
    }

    public function deletar($id) {
        $query = "DELETE FROM `simulador` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        if($stmt->execute()){return true;}
    }
    //get and set
    function getNb() {
        return $this->nb;
    }

    function getVasilhame() {
        return $this->vasilhame;
    }

    function getDescr() {
        return $this->descr;
    }

    function getData() {
        return $this->data;
    }

    function getClasserisco() {
        return $this->classerisco;
    }

    function getDocs() {
        return $this->docs;
    }

    function getInad() {
        return $this->inad;
    }

    function getGiro() {
        return $this->giro;
    }

    function getComodato() {
        return $this->comodato;
    }

    function getTtcompracxs() {
        return $this->ttcompracxs;
    }

    function getMetagiro() {
        return $this->metagiro;
    }

    function getId() {
        return $this->id;
    }
    
    function setNb($nb) {
        $this->nb = $nb;
        return $this;
    }

    function setVasilhame($vasilhame) {
        $this->vasilhame = $vasilhame;
        return $this;
    }

    function setDescr($descr) {
        $this->descr = $descr;
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    function setClasserisco($classerisco) {
        $this->classerisco = $classerisco;
        return $this;
    }

    function setDocs($docs) {
        $this->docs = $docs;
        return $this;
    }

    function setInad($inad) {
        $this->inad = $inad;
        return $this;
    }

    function setGiro($giro) {
        $this->giro = $giro;
        return $this;
    }

    function setComodato($comodato) {
        $this->comodato = $comodato;
        return $this;
    }

    function setTtcompracxs($ttcompracxs) {
        $this->ttcompracxs = $ttcompracxs;
        return $this;
    }

    function setMetagiro($metagiro) {
        $this->metagiro = $metagiro;
        return $this;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

}
