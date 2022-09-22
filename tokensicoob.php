<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
        $url->logarRootGente();//verificar root
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/token.php';
    $token = new token($conexao);
    $resultado = $token->consult();
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Token</h3>
<h1><i class="fas fa-dollar-sign"></i> Lançamento Token Sicoob</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="financeiro.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
    <ul class="formmenu">
        <li><a href="https://api.sisbr.com.br/auth/oauth2/authorize?response_type=code&redirect_uri=https://www.damatabi.com.br&client_id=5iicYfKS9GiQPc_v6GAedH1Lzc4a&versaoHash=3&scope=cobranca_boletos_consultar+cobranca_boletos_incluir" 
               target="_blank" > <i class="fas fa-sign-out-alt"></i> Gerar Token</a></li>
    </ul><br/><br/>
<form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formToken" 
      action="_controller/controllerToken.php" onsubmit="return validaToken();" >
    <fieldset id="token"><legend>
        Token Sicoob</legend>
    </fieldset>
    <fieldset id="token"><legend>Dados do Token</legend>
    <label for="token">Nº do Token .:</label>
    <input type="text" name="token" class="form-control col-sm-10" required
        value="<?php  echo $telaToken = ($resultado) ? $resultado['token'] : null ; ?>" /> <br/>
    <br/><br/>
</fieldset>
<input name="Enviar" type="submit" class="enviar radius" value="Salvar Token"  /> <i class="fas fa-arrow-circle-right"></i><br/><br/>
</fieldset> 
</form>
</div>
</div>
<?php require_once "./_page/footer.php"; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    <?php
        $msg = (isset($_REQUEST['sucess'])) ? "censoOK();" : "" ;
        echo $msg;
    ?>
    $(function(){
        $("#consultar").autocomplete({
            source: '_page/proc_pesq_nome.php'
        });
    });
</script>