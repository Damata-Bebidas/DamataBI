<?php
/**
 * Description of controllerPlano
 *
 * @author welingtonmarquezini
 */
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/plano.php';
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
    
    $plano = new plano($conexao);
    
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['Funcao'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    
    if (isset($REQUEST['consultar'])) {
        $matriz = array('ADMINISTRATIVO','APOIO LOGÍSTICO',
                    'DISTRIBUIÇÃO URBANA','PUXADA','VENDAS');
        foreach ($matriz as $key => $value) {
            if ($REQUEST['consultar']==$value) {
                $kTR = $REQUEST['tr' . ++$key];
                $kAplic = $REQUEST['aplic' . $key]; 
                header("Location: ../launch.php?tr=" . $kTR . "&aplic=" . $kAplic );exit;
            }   
        }
    }

    if (isset($REQUEST['frequencia'])) {
        $kTR = $REQUEST['tr'];
        $kAplic = $REQUEST['aplic'];
        $kFreq = substr($REQUEST['frequencia'],0,1);
        echo $kFreq;
        if (trim($kAplic)<>"") {
            header("Location: ../launch.php?tr=" . $kTR . "&aplic=" . $kAplic . "&freq=" . $kFreq);
        } else {
            header("Location: ../launch.php?tr=" . $kTR  . "&freq=" . $kFreq);
        }
        exit;
    }
    $funcao = trim(strip_tags($REQUEST['Funcao']));

    $qtd = trim(strip_tags($REQUEST['qtd']));
    $id_tr = trim(strip_tags($REQUEST['id0']));
    $previsao = trim(strip_tags($REQUEST['previsao0']));
    if (isset($REQUEST['conclusao'])) {
        $conclusao = trim(strip_tags($REQUEST['conclusao']));
    }else {
        $conclusao = "";
    }
    if (isset($REQUEST['custo'])) {
        $custo = trim(strip_tags($REQUEST['custo']));
    }else {
        $custo = "DEFAULT";
    }
    if (isset($REQUEST['tipo'])) {
        $tipo = trim(strip_tags($REQUEST['tipo']));
    }else {
        $tipo = "DEFAULT";
    }
    if (isset($REQUEST['lista'])) {
        $lista = trim(strip_tags($REQUEST['lista']));
    }else {
        $lista = "";
    }

    $plano->setId_tr($id_tr); 
    $plano->setPrevisao($url->converterData($previsao));
    $plano->setCusto($custo);
    $plano->setCusto($tipo);
    $plano->setLista($lista);
    $plano->setTipo($tipo);
    
    for ($i=0; $i < $qtd; $i++) { 
        $id_tr = trim(strip_tags($REQUEST['id' . $i]));
        $plano->setId_tr($id_tr);
        $previsao = trim(strip_tags($REQUEST['previsao' . $i]));
        $plano->setPrevisao($url->converterData($previsao));
        $buscarTreinamento = $plano->find($id_tr);
        if (count($buscarTreinamento)==1) {
            $funcao = 1;
        } elseif ($funcao<>2) {
            $funcao = 2;
        }

        switch ($funcao) {
        case 1:
            $plano->inserir();
            break;
        case 2:
            $plano->alterarPlan();
            break;
        case 3:
            $plano->deletar($matricula);
            break;
        default :
            break;
        }   
    }
    header("Location: ../plan.php?success=true&area=" . base64_encode($REQUEST['area']));exit;