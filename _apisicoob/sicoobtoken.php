<?php
require_once 'xml.php';
class sicoob {
    private $numero,$cliente;
//construtor
function __construct() {
}
//metetodos consultores
function find() { $numero =$this->getNumero(); $cliente = $this->getCliente();
    $xml = new xmlSafra();
    $client_id = $xml->getConfig('client_id');
    $username = $xml->getConfig('username');
    $password = $xml->getConfig('password');
    $SafraCorrelationID = $xml->getConfig('Safra-Correlation-ID');
    $conToken = $xml->getConfig('token');
    
    do {    if (!isset($_COOKIE['token'])) {
                $terminal = shell_exec($conToken);
                $resultadoTerminal = explode( '"' ,$terminal);  
                $token = $resultadoTerminal[3];
                setcookie('token',$token,time()+360);  
            } else { 
                $token = htmlspecialchars($_COOKIE['token']) ; 
            }    
    } while ($token==""); //enquanto for vazio
    
    $consulta = shell_exec("curl -v \
    GET 'https://api.safranegocios.com.br/gateway/cobrancas/v1/boletos?agencia=18900&conta=5804407&numero=" . 
    $numero . "&numeroCliente=" . $cliente . "' \
    -H 'Safra-Correlation-ID: " . $SafraCorrelationID . "' \
    -H 'Content-Type: application/json' \
    -H 'Authorization: Bearer $token'");  $retorno = json_decode($consulta,JSON_PRETTY_PRINT);
    return $retorno;
    echo "<pre>"; print_r(json_decode($consulta,JSON_PRETTY_PRINT)); echo "</pre><br/><hr/>";
}
// get and setter
    function getNumero() {
        return $this->numero;
    }

    function getCliente() {
        return $this->cliente;
    }

    function setNumero($numero) {
        $this->numero = $numero;
        return $this;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
        return $this;
    }
}