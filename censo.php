<?php session_start();
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou get
    $REQUEST_NB = (isset($post['NB'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    $REQUEST = (isset($post['consultar'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    $REQUEST_FIND = (isset($post['find'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/pesquisaNPS.php';
    $pesquisa = new pesquisaNPS($conexao);
?>
<?php require_once "./_page/header.php"; ?>
<?php require_once "./_page/menu.php"; ?>
<hgroup class="pagina">
<h3>Damata >> Censo</h3>
<h1><i class="far fa-smile"></i> Censo Diversidade</h1><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="login.php" ><i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto">
    <ul class="formmenu">
        <li><a href="nps.php" > <i class="fas fa-sign-out-alt"></i> Novo Censo</a></li> 
    </ul>
    <form method="POST" class="formmenu" name="formPesquisa" action="_controller/controllerCenso.php" onsubmit="return validaCenso();" ><br/>
    <div class="h4">O quê é o censo da Diversidade?<br/></div>
    <legend class="small">
    O Censo da Diversidade é uma pesquisa quantitativa online e física, individual, anônima e sigilosa, que procura mapear, em seu conjunto, a multiplicidade do time da  Damata Bebidas.
    "A diversidade faz parte da humanidade, nenhuma pessoa é igual à outra. Somos uma infinidade de possibilidades de existência. 
    Sabemos que a diversidade engloba diferentes dimensões individuais e sociais, que, juntas, compõem as identidades e, muitas vezes, determinam nossos lugares na sociedade."</legend><br/>
    <label for="setor">QUAL É O SEU SETOR?</label>
    <select name="setor" id="setor"  required class="form-control col-sm-4">
        <option  selected>------------------</option>
        <option>ADMINISTRATIVO</option>
        <option>APOIO LOGISTICO</option>
        <option>COMERCIAL</option>
        <option>DISTRIBUIÇÃO</option>
        <option>PUXADA</option>
    </select>
    <hr class="form"/>
    <fieldset id="censo">ESTRATEGIAS DE INCLUSÃO- FERFIL<legend class="small">RESPONDA COM ATENÇÃO</legend></fieldset>
    <label for="idade">1-Qual a sua idade?</label>
    <select name="idade" id="idade"  required class="form-control col-sm-4">
        <option  selected>------------------</option>
        <option>18 A 21 ANOS</option>
        <option>22 A 30 ANOS</option>
        <option>31 A 40 ANOS</option>
        <option>41 A 50 ANOS</option>
        <option>ACIMA DE 50 ANOS</option>
    </select><br/>
    <label for="tempo">2- Há quanto tempo você trabalha na Damata ?</label>
    <select name="tempo" id="tempo"  required class="form-control col-sm-4">
        <option  selected>------------------</option>
        <option>MENOS DE 1 ANO</option>
        <option>1 A 2 ANOS</option>
        <option>2 A 3 ANOS</option>
        <option>3 A 4 ANOS</option>
        <option>MAIS QUE 5 ANOS</option>
    </select><br/>
    <div class="radio">
        <label for="lider">3-Você possui cargo de liderança: </label><br/>
        <legend class="small">Gerentes/Supervisores/Coordenadores?</legend>
        <input type="radio" name="lider" value="S" /> Sim 
        <input type="radio" name="lider" value="N" checked="checked" /> Não
    </div><br/>
    <hr class="form"/>
    <label for="estadocivil">4-Qual seu estado civil?</label>
    <select name="estadocivil" id="estadocivil"  required class="form-control col-sm-4">
        <option  selected>------------------</option>
        <option>Solteiro</option>
        <option>Casado</option>
        <option>Amasiado/amigado</option>
        <option>Separado/ divorciado</option>
        <option>Viúvo</option>
    </select><br/>
    <label for="escolaridade">5- Escolaridade?</label>
    <select name="escolaridade" id="escolaridade"  required class="form-control col-sm-4">
        <option  selected>------------------</option>
        <option>Ensino Fundamental Incompleto</option>
        <option>Ensino Fundamental Completo</option>
        <option>Ensino Médio Incompleto</option>
        <option>Ensino Médio Completo</option>
        <option>Superior incompleto</option>
        <option>Superior completo</option>
        <option>Pós Graduado</option>
    </select><br/>
    <label for="religiao">6-Você possui alguma religião?</label>
    <select name="religiao" id="religiao"  required class="form-control col-sm-4">
        <option  selected>------------------</option>
        <option>Católico</option>
        <option>Evangélico</option>
        <option>Religiões de matriz Africana (Umbanda, Candomblé..)</option>
        <option>Outras</option>
        <option>Não possuo religião</option>
    </select><br/>
    <hr class="form"/>
    <div class="radio">
        <label for="genero">7-Qual o seu gênero?</label><br/>
        <input type="radio" name="genero" value="M" checked="checked" /> Masculino <br/>
        <input type="radio" name="genero" value="F" /> Feminino <br/>
        <input type="radio" name="genero" value="N"  /> Prefiro não dizer <br/>
    </div><br/>
    <label for="orientacaosexual">8-Qual sua orientação sexual?</label>
    <select name="orientacaosexual" id="orientacaosexual"  required class="form-control col-sm-4">
        <option  selected>------------------</option>
        <option>Assexual (sem interesse sexual)</option>
        <option>Heterossexual ( interesse por pessoas do sexo oposto)</option>
        <option>Homossexual ( interesse por pessoas do mesmo sexo)</option>
        <option>Bissexual (interesse por ambos os sexos)</option>
        <option>Prefiro não Dizer</option>
    </select><br/>
    
    <label for="cor">9-Em relação raça/cor você se considera?</label>
    <select name="cor" id="cor"  required class="form-control col-sm-4">
        <option  selected>------------------</option>
        <option>Branca</option>
        <option>Preta</option>
        <option>Parda</option>
        <option>Amarela</option>
        <option>Indígena</option>
    </select><br/>
    <hr class="form"/>
    <div class="radio">
        <label for="nacionalidade">10-Nacionalidade?</label><br/>
        <input type="radio" name="nacionalidade" value="B" checked="checked" /> Brasileira <br/>
        <input type="radio" name="nacionalidade" value="E"  /> Estrangeira <br/>
    </div><br/>
    
    <div class="radio">
        <label for="naturalidade">11- Naturalidade? </label><br/>
        <legend class="small">( Aonde você nasceu)</legend>
        <input type="radio" name="naturalidade" value="L" checked="checked" /> Leopoldina <br/>
        <input type="radio" name="naturalidade" value="M"  /> Outra cidade de Minas Gerais <br/>
        <input type="radio" name="naturalidade" value="B"  /> Outro Estado <br/>
    </div><br/>
    
    <div class="radio">
        <label for="pcd">12- Você possui deficiência?</label><br/>
        <legend class="small">(física, mental, auditiva, visual, intelectual)</legend>
        <input type="radio" name="pcd" value="S" onclick="mostrarDef()" /> SIM <br/>
        <input type="radio" name="pcd" value="N" checked="checked" onclick="esconderDef()" /> NÃO <br/>
    </div>
    <hr class="form"/>
    <div id="divpcd">
        <div class="radio">
            <label for="deficiencia">13-Se você respondeu que possui deficiência, assinale a deficiência autodeclarada?</label><br/>
            <input type="radio" name="deficiencia" value="A" disabled='disabled' /> PCD auditivo <br/>
            <input type="radio" name="deficiencia" value="F" disabled='disabled'/> PCD fisico <br/>
            <input type="radio" name="deficiencia" value="I" disabled='disabled'/> PCD intelectual <br/>
            <input type="radio" name="deficiencia" value="V" disabled='disabled'/> PCD visual <br/>
            <input type="radio" name="deficiencia" value="M" disabled='disabled'/> PCD múltipla <br/>
            <input type="radio" name="deficiencia" value="N" disabled='disabled' checked="checked" /> Não possuo deficiência <br/>
        </div> 
    </div><br/>
    <div class="radio">
        <label for="politica">14- A Damata Bebidas possui políticas de diversidade e inclusão?</label><br/>
        <legend class="small">(todos são respeitados independente de cor, raça, opção sexual, religião, etc.)</legend>
        <input type="radio" name="politica" value="S" checked="checked" /> SIM <br/>
        <input type="radio" name="politica" value="N"   /> NÃO <br/>
        <input type="radio" name="politica" value="R"   /> NÃO SEI RESPONDER <br/>
    </div>
    <hr class="form"/>
    <label for="Nota">15-Quão importante para você é trabalhar num ambiente inclusivo? </label><br/>
    <label for="Nota" class="small" id="ForNota">Avaliação de 1 a 10 || Nota =>  10  </label>
    <input type="range" min="1" max="10" id="Nota" name="Nota" required class="form-control col-sm-3"
           value="10" onchange="mostrarRange()"/> <br/>
    
    <script type="text/javascript">
        function mostrarRange() {
            let nota = document.getElementById("Nota").value;
            document.getElementById("ForNota").innerHTML = "Avaliação de 1 a 10 || Nota => " + nota;
        }
    </script>
    <label for="Comentario">Comentário Livre :</label><br/><br/>
    <textarea name="Comentario" id="Comentario" required class="form-control col-sm-8" >
        
    </textarea>
    <br/><br/>
    <input type="hidden" name="funcao" value="1" readonly="readonly" />
<input name="Enviar" type="submit" class="enviar radius" value="Salvar"  /> <i class="fas fa-arrow-circle-right"></i><br/><br/>
</fieldset> 
</form>
</div>
<?php require_once "./_page/footer.php"; ?>
<?php 
    if(isset($REQUEST['sucess'])) { 
            echo "<script type='text/javascript'>censoOK();</script>";
    }