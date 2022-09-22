<?php //conexao
require_once '../_model/urlDb.php';
$url = new UrlBD();
$url->iniciaAPI();
$dsn = $url->getDsn();
$username = $url->getUsername();
$passwd = $url->getPasswd();
try {
    $conexao = new \PDO($dsn, $username, $passwd);//cria conexão com banco de dadosX 
} catch (\PDOException $ex) {
    die('Não foi possível estabelecer '
    . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
}

require_once '../_model/colaborador.php';
$colaborador = new colaborador($conexao);
$assunto = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);
//SQL para selecionar os registro
$result = $colaborador->findComplete($assunto);
foreach ($result as $key => $value) {
    foreach ($value as $key2 => $value2) {
        $data[] = $value2;
    }
}
echo json_encode($data);