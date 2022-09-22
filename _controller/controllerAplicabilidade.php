<?php
/**
 * Description of controllerAplicabilidade
 *
 * @author welingtonmarquezini
 */
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['id_tr'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/aplicabilidade.php';
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
    
    $aplicabilidade = new aplicabilidade($conexao);

    if (isset($REQUEST['consultar'])) {
        $matriz = array('ADMINISTRATIVO','APOIO LOGÍSTICO',
                    'DISTRIBUIÇÃO URBANA','PUXADA','VENDAS');
        foreach ($matriz as $key => $value) {
            if ($REQUEST['consultar']==$value) {
                $kTR = $REQUEST['tr' . ++$key];
                $kAplic = $REQUEST['aplic' . $key]; 
                header("Location: ../aplic.php?consultar=" . $kTR . "&aplic=" . $kAplic );exit;
            }   
        }
    }


    $total = trim(strip_tags($REQUEST['Total']));

    $treinamento = trim(strip_tags($REQUEST['id_tr']));

    for ($i=0; $i < $total; $i++) { 
        $matricula = trim(strip_tags($REQUEST['matricula' . $i]));
        $status = (isset($REQUEST['status' . $i])) ? trim(strip_tags($REQUEST['status' . $i])) : "" ;
        $key = $matricula . "_" . $treinamento;

        $aplicabilidade->setId_aplic($key);
        $aplicabilidade->setId_tr($treinamento);
        $aplicabilidade->setMatricula($matricula);
        
        $consulta = $aplicabilidade->findAplic($key);
        if ($status<>"") {
            if ($consulta['id_aplic']=="") {
                $funcao = 1;
            } else {
                $funcao = 2;
            }
        } else {
            if (count($consulta)>0) {
                $funcao = 3;
            } else{
                $funcao = 4 ;
            }
        }
    
    switch ($funcao) {
        case 1:
            $aplicabilidade->inserir();
            break;
        case 2:
            $aplicabilidade->alterar();
            break;
        case 3:
            $aplicabilidade->deletar($key);
            break;
        default:
            break;
    }
}

header("Location: ../aplic.php?consultar=" . $REQUEST['nomeTreinamento']);exit;