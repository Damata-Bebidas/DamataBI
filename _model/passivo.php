<?php
/**
 * Description of passivo
 *
 * @author Willian
 * @Revisor Welingto Marquezini
 */
require_once 'crudBasic.php';
class passivo implements crudBasic {
     private $db,$id_numero,$forum,$vara,$processo,$reu,$matricula,
    $periodo_trabalho_ini,$periodo_trabalho_fim,$advogado_reclamante,$itens_reclamados,$valor_requerido,
    $abertura_processo,$contestacao,$encerramento_processo,$fase_processo_reclamados,$reclamados,$audiencias,
    $preposto,$juiz_do_trabalho,$testemunhas,$pericia,$deposito_recursal,$valor_acordo,$sentenca,
    $recurso_ordinario,$recurso_revista,$status,$status_processo,$data,$pareto;
//construtor
function __construct(\PDO $db) {
    $this->db = $db;
}
//queries
    public function consult() {
        $query = "SELECT * FROM `passivo`;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function find($id) {
        $query = "SELECT * FROM `passivo` WHERE `matricula`= :id ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id",$id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findPassivo($id) {
        $query = "SELECT * FROM `passivo` WHERE `Id_numero`= :id ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id",$id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function inserir() {
         $query = "INSERT INTO `passivo`(`forum`,`vara`,`processo`,"
                 . "`reu`,`matricula`,`periodo_trabalho_ini`,"
                 . "`periodo_trabalho_fim`,`advogado_reclamante`,`itens_reclamados`,"
                 . "`valor_requerido`,`abertura_processo`,`contestacao`,`encerramento_processo`,"
                 . "`fase_processo_reclamados`,`reclamados`,`audiencias`,`preposto`,"
                 . "`juiz_do_trabalho`,`testemunhas`,`pericia`,`deposito_recursal`,`valor_acordo`,"
                 . "`sentenca`,`recurso_ordinario`,`recurso_revista`,`status`,`status_processo`,`data`,`pareto`) "
                 . "VALUES (:forum,:vara,:processo,:reu,:matricula,:periodo_trabalho_ini,"
                 . ":periodo_trabalho_fim,:advogado_reclamante,:itens_reclamados,:valor_requerido,:abertura_processo,"
                 . ":contestacao,:encerramento_processo,:fase_processo_reclamados,:reclamados,:audiencias,:preposto,"
                 . ":juiz_do_trabalho,:testemunhas,:pericia,:deposito_recursal,:valor_acordo,"
                 . ":sentenca,:recurso_ordinario,:recurso_revista,:status,:status_processo,:data,:pareto);";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':forum',$this->getForum() );
            $stmt->bindValue(':vara',$this->getVara() );
            $stmt->bindValue(':processo',$this->getProcesso());
            $stmt->bindValue(':reu',$this->getReu());
            $stmt->bindValue(':matricula',$this->getMatricula());
            $stmt->bindValue(':periodo_trabalho_ini',$this->getPeriodo_trabalho_ini());
            $stmt->bindValue(':periodo_trabalho_fim',$this->getPeriodo_trabalho_fim());
            $stmt->bindValue(':advogado_reclamante',$this->getAdvogado_reclamante());
            $stmt->bindValue(':itens_reclamados',$this->getItens_reclamados());
            $stmt->bindValue(':valor_requerido',$this->getValor_requerido());
            $stmt->bindValue(':abertura_processo',$this->getAbertura_processo());
            $stmt->bindValue(':contestacao',$this->getContestacao());
            $stmt->bindValue(':encerramento_processo',$this->getEncerramento_processo());
            $stmt->bindValue(':fase_processo_reclamados',$this->getFase_processo_reclamados());
            $stmt->bindValue(':reclamados', $this->getReclamados());
            $stmt->bindValue(':audiencias',$this->getAudiencias());
            $stmt->bindValue(':preposto',$this->getPreposto());
            $stmt->bindValue(':juiz_do_trabalho',$this->getJuiz_do_trabalho());
            $stmt->bindValue(':testemunhas',$this->getTestemunhas());
            $stmt->bindValue(':pericia',$this->getPericia());
            $stmt->bindValue(':deposito_recursal', $this->getDeposito_recursal());
            $stmt->bindValue(':valor_acordo',$this->getValor_acordo());
            $stmt->bindValue(':sentenca', $this->getSentenca());
            $stmt->bindvalue(':recurso_ordinario',$this->getRecurso_ordinario());
            $stmt->bindValue(':recurso_revista',$this->getRecurso_revista());
            $stmt->bindvalue(':status', $this->getStatus());
            $stmt->bindvalue(':status_processo',$this->getStatus_processo());
            $stmt->bindValue(':data', $this->getData());
            $stmt->bindvalue(':pareto',$this->getPareto());
            $stmt->execute();
    }
    
    public function alterar() {
    $query = "UPDATE `passivo` SET `forum`=:forum,"
            . "`vara`=:vara,`processo`=:processo,`reu`=:reu,"
            . "`matricula`=:matricula,`periodo_trabalho_ini`=:periodo_trabalho_ini,"
            . "`periodo_trabalho_fim`=:periodo_trabalho_fim,`advogado_reclamante`=:advogado_reclamante,`itens_reclamados`=:itens_reclamados,"
            . "`valor_requerido`=:valor_requerido,`abertura_processo`=:abertura_processo,`contestacao`=:contestacao,`encerramento_processo`=:encerramento_processo,"
            . "`fase_processo_reclamados`=:fase_processo_reclamados,`reclamados`=:reclamados,`audiencias`=:audiencias,`preposto`=:preposto,`juiz_do_trabalho`=:juiz_do_trabalho,"
            . "`testemunhas`=:testemunhas,`pericia`=:pericia,`deposito_recursal`=:deposito_recursal,`valor_acordo`=:valor_acordo,`sentenca`=:sentenca,"
            . "`recurso_ordinario`=:recurso_ordinario,`recurso_revista`=:recurso_revista,`status`=:status,`status_processo`=:status_processo,"
            . "`data`=:data_processo , `pareto` = :pareto_processo "
            . "where `Id_numero` = :id;";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':forum',$this->getForum() );
        $stmt->bindValue(':vara',$this->getVara() );
        $stmt->bindValue(':processo',$this->getProcesso());
        $stmt->bindValue(':reu',$this->getReu());
        $stmt->bindValue(':matricula',$this->getMatricula());
        $stmt->bindValue(':periodo_trabalho_ini',$this->getPeriodo_trabalho_ini());
        $stmt->bindValue(':periodo_trabalho_fim',$this->getPeriodo_trabalho_fim());
        $stmt->bindValue(':advogado_reclamante',$this->getAdvogado_reclamante());
        $stmt->bindValue(':itens_reclamados',$this->getItens_reclamados());
        $stmt->bindValue(':valor_requerido',$this->getValor_requerido());
        $stmt->bindValue(':abertura_processo',$this->getAbertura_processo());
        $stmt->bindValue(':contestacao',$this->getContestacao());
        $stmt->bindValue(':encerramento_processo',$this->getEncerramento_processo());
        $stmt->bindValue(':fase_processo_reclamados',$this->getFase_processo_reclamados());
        $stmt->bindValue(':reclamados', $this->getReclamados());
        $stmt->bindValue(':audiencias',$this->getAudiencias());
        $stmt->bindValue(':preposto',$this->getPreposto());
        $stmt->bindValue(':juiz_do_trabalho',$this->getJuiz_do_trabalho());
        $stmt->bindValue(':testemunhas',$this->getTestemunhas());
        $stmt->bindValue(':pericia',$this->getPericia());
        $stmt->bindValue(':deposito_recursal', $this->getDeposito_recursal());
        $stmt->bindValue(':valor_acordo',$this->getValor_acordo());
        $stmt->bindValue(':sentenca', $this->getSentenca());
        $stmt->bindvalue(':recurso_ordinario',$this->getRecurso_ordinario());
        $stmt->bindValue(':recurso_revista',$this->getRecurso_revista());
        $stmt->bindvalue(':status', $this->getStatus());
        $stmt->bindvalue(':status_processo',$this->getStatus_processo());
        $stmt->bindValue(':data_processo', $this->getData());
        $stmt->bindvalue(':pareto_processo',$this->getPareto());
        $stmt->bindvalue(':id',$this->getId_numero());
        if($stmt->execute()){
            return true;
        }
}

public function deletar($id) {
    $query = "DELETE FROM `passivo` WHERE `id_numero`=:id_numero;";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id_numero', $id);
    if($stmt->execute()){
        return true;
    }
}
    
//getter e setts
    public function getId_numero() {
        return $this->id_numero;
    }

    public function getForum() {
        return $this->forum;
    }

    public function getVara() {
        return $this->vara;
    }

    public function getProcesso() {
        return $this->processo;
    }

    public function getReu() {
        return $this->reu;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getPeriodo_trabalho_ini() {
        return $this->periodo_trabalho_ini;
    }

    public function getPeriodo_trabalho_fim() {
        return $this->periodo_trabalho_fim;
    }

    public function getAdvogado_reclamante() {
        return $this->advogado_reclamante;
    }

    public function getItens_reclamados() {
        return $this->itens_reclamados;
    }

    public function getValor_requerido() {
        return $this->valor_requerido;
    }

    public function getAbertura_processo() {
        return $this->abertura_processo;
    }

    public function getContestacao() {
        return $this->contestacao;
    }

    public function getEncerramento_processo() {
        return $this->encerramento_processo;
    }

    public function getFase_processo_reclamados() {
        return $this->fase_processo_reclamados;
    }

    public function getReclamados() {
        return $this->reclamados;
    }

    public function getAudiencias() {
        return $this->audiencias;
    }

    public function getPreposto() {
        return $this->preposto;
    }

    public function getJuiz_do_trabalho() {
        return $this->juiz_do_trabalho;
    }

    public function getTestemunhas() {
        return $this->testemunhas;
    }

    public function getPericia() {
        return $this->pericia;
    }

    public function getDeposito_recursal() {
        return $this->deposito_recursal;
    }

    public function getValor_acordo() {
        return $this->valor_acordo;
    }

    public function getSentenca() {
        return $this->sentenca;
    }

    public function getRecurso_ordinario() {
        return $this->recurso_ordinario;
    }

    public function getRecurso_revista() {
        return $this->recurso_revista;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getStatus_processo() {
        return $this->status_processo;
    }

    public function getData() {
        return $this->data;
    }

    public function getPareto() {
        return $this->pareto;
    }

    public function setId_numero($id_numero) {
        $this->id_numero = $id_numero;
        return $this;
    }

    public function setForum($forum) {
        $this->forum = $forum;
        return $this;
    }

    public function setVara($vara) {
        $this->vara = $vara;
        return $this;
    }

    public function setProcesso($processo) {
        $this->processo = $processo;
        return $this;
    }

    public function setReu($reu) {
        $this->reu = $reu;
        return $this;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
        return $this;
    }

    public function setPeriodo_trabalho_ini($periodo_trabalho_ini) {
        $this->periodo_trabalho_ini = $periodo_trabalho_ini;
        return $this;
    }

    public function setPeriodo_trabalho_fim($periodo_trabalho_fim) {
        $this->periodo_trabalho_fim = $periodo_trabalho_fim;
        return $this;
    }

    public function setAdvogado_reclamante($advogado_reclamante) {
        $this->advogado_reclamante = $advogado_reclamante;
        return $this;
    }

    public function setItens_reclamados($itens_reclamados) {
        $this->itens_reclamados = $itens_reclamados;
        return $this;
    }

    public function setValor_requerido($valor_requerido) {
        $this->valor_requerido = $valor_requerido;
        return $this;
    }

    public function setAbertura_processo($abertura_processo) {
        $this->abertura_processo = $abertura_processo;
        return $this;
    }

    public function setContestacao($contestacao) {
        $this->contestacao = $contestacao;
        return $this;
    }

    public function setEncerramento_processo($encerramento_processo) {
        $this->encerramento_processo = $encerramento_processo;
        return $this;
    }

    public function setFase_processo_reclamados($fase_processo_reclamados) {
        $this->fase_processo_reclamados = $fase_processo_reclamados;
        return $this;
    }

    public function setReclamados($reclamados) {
        $this->reclamados = $reclamados;
        return $this;
    }

    public function setAudiencias($audiencias) {
        $this->audiencias = $audiencias;
        return $this;
    }

    public function setPreposto($preposto) {
        $this->preposto = $preposto;
        return $this;
    }

    public function setJuiz_do_trabalho($juiz_do_trabalho) {
        $this->juiz_do_trabalho = $juiz_do_trabalho;
        return $this;
    }

    public function setTestemunhas($testemunhas) {
        $this->testemunhas = $testemunhas;
        return $this;
    }

    public function setPericia($pericia) {
        $this->pericia = $pericia;
        return $this;
    }

    public function setDeposito_recursal($deposito_recursal) {
        $this->deposito_recursal = $deposito_recursal;
        return $this;
    }

    public function setValor_acordo($valor_acordo) {
        $this->valor_acordo = $valor_acordo;
        return $this;
    }

    public function setSentenca($sentenca) {
        $this->sentenca = $sentenca;
        return $this;
    }

    public function setRecurso_ordinario($recurso_ordinario) {
        $this->recurso_ordinario = $recurso_ordinario;
        return $this;
    }

    public function setRecurso_revista($recurso_revista) {
        $this->recurso_revista = $recurso_revista;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setStatus_processo($status_processo) {
        $this->status_processo = $status_processo;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function setPareto($pareto) {
        $this->pareto = $pareto;
        return $this;
    }
}