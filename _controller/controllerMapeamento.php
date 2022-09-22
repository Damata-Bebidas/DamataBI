<?php
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$REQUEST = (isset($post['mat'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
ob_start();
session_start();
require_once '../_model/mapeamento.php';
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

$mapeamento     = new mapeamento($conexao);

$id             = (isset($REQUEST['id'])) ? trim(strip_tags($REQUEST['id'])) : null ;
$matricula      = (isset($REQUEST['mat'])) ? trim(strip_tags($REQUEST['mat'])) : null ;
$data           = (isset($REQUEST['data'])) ? trim(strip_tags($REQUEST['data'])) : null ;
$tipo           = (isset($REQUEST['tipo'])) ? trim(strip_tags($REQUEST['tipo'])) : null ;
$motivo         = (isset($REQUEST['motivo'])) ? trim(strip_tags($REQUEST['motivo'])) : null ;
$iniciativa     = (isset($REQUEST['iniciativa'])) ? trim(strip_tags($REQUEST['iniciativa'])) : null ;
$ciclo          = (isset($REQUEST['ciclo'])) ? trim(strip_tags($REQUEST['ciclo'])) : null ;
$situacao       = (isset($REQUEST['situacao'])) ? trim(strip_tags($REQUEST['situacao'])) : null ;
$tipo           = substr($tipo,0,1);
$iniciativa     = substr($iniciativa,0,1);
$ciclo          = substr($ciclo,0,1);
$situacao       = substr($situacao,0,1);

$consulta = $mapeamento->find($matricula);

$mapeamento->setId($id);
$mapeamento->setMatricula($matricula);
$mapeamento->setData($data);
$mapeamento->setTipo($tipo);
$mapeamento->setMotivo($motivo);
$mapeamento->setIniciativa($iniciativa);
$mapeamento->setCiclo($ciclo);
$mapeamento->setSituacao($situacao);

if ( is_null($consulta['id'])) {
    $funcao = 1;
} else {
    $funcao = 2;
    $mapeamento->setId($consulta['id']);
}

switch ($funcao) {
    case 1:
        $mapeamento->inserir();
        break;
    case 2:
        $mapeamento->alterar();
        break;
    case 3:
        $mapeamento->deletar($id);
        break;
}

header("Location: ../mapeamento.php?sucess=true");exit;