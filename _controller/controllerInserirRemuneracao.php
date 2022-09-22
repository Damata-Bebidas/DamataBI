<?php /**
         * Description of controllerInserirRemuneração
         *
         * @author welingtonmarquezini
      */
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/remuneracao.php';
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
    //$conexao = new \PDO("sqlite:api.db") or die("Erro ao abrir a base");
    $remuneracao = new Remuneracao($conexao);
    //inicio da importacao do arquivo
    $dados = $_FILES['arquivo'];
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST = (isset($post['data'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);

   //var_dump($dados);
    if(!empty($_FILES['arquivo']['tmp_name'])){
        $arquivo = new DOMDocument();
        $arquivo->load($_FILES['arquivo']['tmp_name']);
        //var_dump($arquivo);
        $linhas = $arquivo->getElementsByTagName("Row");
 
        $primeira_linha = true;
 
     foreach ($linhas as $linha) {
         if (!$primeira_linha==true) {//1ª Linha <> dela cabeçallho
             $data = trim(strip_tags($REQUEST['data']));
             $matricula_colaborador = trim($linha->getElementsByTagName("Data")->item(0)->nodeValue);
             $setor = substr(trim($linha->getElementsByTagName("Data")->item(2)->nodeValue),0,1);
             $status = substr(trim($linha->getElementsByTagName("Data")->item(3)->nodeValue),0,2);
             $tipo = trim(strip_tags($REQUEST['tipo']));
             $atributo = trim($linha->getElementsByTagName("Data")->item(4)->nodeValue);
             $dias_trabalhados = trim($linha->getElementsByTagName("Data")->item(5)->nodeValue);
             $valor = trim($linha->getElementsByTagName("Data")->item(6)->nodeValue);
             $gratificacao = trim($linha->getElementsByTagName("Data")->item(7)->nodeValue);
             
             $remuneracao->setData($data);
             $remuneracao->setSetor($setor);
             $remuneracao->setTipo($tipo);
             $remuneracao->setMatricula_colaborador($matricula_colaborador);
             $remuneracao->setStatus($status);
             $remuneracao->setDias_trabalhados($dias_trabalhados);
             $remuneracao->setAtributo($atributo);
             $remuneracao->setValor($valor);
             $remuneracao->setGratificacao($gratificacao);

             $consulta = $remuneracao->findData($matricula_colaborador, $data, $tipo);

             if (!$consulta) {
                $remuneracao->inserir();
             } elseif (count($consulta)>1) {
                $remuneracao->alterar();
             }
         } 
         $primeira_linha = false;
     }
    }
    header("Location: ../remuneracao.php?sucess=true");exit;