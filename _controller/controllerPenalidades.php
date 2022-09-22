<?php
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$REQUEST = (isset($post['mat'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
ob_start();
session_start();
require_once '../_model/penalidades.php';
require_once '../_model/urlDb.php';
$url = new UrlBD();
$url->inicia();
$dsn = $url->getDsn();
$username = $url->getUsername();
$passwd = $url->getPasswd();

try {
    $conexao = new \PDO($dsn, $username, $passwd);
} catch (\PDOException $ex) {
    die('Não foi possível estabelecer '
    . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
}

$penalidades    = new penalidades($conexao);
$id             = (isset($REQUEST['id'])) ? trim(strip_tags($REQUEST['id'])) : null ;
$colaborador    = (isset($REQUEST['mat'])) ? trim(strip_tags($REQUEST['mat'])) : null ;
$nome    = (isset($REQUEST['Nome'])) ? trim(strip_tags($REQUEST['Nome'])) : null ;
$data           = (isset($REQUEST['data'])) ? trim(strip_tags($REQUEST['data'])) : null ;
$motivo         = (isset($REQUEST['motivo'])) ? trim(strip_tags($REQUEST['motivo'])) : null ;
$tipo           = (isset($REQUEST['tipo'])) ? trim(strip_tags($REQUEST['tipo'])) : null ;
$tipo           = substr($tipo,0,1);
$aplicador      = (isset($REQUEST['aplic'])) ? trim(strip_tags($REQUEST['aplic'])) : null ;
$consultaId     = $penalidades->findNome($aplicador);
$aplicador      = $consultaId['matricula'];

$penalidades->setId($id);
$penalidades->setColaborador($colaborador);
$penalidades->setData($data);
$penalidades->setMotivo($motivo);
$penalidades->setTipo($tipo);
$penalidades->setAplicador($aplicador);

if ($id==0) {
    $funcao = 1;
} else {
    $funcao = 2;
}

switch ($funcao) {
    case 1:
        $penalidades->inserir();
        break;
    case 2:
        $penalidades->alterar();
        break;
    case 3:
        $penalidades->deletar($id);
        break;
}

header("Location: ../penalidades.php?sucess=true&dataconsul=" . $data . "&mat=" . $colaborador . "&consultar=" . $nome . "&btn=Consultar");exit;