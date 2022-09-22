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
<h3>Treinamentos >> Lent >> Planejamento</h3>
<h1><i class="fas fa-address-card"></i> &nbsp;Programação LENT</h1><br/>
<a href="plan.php">
 <i class="fas fa-arrow-circle-left"></i>Outra Área</a>
</hgroup>
<div class="texto">
    <form method="POST" class="formmenu" action="_controller/controllerPlano.php" 
          name="formTreinamentos" >
        <fieldset id="curso"><legend>Área</legend>
        <h3>Programação dos Treinamentos</h3><br/>
        <p><table class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr class="active">
                        <td>Treinamento</td>
                        <td>Cargos Obrigatórios</td>
                        <td>Frequência </td>
                        <td>Responsável</td>
                        <td>Carga Horária</td>
                        <td>Data Prevista</td>
                    </tr>
                </thead>
                <tbody>
            <?php   $dataD = date("d/m/Y");
                    $data = explode("/", $dataD);
                    list($dia, $mes, $ano) = $data;
                    $inicioAno = "$ano-01-01"; $fimAno = "$ano-12-31";
                    require_once './_model/plano.php';
                    $plano = new plano($conexao); 
                    require_once './_model/treinamento.php';
                    $treinamento = new treinamento($conexao);
                    $id = base64_decode(htmlspecialchars($_REQUEST['area']));
                    $resultadotreinamento = $treinamento->find($id); 
                    foreach ($resultadotreinamento as $key => $value1) {
                        echo "<tr>";
                        foreach ($value1 as $key2 => $value2) {
                            if ($key2=="id_tr") {
                                $w = $value1['id_tr'];
                                echo "<input type='hidden' value='$w' name='id$key' readonly='readonly' />";
                            }else {
                                echo "<td>" . $value2 . "</td>";
                            }
                        }
                        $w = $value1['id_tr'];
                        $buscardata = $plano->findDate($w);
                        if (count($buscardata['previsao'])==1) {
                            $valorData = $buscardata['previsao'];
                            echo "<td><input type='date' id='previsao$key' class='enviar radius' min='$inicioAno' max='$fimAno' value='$valorData' placeholder='Previsão'  name='previsao$key' /> </td></tr>";
                        } else {
                            echo "<td><input type='date' id='previsao$key' class='enviar radius' min='$inicioAno' max='$fimAno' value='' placeholder='Previsão'  name='previsao$key' /> </td></tr>";
                        }
                        echo "<script type='text/javascript'>
                        var navegador = ObterBrowserUtilizado();
                        var tela = ObterTela();
                        var data = document.getElementById('previsao$key').value;
                        if (navegador!='Google Chrome' && tela && (data.substring(3,2)!='/')) {
                            var data = document.getElementById('previsao$key').value;
                            var datatxt = InverterData(data);
                            document.getElementById('previsao$key').value = datatxt;
                        }</script>";
                    } 
                    ?>
                </tbody>
            </table></p>
        </fieldset>
        <input type="hidden" <?php echo "value='$id'"; ?> name="area" readonly="readonly" />
        <input type="hidden" <?php $valor = count($resultadotreinamento); echo "value='$valor'"; ?> name="qtd" readonly="readonly" />
        <input type="hidden" value="1" name="Funcao" readonly="readonly" />
        <input name="tEnviar" type="submit" class="enviar radius" value="Salvar"/>
        <i class="fas fa-arrow-circle-right"></i>
    </form>
</div>
<?php else:?>
<hgroup class="pagina">
<h3>Damata >> Treinamentos >> Lent</h3>
<h1><i class="fas fa-check-square"></i> Programação LENT</h1><br/><br/>
<a href="user.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
    <ul class="formmenu">
        <li><a href="plan.php"><i class="fas fa-calendar-alt"></i> IT01 - Planejamento LENT</a></li>
        <li><a href="launch.php" > <i class="fas fa-chalkboard-teacher"></i> IT02 - Lançar LENT</a></li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiZjdkM2Y0NjUtOGRjNS00ZjczLWIzMTgtYWJiNDc3OTg0MjMyIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
              target="_blank"> <i class="fas fa-chart-bar"></i> DashBoard LENT</a> </li>
    </ul><br/>
    <form method="POST" class="formmenu" action="plan.php" 
          name="formAlterarbuscar Curso" >
        <fieldset id="curso"><legend>Área Setor</legend><br/>
        <h3>Escolha a Área</h3><br/>
        <p><label for="area"> Área </label>
            <select name="area" class="form-control col-sm-4">
                <option value="MQ==">SEGURANÇA</option>
                <option value="Mg==" selected >GENTE</option>
                <option value="Mw==" >GESTÃO</option>
                <option value="NA==" >COMERCIAL</option>
                <option value="NQ==">FINANCEIRO</option>
                <option value="Ng==" >ENTREGA</option>
                <option value="Nw==" >ARMAZÉM</option>
                <option value="OA==" >PLANEJAMENTO</option>
                <option value="OQ==" >FROTA</option>
                <option value="MTA=" >NÍVEL DE SERVIÇO</option>
            </select>
        </p><br/>       
    </fieldset>
    <input type="hidden" value="4" name="Funcao" readonly="readonly" />
    <input name="tEnviar" type="submit" class="enviar radius" value="Consultar"/>
    <i class="fas fa-arrow-circle-right"></i>
    </form>
</div>
<?php endif;?>
<?php require_once "./_page/footer.php";
echo $tela = (isset($_REQUEST['success'])) ? "<script type='text/javascript' >lentSucess();</script>" : "";?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
            $(function(){
                $("#consultar").autocomplete({
                    source: '_page/proc_pesq_nome.php'
                });
            });
</script>