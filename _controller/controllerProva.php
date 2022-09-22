<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once '../_model/prova3e6meses.php';
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
$prova = new prova3e6meses($conexao);
/* Esta é a maneira correta de se declarar uma superglobal */
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//verificar a rota post ou get
$REQUEST = (isset($post['mat'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
$REQUESTPROVA = (isset($REQUEST['consultarprova'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
if (isset($_REQUEST['consultarprova'])) {
    $nome = (isset($_REQUEST['nome'])) ? trim(strip_tags($_REQUEST['nome'])) : "";
    $cargo = (isset($_REQUEST['cargo'])) ? trim(strip_tags($_REQUEST['cargo'])) : "";
    $tipo = (isset($_REQUEST['tipo'])) ? trim(strip_tags($_REQUEST['tipo'])) : "";
    $findMat = $prova->findMatricula($nome);
    $mat = base64_encode($findMat['matricula']);
    header("Location: ../threeAndSixMonth.php?" . $cargo . "=". substr($cargo,0,1) ."&tipo=" . $tipo . "&mat=" . $mat);exit;
}

$id = (isset($REQUEST['id'])) ? trim(strip_tags($REQUEST['id'])) : "";
$matricula = trim(strip_tags($REQUEST['mat']));
$tipo = trim(strip_tags($REQUEST['tipo']));
$aplicacao = trim(strip_tags($REQUEST['data']));
$cargo = trim(strip_tags($REQUEST['cargo']));
$prova->setId($id);
$prova->setMatricula($matricula);
$prova->setTipo($tipo);
$prova->setAplicacao($url->converterData($aplicacao));
$prova->setCargo(strtoupper($cargo));

for ($i=0; $i < 23 ; $i++) { 
    $qt = (isset($REQUEST['qt' . ($i + 1)])) ? substr(trim(strip_tags($REQUEST['qt' . ($i + 1)])),0,1) : "" ;
    $prova->setQt($qt,$i);
    echo "$i -> $qt<br/>";    
}

if (trim($id)=="") {
    $opcao = 1;
} else {
    $opcao = 2;
}

switch ($opcao) {
    case 1:
        $prova->inserir();
        break;
    case 2;
        $prova->Alterar();
    break;
    case 3:
        $prova->deletar($prova->getId());
    break;
}
header("Location: ../findExam.php?sucess");exit;