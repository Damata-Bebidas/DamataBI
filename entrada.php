<?php
ob_start(); 
session_start(); 
require_once './_model/urlDb.php';
$url = new UrlBD();
$url->inicia();
$dsn = $url->getDsn();
$username = $url->getUsername();
$passwd = $url->getPasswd();
$url->logarRootGente();
try {
    $conexao = new \PDO($dsn, $username, $passwd);
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
require_once './_model/entrada.php';
$entrada = new entrada($conexao);
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
    <h3>Damata >> Entrada</h3>
    <h1><i class="fas fa-address-card"></i> Entrada da Jornada </h1><br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="login.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if (isset($_REQUEST['consultar']) || isset($_REQUEST['inserir'])): ?>

    <div class="texto">
        <ul class="formmenu">
            <li><a href="entrada.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li>
        </ul><br/><br/>
        <form method="POST" class="formmenu col-sm-8 col-sm-offset-4" name="formEntrada" 
              action="_controller/controllerEntrada.php" onsubmit="return validaEntrada();" >
            <fieldset id="usuario"><legend>
                    Passivo</legend>
            </fieldset>
            <fieldset id="user"><legend>Dados do Usuário</legend>
                <input type="hidden" name="Mat" id="Mat" 
                       size="15" maxlength="15" placeholder="Matricula" readonly='readonly'
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
                $mat = ($resultado) ? $resultado['matricula'] : null;
                $resultado = $entrada->find($mat);
            ?>
            <hr class="form col-sm-7 pull-left"/>
            <label for="forum"> Hora de Entrada Padrão.: </label>
            <input type="time" class="form-control col-sm-2" name="hora" id="hora" 
                required  value="<?php
                                        $entradaPadrao = ($resultado) ? $resultado['hora'] : null;
                                        echo $telaEntrada = (!is_null($entradaPadrao)) ? $entradaPadrao : "";
                                    ?>" /><br/>    
            <hr class="form col-sm-7 pull-left"/>
            <br/>
            </fieldset>
            <input name="Enviar" type="submit" class="enviar radius" value="Salvar"  /><i class="fas fa-arrow-circle-right"></i><br/><br/>
            </fieldset> 
        </form>
    </div>
<?php else: ?>
    <div class="texto">
        <ul class="formmenu">
            <li><a href="entrada.php" > <i class="fas fa-sign-out-alt"></i>Consultar Colaborador</a></li>  
        </ul><br/>
        <form method="POST" class="formmenu" name="formCadastro" 
                action="entrada.php" onsubmit="return validaCadastro();" ><br/>
            <fieldset id="user"><legend>Dados do Usuário</legend>
                <label for="consultar">Nome.:</label><input type="search" name="consultar" id="consultar" 
                    required autofocus size="30" class="form-control col-sm-6" maxlength="60" placeholder="Nome"/><br/>
            </fieldset>
            <input name="inserir" type="hidden" class="enviar radius" value="inserir" />
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