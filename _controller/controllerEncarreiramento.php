<?php
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$REQUEST = (isset($post['mat'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
ob_start();
session_start();
require_once '../_model/encarreiramento.php';
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

$encarreiramento = new encarreiramento($conexao);

$id             = (isset($REQUEST['id'])) ? trim(strip_tags($REQUEST['id'])) : null ;
$matricula      = (isset($REQUEST['mat'])) ? trim(strip_tags($REQUEST['mat'])) : null ;
$data           = (isset($REQUEST['data'])) ? trim(strip_tags($REQUEST['data'])) : null ;
$cargo          = (isset($REQUEST['cargo'])) ? trim(strip_tags($REQUEST['cargo'])) : null ;

$encarreiramento->setId($id);
$encarreiramento->setMatricula($matricula);
$encarreiramento->setData($data);
$encarreiramento->setCargo($cargo);

if ($id==0 || $id==null) {
    $funcao = 1;
} else {
    $funcao = 2;
}

switch ($funcao) {
    case 1:
        $encarreiramento->inserir();
        break;
    case 2:
        $encarreiramento->alterar();
        break;
    case 3:
        $encarreiramento->deletar($id);
        break;
}

header("Location: ../encarreiramento.php?sucess=true");exit;