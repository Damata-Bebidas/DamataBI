<?php
/**
 * Description of urlBD
 *
 * @author welin
 */
include_once 'session.php';
class UrlBD extends session{
    private $dsn; 
    private $username; 
    private $passwd ;
    //----------------------------------------------------------------------
    function inicia(){
        include_once 'xml.php';
        $xml = new xml();
        $webconfig = $xml->getConfig();
        /*$sistema =  php_uname();  // Sistema em execução no momento
        $os = PHP_OS;       // Sistema usado para BUILD do PHP
        $pegar_ip = htmlspecialchars($_SERVER["REMOTE_ADDR"]);*/
        $servidor = htmlspecialchars($_SERVER["PHP_SELF"]);
        $string = substr($servidor, 1, 6);
        if ($string=="damata") {
            $this->setDsn($webconfig[3]);
            $this->setUsername($webconfig[4]);
            $this->setPasswd($webconfig[5]);
        } else { 
            $this->setDsn($webconfig[0]);
            $this->setUsername($webconfig[1]);
            $this->setPasswd($webconfig[2]);
        }
    }
    //API
    function iniciaAPI(){
        include_once '../_model/xml.php';
        include_once 'xml.php';
        $xml = new xml();
        $webconfig = $xml->getConfig();
        /*$sistema =  php_uname();  // Sistema em execução no momento
        $os = PHP_OS;       // Sistema usado para BUILD do PHP
        $pegar_ip = htmlspecialchars($_SERVER["REMOTE_ADDR"]);*/
        $servidor = htmlspecialchars($_SERVER["PHP_SELF"]);
        $string = substr($servidor, 1, 6);
        if ($string=="damata") {
            $this->setDsn($webconfig[3]);
            $this->setUsername($webconfig[4]);
            $this->setPasswd($webconfig[5]);
        } else { 
            $this->setDsn($webconfig[0]);
            $this->setUsername($webconfig[1]);
            $this->setPasswd($webconfig[2]);
        }
    }
    
    function converterData($data){
    $dataR = explode("/",$data);
    $qtd = count($dataR);
    if ($qtd>1) {
        $dia = $dataR[0];
        $mes = $dataR[1];
        $ano = $dataR[2];
        $resultado = $ano . "-" . $mes . "-" . $dia;
    } else {
        $resultado = $data;
    }

    return $resultado;
    }
    
    function converterDataPadrao($data){
        $dataR = explode("-",$data);
        $qtd = count($dataR);
        if ($qtd>1) {
            $dia = $dataR[2];
            $mes = $dataR[1];
            $ano = $dataR[0];
            $resultado = $dia . "/". $mes .  "/".  $ano;
        } else {
            $resultado = $data;
        }
        
        return $resultado;
    }
    //-------------------------------------------------------------------
    public function getDsn() {
        return base64_decode($this->dsn);
    }

    public function getUsername() {
        return  base64_decode($this->username);
    }

    public function getPasswd() {
        return  base64_decode($this->passwd);
    }

    protected function setDsn($dsn) {
        $this->dsn = $dsn;
        return $this;
    }

    protected function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    protected function setPasswd($passwd) {
        $this->passwd = $passwd;
        return $this;
    }
    
}