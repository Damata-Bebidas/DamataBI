<?php ob_start();//inicio da sessao 
      session_start();//inicio da sessao
      require_once './_model/session.php';
      $session = new session();
      $session->logarUser(); //verificar se esta logado 
      require_once "./_page/header.php"; 
      require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Power BI</h3>
<h1><i class="fas fa-chart-pie"></i> Power BI Logística<br/><br/></h1>
<a href="user.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if($_SESSION['type']=="ROOT" || $_SESSION['type']=="LOG" || $_SESSION['type']=="GESTOR"):?>
<div class="texto">
        <h3> <i class="fas fa-file-powerpoint"></i> Power BI Logística</h3><br/>
    <ul >
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiYzg4NDQxMWEtNjkxYS00YTdhLThmZGMtZTRlY2VmOGQ1ZTgwIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9&pageName=ReportSectiona28a4cc158878699be2d" 
                     target="_blank">Power BI DTO's Entrega</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiYWFlNjdlZmYtMjJmYy00ZWQ4LWIyNDItYzczMzg3MmE4ZjJiIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9&pageName=ReportSection83466910749998c75e96" 
            target="_blank">Power BI Pesquisa NPS</a> </li>
    </ul>
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