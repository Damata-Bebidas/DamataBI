<?php session_start();//inicio da sessao ?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<?php if(!isset($_REQUEST['tNome'])):?> 
<hgroup class="pagina">
<h3>Damata >> Suporte</h3>
<h1><i class="fas fa-at"></i>Formulário de Suporte<br/><br/>
<a href="login.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
    <legend>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         Faça contato com Suporte do Portal</legend>
</h1>
</hgroup>
<div class="texto">
<form method="post" id="fContato" name="formContato" action="suporte.php">
    <fieldset id="usuario"><legend>Identificação do Usuário</legend>
       <label for="cNome">Nome:</label><input type="text" class="form-control col-sm-6" name="tNome" id="cNome" size="40" maxlength="40" placeholder="Nome Completo"/><br/>
       <label for="cMail">E-mail:</label><input type="email" name="tMail" class="form-control col-sm-6" id="cMail" size="40" maxlength="40" placeholder="exemplo@damataleo.com.br"/>
    </fieldset>
<fieldset id="assunto"><legend>Assunto:</legend>
    <label for="cAssunto">Assunto:</label><input class="form-control col-sm-6"
            type="text" name="tAssunto" id="cAssunto" size="40" maxlength="40" placeholder="Assunto"/>
    <br/>
    <fieldset id="assunto"><legend>Suporte sobre:</legend>
        <div class="radio">
        <input type="radio" name="contato" id="portal" value="Suporte Portal Damata.Site" />
        <label for="portal" >Problemas no Portal</label> <br/>
        <input type="radio" name="contato" id="excel" value="Suporte Excel" />
        <label for="excel" >Planilhas de Excel <font size="1"><b>Excel VBA</b></font></label><br/>
        <input type="radio" name="contato" id="checklist" value="Check List Android"/>
        <label for="checklist">Check List no Celular</label><br/>
        <input type="radio" name="contato" id="outros" value="Outros"/>
        <label for="outros">Outros Assuntos</label>
        </div>
    </fieldset>
</fieldset>
<fieldset id="mensagem"><legend>Mensagem do Usuário</legend>
    <label for="cMsg">Mensagem:</label><br/>
        <textarea name="tMsg" id="cMsg" class="form-control col-sm-6" placeholder="Deixe aqui sua mensagem">
        </textarea></fieldset>
<h2><input name="tEnviar" type="submit" class="enviar radius" value="Enviar"/><i class="fas fa-arrow-circle-right"></i></h2>
</form>
</div>
<?php else:?>
<div class="texto">
<h2>Suporte</h2>
<h4>Mensagem Enviada com Sucesso!!!</h4>
</div>
<?php 
    $conteudo = "Atendimento On-Line Damata Bebidas\n\n";
    $conteudo.= "Nome: ".trim(strip_tags(htmlspecialchars($_REQUEST['tNome'])))."\n";
    $conteudo.= "E-mail: ".trim(strip_tags(htmlspecialchars($_REQUEST['tMail'])))."\n";
    $conteudo.= "Tel./Cel.: ".trim(strip_tags(htmlspecialchars($_REQUEST['tTel'])))."\n";
    $conteudo.= "Assunto: ".trim(strip_tags(htmlspecialchars($_REQUEST['tAssunto'])))."\n";
    $conteudo.= "Contato: ".trim(strip_tags(htmlspecialchars($_REQUEST['contato'])))."\n";
    $conteudo.= "Mensagem: ".trim(strip_tags(htmlspecialchars($_REQUEST['tMsg'])))."\n";
    $email = trim(strip_tags(htmlspecialchars($_REQUEST['tMail'])));
    $to = "welington_marquezini88@live.com";
    $assunto = "Atendimento On-Line Damata Bebidas";
    $mensagem = $conteudo;
    $header = "from:pontobi@damata.site";
    mail($to,$assunto,$mensagem,$header);
    mail($email,$assunto,$mensagem,$header);
    //mail("contatoenterprise@hotmail.com",$assunto,$mensagem,$header);
    //@ faz ignorar o email caso de erro
?>
<a href="index.php" >Voltar</a>
<?php header("Refresh: 10, index.php");?>
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