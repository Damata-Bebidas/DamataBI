<?php 
ob_start();//inicio da sessao 
session_start();
if((isset($_SESSION['emails'])) && (isset($_SESSION['senhas']))){
    header("Location: usuario.php");exit;
}
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<?php require_once './_model/urlDb.php';
        $url = new UrlBD(); ?>
<hgroup class="pagina">
<h3>Damata >> Login >> Recuperar Senha</h3>
<h1><i class="fas fa-key"></i> &nbsp;&nbsp;Recuperar Senha<br/>
<a href="login.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a></h1>
</hgroup>
<?php   require_once './_model/colaborador.php';
        require_once './_model/urlDb.php';
            $url->inicia();
            $dsn = $url->getDsn();
            $username = $url->getUsername();
            $passwd = $url->getPasswd();
        try {
            $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dadosX 
        } catch (\PDOException $ex) {
            die('Não foi possível estabelecer '
            . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
        }
 ?>
<div class="texto">
    <form method="POST" class="formmenu" name="formLogin" action="_controller/controllerColaborador.php" onsubmit="return validaSenha();">
    <fieldset id="usuario"><legend>Recuperar Senha</legend></fieldset>
    <fieldset id="email"><legend>Login</legend><br/>
    <label for="Id">Login:</label>
        <input type="number" name="Mat" id="Id" size="12" class="form-control col-sm-4"
               maxlength="40" placeholder="Matrícula"  />
    </fieldset>
    <hr class="form col-sm-7 pull-left"/>   
    <input type="hidden" value="5" name="Funcao" readonly="readonly" />
    <input name="tEnviar" type="submit" class="enviar radius" value="Enviar"/><i class="fas fa-arrow-circle-right"></i>
</form>
<br/>
</div>
<?php require_once "./_page/footer.php"; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
            $(function(){
                $("#consultar").autocomplete({
                    source: '_page/proc_pesq_nome.php'
                });
            });
</script>