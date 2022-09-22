<?php
/**
 * Description of controllerCenso
 *
 * @author welingtonmarquezini
 */
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['setor'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/censo.php';
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
    $censo = new censo($conexao);
    
    
    $setor = trim(strip_tags($REQUEST['setor']));
    $idade = trim(strip_tags($REQUEST['idade']));
    $tempo = trim(strip_tags($REQUEST['tempo']));
    $lider = trim(strip_tags($REQUEST['lider']));
    $estadocivil= trim(strip_tags($REQUEST['estadocivil']));
    $escolaridade= trim(strip_tags($REQUEST['escolaridade']));
    $religiao = trim(strip_tags($REQUEST['religiao']));
    $genero = trim(strip_tags($REQUEST['genero']));
    $orientacaosexual= trim(strip_tags($REQUEST['orientacaosexual']));
    $cor = trim(strip_tags($REQUEST['cor']));
    $nacionalidade = trim(strip_tags($REQUEST['nacionalidade']));
    $naturalidade= trim(strip_tags($REQUEST['naturalidade']));
    $pcd= trim(strip_tags($REQUEST['pcd']));
    $deficiencia = (isset($REQUEST['deficiencia']))?trim(strip_tags($REQUEST['deficiencia'])) : "N" ;
    $politicadiversidade = trim(strip_tags($REQUEST['politica']));
    $importante = trim(strip_tags($REQUEST['Nota']));
    $comentario = trim(strip_tags($REQUEST['Comentario']));
    $funcao = trim(strip_tags($REQUEST['funcao']));
    
    
    $censo->setSetor($setor);
    $censo->setIdade($idade);
    $censo->setTempo($tempo);
    $censo->setLider($lider);
    $censo->setEstadocivil($estadocivil);
    $censo->setEscolaridade($escolaridade);
    $censo->setReligiao($religiao);
    $censo->setGenero($genero);
    $censo->setOrientacaosexual($orientacaosexual);
    $censo->setCor($cor);
    $censo->setNacionalidade($nacionalidade);
    $censo->setNaturalidade($naturalidade);
    $censo->setPcd($pcd);
    $censo->setDeficiencia($deficiencia);
    $censo->setPoliticadiversidade($politicadiversidade);
    $censo->setImportante($importante);
    $censo->setObs($comentario);
    
    switch ($funcao) {
        case 1:
            $censo->inserir();
            break;
        case 2:
            $censo->alterar();
            break;
        case 3:
            $censo->deletar($nb);
            break;
        default:
            break;

    }

header("Location: ../censo.php?sucess=true");exit;