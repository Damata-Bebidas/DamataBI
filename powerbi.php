<?php ob_start();//inicio da sessao 
      session_start();//inicio da sessao
      require_once './_model/session.php';
      $session = new session();
      $session->logarUser(); //verificar se esta logado 
      require_once "./_page/header.php"; 
      require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Power BI</h3>
<h1><i class="fas fa-chart-pie"></i> Power BI <br/> People Analytics<br/><br/></h1>
<a href="user.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<?php if($_SESSION['type']=="ROOT" || $_SESSION['type']=="GENTE"):?>
<div class="texto">
<article class="servico bg-white radius">
    <div class="inner">
    <h4 class="center"><i class="fas fa-file-powerpoint"></i> Power BI Gente</h4><br/>
    <ol >
    <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiYzhjZWEzZmQtOWFhOS00MzJjLWJmNTUtYzNlZWQyNjRiNzg2IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                 target="_blank">Jornada Completa</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiMjgwY2MzNzktZmEyYi00YTVhLWIyYmMtYzMyZTQ3ODI1NGM0IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                 target="_blank">Banco de Horas</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiM2VlYjdkZjQtMzYzNS00YWRmLTgzMjUtZGRkMGMxN2E3ZDA5IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                   target="_blank">Remuneração Damata SPO & DPO</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiZmNkODFlMzEtZjEzZS00ZWFiLThlMjctYjgxMWVlYTdkZjYxIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                 target="_blank">QLP (Quadro de Lotação de Pessoal)</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiYTM5ZDJlZWUtYjhjOC00ODlmLWJlZDAtZTFiZmNiMzgyODk0IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9"
                 target="_blank">Diversidade e Inclusão </a> </li>
        <li> <a href="https://app.powerbi.com/view?r=eyJrIjoiYzUxNGRmMTAtYzA4Yi00MTY0LThhN2QtZGUzN2QzZjlhNWQ4IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                 target="_blank">OPR (Ciclo de Gente)</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiN2ZhYjJkODMtNTkzOS00ZmUyLWJlZDQtOTZjNzc1OTExMzQ2IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9&pageName=ReportSection" 
                 target="_blank">TurnOver</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiOTNhZjE1NDMtMGJlYi00N2Q4LWI1Y2YtZTcwZWVmMTczNTFiIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                 target="_blank">Absenteísmo</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiOGUzM2NjNDctMDg2OC00NmI5LTkzYjEtN2M1MDE4MzA4MGVmIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9&pageName=ReportSectionfb3ed877418d0466dcf0" 
                 target="_blank">Recrutamento & Seleção 45 dias </a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiNTU5MDM5OTYtNWFlNS00MzI3LWI4MTMtNjFlZTRkNmRmMWUyIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9&pageName=ReportSectiond3865e98e5b1f6b426d7" 
                 target="_blank">Penalidades</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiNmVjNTkwY2YtZDNhOC00NTM4LWI3MTMtYmExYjgyNzUzMTRmIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9&pageName=ReportSection" 
                 target="_blank">Passivo Trabalhista</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiMTY2YWUwOTMtY2VmMy00ZDY2LTg2MDItZTViYjYyNGQ0ODZlIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                 target="_blank">Ouvidoria & Caixa de Sugestões</a> </li>
    </ol>
    </div>
</article>
<article class="servico bg-white radius">
    <div class="inner">
    <h4 class="center"><i accesskey="" class="fab fa-servicestack"></i> Config.</h4><br/>
    <ul >
        <li>  <a href="passivo.php"><i class="fas fa-balance-scale"></i> Gerenciar de Passivo</a> </li>
        <li><a href="videospb.php" > <i class="fab fa-youtube"></i> Como Atualizar Relatórios BI</a></li>
        <li><a href='cadconfig.php' ><i class='fas fa-user-graduate'></i> Cadastro de Treinamentos</a></li>
        <li><a href='aplic.php' ><i class='fas fa-user-check'></i> Aplicabilidade dos Treinamentos</a></li>
    </ul>
    </div>
</article>
</div>
<?php elseif($_SESSION['type']=="GESTOR" || $_SESSION['type']=="LOG"):?>
        <div class="texto">
        <h3> <i class="fas fa-file-powerpoint"></i> Power BI Gente</h3><br/>
    <ol >
    <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiYzhjZWEzZmQtOWFhOS00MzJjLWJmNTUtYzNlZWQyNjRiNzg2IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                     target="_blank">Jornada Completa</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiMjgwY2MzNzktZmEyYi00YTVhLWIyYmMtYzMyZTQ3ODI1NGM0IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                     target="_blank">Banco de Horas</a> </li>
        <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiZmNkODFlMzEtZjEzZS00ZWFiLThlMjctYjgxMWVlYTdkZjYxIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                     target="_blank">QLP (Quadro de Lotação de Pessoal)</a> </li>
        <li> <a href="https://app.powerbi.com/view?r=eyJrIjoiN2ZhYjJkODMtNTkzOS00ZmUyLWJlZDQtOTZjNzc1OTExMzQ2IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9&pageName=ReportSection" 
                     target="_blank">TurnOver</a> </li>
        <li> <a href="https://app.powerbi.com/view?r=eyJrIjoiOTNhZjE1NDMtMGJlYi00N2Q4LWI1Y2YtZTcwZWVmMTczNTFiIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                 target="_blank">Absenteísmo</a> </li>
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