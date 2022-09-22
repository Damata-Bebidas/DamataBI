<?php

/**
 * Description of aplicabilidade
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class aplicabilidade implements crudBasic {
    //put your code here
    private $db, $id_aplic, $id_tr , $matricula, $data;
    
    //construtor
    function __construct(\PDO $db) {
        $this->db = $db;
    }
    //metodos acessores
    public function findTreinamento($id){
        $query = "select cadastro.matricula, cadastro.nome, cadastro.cargo 
                from (cadastro inner join aplicabilidade on cadastro.matricula=aplicabilidade.matricula) 
                where aplicabilidade.id_tr=:id and (cadastro.status='ATIVO' OR LEFT(cadastro.status,1)='F')
                order by cadastro.nome ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function findTreinamentoArea($id,$area){
        $query = "select cadastro.matricula, cadastro.nome, cadastro.cargo
        from (cadastro inner join aplicabilidade on cadastro.matricula=aplicabilidade.matricula)
        where aplicabilidade.id_tr=:id and left(cadastro.setor,5)=left(:area,5)
        and (cadastro.status='ATIVO' OR LEFT(cadastro.status,1)='F') order by cadastro.nome ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":area", $area);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id){
        $query = "select cadastro.matricula, cadastro.nome, cadastro.cargo
        from (cadastro inner join aplicabilidade on cadastro.matricula=aplicabilidade.matricula)
        where aplicabilidade.id_tr=:id and (cadastro.status='ATIVO' OR LEFT(cadastro.status,1)='F') 
        order by cadastro.nome ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findColaboradores(){
        $query = "SELECT `matricula`, `nome`, `setor`, `cargo`, `status` FROM `cadastro` ORDER BY `nome` ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findColaboradoresArea($area){
        $query = "SELECT `matricula`, `nome`, `setor`, `cargo`, `status` FROM `cadastro` 
            WHERE LEFT(`setor`,3)=LEFT(:area,3) ORDER BY `nome` ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":area", $area);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findArea($id){
        $query = "select treinamento.id_area from (treinamento inner join aplicabilidade on treinamento.id_tr=aplicabilidade.id_tr) 
        where aplicabilidade.id_tr=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function findColaborador($nome){
        $query = "select treinamento.Treinamento, treinamento.cargos, treinamento.frequencia,treinamento.carga,treinamento.id_area
            from ((aplicabilidade inner join treinamento on aplicabilidade.id_tr=treinamento.id_tr) 
            inner join cadastro on aplicabilidade.matricula=cadastro.matricula) where cadastro.nome=:nome ORDER BY treinamento.id_area ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", $nome);
        $stmt->execute();         
        return $stmt->fetchall(\PDO::FETCH_ASSOC);
    }
    public function findMatricula($id){
        $query = "SELECT * FROM `aplicabilidade` WHERE `matricula`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function findAplic($id){
        $query = "SELECT `id_aplic` FROM `aplicabilidade` WHERE id_aplic=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function consult(){
        $query = "SELECT * FROM `aplicabilidade`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function inserir() {
        $query = "INSERT INTO `aplicabilidade`(`id_aplic`, `id_tr`, `matricula`, `data`) 
            VALUES (:id_aplic,:id_tr,:matricula,now())";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_aplic',$this->getId_aplic());
        $stmt->bindValue(':id_tr',$this->getId_tr());
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `aplicabilidade` SET `id_tr`=:id_tr,`matricula`=:matricula,`data`=now() WHERE `id_aplic`=:id_aplic";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_tr',$this->getId_tr());
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':id_aplic',$this->getId_aplic());
        $stmt->execute();
        if($stmt->execute()){
            return true;
        }
    }
    public function deletar($id) {
        $query = "DELETE FROM `aplicabilidade` WHERE `id_aplic`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    //metodos get and set
    function getId_aplic() {
        return $this->id_aplic;
    }

    function getId_tr() {
        return $this->id_tr;
    }

    function getMatricula() {
        return $this->matricula;
    }

    function getData() {
        return $this->data;
    }

    function setId_aplic($id_aplic) {
        $this->id_aplic = $id_aplic;
        return $this;
    }

    function setId_tr($id_tr) {
        $this->id_tr = $id_tr;
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
}