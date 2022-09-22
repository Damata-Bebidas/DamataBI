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
    require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Treinamentos >> Check >> Config</h3>
<h1><i class="fas fa-chart-pie"></i> Check Configuração<br/><br/></h1>
<a href="user.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if($_SESSION['type']=="ROOT" || $_SESSION['type']=="GENTE" || $_SESSION['type']=="GESTOR"):?>
    <?php $treinamento = (isset($_REQUEST['tr'])) ? base64_decode(htmlspecialchars($_REQUEST['tr'])) : '' ; 
        $freq = (isset($_REQUEST['freq'])) ? htmlspecialchars($_REQUEST['freq']) : 1 ;
        $consultaTreinamento = $check->findTreinamento($treinamento);
        $nometreinamento = $consultaTreinamento['Treinamento'];
        $consultaCheck = $check->find($treinamento . "_" . $freq);
        $status = (isset($consultaCheck[0]['Status'])) ? $consultaCheck[0]['Status'] : "" ;
        $matInstrutor = (isset($consultaCheck[0]['instrutor'])) ? $consultaCheck[0]['instrutor'] : "" ;
        $custo = $consultaTreinamento['custo'];
        $internoExterno = $consultaTreinamento['tipo'];
        $interno = ($internoExterno=="Interno") ? "selected='selected'" : "" ;
        $externo = ($internoExterno=="Externo") ? "selected='selected'": "" ;    
    ?>
<div class="texto">
        <h3> <i class="fas fa-check"></i> <?php echo "Check de Retenção: $nometreinamento"; ?> </h3><br/>
        <h6>  <?php echo "Frequência: $freq ª x Ano"; ?> <br/> Questões</h6><br/>
        <form method="POST" class="formmenu formcheckconfig" action="_controller/controllerCheck.php" name="formcheckConfig" onsubmit="return validaCheckConfig();" >
            <input type="radio" name="status" value="Ativo" <?php echo $telaA = ($status == "Ativo") ? "checked" : "" ; ?> />Ativo
            <input type="radio" name="status" value="Inativo" <?php echo $telaI = ($status == "Inativo") ? "checked" : "" ; ?> /> Inativo<br/>
            Instrutor => 
            <?php $consultaInstrutores = $check->consultInstrutores();
                echo "<select name='instrutor'><option value=''></option>";
                        foreach ($consultaInstrutores as $key => $value) {
                            if ($matInstrutor==$value['matricula']) {
                                echo "<option value='". $value['matricula'] . "' selected='selected'>" . $value['nome'] . "</option>";
                            } else {
                                echo "<option value='". $value['matricula'] . "' >" . $value['nome'] . "</option>";
                            }
                        }
                echo  "</select><br/><br/>";
                echo "Interno/Externo: <select name='intext'>
                        <option $interno >Interno</option>
                        <option $externo >Externo</option>
                      </select><br/><br/>";
                echo "OBZ: Custo do Treinamento: <input type='number' name='custo' step='any' min='0' value='$custo' /><br/>";
                for ($i=0 ; $i < 10 ; $i++ ) {
                    $Questao = (isset($consultaCheck[$i]['Questao'])) ? $consultaCheck[$i]['Questao'] : "" ;
                    $A = (isset($consultaCheck[$i]['A'])) ? $consultaCheck[$i]['A'] : "" ;
                    $B = (isset($consultaCheck[$i]['B'])) ? $consultaCheck[$i]['B'] : "" ;
                    $C = (isset($consultaCheck[$i]['C'])) ? $consultaCheck[$i]['C'] : "" ;
                    $D = (isset($consultaCheck[$i]['D'])) ? $consultaCheck[$i]['D'] : "" ;
                    $Gab = (isset($consultaCheck[$i]['Gabarito'])) ? $consultaCheck[$i]['Gabarito'] : "" ;
                    $n1 = $i;
                    $n2 = ++$n1;
                    $n = ($n<10) ? "0". $n2 : $n2;
                    echo "<-------------------------------------------------><br/>
                    $n. - <input type='text' name='qt$i' size='50' value='$Questao' /><br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; A: <input type='text' name='qtA$i' size='50' value='$A' /><br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; B: <input type='text' name='qtB$i' size='50' value='$B' /><br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; C: <input type='text' name='qtC$i' size='50' value='$C' /><br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; D: <input type='text' name='qtD$i' size='50' value='$D' /><br/>
                    &nbsp;&nbsp;&nbsp;&nbsp; Gabarito: <input type='text' name='gab$i' size='5' value='$Gab' /><br/>";
                }
            ?>
            <input type="hidden" name="id_tr" id="tipo" value="<?php echo $treinamento; ?>" />
            <input type="hidden" name="freq" id="cargo" value="<?php echo $freq; ?>" />
            <input name="tEnviar" type="submit" class="enviar radius" value="Salvar"/><i class="fas fa-arrow-circle-right"></i>
        </form>
</div>
<?php else:?>
    <div class="texto">
    <h2>Seu Usuário Não tem Acesso a essa página, consulte o Administrador do Sistema</h2>
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