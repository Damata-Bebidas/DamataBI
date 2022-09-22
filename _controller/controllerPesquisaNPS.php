<?php
/**
 * Description of controllerNPS
 *
 * @author welingtonmarquezini
 */
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['NB'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/pesquisaNPS.php';
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
    
    $pesquisa = new pesquisaNPS($conexao);

    $id = trim(strip_tags($REQUEST['id']));
    $NB = trim(strip_tags($REQUEST['NB']));
    $MatFunc = trim(strip_tags($REQUEST['MatFunc']));
    $Data = trim(strip_tags($REQUEST['Data']));
    $Nota = trim(strip_tags($REQUEST['Nota']));
    $Motivo = trim(strip_tags(substr($REQUEST['Motivo'], 0,1)));
    $Comentario = trim(strip_tags($REQUEST['Comentario']));
    
    $pesquisa->setID($id);
    $pesquisa->setNB($NB);
    $pesquisa->setMatFunc($MatFunc);
    $pesquisa->setData($url->converterData($Data));
    $pesquisa->setNota($Nota);
    if ($Nota==5) {
        $pesquisa->setMotivo(NULL);
    } else {
        $pesquisa->setMotivo($Motivo);
    }
    $pesquisa->setComentario(trim($Comentario));
    
    $consulta = $pesquisa->find($NB);
    
    if (isset($REQUEST['excluir'])) {
        $funcao = 3;
    } else {
        $funcao = (count($consulta)==1)? 1  : 2 ;
    }
    
    switch ($funcao) {
        case 1:
            $pesquisa->inserir();
            break;
        case 2:
            $pesquisa->alterar();
            break;
        case 3:
            $pesquisa->deletar($nb);
            break;
        default:
            break;

    }

header("Location: ../nps.php?sucess=true&consultar=" . $NB);exit;