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
    $url->logarUser();//verificar logar
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }?>
<hgroup class="pagina">
<h3>Damata >> Financeito >> API Safra</h3>
<h1><i class="fas fa-file-code"></i> Área de API Safra & Sicoob<br/><br/></h1>
<a href="user.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(!(isset($_REQUEST['find'])) && ($_SESSION['type']=="ROOT" || $_SESSION['type']=="FINAN")):?>
<div class="texto">
        <h3> <i class="fas fa-file-invoice-dollar"></i> UpLoad Arquivo API BANCO SAFRA & SICOOB</h3><br/>
        <a href="financeiro.php?find=true"><i class="fas fa-list-ol"></i> Lista de Boletos Registrado na API</a><br/><br/>
        <a href="_apisafra/importBoletos.zip"><i class="fas fa-file-excel"></i> Download da Planilha Padrão</a><br/><br/>
        <br/>
        <hr class="linha" />
        <br/>
        <form name="formBoleto" class="formmenu" action="_apisafra/insert.php" 
            method="POST" enctype="multipart/form-data">
            <label for="arquivo" >Arquivo (*.xml) do Excel</label> 
            <input type="file" required id="arquivo"  name="arquivo" /><br/><br/>
            <input type="hidden" value="1" name="Funcao" readonly="readonly" />
            <input name="tEnviar" type="submit" class="enviar radius" value="Enviar"/>
            <i class="fas fa-arrow-circle-right"></i>
        </form>
        <br/>
        <hr class="linha" />
        <br/>
        <?php 
            require_once '_model/apiconfig.php';
            $api = new apiconfig($conexao);
            $resultApi = $api->consult();
            $selecao = ($resultApi) ? $resultApi['api'] : null;
        ?>
        <form name="formConfig" class="formmenu" action="_controller/controllerApiConfig.php" 
            method="POST" enctype="multipart/form-data">
            <legend>Configuração API's</legend>
            <input type="radio" id="Safra" name="api"  value="Safra" 
            <?php echo $opt1 = ($selecao=="Safra") ? "checked" : null ; ?> >
            <label for="Safra">Safra</label> &nbsp;
            <input type="radio" id="Sicoob" name="api" value="Sicoob" 
            <?php echo $opt1 = ($selecao=="Sicoob") ? "checked" : null ; ?> >
            <label for="Sicoob">Sicoob</label><br/><br/>
            <input type="hidden" value="1" name="Funcao" readonly="readonly" />
            <input name="tEnviar" type="submit" class="enviar radius" value="Salvar"/>
            <i class="fas fa-arrow-circle-right"></i>
        </form>
        
</div>
<?php elseif(isset($_REQUEST['find'])):?>
    <div class="texto">
        <h3><i class="fas fa-file-invoice-dollar"></i> Status de Boletos API</h3><br/>
        <a href="financeiro.php"> <i class="fas fa-paper-plane"></i> Registrar Novos Boletos na API</a><br/><br/>
        <?php if(isset($_REQUEST['data'])) { $data = $_REQUEST['data']; $dataRel = base64_encode($data);
                echo "<a href='_apisafra/relatorioAPI.php?rel=true&data=$dataRel'> "
                     . "<i class='fas fa-info-circle'></i> Gerar Relatório</a><br/><br/>";
            } else { $hoje = date('Y-m-d'); $hojeRel = base64_encode($hoje);
                echo "<a href='_apisafra/relatorioAPI.php?rel=true&data=$hojeRel'> "
                     . "<i class='fas fa-info-circle'></i> Gerar Relatório</a><br/><br/>";
            }
            require_once '_model/boleto.php';
            $boleto = new boleto($conexao);
            if (isset($_REQUEST['data'])) {
                $data = $url->converterData($data);
                $resultado = $boleto->consultBoletoData($data);
            } else {
                $resultado = $boleto->consultBoletoData($hoje);
            } 
        ?>
        <form name="formData"  class="formmenu" action="financeiro.php" method="POST" enctype="multipart/form-data">
            <input type="date" name="data" id="data" required autofocus 
            <?php if (isset($_REQUEST['data'])) { 
                $data = htmlspecialchars($_REQUEST['data']);
                echo "value='$data'";
            } else { 
                $hoje = date('Y-m-d');
                echo "value='$hoje'";
            }?> />
            <input type="hidden" value="true" name="find" readonly="readonly" />
            <input name="tEnviar" type="submit" class="enviar radius" value="Consultar"/>
            <i class="fas fa-arrow-circle-right"></i>
        </form><br/>
        <?php
            //paginacao na tabela php
            echo "<form method='POST' action='financeiro.php' name='formPaginacao' >";
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
            if (isset($_REQUEST['data'])) {
                $data = htmlspecialchars($_REQUEST['data']);
                echo " <input name='data' type='hidden' class='enviar radius' value='$data' /> Páginas >>";
            }
            for ($i=0; $i < $fracionar ; $i++) { 
                $w = $i+1;
                if ($i==$opcao) {
                    echo " <input name='opcao' type='submit' class='enviar radius btn-primary' value='$w' /> ";
                } else {
                    echo " <input name='opcao' type='submit' class='enviar radius' value='$w' /> ";
                }
            }
            echo "</form>";
            //paginacao na tabela php
        ?>
        <table  class="table table-striped table-bordered table-hover table-responsive-lg">
        <tr><td>NªDoc</td><td>NB</td><td>Nome</td><td>Valor</td><td>Vencimento</td>
        <td>Hora Registro</td><td>Status</td></tr>
        <?php
            $registrado = 0; $naoregistrado = 0;
            foreach ($resultado as $key => $value) {
                if($key>=$inicio && $key<=$fim){//paginação
                echo "<tr>";
                foreach ($value as $key2 => $value2) {
                    switch ($key2) {
                        case 'valor':
                            echo "<td>R$" . number_format($value2,2,',','.') . "</td>";
                            break;
                        case 'vencimento':
                            echo "<td>" . date("d/m/y", strtotime($value2)) . "</td>";  
                            break;
                        case 'data':
                            echo "<td>" . date("h:i a", strtotime("- 3 hours",strtotime($value2))) . "</td>";  
                            break;
                        case 'numDoc':
                            if (isset($_REQUEST['data'])) {
                                $num = $value['numDoc'];
                                $nome = $value['nome'];
                                echo "<td><a href='_apisafra/$num.json' download='$nome'>$value2</a></td>";
                            } else {
                                $num = base64_encode($value['numDoc']);
                                $nb = base64_encode($value['NB']);
                                echo "<td><a target='_blank' href='validaboleto.php?num=$num&nb=$nb'>$value2</a></td>";
                            }
                            break;
                        case 'NB':
                            echo "<td>$value2</td>";
                            break;
                        case 'nome':
                            echo "<td>$value2</td>";
                            break;
                        case 'codigoBarras':
                            if (trim($value2)<>"") {
                                echo "<td><img src='_imagens/verde.png' width='20' height='20' alt='verde'/></td>";
                            } else {
                                echo "<td><img src='_imagens/vermelho.png' width='20' height='20' alt='vermelho'/></td>";
                            }
                            break;
                    }
                }
                echo "</tr>";
                } //fim paginacao
                if (!trim($value['codigoBarras'])=="") {
                    $registrado++; 
                } else {
                    $naoregistrado++;
                }
            }
            $total = $registrado + $naoregistrado;
            
            if($total>0){
                $porcentagem = $registrado / $total;
                $porcentagem*=100;
                if ($porcentagem>0) {
                    $porcentagem = number_format($porcentagem,1,",",".");
                } else {
                    $porcentagem = 0;
                }
                echo '<br/><div class="container-fluid">';       
                echo '<div class="col-sm-3">';
                echo '<div class="alert alert-success" role="alert">';
                echo "Boletos Registrados = $registrado</div></div>"; 
                echo '<div class="col-sm-3">';
                echo $tela = ($naoregistrado>0) ? "<div class='alert alert-danger' role='alert'>Boletos Não Registrados = $naoregistrado</div></div>" : "</div>" ;
                echo '<div class="col-sm-3">';
                echo '<div class="alert alert-secondary" role="alert">';
                echo "Total = $total %Registrados = $porcentagem %</div></div></div>";
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