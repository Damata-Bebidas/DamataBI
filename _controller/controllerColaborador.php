<?php
/**
 * Description of controllerColaborador
 *
 * @author welingtonmarquezini
 */
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/colaborador.php';
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
    $colaborador = new colaborador($conexao);
    
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['Funcao'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    
    $funcao = trim(strip_tags($REQUEST['Funcao']));
    
    $admissao = trim(strip_tags($url->converterData($REQUEST['Admissao'])));
    $cargo = trim(strip_tags($REQUEST['Cargo'])) ;
    $email = strtolower(trim(strip_tags($REQUEST['Email'])));
    $escolaridade = trim(strip_tags($REQUEST['Escola']));
    $matricula = trim(strip_tags($REQUEST['Mat']));
    $nascimento = trim($url->converterData(strip_tags($REQUEST['Nascimento'])));
    $nome = trim(strip_tags($REQUEST['Nome']));
    if (isset($REQUEST['Senha'])) {
        $senha = trim(strip_tags($REQUEST['Senha']));
    } else {
        $senha = "";
    }
    $setor = trim(strip_tags($REQUEST['Setor']));
    $sexo = trim(strip_tags($REQUEST['Sexo']));
    $status = trim(strip_tags($REQUEST['Status']));
    $tipo = trim(strip_tags($REQUEST['Tipo']));
    if (isset($REQUEST['Senha2'])) {
        $senha2 = trim(strip_tags($REQUEST['Senha2']));
    } else {
        $senha2 = "";
    }

    if (!$senha=="") {//diferente de vazio
        $colaborador->getNascimento();
    } else {
        $senha =  date("dmY", strtotime($nascimento)); //criarumasenha
        $senha;
    }

    $colaborador->setAdmissao($admissao);
    $colaborador->setCargo(strtoupper($cargo));
    $colaborador->setEmail(strtolower($email));
    $colaborador->setEscolaridade(strtoupper($escolaridade));
    $colaborador->setMatricula($matricula);
    $colaborador->setNascimento($nascimento);
    $colaborador->setNome(strtoupper($nome));
    $colaborador->setSenha(password_hash($senha, PASSWORD_DEFAULT));
    $colaborador->setSetor(strtoupper($setor));
    $colaborador->setSexo(strtoupper($sexo));
    $colaborador->setStatus(strtoupper($status));
    $colaborador->setTipo(strtoupper($tipo));

    switch ($funcao) {
    case 1:
        $colaborador->inserir();
        break;
   case 2:
        $colaborador->alterar();
        header("Location: ../cadastro.php");exit;
        break;
   case 3:
        $colaborador->deletar($matricula);
        break;
   case 4: 
       if ($senha==$senha2) {
            $colaborador->alterarSenha($colaborador->getSenha(),$colaborador->getMatricula());
       }
       break;
   case 5:
       $consultaData = $colaborador->find($colaborador->getMatricula());
       $senhaReset =  date("dmY", strtotime($consultaData['nascimento']));
       $colaborador->setSenha(password_hash($senhaReset, PASSWORD_DEFAULT));
       $colaborador->alterarSenha($colaborador->getSenha(),$colaborador->getMatricula());
       break;
    default :
        break;
    }
    header("Location: ../user.php");exit;