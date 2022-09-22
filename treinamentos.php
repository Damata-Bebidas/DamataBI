<?php 
ob_start();//inicio da sessao 
session_start();//inicio da sessao ?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Treinamentos</h3>
<h1><i class="fas fa-user-graduate"></i> &nbsp;&nbsp;Treinamentos</h1>
</hgroup>
<main class="servicos container bg-white">
<div class="container" > <!--class="container-fluid"-->
    <div class="col-sm-12 col-md-12 col-lg-12" >
            <article class="servico bg-white radius">
                <a href="treinamentos.php"><img src="_imagens/ouvidoria.jpeg" 
                class="img-thumbnail img-responsive"   alt="Ouvidoria" align="middle" /></a>
            <div class="inner">
                <a href="treinamentos.php">Ouvidoria / Compliance</a>
                <h4><b>Ouviria processo SDPO</b></h4>
                <p>Ouvidoria tudo aquilo que fere o código de ética!!!</p>
            </div>
            </article>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12" >        
            <article class="servico bg-white radius">
                <a href="treinamentos.php"><img src="_imagens/5s.jpg" 
                class="img-thumbnail img-responsive" alt="5S" align="middle" /></a>
            <div class="inner">
                <a href="treinamentos.php">Treinamento 5S</a>
                <h4><b>Treinamento SOLCA</b></h4>
                <p>Treinamenoto 5S!!!</p>
            </div>
            </article>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12" >        
            <article class="servico bg-white radius">
                <a href="treinamentos.php"><img src="_imagens/dpo.jpeg" 
                class="img-thumbnail img-responsive" alt="SDPO" align="middle" /></a>
            <div class="inner">
                <a href="treinamentos.php">Treinamento SDPO</a>
                <h4><b>O que é o SDPO?</b></h4>
                <p>Curso Básico tudo que você precisa sobre o SDPO!!!</p>
            </div>
            </article>
        
    </div> <!-- colunas -->
</div> <!-- container -->
</main>
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