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
    require_once './_model/entrevista.php';
    $entrevista = new entrevista($conexao);
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Entrevista</h3>
<h1><i class="fas fa-address-card"></i> Entrevista de Absenteísmo</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="login.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['consultar']) || isset($_REQUEST['inserir'])):?>
<div class="texto">
    <ul class="formmenu">
        <li><a href="entrabs.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
        <li><a href="_page/relatorioEntrevista.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a><br/><br/></li> 
    </ul><br/><br/>
    <form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formEntrevsitaConsulta" 
            action="entrabs.php" >
            <label for="consulta">Data da Entrevista.:</label>
               <input type="date" required class="form-control col-sm-3" name="dataconsul" id="dataconsul" placeholder="consulta" value="<?php echo $telaD = (count($resultado)>0) ? date('Y-m-d') : "" ; ?>"/><br/>
               <input type="hidden" name="mat" value="<?php echo $telaM = (count($resultado)>0) ? $resultado['matricula'] : "" ; ?>" readonly="readonly" />
               <input type="hidden" name="consultar" value="<?php echo $telaR = (count($resultado)>0) ? $resultado['nome'] : "" ; ?>" readonly="readonly" /> 
        <input name="btn" type="submit" class="enviar radius" value="Consultar" 
           onsubmit="return validarSenha();" /><i class="fas fa-arrow-circle-right"></i><br/><br/> 
        <hr class="form col-sm-7 pull-left"/>
    </form>
    <form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formEntrevista" 
        action="_controller/controllerEntrevista.php" onsubmit="return validaEntrevista();" >
    <fieldset id="usuario"><legend>
        Entrevista de Absenteísmo</legend>
    </fieldset>
    <fieldset id="entrevista"><legend>Dados do Usuário</legend>
    <input type="hidden" name="Mat" id="Mat" 
      size="15" maxlength="15" placeholder="Matricula" readonly='readonly'
        value="<?php echo $telaM = (count($resultado)>0) ? $resultado['matricula'] : "" ; ?>"/>
    <label for="Nome">Nome.:</label><input class="form-control col-sm-8" type="text" name="Nome" id="Nome" 
      size="30" maxlength="50" placeholder="Nome Completo" readonly='readonly'
      value="<?php echo $telaN = (count($resultado)>0) ? $resultado['nome'] : "" ; ?>"/>
    
    <label for="Setor">Setor . :</label><input class="form-control col-sm-8" type="text" name="Setor" 
           id="Setor" size="30" maxlength="30" placeholder="Setor" readonly='readonly'
           value="<?php echo $telaS = (count($resultado)>0) ? $resultado['setor'] : "" ; ?>" />

    <label for="Cargo">Cargo.:</label><input class="form-control col-sm-8" type="text" name="Cargo" 
           id="Cargo" size="30" maxlength="30" placeholder="Cargo" readonly='readonly'
           value="<?php echo $telaC = (count($resultado)>0) ? $resultado['cargo'] : "" ; ?>" />
    <?php $exec = false;
        $mat = (isset($_REQUEST['mat'])) ? htmlspecialchars($_REQUEST['mat']) : "";
        if (isset($_REQUEST['dataconsul'])) {
                $dataC = $url->converterData(htmlspecialchars($_REQUEST['dataconsul']));
                $data = date("Y-m-d", strtotime($dataC));
                $keyData = $mat . "_" . $data;
            } else {
                $data = date("Y-m-d");
                $keyData = $mat . "_" . $data;
            }
            $resultado = $entrevista->find($keyData);
    ?>
    <hr class="form col-sm-7 pull-left"/>
    <label for="Tipo">Tipo.:</label>
    <select name="Tipo" id="Tipo" class="form-control col-sm-8">
        <?php $tipo = ($resultado) ? $resultado['tipo'] : null;?>
        <option <?php echo $tela1 = ($tipo=="JUSTIFICADA") ? "selected" : "" ;  ?> >JUSTIFICADA</option>
        <option <?php echo $tela2 = ($tipo=="NÃO JUSTIFICADA") ? "selected" : "" ; ?>>NÃO JUSTIFICADA</option>
        <option <?php echo $tela3 = ($tipo=="PREVISTAS POR LEI") ? "selected" : "" ; ?>>PREVISTAS POR LEI</option>
    </select>
    <hr class="form col-sm-7 pull-left"/>
    <label for="data">Data da Entrevista.:</label><input type="date" name="data" required
           id="data" placeholder="data" class="form-control col-sm-3"
           value="<?php  echo $telaE = (count($resultado)>1) ? $resultado['data'] : date('Y-m-d') ;?>" 
           max="<?php $Hoje = date("Y-m-d"); echo "$Hoje"; ?>" /><br/>

    <label for="Motivo">Motivo de Falta.:</label>
    <select name="Motivo" id="Motivo" class="form-control col-sm-8">
        <?php $motivo = ($resultado) ? $resultado['motivo'] : null;?>
        <option <?php echo $tela11 = ($motivo=="Saúde - com atestado Médico") ? "selected" : "" ; ?> >Saúde - com atestado Médico</option>
        <option <?php echo $tela12 = ($motivo=="Saúde - sem atestado Médico") ? "selected" : "" ; ?> >Saúde - sem atestado Médico</option>
        <option <?php echo $tela13 = ($motivo=="Problemas pessoais") ? "selected" : "" ; ?>>Problemas pessoais</option>
        <option <?php echo $tela14 = ($motivo=="Problemas familiares") ? "selected" : "" ; ?>>Problemas familiares</option>
        <option <?php echo $tela15 = ($motivo=="Dificuldade de transporte") ? "selected" : "" ; ?>>Dificuldade de transporte</option>
        <option <?php echo $tela16 = ($motivo=="Excesso jornada dia anterior") ? "selected" : "" ; ?>>Excesso jornada dia anterior</option>
        <option <?php echo $tela17 = ($motivo=="Compromissos Oficiais") ? "selected" : "" ; ?>>Compromissos Oficiais</option>
        <option <?php echo $tela18 = ($motivo=="Descomprometimento") ? "selected" : "" ; ?>>Descomprometimento</option>
        <option <?php echo $tela19 = ($motivo=="Descontentamento / Protesto") ? "selected" : "" ; ?>>Descontentamento / Protesto</option>
        <option <?php echo $tela20 = ($motivo=="Abandono de emprego") ? "selected" : "" ; ?>>Abandono de emprego</option>
        <option <?php echo $tela21 = ($motivo=="Licença Paternidade") ? "selected" : "" ; ?>>Licença Paternidade</option>
        <option <?php echo $tela22 = ($motivo=="Licença Casamento") ? "selected" : "" ; ?>>Licença Casamento</option>
        <option <?php echo $tela23 = ($motivo=="Doação de Sangue") ? "selected" : "" ; ?>>Doação de Sangue</option>
        <option <?php echo $tela24 = ($motivo=="Exame Escolar / Vestibular") ? "selected" : "" ; ?>>Exame Escolar / Vestibular</option>
        <option <?php echo $tela25 = ($motivo=="Falecimento parente/cônjuge") ? "selected" : "" ; ?>>Falecimento parente/cônjuge</option>
        <option <?php echo $tela26 = ($motivo=="Audiência / Convocação") ? "selected" : "" ; ?>>Audiência / Convocação</option>
    </select>
    <hr class="form col-sm-7 pull-left"/>
    <div class="radio">
    <label for="semjust">Ocorrência de falta(s) anterior(es) sem justificativa ?</label>
        <?php $semajust = ($resultado) ? $resultado['semjust'] : null;?>
        <input type="radio" name="semjust" id="SemJustificativa1" value="S" <?php echo $telaS2 = ($semajust=="S") ? "checked='checked'" : "" ; ?> />Sim 
        <input type="radio" name="semjust" id="SemJustificativa2" value="N" <?php echo $telaN2 = ($semajust=="N") ? "checked='checked'" : "" ; ?> />Não
    </div>
    <div class="radio">
    <label for="comprevia">Comunicação prévia desta(s) falta(s) à empresa ?</label>
        <?php $comprevia = ($resultado) ? $resultado['comprevia'] : null;?>
        <input type="radio" name="comprevia" id="ComunicarPrevia1" value="S" <?php echo $telaS3 = ($comprevia=="S") ? "checked='checked'" : "" ; ?> />Sim 
        <input type="radio" name="comprevia" id="ComunicarPrevia2" value="N" <?php echo $telaN3 = ($comprevia=="N") ? "checked='checked'" : "" ; ?> />Não
    </div>
    <div class="radio">
    <label for="justicomp">Apresentação de justificativa compatível (ausência)  ? </label>
        <?php $justicomp = ($resultado) ? $resultado['justicomp'] : null;?>
        <input type="radio" name="justicomp" id="JustificativaCompativel1" value="S" <?php echo $telaCD = ($justicomp=="S") ? "checked='checked'" : "" ; ?>/>Sim 
        <input type="radio" name="justicomp" id="JustificativaCompativel2" value="N" <?php echo $telaED = ($justicomp=="N") ? "checked='checked'" : "" ; ?> />Não
    </div>
    <hr class="form col-sm-7 pull-left"/>
    <label for="Acao">Ação Tomada =></label>
    <select name="Acao" id="Acao" class="form-control col-sm-8">
        <?php $acao = ($resultado) ? $resultado['acao'] : null;?>
        <option <?php echo $tela31 = ($acao=="Reciclagem treinamento / foco normas empresa") ? "selected" : "" ; ?>>Reciclagem treinamento / foco normas empresa</option>
        <option <?php echo $tela32 = ($acao=="Advertência verbal") ? "selected" : "" ; ?>>Advertência verbal</option>
        <option <?php echo $tela33 = ($acao=="Advertência escrita") ? "selected" : "" ; ?>>Advertência escrita</option>
        <option <?php echo $tela34 = ($acao=="Suspensão") ? "selected" : "" ; ?>>Suspensão</option>
        <option <?php echo $tela35 = ($acao=="Demissão") ? "selected" : "" ; ?>>Demissão</option>
    </select>
    <hr class="form col-sm-7 pull-left"/>  
    <div class="radio">
    <label for="acatada">Justificativa para a falta acatada pela empresa ? .</label>
        <?php $acatada = ($resultado) ? $resultado['acatada'] : null;?>
        <input type="radio" name="acatada" id="AcatadaPelaEmpresa1" value="S" <?php echo $telaR1 = ($acatada=="S") ? "checked='checked'" : "" ; ?> />Sim 
        <input type="radio" name="acatada" id="AcatadaPelaEmpresa2" value="N" <?php echo $telaR2 = ($acatada=="N") ? "checked='checked'" : "" ; ?>/>Não
    </div>
    <div class="radio">
        <label for="diadescontado">Dia de Trabalho descontado ?</label>
        <?php $diadescontado = ($resultado) ? $resultado['diadescontado'] : null;?>
        <input type="radio" name="diadescontado" id="DiaDescontado1" value="S" <?php echo $telaR3 = ($diadescontado=="S") ? "checked='checked'" : "" ; ?>/>Sim 
        <input type="radio" name="diadescontado" id="DiaDescontado2" value="N" <?php echo $telaR4 = ($diadescontado=="N") ? "checked='checked'" : "" ; ?> />Não
    </div>
    <div class="radio">
        <label for="alinhada">Falta poderia ter sido evitada através de folga alinhada ?</label>
        <?php $alinhada = ($resultado) ? $resultado['alinhada'] : null;?>
        <input type="radio" name="alinhada" id="FolgaAlinhada1" value="S" <?php echo $telaR5 = ($alinhada=="S") ? "checked='checked'" : "" ; ?>/>Sim 
        <input type="radio" name="alinhada" id="FolgaAlinhada2" value="N" <?php echo $telaR6 = ($alinhada=="N") ? "checked='checked'" : "" ; ?> />Não
    </div>
    <hr class="form col-sm-7 pull-left"/>
    <label for="Inicio">Início do atestado.:</label><input type="date" name="Inicio" 
           id="Inicio" placeholder="Início" required class="form-control col-sm-3"
           value="<?php echo $telaA1 = (count($resultado)>1) ? $resultado['inicio'] : date("Y-m-d") ; ?>"/><br/>
           
    <label for="Fim">Fim de atestado.:</label><input type="date" name="Fim" 
           id="Fim" placeholder="Fim" required class="form-control col-sm-3"
           value="<?php echo $telaA2 = (count($resultado)>1) ? $resultado['fim'] : date("Y-m-d") ; ?>"/><br/>
    
    <label for="Obs">Comentários Adicionais / RH e Liderança:</label><br/>
    <textarea class="form-control col-sm-8" name="Obs" >
        <?php $obs = ($resultado) ? $resultado['obs'] : null;
              echo $telaObs = (!is_null($obs)) ? $obs : ""; ?>
    </textarea>
    <br/><br/>
    <input type="hidden" name="Funcao" value="<?php echo $tela = (isset($_REQUEST['inserir'])) ? 1 : 2 ; ?>" readonly="readonly" />
</fieldset>
<input name="Enviar" type="submit" class="enviar radius" value="Salvar"  />
        <i class="fas fa-arrow-circle-right"></i><br/><br/>
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
            <li><a href="entrabs.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
            <li><a href="_page/relatorioEntrevista.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a><br/><br/></li> 
        </ul><br/>
    <form method="POST" class="formmenu" name="formCadastro" 
        action="entrabs.php" onsubmit="return validaCadastro();" ><br/>
        <fieldset id="sexo"><legend>Dados do Usuário</legend>
            <div class="form-group"> <!-- form bootstrap -->
                <label for="consultar" class="col-sm-2 control-label">Nome.:</label>
                <div class="col-sm-8">
                    <input type="search" class="form-control" name="consultar" id="consultar" 
                        required autofocus size="30" maxlength="60" placeholder="Nome"/><br/>
                </div>
            </div>
        </fieldset>
    <input name="inserir" type="hidden" class="enviar radius" value="inserir" />
    <div class="btndireita">
        <input name="Enviar" type="submit" class="enviar radius" value="Consultar" /> <i class="fas fa-arrow-circle-right"></i>
    </div><br/><br/>
</fieldset> 
</form>
    </div>
<?php endif;?>
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