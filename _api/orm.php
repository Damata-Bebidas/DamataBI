<?php //api para pegar os dados
    require_once '../_model/urlDb.php';
    $url = new UrlBD();
    $url->iniciaAPI();
    $dsn = $url->getDsn();
    $username = $url->getUsername();
    $passwd = $url->getPasswd();
    try {
        $conexao = new \PDO($dsn, $username, $passwd);//cria conexão com banco de dadosX 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }

    header('Content-Type: application/json; charset=utf-8');
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou ger
    $REQUEST = (isset($post['w'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    $option = (isset($REQUEST['w'])) ? base64_decode($REQUEST['w']) : false;
    switch ($option) {
        case 1:
            require_once '../_model/orm.php';
            $orm = new orm($conexao);
            $resultado = $orm->inserir();
            $matriz[] = array('ORM Inserir', date('d/m/Y h:i:s'));
            echo json_encode($matriz[0],JSON_PRETTY_PRINT);
            break;
        case 2:
            require_once '../_model/orm.php';
            $orm = new orm($conexao);
            $resultado = $orm->alterar();
            $matriz[] = array('ORM Alterar', date('d/m/Y h:i:s'));
            echo json_encode($matriz[0],JSON_PRETTY_PRINT);
            break;
        case 3:
            require_once '../_model/orm.php';
            $orm = new orm($conexao);
            $id = base64_decode("Mw==");
            $resultado = $orm->deletar($id);
            $matriz[] = array('ORM Deletar', date('d/m/Y h:i:s'));
            echo json_encode($matriz[0],JSON_PRETTY_PRINT);
            break;
        case 4:
            require_once '../_model/orm.php';
            $orm = new orm($conexao);
            $id = base64_decode("NA==");
            $resultado = $orm->find($id);
            $matriz[] = array('ORM dados', date('d/m/Y h:i:s'));
            echo json_encode($matriz[0],JSON_PRETTY_PRINT);
            break;
        case 5:
            require_once '../_model/orm.php';
            $orm = new orm($conexao);
            $resultado = $orm->consult();
            $matriz[] = array('ORM Consult', date('d/m/Y h:i:s'));
            echo json_encode($matriz[0],JSON_PRETTY_PRINT);
            break;
        default:
            echo "Acesso Negado";
            break;
    }