<?php //ini_set("max_execution_time", 180); //set_time_limit(0);
/**
 * Description of controllerInserirSimulador
 *
 * @author welingtonmarquezini
 */
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/simulador.php';
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
    //sa$saneamento
    $simulador = new simulador($conexao);
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
            $nb = trim($linha->getElementsByTagName("Data")->item(0)->nodeValue); 
            $vasilhame = trim($linha->getElementsByTagName("Data")->item(2)->nodeValue);
            $vasilhame = (trim($vasilhame)=="Refri Litrao") ? "Cerveja Litrao" : $vasilhame ;
            $vasilhame = (trim($vasilhame)=="") ? "Cerveja Litrao" : $vasilhame;
            $descr = trim($linha->getElementsByTagName("Data")->item(3)->nodeValue);
            $descr = (trim($descr)=="") ? "GARRAFEIRA PLAST,12 GFA 1L,AMBEV," : $descr ; 
            $classerisco = trim($linha->getElementsByTagName("Data")->item(4)->nodeValue); 
            $classerisco = ($classerisco=="") ? 6 : $classerisco ;
            $docs = substr(trim($linha->getElementsByTagName("Data")->item(5)->nodeValue),0,1);
            $docs = ($docs=="") ? 'N' : $docs ; 
            $inad = substr(trim($linha->getElementsByTagName("Data")->item(6)->nodeValue),0,1); 
            $inad = (trim($inad)=="" || $inad==0) ? 'N' : $inad;
            $giro = substr(trim($linha->getElementsByTagName("Data")->item(7)->nodeValue),0,1);
            $giro = ($giro==0) ? "O" : $giro ;
            $comodato = trim($linha->getElementsByTagName("Data")->item(8)->nodeValue); 
            $ttcompracxs = trim($linha->getElementsByTagName("Data")->item(9)->nodeValue); 
            $metagiro = trim($linha->getElementsByTagName("Data")->item(10)->nodeValue);
            $metagiro = ($metagiro < 2) ? 2 : $metagiro;

            $simulador->setNb($nb);
            $simulador->setVasilhame($vasilhame);
            $simulador->setDescr($descr);
            $simulador->setClasserisco($classerisco);
            $simulador->setDocs(strtoupper($docs));
            $simulador->setInad($inad);
            $simulador->setGiro($giro);
            $simulador->setComodato($comodato);
            $simulador->setTtcompracxs($ttcompracxs);
            $simulador->setMetagiro($metagiro);
            
            $consulta = $simulador->findStatus($nb,$vasilhame,$descr);

            if (count($consulta)==1) {
               $simulador->inserir();
            } elseif (count($consulta)>1) {
                  //verificar se houve alteracões
                  if ($simulador->getVasilhame()<>$consulta["vasilhame"] 
                  || $simulador->getClasserisco() <> $consulta["classerisco"]
                  || $simulador->getDocs() <> $consulta["docs"]
                  || $simulador->getInad() <> $consulta["inad"]
                  || $simulador->getGiro() <> $consulta["giro"]
                  || $simulador->getComodato() <> $consulta["comodato"]
                  || $simulador->getTtcompracxs() <> $consulta["ttcompracxs"]
               ) {
                  $id = $consulta['id'];
                  $simulador->setId($id);
                  $simulador->alterar();
               }                  
            }
         } 
         $primeira_linha = false;
     }
    }
    header("Location: ../powerbifin.php?sucess=b");exit;