<?php
/**
 * Description of controllertreinamento
 *
 * @author welingtonmarquezini
 */
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/treinamento.php';
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
    $treinamento = new treinamento($conexao);
  
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['id_tr'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    
    if (isset($REQUEST['validade'])) {
        $validade = $REQUEST['validade'];

    }

    $id_tr = trim(strip_tags($REQUEST['id_tr']));
    $nometreinamento = trim(strip_tags($REQUEST['nome']));
    $cargos = trim(strip_tags($REQUEST['cargos'])) ;
    $frequencia = strtolower(trim(strip_tags($REQUEST['frequencia'])));
    $responsavel = trim(strip_tags($REQUEST['reponsavel']));
    $carga = trim(strip_tags($REQUEST['carga']));
    $id_area = trim(strip_tags($REQUEST['area']));
    
    if (isset($REQUEST['validade'])) {
        $validade = $url->converterData($REQUEST['validade']);
        $treinamento->AlterarVencimento($validade,$id_tr);
    }

    $treinamento->setId_tr($id_tr);
    $treinamento->setTreinamento($nometreinamento);
    $treinamento->setCargos($cargos);
    $treinamento->setFrequencia($frequencia);
    $treinamento->setResponsavel($responsavel);
    $treinamento->setCarga($carga);
    $treinamento->setId_area($id_area);

    $areas = array('SEGURANCA','GENTE','GESTAO','COMERCIAL','FINANCEIRO','ENTREGA','ARMAZEM','PLANEJAMENTO','FROTA','NIVEL DE SERVICO');
    foreach ($areas as $key => $value) {
        if ($value==$id_area) {
            $treinamento->setId_area(++$key);
        }
    }
    $funcao = trim(strip_tags($REQUEST['Funcao']));

    switch ($funcao) {
    case 1:
        $vencimento1 = $treinamento->findMax();
        $max[] = $vencimento1['MAX(id_tr)'];//posicao 1
        $treinamento->inserir();
        $vencimento2 = $treinamento->findMax();
        $max[] = $vencimento2['MAX(id_tr)'];//posicao 2
        if ($max[0]<$max[1]) {//se for  > que outro max faca o valor
            $id_tr = $max[1];
            $treinamento->IncluirVencimento($id_tr);
        }
        break;
   case 2:
        $treinamento->alterar();
        break;
   case 3:
        $treinamento->deletar($id_tr);
        break;
    default :
        break;
    }
    header("Location: ../cadconfig.php");exit;