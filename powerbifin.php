<?php ob_start();//inicio da sessao 
      session_start();//inicio da sessao
      require_once './_model/session.php';
      $session = new session();
      $session->logarUser(); //verificar se esta logado 
      require_once "./_page/header.php"; 
      require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Power BI</h3>
<h1><i class="fas fa-chart-pie"></i> <a name="text1"> Power BI Financeiro </a> <br/><br/></h1>
<a href="powerbifin.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
<?php if(isset($_REQUEST['import'])):?>
    <h3> <i class="fas fa-file-invoice-dollar"></i> UpLoad Arquivos Base de Cadastro</h3><br/>
        <form name="formsanemaento" class="formmenu" action="_controller/controllerInserirBase.php" 
            method="POST" enctype="multipart/form-data">
            <label for="arquivo" >Arquivo (*.xml) do Excel Saneamento:</label> 
            <input type="file" id="arquivo"  name="arquivo" class="form-control col-sm-6"/><br/>
            <input type="hidden" value="1" name="Funcao" readonly="readonly" />
            <input name="tEnviar" type="submit" class="enviar radius" value="Enviar"/>
            <i class="fas fa-arrow-circle-right"></i>
        </form>
        <hr class="linha" />
        <form name="formsimulador" class="formmenu" action="_controller/controllerInserirSimulador.php" 
            method="POST" enctype="multipart/form-data">
            <label for="arquivo" >Arquivo (*.xml) do Excel Simulador:</label> 
            <input type="file" id="arquivo"  name="arquivo" class="form-control col-sm-6"/><br/>
            <input type="hidden" value="1" name="Funcao" readonly="readonly" />
            <input name="tEnviar" type="submit" class="enviar radius" value="Enviar"/>
            <i class="fas fa-arrow-circle-right"></i>
        </form>
        
<?php elseif($_SESSION['type']=="ROOT" || $_SESSION['type']=="FINAN" || $_SESSION['type']=="GESTOR"):?>
    <article class="servico bg-white radius">
     <div class="inner">
    <h3> <i class="fas fa-file-powerpoint"></i> Power BI Financeiro</h3><br/>
      <ol class="formmenu consulta">
        <li> <a href="powerbifin.php?import=true" > Importar Base para Tratamento</a> </li>
        <li> <a href="saneamento.php" > Tratar Cadastro</a> </li>
        <li> <a href="https://app.powerbi.com/view?r=eyJrIjoiNTUwNTJjZGUtZmM2NC00MGQ3LTgwMmMtYTg5MWNmMTcxZGU1IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                 target="_blank">Digitalização Cadastros</a>
        <li>  <a href="#text1"> SPO Financeiro</a>
            <ul id="listnone" class="formmenu consulta listnone consulta">

                <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiY2I2YTRlOWQtOWQxZi00MGE4LWI4MWUtOWZiZTVmNTczZWM4IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                            target="_blank">4.1 Digitalização de Comodato</a> 
                </li>

                <li>  <a href="https://app.powerbi.com/view?r=eyJrIjoiMmVkODE0NjYtMjQxYS00NGRjLTgwYmItMmJhOGI0NjA2MWRjIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                            target="_blank">4.2 Giro Zero Vasilhame</a> 
                </li>

                <li> <a href="https://app.powerbi.com/view?r=eyJrIjoiYWYyYzVhNWEtNDJiMy00YTc4LTg0ZjktZTFlNDdjNWVmNjk1IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                            target="_blank">4.3 Giro Zero Equipamentos</a> 
                </li>

                <li> <a href="https://app.powerbi.com/view?r=eyJrIjoiMjNlYTNlOTAtNmM1Mi00N2ViLTgwOWQtNzM5NzZjMjQ4MjE4IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" 
                target="_blank">4.5 Saneamento de cadastro</a>    
                </li>

                <li> <a href="https://app.powerbi.com/view?r=eyJrIjoiY2ZhNDIwOTUtODYyNi00MGMxLTgwMmItNWI5ZjAyOTgwYjhlIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" target="_blank">*Indicadores de Cadastros</a> </li>

            </ul>
        </li>
        <li> <a href="simulador.php" > Simulador de Comodatos</a> </li>
        <li> <a href="https://app.powerbi.com/view?r=eyJrIjoiNjc3OGFlMmMtMDk1NC00YjNhLTkwNWItYzU2ZmNjMjllYTYyIiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" target="_blank"> Base Compradora Cerveja</a> </li>
        <li> <a href="https://app.powerbi.com/view?r=eyJrIjoiZjE5MTM5NGEtMDlhMC00MzhkLTk0YzQtM2Y2MjI3MTZmZjA2IiwidCI6ImI2ZjI5Njk5LWZhN2MtNDcwMC1hYTg1LTNkODkxMjA4ZTQyYyJ9" target="_blank"> Giro Chopeira</a> </li>
    </ol>
     </div>
 </article>
 <article class="servico bg-white radius">
     <div class="inner">
    <h3> <i class="fas fa-file-powerpoint"></i> Power BI Services</h3><br/>        
            <ul id="listnone" class="formmenu consulta listnone consulta">
            <li>  <a href="https://damataleo-my.sharepoint.com/personal/damata01_damataleo_onmicrosoft_com/_layouts/15/onedrive.aspx?id=%2Fpersonal%2Fdamata01%5Fdamataleo%5Fonmicrosoft%5Fcom%2FDocuments%2FFinanceiro" 
                     target="_blank"> <i class="fas fa-cloud-upload-alt"></i> Acesso a Pasta Onedrive</a>
                </li>
                <li><a href="https://powerbi.microsoft.com/" target="_blank"  > <i class="fas fa-file-powerpoint"></i> PowerBI Web Service</a></li>
            </ul>
        </li>
    </ol>
     </div>
</div>
 </article>
<?php else:?>
    <div class="texto">
    <h2>Seu Usuário Não tem Acesso a essa página, consulte o Administrador do Sistema</h2>
    </div>
<?php endif;?>
</div>      
<?php require_once "./_page/footer.php"; ?>
<?php 
     if (isset($_REQUEST['sucess'])) {
         $index = htmlspecialchars($_REQUEST['sucess']);
         switch ($index) {
             case "b":
                 $msg = "<script>alert('Base Importada com Sucesso')</script>";
                 break;
             default:
                 $msg = "<script>alert('Dados Salvo com Sucesso')</script>";
                 break;
         }
         echo $msg;
     }
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
