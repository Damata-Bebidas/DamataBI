<?php
/**
 * Description of session
 *
 * @author welingtonmarquezini
 */
class session {
    private $login;
    
    function __construct() { // construtor vazio
        
    }
    
    public function logar() {
        if((isset($_SESSION['user'])) 
            && (isset($_SESSION['key']))){
            header("Location: user.php");exit;
        } else {
            header("Location: login.php");exit;
        }
    }
    
    public function logarLogin() {
        if((isset($_SESSION['user'])) 
            && (isset($_SESSION['key']))){
            header("Location: user.php");exit;
        }
    }
    
    public function logarUser() {
        if((isset($_SESSION['user'])) 
            && (isset($_SESSION['key']))){
        } else {
            header("Location: login.php");exit;
        }
    }
    
    public function logarRoot() {
        if(isset($_SESSION['user']) && $_SESSION['type']=="ROOT"){
        } else {
            header("Location: login.php");exit;
        }
    }
    public function logarRootGente() {
        if(isset($_SESSION['user']) && ($_SESSION['type']=="ROOT" || $_SESSION['type']=="GENTE")){
        } else {
            header("Location: login.php");exit;
        }
    }
    public function logarPort() {
        if(isset($_SESSION['user']) && $_SESSION['type']<>"BASIC"){
        } else {
            header("Location: login.php");exit;
        }
    }
    public function logarRootLog() {
        if(isset($_SESSION['user']) && ($_SESSION['type']=="ROOT" || $_SESSION['type']=="LOG")){
        } else {
            header("Location: login.php");exit;
        }
    }
    //metodos acessores e modificadores
    function getLogin() {
        return $this->login;
    }

    function setLogin($login) {
        $this->login = $login;
    }
}
