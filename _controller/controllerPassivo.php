<?php

/**
 * Description of controllerPassivo
 *
 * @author willianmarquezini
 */
/* Esta é a maneira correta de se declarar uma superglobal */
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//verificar a rota post ou get
$REQUEST = (isset($post['Mat'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
ob_start(); //inicio da sessao 
session_start(); //inicio da sessao 
require_once '../_model/passivo.php';
//conexao
require_once '../_model/urlDb.php';
$url = new UrlBD();
$url->inicia();
$dsn = $url->getDsn();
$username = $url->getUsername();
$passwd = $url->getPasswd();
try {
    $conexao = new \PDO($dsn, $username, $passwd); //cria conexão com banco de dadosX 
} catch (\PDOException $ex) {
    die('Não foi possível estabelecer '
            . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
}

$passivo = new passivo($conexao);

// pegar os dados do formulario
$id_numero = (isset($REQUEST['id_numero'])) ? trim(strip_tags($REQUEST['id_numero'])) : NULL;
$forum = (isset($REQUEST['forum'])) ? trim(strip_tags($REQUEST['forum'])) : NULL;
$vara = (isset($REQUEST['vara'])) ? trim(strip_tags($REQUEST['vara'])) : NULL;
$processo = (isset($REQUEST['processo'])) ? trim(strip_tags($REQUEST['processo'])) : NULL;
$reu = (isset($REQUEST['reu'])) ? trim(strip_tags($REQUEST['reu'])) : NULL;
$matricula = (isset($REQUEST['Mat'])) ? trim(strip_tags($REQUEST['Mat'])) : NULL;
$periodo_trabalho_ini = (isset($REQUEST['periodo_trabalho_ini'])) ? trim(strip_tags($REQUEST['periodo_trabalho_ini'])) : NULL;
$periodo_trabalho_fim = (isset($REQUEST['periodo_trabalho_fim'])) ? trim(strip_tags($REQUEST['periodo_trabalho_fim'])) : NULL;
$advogado_reclamante = (isset($REQUEST['advogadoreclamante'])) ? trim(strip_tags($REQUEST['advogadoreclamante'])) : NULL;
$itens_reclamados = (isset($REQUEST['itens_reclamados'])) ? trim(strip_tags($REQUEST['itens_reclamados'])) : NULL;
$valor_requerido = (isset($REQUEST['valor_requerido'])) ? trim(strip_tags($REQUEST['valor_requerido'])) : NULL;
$abertura_processo = (isset($REQUEST['abertura_processo'])) ? trim(strip_tags($REQUEST['abertura_processo'])) : NULL;
$contestacao = (isset($REQUEST['contestacao'])) ? trim(strip_tags($REQUEST['contestacao'])) : NULL;
$reclamados = (isset($REQUEST['reclamados'])) ? trim(strip_tags($REQUEST['reclamados'])) : NULL;
$audiencias = (isset($REQUEST['audiencias'])) ? trim(strip_tags($REQUEST['audiencias'])) : NULL;
$encerramento_processo = (isset($REQUEST['encerramento_processo'])) ? trim(strip_tags($REQUEST['encerramento_processo'])) : NULL;
$fase_processo_reclamados = (isset($REQUEST['fase_processo_reclamados'])) ? trim(strip_tags($REQUEST['fase_processo_reclamados'])) : NULL;
$preposto = (isset($REQUEST['preposto'])) ? trim(strip_tags($REQUEST['preposto'])) : NULL;
$juiz_do_trabalho = (isset($REQUEST['juiz_do_trabalho'])) ? trim(strip_tags($REQUEST['juiz_do_trabalho'])) : NULL;
$testemunhas = (isset($REQUEST['testemunhas'])) ? trim(strip_tags($REQUEST['testemunhas'])) : NULL;
$pericia = (isset($REQUEST['pericia'])) ? trim(strip_tags($REQUEST['pericia'])) : NULL;
$deposito_recursal = (isset($REQUEST['deposito_recursal'])) ? trim(strip_tags($REQUEST['deposito_recursal'])) : NULL;
$valor_acordo = (isset($REQUEST['valor_acordo'])) ? trim(strip_tags($REQUEST['valor_acordo'])) : NULL;
$sentenca = (isset($REQUEST['sentenca'])) ? trim(strip_tags($REQUEST['sentenca'])) : NULL;
$recurso_ordinario = (isset($REQUEST['recurso_ordinario'])) ? trim(strip_tags($REQUEST['recurso_ordinario'])) : NULL;
$recurso_revista = (isset($REQUEST['recurso_revista'])) ? trim(strip_tags($REQUEST['recurso_revista'])) : NULL;
$status = (isset($REQUEST['status'])) ? trim(strip_tags($REQUEST['status'])) : NULL;
$status = strtoupper(substr($status,0,1));
$status_processo = (isset($REQUEST['status_processo'])) ? trim(strip_tags($REQUEST['status_processo'])) : NULL;
$status_processo = strtoupper(substr($status_processo,0,1));
$data = (isset($REQUEST['data'])) ? trim(strip_tags($REQUEST['data'])) : NULL;
$pareto = (isset($REQUEST['pareto'])) ? trim(strip_tags($REQUEST['pareto'])) : NULL;
$pareto = strtoupper(substr($pareto,0,2));
$funcao = (isset($REQUEST['Funcao'])) ? trim(strip_tags($REQUEST['Funcao'])) : NULL;
$nome = (isset($REQUEST['Nome'])) ? trim(strip_tags($REQUEST['Nome'])) : NULL;
$periodo_trabalho_ini = ($periodo_trabalho_ini=='') ? date('Y-m-d') : $periodo_trabalho_ini;
$periodo_trabalho_fim = ($periodo_trabalho_fim=='') ? date('Y-m-d') : $periodo_trabalho_fim;
$abertura_processo =  ($abertura_processo=='') ? date('Y-m-d') : $abertura_processo;
$contestacao = ($contestacao=='') ? date('Y-m-d') : $contestacao;

//setar valores
$passivo->setId_numero($id_numero);
$passivo->setForum($forum);
$passivo->setVara($vara);
$passivo->setProcesso($processo);
$passivo->setReu($reu);
$passivo->setMatricula($matricula);
$passivo->setPeriodo_trabalho_ini($periodo_trabalho_ini);
$passivo->setPeriodo_trabalho_fim($periodo_trabalho_fim);
$passivo->setAdvogado_reclamante($advogado_reclamante);
$passivo->setItens_reclamados($itens_reclamados);
$passivo->setValor_requerido($valor_requerido);
$passivo->setAbertura_processo($abertura_processo);
$passivo->setContestacao($contestacao);
$passivo->setEncerramento_processo($encerramento_processo);
$passivo->setFase_processo_reclamados($fase_processo_reclamados);
$passivo->setReclamados($reclamados);
$passivo->setAudiencias($audiencias);
$passivo->setPreposto($preposto);
$passivo->setJuiz_do_trabalho($juiz_do_trabalho);
$passivo->setTestemunhas($testemunhas);
$passivo->setPericia($pericia);
$passivo->setDeposito_recursal($deposito_recursal);
$passivo->setValor_acordo($valor_acordo);
$passivo->setSentenca($sentenca);
$passivo->setRecurso_ordinario($recurso_ordinario);
$passivo->setRecurso_revista($recurso_revista);
$passivo->setStatus($status);
$passivo->setStatus_processo($status_processo);
$passivo->setData($data);
$passivo->setPareto($pareto);

switch ($funcao) {
    case 1:
        $passivo->inserir();
        break;
    case 2:
        $passivo->alterar();
        break;
    case 3:
        $passivo->deletar($key);
        break;
    default:
        break;
}

header("Location: ../passivo.php?sucess=true&find=true&consultar=" . $nome);
exit;
