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
    $url->logarUser();
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }?>
<hgroup class="pagina">
<h3>Damata >> Financeito >> API Safra >> Validar Boleto</h3>
<h1><i class="fas fa-file-code"></i> &nbsp;&nbsp;Área de API Safra<br/><br/></h1>
<a href="financeiro.php?find=true">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['num']) && isset($_REQUEST['nb'])):?>
    <div class="texto">
        <h3><i class="fas fa-file-invoice-dollar"></i> Status de Boleto API BANCO SAFRA</h3><br/>
        <!-- Colocar uma tabela aqui para fechar a API -->
        <?php 
            require_once '_model/boleto.php';
            $boleto = new boleto($conexao);
            $resultado = $boleto->find(base64_decode(htmlspecialchars($_REQUEST['num'])));
            require_once './_apisafra/safra.php';
            $safra = new safra();
            $safra->setNumero(base64_decode(htmlspecialchars($_REQUEST['num'])));
            $safra->setCliente(base64_decode(htmlspecialchars($_REQUEST['nb'])));
            $consulta = $safra->find();
        ?>
        <table border="0" class="table table-striped table-bordered table-hover table-responsive-lg col-md-8" >
                <thead>
                    <tr>
                        <td>Item</td>
                        <td>Consulta</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>NumDoc</td>
                        <td><?php echo $consulta['data']['documento']['numero']; ?></td>
                    </tr>
                    <tr>
                        <td>NB</td>
                        <td><?php echo $consulta['data']['documento']['numeroCliente']; ?></td>
                    </tr>
                    <tr>
                        <td>Nome</td>
                        <td><?php echo $resultado['nome']; ?></td>
                    </tr>
                    <tr>
                        <td>Valor</td>
                        <td><?php echo "R$ " . number_format($resultado['valor'],2,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td>Vencimento</td>
                        <td><?php echo date("d/m/y",strtotime($resultado['vencimento'])); ?></td>
                    </tr>
                    <tr>
                        <td>Data Registro</td>
                        <td><?php echo date("d/m/y h:i a",strtotime("- 3 hours",strtotime($resultado['data']))); ?></td>
                    </tr>
                    <tr>
                        <td>Danfe</td>
                        <td><?php echo $resultado['danfe']; ?></td>
                    </tr>
                    <tr>
                        <td>Pj_pf</td>
                        <td><?php echo $resultado['pj_pf']; ?></td>
                    </tr>
                    <tr>
                        <td>CPF/CNPJ</td>
                        <td><?php echo $resultado['cpf']; ?></td>
                    </tr>
                    <tr>
                        <td>End</td>
                        <td><?php echo $resultado['end']; ?></td>
                    </tr>
                    <tr>
                        <td>Bairro</td>
                        <td><?php echo $resultado['bairro']; ?></td>
                    </tr>
                    <tr>
                        <td>Cidade</td>
                        <td><?php echo $resultado['cidade']; ?></td>
                    </tr>
                    <tr>
                        <td>Uf</td>
                        <td><?php echo $resultado['uf']; ?></td>
                    </tr>
                    <tr>
                        <td>Cep</td>
                        <td><?php echo $resultado['cep']; ?></td>
                    </tr>
                    <tr>
                        <td>IndicadorBaseCentral</td>
                        <td><?php echo $resultado['indicadorBaseCentral']; ?></td>
                    </tr>
                    <tr>
                        <td>Codigo Barras</td>
                        <td><?php echo $consulta['data']['documento']['codigoBarras']; ?></td>
                    </tr>
                </tbody>
            </table>
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