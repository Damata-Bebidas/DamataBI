<?php
ob_start();//inicio da sessao 
session_start();//inicio da sessao 
require_once '../_model/boleto.php';
//conexao
require_once '../_model/urlDb.php';
$url = new UrlBD();
$url->iniciaAPI();
$dsn = $url->getDsn();
$username = $url->getUsername();
$passwd = $url->getPasswd();
$url->logarUser(); //verificar se esta logado 
try {
    $conexao = new \PDO($dsn, $username, $passwd);//cria conexão com banco de dadosX 
} catch (\PDOException $ex) {
    die('Não foi possível estabelecer '
    . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
}
$boleto = new boleto($conexao);
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
            $numeroDocumento = trim($linha->getElementsByTagName("Data")->item(0)->nodeValue);
            $NB = trim($linha->getElementsByTagName("Data")->item(1)->nodeValue);
            $valor = trim($linha->getElementsByTagName("Data")->item(2)->nodeValue);
            $vencimentotxt = trim($linha->getElementsByTagName("Data")->item(3)->nodeValue);
            $vencimento = substr($vencimentotxt,0,10);
            $danfe = trim($linha->getElementsByTagName("Data")->item(4)->nodeValue);
            $nome = trim($linha->getElementsByTagName("Data")->item(5)->nodeValue);
            $pj_pf = trim($linha->getElementsByTagName("Data")->item(6)->nodeValue);
            $cpf = trim($linha->getElementsByTagName("Data")->item(7)->nodeValue);
            $end = trim($linha->getElementsByTagName("Data")->item(8)->nodeValue);
            $bairro = trim($linha->getElementsByTagName("Data")->item(9)->nodeValue);
            $cidade = trim($linha->getElementsByTagName("Data")->item(10)->nodeValue);
            $uf = trim($linha->getElementsByTagName("Data")->item(11)->nodeValue);
            $cep = trim($linha->getElementsByTagName("Data")->item(12)->nodeValue);
            
            $codigoBarras = "";
            $indicadorBaseCentral = "";

            $boleto->setNumeroDocumento($numeroDocumento);
            $boleto->setNB($NB);
            $boleto->setNome($nome);
            $boleto->setValor($valor);
            $boleto->setVencimento($vencimento);
            $boleto->setDanfe($danfe);
            $boleto->setPj_pf($pj_pf);
            $boleto->setCpf($cpf);
            $boleto->setEnd($end);
            $boleto->setBairro($bairro);
            $boleto->setCidade($cidade);
            $boleto->setUf($uf);
            $boleto->setCep($cep);
            $boleto->setCodigoBarras($codigoBarras);
            $boleto->setIndicadorBaseCentral($indicadorBaseCentral);
            
            $consulta = $boleto->find($numeroDocumento);
            echo "<pre>"; print_r($consulta); echo "</pre>";
            if (count($consulta)==1) {
                $boleto->inserir();
            } elseif (count($consulta)>1) {
                $boleto->alterar();
            }
            echo "<hr/>";
        } 
        $primeira_linha = false;
    }
}
header("Location: ../financeiro.php?find=true");exit;