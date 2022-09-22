<?php //ini_set("max_execution_time", 180); //set_time_limit(0);
/**
 * Description of controllerInserirQLP
 *
 * @author welingtonmarquezini
 */
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/colaborador.php';
    //conexao
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
    //colaborador
    $colaborador = new colaborador($conexao);
    //inicio da importacao do arquivo
    $dados = $_FILES['arquivo'];
   //var_dump($dados);
    if(!empty($_FILES['arquivo']['tmp_name'])){
        $arquivo = new DOMDocument();
        $arquivo->load($_FILES['arquivo']['tmp_name']);
        //var_dump($arquivo);
        $linhas = $arquivo->getElementsByTagName("Row");
 
        $primeira_linha = true;
 
     foreach ($linhas as $linha) {
         if (!$primeira_linha==true) {//1ª Linha <> dela cabeçallho
             $matricula = trim($linha->getElementsByTagName("Data")->item(4)->nodeValue);
             $nome = trim($linha->getElementsByTagName("Data")->item(3)->nodeValue);
             $setor = trim($linha->getElementsByTagName("Data")->item(2)->nodeValue);
             $cargo = trim($linha->getElementsByTagName("Data")->item(11)->nodeValue);
             $nascimentotxt = trim($linha->getElementsByTagName("Data")->item(6)->nodeValue);
             $nascimento = substr($nascimentotxt,0,10);
             $admissaotxt = trim($linha->getElementsByTagName("Data")->item(7)->nodeValue);
             $admissao = substr($admissaotxt,0,10);
             $sexo = trim($linha->getElementsByTagName("Data")->item(5)->nodeValue);
             $statustxt = trim($linha->getElementsByTagName("Data")->item(15)->nodeValue);
             $status = ($statustxt=='AUSENTE') ? "ATIVO" : $statustxt ;
             $email = "";
             $tipo = "BASIC";
             $escolaridade = "-";
             $senha =  date("dmY", strtotime($nascimento)); //criarumasenha

             $colaborador->setAdmissao($admissao);
             $colaborador->setCargo($cargo);
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
             
             $consulta = $colaborador->login($matricula);
             if (count($consulta)==1) {
                $colaborador->inserir();
             } elseif (count($consulta)>1) {
                $colaborador->alterarImport();
             }
         } 
         $primeira_linha = false;
     }
    }
    header("Location: ../cadastro.php");exit;