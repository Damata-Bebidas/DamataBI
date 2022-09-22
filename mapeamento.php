<?php ob_start();
    session_start();
    require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
        $url->logarRootGente();
    try {
        $conexao= new \PDO($dsn, $username, $passwd);
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/colaborador.php';
    $colaborador = new colaborador($conexao);
    if (isset($_REQUEST['consultar'])) {
        $nome = htmlspecialchars($_REQUEST['consultar']);
        $resultado = $colaborador->findName($nome);
        $matricula = $resultado['matricula'];
    }
    require_once './_model/mapeamento.php';
    $mapeamento = new mapeamento($conexao);  
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Mapeamento TurnOver</h3>
<h1><i class="fas fa-map"></i> Mapeamento TurnOver</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="user.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['consultar']) || isset($_REQUEST['inserir'])):?>
<div class="texto">
    <ul class="formmenu">
        <li><a href="mapeamento.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
        <li><a href="mapeamento.php?find=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a><br/><br/></li> 
    </ul><br/><br/>
    <form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formplanobh" action="_controller/controllerMapeamento.php" onsubmit="return validaMapeamento();" >
    <fieldset id="usuario"><legend>
        Mapeamento TurnOver</legend>
    </fieldset>
    <fieldset id="mapeamento"><legend class="small">Dados do Usuário</legend>
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
    <?php   $exec = false;
            $mat = (isset($_REQUEST['mat'])) ? htmlspecialchars($_REQUEST['mat']) : "";
            if (isset($_REQUEST['dataconsul'])) {
                $dataC = $url->converterData(htmlspecialchars($_REQUEST['dataconsul']));
                $data = date("Y-m-d", strtotime($dataC));
            } else {
                $data = date("Y-m-d");
                $keyData = $mat . "_" . $data;
            }
            $resultado = $mapeamento->find($matricula);
    ?>
    <hr class="form col-sm-7 pull-left"/>
    <label for="data">Data Prevista.:</label><input type="date" name="data" 
           id="data" placeholder="data" required class="form-control col-sm-3"
           value="<?php echo $telaA1 = (count($resultado)>1) ? $resultado['data'] : date("Y-m-d") ; ?>"/><br/>
    
    <label for="tipo">Tipo de Dispensa.:</label>
    <select name="tipo" id="Tipo" class="form-control col-sm-5">
        <?php $tipo = ($resultado) ? $resultado['tipo'] : null; ?>
        <option <?php echo $tela11 = ($tipo=="") ? "selected" : "" ; ?> ></option>
        <option <?php echo $tela11 = ($tipo=="C") ? "selected" : "" ; ?> >COM JUSTA CAUSA</option>
        <option <?php echo $tela12 = ($tipo=="S") ? "selected" : "" ; ?> >SEM JUSTA CAUSA</option>
        <option <?php echo $tela12 = ($tipo=="E") ? "selected" : "" ; ?> >ENCERRAMENTO DE ATIVIDADES</option>
        <option <?php echo $tela12 = ($tipo=="P") ? "selected" : "" ; ?> >PEDIDO DE DEMISSÃO</option>
    </select><br/>
    <label for="motivo">Motivo de Desligamento.:</label>
    <select name="motivo" id="Motivo" class="form-control col-sm-5">
        <?php $tipo = ($resultado) ? $resultado['motivo'] : null; ?>
        <option <?php echo $tela12 = ($tipo=="") ? "selected" : "" ; ?> ></option>
        <option <?php echo $tela12 = ($tipo=="ABANDONO DE EMPREGO") ? "selected" : "" ; ?> >ABANDONO DE EMPREGO</option>
        <option <?php echo $tela12 = ($tipo=="ABSENTEÍSMO ELEVADO") ? "selected" : "" ; ?> >ABSENTEÍSMO ELEVADO</option>
        <option <?php echo $tela12 = ($tipo=="ACORDO EMPRESA X COLABORADOR") ? "selected" : "" ; ?> >ACORDO EMPRESA X COLABORADOR</option>
        <option <?php echo $tela12 = ($tipo=="DESVIO DE CONDUTA") ? "selected" : "" ; ?> >DESVIO DE CONDUTA</option>
        <option <?php echo $tela12 = ($tipo=="ENCERRAMENTO DE ATIVIDADES") ? "selected" : "" ; ?> >ENCERRAMENTO DE ATIVIDADES</option>
        <option <?php echo $tela12 = ($tipo=="FALECIMENTO") ? "selected" : "" ; ?> >FALECIMENTO</option>
        <option <?php echo $tela12 = ($tipo=="INCOMPATIBILIDADE COM A EMPRESA ATUAL") ? "selected" : "" ; ?> >INCOMPATIBILIDADE COM A EMPRESA ATUAL</option>
        <option <?php echo $tela12 = ($tipo=="INCOMPATIBILIDADE COM DISTÂNCIA E/OU ACESSO AO TRABALHO") ? "selected" : "" ; ?> >INCOMPATIBILIDADE COM DISTÂNCIA E/OU ACESSO AO TRABALHO</option>
        <option <?php echo $tela12 = ($tipo=="INCOMPATIBILIDADE COM O NÍVEL DE ESFORÇO FÍSICO DA ATIVIDADE") ? "selected" : "" ; ?> >INCOMPATIBILIDADE COM O NÍVEL DE ESFORÇO FÍSICO DA ATIVIDADE</option>
        <option <?php echo $tela12 = ($tipo=="INSATISFAÇÃO COM LIDERANÇAS ATUAIS") ? "selected" : "" ; ?> >INSATISFAÇÃO COM LIDERANÇAS ATUAIS</option>
        <option <?php echo $tela12 = ($tipo=="INSATISFAÇÃO COM O CARGO/FUNÇÃO ATUAL") ? "selected" : "" ; ?> >INSATISFAÇÃO COM O CARGO/FUNÇÃO ATUAL</option>
        <option <?php echo $tela12 = ($tipo=="INSATISFAÇÃO COM O HORÁRIO/TURNO DE TRABALHO") ? "selected" : "" ; ?> >INSATISFAÇÃO COM O HORÁRIO/TURNO DE TRABALHO</option>
        <option <?php echo $tela12 = ($tipo=="NÃO ADEQUAÇÃO AO PERFIL") ? "selected" : "" ; ?> >NÃO ADEQUAÇÃO AO PERFIL</option>
        <option <?php echo $tela12 = ($tipo=="NECESSIDADE DE MUDANÇA DE CIDADE") ? "selected" : "" ; ?> >NECESSIDADE DE MUDANÇA DE CIDADE</option>
        <option <?php echo $tela12 = ($tipo=="NOVO EMPREGO COM MAIOR REMUNERAÇÃO") ? "selected" : "" ; ?> >NOVO EMPREGO COM MAIOR REMUNERAÇÃO</option>
        <option <?php echo $tela12 = ($tipo=="NOVO EMPREGO COM MELHORES BENEFÍCIOS") ? "selected" : "" ; ?> >NOVO EMPREGO COM MELHORES BENEFÍCIOS</option>
        <option <?php echo $tela12 = ($tipo=="NOVO EMPREGO COM MENOR JORNADA DE TRABALHO E/OU MELHOR HORÁRIO DE TRABALHO") ? "selected" : "" ; ?> >NOVO EMPREGO COM MENOR JORNADA DE TRABALHO E/OU MELHOR HORÁRIO DE TRABALHO</option>
        <option <?php echo $tela12 = ($tipo=="NOVO EMPREGO COM MENOR NÍVEL DE ESFORÇO FÍSICO") ? "selected" : "" ; ?> >NOVO EMPREGO COM MENOR NÍVEL DE ESFORÇO FÍSICO</option>
        <option <?php echo $tela12 = ($tipo=="NOVO EMPREGO COM REMUNERAÇÃO E BENEFÍCIOS MELHORES") ? "selected" : "" ; ?> >NOVO EMPREGO COM REMUNERAÇÃO E BENEFÍCIOS MELHORES</option>
        <option <?php echo $tela12 = ($tipo=="OCORRÊNCIA DE VALES / PRESTAÇÃO DE CONTAS") ? "selected" : "" ; ?> >OCORRÊNCIA DE VALES / PRESTAÇÃO DE CONTAS</option>
        <option <?php echo $tela12 = ($tipo=="OUTRAS (ORIGEM PESSOAL OU PROFISSIONAL)") ? "selected" : "" ; ?> >OUTRAS (ORIGEM PESSOAL OU PROFISSIONAL)</option>
        <option <?php echo $tela12 = ($tipo=="PROBLEMAS COMPORTAMENTAIS") ? "selected" : "" ; ?> >PROBLEMAS COMPORTAMENTAIS</option>
        <option <?php echo $tela12 = ($tipo=="PROBLEMAS PESSOAIS") ? "selected" : "" ; ?> >PROBLEMAS PESSOAIS</option>
        <option <?php echo $tela12 = ($tipo=="RELACIONAMENTO COM O CLIENTE FINAL") ? "selected" : "" ; ?> >RELACIONAMENTO COM O CLIENTE FINAL</option>
        <option <?php echo $tela12 = ($tipo=="RENDIMENTO INSATISFATÓRIO") ? "selected" : "" ; ?> >RENDIMENTO INSATISFATÓRIO</option>
        <option <?php echo $tela12 = ($tipo=="RESCISÃO DIRETA") ? "selected" : "" ; ?> >RESCISÃO DIRETA</option>
        <option <?php echo $tela12 = ($tipo=="TÉRMINO DE CONTRATO (TEMPO DETERMINADO OU CUSTOS)") ? "selected" : "" ; ?> >TÉRMINO DE CONTRATO (TEMPO DETERMINADO OU CUSTOS)</option>
    </select><br/>
    
    <hr class="form col-sm-7 pull-left"/><br/>
    <label for="iniciativa">Iniciativa.:</label>
        <?php $iniciativa = ($resultado) ? $resultado['iniciativa'] : null; ?><br/>
        <input type="radio" name="iniciativa" id="Iniciativa1" value="E" <?php echo $telaCD = ($iniciativa =="E") ? "checked='checked'" : "" ; ?>/> Empresa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="iniciativa" id="Iniciativa2" value="C" <?php echo $telaED = ($iniciativa=="C") ? "checked='checked'" : "" ; ?> /> Colaborador
    <hr class="form col-sm-7 pull-left"/><br/>
    <label for="ciclo">Classificação Ciclo de Gente.:</label>
    <select name="ciclo" id="Ciclo" class="form-control col-sm-4">
        <?php $tipo = ($resultado) ? $resultado['ciclo'] : null; ?>
        <option <?php echo $tela11 = ($tipo=="") ? "selected" : "" ; ?> ></option>
        <option <?php echo $tela11 = ($tipo=="P") ? "selected" : "" ; ?> >PREPARAR</option>
        <option <?php echo $tela12 = ($tipo=="M") ? "selected" : "" ; ?> >MUITO BOM</option>
        <option <?php echo $tela12 = ($tipo=="B") ? "selected" : "" ; ?> >BOM</option>
        <option <?php echo $tela12 = ($tipo=="N") ? "selected" : "" ; ?> >NOVO</option>
        <option <?php echo $tela12 = ($tipo=="R") ? "selected" : "" ; ?> >RECUPERAR</option>
        <option <?php echo $tela12 = ($tipo=="D") ? "selected" : "" ; ?> >DESLIGAR</option>
    </select><br/>

    <hr class="form col-sm-7 pull-left"/><br/>
    <label for="situacao">Situação.:</label>
    <?php $tipo = ($resultado) ? $resultado['situacao'] : null; ?><br/>
    <input type="radio" name="situacao" id="Situacao1" value="D" <?php echo $telaCD = ($tipo =="D") ? "checked='checked'" : "" ; ?>/> Desligado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="situacao" id="Situacao3" value="M" <?php echo $telaCD = ($tipo =="M") ? "checked='checked'" : "" ; ?>/> Mapeado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="situacao" id="Situacao2" value="R" <?php echo $telaED = ($tipo=="R") ? "checked='checked'" : "" ; ?> /> Revertido<br/>
    <hr class="form col-sm-7 pull-left"/><br/>
    <input type="hidden" name="id" value="<?php echo $id = ($resultado) ? $resultado['id'] : 0 ; ?>" readonly="readonly" />
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
            }
        </script>
<!--------------------------------tabela-------------------------------->
<?php elseif(isset($_REQUEST['find'])):?>
    <div class="texto">
        <a href="mapeamento.php"> <i class="fas fa-paper-plane"></i> Novo </a><br/><br/>
        <?php
            require_once '_model/mapeamento.php';
            $mapeamento = new mapeamento($conexao);
            $nome_opt = "";
            if (isset($_REQUEST['inicio'])) {
                $inicio = $url->converterData($_REQUEST['inicio']);
                $fim = $url->converterData($_REQUEST['fim']);
                $nome_opt = $_REQUEST['nome'];
                if (!trim($nome_opt)=='') {
                    $resultado = $mapeamento->findFilterNome($inicio, $fim, $nome_opt);
                } else {
                    $resultado = $mapeamento->findFilter($inicio, $fim);
                }
            } else {
                $inicio = date('Y-m') . "-1";
                $fim = date('Y') . "-12-1";
                $resultado = $mapeamento->findFilter($inicio, $fim);
            } 
            $listaDeNomes = $colaborador->findNomes();
        ?>
        <form name="formData"  class="formmenu" action="mapeamento.php" method="POST" enctype="multipart/form-data">


        <div class="form-group">
                <label for="nome" class="col-sm-2 control-label">Nome.:</label>
                <div class="col-sm-5">
                    <input type="search" class="form-control" name="nome" id="nome" autofocus size="30" maxlength="60" placeholder="Nome" list="nomes" value="<?php echo $nome_opt; ?>" /><br>
                        <datalist id="nomes">
                            <?php
                                foreach ($listaDeNomes as $key => $value) {
                                    foreach ($value as $key2 => $value2) {
                                        echo "<option value='$value2'>";
                                    }
                                }
                            ?>
                            
                        </datalist>
                </div>
            </div> &nbsp;&nbsp;&nbsp;


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
            echo "<form method='POST' action='mapeamento.php' name='formPaginacao' >";
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
            //paginacao na tabela php
        ?><br/><br/>
        <table  class="table table-striped table-bordered table-hover table-responsive-lg">
        <tr><td>Matrícula</td><td>Colaborador</td><td>Data</td><td>Tipo</td><td>Motivo</td><td>Admissão</td>
        <td>Iniciativa</td><td>Setor</td><td>Cargo</td><td>Ciclo de Gente</td><td>Situação</td> </tr>
        <?php
            foreach ($resultado as $key => $value) {
                if($key>=$inicio && $key<=$fim){//paginação
                echo "<tr>";
                $data   = $value['data'];
                $nome   = $value['nome'];
                $mat    = $value['matricula'];
                foreach ($value as $key2 => $value2) {
                    switch ($key2) {
                        case 'data':
                        case 'admissao':
                            echo "<td>" . date("d/m/Y", strtotime($value2)) . "</td>";  
                            break;
                        case 'nome':
                            echo "<td><a href='mapeamento.php?consultar=$nome&mat=$mat&dataconsul=$data'>$value2</a></td>";  
                            break;
                        case 'tipo':
                            if ($value2=="P"){
                                echo "<td><button type='button' class='btn btn-success col-sm-12'>PEDIDO DE DEMISSÃO</button></td>";
                            } else if($value2=="S"){
                                echo "<td><button type='button' class='btn btn-warning col-sm-12'>DISPENSA SEM JUSTA CAUSA</button></td>";
                            } else if($value2=="E"){
                                echo "<td><button type='button' class='btn btn-warning col-sm-12'>ENCERRAMENTO DE ATIVIDADES</button></td>";
                            } else if($value2=="C"){
                                echo "<td><button type='button' class='btn btn-danger col-sm-12'>DISPENSA COM JUSTA CAUSA</button></td>";
                            }
                            break;
                        case 'iniciativa':
                            if ($value2=="C"){
                                echo "<td><button type='button' class='btn btn-success col-sm-12'>Colaborador</button></td>";
                            } else if($value2=="E"){
                                echo "<td><button type='button' class='btn btn-danger col-sm-12'>Empresa</button></td>";
                            }
                            break;
                        case 'ciclo':
                            switch ($value2) {
                                case 'P':
                                    echo "<td>PREPARAR</td>";
                                    break;
                                case 'M':
                                    echo "<td>MUITO BOM</td>";
                                    break;
                                case 'B':
                                    echo "<td>BOM</td>";
                                    break;
                                case 'N':
                                    echo "<td>NOVO</td>";
                                    break;
                                case 'R':
                                    echo "<td>RECUPERAR</td>";
                                    break;
                                case 'D':
                                    echo "<td>DESLIGAR</td>";
                                    break;
                            }
                            break;
                        case 'situacao':
                            echo $situacaoTela = ($value2=='D') ? "" : "" ;
                            if($value2=="D") {
                                echo "<td><button type='button' class='btn btn-danger col-sm-12'>Desligado</button></td>";
                            }else if ($value2=="M") {
                                echo "<td><button type='button' class='btn btn-warning col-sm-12'>Mapeado</button></td>";
                            }else if ($value2=="R") {
                                echo "<td><button type='button' class='btn btn-success col-sm-12'>Revertido</button></td>";
                            }
                            break;
                        case 'id':
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
<!--------------------------------tabela-------------------------------->
<?php else:?>
    <div class="texto">
        <ul class="formmenu">
            <li><a href="mapeamento.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
            <li><a href="mapeamento.php?find=true"><i class="fas fa-file-excel"></i> Relatório</a><br/><br/></li> 
        </ul><br/>
    <form method="POST" class="formmenu" name="formCadastro" action="mapeamento.php" ><br/>
        <fieldset id="user"><legend>Dados do Usuário</legend>
            <div class="form-group">
                <label for="consultar" class="col-sm-2 control-label">Nome.:</label>
                <div class="col-sm-6">
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