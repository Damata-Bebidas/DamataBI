<?php
/**
 * Description of controllerTreinar
 *
 * @author welingtonmarquezini
 */
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/treinar.php';
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
    $treinar = new treinar($conexao);
    
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['matricula0'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    
    $funcao = trim(strip_tags($REQUEST['Funcao']));
    $qtd = trim(strip_tags($REQUEST['qtd']));
    $status = trim(strip_tags($REQUEST['status0']));

    $matricula = trim(strip_tags($REQUEST['matricula0']));
    $id_tr = trim(strip_tags(base64_decode($REQUEST['tr'])));
    $conclusao = $url->converterData(trim(strip_tags($REQUEST['data0'])));
    $previsao = $url->converterData(trim(strip_tags($REQUEST['prev'])));
    $freq = trim(strip_tags($REQUEST['freq']));
    $id_treinar = $matricula . "_" . $id_tr;
    $id_treinar_freq = $id_treinar . "_" . $freq; 

    $treinar->setId_tr_freq($id_treinar_freq);
    $treinar->setId_treinar($id_treinar);
    $treinar->setMatricula($matricula);
    $treinar->setId_tr($id_tr);
    $treinar->setConclusao($url->converterData($conclusao));
    $treinar->setPrevisao($url->converterData($previsao));
    
    for ($i=0; $i < $qtd ; $i++) { 
        $matricula = trim(strip_tags($REQUEST['matricula' . $i]));
        $id_treinar = $matricula . "_" . $id_tr;
        $id_treinar_freq = $id_treinar . "_" . $freq;
        $treinar->setMatricula($matricula);
        $treinar->setId_treinar($id_treinar);
        $treinar->setId_tr_freq($id_treinar_freq);

        $conclusao = $url->converterData(trim(strip_tags($REQUEST['data' . $i])));
        $treinar->setConclusao($conclusao);
        $buscarTreinamento = $treinar->find($id_treinar_freq);
        $exect = isset($REQUEST['status'. $i]) ? true : false;
        if (count($buscarTreinamento)==1) {
            $funcao = 1;
        } elseif ($funcao<>2) {
            if ($exect) {
                $funcao = 2;
            } else {
                $funcao = 3;
            }
        }
        
        switch ($funcao) {
        case 1:
            if ($exect) {
                $treinar->inserir();
            }
            break;
        case 2:
            if ($exect) {
                $treinar->alterar();
            }
            break;
        case 3:
            $treinar->deletar($id_treinar_freq);
            break;
        default :
            break;
        } 
    }
    header("Location: ../launch.php?success=true&tr=" . $REQUEST['tr'] . "&freq=" . $REQUEST['freq']);exit; 