<?php ob_start(); //inicio da sessao 
session_start(); //inicio da sessao
require_once './_model/session.php';
$session = new session();
$session->logarLogin(); //verificar se esta logado 
?>
<link rel="stylesheet" href="_css/login.css">
<?php require_once './_model/urlDb.php';
$url = new UrlBD();
$url->inicia();
?>
<hgroup class="pagina">
    <img class="wave" src="_imagens/wave2.png">
    <div class="container">
        <div class="img">
            <img src="_imagens/beer.png">
        </div>
        <div class="login-content">
            <form action="login.php">
                <img src="_imagens/avatar.svg">
                <h2 class="title">Bem vindo ao DamataBI</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5><label for="Login">Login:</label>
                        </h5>
                        <input type="number" class="input" name="login" id="login">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5><label for="senha">Senha:</label></h5>
                        <input type="password" require name="senha" id="senha" class="input">
                    </div>
                </div>
                <a href="reset.php">esqueceu a senha?</a>
                <a href="index.php">Voltar a home</a>
                <input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="_bootstrap4.5.0/js/login.js"></script>
    </body>
    <?php
    if (isset($_REQUEST['login'])) {
        $matricula = trim(strip_tags(htmlspecialchars($_REQUEST['login'])));
        $senha = trim(strip_tags(htmlspecialchars($_REQUEST['senha'])));
        setcookie("email", htmlspecialchars($_REQUEST['login']), 9999);
        setcookie("senha", htmlspecialchars($_REQUEST['senha']), 9999);
        //incio do banco de dados
        require_once './_model/colaborador.php';
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
        try {
            $conexao = new \PDO($dsn, $username, $passwd); //cria conexão com banco de dadosX 
        } catch (\PDOException $ex) {
            die('Não foi possível estabelecer '
                . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
        }
        $colaborador = new colaborador($conexao);
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
        // fim de bando de dados
        if (
            $colaborador->getMatricula() == $matricula
            && (password_verify($senha, $colaborador->getSenha()))
        ) {
            $_SESSION['logado'] = TRUE;
            $_SESSION['ids'] = $colaborador->getMatricula();
            $usuario = explode(" ", $colaborador->getNome());
            $_SESSION['nome'] = ucfirst(strtolower($usuario[0]));
            setcookie('nomeColaborador', $colaborador->getNome());
            $_SESSION['user'] = $colaborador->getMatricula();
            $_SESSION['key'] = $colaborador->getSenha();
            $_SESSION['type'] = $colaborador->getTipo();
            //envio do email
            $nome = base64_encode($colaborador->getNome());
            $tipo = base64_encode($colaborador->getTipo());
            $matricula = base64_encode($matricula);
            header("location: email.php?nome=$nome&id=$matricula&tipo=$tipo");
            //header("location: user.php");
        } else {
            header("location: login.php?nlogin='true'");
        }
    } ?>