<?php
ob_start(); //inicio da sessao 
session_start(); //inicio da sessao
require_once './_model/urlDb.php';
$url = new UrlBD();
$url->inicia();
$dsn = $url->getDsn();
$username = $url->getUsername();
$passwd = $url->getPasswd();
$url->logarRootGente(); //verificar root
try {
    $conexao = new \PDO($dsn, $username, $passwd); //cria conexão com banco de dados 
} catch (\PDOException $ex) {
    die('Não foi possível estabelecer '
            . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
}
require_once './_model/colaborador.php';
$colaborador = new colaborador($conexao);
if (isset($_REQUEST['consultar'])) {
    $nome = htmlspecialchars($_REQUEST['consultar']);
    $resultado = $colaborador->findName($nome);
}
require_once './_model/passivo.php';
$passivo = new passivo($conexao);
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
    <h3>Damata >> Passivo</h3>
    <h1><i class="fas fa-balance-scale"></i> Passivo </h1><br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="powerbi.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if (isset($_REQUEST['update'])): ?>
    <div class="texto">
        <ul class="formmenu">
            <li><a href="passivo.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li>
        </ul><br/><br/>
        <form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formPassivo" 
              action="_controller/controllerPassivo.php" onsubmit="return validaCadastro();" >
            <fieldset id="usuario"><legend>
                    Passivo</legend>
            </fieldset>
            <fieldset id="user"><legend>Dados do Usuário</legend>
                <input type="hidden" name="Mat" id="Mat" 
                       size="15" maxlength="15" placeholder="Matricula" readonly='readonly' required
                       value="<?php echo $telaM = (count($resultado) > 0) ? $resultado['matricula'] : ""; ?>"/><br/>

                <label for="Nome">Nome .:</label><input type="text" name="Nome" id="Nome" 
                                                        size="30" maxlength="50" class="form-control col-sm-8" placeholder="Nome Completo" readonly='readonly'
                                                        value="<?php echo $telaN = (count($resultado) > 0) ? $resultado['nome'] : ""; ?>"/><br/>

                <label for="Setor">Setor . :</label><input type="text" name="Setor" 
                                                           id="Setor" size="30" maxlength="30" class="form-control col-sm-8" placeholder="Setor" readonly='readonly'
                                                           value="<?php echo $telaS = (count($resultado) > 0) ? $resultado['setor'] : ""; ?>" /><br/>

                <label for="Cargo">Cargo.:</label><input type="text" name="Cargo" 
                                                         id="Cargo" size="30" maxlength="30" class="form-control col-sm-8" placeholder="Cargo" readonly='readonly'
                                                         value="<?php echo $telaZ = (count($resultado) > 0) ? $resultado['cargo'] : ""; ?>" /><br/>
            <?php
                $matricula = ($resultado) ? $resultado['matricula'] : null;
                $id = (isset($_REQUEST['processo'])) ? $_REQUEST['processo'] : null;
                $resultado = $passivo->findPassivo($id);
            ?>
                <hr class="form col-sm-7 pull-left"/>
                <!-- campo forum  -->
                <label for="forum"> Fórum.: </label>
                <input type="text" class="form-control col-sm-8" name="forum" id="forum" 
                       required value="<?php
                                                         $telaforum = ($resultado) ? $resultado['forum'] : null;
                                                         echo $telaforum = (!is_null($telaforum)) ? $telaforum : "";
                                                         ?>" /><br/>
                <!-- campo Vara  -->
                <label for="vara"> Vara.: </label>
                <input type="text" class="form-control col-sm-8" name="vara" id="vara" 
                       required value="<?php
                                                         $tela_vara = ($resultado) ? $resultado['vara'] : null;
                                                         echo $tela_vara = (!is_null($tela_vara)) ? $tela_vara : "";
                                                         ?>" /><br/>
                <!-- campo Processo  -->
                <label for="processo"> Processo.: </label>
                <input type="text" class="form-control col-sm-8" name="processo" id="processo" 
                       required value="<?php
                                                         $tela_processo = ($resultado) ? $resultado['processo'] : null;
                                                         echo $tela_processo = (!is_null($tela_processo)) ? $tela_processo : "";
                                                         ?>" /><br/>
                <!-- campo Data processo  -->
                <label for="data"> Data Processo.:</label>
                <input type="date" name="data" class="form-control col-sm-3" id="data" placeholder="data" required value="<?php
            $tela_data_processo = ($resultado) ? $resultado['data'] : null;
            echo $tela_data_processo = (!is_null($tela_data_processo)) ? $tela_data_processo : "";
                                                         ?>" /><br/>
                <!-- campo Réu  -->
                <label for="reu"> Réu.:</label>
                <input type="text" class="form-control col-sm-8" name="reu" id="reu" required value=" <?php
            $tela_reu = ($resultado) ? $resultado['reu'] : null;
            echo $tela_reu = (!is_null($tela_reu)) ? $tela_reu : "";
            ?>" /><br/>
                <!-- campo Período de Trabalho Inicial  -->
                <label for="periodo_trabalho_ini"> Período de Trabalho Inicial.:</label>
                <input type="date" name="periodo_trabalho_ini" class="form-control col-sm-3"
                       id="periodo_trabalho_ini" placeholder="data" required 
                       value="<?php
            $tela_periodo_trabalhado_ini = ($resultado) ? $resultado['periodo_trabalho_ini'] : date('Y-m-d');
            echo $tela_periodo_trabalho_ini = (!is_null($tela_periodo_trabalhado_ini)) ? $tela_periodo_trabalhado_ini : "";
            ?>" /><br/>
                <!-- campo Período de Trabalho Fim  -->
                <label for="periodo_trabalho_fim"> Período de Trabalho Fim.:</label>
                <input type="date" name="periodo_trabalho_fim" class="form-control col-sm-3"
                       id="periodo_trabalho_fim" placeholder="data" required 
                       value="<?php
            $tela_periodo_trabalho_fim = ($resultado) ? $resultado['periodo_trabalho_fim'] : date('Y-m-d');
            echo $tela_periodo_trabalho_fim = (!is_null($tela_periodo_trabalho_fim)) ? $tela_periodo_trabalho_fim : "";
            ?>"/><br/>
                <!-- campo Advogado Reclamante  -->
                <label for="advogado_reclamante"> Advogado Reclamante.:</label>
                <input type="text" name="advogadoreclamante" class="form-control col-sm-8" id="advogadoreclamante" value="<?php
                        $tela_advogado_reclamante = ($resultado) ? $resultado['advogado_reclamante'] : null;
                        echo $tela_advogado_reclamante = (!is_null($tela_advogado_reclamante)) ? $tela_advogado_reclamante : "";
                    ?>"/><br/>
                <!-- campo Itens Reclamados  -->
                <label for="itens_reclamados"> Itens Reclamados.:</label>
                <textarea name="itens_reclamados" class="form-control col-sm-8" id="itens_reclamados" >
                       <?php
                            $tela_itens_reclamados = ($resultado) ? $resultado['itens_reclamados'] : null;
                            echo $tela_itens_reclamados = (!is_null($tela_itens_reclamados)) ? $tela_itens_reclamados : "";
                        ?> </textarea> <br/>
                <!-- campo  Valor Requerido  -->
                <label for="valor_requerido"> Valor Requerido.:</label>
                <input type="number" name="valor_requerido" class="form-control col-sm-8" id="valor_requerido" step="any"
                    required value="<?php
                                        $tela_valor_requerido = ($resultado) ? $resultado['valor_requerido'] : null;
                                        echo $tela_valor_requerido = (!is_null($tela_valor_requerido)) ? $tela_valor_requerido : "";
                                    ?>"/><br/>
                <!-- campo Abertura do Processo  -->
                <label for="abertura_processo"> Abertura do Processo.:</label>
                <input type="date" name="abertura_processo" class="form-control col-sm-3" id="abertura_processo" value="<?php
                            $tela_abertura_processo = ($resultado) ? $resultado ['abertura_processo'] : null;
                            echo $tela_processo = (!is_null($tela_abertura_processo)) ? $tela_abertura_processo : "";
                        ?>"/><br/>
                <!-- campo Contestação  -->
                <label for="contestacao"> Contestação.:</label>
                <input type="date" name="contestacao" class="form-control col-sm-3"
                       id="contestacao" placeholder="data" 
                       value="<?php
                            $tela_contestacao = ($resultado) ? $resultado['contestacao'] : null;
                            echo $tela_contestacao = (!is_null($tela_contestacao)) ? $tela_contestacao : "";
                        ?>"/><br/>
                <!-- campo Encerramento Processo  -->
                <label for="encerramento_processo"> Encerramento Processo.:</label>
                <input type="text" name="encerramento_processo" class="form-control col-sm-8" id="encerramento_processo" 
                       value=" <?php
                                $tela_encerramento_processo = ($resultado) ? $resultado['encerramento_processo'] : null;
                                echo $tela_encerramento_processo = (!is_null($tela_encerramento_processo)) ? $tela_encerramento_processo : "";
                            ?>"/><br/>
                <!-- campo Fase do Processo Reclamados  -->
                <label for="fase_processo_reclamados"> Fase do Processos Reclamados.:</label>
                <textarea name="fase_processo_reclamados" class="form-control col-sm-8" id="fase_processo_reclamados" >
                     <?php
                            $tela_fase_processo_reclamados = ($resultado) ? $resultado['fase_processo_reclamados'] : null;
                            echo $tela_fase_processo_reclamados = (!is_null($tela_fase_processo_reclamados)) ? $tela_fase_processo_reclamados : "";
                    ?> </textarea><br/>
                <!-- campo Reclamados  -->
                <label for="reclamados"> Reclamados.:</label>
                <input type="text" name="reclamados" class="form-control col-sm-8" id="reclamados" 
                        value="<?php
                            $tela_reclamados = ($resultado) ? $resultado['reclamados'] : null;
                            echo $tela_reclamados = (!is_null($tela_reclamados)) ? $tela_reclamados : "";
                        ?>"/><br/>
                <!-- campo Audiências  -->
                <label for="audiencias"> Audiências.:</label>
                <textarea name="audiencias" class="form-control col-sm-8" id="audiencias" >
                       <?php
                            $tela_audiencias = ($resultado) ? $resultado['audiencias'] : null;
                            echo $tela_audiencias = (!is_null($tela_audiencias)) ? $tela_audiencias : "";
                        ?> </textarea>     <br/>
                <!-- campo Preposto  -->
                <label for="preposto"> Preposto.:</label>
                <input type="text" name="preposto" class="form-control col-sm-8" id="preposto" 
                        value="<?php
                                $tela_preposto = ($resultado) ? $resultado['preposto'] : null;
                                echo $tela_preposto = (!is_null($tela_preposto)) ? $tela_preposto : "";
                        ?>"/><br/>
                <!-- campo Juiz do Trabalho  -->
                <label for="juiz_do_trabalho"> Juiz do Trabalho.:</label>
                <input type="text" name="juiz_do_trabalho" class="form-control col-sm-8" id="juiz_do_trabalho" 
                        value="<?php
                                $tela_juiz_do_trabalho = ($resultado) ? $resultado['juiz_do_trabalho'] : null;
                                echo $tela_juiz_do_trabalho = (!is_null($tela_juiz_do_trabalho)) ? $tela_juiz_do_trabalho : "";
                            ?>"/><br/>
                <!-- campo Testemunhas  -->
                <label for="testemunhas"> Testemunhas.:</label>
                <textarea name="testemunhas" class="form-control col-sm-8" id="testemunhas" >
                    <?php
                        $tela_testemunhas = ($resultado) ? $resultado['testemunhas'] : null;
                        echo $tela_testemunhas = (!is_null($tela_testemunhas)) ? $tela_testemunhas : "";
                    ?> </textarea><br/>
                <!-- campo Perícia  -->
                <label for="pericia"> Perícia.:</label>
                <textarea  name="pericia" class="form-control col-sm-8" id="pericia" >
                    <?php
                        $tela_pericia = ($resultado) ? $resultado['pericia'] : null;
                        echo $tela_pericia = (!is_null($tela_pericia)) ? $tela_pericia : "";
                    ?> </textarea> <br/>
                <!-- campo Depósito Recursal  -->
                <label for="deposito_recursal"> Depósito Recursal.:</label>
                <textarea name="deposito_recursal" class="form-control col-sm-8" id="deposito_recursal" >
                    <?php
                        $tela_deposito_recursal = ($resultado) ? $resultado['deposito_recursal'] : null;
                        echo $tela_deposito_recursal = (!is_null($tela_deposito_recursal)) ? $tela_deposito_recursal : "";
                    ?> </textarea> <br/>
                <!-- campo Valor Acordo  -->
                <label for="valor_acordo"> Valor Acordo.:</label>
                <textarea name="valor_acordo" class="form-control col-sm-8"
                 name="valor_acordo" class="form-control col-sm-8" id="valor_acordo" >
                    <?php
                        $tela_valor_acordo = ($resultado) ? $resultado['valor_acordo'] : null;
                        echo $tela_valor_acordo = (!is_null($tela_valor_acordo)) ? $tela_valor_acordo : "";
                    ?>  </textarea> <br/>
                <!-- campo Sentença  -->
                <label for="sentenca"> Sentença.:</label>
                <textarea class="form-control col-sm-8" name="sentenca"  id="sentenca"  >
                    <?php
                        $tela_sentenca = ($resultado) ? $resultado['sentenca'] : null;
                        echo $tela_sentenca = (!is_null($tela_sentenca)) ? $tela_sentenca : "";
                    ?>
                </textarea><br/>
                <!-- campo Recurso Ordinário  -->
                <label for="recurso_ordinario"> Recurso Ordinário.:</label>
                <textarea class="form-control col-sm-8" name="recurso_ordinario" id="recurso_ordinario" >
                    <?php
                        $tela_recurso_ordinario = ($resultado) ? $resultado['recurso_ordinario'] : null;
                        echo $tela_recurso_ordinario = (!is_null($tela_recurso_ordinario)) ? $tela_recurso_ordinario : "";
                    ?>
                </textarea> <br/>
                <!-- campo Recurso Revista  -->
                <label for="recurso_revista"> Recurso Revista.:</label>
                <textarea name="recurso_revista" class="form-control col-sm-8" id="recurso_revista" >
                       <?php
                            $tela_recurso_revista = ($resultado) ? $resultado['recurso_revista'] : null;
                            echo $tela_recurso_revista = (!is_null($tela_recurso_revista)) ? $tela_recurso_revista : "";
                        ?> </textarea><br/>
                <!-- campo Status  -->
                <label for="status"> Status.:</label>
                <select name="status" id="status" class="form-control col-sm-8">
                <?php $status = (!is_null($resultado)) ? $resultado['status'] : null; ?>
                    <option <?php echo $tela1 = ($status == "T") ? "selected" : ""; ?> >Transação/Acordo</option>
                    <option <?php echo $tela2 = ($status == "F") ? "selected" : ""; ?> >Finalizado</option>
                    <option <?php echo $tela3 = ($status == "E") ? "selected" : ""; ?> >Em Andamento</option>
                    <select><br/>
                        <hr class="form col-sm-7 pull-left"/>
                        <!-- campo Status do Processo  -->
                        <label for="status_processo"> Status do Processo.:</label>
                        <select name="status_processo" id="status_processo" class= "form-control col-sm-8">
                    <?php $status_processo = (!is_null($resultado)) ? $resultado['status_processo'] : null; ?>
                            <option <?php echo $tela1 = ($status_processo == "E") ? "selected" : ""; ?> >Encerrado</option>
                            <option <?php echo $tela2 = ($status_processo == "A") ? "selected" : ""; ?> >Ativo</option>
                        </select><br/>
                        <hr class="form col-sm-7 pull-left"/>
                        <!-- campo Pareto  -->
                        <label for="pareto"> Pareto.:</label>
                        <select name="pareto" id="pareto" class="form-control col-sm-8">
                    <?php $status_pareto = (!is_null($resultado)) ? $resultado['pareto'] : null; ?>
                            <option <?php echo $tela1 = ($status_pareto == "AN") ? "selected" : ""; ?> >Antecipação de Tutela</option>
                            <option <?php echo $tela2 = ($status_pareto == "DA") ? "selected" : ""; ?> >Danos Morais</option>
                            <option <?php echo $tela3 = ($status_pareto == "DO") ? "selected" : ""; ?> >Doença Ocupacional</option>
                            <option <?php echo $tela4 = ($status_pareto == "HO") ? "selected" : ""; ?> >Hora Extra + Nulidade Banco Horas</option>
                            <option <?php echo $tela5 = ($status_pareto == "NU") ? "selected" : ""; ?> >Nulidade Justa Causa</option>
                            <option <?php echo $tela6 = ($status_pareto == "PR") ? "selected" : ""; ?> >Produção Antecipada</option>
                            <option <?php echo $tela7 = ($status_pareto == "QU") ? "selected" : ""; ?> >Quantias Vultosas</option>
                            <option <?php echo $tela8 = ($status_pareto == "RE") ? "selected" : ""; ?> >Reversão Justa Causa</option>
                            <option <?php echo $tela9 = ($status_pareto == "TI") ? "selected" : ""; ?> >Ticket Refeição</option>
                        </select><br/>
                        <hr class="form col-sm-7 pull-left"/>

                        <br/><br/>
                        <input type="hidden" name="Funcao" value="<?php echo $telaFuncao = (!isset($_REQUEST['processo'])) ? 1 : 2; ?>" readonly="readonly" />
                        <?php 
                            if (!is_null($id)) {
                                echo "<input type='hidden' name='id_numero' value='$id' readonly='readonly' />";
                            }       
                         ?>
                        </fieldset>
                        <input name="Enviar" type="submit" class="enviar radius" value="Salvar"  /><i class="fas fa-arrow-circle-right"></i><br/><br/>
                        </fieldset> 
                        </form>
                        </div>
                        <script type="text/javascript">
                            var navegador = ObterBrowserUtilizado();
                            var tela = ObterTela();
                            var data = document.getElementById("Inicio").value;
                            if (navegador !== "Google Chrome" && tela && (data.substring(3, 2) !== "/")) {
                                var data = document.getElementById("dataconsul").value;
                                var datatxt = InverterData(data);
                                document.getElementById("dataconsul").value = datatxt;
                            }
                        </script>
<!-- ---------------------------------- tabela ---------------------------------------------------------------- -->
<?php elseif(isset($_REQUEST['find'])):?>
    <div class="texto">
        <ul class="formmenu">
        <li><a href="passivo.php" > <i class="fas fa-sign-out-alt"></i>Consultar Outro Colaborador</a></li>   
        <?php
            $nome = htmlspecialchars($_REQUEST['consultar']);
            $matricula = ($resultado) ? $resultado['matricula'] : null;
            $resultado = $passivo->find($matricula);
            echo "<li><a href='passivo.php?update=true&consultar=$nome'> <i class='fas fa-paper-plane'></i> Registrar Novo Processo -> Colaborador $nome</a></li>";
        ?>
        </ul><br/>
        <table  class="table table-striped table-bordered table-hover table-responsive-lg">
        <tr><td>Colaborador</td><td>Nº do Processo</td><td> Valor Requerido </td>
        <td>Abertura do Processo</td><td>Status Justiça</td><td>Status</td></tr>
        <?php
            foreach ($resultado as $key => $value) {
                echo "<tr>";
                foreach ($value as $key2 => $value2) {
                    $id = $value['Id_numero'];
                    switch ($key2) {
                        case 'matricula':
                            echo "<td><a href='passivo.php?consultar=$nome&mat=$value2&processo=$id&update=true'>$nome</a></td>";
                            break;
                        case 'processo':
                            echo "<td>$value2</td>";
                            break;
                        case 'valor_requerido':
                            echo "<td> R$ " . number_format($value2,2,",",".") . "</td>";
                            break;
                        case 'abertura_processo':
                            echo "<td>" . date("d/m/Y", strtotime($value2)) . "</td>";  
                            break;
                        case 'status':
                            if ($value2=="F"){
                                echo "<td><button type='button' class='btn btn-success col-sm-12'>Finalizado</button></td>";
                            } else if($value2=="T"){
                                echo "<td><button type='button' class='btn btn-warning col-sm-12'>Transação/Acordo</button></td>";
                            } else {
                                echo "<td><button type='button' class='btn btn-danger col-sm-12'>Em Andamento</button></td>";
                            }
                            break;
                        case 'status_processo':
                            if ($value2=="E"){
                                echo "<td><button type='button' class='btn btn-success col-sm-12'>Encerrado</button></td>";
                            } else {
                                echo "<td><button type='button' class='btn btn-warning col-sm-12'>Ativo</button></td>";
                            }
                            break;
                    }
                }
                echo "</tr>";
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
<?php else: ?>
    <div class="texto">
        <ul class="formmenu">
            <li><a href="passivo.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li> 
        </ul><br/>
        <form method="POST" class="formmenu" name="formCadastro" 
                action="passivo.php" onsubmit="return validaCadastro();" ><br/>
            <fieldset id="user"><legend>Dados do Usuário</legend>
                <label for="consultar">Nome.:</label><input type="search" name="consultar" id="consultar" 
                    required autofocus size="30" class="form-control col-sm-6" maxlength="60" placeholder="Nome"/><br/>
            </fieldset>
            <input name="find" type="hidden" class="enviar radius" value="find" />
            <div class="btndireita">
                <input name="Enviar" type="submit" class="enviar radius" value="Consultar" /> <i class="fas fa-arrow-circle-right"></i></div>
            <br/><br/>
            </fieldset> 
        </form>
    </div>
<?php endif; ?>
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