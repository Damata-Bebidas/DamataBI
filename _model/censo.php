<?php
/**
 * Description of censo
 *
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class censo implements crudBasic {
    private $db, $id, $setor, $idade, $tempo, $lider, $estadocivil, $escolaridade, $religiao,
            $genero, $orientacaosexual, $cor, $nacionalidade, $naturalidade, $pcd, 
            $deficiencia, $politicadiversidade, $importante, $obs;
    //construtor
    function __construct(\PDO $db) {
        $this->db = $db;
    }
    
    public function consult() {
        $query = "SELECT * FROM `censo`;";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function find($id) {
        $query = "SELECT * FROM `censo` WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();         
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function inserir() {
        $query = "INSERT INTO `censo`(`setor`,`idade`, `tempo`, `lider`, `estadocivil`, `escolaridade`, `religiao`, `genero`, `orientacaosexual`, `cor`,`nacionalidade`, `naturalidade`, `pcd`, `deficiencia`, `politicadiversidade`, `importante`, `obs`) "
                . "VALUES (:setor,:idade,:tempo,:lider,:estadocivil,:escolaridade,:religiao,:genero,:orientacaosexual,:cor,:nacionalidade,:naturalidade,:pcd,:deficiencia,:politicadiversidade,:importante,:obs);";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':setor',$this->getSetor()); 
        $stmt->bindValue(':idade',$this->getIdade());
        $stmt->bindValue(':tempo',$this->getTempo());
        $stmt->bindValue(':lider',$this->getLider());
        $stmt->bindValue(':estadocivil',$this->getEstadocivil());
        $stmt->bindValue(':escolaridade',$this->getEscolaridade());
        $stmt->bindValue(':religiao',$this->getReligiao());
        $stmt->bindValue(':genero',$this->getGenero());
        $stmt->bindValue(':orientacaosexual',$this->getOrientacaosexual());
        $stmt->bindValue(':cor',$this->getCor());
        $stmt->bindValue(':nacionalidade',$this->getNacionalidade());
        $stmt->bindValue(':naturalidade',$this->getNaturalidade());
        $stmt->bindValue(':pcd',$this->getPcd());
        $stmt->bindValue(':deficiencia',$this->getDeficiencia());
        $stmt->bindValue(':politicadiversidade',$this->getPoliticadiversidade());
        $stmt->bindValue(':importante',$this->getImportante());
        $stmt->bindValue(':obs',$this->getObs());
        $stmt->execute();
    }
    
    public function alterar() {
        $query = "UPDATE `censo` SET `idade`=:idade,`tempo`=:tempo,`lider`=:lider,`estadocivil`=:estadocivil,`escolaridade`=:escolaridade,`religiao`=:religiao,`genero`=:genero,`orientacaosexual`=:orientacaosexual,`cor`=:cor,`nacionalidade`=:nacionalidade,`naturalidade`=:naturalidade,`pcd`=:pcd,`deficiencia`=:deficiencia,`politicadiversidade`=:politicadiversidade,`importante`=:importante,`obs`=:obs WHERE `id`=:id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idade',$this->getIdade());
        $stmt->bindValue(':tempo',$this->getTempo());
        $stmt->bindValue(':lider',$this->getLider());
        $stmt->bindValue(':estadocivil',$this->getEstadocivil());
        $stmt->bindValue(':escolaridade',$this->getEscolaridade());
        $stmt->bindValue(':religiao',$this->getReligiao());
        $stmt->bindValue(':genero',$this->getGenero());
        $stmt->bindValue(':orientacaosexual,',$this->getOrientacaosexual());
        $stmt->bindValue(':cor',$this->getCor());
        $stmt->bindValue(':nacionalidade',$this->getNacionalidade());
        $stmt->bindValue(':naturalidade',$this->getNaturalidade());
        $stmt->bindValue(':pcd',$this->getPcd());
        $stmt->bindValue(':deficiencia',$this->getDeficiencia());
        $stmt->bindValue(':politicadiversidade',$this->getPoliticadiversidade());
        $stmt->bindValue(':importante',$this->getImportante());
        $stmt->bindValue(':obs',$this->getObs());
        $stmt->bindValue(':id',$this->getId());
        if($stmt->execute()){return true;}
    }

    public function deletar($id) {
        $query = "DELETE FROM `censo` WHERE `id`=:id;";
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
    
    function getSetor() {
        return $this->setor;
    }
    
    function getIdade() {
        return $this->idade;
    }

    function getTempo() {
        return $this->tempo;
    }

    function getLider() {
        return $this->lider;
    }

    function getEstadocivil() {
        return $this->estadocivil;
    }

    function getEscolaridade() {
        return $this->escolaridade;
    }

    function getReligiao() {
        return $this->religiao;
    }

    function getGenero() {
        return $this->genero;
    }

    function getOrientacaosexual() {
        return $this->orientacaosexual;
    }

    function getCor() {
        return $this->cor;
    }

    function getNacionalidade() {
        return $this->nacionalidade;
    }

    function getNaturalidade() {
        return $this->naturalidade;
    }

    function getPcd() {
        return $this->pcd;
    }

    function getDeficiencia() {
        return $this->deficiencia;
    }

    function getPoliticadiversidade() {
        return $this->politicadiversidade;
    }

    function getImportante() {
        return $this->importante;
    }

    function getObs() {
        return $this->obs;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    function setSetor($setor) {
        $this->setor = $setor;
        return $this;
    }
    
    function setIdade($idade) {
        $this->idade = $idade;
        return $this;
    }

    function setTempo($tempo) {
        $this->tempo = $tempo;
        return $this;
    }

    function setLider($lider) {
        $this->lider = $lider;
        return $this;
    }

    function setEstadocivil($estadocivil) {
        $this->estadocivil = $estadocivil;
        return $this;
    }

    function setEscolaridade($escolaridade) {
        $this->escolaridade = $escolaridade;
        return $this;
    }

    function setReligiao($religiao) {
        $this->religiao = $religiao;
        return $this;
    }

    function setGenero($genero) {
        $this->genero = $genero;
        return $this;
    }

    function setOrientacaosexual($orientacaosexual) {
        $this->orientacaosexual = $orientacaosexual;
        return $this;
    }

    function setCor($cor) {
        $this->cor = $cor;
        return $this;
    }

    function setNacionalidade($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
        return $this;
    }

    function setNaturalidade($naturalidade) {
        $this->naturalidade = $naturalidade;
        return $this;
    }

    function setPcd($pcd) {
        $this->pcd = $pcd;
        return $this;
    }

    function setDeficiencia($deficiencia) {
        $this->deficiencia = $deficiencia;
        return $this;
    }

    function setPoliticadiversidade($politicadiversidade) {
        $this->politicadiversidade = $politicadiversidade;
        return $this;
    }

    function setImportante($importante) {
        $this->importante = $importante;
        return $this;
    }

    function setObs($obs) {
        $this->obs = $obs;
        return $this;
    }
}
