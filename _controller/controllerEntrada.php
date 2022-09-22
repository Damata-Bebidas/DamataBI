<?php
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$REQUEST = (isset($post['Mat'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
ob_start();//inicio da sessao 
session_start();//inicio da sessao 
require_once '../_model/entrada.php';
require_once '../_model/urlDb.php';
$url = new UrlBD();
$url->inicia();
$dsn = $url->getDsn();
$username = $url->getUsername();
$passwd = $url->getPasswd();
try {
    $conexao = new \PDO($dsn, $username, $passwd);//cria conexão com banco de dadosX 
} catch (\PDOException $ex) {
    die('Não foi possível estabelecer '
    . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
}

$entrada = new entrada($conexao);
$matricula = (isset($REQUEST['Mat'])) ? trim(strip_tags($REQUEST['Mat'])) : null ;
$hora = (isset($REQUEST['hora'])) ? trim(strip_tags($REQUEST['hora'])) : null ;

$entrada->setMatricula($matricula);
$entrada->setHora($hora);
$consulta = $entrada->find($matricula);

if (!$consulta) {
    $funcao = 1;
} else {
    $funcao = 2;
}

switch ($funcao) {
    case 1:
        $entrada->inserir();
        break;
    case 2:
        $entrada->alterar();
        break;
    case 3:
        $entrada->deletar($matricula);
        break;
}

header("Location: ../entrada.php?sucess=true");exit;