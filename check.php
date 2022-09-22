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
?>
<hgroup class="pagina">
<h3>Damata >> Treinamentos >> Check </h3>
<h1><i class="fas fa-chart-pie"></i> Check Retenção<br/><br/></h1>
<a href="user.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['tr'])):?>
    <?php $treinamento = (htmlspecialchars(isset($_REQUEST['tr']))) ? base64_decode(htmlspecialchars($_REQUEST['tr'])) : '' ;
        $tr_b64 = (isset($_REQUEST['tr'])) ? htmlspecialchars($_REQUEST['tr']) : '' ;
        $freq = (isset($_REQUEST['freq'])) ? htmlspecialchars($_REQUEST['freq']) : 1 ;
        $consultaTreinamento = $check->findTreinamento($treinamento);
        $nometreinamento = $consultaTreinamento['Treinamento'];
        $consultaCheck = $check->find($treinamento . "_" . $freq);
        $status = (isset($consultaCheck[0]['Status'])) ? $consultaCheck[0]['Status'] : "" ;
        $consultarRespostas = $check->respCheck($treinamento . "_" . $freq . "_" . $id);
    ?>
<div class="texto">
        <h3> <i class="fas fa-check"></i> <?php echo " Questões Check de Retenção: $nometreinamento"; ?> </h3><br/>
        <?php echo $tela = (isset($consultarRespostas['QT1'])) ? "<h3><span id='destaque'>Check de Reação --> <a href='checkreacao.php?tr=$tr_b64&freq=$freq' >Click aqui!</a></span></h3>" : "" ; ?>
        <h2>  <?php echo "Colaborador: $nome"; ?></h2><br/>
        <?php
        if (isset($_REQUEST['nome'])) {
            echo "<form name='formReaplicar' action='_controller/controllerCheckResp.php' method='GET'>
                    <input type='hidden' name='id_tr' id='id_tr' value='$treinamento' />
                    <input type='hidden' name='freq' id='freq' value='$freq'' />
                    <input type='hidden' name='matricula' id='matricula' value='$id' />
                    <input type='hidden' name='optR' id='optR' value='true' />
                    <input type='hidden' name='exec' id='exec' value='V' />
                    <input type='radio' name='ReapSN' value='S' /> Sim
                    <input type='radio' name='ReapSN' value='N' checked='checked' /> Não<br/>
                    <input name='tEnviar' type='submit' class='enviar radius' value='Reaplicar Check'/><i class='fas fa-arrow-circle-right'></i>
                </form>";
        }
        ?>
        <form method="POST" class="formmenu formcheck" action="_controller/controllerCheckResp.php" name="formcheck" onsubmit="return validaCheck();">
            <?php $acertos=0;
                for ($i=0 ; $i < 10 ; $i++ ) {
                    $Questao = (isset($consultaCheck[$i]['Questao'])) ? $consultaCheck[$i]['Questao'] : "" ;
                    $A = (isset($consultaCheck[$i]['A'])) ? $consultaCheck[$i]['A'] : "" ;
                    $B = (isset($consultaCheck[$i]['B'])) ? $consultaCheck[$i]['B'] : "" ;
                    $C = (isset($consultaCheck[$i]['C'])) ? $consultaCheck[$i]['C'] : "" ;
                    $D = (isset($consultaCheck[$i]['D'])) ? $consultaCheck[$i]['D'] : "" ;
                    $Gab = (isset($consultaCheck[$i]['Gabarito'])) ? $consultaCheck[$i]['Gabarito'] : "" ;
                    $n1 = $i;
                    $n = ++$n1;
                    $consultaGabarito = $check->checkGabarito($treinamento . "_" . $freq . "_" . $i);
                    $gabarito = $consultaGabarito['Gabarito'];
                    $resp = $consultarRespostas['QT' . ($i + 1)]; $respA="";$respB="";$respC="";$respD="";
                    $correcao="Errou";
                    switch ($resp) {
                        case 'A':
                            $respA="checked='checked'";
                            if ($gabarito=="A") {
                                $correcao="Acertou";
                                $acertos++;
                            }
                            break;
                        case 'B':
                            $respB="checked='checked'";
                            if ($gabarito=="B") {
                                $correcao="Acertou";
                                $acertos++;
                            }
                            break;
                        case 'C':
                            $respC="checked='checked'";
                            if ($gabarito=="C") {
                                $correcao="Acertou";
                                $acertos++;
                            }
                            break;
                        case 'D':
                            $respD="checked='checked'";
                            if ($gabarito=="D") {
                                $correcao="Acertou";
                                $acertos++;
                            }
                            break;
                    }
                    $respW = ($respA<>"" || $respB<>"" || $respC<>"" || $respD<>"") ? "disabled='disabled'" : "" ;
                    if (count($consultaCheck)>0) {
                        echo "$n. - $Questao <br/><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp; <input type='radio' name='qt$i' $respA $respW value='A'/> A -- $A <br/>
                        &nbsp;&nbsp;&nbsp;&nbsp; <input type='radio' name='qt$i' $respB $respW value='B'/> B -- $B <br/>
                        &nbsp;&nbsp;&nbsp;&nbsp; <input type='radio' name='qt$i' $respC $respW value='C'/> C -- $C <br/>
                        &nbsp;&nbsp;&nbsp;&nbsp; <input type='radio' name='qt$i' $respD $respW value='D'/> D -- $D <br/>";
                    }else{
                        if ($i<=0) {
                            $id_tr_encode = base64_encode($treinamento);
                            echo "<a href='checkconfig.php?tr=$id_tr_encode&freq=$freq'>Esse treinamento não possui check de retenção</a><br/><br/>";
                        }
                    }
                    if ($respA<>"" || $respB<>"" || $respC<>"" || $respD<>"") {
                        if ($correcao=="Acertou") {
                            echo "<span class='pago'>Gabarito => $gabarito <br/>Status => $correcao</span><br/><br/>";
                        } else if($correcao=="Errou") {
                            echo "<span class='pendente'>Gabarito => $gabarito <br/>Status => $correcao</span><br/><br/>";
                        }
                        echo "-----------------------------------------------------<br/>";
                    }
                }
                if ($respA<>"" || $respB<>"" || $respC<>"" || $respD<>"") {
                    $erros = 10 - $acertos;
                    $aderencia1 = ($acertos / 10) *100;
                    $aderencia = number_format($aderencia1,0,",",".");
                    echo "<h5><span class='pago'>Quant. Acertos = $acertos</span></h5>"; 
                    if ($erros>0) {
                        echo "<h5><span class='pendente'>Quant. Erros = $erros</span></h5>"; 
                    }
                    echo "<h5> % Retenção = $aderencia %</h5><br/>"; 
                }
            ?>
            <input type="hidden" name="id_tr" id="tipo" value="<?php echo $treinamento; ?>" />
            <input type="hidden" name="freq" id="cargo" value="<?php echo $freq; ?>" />
            <input type="hidden" name="matricula" id="tipo" value="<?php echo $id; ?>" />
            <input type="hidden" name="exec" id="exec" value="<?php echo $exec = (isset($_REQUEST['nome'])) ? "V" : "F"; ?>" />
            <?php echo $botao = ($respA=="" && $respB=="" && $respC=="" && $respD=="") ? '<input name="tEnviar" type="submit" class="enviar radius" value="Responder"/><i class="fas fa-arrow-circle-right"></i>' : '' ; ?>
        </form>
</div>
<?php else:?>
    <div class="texto">
    <?php $listaCheck = $check->listarChecks($id);$c=0;
        foreach ($listaCheck as $key => $value) { 
            $freqMax = $check->checkResp($id,$value['id_tr']);
            $abertos = $check->checkAbertos($value['id_tr']);
            $exec_abertos = $abertos['MAX(`check`.`freq`)'];
            $exec_resp = $freqMax['max(`checkResp`.`freq`)'];
            if ($exec_abertos <> "" && $exec_abertos > $exec_resp) {
                echo "<a href='check.php?tr=" . base64_encode($value['id_tr'])  . "&freq=$exec_abertos'>" . 
                $value['Treinamento'] . "</a><br/>";
                $c++;
            } 
        }
        echo $tela = ($c>0 && $_SESSION['type']<>"BASIC") ? "<h4>Check disponíveis para $nome. </h2>" : "<h2>Você não possui checks para responder. </h4>"; 
    ?>
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