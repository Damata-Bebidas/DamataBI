<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once '../_model/checkResp.php';
    require_once '../_model/session.php'; //consulta
    require_once '../_model/treinar.php';
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
$prova = new checkResp($conexao);
$treinar = new treinar($conexao);

$id_tr = trim(strip_tags($REQUEST['id_tr']));
$freq = trim(strip_tags($REQUEST['freq']));
$id = trim(strip_tags($REQUEST['matricula']));
$id_key_check = $id_tr . "_" . $freq;
$id_check = $id_key_check . "_" . $id;
$prova->setId_check($id_check);
$prova->setId_key_check($id_key_check);
$prova->setId_tr($id_tr);
$prova->setFreq($freq);
$prova->setMatricula($id);

for ($i=0; $i < 10 ; $i++) { 
    $qt[$i] = (isset($REQUEST['qt' . $i])) ? trim(strip_tags($REQUEST['qt' . $i])) : "" ;
}
$prova->setQt1($qt[0]);
$prova->setQt2($qt[1]);
$prova->setQt3($qt[2]);
$prova->setQt4($qt[3]);
$prova->setQt5($qt[4]);
$prova->setQt6($qt[5]);
$prova->setQt7($qt[6]);
$prova->setQt8($qt[7]);
$prova->setQt9($qt[8]);
$prova->setQt10($qt[9]);

$inserirOuAlterar = $prova->vericarStatus($id_check);
if (isset($REQUEST['optR'])) {
    if ($REQUEST['ReapSN']=="S") {
        $opcao = 3;
    }else{
        $opcao = 4;
    }
    $key = $id_tr . "_" . $freq . "_". $id;
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
        $prova->deletar($key);
    break;
}

$conclusao = date('Y-m-d');
$consultPrevisao = $prova->checkPrevisao($id_tr);
$previsao = $consultPrevisao['previsao'];
$inserirOuAlterarTreinar = $treinar->find($id . "_" . $id_tr . "_" . $freq);

$treinar->setId_tr_freq($id . "_" . $id_tr . "_" . $freq);
$treinar->setId_treinar($id . "_" . $id_tr);
$treinar->setMatricula($id);
$treinar->setId_tr($id_tr);
$treinar->setConclusao($conclusao);
$treinar->setPrevisao($previsao);

if (count($inserirOuAlterarTreinar) <= 1) {
    $opcao = 1;
} else {
    $opcao = 2;
}
switch ($opcao) {
    case 1:
        $treinar->inserir();
        break;
    case 2;
        $treinar->alterar();
        break;
}
if ($REQUEST['exec']=="V") {
    header("Location: ../launch.php?tr=". base64_encode($id_tr) . "&freq=" . $freq);exit;
} else {
    header("Location: ../check.php?tr=". base64_encode($id_tr) . "&freq=" . $freq);exit;
}