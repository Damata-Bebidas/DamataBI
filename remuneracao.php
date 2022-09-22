<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
        $url->logarRootGente();//verificar gente
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/colaborador.php';
    $colaborador = new colaborador($conexao);
    if (isset($_REQUEST['consultar'])) {
        $nome = htmlspecialchars($_REQUEST['consultar']);
        $resultado = $colaborador->findName($nome);
    }
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Remuneração</h3>
<h1><i class="fas fa-dollar-sign"></i> Remuneração Variável</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="login.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
        <h3><i class="fas fa-list-ol"></i> UpLoad Arquivo Remuneração Variável</h3><br/>
        <ul class="formmenu">
            <li><a href="remuneracao.php" > <i class="fas fa-sign-out-alt"></i> Remuneracao Variável</a></li> 
            <li><a href="_download/remuneracao.zip" > <i class="fas fa-download"></i> Download Planilha Padrão</a></li> 
        </ul><br/><br/>
        <form name="formCadastro" class="formmenu" action="_controller/controllerInserirRemuneracao.php" 
            method="POST" enctype="multipart/form-data">
            <label for="arquivo" >Arquivo (*.xml) do Excel</label> 
            <input type="file" required id="arquivo"  name="arquivo" class="form-control col-sm-6"/><br/>
            
            <label for="Nascimento">Data.:</label><input type="date" name="data" 
            id="data" placeholder="Data" class="form-control col-sm-2" required
            value="<?php echo date('Y-m') .'-01' ; ?>"/><br/>
            <hr class="form" />&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="Fechado" class="form-check-input" name="tipo" checked  value="F" />
            <label for="Safra" class="form-check-label">Fechado</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="Tendência" class="form-check-input" name="tipo" value="T" />
            <label for="Sicoob" class="form-check-label">Tendência</label><br/><br/>    

            <input type="hidden" value="1" name="Funcao" readonly="readonly" />
            <input name="tEnviar" type="submit" class="enviar radius" value="Enviar"/>
            <i class="fas fa-arrow-circle-right"></i>
        </form>
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