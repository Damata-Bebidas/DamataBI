<?php
require_once '../_model/boleto.php';
require_once '../_apisafra/safra.php';
require_once '../_model/apiconfig.php';
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
$boleto = new boleto($conexao);
$safra = new safra();
$data  = date('Y-m-d');
$resultado = $boleto->listarRecentesTT($data);

$apiconfig = new apiconfig($conexao);
$resultadoconfig = $apiconfig->consult();
$config = $resultadoconfig['api'];
/* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou ger
    $REQUEST = (isset($post['w'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
if (isset($REQUEST['w'])) {
    $exect = base64_decode($REQUEST['w']);//w=MQ==
}

if ($exect==1 && $config=='Safra') {
    foreach ($resultado as $key => $value) {
        $id = $value['numDoc'];
        $nb = $value['NB'];
        $safra->setNumero($id);
        $safra->setCliente($nb);
        $consulta = $safra->find();
        
        $codigoBarras = (isset($consulta['data']['documento']['codigoBarras'])) ? $consulta['data']['documento']['codigoBarras'] : "" ;
        if (trim($codigoBarras)<>"") {
            $boleto->alterarStatus($codigoBarras, $id);  
        } 
        
        //criamos o arquivo
        //$arquivo = fopen("Msg" . $numeroDocumento . '.json','w');
        //verificamos se foi criado
        //if ($arquivo == false) die('Não foi possível criar o arquivo.');
        //escrevemos no arquivo
        //$texto = $json;
        //fwrite($arquivo, $texto);
        //Fechamos o arquivo após escrever nele
        //fclose($arquivo);
    }
    $matriz[] = array(base64_encode(2),base64_encode('API Safra'), base64_encode(date('d/m/Y h:i:s')));
    echo json_encode($matriz[0],JSON_PRETTY_PRINT);
}
else{
    $matriz[] = array(base64_encode(2),base64_encode('API Safra Fora de Serviço'), base64_encode(date('d/m/Y h:i:s')));
    echo json_encode($matriz[0],JSON_PRETTY_PRINT);
}