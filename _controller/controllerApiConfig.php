<?php ob_start();//inicio da sessao 
session_start();//inicio da sessao
require_once '../_model/classarquivos.php';
require_once '../_model/session.php'; //consulta
$session = new session();
$session->logarUser();
require_once '../_model/urlDb.php';
    $url = new UrlBD();
    $url->inicia();
    $dsn = $url->getDsn();
    $username = $url->getUsername();
    $passwd = $url->getPasswd();
try {
    $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
} catch (\PDOException $ex) {
    die('Não foi possível estabelecer '
    . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
}
//verificar se esta logado 
require_once '../_model/apiconfig.php';
$api = new apiconfig($conexao);
/* Esta é a maneira correta de se declarar uma superglobal */
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//verificar a rota post ou get
$REQUEST = (isset($post['api'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);

$api->setApi($REQUEST['api']);

$opcao = 1;
switch ($opcao) {
    case 1:
        $api->inserir();
        break;
    break;
}

header("Location: ../financeiro.php");exit;