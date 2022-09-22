<?php
/**
 * Description of mapeamento
 * extinção do Cargo
 * @author welingtonmarquezini
 */
require_once 'crudBasic.php';
class mapeamento implements crudBasic{
    private  $db, $id, $matricula , $data, $tipo, $motivo, $iniciativa, $ciclo, $situacao; 
   
    function __construct(\PDO $db) {
        $this->db = $db;
    }

    //metodos modificadores
    public function find($id){
        $query = "SELECT * FROM `mapeamento` WHERE `matricula`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function findDate($id,$data){
        $query = "SELECT * FROM `mapeamento` WHERE `matricula`=:id AND `data`=:data_p;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":data_p", $data);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findFilter($inicio,$fim) {
        $query = "SELECT `id`, `mapeamento`.`matricula`, `cadastro`.`nome`, `data`, `mapeamento`.`tipo`, `motivo`, 
            `cadastro`.`admissao` , `iniciativa`, `cadastro`.`setor`, `cadastro`.`cargo`, `ciclo`, `situacao` 
            FROM `mapeamento` INNER JOIN `cadastro` ON `mapeamento`.`matricula` = `cadastro`.`matricula` 
            WHERE `data` >= :inicio AND `data` <= :fim ORDER BY `data` ASC;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":inicio", $inicio);
        $stmt->bindValue(":fim", $fim);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function findFilterNome($inicio,$fim,$nome){
        $query = "SELECT `id`, `mapeamento`.`matricula`, `cadastro`.`nome`, `data`, `mapeamento`.`tipo`, `motivo`, `cadastro`.`admissao` , `iniciativa`, `cadastro`.`setor`, `cadastro`.`cargo`, `ciclo`, `situacao` FROM `mapeamento` INNER JOIN `cadastro` ON `mapeamento`.`matricula` = `cadastro`.`matricula` WHERE `data` >= :inicio AND `data` <= :fim AND `nome` = :nome ORDER BY `data`"; 
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":inicio", $inicio);
        $stmt->bindValue(":fim", $fim);
        $stmt->bindValue(":nome", $nome);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consult(){
        $query = "SELECT * FROM `mapeamento`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function inserir() {
        $query = "INSERT INTO `mapeamento`(`matricula`, `data`, `tipo`, `motivo`, `iniciativa`, `ciclo`, `situacao`) VALUES ( :matricula, :data_p , :tipo , :motivo , :iniciativa , :ciclo , :situacao);";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':data_p',$this->getData());
        $stmt->bindValue(':tipo',$this->getTipo());
        $stmt->bindValue(':motivo',$this->getMotivo());
        $stmt->bindValue(':iniciativa',$this->getIniciativa());
        $stmt->bindValue(':ciclo',$this->getCiclo());
        $stmt->bindValue(':situacao',$this->getSituacao());
        $stmt->execute();
    }
    public function alterar() {
        $query = "UPDATE `mapeamento` SET `matricula`=:matricula,`data`=:data_p, `tipo`=:tipo, `motivo`=:motivo, `iniciativa`=:iniciativa ,`ciclo`=:ciclo,`situacao`=:situacao WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':data_p',$this->getData());
        $stmt->bindValue(':tipo',$this->getTipo());
        $stmt->bindValue(':motivo',$this->getMotivo());
        $stmt->bindValue(':iniciativa',$this->getIniciativa());
        $stmt->bindValue(':ciclo',$this->getCiclo());
        $stmt->bindValue(':situacao',$this->getSituacao());
        $stmt->bindValue(':id',$this->getId());
        $stmt->execute();
    }
    public function deletar($id) {
        $query = "DELETE FROM `mapeamento` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()){
            return true;
        }
    }
    // Get and set
    public function getId() {
        return $this->id;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getData() {
        return $this->data;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getMotivo() {
        return $this->motivo;
    }

    public function getIniciativa() {
        return $this->iniciativa;
    }

    public function getCiclo() {
        return $this->ciclo;
    }

    public function getSituacao() {
        return $this->situacao;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    public function setMotivo($motivo) {
        $this->motivo = $motivo;
        return $this;
    }

    public function setIniciativa($iniciativa) {
        $this->iniciativa = $iniciativa;
        return $this;
    }

    public function setCiclo($ciclo) {
        $this->ciclo = $ciclo;
        return $this;
    }

    public function setSituacao($situacao) {
        $this->situacao = $situacao;
        return $this;
    }
}
