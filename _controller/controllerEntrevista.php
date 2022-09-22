<?php
/**
 * Description of controllerEntrevista
 *
 * @author welingtonmarquezini
 */
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/entrevista.php';
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
    $entrevista = new entrevista($conexao);
    
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['Mat'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    
    $matricula = trim(strip_tags($REQUEST['Mat']));
    $tipo = strtolower(trim(strip_tags($REQUEST['Tipo'])));
    $data1 = trim(strip_tags($REQUEST['data']));
    $data = $url->converterData($data1);
    $motivo = trim(strip_tags($REQUEST['Motivo']));
    $semjust = trim(strip_tags($REQUEST['semjust']));
    $comprevia = trim(strip_tags($REQUEST['comprevia']));
    $justicomp = trim(strip_tags($REQUEST['justicomp']));
    $acao = trim(strip_tags($REQUEST['Acao']));
    $acatada = trim(strip_tags($REQUEST['acatada']));
    $alinhada = trim(strip_tags($REQUEST['alinhada']));
    $diadescontado = trim(strip_tags($REQUEST['diadescontado']));
    $inicio = trim($url->converterData(strip_tags($REQUEST['Inicio'])));
    $fim = trim($url->converterData(strip_tags($REQUEST['Fim'])));
    $obs = trim(strip_tags($REQUEST['Obs']));
    $id  = $matricula . "_" . date("Y-m-d", strtotime($data));

    $funcao = trim(strip_tags($REQUEST['Funcao']));
    
    $entrevista->setMatricula($matricula);
    $entrevista->setTipo($tipo);
    $entrevista->setData($data);
    $entrevista->setMotivo($motivo);
    $entrevista->setSemjust($semjust);
    $entrevista->setComprevia($comprevia);
    $entrevista->setJusticomp($justicomp);
    $entrevista->setAcao($acao);
    $entrevista->setAcatada($acatada);
    $entrevista->setAlinhada($alinhada);
    $entrevista->setDiadescontado($diadescontado);
    $entrevista->setInicio($inicio);
    $entrevista->setFim($fim);
    $entrevista->setObs($obs);
    $entrevista->setId($id);

switch ($funcao) {
    case 1:
        $entrevista->inserir();
        break;
   case 2:
        $entrevista->alterar();
        break;
   case 3:
        $entrevista->deletar($id);
        break;
   default :
        break;
}
header("Location: ../entrabs.php?sucess=true");exit;