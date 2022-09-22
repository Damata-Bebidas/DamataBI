<?php //ini_set("max_execution_time", 180); //set_time_limit(0);
/**
 * Description of controllerInserirBase
 *
 * @author welingtonmarquezini
 */
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    require_once '../_model/saneamento.php';
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
    $saneamento = new saneamento($conexao);
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
             $NB = trim($linha->getElementsByTagName("Data")->item(0)->nodeValue); 
             $Nome = trim($linha->getElementsByTagName("Data")->item(1)->nodeValue);
             $PJ_PF =  substr(trim($linha->getElementsByTagName("Data")->item(2)->nodeValue),0,1);
             $GV = trim($linha->getElementsByTagName("Data")->item(3)->nodeValue); 
             $SV = trim($linha->getElementsByTagName("Data")->item(4)->nodeValue);  
             $VDE = trim($linha->getElementsByTagName("Data")->item(5)->nodeValue); 
             $End = trim($linha->getElementsByTagName("Data")->item(6)->nodeValue); 
             $Compl  = trim($linha->getElementsByTagName("Data")->item(7)->nodeValue); 
             $Bairro = trim($linha->getElementsByTagName("Data")->item(8)->nodeValue); 
             $Cidade = trim($linha->getElementsByTagName("Data")->item(9)->nodeValue); 
             $CEP = trim($linha->getElementsByTagName("Data")->item(10)->nodeValue); 
             $Tel = trim($linha->getElementsByTagName("Data")->item(11)->nodeValue); 
             $Cadastro =  substr(trim($linha->getElementsByTagName("Data")->item(12)->nodeValue),0,10); 
             $UltimaCompra = substr(trim($linha->getElementsByTagName("Data")->item(13)->nodeValue),0,10);
             $Categoria = trim($linha->getElementsByTagName("Data")->item(14)->nodeValue); 
             $Anomalias_txt = trim($linha->getElementsByTagName("Data")->item(15)->nodeValue);
             switch ($Anomalias_txt) {
                case "Telefone Validado?":
                    $Anomalias = "TV";
                    break;
                case "Endereço Duplicado":
                    $Anomalias = "ED";
                    break;
                case "Telefone Validado?":
                    $Anomalias = "TV";
                    break;
                default:
                    $Anomalias = "TV";
                    break;
            }
            $Base = substr(trim($linha->getElementsByTagName("Data")->item(16)->nodeValue),0,1);
            $Tipo = substr(trim($linha->getElementsByTagName("Data")->item(17)->nodeValue),0,1);
            $Status = 1;

             $saneamento->setNB($NB);
             $saneamento->setNome(strtoupper($Nome));
             $saneamento->setPJ_PF($PJ_PF);
             $saneamento->setGV($GV);
             $saneamento->setSV($SV);
             $saneamento->setVDE($VDE);
             $saneamento->setEnd($End);
             $saneamento->setCompl($Compl);
             $saneamento->setBairro($Bairro);
             $saneamento->setCidade($Cidade);
             $saneamento->setCEP($CEP);
             $saneamento->setTel($Tel);
             $saneamento->setCadastro($Cadastro);
             $saneamento->setUltimaCompra($UltimaCompra);
             $saneamento->setCategoria($Categoria);
             $saneamento->setAnomalias($Anomalias);
             $saneamento->setBase($Base);
             $saneamento->setTipo($Tipo);
             $saneamento->setStatus($Status);
             
             $consulta = $saneamento->find($NB);
             
             if (count($consulta)==1) {
                $saneamento->inserir();
             } elseif (count($consulta)>1) {
                //verificar se houve alterações
                if ($saneamento->getEnd() <> $consulta["End"] || $saneamento->getCompl() <> $consulta["Compl"]
                || $saneamento->getBairro() <> $consulta["Bairro"] || $saneamento->getCidade() <> $consulta["Cidade"]
                || $saneamento->getCEP() <> $consulta["CEP"] || $saneamento->getTel() <> $consulta["Tel"]
                || $saneamento->getCategoria() <> $consulta["Categoria"] || $saneamento->getAnomalias() <> $consulta["Anomalias"]
                || $saneamento->getBase() <> $consulta["Base"] || $saneamento->getTipo() <> $consulta["Tipo"]
                || $saneamento->getTipo() <> $consulta["Status"]) {
                    $saneamento->alterar();
                }
                
             }
         } 
         $primeira_linha = false;
     }
    }
header("Location: ../powerbifin.php?sucess=b");exit;