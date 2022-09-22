<?php ob_start();//inicio da sessao 
      session_start();//inicio da sessao
      require_once './_model/session.php';
      $session = new session();
      $session->logarUser(); //verificar se esta logado
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
    require_once './_model/check.php';
    $check = new check($conexao);
    require_once "./_page/header.php"; 
    require_once "./_page/menu.php";
    
    if (isset($_SESSION['ids'])) {
        $id  = (isset($_SESSION['ids'])) ? $_SESSION['ids'] : "" ;
    } else {
        $id = (isset($_REQUEST['mat'])) ? base64_decode(htmlspecialchars($_REQUEST['mat'])) : $id ;
    }
    
    if (isset($_SESSION['nome'])) {
        $nome = (isset($_SESSION['nome'])) ? $_SESSION['nome'] : "" ;
    } else {
        $nome = (isset($_REQUEST['nome'])) ? base64_decode(htmlspecialchars($_REQUEST['nome'])) : $nome ;
    }
    $id_nome_treinamento = (isset($_REQUEST['consultar'])) ? htmlspecialchars($_REQUEST['consultar']) : "";
    $consult_id = $check->consultTrei($id_nome_treinamento);
    ?>
<hgroup class="pagina">
<h3>Damata >> Treinamentos >> Check </h3>
<h1><i class="fas fa-chart-pie"></i> Check Reação<br/><br/></h1>
<a href="user.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['tr']) || isset($_REQUEST['consultar'])):?>
    <?php 
        $treinamento = (htmlspecialchars(isset($_REQUEST['tr']))) ? base64_decode(htmlspecialchars($_REQUEST['tr'])) : $consult_id['id_tr'] ; 
        $freq = (isset($_REQUEST['freq'])) ? htmlspecialchars($_REQUEST['freq']) : 1 ;
        $consultaTreinamento = $check->findTreinamento($treinamento);
        $nometreinamento = $consultaTreinamento['Treinamento'];
        $consultaCheck = $check->find($treinamento . "_" . $freq);
        $status = $retVal = (isset($consultaCheck[0]['Status'])) ? $consultaCheck[0]['Status'] : "" ;
        $consultarRespostas = $check->respCheck($treinamento . "_" . $freq . "_" . $id);
    ?>
<div class="texto">
        <h3> <i class="fas fa-check"></i> <?php echo " Questões Check de Reação: $nometreinamento"; ?> </h3><br/>
        <h2>  <?php echo "Colaborador: $nome"; ?></h2><br/>
        <form method="POST" class="formmenu formcheck" action="_controller/controllerCheckReacao.php" name="formcheck" onsubmit="return validaCheck();">
            <fieldset name="fd1"><h3>1 - Estrutura</h3><br/><br/>
                <label for="opt1_1">1.1 - Como você avalia as instalações físicas utilizadas pela empresa para a realização deste treinamento ? <br/>
                    (considere aspectos como limpeza, nível de ruído e conforto)</label><br/><br/>
                <input type="radio" name="opt1_1" value="A" />A Muito Positiva<br/>
                <input type="radio" name="opt1_1" value="B" />B Positiva<br/>
                <input type="radio" name="opt1_1" value="C" />C Negativa<br/>
                <input type="radio" name="opt1_1" value="D" />D Muito Negativa<br/><br/>
                
                <label for="opt1_2">1.2 - Qual a sua opinião sobre os recursos áudio visuais utilizados neste treinamento ?<br/> (data show, TV, sistema de som, flip chart, etc)</label><br/><br/>
                <input type="radio" name="opt1_2" value="A" />A Muito Positiva<br/>
                <input type="radio" name="opt1_2" value="B" />B Positiva<br/>
                <input type="radio" name="opt1_2" value="C" />C Negativa<br/>
                <input type="radio" name="opt1_2" value="D" />D Muito Negativa<br/><br/>
            </fieldset>
            
            <fieldset name="fd2"><h3>2 - Instrutor</h3><br/><br/>
                <label for="opt2_1">2.1 - Em relação ao(s) instrutor(es) responsável(is) pelo treinamento, como você avalia a capacidade de transmissão do conteúdo ?</label><br/><br/>
                <input type="radio" name="opt2_1" value="A" />A Muito Positiva<br/>
                <input type="radio" name="opt2_1" value="B" />B Positiva<br/>
                <input type="radio" name="opt2_1" value="C" />C Negativa<br/>
                <input type="radio" name="opt2_1" value="D" />D Muito Negativa<br/><br/>
                
                <label for="opt2_2">2.2 - O(s) instrutor(es) responsável(is) pelo treinamento foram receptivos quanto ao esclarecimento de dúvidas dos participantes ?</label><br/><br/>
                <input type="radio" name="opt2_2" value="A" />A Sempre<br/>
                <input type="radio" name="opt2_2" value="B" />B Quase sempre<br/>
                <input type="radio" name="opt2_2" value="C" />C Raramente<br/>
                <input type="radio" name="opt2_2" value="D" />D Nunca<br/><br/>
                
                <label for="opt2_3">2.3 - Em sua opinião, o(s) instrutor(es) responsável(is) pelo treinamento demonstraram domínio sobre os assuntos transmitidos no treinamento ?</label><br/><br/>
                <input type="radio" name="opt2_3" value="A" />A Sempre<br/>
                <input type="radio" name="opt2_3" value="B" />B Quase sempre<br/>
                <input type="radio" name="opt2_3" value="C" />C Raramente<br/>
                <input type="radio" name="opt2_3" value="D" />D Nunca<br/><br/>
            </fieldset>
            
            <fieldset name="fd3"><h3>3 - Conteúdo</h3><br/><br/>
                <label for="opt3_1">3.1 - Em sua opinião o tempo dedicado a realização deste treinamento foi:</label><br/><br/>
                <input type="radio" name="opt3_1" value="A" />A Adequado<br/>
                <input type="radio" name="opt3_1" value="B" />B Exagerado<br/>
                <input type="radio" name="opt3_1" value="C" />C Insuficiente<br/><br/>
                
                <label for="opt3_2">3.2 - Você conseguiu entender todo o conteúdo transmitido durante o treinamento ?</label><br/><br/>
                <input type="radio" name="opt3_2" value="A" />A Sempre<br/>
                <input type="radio" name="opt3_2" value="B" />B Quase sempre<br/>
                <input type="radio" name="opt3_2" value="C" />C Raramente<br/>
                <input type="radio" name="opt3_2" value="D" />D Nunca<br/><br/>
                
                <label for="opt3_3">3.3 - Qual a sua opinião sobre a importância do tema tratado neste treinamento ?</label><br/><br/>
                <input type="radio" name="opt3_3" value="A" />A Muito importante<br/>
                <input type="radio" name="opt3_3" value="B" />B Importante<br/>
                <input type="radio" name="opt3_3" value="C" />C Pouco importante<br/>
                <input type="radio" name="opt3_3" value="D" />D Desnecessário<br/><br/>
                
                <label for="opt3_4">3.4 - Você entende que poderá utilizar algo do que aprendeu neste treinamento em sua função e/ou vida pessoal ?</label><br/><br/>
                <input type="radio" name="opt3_4" value="A" />A Sempre<br/>
                <input type="radio" name="opt3_4" value="B" />B Quase sempre<br/>
                <input type="radio" name="opt3_4" value="C" />C Raramente<br/>
                <input type="radio" name="opt3_4" value="D" />D Nunca<br/><br/>
                
                <label for="opt3_5">3.5 - Qual a sua avaliação sobre o conteúdo geral do treinamento ?</label><br/><br/>
                <input type="radio" name="opt3_5" value="A" />A Muito Positiva<br/>
                <input type="radio" name="opt3_5" value="B" />B Positiva<br/>
                <input type="radio" name="opt3_5" value="C" />C Negativa<br/>
                <input type="radio" name="opt3_5" value="D" />D Muito Negativa<br/><br/>
                
                Obs.:<br/><textarea name="obs" rows="4" cols="20">
                </textarea>
            </fieldset>
            <input type="hidden" name="id_tr" id="tipo" value="<?php echo $treinamento; ?>" />
            <input type="hidden" name="freq" id="cargo" value="<?php echo $freq; ?>" />
            <input type="hidden" name="matricula" id="tipo" value="<?php echo $id; ?>" />
            <input name="tEnviar" type="submit" class="enviar radius" value="Responder"/><i class="fas fa-arrow-circle-right"></i>
        </form>
</div>
<?php else:?>
    <div class="texto">
        <ul class="formmenu"> 
            <li><a href="cadconfig.php?consultar=true&inserir=true" > <i class="fas fa-user-graduate"></i> Inserir Treinamento</a></li>
        </ul>
    <form method="POST" class="formmenu" name="formCadastro" 
          action="checkreacao.php" onsubmit="return validaCadastro();" >
        <fieldset id="usuario"><legend>
            Cadastro de Treinamentos:</legend>
        </fieldset>
        <fieldset id="treinamento"><legend>Dados do Treinamento:</legend>
        <label for="consultar">Nome do Treinamentos.:</label><input type="text" name="consultar" id="consultar"
            size="40" maxlength="100" placeholder="Treinamento"/><br/>
        </fieldset>
    
    Frequência :
        <select name="freq">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
            <option>11</option>
            <option>12</option>
        </select><br/><br/>
    <input name="Enviar" type="submit" class="enviar radius" value="Consultar" 
       onsubmit="return validarSenha();" /><i class="fas fa-arrow-circle-right"></i>
    <br/>
    <br/> 
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