<?php
/**
 * Description of colaborador
 * @author welingtonmarquezini
 */
include_once 'crudBasic.php';
class colaborador implements crudBasic {
    //put your code here
    private $db,$matricula, $nome, $setor, $sexo, $email,$cargo,$nascimento,$admissao,
    $escolaridade, $status, $tipo, $senha;

//construtor    
function __construct(\PDO $db) {
    $this->db = $db;
}
//metodos modificadores
public function find($id){
    $query = "select * from cadastro where matricula=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();         
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
public function consult(){
    $query = "select * from cadastro;";
    $stmt = $this->db->prepare($query);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function listar() {
    $query = "select * from cadastro;";
    $stmt = $this->db->query($query);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function inserir() {
    $query = "INSERT INTO `cadastro`(`matricula`, `nome`, `setor`, `email`, `cargo`, `nascimento`, `admissao`, `sexo`, `escolaridade`, `status`, `tipo`, `senha`) "
            . "VALUES (:matricula,:nome,:setor,:email,:cargo,:nascimento,:admissao,:sexo,"
            . ":escolaridade,:status,:tipo,:senha)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':matricula',$this->getMatricula());
    $stmt->bindValue(':nome',$this->getNome());
    $stmt->bindValue(':setor',$this->getSetor());
    $stmt->bindValue(':email',$this->getEmail());
    $stmt->bindValue(':cargo',$this->getCargo());
    $stmt->bindValue(':nascimento',$this->getNascimento());
    $stmt->bindValue(':admissao',$this->getAdmissao());
    $stmt->bindValue(':sexo',$this->getSexo());
    $stmt->bindValue(':escolaridade',$this->getEscolaridade());
    $stmt->bindValue(':status',$this->getStatus());
    $stmt->bindValue(':tipo',$this->getTipo());
    $stmt->bindValue(':senha',$this->getSenha());
    $stmt->execute();
}
public function alterar() {
    $query = "update cadastro set `nome`=:nome,`setor`=:setor,`email`=:email,`cargo`=:cargo,"
            . "`nascimento`=:nascimento,`admissao`=:admissao,`sexo`=:sexo,`escolaridade`=:escolaridade,`status`=:status,"
            . "`tipo`=:tipo where `matricula`=:matricula";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':matricula',$this->getMatricula());
    $stmt->bindValue(':nome',$this->getNome());
    $stmt->bindValue(':setor',$this->getSetor());
    $stmt->bindValue(':email',$this->getEmail());
    $stmt->bindValue(':cargo',$this->getCargo());
    $stmt->bindValue(':nascimento',$this->getNascimento());
    $stmt->bindValue(':admissao',$this->getAdmissao());
    $stmt->bindValue(':sexo',$this->getSexo());
    $stmt->bindValue(':escolaridade',$this->getEscolaridade());
    $stmt->bindValue(':status',$this->getStatus());
    $stmt->bindValue(':tipo',$this->getTipo());
    $stmt->execute();
    if($stmt->execute()){
        return true;
    }
}
public function alterarImport() {
    $query = "update cadastro set `setor`=:setor, `cargo`=:cargo,`status`=:status where `matricula`=:matricula";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':setor',$this->getSetor());
    $stmt->bindValue(':cargo',$this->getCargo());
    $stmt->bindValue(':status',$this->getStatus());
    $stmt->bindValue(':matricula',$this->getMatricula());
    $stmt->execute();
    if($stmt->execute()){
        return true;
    }
}
public function alterarSenha($senha, $matricula) {
    $query = "update cadastro set `senha`=:senha where `matricula`=:matricula";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':senha',$senha);
    $stmt->bindValue(':matricula',$matricula);
    $stmt->execute();
    if($stmt->execute()){
        return true;
    };
}
public function deletar($id) {
    $query = "delete from cadastro where `matricula`=:id;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id', $id);
    if($stmt->execute()){
        return true;
    }
}
public function login($matricula){
    $query = "select * from `cadastro` where `matricula`=:matricula and `status`<>'DEMITIDO';";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":matricula", $matricula);
    $stmt->execute();        
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
public function findName($nome){
    $query = "select * from `cadastro` where `nome`=:nome;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":nome", $nome);
    $stmt->execute();        
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
public function findComplete($assunto){
    $query = "SELECT `nome` FROM `cadastro` WHERE `nome` LIKE '%" . $assunto ."%' ORDER BY `nome` ASC LIMIT 5";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function findNomes(){
    $query = "SELECT DISTINCT `nome` FROM `cadastro` ORDER BY `nome` ASC;";
    $stmt = $this->db->prepare($query);
    $stmt->execute();         
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
// get and settes
    function getMatricula() {
        return $this->matricula;
    }

    function getNome() {
        return $this->nome;
    }

    function getSetor() {
        return $this->setor;
    }

    function getEmail() {
        return $this->email;
    }

    function getCargo() {
        return $this->cargo;
    }

    function getNascimento() {
        return $this->nascimento;
    }

    function getAdmissao() {
        return $this->admissao;
    }

    function getEscolaridade() {
        return $this->escolaridade;
    }

    function getStatus() {
        return $this->status;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getSenha() {
        return $this->senha;
    }

    function getSexo() {
        return $this->sexo;
    }
    
    function setMatricula($matricula) {
        $this->matricula = $matricula;
        return $this;
    }

    function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    function setSetor($setor) {
        $this->setor = $setor;
        return $this;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
        return $this;
    }

    function setNascimento($nascimento) {
        $this->nascimento = $nascimento;
        return $this;
    }

    function setAdmissao($admissao) {
        $this->admissao = $admissao;
        return $this;
    }

    function setEscolaridade($escolaridade) {
        $this->escolaridade = $escolaridade;
        return $this;
    }

    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    function setSenha($senha) {
        $this->senha = $senha;
        return $this;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
        return $this;
    }
}