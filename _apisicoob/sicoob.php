<?php
    require_once '../_model/boleto.php';
    require_once '../_model/urlDb.php';
    require_once '../_model/apiconfig.php';
    require_once '../_model/token.php';
    require_once 'xml.php';
    $url = new UrlBD();
    $url->iniciaAPI();
    $dsn = $url->getDsn();
    $username = $url->getUsername();
    $passwd = $url->getPasswd();

    $xml = new xmlSicoob();
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
    $tokenBasic = $xml->getConfig('tokenBasic');
try {
    $conexao = new \PDO($dsn, $username, $passwd);//cria conexão com banco de dadosX
} catch (\PDOException $ex) {
    die('Não foi possível estabelecer '
    . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
}
//$conexao = new \PDO("sqlite:api.db") or die("Erro ao abrir a base");
$boleto = new boleto($conexao);
$data  = date('Y-m-d', strtotime('-1 days'));
$resultado = $boleto->listarRecentes($data);
$modelToken = new token($conexao);
$resultado_access_token = $modelToken->consult();
$tokenAccess = $resultado_access_token['token'];

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
if ($exect==1 && $config=='Sicoob') {
    //foreach ($resultado as $key => $value) {
        $numeroDocumento = ($value) ? $value['numDoc'] : null ;
        $NB = ($value) ? $value['NB'] : null ;
        $nome = ($value) ? $value['nome'] : null ;
        $valor =  ($value) ? $value['valor'] : null ;
        $vencimento = ($value) ? $value['vencimento'] : null ;
        $danfe = ($value) ? $value['danfe'] : null ;
        $pj_pf = ($value) ? $value['pj_pf'] : null ;
        $cpf = ($value) ? $value['cpf'] : null ;
        $end = ($value) ? $value['end'] : null ;
        $bairro = ($value) ? $value['bairro'] : null ;
        $cidade = ($value) ? $value['cidade'] : null ;
        $uf = ($value) ? $value['uf'] : null ;
        $cep = ($value) ? $value['cep'] : null ;
        $indicadorBaseCentral =  ($value) ? $value['indicadorBaseCentral'] : null ;
        $codigoBarras = ($value) ? $value['codigoBarras'] : null ;

        do {
            $json = '{
                "numeroContrato": '. $numeroDocumento .',
                "modalidade": 1,
                "numeroContaCorrente": 596,
                "nossoNumero": 44772018,
                "seuNumero": 7367194,
                "especieDocumento": "DM",
                "dataEmissao": "'. $data .'T00:00:00-03:00",
                "identificacaoBoletoEmpresa": 11379308,
                "identificacaoEmissaoBoleto": 1,
                "identificacaoDistribuicaoBoleto": 2,
                "valor": ' . $valor . ',
                "dataVencimento": "' . $vencimento . 'T00:00:00-03:00",
                "dataLimitePagamento": "' . $vencimento . 'T00:00:00-03:00",
                "valorAbatimento": 0.00,
                "tipoDesconto": 3,
                "dataPrimeiroDesconto": "' . $vencimento  .  'T00:00:00-03:00",
                "valorPrimeiroDesconto": 0.00,
                "tipoMulta": 0,
                "dataMulta": "' . $vencimento .'T00:00:00-03:00",
                "valorMulta": '. ($valor * 0.02) .',
                "tipoJurosMora": 3,
                "dataJurosMora": "'. $vencimento .'T00:00:00-03:00",
                "valorJurosMora": ' . (($valor * 0.099) / 30) .',
                "numeroParcela": 99,
                "aceite": "true",
                "codigoNegativacao": 3,
                "numeroDiasNegativacao": 24,
                "codigoProtesto": 3,
                "numeroDiasProtesto": 35,
                "quantidadeDiasFloat": 51,
                "pagador": {
                    "numeroCpfCnpj": '. $cpf .',
                    "nome": "'. $nome .'",
                    "endereco": "'. $end .'",
                    "bairro": "'. $bairro .'",
                    "cidade": "'. $cidade .'",
                    "cep": ' . $cep .',
                    "uf": "'. $uf .'",
                    "email": [
                        "ricardo@damataleo.com.br"
                    ]
                },
                "beneficiarioFinal": {
                    "numeroCpfCnpj": ' . $cnpj . ',
                    "nome": "'. $nomeXml .'"
                },
                "mensagensInstrucao": {
                    "tipoInstrucao": 3,
                    "mensagens": [
                        "Apos o vencimento, Multa de R$' . number_format($valor * 0.02,2,',','.') . 
                                ' e Juros dia de R$' . number_format((($valor * 0.099) / 30),2,',','.') .  '"
                    ]
                },
                "situacaoBoleto": "Em Aberto",
                "listaHistorico": [
                    {
                        "dataHistorico": "' . $data .'T00:00:00-03:00",
                        "tipoHistorico": 56,
                        "descricaoHistorico": "Apos o vencimento, Multa de R$' . number_format($valor * 0.02,2,',','.') . 
                        ' e Juros dia de R$' . number_format((($valor * 0.099) / 30),2,',','.') .  '"
                    }
                ]
            }';

            do {
                if (!isset($_COOKIE['token'])) {
                    //pegar o código aqui
                    $terminal = shell_exec("curl --location --request POST 'https://api.sisbr.com.br/auth/token' \
                    --header 'Content-Type: application/x-www-form-urlencoded' \
                    --header 'Authorization: Basic $tokenBasic' \
                    --data-urlencode 'grant_type=authorization_code' \
                    --data-urlencode 'code=$tokenAccess' \
                    --data-urlencode 'redirect_uri=https://www.damatabi.com.br'");
                    $resultadoTerminal = json_decode($terminal,JSON_PRETTY_PRINT); 
                    $access_token  = $resultadoTerminal['access_token'];
                    $refresh_token = $resultadoTerminal['refresh_token'];
                    //-------------------------------------------------------------------------------------------------
                    /*$jsonToken = '{
                        "access_token": "78111773-8e59-3314-a006-030e40ba75d6",
                        "refresh_token": "e54950f5-f52d-3258-871b-da21bc9af077",
                        "scope": "cobranca_boletos_consultar cobranca_boletos_incluir",
                        "token_type": "Bearer",
                        "expires_in": 3600
                    }';
                    $tokenMatriz   = json_decode($jsonToken,JSON_PRETTY_PRINT);
                    $access_token  = $tokenMatriz['access_token'];
                    $refresh_token = $tokenMatriz['refresh_token'];*/
                    //-------------------------------------------------------------------------------------------------
                    ($access_token<>'') ? setcookie('token',$token,time()+360) : null ;
                    //criamos o log token
                    $arquivo = fopen('_Token.json','w');
                    //verificamos se foi criado
                    if ($arquivo == false) {die('Não foi possível criar o arquivo.');}
                    //escrevemos no arquivo
                    $texto = $terminal;
                    fwrite($arquivo, $texto);
                    //Fechamos o arquivo após escrever nele
                    fclose($arquivo);
                    //salvar o token aqui
                    if($refresh_token<>""){
                        $modelToken->setToken($access_token);
                        $modelToken->inserir();
                    }
                } else {
                    $refresh_token = htmlspecialchars($_COOKIE['token']);
                }    
            } while ($refresh_token==""); //enquanto for vazio
            $registro = array();
            $registro = shell_exec("curl --location --request POST 'https://api.sisbr.com.br/cooperado/cobranca-bancaria/v1/boletos' \
            --header 'Authorization: Bearer $refresh_token' \
            --header 'Content-Type: application/json' \
            --data-raw '$json'");
            //criamos o log registo
            $arquivo = fopen('_ApiLog.json','w');
            //verificamos se foi criado
            if ($arquivo == false) {die('Não foi possível criar o arquivo.');}
            //escrevemos no arquivo
            $texto = $registro;
            fwrite($arquivo, $texto);
            //Fechamos o arquivo após escrever nele
            fclose($arquivo);
            //salvar o token aqui
            $retorno = json_decode($registro,JSON_PRETTY_PRINT);
            
            $w =  ($retorno["httpCode"]=='401') ? "" : true;
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
    //}
    $matriz[] = array(base64_encode(1),base64_encode('API Sicoob'), base64_encode(date('d/m/Y h:i:s')));
    echo json_encode($matriz[0],JSON_PRETTY_PRINT);
}else{
    $matriz[] = array(base64_encode(1),base64_encode('API Sicoob Fora de Serviço'), base64_encode(date('d/m/Y h:i:s')));
    echo json_encode($matriz[0],JSON_PRETTY_PRINT);
}