<?php
/**
 * Description of controllerPlanoBH
 *
 * @author welingtonmarquezini
 */
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/planobh.php';
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
    
    $plano = new planobh($conexao);
    $matriculas = array(97,16,1189,116,103,82,45,4,566,827,150,1026,100);
    $gestores = array('ALQUINDAR DA SILVA PEREIRA','ARGEU ANTONIO HENRIQUES','DANILO DOS SANTOS MARTINS',
           'EDUARDO CRUZATO FERRAZ','FARID CALIL','JOSE DOMINGOS SILVA CONTE','JULIO CESAR SILVA XAVIER',
           'JULIO SERGIO CARMO MORAIS','LILIAN DE OLIVEIRA RODRIGUES','MARCOS CESAR MARIANO ZAMBONI',
           'MOYSES PEREIRA BATISTA','RICARDO GONÇALVES GOMES','VIRGÍNIA RIBEIRO'
        );
    //lembrar de alterar tbm na tabela inicial
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['funcao'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    
    $id = (isset($REQUEST['id']))? trim(strip_tags($REQUEST['id'])) : null;
    $mat = trim(strip_tags($REQUEST['mat']));
    $saldo =  trim(strip_tags($REQUEST['saldo']));
    $abatido = trim(strip_tags($REQUEST['abatido']));
    $pagarCompensar = trim(strip_tags($REQUEST['pagarcomp']));
    $data = trim(strip_tags($url->converterData($REQUEST['data'])));
    $status = trim(strip_tags($REQUEST['status']));
    $nomegestor = trim(strip_tags($REQUEST['autorizado']));
    foreach ($gestores as $key => $value) {
        if ($value==$nomegestor) {
            $autorizado = $matriculas[$key];
            break;
        } 
    }
    $obs =  trim(strip_tags($REQUEST['obs']));
    
    $funcao = trim(strip_tags($REQUEST['funcao']));
    
    $plano->setId($id);
    $plano->setMat($mat);
    $plano->setSaldo($saldo);
    $plano->setAbatido($abatido);
    $plano->setPagarCompensar($pagarCompensar);
    $plano->setData($data);
    $plano->setStatus($status);
    $plano->setAutorizado($autorizado);
    $plano->setObs($obs);

    switch ($funcao) {
    case 1:
        $plano->inserir();
        break;
   case 2:
        $plano->alterar();
        break;
   case 3:
        $plano->deletar($matricula);
        break;
    }
    header("Location: ../planodecompensacao.php?sucess=true");exit;