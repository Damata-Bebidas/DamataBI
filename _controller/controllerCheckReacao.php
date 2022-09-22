<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once '../_model/checkReacao.php';
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
$prova = new checkReacao($conexao);

$id_tr = trim(strip_tags($REQUEST['id_tr']));
$freq = trim(strip_tags($REQUEST['freq']));
$id = trim(strip_tags($REQUEST['matricula']));
$obs = trim(strip_tags($REQUEST['obs']));
$id_key_check = $id_tr . "_" . $freq;
$id_check = $id_key_check . "_" . $id;
$prova->setId_check($id_check);
$prova->setId_key_check($id_key_check);
$prova->setId_tr($id_tr);
$prova->setFreq($freq);
$prova->setMatricula($id);
$prova->setObs($obs);
$w = 0;

for ($c=1; $c <= 3 ; $c++) {
    switch ($c) {
        case 1:
            for ($i=1; $i <= 2 ; $i++) {
                $qt[$w] = (isset($REQUEST['opt' . $c . '_' . $i])) ? trim(strip_tags($REQUEST['opt' . $c . '_' . $i])) : "" ;
                $w++;
            }
            break;
        case 2:
            for ($i=1; $i <= 3 ; $i++) {
                $qt[$w] = (isset($REQUEST['opt' . $c . '_' . $i])) ? trim(strip_tags($REQUEST['opt' . $c . '_' . $i])) : "" ;
                $w++;
            }
            break;
        case 3:
            for ($i=1; $i <= 5 ; $i++) {
                $qt[$w] = (isset($REQUEST['opt' . $c . '_' . $i])) ? trim(strip_tags($REQUEST['opt' . $c . '_' . $i])) : "" ;
                $w++;
            }
            break;
    }
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

$opcao = 1;
$prova->inserir();
header("Location: ../check.php?tr=". base64_encode($id_tr) . "&freq=" . $freq);exit;