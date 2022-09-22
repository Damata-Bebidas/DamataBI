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
        do {
            $litrao = $simulador->findSimulador($nb, "Cerveja Litrao");
            if (count($litrao)<=1) {
                header("Location: ./simulador.php?inativo=true");exit;
            }
            $nome_r = $litrao['nome'];
            $vasilhame_r = $vasilhame;
            $classerisco_r = $litrao['classerisco'];
            $docs_r = $litrao['docs'];
            $inad_r = $litrao['inad'];
            $giro_r = $litrao['giro'];
            $comodato_r = $litrao['comodato'];
            $ttcompracxs_r = $litrao['ttcompracxs'];
            $metagiro_r = $litrao['metagiro'];
            switch ($vasilhame) {
                case 'Cerveja 1/1':
                    $descr_r = "GARRAFEIRA PLAST,24 GFA 600ML";
                    break;
                case 'Cerveja 1/2':
                    $descr_r = "GARRAFEIRA PLAST,24 GFA 300ML,AZUL,C/2";
                    break;
                case 'Barril':
                    $descr_r = "BARRIL CHOPP,30L,";
                    break;
                case 'Refri 1/2':
                    $descr_r = "GARRAFEIRA PLAST,24 GFA 290ML";
                    break;        
                default:
                    header("Location: ./simulador.php?inativo=true");exit;
                    break;
            }
            $simulador->inserirSimulador($nb, $vasilhame, $descr_r, $classerisco_r,
                    $docs_r, $inad_r, $giro_r, $comodato_r, $ttcompracxs_r, $metagiro_r);
            $a = $simulador->findSimulador($nb, $vasilhame);
          } while ($a <= 1);
          $resultado = $simulador->findSimulador($nb, $vasilhame);
          $id = $resultado['id'];
    }
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Simulador</h3>
<h1><i class="fas fa-file-excel"></i> Simulador</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="user.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<!-- ----------------------------------form1 consultar---------------------------------------------- -->
<div class="texto">
    <ul class="formmenu">
        <li><a href="simulador.php" > <i class="fas fa-sign-out-alt"></i>Consultar Novo Cliente</a></li> 
        <li><a href="simulador.php?find=true"><i class="fas fa-file-excel"></i>Relatório</a><br/><br/></li> 
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
           value="<?php echo $telaD = (count($resultado)>0) ? $resultado['metagiro'] : "" ; ?>" /> <br/>
    <?php $lacuna = $resultado['ttcompracxs'] - $resultado['metagiro'];  ?>
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
            $resultado = $analisesimulador->find(0);
    ?>
    <label for="qtd">Quantidade .:</label><input type="number" name="qtd" id="qtd" placeholder="Quantidade" class="form-control col-sm-2"
        required min="0" value="<?php echo $telaE = (count($resultado)>1) ? $resultado['qtd'] : "" ;?>" onchange="calcularQtd();"  /><br/>
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
        <input type="radio" id="serasaOK" name="serasa" value="O" 
            <?php  echo $telaOK = ($resultado['serasa']=="O") ? 'checked="checked"' : '' ; ?> />  OK s/ pendência 
        <input type="radio" id="serasaPen" name="serasa" value="P" 
            <?php  echo $telaPendencia = ($resultado['serasa']=="P") ? 'checked="checked"' : '' ;?>/>  Pendência <br/>
    </div>
    <hr class="form col-sm-7 pull-left"/>
    <label for="status">Status.:</label>
    <select name="status" id="status" class="form-control col-sm-3">
        <option <?php echo $telaV = ($resultado['id']=="") ? "selected" : "" ; ?> ></option>
        <option <?php echo $tela1Aprovado = ($resultado['status']=="APROVADO") ? "selected" : "" ; ?> >APROVADO</option>
        <option <?php echo $tela1Reprovado = ($resultado['status']=="REPROVADO") ? "selected" : "" ; ?> >REPROVADO</option>
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
    <input type="hidden" name="nb" value="<?php echo $telaNB = (count($resultado)>1) ? $resultado['nb'] : "" ; ?>" readonly="readonly" />
    <input type="hidden" name="funcao" value="1" readonly="readonly" />
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