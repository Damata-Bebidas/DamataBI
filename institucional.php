<?php session_start();//inicio da sessao ?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Institucional</h3>
<h1><i class="fas fa-thumbtack"></i> &nbsp;&nbsp; Institucional</h1>
</hgroup>
<div class="texto">
    <div class="container-fluid" > <!--class="container-fluid"-->
        <div class="col-sm-12" >
        <h2>QUEM SOMOS</h2>
        <p><b>Damata Bebidas Ltda. - Revendedora Ambev</b> 
            Foi fundada em 1978 pelos sócios José Carlos Calil & Valtacir Nei Ribeiro
            Matriz: Leopoldina;
            Escritórios Remotos: Ubá, Muriaé, Além Paraíba e Carangola;
            Atualmente representa e comercializa exclusivamente os produtos fabricados pela AMBEV</p>
        </div>
    
        <div class="col-sm-12" >
        <h2>MISSÃO</h2>
        <p>Ter a maior participação do mercado de bebidas, oferecendo qualidade e excelência nos serviços prestados, 
            atendendo às expectativas dos nossos clientes e consumidores, atavés de uma equipe motivada e comprometida.</p>    
        </div>

        <div class="col-sm-12" >
        <h2>VISÃO</h2>
        <p>Nosso sonho é ser um Revendedor Ambev de referência nacional, destacando-se pela liderança absoluta quanto à participação no mercado, através de uma abordagem consistente e sustentável para tudo o que fazemos.</p> 
        </div>

        <div class="col-sm-12" >
        <h2>VALORES</h2>
            <ul type="disc">
                <li><b>Gente:</b> as pessoas que fazem parte de nosso time são o alicerce da revenda: sem elas nada seria possível. 
                    Valorizar os indivíduos, suas diferenças e necessidades, reconhecendo suas contribuições e proporcionando uma relação de trabalho 
                    justa, desafiadora e favorável ao desenvolvimento pessoal e profissional; </li>
                <li><b>Clientes:</b> É a nossa razão de ser, sem eles não existe venda, nossas ações são focadas para superar suas expectativas;  </li>
                <li><b>Ética:</b> integridade e ética norteiam todas as atividades e o relacionamento com nossa gente, clientes, fornecedores e parceiros. 
                    Agir com honestidade, integridade, transparência e profissionalismo em todas as nossas relações e atividades dentro da empresa; </li>
                <li><b>Qualidade:</b> prestar um serviço com qualidade, visando a satisfação das necessidades e expectativas de nossos clientes.</li>
            </ul>
            <p><b><i>Damata Bebidas&copy;</i></p>
        </div> <!-- colunas -->
    </div> <!-- container -->
</div> <!-- texto -->
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