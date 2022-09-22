<?php 
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
// Destinatário
$para = "welingtonmarquezini22@gmail.com;welington_marquezini88@live.com";
// Assunto do e-mail
$assunto = "Login no Portal";

// Campos do formulário de contato
$nome =  (isset($_REQUEST['nome'])) ? trim(base64_decode($_REQUEST['nome'])) : null ; 
$matricula = (isset($_REQUEST['id'])) ? trim(base64_decode($_REQUEST['id'])) : null ;
$tipo = (isset($_REQUEST['tipo'])) ? trim(base64_decode($_REQUEST['tipo'])) : null ;
$mensagem = "Login feito no portal.";

// Monta o corpo da mensagem com os campos
$corpo = "Nome: $nome \nMatricula: $matricula \nTipo: $tipo \nMensagem: $mensagem"; 

// Cabeçalho do e-mail
$email_headers = implode("\n", array("From: $nome", "Reply-To: $email", "Subject: $assunto", "Return-Path: $email", "MIME-Version: 1.0", "X-Priority: 3", "Content-Type: text/html; charset=UTF-8"));

//Verifica se os campos estão preenchidos para enviar então o email
if (!empty($nome) && !empty($matricula) && !empty($tipo)) {
    mail($para, $assunto, $corpo);
    //mail($para, $assunto, $corpo, $email_headers);
    $msg = "Login feito com sucesso.";
    //echo "<script>alert('$msg');window.location.assign('https://www.damatabi.com.br/user.php');</script>";
} else {
    $msg = "Erro ao conectar";
    //echo "<script>alert('$msg');window.location.assign('https://www.damatabi.com.br/user.php');</script>";
}

header("location: user.php");