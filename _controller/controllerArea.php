<?php
/**
 * Description of controllerArea
 *
 * @author welingtonmarquezini
 */
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['id_area1'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/area.php';
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
    
    $area = new area($conexao);
    $total = trim(strip_tags($REQUEST['Total']));

for ($i=0; $i <= $total; $i++) { 
    
    $idarea = trim(strip_tags($REQUEST['id_area' . $i]));
    $nome = trim(strip_tags($REQUEST['area' . $i])) ;
    $responsavel = trim(strip_tags($REQUEST['id_resp' . $i]));

    $area->setId_area($idarea);
    $area->setNome($nome);
    $area->setMatricula($responsavel);
    
    $consulta = $area->find($idarea);
    if (count($consulta)<=1) {
        $funcao = 1;
    } else {
        $funcao = 2;
    }
    
    switch ($funcao) {
        case 1:
            if (trim($nome)<>"" && trim($responsavel)<>"") {
                $area->inserir();
            }
            break;
        case 2:
            $area->alterar();
            break;
        case 3:
            $area->deletar($idarea);
            break;
    }
}
header("Location: ../cadastro.php?area=true");exit;