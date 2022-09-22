<?php
/**
 * Description of planobh
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class planobh implements crudBasic {
    private $db, $id, $mat, $saldo, $abatido, $pagarCompensar, $data, $status, $autorizado, $obs;
    //construtor
    function __construct(\PDO $db) {
        $this->db = $db;
    }
    
    public function consult() {
        $query = "SELECT * FROM `planobh`;";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function find($id) {
        $query = "SELECT * FROM `planobh` WHERE`id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findDate($mat,$data) {
        $query = "SELECT * FROM `planobh` WHERE `mat`=:mat and `data`=:datac";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":mat", $mat);
        $stmt->bindValue(":datac", $data);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findFilter($inicio,$fim) {
        $query = "SELECT `id`, `mat`, `nome` ,`saldo`, `abatido`, `PagarCompensar`, `data`, `planobh`.`status`, `autorizado`, `obs` 
        FROM `planobh` INNER JOIN `cadastro` ON `planobh`.`mat` = `cadastro`.`matricula` 
        WHERE `data` >= :inicio AND `data` <= :fim ORDER BY `data` ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":inicio", $inicio);
        $stmt->bindValue(":fim", $fim);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function inserir() {
        $query = "INSERT INTO `planobh`(`mat`, `saldo`, `abatido`, `PagarCompensar`, `data`, `status`, `autorizado`, `obs`) "
                . "VALUES (:mat,:saldo,:abatido,:PagarCompensar,:data,:status,:autorizado,:obs)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':mat',$this->getMat()); 
        $stmt->bindValue(':saldo',$this->getSaldo());
        $stmt->bindValue(':abatido',$this->getAbatido());
        $stmt->bindValue(':PagarCompensar',$this->getPagarCompensar());
        $stmt->bindValue(':data',$this->getData());
        $stmt->bindValue(':status',$this->getStatus());
        $stmt->bindValue(':autorizado',$this->getAutorizado());
        $stmt->bindValue(':obs',$this->getObs());
        $stmt->execute();
    }
    
    public function alterar() {
        $query = "UPDATE `planobh` SET `abatido`=:abatido,`PagarCompensar`=:PagarCompensar,"
                . "`data`=:data,`status`=:status,`autorizado`=:autorizado,`obs`=:obs WHERE`id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':abatido',$this->getAbatido());
        $stmt->bindValue(':PagarCompensar',$this->getPagarCompensar());
        $stmt->bindValue(':data',$this->getData());
        $stmt->bindValue(':status',$this->getStatus());
        $stmt->bindValue(':autorizado',$this->getAutorizado());
        $stmt->bindValue(':obs',$this->getObs());
        $stmt->bindValue(':id',$this->getId());
        if($stmt->execute()){return true;}
    }

    public function deletar($id) {
        $query = "DELETE FROM `planobh` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        if($stmt->execute()){
            return true;
        }
    }
    //get and set
    function getId() {
        return $this->id;
    }

    function getMat() {
        return $this->mat;
    }

    function getSaldo() {
        return $this->saldo;
    }

    function getAbatido() {
        return $this->abatido;
    }

    function getPagarCompensar() {
        return $this->pagarCompensar;
    }

    function getData() {
        return $this->data;
    }

    function getStatus() {
        return $this->status;
    }

    function getAutorizado() {
        return $this->autorizado;
    }

    function getObs() {
        return $this->obs;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setMat($mat) {
        $this->mat = $mat;
        return $this;
    }

    function setSaldo($saldo) {
        $this->saldo = $saldo;
        return $this;
    }

    function setAbatido($abatido) {
        $this->abatido = $abatido;
        return $this;
    }

    function setPagarCompensar($pagarCompensar) {
        $this->pagarCompensar = $pagarCompensar;
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    function setAutorizado($autorizado) {
        $this->autorizado = $autorizado;
        return $this;
    }

    function setObs($obs) {
        $this->obs = $obs;
        return $this;
    }
}
