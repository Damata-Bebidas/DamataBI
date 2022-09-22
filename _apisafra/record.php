<?php
require_once '../_model/boleto.php';
require_once '../_model/urlDb.php';
require_once '../_model/apiconfig.php';
require_once 'xml.php';
$url = new UrlBD();
$url->iniciaAPI();
$dsn = $url->getDsn();
$username = $url->getUsername();
$passwd = $url->getPasswd();

$xml = new xmlSafra();
$client_id = $xml->getConfig('client_id');
$usernamesafra = $xml->getConfig('username');
$password = $xml->getConfig('password');
$SafraCorrelationID = $xml->getConfig('Safra-Correlation-ID');
$agencia = $xml->getConfig('agencia');
$conta = $xml->getConfig('conta');
$taxaJuros = $xml->getConfig('taxaJuros');
$nomeXml = $xml->getConfig('nome');
$pessoaXml = $xml->getConfig('pessoa');
$diasDevolucao = $xml->getConfig('diasDevolucao');
$taxaMulta = $xml->getConfig('taxaMulta');
$cnpj = $xml->getConfig('cnpj');
$logradouroXml =  $xml->getConfig('logradouro');
$bairroXml = $xml->getConfig('bairro');
$cidadeXml = $xml->getConfig('cidade');
$ufXml = $xml->getConfig('uf');
$cepXml = $xml->getConfig('cep');
$conToken = $xml->getConfig('token');
   
try {
    $conexao = new \PDO($dsn, $username, $passwd);//cria conexão com banco de dadosX 
} catch (\PDOException $ex) {
    die('Não foi possível estabelecer '
    . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
}
$boleto = new boleto($conexao);
$data  = date('Y-m-d', strtotime('-1 days'));
$resultado = $boleto->listarRecentes($data);

$apiconfig = new apiconfig($conexao);
$resultadoconfig = $apiconfig->consult();
$config = $resultadoconfig['api'];
/* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou ger
    $REQUEST = (isset($post['W'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);

if (isset($REQUEST['w'])) {
    $exect = base64_decode($REQUEST['w']);//w=MQ==
}
if ($exect==1 && $config=='Safra') {
    foreach ($resultado as $key => $value) {
        $numeroDocumento = $value['numDoc'];
        $NB = $value['NB'];
        $nome = $value['nome'];
        $valor =  $value['valor'];
        $vencimento = $value['vencimento'];
        $danfe = $value['danfe'];
        $pj_pf = $value['pj_pf'];
        $cpf = $value['cpf'];
        $end = $value['end'];
        $bairro = $value['bairro'];
        $cidade = $value['cidade'];
        $uf = $value['uf'];
        $cep = $value['cep'];
        $indicadorBaseCentral =  $value['indicadorBaseCentral'];
        $codigoBarras = $value['codigoBarras'];

        do {
            $json = '{
                "agencia": "'. $agencia .'",
                "conta": "'. $conta .'",
                "documento": {
                    "numero": ' . $numeroDocumento . ',
                    "numeroCliente": "' . $NB . '",
                    "especie": "09",
                    "dataVencimento": "' . $vencimento .'",
                    "valor": ' . $valor . ',
                    "diasDevolucao" : '. $diasDevolucao .',
                    "codigoMoeda": 0,
                    "quantidadeDiasProtesto": 0,
                    "multa": {
                        "dataJuros": "' . $vencimento .'",
                        "taxaJuros": '. $taxaJuros.',
                        "dataMulta": "' . $vencimento .'",
                        "taxaMulta": '. $taxaMulta .'
                    },
                    "campoLivre": "",
                    "fidc": "0",
                    "danfe": "' . $danfe . '",
                    "pagador": {
                        "nome": "'. $nome .'",
                        "tipoPessoa": "' . $pj_pf .'",
                        "numeroDocumento": "'. $cpf .'",
                        "endereco": {
                            "logradouro": "'. $end . '",
                            "bairro": "' . $bairro .'",
                            "cidade": "' . $cidade .'",
                            "uf": "' . $uf . '",
                            "cep": "'. $cep .'"
                        }
                    },
                    "beneficiario": {
                        "nome": "'.$nomeXml.'",
                        "tipoPessoa": "'.$pessoaXml.'",
                        "email": "",
                        "numeroDocumento": "'.$cnpj.'",
                        "endereco": {
                            "logradouro": "'. $logradouroXml .'",
                            "bairro": "'. $bairroXml .'",
                            "cidade": "'. $cidadeXml .'",
                            "uf": "'. $ufXml .'",
                            "cep": "'. $cepXml .'"
                        }
                    },
                    "mensagens": [
                        {
                            "posicao": "1",
                            "descricao": "Apos o vencimento, Multa de R$' . number_format($valor * 0.02,2,',','.') . 
                                ' e Juros dia de R$' . number_format((($valor * 0.099) / 30),2,',','.') .  '"
                        }
                    ]
                }
            }';

            do {
                if (!isset($_COOKIE['token'])) {
                    $terminal = shell_exec($conToken);
                    $resultadoTerminal = explode( '"' ,$terminal); 
                    $token = $resultadoTerminal[3];
                    setcookie('token',$token,time()+360);
                } else {
                    $token = htmlspecialchars($_COOKIE['token']);
                }    
            } while ($token==""); //enquanto for vazio
            
            $registro = shell_exec("curl --location --request POST 'https://api.safranegocios.com.br/gateway/cobrancas/v1/boletos' \
            --data '$json' \
            -H 'Safra-Correlation-ID: $SafraCorrelationID       ' \
            -H 'Content-Type: application/json' \
            -H 'Authorization: Bearer $token'");
            
            $retorno = json_decode($registro,JSON_PRETTY_PRINT);
            $w = count($registro);
                if (isset($retorno['data'])) {
                    $numero = $retorno['data']['numero'];
                    $numeroCliente = $retorno['data']['numeroCliente'];
                    $codigoBarras = $retorno['data']['codigoBarras'];
                    $indicadorBaseCentral = $retorno['data']['indicadorBaseCentral'];

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
                    if (count($consulta)==1) {
                        $boleto->inserir();
                    } elseif (count($consulta)>1) {
                        $boleto->alterar();
                    }
                } elseif (isset($retorno['code'])) {
                    $codigoBarras = "";
                    $indicadorBaseCentral = $retorno['message'];
                    
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
                    if (count($consulta)==1) {
                        $boleto->inserir();
                    } elseif (count($consulta)>1 && isset($retorno['message'])) {
                        if (trim($value['codigoBarras'])=="" 
                            && TRIM($value['indicadorBaseCentral'])<>"NOSSO NUMERO JA EXISTENTE EM NOSSA BASE") {
                            $boleto->alterar();
                        }
                    }
                }
        } while ($w == ""); //Fazer ate ser diferente de vazio
        //criamos o arquivo
        $arquivo = fopen($numeroDocumento . '.json','w');
        //verificamos se foi criado
        if ($arquivo == false) {
            die('Não foi possível criar o arquivo.');
        }
        //escrevemos no arquivo
        $texto = $json;
        fwrite($arquivo, $texto);
        //Fechamos o arquivo após escrever nele
        fclose($arquivo);
    }
    $matriz[] = array(base64_encode(1),base64_encode('API Safra'), base64_encode(date('d/m/Y h:i:s')));
    echo json_encode($matriz[0],JSON_PRETTY_PRINT);
} else{
    $matriz[] = array(base64_encode(2),base64_encode('API Safra Fora de Serviço'), base64_encode(date('d/m/Y h:i:s')));
    echo json_encode($matriz[0],JSON_PRETTY_PRINT);
}