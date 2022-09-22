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
    require_once './_model/colaborador.php';
    $colaborador = new colaborador($conexao);
    if (isset($_REQUEST['consultar'])) {
        $nome = htmlspecialchars($_REQUEST['consultar']);
        $resultado = $colaborador->findName($nome);
    }
    require_once './_model/medclin.php';
    $entrevista = new medclin($conexao);
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Cadastro</h3>
<h1><i class='fas fa-stethoscope'></i> Lançamento Medclin</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="login.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['consultar']) || isset($_REQUEST['inserir'])):?>

<div class="texto">
    <ul class="formmenu">
        <li><a href="medclin.php.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
        <li><a href="_page/relatorioMedclin.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a><br/><br/></li> 
    </ul><br/><br/>
<form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formMedclinConsulta" 
      action="medclin.php" onsubmit="return validaCadastro();" >
        <label for="consulta">Data da Consulta.:</label>
        <input type="date" name="dataconsul" required class="form-control col-sm-3" id="dataconsul" placeholder="consulta" value="<?php echo $telaA = (count($resultado)>0) ? date('Y-m-d') : "" ; ?>"/><br/>
           <input type="hidden" name="mat" value="<?php echo $telaB = (count($resultado)>0) ? $resultado['matricula'] : "" ; ?>" readonly="readonly" />
           <input type="hidden" name="consultar" value="<?php echo $telaC = (count($resultado)>0) ? $resultado['nome'] : "" ; ?>" readonly="readonly" /> 
    <input name="btn" type="submit" class="enviar radius" value="Consultar" 
       onsubmit="return validarSenha();" /><i class="fas fa-arrow-circle-right"></i><br/><br/>
    <hr class="form col-sm-7 pull-left"/>
</form>
<form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formMedclin" 
      action="_controller/controllerMedclin.php" onsubmit="return validaCadastro();" >
    <fieldset id="usuario"><legend>
        Medclin</legend>
    </fieldset>
    <fieldset id="sexo"><legend>Dados do Usuário</legend>
    <input type="hidden" name="Mat" id="Mat" 
      size="15" maxlength="15" placeholder="Matricula" readonly='readonly'
        value="<?php echo $telaM = (count($resultado)>0) ? $resultado['matricula'] : "" ; ?>"/><br/>

    <label for="Nome">Nome .:</label><input type="text" name="Nome" id="Nome" 
      size="30" maxlength="50" class="form-control col-sm-8" placeholder="Nome Completo" readonly='readonly'
      value="<?php echo $telaN = (count($resultado)>0) ? $resultado['nome'] : "" ; ?>"/><br/>
    
    <label for="Setor">Setor . :</label><input type="text" name="Setor" 
           id="Setor" size="30" maxlength="30" class="form-control col-sm-8" placeholder="Setor" readonly='readonly'
           value="<?php echo $telaS = (count($resultado)>0) ? $resultado['setor'] : "" ; ?>" /><br/>

    <label for="Cargo">Cargo.:</label><input type="text" name="Cargo" 
           id="Cargo" size="30" maxlength="30" class="form-control col-sm-8" placeholder="Cargo" readonly='readonly'
           value="<?php echo $telaZ = (count($resultado)>0) ? $resultado['cargo'] : "" ; ?>" /><br/>
    <?php $exec = false;
        $mat = (isset($_REQUEST['mat'])) ? htmlspecialchars($_REQUEST['mat']) : "";
        if (isset($_REQUEST['dataconsul'])) {
                $dataD = $url->converterData(htmlspecialchars($_REQUEST['dataconsul']));
                $data = date("Y-m-d", strtotime($dataD));
                $keyData = $mat . "_" . $data;
            } else {
                $data = date("Y-m-d");
                $keyData = $mat . "_" . $data;
            }
            $resultado = $entrevista->find($keyData);
    ?>
    <hr class="form col-sm-7 pull-left"/>
    <label for="data">Data.:</label><input type="date" name="data" class="form-control col-sm-3"
           id="data" placeholder="data" required
           value="<?php  echo $telaD1 = (count($resultado)>1) ? $resultado['Data Atend'] : date('Y-m-d') ; ?>"/><br/>
    
    <label for="prontuario">Nº do Prontuário.:</label>
    <input type="number" name="prontuario" class="form-control col-sm-8" required
        value="<?php  echo $telaD2 = (count($resultado)>1) ? $resultado['Prontuario'] : date('Y-m-d') ; ?>" /> <br/>
    
    
    <label for="Tipo">Tipo.:</label>
    <select name="Tipo" id="Tipo" class="form-control col-sm-8">
        <option <?php echo $tela1 = ($resultado['Tipo']=="ADMISSIONAL") ? "selected" : "" ;  ?> >ADMISSIONAL</option>
        <option <?php echo $tela2 = ($resultado['Tipo']=="CONSULTA") ? "selected" : "" ; ?>>CONSULTA</option>
        <option <?php echo $tela3 = ($resultado['Tipo']=="DEMISSIONAL") ? "selected" : "" ; ?>>DEMISSIONAL</option>
        <option <?php echo $tela4 = ($resultado['Tipo']=="MUD. FUNÇÃO") ? "selected" : "" ; ?>>MUD. FUNÇÃO</option>
        <option <?php echo $tela5 = ($resultado['Tipo']=="PERIÓDICO") ? "selected" : "" ; ?>>PERIÓDICO</option>
        <option <?php echo $tela6 = ($resultado['Tipo']=="READMISSÃO") ? "selected" : "" ; ?>>READMISSÃO</option>
        <option <?php echo $tela7 = ($resultado['Tipo']=="RET. AO TRABALHO") ? "selected" : "" ; ?>>RET. AO TRABALHO</option>
        <option <?php echo $tela8 = ($resultado['Tipo']=="REVISÃO") ? "selected" : "" ; ?>>REVISÃO</option>
    </select><br/>
    <hr class="form col-sm-7 pull-left"/>
    <label for="cid">CID.:</label>
    <select name="cid" id="cid" class="form-control col-sm-8">
        <?php $motivoSelecionado = $resultado['motivo'];
              $consultacid = $entrevista->listarCid();
              $s = 'selected';
              $cidResul = (count($resultado)>1) ? $resultado['CID'] : "" ;
              foreach ($consultacid as $key => $value) {
                    $cid = $value['DESCRABREV'];
                    
                    if ($cidResul == $value['CAT']) {
                        echo "<option $s >$cid</option>";
                    } else {
                        echo "<option >$cid</option>";
                    }
              }  
        ?>
    </select><br/>
    <hr class="form col-sm-7 pull-left"/>
    <label for="tempo">Tempo Afastado.:</label>
    <input type="number" name="tempo" class="form-control col-sm-8" required
        value="<?php  echo $telaT = (count($resultado)>1) ? $resultado['Tempo'] : "" ; ?>" /> <br/>
    

    <label for="unidtempo">Unidade do Tempo =></label>
    <select name="unidtempo" id="unidtempo" class="form-control col-sm-2">
        <option  <?php echo $telaDia = ($resultado['UnidTempo']=="Dia") ? "selected" : "" ; ?>>Dia</option>
        <option <?php echo $telaHora = ($resultado['UnidTempo']=="Hora") ? "selected" : "" ; ?>>Hora</option>
        <option <?php echo $telaMinuto = ($resultado['UnidTempo']=="Minuto") ? "selected" : "" ; ?>>Minuto</option>
        <option <?php echo $telaSemana = ($resultado['UnidTempo']=="Semana") ? "selected" : "" ; ?>>Semana</option>
        <option <?php echo $telaMes = ($resultado['UnidTempo']=="Mês") ? "selected" : "" ; ?>>Mês</option>
        <option <?php echo $telaAno = ($resultado['UnidTempo']=="Ano") ? "selected" : "" ; ?>>Ano</option>
    </select><br/>
    <hr class="form col-sm-7 pull-left"/>
    <label for="Inicio">Início do atestado.:</label><input type="date" name="Inicio" 
           id="Inicio" placeholder="Início" class="form-control col-sm-3" required
           value="<?php echo $telaInicio = (count($resultado)>1) ? $resultado['Inicio'] : date("Y-m-d") ; ?>"/><br/>
           
    <label for="Fim">Fim de atestado.:</label><input type="date" name="Fim" 
           id="Fim" placeholder="Fim" class="form-control col-sm-3" required
           value="<?php echo $telaFim = (count($resultado)>1) ? $resultado['Fim'] : date("Y-m-d") ; ?>"/><br/>
    
    <label for="Obs">Comentários Adicionais:</label><br/>
    <textarea name="Obs" class="form-control col-sm-8" >
        <?php echo $telaObs = (count($resultado)>1) ? $resultado['obs'] : "" ; ?>
    </textarea>
    <br/><br/>
    <input type="hidden" name="Funcao" value="<?php echo $telaFuncao = (isset($_REQUEST['inserir'])) ? 1 : 2 ; ?>" readonly="readonly" />
</fieldset>
<input name="Enviar" type="submit" class="enviar radius" value="Salvar"  /><i class="fas fa-arrow-circle-right"></i><br/><br/>
</fieldset> 
</form>
</div>
<script type="text/javascript">
            var navegador = ObterBrowserUtilizado();
            var tela = ObterTela();
            var data = document.getElementById("Inicio").value;
            if (navegador!=="Google Chrome" && tela && (data.substring(3,2)!=="/")) {
                var data = document.getElementById("Inicio").value;
                var datatxt = InverterData(data);
                document.getElementById("Inicio").value = datatxt;

                var data = document.getElementById("Fim").value;
                var datatxt = InverterData(data);
                document.getElementById("Fim").value = datatxt;

                var data = document.getElementById("data").value;
                var datatxt = InverterData(data);
                document.getElementById("data").value = datatxt;

                var data = document.getElementById("dataconsul").value;
                var datatxt = InverterData(data);
                document.getElementById("dataconsul").value = datatxt;
            }
        </script>
<?php else:?>
    <div class="texto">
        <ul class="formmenu">
            <li><a href="medclin.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
            <li><a href="_page/relatorioMedclin.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a></li> 
        </ul><br/>
    <form method="POST" class="formmenu" name="formCadastro" 
          action="medclin.php" onsubmit="return validaCadastro();" ><br/>
        <fieldset id="usuario"><legend>Dados do Usuário</legend>
        <label for="consultar">Nome.:</label><input type="search" name="consultar" id="consultar" 
            required autofocus size="30" class="form-control col-sm-6" maxlength="60" placeholder="Nome"/><br/>
        </fieldset>
    <input name="inserir" type="hidden" class="enviar radius" value="inserir" />
    <div class="btndireita">
    <input name="Enviar" type="submit" class="enviar radius" value="Consultar" /> <i class="fas fa-arrow-circle-right"></i></div>
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