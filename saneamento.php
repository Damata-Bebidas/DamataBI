<?php ob_start();//inicio da sessao 
      session_start();//inicio da sessao
      require_once './_model/session.php';
      $session = new session();
      $session->logarUser(); //verificar se esta logado 
      require_once "./_page/header.php"; 
      require_once "./_page/menu.php";
      require_once './_model/saneamento.php';
      require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
        $url->logarUser(); //verificar se esta logado
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    $saneamento = new saneamento($conexao);
    $id = (isset($_REQUEST['NB'])) ? htmlspecialchars($_REQUEST['NB']) : 1 ; 
    
    if (isset($_REQUEST['status'])) {
        $status = htmlspecialchars($_REQUEST['status']);
        $obs = trim(htmlspecialchars($_REQUEST['obs']));
        $saneamento->alterarStatus($status, $obs ,$id);
        header("Location: ./saneamento.php?NB=$id&import=s");exit;
    }
    $consulta = $saneamento->find($id);
?>
<hgroup class="pagina">
<h3>Damata >> Treinamentos >> Power BI</h3>
<h1><i class="fas fa-chart-pie"></i> <a name="text1">Saneamento da Base </a> <br/><br/></h1>
<a href="powerbifin.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
<?php if($_SESSION['type']=="ROOT" || $_SESSION['type']=="FINAN" || $_SESSION['type']=="GESTOR"):?>
    <form name="formBuscarNB" class="formmenu" action="saneamento.php" method="POST" enctype="multipart/form-data">
        <label for="NB">Consultar NB Saneamento=></label>
        <input type="number" id="NB" autofocus class="form-control col-sm-4" name="NB" value="<?php echo $id; ?>" /> <br/>
        <input name="tConsultar" type="submit" class="enviar radius" value="Consultar"/> <i class="fas fa-arrow-circle-right"></i>
    </form>
    <hr class="linha"/>
        <?php 
            $NB = $consulta["NB"];
            $Nome = $consulta["Nome"];
            $PF_PJ = $consulta["PJ_PF"];
            $GV = $consulta["GV"];
            $SV = $consulta["SV"];
            $VDE = $consulta["VDE"];
            $END = $consulta["End"];
            $Comp = $consulta["Compl"];
            $Bairro = $consulta["Bairro"];
            $Cidade = $consulta["Cidade"];
            $CEP = $consulta["CEP"];
            $Tel = $consulta["Tel"];
            $Cadastro = $url->converterDataPadrao($consulta["Cadastro"]); //converter data apara dd/mm/yyyy
            $UltimaCompra = $url->converterDataPadrao($consulta["UltimaCompra"]);
            $Categoria = $consulta["Categoria"];
            $Anomalias = $consulta["Anomalias"];
            $Base = $consulta["Base"];
            $Tipo = $consulta["Tipo"];
            $Status = $consulta["Status"];
            $obs = $consulta["obs"];
            switch ($Anomalias) {//anomalias na base
                case 'TV':
                    $Anomalias = "Telefone Validado";
                    break;
                case 'TD':
                    $Anomalias =  "<span class='pendente'>Telefone Duplicado</span>";  
                    break;
                case 'ED':
                    $Anomalias = "<span class='pendente'>Endereço Duplicado</span>";
                    break;
            }
            switch ($Base) { //status
                case 'D':
                    $Base = 'VENDA NORMAL';
                    break;
                case 'V':
                    $Base = "<span class='pendente'>VENDA A PRAZO</span>";
                    break;
                case '1':
                    $Base = "<span class='gratis'>100 MAIORES CLIENTES</span>";
                    break;
            }
            switch ($Tipo) {//financeiro
                case 'V':
                    $Tipo = 'VENDA NORMAL';
                    break;
                case 'T':
                    $Tipo = "<span class='pendente'>INADIMPLÊNCIA</span>";
                    break;
                case 'B':
                    $Tipo = "<span class='gratis'>BALCÃO/EVENTOS</span>";
                    break;
            }
            echo "<form class='formmenu'><h5 id='formsaneamento'><b> NB => </b> $NB</h5> "
               . "<h5 id='formsaneamento'><b>Nome =></b> $Nome<h5/>"
               . "<h5 id='formsaneamento'><b>PF/PJ =></b> $PF_PJ || <b>GV =></b> $GV - "
               . "<b>SV =></b> $SV || <b>VDE =></b> $VDE<h5/>"
               . "<h5 id='formsaneamento'><b>Endereço =></b> $END $Comp<h5/>"
               . "<h5 id='formsaneamento'><b>Bairro =></b> $Bairro || <b>Cidade</b> => $Cidade || <b>CEP</b> => $CEP <h5/>"
               . "<h5 id='formsaneamento'><b>Tel =></b> $Tel <h5/> "
               . "<h5 id='formsaneamento'><b>Data Cadastro =></b> $Cadastro <h5/> "
               . "<h5 id='formsaneamento'><b>Última Compra =></b> $UltimaCompra<h5/>"
               . "<h5 id='formsaneamento'><b>Categoria =></b> $Categoria </h5>" 
               . "<h5 id='formsaneamento'><b>Anomalias? =></b> $Anomalias </h5>" 
               . "<h5 id='formsaneamento'><b>Base de Saneamento =></b> $Base </h5>" 
               . "<h5 id='formsaneamento'><b>Financeiro =></b> $Tipo </h5></form><br/>" ;
        ?>
    <hr class="linha"/>
    <form name="formBuscarNB" class="formmenu" action="saneamento.php" method="POST" enctype="multipart/form-data">
        <div class="radio">
            <h5 id='formsaneamento'><b>Saneamento Feito:</b><br/><br/> 
            <input type="radio" name="status" value="0" <?php if($Status==0){ echo "checked='checked'";} ?>  /> Sim 
            <input type="radio" name="status" value="1" <?php if($Status==1){ echo "checked='checked'";} ?> /> Não </h5><br/>
        </div>
        <h5 id='formsaneamento'><b>Descrição do Saneamento:</b></h5><br/>
        <textarea name="obs" class="form-control col-sm-8" ><?php echo trim($obs); ?>
        </textarea><br/>
        <input type="hidden" value="<?php echo $NB; ?>" name="NB" readonly="readonly" />
        <input name="tConsultar" type="submit" class="enviar radius" value="Salvar"/><i class="fas fa-arrow-circle-right"></i>
    </form>       
<?php else:?>
    <div class="texto">
    <h2>Seu Usuário Não tem Acesso a essa página, consulte o Administrador do Sistema</h2>
    </div>
<?php endif;?>
</div>      
<?php require_once "./_page/footer.php"; ?>
<?php if (isset($_REQUEST['sucess'])) {
         $index = htmlspecialchars($_REQUEST['sucess']);
         switch ($index) {
             case "s":
                 $msg = "<script>alert('Saneamento Salvo com Sucesso')</script>";
                 break;
             default:
                 $msg = "<script>alert('Dados Salvo com Sucesso')</script>";
                 break;
         }
         echo $msg;
     }
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