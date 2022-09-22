<?php
/**
 * Description of controllerSimulador
 * @author welingtonmarquezini
 */
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['qtd'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/analisesimulador.php';
    //conexao
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
    $simulador = new analisesimulador($conexao);
    
    $qtd = trim(strip_tags($REQUEST['qtd']));
    $serasa = trim(strip_tags($REQUEST['serasa']));
    $status = trim(strip_tags($REQUEST['status']));
    $simuladorId = trim(strip_tags($REQUEST['id']));
    $motivo = trim(strip_tags($REQUEST['motivo']));
    $nomeAprovador = trim(strip_tags($REQUEST['autorizado']));
    $nb = trim(strip_tags($REQUEST['nb']));
    $funcao = trim(strip_tags($REQUEST['funcao']));
    $id = (isset($_REQUEST['key']))? trim(strip_tags($REQUEST['key'])): null ;
    
    switch ($nomeAprovador) {
        case 'LUCIANA RIBEIRO':
            $aprovador = 1009;
            break;
        case 'FABIANO A. CALIL':
            $aprovador = 102;
            break;
       case 'FARID CALIL':
            $aprovador = 103;
            break;
       case 'JOSE CARLOS CALIL JR':
            $aprovador = 104;
            break;
       case 'RICARDO CALIL':
            $aprovador = 101;
            break;
       case 'VIRGÍNIA RIBEIRO':
            $aprovador = 100;
            break;
        default:
            $aprovador = null;
            break;
    }
    
    $simulador->setId($id);
    $simulador->setQtd($qtd);
    $simulador->setSerasa($serasa);
    $simulador->setStatus($status);
    $simulador->setSimulador($simuladorId);
    $simulador->setAprovador($aprovador);
    $simulador->setMotivo($motivo);
    
    if (isset($_REQUEST['excluir'])) {
        $funcao = 3;
    }

    switch ($funcao) {
        case 1:
            $simulador->inserir();
            break;
        case 2:
            $simulador->alterar();
            break;
        case 3:
            $simulador->deletar($id);
            break;
        default:
            break;

    }

header("Location: ../simulador.php?sucess=true&find=true");exit;