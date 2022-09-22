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
    require_once './_model/treinamento.php';
    $treinamento = new treinamento($conexao);
    if (isset($_REQUEST['consultar'])) {
        $nome = htmlspecialchars($_REQUEST['consultar']);
        $resultado = $treinamento->findName($nome);
    } 
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Lent >>  Treinamentos >> Prova de 3 e 6  Meses </h3>
<h1><i class="fas fa-edit"></i> Prova de 3 & 6 Meses</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="user.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['repositor']) || isset($_REQUEST['vendedor']) || isset($_REQUEST['entrega'])):?>
    <div class="texto">
        <ul class="formmenu"> 
            <li><a href="findExam.php" > <i class='fas fa-address-book'></i> Consultar outra Prova</a></li>
        </ul><br/>  
    <form method="POST" class="formmenu" name="formCadastro" 
        action="_controller/controllerProva.php" onsubmit="return validaCadastro();" >
        <fieldset id="usuario"><legend>
            Aplicabilidade por Colaborador:</legend>
        </fieldset>
        <fieldset id="treinamento"><legend>Qual Prova:</legend>
            <div class="radio">
                <label for="prova"> Tipo:</label><legend>Prova 3 e 6 meses</legend>
                <input type="radio" name="tipo" value="3 Meses" checked="checked" /> 3 Meses
                <input type="radio" name="tipo" value="6 Meses" /> 6 Meses <br/>
            </div>
        </fieldset>
        <hr class="form col-sm-7 pull-left"/>
        <fieldset id="treinamento"><legend>Dados do Colaborador:</legend>
            <label for="nome">Nome Colaborador.:</label><input type="text" name="nome" id="nome" required autofocus
            size="40" maxlength="50" placeholder="Nome de Colaborador" class="form-control col-sm-6"
            value="<?php echo $tela = (isset($_REQUEST['nome'])) ?  htmlspecialchars($_REQUEST['nome']) : "" ; ?>" /><br/>
        </fieldset>
    <?php if (isset($_REQUEST['repositor'])) {
            echo   '<input name="cargo" type="hidden" value="repositor" />';
        } else if (htmlspecialchars(isset($_REQUEST['vendedor']))) {
            echo   '<input name="cargo" type="hidden" value="vendedor" />';
        }else if (isset($_REQUEST['entrega'])) {
            echo   '<input name="cargo" type="hidden" value="entrega" />';
        }?>
    
    <input name="consultarprova" type="hidden" value="true" />
    <div class="btndireita">
        <input name="Enviar" type="submit" class="enviar radius" value="Consultar" /> <i class="fas fa-arrow-circle-right"></i>
    </div>
    <br/><br/>
    </form>
</div>
<?php else:?>
    <div class="texto">
    <!--Provas -->
    <article class="servico bg-white radius">
     <div class="inner">
       <h4 class="center"><i class="fab fa-servicestack"></i> Tipos de Provas</h4>
        <ul class="formmenu consulta"> 
            <li><a href='findExam.php?repositor'><i class="fas fa-map-marker-alt"></i> Prova 3 & 6 Meses Repositor</a></li>
            <li><a href='findExam.php?vendedor'> <i class="fas fa-beer"></i> Prova 3 & 6 Representante de Negócios I</a></li>
            <li><a href='findExam.php?entrega'><i class="fas fa-truck-moving"></i> Prova 3 & 6 Meses Entrega</a></li>
            <li><a href='https://app.powerbi.com/view?r=eyJrIjoiMzM1OTQzMWEtNmRhNC00NTg0LWIxNjctNmZjYTI1NTc1OWIxIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9' target="_blank" > <i class='fas fa-chalkboard-teacher'></i> Power BI Prova 3 & 6 Meses</a></li>
        </ul>
    </div>
    </article> 
    <!--Gabaritos -->
    <article class="servico bg-white radius">
     <div class="inner">
       <h4 class="center"><i class="fas fa-check-circle"></i> Gabaritos de Provas</h4>
        <ul class="formmenu consulta"> 
            <li><a href='_download/Prova3&6MesesRepositor.xlsx'><i class="fas fa-map-marker-alt"></i> Gabarito Prova 3 & 6 Meses Repositor</a></li>
            <li><a href='_download/Prova3&6MesesVendedor.xlsx'> <i class="fas fa-beer"></i> Gabarito Prova 3 & 6 Meses Representante de Negócios I</a></li>
            <li><a href='_download/Prova3&6MesesEntrega.xlsx'><i class="fas fa-truck-moving"></i> Gabarito Prova 3 & 6 Meses Entrega</a></li>
        </ul>
    </div>
    </article> 
</div>
<?php endif;?>
<?php require_once "./_page/footer.php"; ?>
<!-- Auto complete -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
            $(function(){
                $("#nome").autocomplete({
                    source: '_page/proc_pesq_nome.php'
                });
            });
</script>
<?php echo $tela = (isset($_REQUEST['sucess'])) ? "<script type='text/javascript' >provaSucess();</script>" : "";?>