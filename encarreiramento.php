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
    require_once './_model/encarreiramento.php';
    $encarreiramento = new encarreiramento($conexao);
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Encarreiramento</h3>
<h1><i class="fas fa-exchange-alt"></i> Encarreiramento </h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="user.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['consultar']) || isset($_REQUEST['inserir'])):?>
<div class="texto">
    <ul class="formmenu">
        <li><a href="encarreiramento.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
        <li><a href="encarreiramento.php?find=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a><br/><br/></li> 
    </ul><br/><br/>
    <form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formplanobh" action="_controller/controllerEncarreiramento.php" onsubmit="return validaEncarreiramento();" >
    <fieldset id="usuario"><legend>
        Encarreiramento</legend>
    </fieldset>
    <fieldset id="encarreiramento"><legend class="small">Dados do Usuário</legend>
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
            $resultado = $encarreiramento->find($matricula);
    ?>
    <hr class="form col-sm-7 pull-left"/>
    <label for="data">Data .:</label><input type="date" name="data" 
           id="data" placeholder="data" required class="form-control col-sm-3"
           value="<?php echo $telaA1 = (count($resultado)>1) ? $resultado['data'] : date("Y-m-d") ; ?>"/><br/>
    
    <label for="cargo">Cargo.:</label>
    <select name="cargo" id="cargo" class="form-control col-sm-5">
        <?php 
            $cargo_banco = ($resultado) ? $resultado['cargo'] : null ;
            $cargos = $encarreiramento->getCargos();
            foreach ($cargos as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $selecao = ($cargo_banco==$value2) ? 'selected' : null ;
                    echo "<option $selecao > $value2 </option>";
                }
            }
        ?>
    </select><br/>

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
<!-- ---------------------------------- tabela ---------------------------------------------------------------- -->
<?php elseif(isset($_REQUEST['find'])):?>
    <div class="texto">
        <a href="encarreiramento.php"> <i class="fas fa-paper-plane"></i> Novo </a><br/><br/>
        <?php
            require_once '_model/encarreiramento.php';
            $encarreiramento = new encarreiramento($conexao);
            if (isset($_REQUEST['inicio'])) {
                $inicio = $url->converterData($_REQUEST['inicio']);
                $fim = $url->converterData($_REQUEST['fim']);
                $resultado = $encarreiramento->findFilter($inicio, $fim);
            } else {
                $inicio = date('Y-m') . "-1";
                $fim = date('Y') . "-12-1";
                $resultado = $encarreiramento->findFilter($inicio, $fim);
            } 
        ?>
        <form name="formData"  class="formmenu" action="encarreiramento.php" method="POST" enctype="multipart/form-data">
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
            echo "<form method='POST' action='encarreiramento.php' name='formPaginacao' >";
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
                            echo "<td><a href='encarreiramento.php?consultar=$nome&mat=$mat&dataconsul=$data'>$value2</a></td>";  
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
                            echo $situacaoTela = ($value2=='D') ? "<td><button type='button' class='btn btn-danger col-sm-12'>Desligado</button></td>" : "<td><button type='button' class='btn btn-success col-sm-12'>Revertido</button></td>" ;
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
<!-- ---------------------------------- tabela ---------------------------------------------------------------- -->
<?php else:?>
    <div class="texto">
        <ul class="formmenu">
            <li><a href="encarreiramento.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
            <li><a href="encarreiramento.php?find=true"><i class="fas fa-file-excel"></i> Relatório</a><br/><br/></li> 
        </ul><br/>
    <form method="POST" class="formmenu" name="formCadastro" action="encarreiramento.php" ><br/>
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