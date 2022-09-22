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
<h3>Damata >> Cadastro</h3>
<h1><i class="fas fa-address-card"></i>Cadastro</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="login.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['consultar']) || isset($_REQUEST['inserir'])):?>
<div class="texto">
    <ul class="formmenu">
        <li><a href="cadastro.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
        <li><a href="_page/relatorioColaboradores.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a><br/><br/></li> 
    </ul><br/><br/>
<form method="POST" class="formmenu" name="formCadastro" 
        action="_controller/controllerColaborador.php" onsubmit="return validaCadastro();" >
    <fieldset id="usuario"><legend>
        Cadastro do colaborador</legend>
    </fieldset>
    <fieldset id="sexo"><legend>Dados do Usuário</legend>
    <label for="Id">Matrícula.:</label><input type="number" name="Mat" id="Mat" 
      size="15" maxlength="15" placeholder="Matricula" class="form-control col-sm-4" required
      <?php echo $tela1 = (isset($_REQUEST['inserir'])) ? "" : "readonly='readonly'" ; ?>
        value="<?php echo $telaMat = (count($resultado)>0) ? $resultado['matricula'] : "" ; ?>"/><br/>

    <label for="Nome">Nome.:</label><input type="text" name="Nome" id="Nome" 
      size="35" maxlength="50" placeholder="Nome Completo" class="form-control col-sm-8" required
      <?php echo $tela2 = (isset($_REQUEST['inserir'])) ? "" : "readonly='readonly'" ; ?>
      value="<?php echo $telaNome = (count($resultado)>0) ? $resultado['nome'] : "" ; ?>"/><br/>
    
    <label for="EMail">E-mail.:</label><input type="email" name="Email" class="form-control col-sm-8" 
           id="Email" size="30" maxlength="40" placeholder="email@damataleo.com.br"
           value="<?php echo $tela8 = (count($resultado)>0) ? $resultado['email'] : "" ; ?>"/> <br/>
    
    <label for="Setor">Setor.:</label>
    <select name="Setor" id="Setor" class="form-control col-sm-4">
        <option <?php echo $tela3 = ($resultado['setor']=="ADMINISTRATIVO") ? "selected" : "" ; ?> >ADMINISTRATIVO</option>
        <option <?php echo $tela4 = ($resultado['setor']=="APOIO LOGÍSTICO") ? "selected" : "" ; ?> >APOIO LOGÍSTICO</option>
        <option <?php echo $tela5 = ($resultado['setor']=="DISTRIBUIÇÃO URBANA") ? "selected" : "" ; ?>>DISTRIBUIÇÃO URBANA</option>
        <option <?php echo $tela6 = ($resultado['setor']=="PUXADA") ? "selected" : "" ; ?>>PUXADA</option>
        <option <?php echo $tela7 = ($resultado['setor']=="VENDAS") ? "selected" : "" ; ?>>VENDAS</option>
    </select><br/><br/>
    
    <label for="Cargo">Cargo.:</label><input type="text" name="Cargo" class="form-control col-sm-8" required
           id="Cargo" size="30" maxlength="30" placeholder="Cargo" 
           value="<?php echo $telaCargo = (count($resultado)>0) ? $resultado['cargo'] : "" ; ?>" /><br/>
    
    <label for="Nascimento">Nascimento.:</label><input type="date" name="Nascimento" 
           id="Nascimento" placeholder="Nascimento" class="form-control col-sm-4" required
           value="<?php echo $telaNascimento = (count($resultado)>0) ? $resultado['nascimento'] : "" ; ?>"/><br/>
    
    <label for="Admissao">Admissão.:</label><input type="date" name="Admissao" 
           id="Admissao" placeholder="Admissão" class="form-control col-sm-4" required
           value="<?php echo $telaAdm = (count($resultado)>0) ? $resultado['admissao'] : "" ; ?>"/><br/>
    
    <label for="Sexo">Sexo.:</label>
    <select name="Sexo" id="Sexo" class="form-control col-sm-4" >
        <option <?php echo $telaM = ($resultado['sexo']=="MASCULINO") ? "selected" : "" ; ?> >MASCULINO</option>
        <option <?php echo $telaF = ($resultado['sexo']=="FEMININO") ? "selected" : "" ; ?>>FEMININO</option>
    </select><br/><br/>
    
     <label for="Escola">Nível Escolar.:</label>
    <select name="Escola" id="Escolar" class="form-control col-sm-4" >
        <option <?php echo $telaE1 = ($resultado['escolaridade']=="FUNDAMENTAL") ? "selected" : "" ; ?> >FUNDAMENTAL</option>
        <option <?php echo $telaE2 = ($resultado['escolaridade']=="MÉDIO") ? "selected" : "" ; ?> >MÉDIO</option>
        <option <?php echo $telaE3 = ($resultado['escolaridade']=="MÉDIO TÉCNICO") ? "selected" : "" ; ?>>MÉDIO TÉCNICO</option>
        <option <?php echo $telaE4 = ($resultado['escolaridade']=="SUPERIOR") ? "selected" : "" ; ?>>SUPERIOR</option>
        <option <?php echo $telaE5 = ($resultado['escolaridade']=="PÓS GRADUADO - MBA") ? "selected" : "" ; ?>>PÓS GRADUADO - MBA</option>
    </select><br/><br/>
    
    <label for="Status">Status</label>
    <select name="Status" id="Status" class="form-control col-sm-4" >
        <option  <?php echo $telaS1 = ($resultado['status']=="ATIVO") ? "selected" : "" ; ?>>ATIVO</option>
        <option <?php echo $telaS2 = ($resultado['status']=="FÉRIAS") ? "selected" : "" ; ?>>FÉRIAS</option>
        <option <?php echo $telaS3 = ($resultado['status']=="AFASTADO") ? "selected" : "" ; ?>>AFASTADO</option>
        <option <?php echo $telaS4 = ($resultado['status']=="DEMITIDO") ? "selected" : "" ; ?>>DEMITIDO</option>
    </select><br/><br/>
    
    <label for="Tipo">Tipo</label>
    <select name="Tipo" id="Tipo" class="form-control col-sm-4" >
        <option <?php echo $telaT1 = ($resultado['tipo']=="BASIC") ? "selected" : "" ; ?>>BASIC</option>
        <option <?php echo $telaT2 = ($resultado['tipo']=="FINAN") ? "selected" : "" ; ?>>FINAN</option>
        <option <?php echo $telaT3 = ($resultado['tipo']=="GENTE") ? "selected" : "" ; ?> >GENTE</option>
        <option <?php echo $telaT4 = ($resultado['tipo']=="GESTOR") ? "selected" : "" ; ?>>GESTOR</option>
        <option <?php echo $telaT5 = ($resultado['tipo']=="LOG") ? "selected" : "" ; ?>>LOG</option>
        <option <?php echo $telaT6 = ($resultado['tipo']=="PORT") ? "selected" : "" ; ?>>PORT</option>
        <option <?php echo $telaT7 = ($resultado['tipo']=="ROOT") ? "selected" : "" ; ?>>ROOT</option>
    </select><br/><br/>
    <hr class="form col-sm-7 pull-left" />
    <input type="hidden" name="Funcao" value="<?php echo $tela = (isset($_REQUEST['inserir'])) ? 1 : 2 ; ?>" readonly="readonly" />
</fieldset>
<input name="Enviar" type="submit" class="enviar radius" value="Salvar" 
       onsubmit="return validarSenha();" /> <i class="fas fa-arrow-circle-right"></i><br/><br/>
</fieldset> 
</form>
</div>
<script type="text/javascript">
            var navegador = ObterBrowserUtilizado();
            var tela = ObterTela();
            var data = document.getElementById("Nascimento").value;
            if (navegador!=="Google Chrome" && tela && (data.substring(3,2)!=="/")) {
                var data = document.getElementById("Nascimento").value;
                var datatxt = InverterData(data);
                document.getElementById("Nascimento").value = datatxt;

                var data = document.getElementById("Admissao").value;
                var datatxt = InverterData(data);
                document.getElementById("Admissao").value = datatxt;
            }
        </script>
<?php elseif(isset($_REQUEST['import'])):?>
    <div class="texto">
        <h3><i class="fas fa-list-ol"></i> UpLoad Arquivo Egente</h3><br/>
        <ul class="formmenu">
            <li><a href="cadastro.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
            <li><a href="_download/PadraoEgenteQLP.zip"><i class="fas fa-file-excel"></i> Download da Planilha Padrão</a><br/><br/></li> 
        </ul><br/><br/>
        <form name="formCadastro" class="formmenu" action="_controller/controllerInserirQLP.php" 
            method="POST" enctype="multipart/form-data">
            <label for="arquivo" >Arquivo (*.xml) do Excel</label> 
            <input type="file" required id="arquivo"  name="arquivo" class="form-control col-sm-6"/><br/>
            <input type="hidden" value="1" name="Funcao" readonly="readonly" />
            <input name="tEnviar" type="submit" class="enviar radius" value="Enviar"/>
            <i class="fas fa-arrow-circle-right"></i>
        </form>
</div>
<?php elseif(isset($_REQUEST['area'])): 
    require_once '_model/area.php';
    $area = new area($conexao);
    $consulta = $area->consult();?>
    <form name="formArea" class="formmenu" action="_controller/controllerArea.php" method="POST" enctype="multipart/form-data">
        <?php 
            foreach ($consulta as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    switch ($key2) {
                        case 'id_area':
                            echo "<input type='hidden' size='2' readonly='readonly id='id_area$key' name='id_area$key' value='$value2'/> ";
                            break;
                        case 'nome':
                            echo "<label for='area$key'>Área:</label> 
                                <input class='form-control col-sm-8' type='text' size='15' id='area$key' name='area$key' value='$value2' /> ";
                            break;
                        case 'matricula':
                            echo "<label for='id_resp$key'>Resp: </label> 
                                <input class='form-control col-sm-8' type='text' size='4' id='id_resp$key' name='id_resp$key' value='$value2' /> ";
                            break;
                    }
                } echo "<br/><br/>";
            }
            $total = count($consulta);
            echo "<span id='new' class='null'>
                <input type='hidden' size='2' readonly='readonly id='id_area$total' name='id_area$total'/> ";
            echo "<label for='area$total'>Área: </label> 
                <input type='text' size='15' id='area$total' name='area$total' /> ";
            echo "<label for='id_resp$total'>Resp: </label> 
                <input type='text' size='4' id='id_resp$total' name='id_resp$total' /></span><br/> ";?>
        <input type="hidden" value="<?php echo $total;?>" name="Total" readonly="readonly" />
        <input name="Enviar" type="submit" class="enviar radius" value="Salvar" /><i class="fas fa-arrow-circle-right"></i>
    </form>
    <button onclick="mostrarArea()"><i class="fas fa-angle-double-left"></i>Nova Área</button><br/><br/>
    <a href="_page/relatorioArea.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a>
<?php else:?>
    <div class="texto">
        <ul class="formmenu">
            <li><a href="cadastro.php?import=true" > <i class="fas fa-sign-out-alt"></i> Importar Planilha QLP</a></li> 
            <li><a href="cadastro.php?consultar=true&inserir=true" > <i class='fas fa-address-book'></i> Criar Usuário</a></li>
            <li><a href="cadastro.php?area=true" ><i class='fas fa-chalkboard-teacher'></i>  Áreas</a></li>  
        </ul>
    <form method="POST" class="formmenu" name="formCadastro" 
        action="cadastro.php" onsubmit="return validaCadastro();" >
        <fieldset id="sexo"><legend>Dados do Usuário</legend>
        <label for="consultar">Nome.:</label><input type="text" name="consultar" id="consultar" 
            required autofocus size="30" class="form-control col-sm-8" maxlength="60" placeholder="Nome"/><br/>
        </fieldset>
    <div class="btndireita">
        <input name="Enviar" type="submit" class="enviar radius" value="Consultar"  /> <i class="fas fa-arrow-circle-right"></i>
    </div>
    <br/><br/>
</fieldset> 
</form>
    </div>
<?php endif;?>
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