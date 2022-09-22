<?php
/**
 * Description of treinamento
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class treinamento implements crudBasic {
    //put your code here
    private $db,$id_tr, $treinamento, $cargos, $frequencia, 
            $responsavel, $carga, $id_area;
    //metodos modificadores
    public function find($id){
        $query = "select `treinamento`.`id_tr`, `Treinamento`, `cargos`, `frequencia`, `responsavel`,`carga` 
        from (`treinamento` inner join `plano` on plano.id_tr=treinamento.id_tr) where `id_area`=:id and `conclusao`>=now()
        ORDER BY `Treinamento` ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function findPrev($id){
        $query = "select `id_tr`, `Treinamento`, `cargos`, `frequencia`, `carga` from `treinamento` where `id_area`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function consult(){
        $query = "select `treinamento`.`id_tr`, `Treinamento`, `cargos`,`frequencia`,`carga`, `responsavel`,
        `id_area`,`plano`.`previsao`, `plano`.`conclusao` from (`treinamento` inner join `plano` on plano.id_tr=treinamento.id_tr);";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function findPlan($id){
        $query = "select plano.previsao from (treinamento inner join plano "
         . "on plano.id_tr=treinamento.id_tr) where treinamento.id_tr=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function findComplete($assunto){
        $query = "SELECT `Treinamento` FROM `treinamento` WHERE `treinamento` LIKE '%" . $assunto ."%' ORDER BY `treinamento` ASC LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function findName($treinamento){
        $query = "SELECT * FROM `treinamento` WHERE Treinamento=:treinamento;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":treinamento", $treinamento);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function inserir() {
        $query = "INSERT INTO `treinamento`(`Treinamento`, `cargos`, `frequencia`, `carga`, `responsavel`, `id_area`) 
            VALUES (:treinamento,:cargos,:frequencia,:carga,:responsavel,:idarea)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':treinamento',$this->getTreinamento());
        $stmt->bindValue(':cargos',$this->getCargos());
        $stmt->bindValue(':frequencia',$this->getFrequencia());
        $stmt->bindValue(':carga',$this->getCarga());
        $stmt->bindValue(':responsavel',$this->getResponsavel());
        $stmt->bindValue(':idarea',$this->getId_area());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `treinamento` SET `Treinamento`=:treinamento,`cargos`=:cargos,`frequencia`=:frequencia,
            `carga`=:carga,`responsavel`=:responsavel,`id_area`=:idarea WHERE `id_tr`=:idtr";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':treinamento',$this->getTreinamento());
        $stmt->bindValue(':cargos',$this->getCargos());
        $stmt->bindValue(':frequencia',$this->getFrequencia());
        $stmt->bindValue(':carga',$this->getCarga());
        $stmt->bindValue(':responsavel',$this->getResponsavel());
        $stmt->bindValue(':idarea',$this->getId_area());
        $stmt->bindValue(':idtr',$this->getId_tr());
        $stmt->execute();
        if($stmt->execute()){
            return true;
        }
    }
    public function deletar($id) {
        $query = "DELETE FROM `treinamento` WHERE id_tr=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    //consultar vencimento do treinamento
    public function IncluirVencimento($id) {
        $query = "INSERT INTO `plano`(`id_tr`, `conclusao`) VALUES (:id,now());";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
    public function AlterarVencimento($data,$id) {
        $query = "UPDATE `plano` SET `conclusao`=:dataPrevista WHERE `id_tr`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':dataPrevista', $data);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    public function findVencimento($id) {
        $query = "SELECT `conclusao` FROM `plano` WHERE `id_tr`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function findMax() {
        $query = "SELECT MAX(id_tr) FROM `treinamento`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    //GET and Set
    function __construct(\PDO $db) {
        $this->db = $db;
    }
    
    function getId_tr() {
        return $this->id_tr;
    }

    function getTreinamento() {
        return $this->treinamento;
    }

    function getCargos() {
        return $this->cargos;
    }

    function getFrequencia() {
        return $this->frequencia;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getCarga() {
        return $this->carga;
    }

    function getId_area() {
        return $this->id_area;
    }

    function setId_tr($id_tr) {
        $this->id_tr = $id_tr;
        return $this;
    }

    function setTreinamento($treinamento) {
        $this->treinamento = $treinamento;
        return $this;
    }

    function setCargos($cargos) {
        $this->cargos = $cargos;
        return $this;
    }

    function setFrequencia($frequencia) {
        $this->frequencia = $frequencia;
        return $this;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
        return $this;
    }

    function setCarga($carga) {
        $this->carga = $carga;
        return $this;
    }

    function setId_area($id_area) {
        $this->id_area = $id_area;
        return $this;
    }
}