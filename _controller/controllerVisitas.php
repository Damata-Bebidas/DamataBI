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
require_once '../_model/visitas.php';
$visita = new Visitas($conexao);
$data = date("d/m/Y");
/* Esta é a maneira correta de se declarar uma superglobal */
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//verificar a rota post ou get
$REQUEST = (isset($post['cpf'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);

$visita->setCPF($REQUEST['cpf']);
$visita->setNome(strtoupper($REQUEST['nome']));
$visita->setArea($REQUEST['area']);
$visita->setVideo(strtoupper($REQUEST['video']));
$visita->setPlaca(strtoupper($REQUEST['placa']));
$visita->setEquipamento($REQUEST['equipamentos']);
$visita->setData($data);

$opcao = $REQUEST['Funcao'];
switch ($opcao) {
    case 1:
        $visita->inserir();
        break;
    case 2:
        $visita->deletar($visita->getCPF());
    break;
}

header("Location: ../portaria.php?externo=true&cpf=" . $REQUEST['cpf']);exit;