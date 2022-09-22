<?php ob_start();//inicio da sessao 
      session_start();//inicio da sessao
      require_once "./_page/header.php"; 
      require_once "./_page/menu.php"; 
      require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
        $url->logarUser(); //verificar se esta logado
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/colaborador.php';
    $colaborador = new colaborador($conexao);
    $matricula = $_SESSION['user'];
    $resultado = $colaborador->login($matricula);
    $colaborador->setMatricula($resultado['matricula']);
    $colaborador->setNome($resultado['nome']);
    $colaborador->setEmail($resultado['email']);
    $colaborador->setNascimento($resultado['nascimento']);
    $colaborador->setSexo($resultado['sexo']);
    $colaborador->setEscolaridade($resultado['escolaridade']);
    $colaborador->setSenha($resultado['senha']);
    $colaborador->setAdmissao($resultado['admissao']);
    $colaborador->setCargo($resultado['cargo']);
    $colaborador->setSetor($resultado['setor']);
    $colaborador->setStatus($resultado['status']);
    $colaborador->setTipo($resultado['tipo']); 
    $nome = $resultado['nome'];
    $setor = $resultado['setor'];
    $email = $resultado['email'];
    $cargo = $resultado['cargo'];
    $nascimento = $resultado['nascimento'];
    $admissao = $resultado['admissao'];
    $sexo = $resultado['sexo'];
    $escolaridade = $resultado['escolaridade'];
    $status = $resultado['status'];
    $tipo = $resultado['tipo'];?>
<?php if(isset($_REQUEST['area'])):?>
<hgroup class="pagina">
<h3>Damata >> Treinamentos >> Lent </h3>
<h1><i class="fas fa-address-card"></i> &nbsp;&nbsp;Lançamento LENT</h1><br/><br/>
    &nbsp;&nbsp; &nbsp;&nbsp;<a href="launch.php">
 <i class="fas fa-arrow-circle-left"></i>Outra Área</a>
</hgroup>
<div class="texto">
    <form method="POST" class="formmenu" action="_controller/controllerPlano.php" 
          name="formTreinamentos" >  
        <fieldset id="curso"><legend>Área</legend>
        <h3>Programação dos Treinamentos</h3><br/>
        <p><table class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <td>Treinamento</td>
                        <td>Cargos Obrigatórios</td>
                        <td>Frequência </td>
                        <td>Responsável</td>
                        <td>Carga Horária</td>
                    </tr>
                </thead>
                <tbody>
            <?php   require_once './_model/treinamento.php';
                    $treinamento = new treinamento($conexao);
                    $id =  base64_decode(htmlspecialchars($_REQUEST['area']));
                    $resultadotreinamento = $treinamento->find($id);
                    foreach ($resultadotreinamento as $key => $value1) {
                        echo "<tr>";
                        foreach ($value1 as $key2 => $value2) {
                            $w = $value1['id_tr'];
                            $planejamento = $treinamento->findPlan($w);
                            $hash = base64_encode($w);
                            if ($key2=="Treinamento") {
                                if (trim($planejamento['previsao'])<>"" && $planejamento['previsao']<>"0000-00-00") {
                                    echo "<td><a target='_blank' href='launch.php?tr=$hash'>$value2</a></td>";
                                } else {
                                    echo "<td>$value2</td>";
                                }
                                
                            } elseif ($key2<>"id_tr") {
                                echo "<td>" . $value2 . "</td>";
                            } 
                        }
                        echo "</tr>";
                    } ?>
                </tbody>
            </table></p>
        </fieldset>
        <input type="hidden" <?php echo "value='$id'"; ?> name="area" readonly="readonly" />
        <input type="hidden" <?php $valor = count($resultadotreinamento); echo "value='$valor'"; ?> name="qtd" readonly="readonly" />
        <input type="hidden" value="1" name="Funcao" readonly="readonly" />
    </form>
</div>
<?php elseif(isset($_REQUEST['tr'])):?>
<hgroup class="pagina">
<h3>Damata >> Treinamentos >> Lent >> Lançamento </h3>
<h1><i class="fas fa-address-card"></i> &nbsp;&nbsp;Lançamento LENT</h1><br/><br/>
    &nbsp;&nbsp; &nbsp;&nbsp;<a href="launch.php">
 <i class="fas fa-arrow-circle-left"></i> Outra Área</a>
</hgroup>
<div class="texto">
        <?php  
            require_once './_model/plano.php';
            $plano = new plano($conexao); 
            require_once './_model/aplicabilidade.php';
            $aplic = new  aplicabilidade($conexao);
            $id_consulta = base64_decode(htmlspecialchars($_REQUEST['tr']));
            $resultadoArea = $aplic->findArea($id_consulta);
            $matrizTreinemento = $plano->nomeTreinamento($id_consulta);
            $id = htmlspecialchars($_REQUEST['tr']);
            if ($resultadoArea['id_area']<=3) {//<=3 somente as áreas gente gestão e seguranca
                $matriz = array('ADMINISTRATIVO','APOIO LOGÍSTICO',
                    'DISTRIBUIÇÃO URBANA','PUXADA','VENDAS');
                $k = 0;
                echo "<form method='POST' action='_controller/controllerPlano.php' name='formTreinamentos' >";
                echo "<a href='launch.php?tr=$id'> Limpar Área (Todos Colaboradores)</a><br/><br/>";
                foreach ($matriz as $key => $value) {
                    $k++; $n = $matriz[$key];
                    echo "<input type='hidden' value='$id' name='tr$k' readonly='readonly' />
                    <input type='hidden' value='$k' name='aplic$k' readonly='readonly' />
                    <input name='consultar' type='submit' class='enviar radius' value='$n'/>"; 
                }
                echo "</form>";
            }
            $frequencia = $plano->findFrequencia($id_consulta);
            $valor = htmlspecialchars($frequencia['frequencia']);
            $tamanhoString = strlen($valor) - 1;
            $texto = substr($valor,1,$tamanhoString);
            $qtd = substr($valor,0,1);
            if ($qtd>1) {
                for ($i=1; $i <= $qtd ; $i++) {
                    $tr = (isset($_REQUEST['tr'])) ? htmlspecialchars($_REQUEST['tr']) : "" ;
                    $w = (isset($_REQUEST['aplic'])) ? "value='" . htmlspecialchars($_REQUEST['aplic']) . "'" : "";
                    echo "<form method='POST' action='_controller/controllerPlano.php' name='formTreinamentos' >
                    <input type='hidden' value='$tr' name='tr' readonly='readonly' />
                    <input type='hidden' $w name='aplic' readonly='readonly' />
                    <input name='frequencia' type='submit' class='enviar radius' value='$i x Ano'/>
                    </form>"; 
                }
            } ?> 
        <form method="POST" class="formmenu" action="_controller/controllerTreinar.php" 
          name="formTreinamentos" >  
        <fieldset id="curso"><legend>Área</legend>
        <h3>Lançar Presença do Treinamento => 
            <?php echo $telaT = (count($matrizTreinemento)>1) ? $matrizTreinemento['Treinamento'] : "" ; ?></h3><br/>
        Click aqui <i class="fas fa-arrow-alt-circle-right"></i>
        <?php   $dataHoje = date("Y-m-d");
                $dataD = date("d/m/Y");
                $data = explode("/", $dataD);
                list($dia, $mes, $ano) = $data;//divide matriz em variaveis
                $inicioAno = "$ano-01-01";
                $linkFreq = (isset($_REQUEST['freq'])) ? htmlspecialchars($_REQUEST['freq']): 1 ;            
                if (isset($_REQUEST['all'])) {
                    if (isset($_REQUEST['aplic'])) {
                        $a = htmlspecialchars($_REQUEST['aplic']);
                        echo "<a href='launch.php?tr=$id&clean=true&aplic=$a&freq=$linkFreq'> Desmarcar Todos</a><br/><br/>";
                    } else {
                        echo "<a href='launch.php?tr=$id&clean=true&freq=$linkFreq'> Desmarcar Todos</a><br/><br/>";
                    }
                } else {
                    if (isset($_REQUEST['aplic'])) {
                        $a = htmlspecialchars($_REQUEST['aplic']);
                        echo "<a href='launch.php?tr=$id&all=true&aplic=$a&freq=$linkFreq'> Marcar Todos</a><br/><br/>";
                    } else {
                        echo "<a href='launch.php?tr=$id&all=true&freq=$linkFreq'> Marcar Todos</a><br/><br/>";
                    }
                }
                echo "<i class='fas fa-file-archive'></i> Relatório em Excel<a href='_page/relatorioLent.php?tr=$id&all=true&freq=$linkFreq'> >> Gerar</a><br/><br/>";
                ?>
        <i class='fas fa-sliders-h'></i> Check >> 
        <?php $id_trei = (isset($_REQUEST['tr'])) ? htmlspecialchars($_REQUEST['tr']) : "MQ==";
              $nu_freq = (isset($_REQUEST['freq'])) ? htmlspecialchars($_REQUEST['freq']) : 1 ;
        //echo "<a href='checkconfig.php?tr=$id_trei&freq=$nu_freq'> Configurar  </a>"; ?> <br/><br/>
        <p> <table class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <td>Participou?</td>
                        <td>Check Retenção</td>
                        <td>Matricula</td>
                        <td>Nome</td>
                        <td>Cargo</td>
                        <td>Data</td>
                    </tr>
                </thead>
                <tbody>
            <?php   if (isset($_REQUEST['aplic'])) {
                        $areaTxt = $matriz[(htmlspecialchars($_REQUEST['aplic']))-1];
                        $resultadoAplic = $aplic->findTreinamentoArea($id_consulta,$areaTxt);
                    } else {
                        $resultadoAplic = $aplic->findTreinamento($id_consulta);
                    }
                    $totalAplic = count($resultadoAplic);
                    $presenca = 0;
                    foreach ($resultadoAplic as $key => $value1) {
                        $freq = (isset($_REQUEST['freq'])) ? htmlspecialchars($_REQUEST['freq']) : 1;
                        $mat = base64_encode($value1['matricula']);
                        $nome = base64_encode($value1['nome']);
                        $m = $value1['matricula'] . "_" . base64_decode(htmlspecialchars($_REQUEST['tr'])) . "_" . $freq;
                        $buscarTreinamento = $plano->findTreinar($m);
                        if (isset($_REQUEST['all'])) {
                            echo "<tr><td> <input type='checkbox' name='status$key' value='ON' checked='checked' /> </td>";
                            $presenca++;
                        }elseif (isset($_REQUEST['clean'])) {
                            echo "<tr><td> <input type='checkbox' name='status$key' value='ON' /> </td>";
                        } elseif ($buscarTreinamento['id_treinar']<>"") {
                            echo "<tr><td> <input type='checkbox' name='status$key' value='ON' checked='checked' /> </td>";
                            $presenca++;
                        } else {
                            echo "<tr><td> <input type='checkbox' name='status$key' value='ON' /> </td>";
                        }
                        echo "<td><a href='check.php?tr=$id_trei&freq=$freq&mat=$mat&nome=$nome'>Check</a></td>";
                        foreach ($value1 as $key2 => $value2) {
                                if ($key2=="matricula") {
                                    echo "<td><input type='text' size='4' id='matricula$key' value='$value2' name='matricula$key' readonly='readonly' /> </td>";
                                } else {
                                    echo "<td>$value2</td>";
                                }
                        }
                        $buscardata = $plano->findDate($id_consulta); //data prevista
                        if ($buscarTreinamento['data']<>"") {
                            $valorData = $buscarTreinamento['data'];
                            if ($valorData<>"" && strtotime($dataHoje)<strtotime($valorData))  {
                                $dataHoje = $valorData;
                            }  
                            echo "<td><input type='date' id='data$key' class='enviar radius' min='$inicioAno' max='$dataHoje' value='$valorData' placeholder='Previsão'  name='data$key' /> </td></tr>";
                        }elseif (count($buscardata['previsao'])==1) {
                            $valorData = $buscardata['previsao'];
                            if ($valorData<>"" && strtotime($dataHoje)<strtotime($valorData))  {
                                $dataHoje = $valorData;
                            }  
                            echo "<td><input type='date' id='data$key' class='enviar radius' min='$inicioAno' max='$dataHoje' value='$valorData' placeholder='Previsão'  name='data$key' /> </td></tr>";
                        } else {
                            echo "<td><input type='date' id='data$key' class='enviar radius' min='$inicioAno' max='$dataHoje' value='' placeholder='Previsão'  name='data$key' /> </td></tr>";
                        }
                        echo "<script type='text/javascript'>
                        var navegador = ObterBrowserUtilizado();
                        var tela = ObterTela();
                        var data = document.getElementById('data$key').value;
                        if (navegador!='Google Chrome' && tela && (data.substring(3,2)!='/')) {
                            var data = document.getElementById('data$key').value;
                            var datatxt = InverterData(data);
                            document.getElementById('data$key').value = datatxt;
                        }</script>";
                    } 
                    if($totalAplic >0){
                        $porcentagem = $presenca / $totalAplic;
                        $falta = $totalAplic - $presenca;
                        $porcentagem*=100;
                        if ($porcentagem>0) {
                            $porcentagem = number_format($porcentagem,1,",",".");
                        } else {
                            $porcentagem = 0;
                        }
                        if ($porcentagem<100) {
                            echo "<h5><span class='pago'>Quant. de Presença = $presenca</span></h5>"; 
                            echo "<h5><span class='pendente'>Quant. Ausência = $falta</span></h5>"; 
                            echo "<h5>Aplicabilidade Total = $totalAplic => Aderência de = $porcentagem %</h5><br/>"; 
                        } else {
                            echo "<h5><span class='pago'>Quant. de Presença = $presenca</span></h5>";
                            echo "<h5>Aplicabilidade Total = $totalAplic => Aderência de = $porcentagem %</h5><br/>"; 
                        }
                    }?>
                </tbody>
            </table></p>
        </fieldset>
        <input type="hidden" value="<?php echo $freq = (isset($_REQUEST['freq'])) ?
                htmlspecialchars($_REQUEST['freq'])  : 1; ?>" name="freq" readonly="readonly" />
        <input type="hidden" <?php echo "value='$id'"; ?> name="tr" readonly="readonly" />
        <input type="hidden" value="<?php echo $tela = ($valorData<>"") ? $valorData : "" ; ?>" name="prev" readonly="readonly" />
        <input type="hidden" <?php $valor1 = count($resultadoAplic); echo "value='$valor1'"; ?> name="qtd" readonly="readonly" />
        <input type="hidden" value="1" name="Funcao" readonly="readonly" />
        <input name="tEnviar" type="submit" class="enviar radius" value="Salvar"/>
        <i class="fas fa-arrow-circle-right"></i>
    </form>
</div>
<?php else:?>
<hgroup class="pagina">
<h3>Damata >> Treinamentos >> Lent</h3>
<h1><i class="fas fa-check-square"></i> Lançamento LENT</h1><br/><br/>
    &nbsp;&nbsp; &nbsp;&nbsp;<a href="user.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
    <ul class="formmenu">
        <li><a href="plan.php"><i class="fas fa-calendar-alt"></i> IT01 - Planejamento LENT</a></li>
        <li><a href="launch.php" > <i class="fas fa-chalkboard-teacher"></i> IT02 - Lançar LENT</a></li>
        <li><a href="https://app.powerbi.com/view?r=eyJrIjoiZjdkM2Y0NjUtOGRjNS00ZjczLWIzMTgtYWJiNDc3OTg0MjMyIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
              target="_blank"> <i class="fas fa-chart-bar"></i> DashBoard LENT</a> </li></ul><br/>   
    <form method="POST" class="formmenu" action="launch.php" 
          name="formAlterarbuscar Curso" >
    <fieldset id="curso"><br/><legend>Área</legend>
        <h3>Escolha a Área</h3><br/>
        <p><label for="area"> Área </label>
            <select name="area" class="form-control col-sm-4">
                <option value="MQ==">SEGURANÇA</option>
                <option value="Mg==" selected>GENTE</option>
                <option value="Mw==" >GESTÃO</option>
                <option value="NA==" >COMERCIAL</option>
                <option value="NQ==">FINANCEIRO</option>
                <option value="Ng==" >ENTREGA</option>
                <option value="Nw==" >ARMAZÉM</option>
                <option value="OA==" >PLANEJAMENTO</option>
                <option value="OQ==" >FROTA</option>
                <option value="MTA=" >NÍVEL DE SERVIÇO</option>
            </select>
        </p> <br/>      
    </fieldset>
    <input type="hidden" value="4" name="Funcao" readonly="readonly" />
    <input name="tEnviar" type="submit" class="enviar radius" value="Consultar"/>
    <i class="fas fa-arrow-circle-right"></i>
    </form>
</div>
<?php endif;?>
<?php require_once "./_page/footer.php"; 
    echo $tela = (isset($_REQUEST['sucess'])) ? "<script type='text/javascript' >provaSucess();</script>" : "";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
            $(function(){
                $("#consultar").autocomplete({
                    source: '_page/proc_pesq_nome.php'
                });
            });
</script>