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
    } else {
        $resultado = $treinamento->consult();
    }
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Lent >> Cadastro >> Treinamentos </h3>
<h1><i class="fas fa-address-card"></i>Treinamentos</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="login.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['consultar']) || isset($_REQUEST['inserir'])):?>
<div class="texto">
<ul class="formmenu">
            <li><a href="cadconfig.php" > <i class="fas fa-sign-out-alt"></i>Consultar Treinamento</a></li> 
        </ul><br/><br/>
<form method="POST" class="formmenu" name="formCadastro" 
        action="_controller/controllerTreinamento.php" onsubmit="return validaCadastro();" >
    <fieldset id="usuario"><legend>
        Cadastro do Treinamento</legend>
    </fieldset>
    <fieldset id="treinamento"><legend>Dados do Treinamento</legend>
    <input type="hidden" name="id_tr" id="id_tr" 
      size="15" maxlength="15" placeholder="ID Treinamento" 
      readonly='readonly' value="<?php echo $telaId = (count($resultado)>0) ? $resultado['id_tr'] : "" ; ?>"/><br/>
    
    <label for="nome">Treinamento.:</label><input type="text" name="nome" id="nome" class="form-control col-sm-8"
      size="50" maxlength="100" placeholder="Nome treinamento" <?php //echo $tela = (isset($_REQUEST['inserir'])) ? "" : "readonly='readonly'" ; ?>
      value="<?php echo $telaTreinamento = (count($resultado)>0) ? $resultado['Treinamento'] : "" ; ?>"/><br/>

    <label for="frequencia">Frequência.:</label><input type="text" name="frequencia" 
           id="frequencia" size="30" maxlength="30" placeholder="Frequência" class="form-control col-sm-8"
           value="<?php echo $telaFreq = (count($resultado)>0) ? $resultado['frequencia'] : "" ; ?>" /><br/>
    
    <label for="carga">Carga Horária.:</label><input type="text" name="carga" 
           id="Carga" placeholder="Carga Horária" class="form-control col-sm-8"
           value="<?php echo $telaCarga = (count($resultado)>0) ? $resultado['carga'] : "" ; ?>"/><br/>
    
    <label for="reponsavel">Responsável.:</label><input type="text" name="reponsavel" 
           id="reponsavel" placeholder="responsavel" class="form-control col-sm-8"
           value="<?php echo $telaResp = (count($resultado)>0) ? $resultado['responsavel'] : "" ; ?>"/><br/>
    <label for="cargos">Cargos.:</label><input type="text" name="cargos" 
           id="cargos" placeholder="cargos" size="30" class="form-control col-sm-8"
           value="<?php echo $telaCargos = (count($resultado)>0) ? $resultado['cargos'] : "" ; ?>"/><br/>
    <label for="area">Área.:</label>
    <select name="area" id="area" class="form-control col-sm-8">
        <option <?php echo $telaA1 = ($resultado['id_area']=="1") ? "selected" : "" ; ?> >SEGURANCA</option>
        <option <?php echo $telaA2 = ($resultado['id_area']=="2") ? "selected" : "" ; ?> >GENTE</option>
        <option <?php echo $telaA3 = ($resultado['id_area']=="3") ? "selected" : "" ; ?> >GESTAO</option>
        <option <?php echo $telaA4 = ($resultado['id_area']=="4") ? "selected" : "" ; ?> >COMERCIAL</option>
        <option <?php echo $telaA5 = ($resultado['id_area']=="5") ? "selected" : "" ; ?> >FINANCEIRO</option>
        <option <?php echo $telaA6 = ($resultado['id_area']=="6") ? "selected" : "" ; ?> >ENTREGA</option>
        <option <?php echo $telaA7 = ($resultado['id_area']=="7") ? "selected" : "" ; ?> >ARMAZEM</option>
        <option <?php echo $telaA8 = ($resultado['id_area']=="8") ? "selected" : "" ; ?> >PLANEJAMENTO</option>
        <option <?php echo $telaA9 = ($resultado['id_area']=="9") ? "selected" : "" ; ?> >FROTA</option>
        <option <?php echo $telaA10 = ($resultado['id_area']=="10") ? "selected" : "" ; ?> >NIVEL DE SERVICO</option>
    </select><br/><br/>
    <?php 
        if (!isset($_REQUEST['inserir'])) {
            $vencimento=$treinamento->findVencimento($resultado['id_tr']);
            $valor=$vencimento['conclusao'];
            echo "<label for='validade'>Validade.:</label> <input type='date'class='form-control col-sm-4' id='validade' value='$valor' name='validade' />";
        }
    ?>
    <br/><br/>
    <hr class="form col-sm-7 pull-left" />
    <input type="hidden" name="Funcao" value="<?php echo $tela = (isset($_REQUEST['inserir'])) ? 1 : 2 ; ?>" readonly="readonly" />
</fieldset>
<input name="Enviar" type="submit" class="enviar radius" value="Salvar" 
       onsubmit="return validarSenha();" /><i class="fas fa-arrow-circle-right"></i>
<br/>
<br/>
</fieldset> 
</form>
</div>
<script type="text/javascript">
            var navegador = ObterBrowserUtilizado();
            var tela = ObterTela();
            var data = document.getElementById("validade").value;
            if (navegador!=="Google Chrome" && tela && (data.substring(3,2)!=="/")) {
                var data = document.getElementById("validade").value;
                var datatxt = InverterData(data);
                document.getElementById("validade").value = datatxt;
            }
        </script>
<?php else:?>
    <div class="texto">
        <ul class="formmenu"> 
            <li><a href="cadconfig.php?consultar=true&inserir=true" > <i class="fas fa-user-graduate"></i> Inserir Treinamento</a></li>
            <li><a href="_page/relatorioTreinamentos.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a></li><br/><br/>
        </ul>
    <form method="POST" class="formmenu" name="formCadastro" 
        action="cadconfig.php" onsubmit="return validaCadastro();" >
        <fieldset id="usuario"><legend>
            Cadastro de Treinamentos:</legend>
        </fieldset>
        <fieldset id="treinamento"><legend>Dados do Treinamento:</legend>
        <label for="consultar">Nome do Treinamentos.:</label><input type="text" name="consultar" id="consultar"
            required autofocus class="form-control col-sm-7" size="40" maxlength="100" placeholder="Treinamento"/><br/>
        </fieldset>
    <div class="btndireita">
        <input name="Enviar" type="submit" class="enviar radius" value="Consultar" /> <i class="fas fa-arrow-circle-right"></i>
    </div>
    <br/>
    <br/>
</fieldset> 
</form>
</div>
<?php endif;?>
<?php require_once "./_page/footer.php"; ?>
<!-- Auto complete -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
            $(function(){
                $("#consultar").autocomplete({
                    source: '_page/proc_pesq_treinamentos.php'
                });
            });
    </script>