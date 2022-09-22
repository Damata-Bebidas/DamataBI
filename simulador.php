<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
        $url->logarUser();//verificar root
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/analisesimulador.php';
    $simulador = new analisesimulador($conexao);
    if (isset($_REQUEST['consultar'])) {
        $nb = htmlspecialchars($_REQUEST['consultar']);
        $opcao = htmlspecialchars($_REQUEST['vasilhame']);
        $opcoes = explode("-", $opcao);
        $vasilhame = trim($opcoes[1]);
        $resultado = $simulador->findSimulador($nb, $vasilhame);
        if(count($resultado)<=1){
            $consultar_r = $_REQUEST['consultar'];
            $vasilhame_r = $_REQUEST['vasilhame'];
            header("Location: ./simuladorincluir.php?consultar=$consultar_r&vasilhame=$vasilhame_r");exit;
        }
    }
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Simulador</h3>
<h1><i class="fas fa-file-excel"></i> Simulador</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="powerbifin.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<!-- ----------------------------------form1 consultar---------------------------------------------- -->
<?php if(isset($_REQUEST['consultar'])):?>
<div class="texto">
    <ul class="formmenu">
        <li><a href="simulador.php" > <i class="fas fa-sign-out-alt"></i>Consultar Novo Cliente</a></li> 
        <li><a href="simulador.php?find=true"><i class="fas fa-file-excel"></i> Relatório</a><br/><br/></li> 
    </ul><br/><br/>
    <form method="POST" class="formmenu col-sm-8 col-sm-offset-4"  >
    <fieldset id="usuario"><legend>
        Simulador de Comodados</legend>
    </fieldset>
    <fieldset id="simulador"><legend class="small">Dados do Cliente</legend>
    
    <label for="id">Nº da Solicitação.:</label><input class="form-control col-sm-3" type="number" name="id" id="id" 
      size="30" maxlength="50" placeholder="Nova Solicitação" readonly='readonly'
      value="<?php echo $telaN = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "" ; ?>"/>
    
    <label for="NB">NB.:</label><input class="form-control col-sm-3" type="number" name="NB" id="NB" 
      size="30" maxlength="50" placeholder="NB" readonly='readonly'
      value="<?php echo $telaN = (count($resultado)>0) ? $resultado['nb'] : "" ; ?>"/>
     
    <label for="Nome">Nome.:</label><input class="form-control col-sm-8" type="text" name="Nome" id="Nome" 
      size="30" maxlength="50" placeholder="Nome Fantasia" readonly='readonly'
      value="<?php echo $telaN = (count($resultado)>0) ? $resultado['nome'] : "" ; ?>"/>
    
    <label for="vasilhame">Vasilhame . :</label><input class="form-control col-sm-8" type="text" name="vasilhame" 
           id="vasilhame" size="30" maxlength="30" placeholder="Setor" readonly='readonly'
           value="<?php echo $telaS = (count($resultado)>0) ? $resultado['vasilhame'] : "" ; ?>" />

    <label for="descr">Descrição.:</label><input class="form-control col-sm-8" type="text" name="descr" 
           id="descr" size="30" maxlength="30" placeholder="Descrição" readonly='readonly'
           value="<?php echo $telaD = (count($resultado)>0) ? $resultado['descr'] : "" ; ?>" /> <br/>
    <?php 
        require_once '_model/analisesimulador.php';
        $analisesimulador = new analisesimulador($conexao);
        if (isset($_REQUEST['update'])) {
            $updateId = $_REQUEST['id'];
            $resultado = $analisesimulador->find($updateId);
        }else {
            $resultado = $analisesimulador->find(0);
        }
        $classeDeRisco = ($resultado) ? $resultado['classerisco']  : null ;
        if (trim($classeDeRisco) =="") { //caso esteja vazio puxar da tabela original do simulador 
            $resultado = $simulador->findSimulador($nb, $vasilhame);
        } 
    ?>
    <label for="classe">Classe de Risco.:</label><br/><input type="button" name="classe" 
           id="classe" size="30" maxlength="30" placeholder="Classe Risco" readonly='readonly'
           class="col-sm-2 <?php echo $telaC = ($resultado['classerisco']<=3) ? "btn-success" : "btn-danger" ; ?>"
           value="<?php echo $telaC = (count($resultado)>0) ? $resultado['classerisco'] : "" ; ?>" /> <br/><br/>
    
    <label for="docs">Documentação .:</label><br/><input type="button" name="docs" 
           id="docs" size="30" maxlength="30" placeholder="Documentos" readonly='readonly'
           class="col-sm-2 <?php echo $telaD = ($resultado['docs']=="S") ? "btn-success" : "btn-danger" ; ?>"
           value="<?php echo $telaC = (count($resultado)>0) ? str_replace("S","Sim",str_replace("N", "Não", $resultado['docs'])) : "" ; ?>" /><br/><br/>
    
    <label for="inad">INAD .:</label><br/><input type="button" name="inad" 
           id="inad" size="30" maxlength="30" placeholder="INAD" readonly='readonly'
           class="col-sm-2 <?php echo $telaI = ($resultado['inad']=="N") ? "btn-success" : "btn-danger" ; ?>"
           value="<?php echo $telaC = (count($resultado)>0) ? str_replace("S","Sim",str_replace("N", "Não",$resultado['inad'])) : "" ; ?>" /><br/><br/>
    
    <label for="giro">Giro Mês .:</label><br/><input type="button" name="giro" 
           id="giro" size="30" maxlength="30" placeholder="giro" readonly='readonly'
           class="col-sm-2 <?php 
                                switch ($resultado['giro']) {
                                    case "O":
                                        echo "btn-success";
                                       break;
                                   case "N":
                                        echo "btn-warning";
                                       break;
                                   case "Z":
                                        echo "btn-danger";
                                       break;
                                }
                            ?>"
           value="<?php echo $telaC = (count($resultado)>0) ? 
                   str_replace("N", "NOK",str_replace("O", "OK",str_replace("Z", "Giro Zero", $resultado['giro']))) : "" ; ?>" /><br/><br/>
    
    <label for="comodato">Total de Caixas Comodato.:</label><input class="form-control col-sm-2" type="number" name="comodato" 
           id="comodato" size="30" maxlength="30" placeholder="Comodato" readonly='readonly'
           value="<?php echo $telaD = (count($resultado)>0) ? $resultado['comodato'] : "" ; ?>" /> <br/>
    
    <label for="ttcompracxs">Total Compra Caixas Mês.:</label><input class="form-control col-sm-2" type="number" name="ttcompracxs" 
           id="ttcompracxs" size="30" maxlength="30" placeholder="ttcompracxs" readonly='readonly'
           value="<?php echo $telaD = (count($resultado)>0) ? $resultado['ttcompracxs'] : "" ; ?>" /> <br/>
    
    <label for="metagiro">Meta Giro.:</label><input class="form-control col-sm-2" type="number" name="metagiro" 
           id="metagiro" size="30" maxlength="30" placeholder="ttcompracxs" readonly='readonly'
           value="<?php switch ($vasilhame) {
                            case 'Barril':
                                $metagiro = 4;
                                break;
                            case 'Refri 1/2':
                                $metagiro = 4;
                                break;
                            default:
                                $metagiro = 2;
                                break;
                            }
                            if (isset($resultado['qtd'])) {
                                $qtd = $resultado['qtd'];
                                $metagiro = $qtd * $metagiro;
                            }
                        echo $telaD = (count($resultado)>0) ? $metagiro : "" ; 
                    ?>" /> <br/>
    <?php $lacuna = $resultado['ttcompracxs'] - $metagiro;  ?>
    <label for="lacuna">Lacuna .:</label><br/><input type="button" name="lacuna" 
           id="lacuna" size="30" maxlength="30" placeholder="INAD" readonly='readonly'
           class="col-sm-2 <?php echo $telaI = ($lacuna>=0) ? "btn-success" : "btn-danger" ; ?>"
           value="<?php echo $telaC = (count($resultado)>0) ? $lacuna : "" ; ?>" /><br/><br/>
    </fieldset>
    </form>
    <!-- -------------------------------form2 ---------------------------------------------------------- -->
    <form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formplanobh" 
          action="_controller/controllerSimulador.php" onsubmit="return validaSimulador();" >
    <hr class="form col-sm-7 pull-left"/>
    <input type="hidden" name="id" value="<?php echo $telaID = (count($resultado)>1) ? $resultado['id'] : "" ; ?>" readonly="readonly" />
    <?php 
            require_once '_model/analisesimulador.php';
            $analisesimulador = new analisesimulador($conexao);
            if (isset($_REQUEST['update'])) {
                $updateId = $_REQUEST['id'];
                $resultado = $analisesimulador->find($updateId);
            }else {
                $resultado = $analisesimulador->find(0);
            }
    ?>
    <label for="qtd">Quantidade .:</label><input type="number" name="qtd" id="qtd" placeholder="Quantidade" class="form-control col-sm-2"
        required min="0" value="<?php echo $telaE = (count($resultado)>1) ? $resultado['qtd'] : "" ;?>"  onchange="calcularQtd();" /><br/>
    <script type="text/javascript">
        function calcularQtd() {
            let qtd = document.getElementById("qtd").value;
            let vasilhame = document.getElementById("vasilhame").value;
            let compras = document.getElementById("ttcompracxs").value;
            let metagiro = 1;
            let total = 0;
            let lacuna = 0;   
            switch (vasilhame) {
                case 'Barril':
                    metagiro = 4;
                    break;
                case 'Refri 1/2':
                    metagiro = 4;
                    break;
                default:
                    metagiro = 2;
                    break;
            }
            if (qtd>0) {
                metagiro = qtd * metagiro;
                document.getElementById("metagiro").value = metagiro;
                lacuna = compras - metagiro;
                document.getElementById("lacuna").value = lacuna;
                let classe = document.getElementById('lacuna');
                if (lacuna>=0) {
                    classe.classList.remove('btn-danger');
                    classe.classList.add('btn-success');
                } else if(lacuna<0){
                    classe.classList.remove('btn-success');
                    classe.classList.add('btn-danger');
                }
            }
        }
    </script>
    <label for="serasa">Serasa .:</label>
    <div class="radio">
        <?php   $check = ($resultado) ? $resultado['serasa'] : null ; ?>
        <input type="radio" id="serasaOK" name="serasa" value="O" 
            <?php  echo $telaOK = ($check=="O") ? 'checked="checked"' : '' ; ?> />  OK s/ pendência 
        <input type="radio" id="serasaPen" name="serasa" value="P" 
            <?php  echo $telaPendencia = ($check=="P") ? 'checked="checked"' : '' ;?>/>  Pendência <br/>
    </div>
    <hr class="form col-sm-7 pull-left"/>
    <label for="status">Status.:</label>
    <select name="status" id="status" class="form-control col-sm-3">
        <?php   $checkStatus = ($resultado) ? $resultado['status'] : null ; ?>
        <option <?php echo $telaV = ($checkStatus=="") ? "selected" : "" ; ?> ></option>
        <option <?php echo $tela1Aprovado = ($checkStatus=="APROVADO") ? "selected" : "" ; ?> >APROVADO</option>
        <option <?php echo $tela1Reprovado = ($checkStatus=="REPROVADO") ? "selected" : "" ; ?> >REPROVADO</option>
    </select><br/>
    
    <label for="motivo">Motivo.:</label>
    <select name="motivo" id="motivo" class="form-control col-sm-3">
        <option <?php echo $telaVA = ($resultado['motivo']=="") ? "selected" : "" ; ?> ></option>
        <option <?php echo $tela11 = ($resultado['motivo']=="SOLICITAÇÃO PRECISA DE VENDA") ? "selected" : "" ; ?> >SOLICITAÇÃO PRECISA DE VENDA</option>
        <option <?php echo $tela12 = ($resultado['motivo']=="DESC NO PEDIDO") ? "selected" : "" ; ?> >DESC NO PEDIDO</option>
        <option <?php echo $tela13 = ($resultado['motivo']=="NÃO BATE O GIRO") ? "selected" : "" ; ?> >NÃO BATE O GIRO</option>
        <option <?php echo $tela14 = ($resultado['motivo']=="SEM DOCS") ? "selected" : "" ; ?> >SEM DOCS</option>
        <option <?php echo $tela15 = ($resultado['motivo']=="INADIMPLENTE") ? "selected" : "" ; ?> >INADIMPLENTE</option>
        <option <?php echo $tela16 = ($resultado['motivo']=="PEDIDO ABAIXO DA QNT") ? "selected" : "" ; ?> >PEDIDO ABAIXO DA QNT</option>
        <option <?php echo $tela17 = ($resultado['motivo']=="CLASSE DE RISCO ALTA") ? "selected" : "" ; ?> >CLASSE DE RISCO ALTA</option>
    </select><br/>
    <hr class="form col-sm-7 pull-left"/>
    <label for="autorizado">Autorizado por quem?</label>
    <select name="autorizado" id="autorizado" class="form-control col-sm-6">
        <option  <?php echo $telavv = ($resultado['aprovador']=="") ? "selected" : "" ; ?>></option>
        <option  <?php echo $tela18 = ($resultado['aprovador']==1009) ? "selected" : "" ; ?>>LUCIANA RIBEIRO</option>
        <option  <?php echo $tela19 = ($resultado['aprovador']==102) ? "selected" : "" ; ?>>FABIANO A. CALIL</option>
        <option <?php echo $tela20 = ($resultado['aprovador']==103) ? "selected" : "" ; ?>>FARID CALIL</option>
        <option <?php echo $tela21 = ($resultado['aprovador']==104) ? "selected" : "" ; ?>>JOSE CARLOS CALIL JR</option>
        <option <?php echo $tela22 = ($resultado['aprovador']==101) ? "selected" : "" ; ?>>RICARDO CALIL</option>
        <option <?php echo $tela24 = ($resultado['aprovador']==100) ? "selected" : "" ; ?>>VIRGÍNIA RIBEIRO</option>
    </select>
    <hr class="form col-sm-7 pull-left"/> 
    <?php echo $telaLog = (count($resultado)>1) ? '<label for="autorizado">Log de aprovação</label>' . $resultado['log'] : "" ; ?>
    <br/>
    <?php echo $telaNB = (count($resultado)>1) ? '<input type="hidden" name="key" value="' . $resultado['id'] . '" readonly="readonly" />' : "" ; ?>  
    <input type="hidden" name="nb" value="<?php echo $telaNB = (count($resultado)>1) ? $resultado['nb'] : "" ; ?>" readonly="readonly" />
    <input type="hidden" name="funcao" value="<?php echo $tela = (isset($_REQUEST['inserir'])) ? 1 : 2 ; ?>" readonly="readonly" />
</fieldset>
<input name="Enviar" type="submit" class="enviar radius" value="Salvar"  />
        <i class="fas fa-arrow-circle-right"></i><br/><br/>
        
</form>
<!-- Fim Form 2 e Inicio Botão excluir -->
    <div class="btndireita">  
             <?php 
                    if (isset($_REQUEST['update']) && isset($_REQUEST['id']) ) {
                        $idEx = $resultado['id']; 
                        echo "<a href='_controller/controllerSimulador.php?excluir=true&key=$idEx'";
                        echo "<i class='fas fa-trash-alt'></i> Excluir</a>";
                    }
               ?>
            
    </div> 
</div>
<script type="text/javascript">
        
        let qtd = document.getElementById("qtd").value;
        let vasilhame = document.getElementById("vasilhame").value;
        let compras = document.getElementById("ttcompracxs").value;
        let metagiro = 1;
        let total = 0;
        let lacuna = 0;   
        switch (vasilhame) {
            case 'Barril':
                metagiro = 4;
                break;
            case 'Refri 1/2':
                metagiro = 4;
                break;
            default:
                metagiro = 2;
                break;
        }
        if (qtd>0) {
            metagiro = qtd * metagiro;
            document.getElementById("metagiro").value = metagiro;
            lacuna = compras - metagiro;
            document.getElementById("lacuna").value = lacuna;
            let classe = document.getElementById('lacuna');
            if (lacuna>=0) {
                classe.classList.remove('btn-danger');
                classe.classList.add('btn-success');
            } else if(lacuna<0){
                classe.classList.remove('btn-success');
                classe.classList.add('btn-danger');
            }
        }
    </script>
<!-- ---------------------------------- tabela ---------------------------------------------------------------- -->
<?php elseif(isset($_REQUEST['find'])):?>
    <div class="texto">
        <a href="simulador.php"> <i class="fas fa-paper-plane"></i> Novo </a><br/><br/>
        <?php
            require_once '_model/analisesimulador.php';
            $simulador = new analisesimulador($conexao);
            if (isset($_REQUEST['inicio']) && isset($_REQUEST['fim'])  ) {
                $resultado = $simulador->findData($_REQUEST['inicio'],$_REQUEST['fim']);
            } else {
                $resultado = $simulador->consult();
            }
        ?>
        <form name="formData" method="POST" class="formmenu" action="simulador.php" enctype="multipart/form-data">
            <input type="date" name="inicio" id="inicio" required autofocus 
            <?php if (isset($_REQUEST['inicio'])) { 
                $data = htmlspecialchars($_REQUEST['inicio']);
                echo "value='$data'";
            } else { 
                $hoje = date('Y') . "-01-01";
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
            echo "<form method='POST' action='simulador.php' name='formPaginacao' >";
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
                $inicioOpt = date('Y')."-01-01";
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
        <tr><td>Núm. Simulação</td><td>NB</td><td>Nome</td><td> PDF </td>
        <td>Vasilhame</td><td>Data</td><td>Status</td></tr>
        <?php
            foreach ($resultado as $key => $value) {
                if($key>=$inicio && $key<=$fim){//paginação
                echo "<tr>";
                $vasilhameOpt =$value['vasilhame'];
                $idOpt =$value['id'];
                $nbOpt =$value['nb'];
                foreach ($value as $key2 => $value2) {
                    switch ($key2) {
                        case 'data':
                            echo "<td>" . date("d/m/y", strtotime($value2)) . "</td>";  
                            break;
                        case 'nome':
                            echo "<td><a href='simulador.php?update=true&id=$idOpt&consultar=$nbOpt&vasilhame=1-$vasilhameOpt'>$value2</a></td>";
                            echo "<td><a href='simuladorpdf.php?update=true&id=$idOpt&consultar=$nbOpt&vasilhame=1-$vasilhameOpt' target='_blank' ><i class='fas fa-file-pdf'></i></a></td>";   
                            break;
                        case 'status':
                            if ($value2=="APROVADO"){
                                echo "<td><button type='button' class='btn btn-success col-sm-12'>$value2</button></td>";
                            } else if($value2=="PROGRAMADO"){
                                echo "<td><button type='button' class='btn btn-warning col-sm-12'>$value2</button></td>";
                            } else {
                                echo "<td><button type='button' class='btn btn-danger col-sm-12'>$value2</button></td>";
                            }
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
            <li><a href="simulador.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
            <li><a href="simulador.php?find=true"><i class="fas fa-file-excel"></i> Relatório</a><br/><br/></li> 
        </ul><br/>
        <form method="POST" class="formmenu" name="formCadastro" action="simulador.php" ><br/>
        <fieldset id="sexo"><legend>Dados do Cliente</legend>
            <div class="form-group"> <!-- form bootstrap -->
                <label for="consultar" class="col-sm-2 control-label">NB.:</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="consultar" id="consultar" 
                     required autofocus min="1" placeholder="NB Cliente"/><br/>
                </div>
                <label for="consultar" class="col-sm-2 control-label">Vasilhame.:</label>
                <div class="col-sm-6">
                    <select name="vasilhame" class="form-control col-sm-8">
                            <option> 30486 - Cerveja 1/1</option>    
                            <option selected >188005 - Cerveja Litrao</option>
                            <option>198213 - Cerveja 1/2</option>
                            <option>101489 - Barril</option>
                            <option>103332 - Refri 1/2</option>
                        </select>
                </div>
            </div>
            <br/><hr class="form" />
        </fieldset>        
    <input name="inserir" type="hidden" class="enviar radius" value="inserir" />
    <input name="Enviar" type="submit" class="enviar radius" value="Consultar" /> <i class="fas fa-arrow-circle-right"></i>
    <br/><br/>
</fieldset> 
</form>
    </div>
<?php endif;?>
<?php require_once "./_page/footer.php"; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<?php echo $alerta = (isset($_REQUEST['inativo'])) ? '<script> alert("Cliente Inativo ou Não Cadastrado!!!") </script>' : "" ; ?>
<script>
        $(function(){
            $("#consultar").autocomplete({
                source: '_page/proc_pesq_nome.php'
            });
        });
</script>