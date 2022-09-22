<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once '../_model/check.php';
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
/* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['id_tr'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
$prova = new check($conexao);

$id_tr = trim(strip_tags($REQUEST['id_tr']));
$freq = trim(strip_tags($REQUEST['freq']));
$Status = trim(strip_tags($REQUEST['status']));
$id_key_check = $id_tr . "_" . $freq;
$instrutor = trim(strip_tags($REQUEST['instrutor']));
$custo = trim(strip_tags($REQUEST['custo']));
$intext = trim(strip_tags($REQUEST['intext']));
for ($i=0; $i < 10 ; $i++) { 
    $id_check = $id_key_check . "_" . $i;
    $Questao = trim(strip_tags($REQUEST['qt'. $i])); 
    $A = trim(strip_tags($REQUEST['qtA' . $i])); 
    $B = trim(strip_tags($REQUEST['qtB' . $i])); 
    $C = trim(strip_tags($REQUEST['qtC' . $i ])); 
    $D = trim(strip_tags($REQUEST['qtD' . $i])); 
    $Gabarito = trim(strip_tags($REQUEST['gab' . $i])); 

    $prova->setId_check($id_check);
    $prova->setId_key_check($id_key_check);
    $prova->setId_tr($id_tr);
    $prova->setFreq($freq);
    $prova->setQuestao($Questao);
    $prova->setA($A);
    $prova->setB($B);
    $prova->setC($C);
    $prova->setD($D);
    $prova->setGabarito(strtoupper($Gabarito));
    $prova->setStatus($Status);
    $prova->setInstrutor($instrutor);
    
    $prova->alterarCustoTipo($custo, $intext);
    $inserirOuAlterar = $prova->vericarStatus($id_check);
    if (trim($Questao)== "" || trim($A)== "" || trim($B)== "" || trim($C)== "" || trim($D)== "" || trim($Gabarito)== "" ) {
        $opcao = 4;
    } else if (count($inserirOuAlterar) <= 1) {
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
            //$prova->deletar($prova->getId());
        break;
    }
}
header("Location: ../checkconfig.php?tr=". base64_encode($id_tr) . "&freq=" . $freq);exit;