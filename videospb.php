<?php session_start();//inicio da sessao ?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; 
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
}?>
<hgroup class="pagina">
<h3>Damata >> Institucional</h3>
<h1><i class="fas fa-thumbtack"></i> &nbsp;&nbsp; Institucional</h1>
</hgroup>
<div class="texto">
<a href="user.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
<div id="tv-radio">
    <h3>Como Atualizar a Remuneração</h3>	
    <video id="filme" controls="controls">
        <source src="_media/AtualizarRemuneracao.mov" type="video/mp4"/>
            Desculpe,mas não foi possível carregar o Vídeo.
    </video>
</div>
<div id="tv-radio">
    <h3>Como Atualizar o Remuneração Tendência</h3>	
    <video id="filme" controls="controls">
        <source src="_media/AtualizarRemuneracaoII.mov" type="video/mp4"/>
            Desculpe,mas não foi possível carregar o Vídeo.
    </video>
</div>
<div id="tv-radio">
    <h3>Como Atualizar o Banco de Horas</h3>	
    <video id="filme" controls="controls">
    <source src="_media/AtualizarBH.mov" type="video/mp4"/>
        Desculpe,mas não foi possível carregar o Vídeo.
</video>
</div>
<div id="tv-radio">
    <h3>Como Atualizar o QLP</h3>	
    <video id="filme" controls="controls">
    <source src="_media/AtualizarQLP.mov" type="video/mp4"/>
        Desculpe,mas não foi possível carregar o Vídeo.
</video>
</div>
</div>
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