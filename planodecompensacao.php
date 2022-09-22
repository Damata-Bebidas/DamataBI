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
    require_once './_model/planobh.php';
    $plano = new planobh($conexao);
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Plano de Compensação</h3>
<h1><i class="fas fa-file-excel"></i> Plano de Compensação</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="user.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['consultar']) || isset($_REQUEST['inserir'])):?>
<div class="texto">
    <ul class="formmenu">
        <li><a href="planodecompensacao.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
        <li><a href="planodecompensacao.php?find=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a><br/><br/></li> 
    </ul><br/><br/>
    <form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formplanobhdata" action="planodecompensacao.php"  >
            <label for="consulta">Data da Folga/Planejamento.:</label>
               <input type="date" required class="form-control col-sm-3" name="dataconsul" id="dataconsul" placeholder="consulta" value="<?php echo $telaD = (count($resultado)>0) ? date('Y-m-d') : "" ; ?>"/><br/>
               <input type="hidden" name="mat" value="<?php echo $telaM = (count($resultado)>0) ? $resultado['matricula'] : "" ; ?>" readonly="readonly" />
               <input type="hidden" name="consultar" value="<?php echo $telaR = (count($resultado)>0) ? $resultado['nome'] : "" ; ?>" readonly="readonly" /> 
        <input name="btn" type="submit" class="enviar radius" value="Consultar" 
           onsubmit="return validarSenha();" /><i class="fas fa-arrow-circle-right"></i><br/><br/> 
        <hr class="form col-sm-7 pull-left"/>
    </form>
    <form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formplanobh" action="_controller/controllerPlanoBH.php" onsubmit="return validaPlanoBH();" >
    <fieldset id="usuario"><legend>
        Plano de Compensação</legend>
    </fieldset>
    <fieldset id="entrevista"><legend>Dados do Usuário</legend>
    <input type="hidden" name="mat" id="mat" 
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
            } else {
                $data = date("Y-m-d");
                $keyData = $mat . "_" . $data;
            }
            $resultado = $plano->findDate($mat,$data);
    ?>
    <hr class="form col-sm-7 pull-left"/>
    <label for="saldo">Saldo.:</label><input type="number" name="saldo" id="saldo" placeholder="Saldo Atual" class="form-control col-sm-2"
        required   value="<?php  echo $telaE = (count($resultado)>1) ? $resultado['saldo'] : "" ;?>" /><br/>
    
    <label for="abatido">Saldo que será abatido.:</label><input type="number" name="abatido" required
           id="abatido" placeholder="Saldo que será abatido" class="form-control col-sm-2"
           value="<?php  echo $telaSA = (count($resultado)>1) ? $resultado['abatido'] : "" ;?>" /><br/>
    
    <label for="pagarcomp">Pagar ou Compensar?.:</label>
    <div class="radio">
        <input type="radio" id="pagarcomp" name="pagarcomp" value="F" 
            <?php  echo $telaSA = ($resultado['PagarCompensar']=="F") ? 'checked="checked"' : '' ; ?> />  Folgar 
        <input type="radio" id="pagarcomp" name="pagarcomp" value="P" 
            <?php  echo $telaSA = ($resultado['PagarCompensar']=="P") ? 'checked="checked"' : '' ;?>/>  Pagar <br/>
    </div>
    <hr class="form col-sm-7 pull-left"/>
    <label for="data">Data que será abatida.:</label><input type="date" name="data" 
           id="data" placeholder="data" required class="form-control col-sm-3"
           value="<?php echo $telaA1 = (count($resultado)>1) ? $resultado['data'] : date("Y-m-d") ; ?>"/><br/>
    
    <label for="status">Status.:</label>
    <select name="status" id="status" class="form-control col-sm-3">
        <option <?php echo $tela11 = ($resultado['status']=="") ? "selected" : "" ; ?> ></option>
        <option <?php echo $tela11 = ($resultado['status']=="OK") ? "selected" : "" ; ?> >OK</option>
        <option <?php echo $tela12 = ($resultado['status']=="Programado") ? "selected" : "" ; ?> >Programado</option>
        <option <?php echo $tela13 = ($resultado['status']=="Não Fez") ? "selected" : "" ; ?>>Não Fez</option>
    </select>
    <hr class="form col-sm-7 pull-left"/>
    <label for="autorizado">Autorizado por quem?</label>
    <select name="autorizado" id="autorizado" class="form-control col-sm-6">
        <option  <?php echo $tela31 = ($resultado['autorizado']=="") ? "selected" : "" ; ?>></option>
        <option  <?php echo $tela31 = ($resultado['autorizado']==97) ? "selected" : "" ; ?>>ALQUINDAR DA SILVA PEREIRA</option>
        <option <?php echo $tela32 = ($resultado['autorizado']==16) ? "selected" : "" ; ?>>ARGEU ANTONIO HENRIQUES</option>
        <option <?php echo $tela33 = ($resultado['autorizado']==1476) ? "selected" : "" ; ?>>CAROLINE PIRES DE SOUZA</option>
        <option <?php echo $tela35 = ($resultado['autorizado']==103) ? "selected" : "" ; ?>>FARID CALIL</option>
        <option <?php echo $tela35 = ($resultado['autorizado']==82) ? "selected" : "" ; ?>>JOSE DOMINGOS SILVA CONTE</option>
        <option <?php echo $tela35 = ($resultado['autorizado']==45) ? "selected" : "" ; ?>>JULIO CESAR SILVA XAVIER</option>
        <option <?php echo $tela35 = ($resultado['autorizado']==4) ? "selected" : "" ; ?>>JULIO SERGIO CARMO MORAIS</option>
        <option <?php echo $tela35 = ($resultado['autorizado']==566) ? "selected" : "" ; ?>>LILIAN DE OLIVEIRA RODRIGUES</option>
        <option <?php echo $tela35 = ($resultado['autorizado']==827) ? "selected" : "" ; ?>>MARCOS CESAR MARIANO ZAMBONI</option>
        <option <?php echo $tela35 = ($resultado['autorizado']==1228) ? "selected" : "" ; ?>>WILLIAN DE ALMEIDA LORENZETTO</option>
        <option <?php echo $tela35 = ($resultado['autorizado']==1351) ? "selected" : "" ; ?>>FRANCISCO ARLEN DOS SANTOS</option>
        <option <?php echo $tela35 = ($resultado['autorizado']==100) ? "selected" : "" ; ?>>VIRGÍNIA RIBEIRO</option>
    </select>
    <hr class="form col-sm-7 pull-left"/>  
    <label for="obs">Comentários Adicionais / RH e Liderança:</label><br/>
    <textarea class="form-control col-sm-8" name="obs" >
        <?php echo $telaObs = (count($resultado)>1) ? $resultado['obs'] : "" ; ?>
    </textarea>
    <br/><br/>
    <input type="hidden" name="id" value="<?php echo $telaID = (count($resultado)>1) ? $resultado['id'] : "" ; ?>" readonly="readonly" />
    <input type="hidden" name="funcao" value="<?php echo $tela = (isset($_REQUEST['inserir'])) ? 1 : 2 ; ?>" readonly="readonly" />
</fieldset>
<input name="Enviar" type="submit" class="enviar radius" value="Salvar"  />
        <i class="fas fa-arrow-circle-right"></i><br/><br/>
</fieldset> 
</form>
</div>
        <script type="text/javascript">
            var navegador = ObterBrowserUtilizado();
            var tela = ObterTela();
            var data = document.getElementById("data").value;
            if (navegador!=="Google Chrome" && tela && (data.substring(3,2)!=="/")) {

                var data = document.getElementById("data").value;
                var datatxt = InverterData(data);
                document.getElementById("data").value = datatxt;

                var data = document.getElementById("dataconsul").value;
                var datatxt = InverterData(data);
                document.getElementById("dataconsul").value = datatxt;
            }
        </script>
<!-- ---------------------------------- tabela ---------------------------------------------------------------- -->
<?php elseif(isset($_REQUEST['find'])):?>
    <div class="texto">
        <a href="planodecompensacao.php"> <i class="fas fa-paper-plane"></i> Novo </a><br/><br/>
        <?php
            require_once '_model/planobh.php';
            $plano = new planobh($conexao);
            if (isset($_REQUEST['inicio'])) {
                $inicio = $url->converterData($_REQUEST['inicio']);
                $fim = $url->converterData($_REQUEST['fim']);
                $resultado = $plano->findFilter($inicio, $fim);
            } else {
                $inicio = date('Y-m') . "-1";
                $fim = date('Y') . "-12-1";
                $resultado = $plano->findFilter($inicio, $fim);
            } 
        ?>
        <form name="formData"  class="formmenu" action="planodecompensacao.php" method="POST" enctype="multipart/form-data">
            <input type="date" name="inicio" id="inicio" required autofocus 
            <?php if (isset($_REQUEST['inicio'])) { 
                $data = htmlspecialchars($_REQUEST['inicio']);
                echo "value='$data'";
            } else { 
                $hoje = date('Y-m') . "-01";
                echo "value='$hoje'";
            }?> />
            a <input type="date" name="fim" id="fim" required autofocus 
            <?php if (isset($_REQUEST['fim'])) { 
                $data = htmlspecialchars($_REQUEST['fim']);
                echo "value='$data'";
            } else { 
                $hoje = date('Y')."-12-31";
                echo "value='$hoje'";
            }?> />
            <input type="hidden" value="true" name="find" readonly="readonly" />
            <input name="tEnviar" type="submit" class="enviar radius" value="Consultar"/>
            <i class="fas fa-arrow-circle-right"></i>
        </form><br/>
        <?php
            //paginacao na tabela php
            echo "<form method='POST' action='planodecompensacao.php' name='formPaginacao' >";
            $intervalo = 20; 
            $tt = count($resultado);
            $valor = $tt/$intervalo;
            $fracionar = ceil ($valor);
            if (isset($_REQUEST['opcao'])) {
                $opcao = ($_REQUEST['opcao']-1);
            } else {
                $opcao = 0;// colocar request aqui
            }
            
            $inicio = $opcao * $intervalo;
            $fim = $inicio + $intervalo;
            echo " <input name='find' type='hidden' class='enviar radius' value='true' /> ";
            if (isset($_REQUEST['inicio'])) {
                $inicioOpt = htmlspecialchars($_REQUEST['inicio']);
                $fimOpt = htmlspecialchars($_REQUEST['fim']);
                echo " <input name='inicio' type='hidden' class='enviar radius' value='$inicioOpt' /> Páginas >>";
                echo " <input name='fim' type='hidden' class='enviar radius' value='$fimOpt' />";
            }else {
                $inicioOpt = date('Y-m') . "-01";
                $fimOpt = date('Y')."-12-31";
                echo " <input name='inicio' type='hidden' class='enviar radius' value='$inicioOpt' /> Páginas >>";
                echo " <input name='fim' type='hidden' class='enviar radius' value='$fimOpt' /> ";
            }
            for ($i=0; $i < $fracionar ; $i++) { 
                $w = $i+1;
                if ($i==$opcao) {
                    echo " <input name='opcao' type='submit' class='enviar radius btn-primary' value='$w' /> ";
                } else {
                    echo " <input name='opcao' type='submit' class='enviar radius' value='$w' /> ";
                }
            }
            echo "</form>";
            //paginacao na tabela php
        ?><br/>
        <table  class="table table-striped table-bordered table-hover table-responsive-lg">
        <tr><td>Colaborador</td><td>Saldo Total Positivo</td><td>Saldo que será abatido</td>
        <td>Pagar ou Compensar?</td><td>Data</td><td>Status</td><td>Autorizado por quem?</td> <td>Obs.:</td> </tr>
        <?php
            $matriculas = array(97,16,1189,116,103,82,45,4,566,827,150,1026,100);
            $gestores = array('ALQUINDAR DA SILVA PEREIRA','ARGEU ANTONIO HENRIQUES','DANILO DOS SANTOS MARTINS',
            'EDUARDO CRUZATO FERRAZ','FARID CALIL','JOSE DOMINGOS SILVA CONTE','JULIO CESAR SILVA XAVIER',
            'JULIO SERGIO CARMO MORAIS','LILIAN DE OLIVEIRA RODRIGUES','MARCOS CESAR MARIANO ZAMBONI',
            'MOYSES PEREIRA BATISTA','RICARDO GONÇALVES GOMES','VIRGÍNIA RIBEIRO'
            );
            foreach ($resultado as $key => $value) {
                if($key>=$inicio && $key<=$fim){//paginação
                echo "<tr>";
                $data =$value['data'];
                $nome =$value['nome'];
                $mat =$value['mat'];
                foreach ($value as $key2 => $value2) {
                    switch ($key2) {
                        case 'data':
                            echo "<td>" . date("d/m/y", strtotime($value2)) . "</td>";  
                            break;
                        case 'nome':
                            echo "<td><a href='planodecompensacao.php?consultar=$nome&mat=$mat&dataconsul=$data'>$value2</a></td>";  
                            break;
                        case 'autorizado':
                            foreach ($matriculas as $keyg => $valueg) {
                                if ($valueg==$value2) {
                                    $autorizado = $gestores[$keyg];
                                    echo "<td>$autorizado</td>";
                                    break;
                                } 
                            }
                            break;
                        case 'PagarCompensar':
                            if ($value2=="P"){
                                echo "<td>PAGO</td>";
                            }else {
                                echo "<td>FOLGA</td>";
                            }
                            break;
                        case 'status':
                            if ($value2=="OK"){
                                echo "<td><button type='button' class='btn btn-success col-sm-12'>$value2</button></td>";
                            } else if($value2=="PROGRAMADO"){
                                echo "<td><button type='button' class='btn btn-warning col-sm-12'>$value2</button></td>";
                            } else {
                                echo "<td><button type='button' class='btn btn-danger col-sm-12'>$value2</button></td>";
                            }
                            break;
                        case 'id':
                            break;
                        case 'mat':
                            break;
                        default:
                            echo "<td>$value2</td>";
                            break;
                    }
                }
                echo "</tr>";
                } //fim paginacao
            }
        ?>
        </table>
        <script type="text/javascript">
            var navegador = ObterBrowserUtilizado();
            var tela = ObterTela();
            var data = document.getElementById("data").value;
            if (navegador!=="Google Chrome" && tela && (data.substring(3,2)!=="/")) {
                var data = document.getElementById("data").value;
                var datatxt = InverterData(data);
                document.getElementById("data").value = datatxt;
            }
        </script>
    </div>
<!-- ---------------------------------- tabela ---------------------------------------------------------------- -->
<?php else:?>
    <div class="texto">
        <ul class="formmenu">
            <li><a href="planodecompensacao.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
            <li><a href="planodecompensacao.php?find=true"><i class="fas fa-file-excel"></i> Relatório</a><br/><br/></li> 
        </ul><br/>
    <form method="POST" class="formmenu" name="formCadastro" action="planodecompensacao.php" ><br/>
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
            $(function(){
                $("#consultar").autocomplete({
                    source: '_page/proc_pesq_nome.php'
                });
            });
</script>