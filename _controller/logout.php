<?php
    session_start();
    unset($_SESSION['logado']);
    unset($_SESSION['nome']);
    unset($_SESSION['user']);
    unset($_SESSION['key']);
    unset($_SESSION['treinamento']);
    unset($_SESSION['ids']);
    unset($_SESSION['redirecionar']);
    unset($_SESSION['nomeArq']);
    unset($_SESSION['type']);
    
    //redirecionar
    header("location: ../login.php");