<?php ob_start();//inicio da sessao 
      session_start();//inicio da sessao ?>
<?php  
    if(isset($_REQUEST['nomeup']) && isset($_REQUEST['matup']) ){
        $_SESSION['nomeup'] = htmlspecialchars($_REQUEST['nomeup']); // nome 
        $_SESSION['matup'] = htmlspecialchars($_REQUEST['matup']); // matricula
    }
    //consulta
    require_once './_model/classarquivos.php';
    //conexao
    require_once "./_page/header.php"; 
    require_once "./_page/menu.php"; 
    require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
        $url->logarUser();
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/colaborador.php';
    $colaborador = new colaborador($conexao);
?>
<hgroup class="pagina">
<h3>Damata >> Treinamentos >> Controle de Interno >> Upload Fotos</h3>
<h1><i class="fas fa-address-card"></i> &nbsp;&nbsp;UpLoad de Fotos</h1><br/><br/>
    &nbsp;&nbsp; &nbsp;&nbsp;<a href="portaria.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
    <a href="_page/relatorioArq.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório Geral</a><br/><br/>
    <form action="_controller/controllerArquivos.php" method="POST" enctype="multipart/form-data">
        <h2>Matrícula:   <input type="text" value="<?php echo $telaM = (isset($_SESSION['matup'])) ? base64_decode($_SESSION['matup']) : ""; ?>" 
            name="mat" readonly="readonly"/><br/>
        Colaborador: <input type="text" size="45" value="<?php echo $telaC = (isset($_SESSION['nomeup'])) ? base64_decode($_SESSION['nomeup']) : ""; ?>" 
            name="nome" readonly="readonly"/><br/>
        Enviar Foto: <input type="file" class="form-control col-sm-6" name="arquivo" size="20" /></h2>
        <input type="hidden" value="FotoPonto" name="tipo" readonly="readonly" />
        <input type="hidden" value="1" name="Funcao" readonly="readonly" />
        <hr class="form col-sm-7 pull-left"/>   
        <h2><input name="tEnviar" type="submit" class="enviar radius" value="Enviar"/><i class="fas fa-arrow-circle-right"></i></h2>
        </form>
</div>
<?php require_once "./_page/footer.php";
    echo $tela = (isset($_REQUEST['up'])) ? "<script type='text/javascript' >upFoto();</script>" : "";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
            $(function(){
                $("#consultar").autocomplete({
                    source: '_page/proc_pesq_nome.php'
                });
            });
</script>