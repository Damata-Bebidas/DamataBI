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
            require_once '../_model/plano.php';
            $plano = new plano($conexao);
            $resultado = $plano->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 2:
            require_once '../_model/treinar.php';
            $treinar = new treinar($conexao);
            $resultado = $treinar->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 3:
            require_once '../_model/treinamento.php';
            $treinamentos = new treinamento($conexao);
            $resultado = $treinamentos->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 4:
            require_once '../_model/aplicabilidade.php';
            $aplic = new aplicabilidade($conexao);
            $resultado = $aplic->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 5:
            require_once '../_model/prova3e6meses.php';
            $prova = new prova3e6meses($conexao);
            $resultado = $prova->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 6:
            require_once '../_model/entrevista.php';
            $entrevista = new entrevista($conexao);
            $resultado = $entrevista->listar();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 7:
            require_once '../_model/medclin.php';
            $consulta = new medclin($conexao);
            $resultado = $consulta->listar();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 8:
            require_once '../_model/checkResp.php';
            $consulta = new checkResp($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 9:
            require_once '../_model/checkReacao.php';
            $consulta = new checkReacao($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 10:
            require_once '../_model/check.php';
            $consulta = new check($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 11:
            require_once '../_model/saneamento.php';
            $consulta = new saneamento($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 12:
            require_once '../_model/planobh.php';
            $consulta = new planobh(($conexao));
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 13:
            require_once '../_model/censo.php';
            $consulta = new censo($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 14:
            require_once '../_model/entrada.php';
            $consulta = new entrada($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 15:
            require_once '../_model/penalidades.php';
            $consulta = new penalidades($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 16;
            require_once '../_model/mapeamento.php';
            $consulta = new mapeamento($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 17:
            require_once '../_model/encarreiramento.php';
            $consulta = new encarreiramento($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 18:
            require_once '../_model/remuneracao.php';
            $consulta = new Remuneracao($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 98:
            require_once '../_model/passivo.php';
            $consulta = new passivo($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        case 99:
            require_once '../_model/pesquisaNPS.php';
            $consulta = new pesquisaNPS($conexao);
            $resultado = $consulta->consult();
            echo json_encode($resultado,JSON_PRETTY_PRINT);
            break;
        default:
            echo "Acesso Negado";
            break;
    }