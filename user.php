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
<hgroup class="pagina">
<h3>Damata >> Usuário</h3>
<h1><i class="fas fa-user"></i> &nbsp;&nbsp;Portal Damata</h1><br/><br/>
    &nbsp;&nbsp;<a href="index.php">
 <i class="fas fa-arrow-circle-left"></i> Voltar</a>
</hgroup>
<?php if((!isset($_REQUEST['alterar'])) &&(!isset($_REQUEST['alterarSenha']))):?>
<div class="texto">
    <article class="servico bg-white radius">
     <div class="inner">
       <h4 class="center"><i class="fas fa-id-card"></i> Cadastro do Colaborador</h4>
       <ul class="formmenu consulta">
           <li>Nome: <br/><b><?php if(isset($_SESSION['user'])){ echo $colaborador->getNome();} ?></b></li>
           <li>Setor: <b><?php if(isset($_SESSION['user'])){ echo $colaborador->getSetor();} ?></b></li>
           <li>Cargo: <b><?php if(isset($_SESSION['user'])){ echo $colaborador->getCargo();} ?></b></li>
           <li>Nascimento: <b><?php if(isset($_SESSION['user'])){ echo date("d/m/Y", strtotime($colaborador->getNascimento()));} ?></b></li>
           <li>Admissão: <b><?php if(isset($_SESSION['user'])){ echo date("d/m/Y", strtotime($colaborador->getAdmissao()));} ?></b></li>
           <li><a href="user.php?alterarSenha=true" > <i class="fas fa-key"></i> Alterar Senha &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a></li>
           <li><a href="_controller/logout.php" > <i class="fas fa-sign-out-alt"></i> Logout(Sair)</a></li>
        </ul>
     </div>
    </article>
    <!--Service -->
    <article class="servico bg-white radius">
     <div class="inner">
       <h4 class="center"><i    accesskey="" class="fab fa-servicestack"></i> Services</h4>
        <ul class="formmenu consulta"> <?php if($resultado['matricula']>0)  ?>
            <?php
                switch ($colaborador->getTipo()) {
                    case 'GENTE':
                        require_once('_home/gente.php');
                        break;
                    case 'GESTOR':
                        require_once('_home/gestor.php');
                        break;
                    case 'ROOT':
                        require_once('_home/root.php');
                        break;
                    case 'FINAN':
                        require_once('_home/finan.php');
                        break;
                    case 'PORT':
                        require_once('_home/port.php');
                        break;
                    case 'LOG':
                        require_once('_home/log.php');
                        break;
                }
            ?>
            <li><a href="check.php" > <i class="fas fa-umbrella-beach"></i> Programar Minhas Férias</a></li>
            <li><a href="check.php" > <i class="fas fa-check"></i> Responder Check de Retenção</a></li>
            <li><a href="checkreacao.php" > <i class="fas fa-retweet"></i> Responder Check de Reação</a></li>
        </ul>
    </div>
    </article> 
    <!--Gente -->
            <?php
                if ($colaborador->getTipo()=="GENTE" || $colaborador->getTipo()=="ROOT") {
                    require_once '_home/servicepeople.php';
                }
            ?>
</div>
<?php elseif(isset($_REQUEST['alterarSenha'])):?>
    <div id="texto">
    <article class="servico bg-white radius">
    <div class="inner">
        <h4 ><i class="fas fa-id-card"></i> Cadastro do Colaborador:</h4><br/>
        <ul class="formmenu consulta">
            <li><b><?php if(isset($_SESSION['user'])){ echo $colaborador->getNome();} ?></b></li><br/>
            <li>Matrícula: <b><?php if(isset($_SESSION['user'])){ echo $colaborador->getMatricula();} ?></b></li><br/>
            <li>Cargo: <b><?php if(isset($_SESSION['user'])){ echo $colaborador->getCargo();} ?></b></li><br/>
        </ul>
    </div>
    </article>
    <article class="servico bg-white radius">
    <div class="inner">
    <form method="POST" class="formmenu" action="_controller/controllerColaborador.php" name="formAlterarSenha" onsubmit="return validarAlterarSenha();" >  
        <fieldset id="senha">
                <p><label for="Senha"> Nova Senha:</label><input type="password" class="form-control col-sm-12" name="Senha" id="Senha" size="8" maxlength="20" placeholder="8 dígitos" />
                <label for="Senha2"> Confirmar Senha:</label><input type="password" class="form-control col-sm-12" name="Senha2" id="Senha2" size="8" maxlength="20" placeholder="8 dígitos" /></p>
        </fieldset>
        <input type="hidden" value="4" name="Funcao" readonly="readonly" />
        <input type="hidden" <?php if(isset($_SESSION['user'])){ echo "value='" . $_SESSION['user'] . "'";} ?> name="Mat" readonly="readonly" />
        <input name="tEnviar" type="submit" class="enviar radius" value="Enviar"/><i class="fas fa-arrow-circle-right"></i>
    </form>
    </div>
    </article>
</div>
<?php endif;?>
<?php require_once "./_page/footer.php"; ?>
<?php 
    echo $tela = (isset($_REQUEST['alterado'])) ? "<script type='text/javascript' >alterado();</script>" : "";
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