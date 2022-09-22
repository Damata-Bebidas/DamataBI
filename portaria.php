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
        $url->logarPort(); //verificar se esta logado 
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/colaborador.php';
    $colaborador = new colaborador($conexao);
    if (isset($_REQUEST['matricula'])) {
        $matricula = htmlspecialchars($_REQUEST['matricula']);
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
        $tipo = $resultado['tipo'];
    }
?>
<?php if(isset($_REQUEST['externo'])):?>
<hgroup class="pagina">
<h3>Treinamentos >> Controle de Externa</h3>
<h1><i class="fas fa-address-card"></i> Entrada Externo</h1><br/><br/>
    &nbsp;&nbsp; &nbsp;&nbsp;<a href="portaria.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
    <?php require_once './_model/visitas.php';
          $visita = new Visitas($conexao);
    if (isset($_REQUEST['cpf'])) {
        $cpf = htmlspecialchars($_REQUEST['cpf']);
        $consulta = $visita->consultarVisitas($cpf);
    }?>
    <ul class="formmenu">
        <li><a href="<?php //i = inserir
            echo $cpf = (isset($_REQUEST['cpf'])) ? "portaria.php?inserir=true&icpf=" . 
                    base64_encode(htmlspecialchars($_REQUEST['cpf'])) 
            . "&inome=" . base64_encode($consulta[0]['Nome'])  : ""; ?>" >
            <i class="fas fa-arrow-circle-right"></i>Lançar Visita</a></li>
        <li><a href="portaria.php"><i class="fas fa-car"></i> Colaboradores Internos</a></li>
        <li><a href="portaria.php?externo=true" ><i class="fas fa-id-card"></i> Visitantes Externos</a></li>
    </ul><br/>
    <form name="portaria" action="portaria.php" 
          class="formmenu" method="POST" enctype="multipart/form-data" onsubmit="return validaCadastro();">
        <label for="cpf"> CPF:</label> 
        <input type="number" id="cpf"  name="cpf" 
                value="<?php echo $tela = (isset($_REQUEST['cpf'])) ? htmlspecialchars($_REQUEST['cpf']) : "" ; ?>" />
        <input type="hidden" value="true" name="externo" readonly="readonly" />
        <input name="tEnviar" type="submit" class="enviar radius" value="Consultar"/>
    </form>
    <table class="table table-striped table-bordered table-hover table-responsive-lg">
            <tbody>
                <tr>
                    <td>CPF</td>
                    <td>Nome Completo</td>
                    <td>Área da Visita</td>
                    <td>Assistiu o Vídeo ?</td>
                    <td>Data</td>
                    <td>Placa Veículo</td>
                    <td>Equipamentos</td>
                </tr>
                <?php $data = 0;
                    if (isset($_REQUEST['cpf'])) {
                        foreach ($consulta as $key => $value) {
                            echo "<tr>";
                            $video = $value['video'];
                            foreach ($value as $key2 => $value2) {
                                if ($key2=="data") {
                                    echo "<td>" . date("d/m/y H:i:s", strtotime("- 3 hours",strtotime($value2))) . "</td>";
                                    if ($value2>$data && $video=="SIM") {
                                        $data = $value2;
                                    }
                                } else if($key2<>"ID"){
                                    echo "<td>" . $value2 . "</td>";
                                }
                            }
                            echo "</tr>";
                        }
                    }
                    $hoje = date("Y-m-d");
                    $ultimavisita = date("Y-m-d", strtotime($data));
                    $meses  = strtotime($hoje) - strtotime($ultimavisita); //86400 segundos é um dia & 30 dias 1 mes
                    $meses /= 86400; //segundos 
                    $meses /= 30; //meses
                    if ($meses<=6 && isset($_REQUEST['cpf'])) {
                        echo "<h5><span class='pago'>OK, Video de Segurança Dentro Prazo.</span></h5><br/>"; 
                    } else if(isset($_REQUEST['cpf'])){
                        echo "<h5><span class='pendente'> Assistir, Vídeo de Segurança Vencido!!!</span></h5><br/>"; 
                    }    
                ?>
            </tbody>
        </table>
</div>
<?php elseif(isset($_REQUEST['inserir'])):?>
<hgroup class="pagina">
<h3> Portaria >> Inserir Visita Externa</h3>
<h1><i class="fas fa-address-card"></i> Lançar Visita</h1><br/><br/>
    &nbsp;&nbsp; &nbsp;&nbsp;<a href="portaria.php?externo=true">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
    <form class="formmenu" name="portaria" action="_controller/controllerVisitas.php" method="POST" enctype="multipart/form-data">
        <label for="cpf">CPF . : .</label> <input type="number" class="form-control col-sm-4"
            value="<?php echo $telaCPF = (isset($_REQUEST['icpf'])) ? base64_decode(htmlspecialchars($_REQUEST['icpf'])) : "" ; ?>" id="cpf" name="cpf" /><br/>
        <label for="nome">Nome:</label> <input type="text" size="40" class="form-control col-sm-8"
            value="<?php echo $telaNome = (isset($_REQUEST['inome'])) ? base64_decode(htmlspecialchars($_REQUEST['inome'])) : "" ; ?>" id="nome" name="nome" /><br/>
        <label for="area">Área da Visita:</label>
            <select id="area" name="area" class="form-control col-sm-4">
                <option>ANA PAULA - DP</option>
                <option>BRUNO - FIN(CAIXA)</option>
                <option>DELCIO / SANYA - SEGURANÇA</option>
                <option>DEBORA - PROCESSO SELETIVO</option>
                <option>THAIS - OBZ</option>
                <option>MARCELA - FIN(PGTO)</option>
                <option>JOSE DOMINGOS - CONTABILIDADE</option>
                <option>RICARDO - DIRETOR FIN</option>
                <option>JULIO GOD</option>
                <option>JULIO FROTA</option>
                <option>FABIANO - LOG</option>
                <option>FARID - COMERCIAL</option>
                <option>VIRGÍNIA - GENTE</option>
                <option>NEY - DIRETORIA</option>
                <option>LUCIANA - FIN</option>
                <option>LIDIA - CADASTRO</option>
                <option>DUDU - MKT</option>
                <option>ALQUINDAR - GV</option>
                <option>THAIS - GVR</option>
            </select><br/><br/>
            <label for="video">Assistiu o Vídeo de Segurança:</label
            ><select id="video" name="video" class="form-control col-sm-4">
                <option>SIM</option>
                <option selected>NAO</option>
            </select><br/><br/>
            <label for="video">Placa do Veículo:</label>
            <input type="text" name="placa" size="10" maxlength="10" class="form-control col-sm-4" /><br/>
            <label for="video">Equipamentos:</label><br/>
            <textarea name="equipamentos" class="form-control col-sm-8" maxlength="100">
            </textarea>
            <hr class="form col-sm-7 pull-left"/>
        <input type="hidden" value="1" name="Funcao" readonly="readonly" />
        <input name="tEnviar" type="submit" class="enviar radius" value="Salvar"/><i class="fas fa-arrow-circle-right"></i>
        </form>
    </form>
</div>
<?php else:?>
<hgroup class="pagina">
<h3>Treinamentos >> Controle de Entrada</h3>
<h1><i class="fas fa-id-card"></i> Entrada Portaria</h1><br/><br/>
    &nbsp;&nbsp; &nbsp;&nbsp;<a href="user.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
    <!-- Aqui Entra Imagem -->
    <?php require_once './_model/classarquivos.php';
          $arquivo = new Arquivos($conexao);
    if (isset($_REQUEST['matricula'])
        && ($_SESSION['type']=="ROOT" || $_SESSION['type']=="GESTOR")) {
        $consulta = $arquivo->consultarArquivos($matricula);
        $imagem = (count($consulta)>0) ? $consulta[0]['arquivo'] : "" ;
        echo "<a target='_blank' href='upload.php?matup=" . base64_encode(htmlspecialchars($_REQUEST['matricula']))  .  "&nomeup=" 
        . base64_encode($nome) . "'><img class='fotoponto' src='_fotospontos/"
        . $imagem ."' alt='Falta Inserir Foto' align='top' /></a>";
    } elseif (isset($_REQUEST['matricula'])) {
        $consulta = $arquivo->consultarArquivos($matricula);
        $imagem = (count($consulta)>0) ? $consulta[0]['arquivo'] : "" ;
        echo "<img class='fotoponto' src='_fotospontos/"
        . $imagem . "' alt='Falta Inserir Foto' align='top' />";
    }
    ?>
    <ul class="formmenu">
        <li><a href="portaria.php"><i class="fas fa-car"></i> Colaboradores Internos</a></li>
        <li><a href="portaria.php?externo=true" ><i class="fas fa-id-card"></i> Visitantes Externos</a></li>
        <li><a href="_page/relatorioVisitas.php?rel=true" ><i class="fas fa-file-excel"></i> Relatório de Visitas Excel</a></li>
    </ul><br/>
    <!-- Aqui Entra Imagem -->
    <form name="portaria" action="portaria.php" onsubmit="return validaMatricula();"
          class="formmenu" method="POST" enctype="multipart/form-data" >
        <label for="matricula"> Matrícula:</label> 
        <input type="number" id="matricula"  name="matricula" 
                value="<?php echo $tela = (isset($_REQUEST['matricula'])) ? $matricula : "" ; ?>" />
        <input name="tEnviar" type="submit" class="enviar radius" value="Consultar"/>
    </form>
    <table class="table table-striped table-bordered table-hover table-responsive-lg">
            <tbody>
                <tr>
                    <td>Nome Colaborador</td>
                    <td>Setor</td>
                    <td>Cargo</td>
                    <td>Sexo</td>
                    <td>Status</td>
                </tr>
                <tr>
                    <td> <?php echo $tela1 = (isset($_REQUEST['matricula'])) ? $nome : "-----" ; ?> </td>
                    <td> <?php echo $tela2 = (isset($_REQUEST['matricula'])) ? $setor : "-----" ; ?> </td>
                    <td> <?php echo $tela3 = (isset($_REQUEST['matricula'])) ? $cargo : "-----" ; ?> </td>
                    <td> <?php echo $tela4 = (isset($_REQUEST['matricula'])) ? $sexo : "-----" ; ?> </td>
                    <td> <?php echo $tela5 = (isset($_REQUEST['matricula'])) ? $status : "-----" ; ?> </td>
                </tr>
            </tbody>
        </table>
</div>
<?php endif;?>
<?php require_once "./_page/footer.php"; 
    echo $tela = (isset($_REQUEST['success'])) ? "<script type='text/javascript' >portariaSucess();</script>" : "" ;
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