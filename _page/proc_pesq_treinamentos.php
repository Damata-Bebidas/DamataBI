<?php //conexao
require_once '../_model/UrlDb.php';
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

require_once '../_model/treinamento.php';
$treinamento = new treinamento($conexao);
$assunto = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);
//SQL para selecionar os registro
$result = $treinamento->findComplete($assunto);
foreach ($result as $key => $value) {
    foreach ($value as $key2 => $value2) {
        $data[] = $value2;
    }
}
echo json_encode($data);