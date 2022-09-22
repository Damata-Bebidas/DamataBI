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
/*pasta que vc deseja salvar o arquivo*/
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//verificar a rota post ou get
$REQUEST = (isset($post['nome'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);

$pos = strpos($_FILES['arquivo']['name'],".") - strlen($_FILES['arquivo']['name']);
$extensao = substr($_FILES['arquivo']['name'], $pos);
$novo_nome = $REQUEST['nome'] . "_" .time().$extensao;
$diretorio = "../_fotospontos/";
move_uploaded_file($_FILES['arquivo']['tmp_name'],$diretorio.$novo_nome);

$arquivo = new Arquivos($conexao);
$arquivo->setArquivo($novo_nome);
$data = date("d/m/Y");
$arquivo->setData($data);
$arquivo->setMatricula($REQUEST['mat']);
$arquivo->setTipo($REQUEST['tipo']);
$arq = $arquivo->consultarArquivos($REQUEST['mat']);
$qtd = count($arq);

if ($qtd<1) {
    $opcao = $REQUEST['Funcao'];
} else {
    $opcao = 2;
}

switch ($opcao) {
    case 1:
        $arquivo->inserir();
        break;
    case 2:
        $arquivo->Alterar($arquivo->getMatricula());
    break;
    case 3:
        $arquivo->deletar($arquivo->getMatricula());
    break;
}

header("Location: ../upload.php?up=true");exit;