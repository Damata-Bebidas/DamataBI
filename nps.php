<?php session_start();
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST_NB = (isset($post['NB'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    $REQUEST = (isset($post['consultar'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    $REQUEST_FIND = (isset($post['find'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/pesquisaNPS.php';
    $pesquisa = new pesquisaNPS($conexao);
    if (isset($REQUEST['consultar'])) {
        $id = htmlspecialchars($_REQUEST['consultar']);
        $resultado = $pesquisa->find($id);
        $resultadoNB = $pesquisa->findNB($id);
    }
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Pesquisa NPS</h3>
<h1><i class="fas fa-address-card"></i> Pesquisa NPS</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="login.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>

<?php if(isset($REQUEST['consultar'])):?>
<div class="texto">
    <ul class="formmenu">
        <li><a href="nps.php" > <i class="fas fa-sign-out-alt"></i>Consultar Novo Cliente</a></li> 
    </ul>
<form method="POST" class="formmenu" name="formPesquisa" action="_controller/controllerPesquisaNPS.php" ><br/>
    <label for="Nome">Nome . :</label><input type="text" name="Nome" id="Nome" required class="form-control col-sm-8"
      size="30" maxlength="50" placeholder="Nome Fantasia" readonly='readonly'
      value="<?php echo $telaN = (count($resultadoNB)>0) ? $resultadoNB['Nome'] : "" ; ?>"/><br/>
    
    <label for="End">Rua/Av.:</label><input type="text" name="End" required class="form-control col-sm-8"
           id="End" size="30" maxlength="30" placeholder="End" readonly='readonly'
           value="<?php echo $telaS = (count($resultadoNB)>0) ? $resultadoNB['End'] : "" ; ?>" /><br/>

    <label for="Bairro">Bairro . :</label><input type="text" name="Bairro" required class="form-control col-sm-8"
           id="Bairro" size="30" maxlength="30" placeholder="Bairro" readonly='readonly'
           value="<?php echo $telaBairro = (count($resultadoNB)>0) ? $resultadoNB['Bairro'] : "" ; ?>" /><br/>
    
    <label for="Cidade">Cidade.:</label><input type="text" name="Cidade" required class="form-control col-sm-8"
           id="Cidade" size="30" maxlength="30" placeholder="Cidade" readonly='readonly'
           value="<?php echo $telaCidade = (count($resultadoNB)>0) ? $resultadoNB['Cidade'] : "" ; ?>" /><br/>
    </form>
    <hr class="linha"/>
    <form method="POST" class="formmenu" name="formPesquisa" action="_controller/controllerPesquisaNPS.php" >
    <fieldset id="nps"><legend>Dados Pesquisa NPS</legend></fieldset>
    <label for="Data">Data da Pesquisa .:</label><input type="date" name="Data" 
           id="Data" placeholder="Data" required class="form-control col-sm-3"
           value="<?php  echo $telaE = (count($resultado)>1) ? $resultado['Data'] : date('Y-m-d') ;?>" 
           max="<?php $Hoje = date("Y-m-d"); echo "$Hoje"; ?>" /><br/>
    
    <script type="text/javascript">
        var navegador = ObterBrowserUtilizado();
        var tela = ObterTela();
        var data = document.getElementById("Data").value;
        if (navegador!=="Google Chrome" && tela && (data.substring(3,2)!=="/")) {
            var data = document.getElementById("Data").value;
            var datatxt = InverterData(data);
            document.getElementById("Data").value = datatxt;

        }
    </script>
    <?php $Nota = (count($resultado)>1) ? $resultado['Nota'] : 5 ;  ?> 
    <label for="Nota" id="ForNota">Avaliação de 1 a 5 || Nota =>  <?php echo $Nota; ?> </span> </label>
    <input type="range" min="1" max="5" id="Nota" name="Nota" required class="form-control col-sm-3"
           value="<?php echo $Nota; ?>" onchange="mostrarRange()"/> <br/>
    
    <script type="text/javascript">
        function mostrarRange() {
            let nota = document.getElementById("Nota").value;
            document.getElementById("ForNota").innerHTML = "Avaliação de 1 a 5 || Nota => " + nota;
            if (nota==5) {
                document.getElementById("ForMotivo").style.display = "none";
                document.getElementById("Motivo").style.display = "none";
            } else {
                document.getElementById("ForMotivo").style.display = "block";
                document.getElementById("Motivo").style.display = "block";
            }
            
        }
    </script>
    
    
    <label for="Motivo" id="ForMotivo" >Motivo Nota Abaixo < 5 </label><br/>
    <select name="Motivo" id="Motivo"  required class="form-control col-sm-4">
        <option  <?php echo $tela1 = ($resultado['Motivo']=="C") ? "selected" : "" ; ?>>Cortesia da Equipe</option>
        <option <?php echo $tela2 = ($resultado['Motivo']=="D") ? "selected" : "" ; ?>>Divergência no Pedido</option>
        <option <?php echo $tela3 = ($resultado['Motivo']=="N") ? "selected" : "" ; ?>>Não Recebi este Pedido</option>
        <option <?php echo $tela4 = ($resultado['Motivo']=="Q") ? "selected" : "" ; ?>>Qualidade do Produto</option>
    </select><br/><br/>
    <?php
           if ($Nota==5){
               echo '<script type="text/javascript">
                        document.getElementById("ForMotivo").style.display = "none";
                        document.getElementById("Motivo").style.display = "none";
                    </script>';
           }
    ?>
    <label for="Comentario">Comentário Livre :</label><br/><br/>
    <textarea name="Comentario" id="Comentario" required class="form-control col-sm-8" >
        <?php echo $telaObs = (count($resultado)>1) ? $resultado['Comentario'] : "" ; ?>
    </textarea>
    <br/><br/>
    <input type="hidden" name="NB" id="NB"  readonly='readonly'
        value="<?php echo $telaM = (count($resultadoNB)>0) ? $resultadoNB['NB'] : "" ; ?>"/>
    <input type="hidden" name="id" value="<?php echo $telaID = (count($resultado)>1) ? $resultado['ID']  : null ; ?>" readonly="readonly" />
    <input type="hidden" name="MatFunc" value="<?php echo $telaMat = (isset($_SESSION['ids'])) ? htmlspecialchars($_SESSION['ids'])  : $_SERVER["REMOTE_ADDR"] ; ?>" readonly="readonly" />
<input name="Enviar" type="submit" class="enviar radius" value="Salvar" 
       onsubmit="return validarSenha();" /> <i class="fas fa-arrow-circle-right"></i><br/><br/>
</fieldset> 
</form>
</div>
<?php else:?>
    <div class="texto">
        <ul class="formmenu">
            <li><a href="nps.php" > <i class="fas fa-sign-out-alt"></i>Consultar Novo Cliente</a></li> 
        </ul>
    <form method="POST" class="formmenu" name="formCadastro" ><br/>
        <fieldset id="usuario">
        <legend>
            Digite NB => Ponto de Venda</legend>
        </fieldset>
        <fieldset id="sexo"><legend>Dados do Cliente</legend><br/>
        <label for="consultar">NB => .:</label><input type="number" name="consultar" id="consultar" 
           class="form-control col-sm-4" autofocus size="30" maxlength="60" pattern="[0-9]*" required placeholder="Número Base"/><br/>
        </fieldset>
        <hr class="form col-sm-7 pull-left" />
    <input name="Enviar" type="submit" class="enviar radius" value="Consultar" 
       onsubmit="return validarSenha();" /><i class="fas fa-arrow-circle-right"></i><br/><br/>
</fieldset> 
</form>
    </div>
<?php endif;?>
<?php require_once "./_page/footer.php"; ?>
<?php 
    if(isset($REQUEST['sucess'])) { 
            echo "<script type='text/javascript'>pesquisaOK();</script>"; 
            ini_set( 'display_errors', 1 );
            error_reporting( E_ALL );
            // Destinatário
            $para = "damatabebidas@hotmail.com";
            // Assunto do e-mail
            $assunto = "Pesquisa NPS";

            // Campos do formulário de contato
            $nome =  $resultadoNB['Nome']  ; 
            $matricula = $resultadoNB['NB'] ;
            $mensagem = "Pesquisa Respondida com sucesso";

            // Monta o corpo da mensagem com os campos
            $corpo = "Mensagem: $mensagem \nNB: $matricula \nNome: $nome "; 

            // Cabeçalho do e-mail
            //$email_headers = implode("\n", array("From: $nome", "Reply-To: $email", "Subject: $assunto", "Return-Path: $email", "MIME-Version: 1.0", "X-Priority: 3", "Content-Type: text/html; charset=UTF-8"));

            //Verifica se os campos estão preenchidos para enviar então o email
            mail($para, $assunto, $corpo);
    } 

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
        }
         $(function(){
            $("#consultar").autocomplete({
                source: '_page/proc_pesq_nome.php'
            });
        });
</script>