<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
        $url->logarRootGente();//verificar root
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/treinamento.php';
    $treinamento = new treinamento($conexao);
    if (isset($_REQUEST['consultar'])) {
        $nome = htmlspecialchars($_REQUEST['consultar']);
        $resultado = $treinamento->findName($nome);
    } 
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Lent >>  Treinamentos >> Aplicablidade </h3>
<h1><i class="fas fa-address-card"></i>Aplicablidade</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="user.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if(isset($_REQUEST['consultar']) || isset($_REQUEST['inserir'])):?>
<div class="texto">
<ul class="formmenu">
    <li><a href="aplic.php" > <i class='fas fa-address-book'></i> Aplicabilidade por Treinamento</a></li>
    <li><a href="_page/relatorioAplic.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a><br/><br/></li> 
</ul><br/>
<?php 
    $id = $resultado['Treinamento'];
    $matriz = array('ADMINISTRATIVO','APOIO LOGÍSTICO',
    'DISTRIBUIÇÃO URBANA','PUXADA','VENDAS'); $k = 0;
    echo "<form method='POST' action='_controller/controllerAplicabilidade.php' name='formTreinamentos' >";
    echo "<a href='aplic.php?consultar=$id'> Limpar Área (Todos Colaboradores)</a><br/><br/>";
    foreach ($matriz as $key => $value) {
        $k++; $n = $matriz[$key];
        echo "<input type='hidden' value='$id' name='tr$k' readonly='readonly' />
            <input type='hidden' value='$k' name='aplic$k' readonly='readonly' />
            <input name='consultar' type='submit' class='enviar radius' value='$n'/>"; 
    }echo "</form>";

    if (isset($_REQUEST['all'])) {
        if (isset($_REQUEST['aplic'])) {
            $a = htmlspecialchars($_REQUEST['aplic']);
            echo "<a href='aplic.php?consultar=$id&clean=true&aplic=$a'><i class='fas fa-reply-all'></i>Desmarcar Todos</a><br/><br/>";
        } else {
            echo "<a href='aplic.php?consultar=$id&clean=true'><i class='fas fa-reply-all'></i>Desmarcar Todos</a><br/><br/>";
        }
    } else {
        if (isset($_REQUEST['aplic'])) {
            $a = htmlspecialchars($_REQUEST['aplic']);    
            echo "<a href='aplic.php?consultar=$id&all=true&aplic=$a'><i class='fas fa-reply-all'></i>Marcar Todos</a><br/><br/>";
        } else {
            echo "<a href='aplic.php?consultar=$id&all=true'><i class='fas fa-reply-all'></i>Marcar Todos</a><br/><br/>";
        }
    }
?> 
<form method="POST" class="formmenu" name="formCadastro" 
        action="_controller/controllerAplicabilidade.php" onsubmit="return validaCadastro();" >
    <fieldset id="treinamento"><legend>Dados do Treinamento</legend>
    <input type="hidden" name="id_tr" id="id_tr" 
      size="15" maxlength="15" placeholder="ID Treinamento" 
      readonly='readonly' value="<?php echo $tela = (count($resultado)>0) ? $resultado['id_tr'] : "" ; ?>"/>
    <label for="nome">Treinamento.:</label><input type="text" name="nomeTreinamento" id="nomeTreinamento" 
      size="50" maxlength="50" placeholder="Nome treinamento" readonly='readonly' class="form-control col-sm-7"
      value="<?php echo $tela1 = (count($resultado)>0) ? $resultado['Treinamento'] : "" ; ?>"/><br/><br/>
    <input type="hidden" name="Funcao" 
            value="<?php echo $tela2 = (isset($_REQUEST['inserir'])) ? 1 : 2 ; ?>" readonly="readonly" />
</fieldset>
<table class="table table-striped table-bordered table-hover table-responsive">
    <thead>
        <tr>
            <td>Status</td>
            <td>Nome </td>
            <td>Setor</td>
            <td>Cargo</td>
            <td>Status E-gente</td>
        </tr>
    </thead>
    <tbody>
<?php
    require_once './_model/aplicabilidade.php';
    $aplicabilidade = new aplicabilidade($conexao);
    if(isset($_REQUEST['aplic'])) {
        $area = $matriz[htmlspecialchars($_REQUEST['aplic'])-1];
        $resultadoColaboradores = $aplicabilidade->findColaboradoresArea($area);
    } else {
        $resultadoColaboradores = $aplicabilidade->findColaboradores();
    }
    $treinamento = $resultado['id_tr'];
    $qtdColaboradores=0;
    foreach ($resultadoColaboradores as $key => $value) {
        echo "<tr>";
        foreach ($value as $key2 => $value2) {
            if ($key2=="matricula") {
                $chave = $value2 .  "_" . $treinamento;
                $statusAplic = $aplicabilidade->findAplic($chave);
                if (isset($_REQUEST['all'])) {
                    echo "<td><input type='checkbox' name='status$key' value='ON' checked='checked' /></td>";
                    $qtdColaboradores++;
                } elseif (isset($_REQUEST['clean'])) {
                    echo "<td><input type='checkbox' name='status$key' value='ON' /></td>";
                } else if ($statusAplic<>"") {
                    echo "<td><input type='checkbox' name='status$key' value='ON' checked='checked' /></td>";
                    $qtdColaboradores++;
                } else {
                    echo "<td><input type='checkbox' name='status$key' value='ON' /></td>";
                }
                echo "<input name='matricula$key' type='hidden' value='$value2' />";
            }else {
                echo "<td>$value2</td>";
            }
        }
        echo "</tr>";
    }
    if (isset($_REQUEST['consultar'])) {
        echo "<h4>$qtdColaboradores Colaboradores com Aplicabilidade</h4>";
    }
?>
    </tbody>
</table><br/><br/>
<input name='Total' type='hidden' value='<?php echo count($resultadoColaboradores); ?>' />
<input name="Enviar" type="submit" class="enviar radius" value="Salvar" 
       onsubmit="return validarSenha();" /><i class="fas fa-arrow-circle-right"></i>
</fieldset> 
</form>
</div>
<?php elseif(isset($_REQUEST['colaborador'])):?>
    <div class="texto">
        <ul class="formmenu"> 
            <li><a href="aplic.php" > <i class='fas fa-address-book'></i> Aplicabilidade por Treinamento</a></li>
            <li><a href="_page/relatorioAplic.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a><br/><br/></li> 
        </ul><br/>  
    <form method="POST" class="formmenu" name="formCadastro" 
        action="#" onsubmit="return validaCadastro();" ><br/>
        <fieldset id="treinamento"><legend>Dados do Colaborador:</legend>
        <label for="nome">Nome Colaborador.:</label><input type="text" name="nome" id="nome" class="form-control col-sm-6"
            autofocus required size="40" maxlength="50" placeholder="Nome de Colaborador"
            value="<?php echo $tela = (isset($_REQUEST['nome'])) ?  $_REQUEST['nome'] : "" ; ?>" /><br/>
        </fieldset>
    <input name="colaborador" type="hidden" value="true" /> 
    <input name="Enviar" type="submit" class="enviar radius" value="Consultar" 
       onsubmit="return validarSenha();" /><i class="fas fa-arrow-circle-right"></i>
    <br/>
    <br/>
    <table class="table table-striped table-bordered table-hover table-responsive-lg">
    <thead>
        <tr>
            <td>Treinamento</td>
            <td>Cargos </td>
            <td>Frequência</td>
            <td>Carga</td>
            <td>Área</td>
        </tr>
    </thead>
    <tbody>
<?php
    $matriz = array('SEGURANÇA','GENTE','GESTÃO','COMERCIAL','FINANCEIRO','ENTREGA',
    'ARMAZÉM','PLANEJAMENTO','FROTA','NÍVEL DE SERVIÇO');
    require_once './_model/aplicabilidade.php';
    $aplicabilidade = new aplicabilidade($conexao);
    if (isset($_REQUEST['nome'])) {
        $nome = htmlspecialchars($_REQUEST['nome']);
        $resultadoColaborador = $aplicabilidade->findColaborador($nome);
        $qtdTreinamentos = count($resultadoColaborador);
        foreach ($resultadoColaborador as $key => $value) {
            echo "<tr>";
            foreach ($value as $key2 => $value2) {
                if ($key2=='id_area') {
                    echo "<td>" .  $matriz[$value2-1] . "</td>";
                } else {
                    echo "<td>$value2</td>";
                }
            }
            echo "</tr>";
        }
    }
    if (isset($_REQUEST['nome'])) {
        echo "<h4 class='enviar radius' >$qtdTreinamentos Treinamentos para esse Colaborador</h4>";
    }
    
?>
</tbody>
</table>
</fieldset> 
</form>
</div>
<?php else:?>
    <div class="texto">
        <ul class="formmenu"> 
            <li><a href="aplic.php?colaborador=true" ><i class='fas fa-address-book'></i>Aplicabilidade por Colaborador</a></li>
            <li><a href="_page/relatorioAplic.php?rel=true"><i class="fas fa-file-excel"></i> Gerar Relatório</a><br/><br/></li> 
        </ul><br/>  
    <form method="POST" class="formmenu" name="formCadastro" 
        action="aplic.php" onsubmit="return validaCadastro();" ><br/>
        
        <fieldset id="treinamento"><legend>Dados do Treinamento:</legend>
        <label for="consultar">Treinamentos.:</label><input type="text" name="consultar" id="consultar"
            required autofocus size="40" maxlength="40" class="form-control col-sm-7" placeholder="Treinamento"/><br/>
        </fieldset>
    <div class="btndireita">
        <input name="Enviar" type="submit" class="enviar radius" value="Consultar" /> <i class="fas fa-arrow-circle-right"></i>
    </div>    
    <br/>
    <br/>
</fieldset> 
</form>
</div>
<?php endif;?>
<?php require_once "./_page/footer.php"; ?>
<!-- Auto complete -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
            $(function(){
                $("#consultar").autocomplete({
                    source: '_page/proc_pesq_treinamentos.php'
                });
            });
            $(function(){
                $("#nome").autocomplete({
                    source: '_page/proc_pesq_nome.php'
                });
            });
</script>