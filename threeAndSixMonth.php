<?php ob_start();//inicio da sessao 
      session_start();//inicio da sessao
      require_once "./_page/header.php"; 
      require_once "./_page/menu.php"; 
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
    }
    require_once './_model/colaborador.php';
    $colaborador = new colaborador($conexao);
    $matricula = (isset($_REQUEST['mat'])) ? base64_decode(htmlspecialchars($_REQUEST['mat'])) : "" ;
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
    $nome = $resultado['nome'];
    $setor = $resultado['setor'];
    $email = $resultado['email'];
    $cargo = $resultado['cargo'];
    $nascimento = $resultado['nascimento'];
    $admissao = $resultado['admissao'];
    $sexo = $resultado['sexo'];
    $escolaridade = $resultado['escolaridade'];
    $status = $resultado['status'];
    if (isset($_REQUEST['repositor'])) {
        $cargoUrl = htmlspecialchars($_REQUEST['repositor']);
    } else if(isset($_REQUEST['vendedor'])) {
        $cargoUrl = htmlspecialchars($_REQUEST['vendedor']);
    } else if(isset($_REQUEST['entrega'])) {
        $cargoUrl = htmlspecialchars($_REQUEST['entrega']);
    } 
    $tipo = (isset($_REQUEST['tipo'])) ? substr($_REQUEST['tipo'],0,1) : "" ;
    require_once '_model/prova3e6meses.php';
    $prova = new prova3e6meses($conexao);
    $findExam = $prova->findCargo($matricula,$cargoUrl);
    $exect = true;
    foreach ($findExam as $key => $value) {
       foreach ($value as $key2 => $value2) {
            if (substr($value2,0,1)==$tipo) {
                $exect = false;
                $id  = $value['id'];
                $aplicacao = $value['aplicacao'];
                $tipo = $value['tipo'];
                for ($i=0; $i < 23; $i++) { 
                    $qt[] = $value['qt' . ($i + 1)];
                }
            }
       }
    }
    $qtdExam = count($findExam);
    if ($exect) {
        for ($i=0; $i < 23; $i++) { 
            $qt[] = "";
        }
    } ?>
<hgroup class="pagina">
<h3>Damata >> Prova de 3 e 6 Meses </h3>
<h1><i class="fas fa-list-ol"></i> Prova de 3 e 6 Meses</h1><br/><br/>
    &nbsp;&nbsp;<a href="findExam.php">
 <i class="fas fa-arrow-circle-left"></i>Voltar</a>
</hgroup>
<div class="texto"> <!----------------------- Vendedor ------------------------------------>
<?php if(isset($_REQUEST['vendedor']) && (strtolower($cargo)=="representante de negócios i")||(strtolower($cargo)=="vendedor externo")):?>
    <?php   $gabarito = array('B','D','A','A','A','B','D','A','A','C','B','D','D','D','D','B','C','D','D','A','A','A','D');
            $acerto=0;$erro=0;$total = count($gabarito);
            foreach ($gabarito as $key => $value) {
                if ($qt[$key]==$value) {
                    $acerto++;
                } else {
                    $erro++;
                }
            }
            if (!$exect) {
                $porcentagem1 = ($acerto/$total) * 100;
                $porcentagem = number_format($porcentagem1,1,",",".");
                echo "<h5><span class='pago'>Quant. de Acertos = $acerto</span></h5>"; 
                echo "<h5><span class='pendente'>Quant. Erros = $erro</span></h5>"; 
                echo "<h5>Quant. Total = $total -->  Acerto = $porcentagem %</h5><br/>"; 
            } ?>  
    <form method="POST" class="formmenu" action="_controller/controllerProva.php" name="form3e6Meses" onsubmit="return validarData();" >  
        <fieldset id="vendedor"><legend>Prova Representante de Negócios I</legend><br/>
            <label for="vendedor"> Colaborador:</label><legend>Colaborador avaliado</legend>
            <input type="text" id="vendedor" name="vendedor" 
            value="<?php echo $telaNome = (isset($_REQUEST['mat'])) ? $nome : ""; ?>" size="30" class="form-control col-sm-8" readonly="reandonly" /><br/>
            <label for="cargo"> Cargo:</label><legend>Cargo do avaliado</legend>
            <input type="text" id="cargo" name="cargo" class="form-control col-sm-8"
            value="<?php echo $telaCargo = (isset($_REQUEST['mat'])) ? $cargo : ""; ?>" size="30" readonly="reandonly" /><br/>
            <label for="admissao"> Data:</label><legend>Data Admissão do avaliado</legend>
            <input type="date" id="admissao" name="admissao" class="form-control col-sm-4"
            value="<?php echo $telaAdm = (isset($_REQUEST['mat'])) ? $admissao : ""; ?>" size="30" readonly="reandonly" /><br/>
            <label for="prova"> Tipo:</label><legend>Prova 3 e 6 meses</legend>
            <input type="radio" name="tipo" value="3 Meses" disabled="disabled" <?php echo $tela3M = ($tipo==3) ? 'checked="checked"' : '' ; ?> /> 3 Meses
            <input type="radio" name="tipo" value="6 Meses" disabled="disabled" <?php echo $tela6M = ($tipo==6) ? 'checked="checked"' : '' ; ?> /> 6 Meses <br/>
            <label for="data"> Data:</label><legend>Data da Prova</legend>
            <input type="date" id="data" name="data" class="form-control col-sm-4"  value="<?php echo $tela1 = (isset($_REQUEST['mat']) && (!$exect)) ? $aplicacao : ""; ?>" />
            <input type="hidden" name="mat" id="mat" value="<?php echo $tela2 = (isset($_REQUEST['mat'])) ? $matricula : ""; ?>" />
            <input type="hidden" name="id" id="id" value="<?php echo $tela3 = (isset($_REQUEST['mat']) && (!$exect)) ? $id : ""; ?>" />
            <input type="hidden" name="tipo" id="tipo" value="<?php echo $tela4 = (isset($_REQUEST['tipo'])) ? htmlspecialchars($_REQUEST['tipo']) : ""; ?>" />
            <input type="hidden" name="cargo" id="cargo" value="<?php echo $tela5 = (isset($_REQUEST['vendedor'])) ? htmlspecialchars($_REQUEST['vendedor']) : ""; ?>" />
        </fieldset><br/>
        <fieldset id="Questões"><legend>Perguntas:</legend><br/>
            <label for="qt1">1. Zelar pelo patrimônio da companhia também faz parte da ética no nosso trabalho.</label>
            <legend class="small">Assinale a alternativa que mostra uma situação em que o colaborador NÃO age com ética em relação ao patrimônio da Revenda.</legend><br/>
            <select name="qt1" class="form-control col-sm-8">
                    <option <?php echo $telaA1 = ($qt[0]=='A')?'selected': '';?>>A) Cuida dos aparelhos eletrônicos que utiliza na Revenda.</option>
                    <option <?php echo $telaA2 = ($qt[0]=='B')?'selected': '';?>>B)  Posta fotos nas redes sociais que foram tiradas durante o expediente na Revenda.</option>
                    <option <?php echo $telaA3 = ($qt[0]=='C')?'selected': '';?>>C)  Cuida dos veículos da Revenda.</option>
                    <option <?php echo $telaA4 = ($qt[0]=='D')?'selected': '';?>>D)  Segue o Código de Conduta Ética da Revenda e evita expor a imagem da revenda na internet.</option>
                </select><br/><br/>
            <label for="qt2">2. Qual o maior objetivo da Ergonomia?</label><br/>
            <select name="qt2" class="form-control col-sm-8" >
                <option <?php echo $telaB1 = ($qt[1]=='A')?'selected': '';?>>A) Nenhuma adaptação do trabalho.</option>
                <option <?php echo $telaB2 = ($qt[1]=='B')?'selected': '';?>>B)  A adaptação do trabalhador ao trabalho.</option>
                <option <?php echo $telaB3 = ($qt[1]=='C')?'selected': '';?>>C)  Nenhuma adaptação da empresa.</option>
                <option <?php echo $telaB4 = ($qt[1]=='D')?'selected': '';?>>D)  A adaptação do trabalho ao trabalhador.</option>
            </select><br/><br/>
            <label for="qt3">3. Quais os Epis são necessários para que o vendedor realize seu trabalho?</label><br/>
            <select name="qt3" class="form-control col-sm-8">
                <option <?php echo $telaC1 = ($qt[2]=='A')?'selected': '';?>>A) Luvas, Óculos e Calçado de Segurança.</option>
                <option <?php echo $telaC2 = ($qt[2]=='B')?'selected': '';?>>B)  Luvas, óculos, cinta lombar, jaqueta e antena.</option>
                <option <?php echo $telaC3 = ($qt[2]=='C')?'selected': '';?>>C)  Luvas, óculos e cinta lombar.</option>
                <option <?php echo $telaC4 = ($qt[2]=='D')?'selected': '';?>>D)  Não é necessário o uso de EPI’s.</option>
            </select><br/><br/>
            <label for="qt4">4. O que você perde com uma falta sem justificativa?</label><br/>
            <select name="qt4" class="form-control col-sm-8">
                <option <?php echo $telaD1 = ($qt[3]=='A')?'selected': '';?> >A)  Perde o dia de trabalho, diária e o DSR (Descanso semanal remunerado).</option>
                <option <?php echo $telaD2 = ($qt[3]=='B')?'selected': '';?>>B)  Perde somente a diária.</option>
                <option <?php echo $telaD3 = ($qt[3]=='C')?'selected': '';?>>C)  Perde o dia de trabalho e diária.</option>
                <option <?php echo $telaD4 = ($qt[3]=='D')?'selected': '';?>>D)  Perde as férias.</option>
            </select><br/><br/>
            <label for="qt5">5. Quais informações pode-se encontrar no R?</label><br/>
            <select name="qt5" class="form-control col-sm-8">
                <option <?php echo $telaE1 = ($qt[4]=='A')?'selected': '';?>>A) Ranking, Volume, Produtividade, Remuneração, Ações e Combos</option>
                <option <?php echo $telaE2 = ($qt[4]=='B')?'selected': '';?>>B)  Preço dos produtos e Endereço do PDV</option>
                <option <?php echo $telaE3 = ($qt[4]=='C')?'selected': '';?>>C)  Nome e foto do dono do PDV</option>
                <option <?php echo $telaE4 = ($qt[4]=='D')?'selected': '';?>>D)  Guia da moto e telefone do PDV</option>
            </select><br/><br/>
            <label for="qt6">6. Em relação ao uso do Procad, é verdadeiro afirmar que:</label><br/>
            <select name="qt6" class="form-control col-sm-8">
                <option <?php echo $telaF1 = ($qt[5]=='A')?'selected': '';?> >A) Posso fazer minha rota sem meu Procad em mãos;</option>
                <option <?php echo $telaF2 = ($qt[5]=='B')?'selected': '';?>>B)  Esse indicador mede a distância que estou do PDV no momento do atendimento;</option>
                <option <?php echo $telaF3 = ($qt[5]=='C')?'selected': '';?>>C)  Não bater o Procad não me trará prejuízos;</option>
                <option <?php echo $telaF4 = ($qt[5]=='D')?'selected': '';?>>D)  Meu Procad só registra minha visita se a internet do Palm estiver funcionando e posso bater o Procad de qualquer lugar do PDV.</option>
            </select><br/><br/>
            <label for="qt7">7. O que é TTV e TTC?</label><br/>
            <select name="qt7" class="form-control col-sm-8">
                <option <?php echo $telaG1 = ($qt[6]=='A')?'selected': '';?>>A) Preço TT Varejo e Preço TT Contrato;</option>
                <option <?php echo $telaG2 = ($qt[6]=='B')?'selected': '';?>>B)  Preço TT Varejo e Preço TT Concorrente;</option>
                <option <?php echo $telaG3 = ($qt[6]=='C')?'selected': '';?>>C)  Preço TT Varejo e Preço TT Cliente;</option>
                <option <?php echo $telaG4 = ($qt[6]=='D')?'selected': '';?>>D)  Preço TT Varejo e Preço TT Consumidor.</option>
            </select><br/><br/>
            <label for="qt8">8. Qual a composição do salário do Vendedor Rota?</label><br/>
            <select name="qt8" class="form-control col-sm-8">
                <option <?php echo $telaH1 = ($qt[7]=='A')?'selected': '';?>>A) 60% Volume e 40% IP;</option>
                <option <?php echo $telaH2 = ($qt[7]=='B')?'selected': '';?>>B)  40% Volume e 60% IP;</option>
                <option <?php echo $telaH3 = ($qt[7]=='C')?'selected': '';?>>C)  50% Volume e 50% IP;</option>
                <option <?php echo $telaH4 = ($qt[7]=='D')?'selected': '';?>>D)  75% Volume e 25% IP.</option>
            </select><br/><br/>
            <label for="qt9">9. Quais os itens constituem a variável?</label><br/>
            <select name="qt9" class="form-control col-sm-8">
                <option <?php echo $telaI1 = ($qt[8]=='A')?'selected': '';?>>A) Volume + IPs + Painel + DSR;</option>
                <option <?php echo $telaI2 = ($qt[8]=='B')?'selected': '';?>>B)  IP + CR + DSR;</option>
                <option <?php echo $telaI3 = ($qt[8]=='C')?'selected': '';?>>C)  Itens relacionados à volume + IPs + CR;</option>
                <option <?php echo $telaI4 = ($qt[8]=='D')?'selected': '';?>>D)  Nenhuma das alternativas anteriores.</option>
            </select><br/><br/>
            <label for="qt10">10. O que significa GSR e para que ele serve?</label><br/>
            <select name="qt10" class="form-control col-sm-8">
                <option <?php echo $telaJ1 = ($qt[9]=='A')?'selected': '';?>>A)  Gabarito de Segurança em Rota; para medir o desempenho dentro da Revenda;</option>
                <option <?php echo $telaJ2 = ($qt[9]=='B')?'selected': '';?>>B)  Gabarito de Seleção em Rota; para medir o desempenho no trânsito;</option>
                <option <?php echo $telaJ3 = ($qt[9]=='C')?'selected': '';?>>C)  Gabarito de Segurança em Rota; para medir o desempenho no trânsito;</option>
                <option <?php echo $telaj4 = ($qt[9]=='D')?'selected': '';?>>D)  Gabarito de Segurança em Rua; para medir o desempenho no trânsito;</option>
            </select><br/><br/>
            <label for="qt11">11. Onde fica o ponto de encontro em caso de Incêndio?</label><br/>
            <select name="qt11" class="form-control col-sm-8">
                <option <?php echo $telaK1 = ($qt[10]=='A')?'selected': '';?>>A)  Na recepção;</option>
                <option <?php echo $telaK2 = ($qt[10]=='B')?'selected': '';?>>B)  Ao lado da portaria;</option>
                <option <?php echo $telaK3 = ($qt[10]=='C')?'selected': '';?>>C)  Dentro do armazém;</option>
                <option <?php echo $telaK4 = ($qt[10]=='D')?'selected': '';?>>D)  Na sala de treinamento.</option>
            </select><br/><br/>
            <label for="qt12">12. Qual a composição do salário (Volume + Ips) Rota?</label><br/>
            <select name="qt12" class="form-control col-sm-8">
                <option <?php echo $telaL1 = ($qt[11]=='A')?'selected': '';?>>A)  RGB 30% - OW 10% - Estratégico 10% - Refrigenanc 10% - 4 IP 10% cada</option>
                <option <?php echo $telaL2 = ($qt[11]=='B')?'selected': '';?>>B)  RGB 10% - OW 20% - Estratégico 20% - Refrigenanc 20% - 3 IP 10% cada</option>
                <option <?php echo $telaL3 = ($qt[11]=='C')?'selected': '';?>>C)  RGB 10% - OW 10% - Estratégico 15% - Refrigenanc 15% - 5 IP 10% cada</option>
                <option <?php echo $telaL4 = ($qt[11]=='D')?'selected': '';?>>D)  RGB 20% - OW 10% - Estratégico 15% - Refrigenanc 15% - 4 IP 10% cada</option>
            </select><br/><br/>
            <label for="qt13">13. Quais os tipos de classificação do Ciclo de Gente?</label><br/>
            <select name="qt13" class="form-control col-sm-8">
                <option <?php echo $telaM1 = ($qt[12]=='A')?'selected': '';?>>A)  Novo, Bom, Muito Bom, Treinar, Recuperar e Desligar.</option>
                <option <?php echo $telaM2 = ($qt[12]=='B')?'selected': '';?>>B)  Novo, Razoável, Bom e Desligar;</option>
                <option <?php echo $telaM3 = ($qt[12]=='C')?'selected': '';?>>C)  Novo, Bom, Muito Bom, Preparar e Recuperar;</option>
                <option <?php echo $telaM4 = ($qt[12]=='D')?'selected': '';?>>D)  Novo, Bom, Muito Bom, Preparar, Recuperar e Desligar.</option>
            </select><br/><br/>
            <label for="qt14">14. Qual é o gabarito de execução da área INTERNA do PDV?</label>1<br/>
            <select name="qt14" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[13]=='A')?'selected': '';?>>A)  Cartaz de Tudão, Cartaz de Refri, Faixa Trimarca e Faixa Refri;</option>
                <option <?php echo $tela = ($qt[13]=='B')?'selected': '';?>>B)  Cartaz de Tudão, Cartaz de Refri e Bandô;</option>
                <option <?php echo $tela = ($qt[13]=='C')?'selected': '';?>>C)  Cartaz de Tudão, Cartaz com a Tabela de Preços, Cartaz de Inovação e Cartaz de Refri e Bandô;</option>
                <option <?php echo $tela = ($qt[13]=='D')?'selected': '';?>>D)  Cartaz de Tudão, Cartaz com a Tabela de Preços, Cartaz de Inovação e Cartaz de Refri; e. Cartaz de Refri P2L, Cartaz de Tudão, Faixa Trimarca e Cartaz M4.</option>
            </select><br/><br/>
            <label for="qt15">15. Quando ocorre o acidente de trajeto?</label><br/>
            <select name="qt15" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[14]=='A')?'selected': '';?>>A)  Acontece quando dá a hora de descanso; </option>
                <option <?php echo $tela = ($qt[14]=='B')?'selected': '';?>>B)  Acontece dentro do armazém; </option>
                <option <?php echo $tela = ($qt[14]=='C')?'selected': '';?>>C)  Acontece no trajeto na rua quando em visita aos PDV’S; </option>
                <option <?php echo $tela = ($qt[14]=='D')?'selected': '';?>>D)  Acontece no caminho de casa para o trabalho ou vice-versa, sem alteração ou desvios;</option>
            </select><br/><br/>
            <label for="qt16">16. Sobre as informações de remuneração presentes no R, devemos afirmar que:</label><br/>
            <select name="qt16" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[15]=='A')?'selected': '';?>>A)  O R mostra os maiores salários da sala;</option>
                <option <?php echo $tela = ($qt[15]=='B')?'selected': '';?>>B)  O R traz as informações de volume e IP´s de forma simplificada, facilitando a visualização do VD;</option>
                <option <?php echo $tela = ($qt[15]=='C')?'selected': '';?>>C)  O R tem o valor em Reais que o VD está ganhando;</option>
                <option <?php echo $tela = ($qt[15]=='D')?'selected': '';?>>D)  Não existe informação de remuneração no R e. No R o VD visualiza quanto ganhou no mês passado e esse mês</option>
            </select><br/><br/>
            <label for="qt17">17. Sobre o R é correto afirmar:</label><br/>
            <select name="qt17" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[16]=='A')?'selected': '';?>>A)  R é entregue toda segunda-feira com as estratégias de vendas da semana;</option>
                <option <?php echo $tela = ($qt[16]=='B')?'selected': '';?>>B)  O responsável por entregar o R aos vendedores é o time de Gente e Gestão;</option>
                <option <?php echo $tela = ($qt[16]=='C')?'selected': '';?>>C)  O R é o demonstrativo de volume, cobertura e coleta de preço de cada PDV.</option>
                <option <?php echo $tela = ($qt[16]=='D')?'selected': '';?>>D)  Para fazer a análise do R, não devo levar em consideração os resultados do ano anterior do PDV</option>
            </select><br/><br/>
            <label for="qt18">18. Qual é o gabarito de execução da área EXTERNA do PDV?</label><br/>
            <select name="qt18" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[17]=='A')?'selected': '';?>>A)  Quando Aderido: Faixa Trimarca 1/1 ( tendo espaço também de Litro e Litrinho) e se tiver concorrente, de M4 e foco regional. Não aderido: Bandô; </option>
                <option <?php echo $tela = ($qt[17]=='B')?'selected': '';?>>B)  Quando Aderido: Bandô. Quando Não Aderido: Nada;</option>
                <option <?php echo $tela = ($qt[17]=='C')?'selected': '';?>>C)  Quando Aderido: Faixa Trimarca 1/1 ( tendo espaço também de Litro e Litrinho) e se tiver concorrente, de M4 e foco regional. Não aderido: Nada; </option>
                <option <?php echo $tela = ($qt[17]=='D')?'selected': '';?>>D)  Quando Aderido: Cartaz Menu, Cartaz Refri. Quando Não Aderido: Nada</option>
            </select><br/><br/>
            <label for="qt23">19. Na Ambev, um bom vendedor não é apenas aquele que gera lucros para a empresa. Para ser eficiente, o bom vendedor deve, além de vestir a camisa, também ser ético e responsável.?</label><br/>
            <legend class="small">Imagine que um cliente lhe ofereça ingressos para o show do seu cantor favorito ou um happy hour com os melhores petiscos da casa. Qual deve ser a sua conduta nesse tipo de situação?</legend>
            <select name="qt23" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[22]=='A')?'selected': '';?>>A)  Deve-se aceitar a oferta do cliente, já que aceitar um agrado melhora a relação com o cliente;</option>
                <option <?php echo $tela = ($qt[22]=='B')?'selected': '';?>>B)  Deve-se recusar a oferta de forma ríspida, dizendo que irá denunciar o cliente na junta comercial;</option>
                <option <?php echo $tela = ($qt[22]=='C')?'selected': '';?>>C)  Deve-se aceitar a oferta do cliente, retribuindo com descontos em todos os produtos; </option>
                <option <?php echo $tela = ($qt[22]=='D')?'selected': '';?>>D)  Deve-se recusar a oferta educadamente, dizendo que não pode aceitá-la porque são regras da companhia;</option>
            </select><br/><br/>
            <label for="qt19">20. Para uma máquina funcionar bem, todas as peças que a compõem são importantes</label>
            <legend class="small">Na Ambev, a força de vendas possui uma organização que funciona como uma máquina, em que todas as engrenagens ajudam no processo de vendas. Leia a seguir a descrição das principais funções de cada uma dessas engrenagens dentro da máquina de vendas:<br/>
                        1 – Atende uma relação de PDVs, fazendo ligações programadas. <br/>
                        2 – Lideram as mesas. <br/>
                        3 – É responsável por todas as salas de vendas. <br/>
                        4 – Compõem as mesas que atendem setores divididos por área territorial ou por uma lista de clientes específica. <br/>
                        5 – São responsáveis por receber ligações para negociar produtos e fazer pedidos.<br/>
                        6 – É responsável por uma sala de vendas. Assinale a alternativa que relaciona corretamente a descrição da função com o nome do cargo:</legend><br/>
            <select name="qt19" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[18]=='A')?'selected': '';?>>A)  1 – vendedor interno; 2 – supervisores; 3 – gerente comercial; 4 – vendedores internos e externos; 5 – vendedor interno receptivo; 6 – gerente de vendas.</option>
                <option <?php echo $tela = ($qt[18]=='B')?'selected': '';?>>B)  1 – vendedor interno; 2 – gerente comercial; 3 – supervisores; 4 – gerente de vendas; 5 – vendedor interno receptivo; 6 – vendedores internos e externos.</option>
                <option <?php echo $tela = ($qt[18]=='C')?'selected': '';?>>C)  1 – vendedores internos e externos; 2 – supervisores; 3 – gerente comercial; 4 – vendedor interno; 5 – gerente de vendas; 6 – vendedor interno receptivo.</option>
                <option <?php echo $tela = ($qt[18]=='D')?'selected': '';?>>D)  1 – vendedor interno receptivo; 2 – gerente de vendas; 3 – gerente comercial; 4 – vendedores internos e externos; 5 – vendedor interno; 6 – supervisores.</option>
            </select><br/><br/>
            <label for="qt20">21. O vendedor externo da Ambev também é uma peça fundamental para fazer a máquina de vendas funcionar a todo vapor.</label><br/>
            <legend class="small">Ele é o dono dos Pontos de Venda que são divididos em monopasse (uma visita por semana), bipasse (duas visitas por semana) e tripasse (três visitas por semana). O que é feito para garantir mais segurança e agilidade para cumprir as metas nas ruas?</legend>
            <select name="qt20" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[19]=='A')?'selected': '';?>>A)  A rota do vendedor é registrada e controlada por GPS.</option>
                <option <?php echo $tela = ($qt[19]=='B')?'selected': '';?>>B)  A rota do vendedor é montada de acordo com as suas preferências.</option>
                <option <?php echo $tela = ($qt[19]=='C')?'selected': '';?>>C)  A rota do vendedor é modificada constantemente para que as metas sejam cumpridas.</option>
                <option <?php echo $tela = ($qt[19]=='D')?'selected': '';?>>D)  As metas são analisadas em tempo real pelo seu supervisor por telefone.</option>
            </select><br/><br/>
            <label for="qt21">22. Sabemos que o vendedor da Ambev está mais do que acostumado a bater meta todos os dias, porém às vezes isso não acontece.</label><br/>
            <legend class="small">Há inúmeros motivos que levam a isso, como falta de produto e problemas financeiros e logísticos do cliente. Agora imagine a situação em que o produto que você vendeu foi devolvido. O que você deve fazer nessa situação?</legend>
            <select name="qt21" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[20]=='A')?'selected': '';?>>A)  Garantir o correto fluxo de devolução do pedido, incluindo o cancelamento da NF.</option>
                <option <?php echo $tela = ($qt[20]=='B')?'selected': '';?>>B)  Ficar com o produto devolvido.</option>
                <option <?php echo $tela = ($qt[20]=='C')?'selected': '';?>>C)  Pedir ao supervisor que tome uma providência.</option>
                <option <?php echo $tela = ($qt[20]=='D')?'selected': '';?>>D)  Tentar convencer o cliente para que ele aceite o produto a qualquer custo.</option>
            </select><br/><br/>
            <label for="qt22">23. Qual a composição da remuneração do vendedor Rota?</label><br/>
            <select name="qt22" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[21]=='A')?'selected': '';?>>A)  40% de IP e 60% Volume sendo: RGB 30% - OW 10% - Estratégico 10% - Refrigenanc 10% - 4 IP 10% cada</option>
                <option <?php echo $tela = ($qt[21]=='B')?'selected': '';?>>B)  30% de IP e 70% de Volume sendo: RGB 10% - OW 20% - Estratégico 20% - Refrigenanc 20% - 3 IP 10% cada</option>
                <option <?php echo $tela = ($qt[21]=='C')?'selected': '';?>>C)  35% De IP e 65% de Volume sendo: RGB 10% - OW 10% - Estratégico 15% - Refrigenanc 15% - 5 IP 10% cada</option>
                <option <?php echo $tela = ($qt[21]=='D')?'selected': '';?>>D)  40% de IP e 60% Volume sendo: RGB 20% - OW 10% - Estratégico 15% - Refrigenanc 15% - 4 IP 10% cada</option>
            </select><br/><br/>
            
        </fieldset><br/>
        <hr class="form col-sm-7 pull-left"/>
        <input name="tEnviar" type="submit" class="enviar radius" value="Salvar"/><i class="fas fa-arrow-circle-right"></i>
    </form> <!---------------------------- Repositor ---------------------------->
<?php elseif(isset($_REQUEST['repositor']) && (strtolower($cargo)=="repositor")):?>
    <?php   $gabarito = array('B','A','A','C','D','A','B','C','B','D','A','A','B','B','A');
            $acerto=0;$erro=0;$total = count($gabarito);
            foreach ($gabarito as $key => $value) {
                if ($qt[$key]==$value) {
                    $acerto++;
                } else {
                    $erro++;
                }
            }
            if (!$exect) {
                $porcentagem = ($acerto/$total);
                $porcentagem *= 100;
                $porcentagem = number_format($porcentagem,1,",",".");
                echo "<h5><span class='pago'>Quant. de Acertos = $acerto</span></h5>"; 
                echo "<h5><span class='pendente'>Quant. Erros = $erro</span></h5>"; 
                echo "<h5>Quant. Total = $total -->  Acerto = $porcentagem %</h5><br/>"; 
            }
        ?>  
    <form method="POST" class="formmenu" action="_controller/controllerProva.php" name="form3e6Meses" onsubmit="return validarData();" >  
    <fieldset id="repositor"><legend>Prova Repositor</legend><br/>
            <label for="repositor"> Colaborador:</label><legend>Colaborador avaliado</legend>
            <input type="text" id="repositor" name="repositor" 
            value="<?php echo $tela = (isset($_REQUEST['mat'])) ? $nome : ""; ?>" size="50" class="form-control col-sm-8" readonly="reandonly" /><br/>
            <label for="cargo"> Cargo:</label><legend>Cargo do avaliado</legend>
            <input type="text" id="cargo" name="cargo" class="form-control col-sm-8"
            value="<?php echo $tela = (isset($_REQUEST['mat'])) ? $cargo : ""; ?>" size="50" readonly="reandonly" /><br/>
            <label for="admissao"> Data:</label><legend>Data Admissão do avaliado</legend>
            <input type="date" id="admissao" name="admissao" class="form-control col-sm-4"
            value="<?php echo $tela = (isset($_REQUEST['mat'])) ? $admissao : ""; ?>" size="50" readonly="reandonly" /><br/>
            <label for="prova"> Tipo:</label><legend>Prova 3 e 6 meses</legend>
            <input type="radio" name="tipo" value="3 Meses" disabled="disabled" <?php echo $tela = ($tipo==3) ? 'checked="checked"' : '' ; ?> /> 3 Meses
            <input type="radio" name="tipo" value="6 Meses" disabled="disabled" <?php echo $tela = ($tipo==6) ? 'checked="checked"' : '' ; ?> /> 6 Meses <br/>
            <label for="data"> Data:</label><legend>Data da Prova</legend>
            <input type="date" id="data" name="data" class="form-control col-sm-4" value="<?php echo $tela = (isset($_REQUEST['mat']) && (!$exect)) ? $aplicacao : ""; ?>" />
            <input type="hidden" name="mat" id="mat" value="<?php echo $tela = (isset($_REQUEST['mat'])) ? $matricula : ""; ?>" />
            <input type="hidden" name="id" id="id" value="<?php echo $tela = (isset($_REQUEST['mat'])&& (!$exect)) ? $id : ""; ?>" />
            <input type="hidden" name="tipo" id="tipo" value="<?php echo $tela = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : ""; ?>" />
            <input type="hidden" name="cargo" id="cargo" value="<?php echo $tela = (isset($_REQUEST['repositor'])) ? $_REQUEST['repositor'] : ""; ?>" />
        </fieldset><br/>
        <fieldset id="Questões"><legend>Perguntas:</legend><br/>
            <label for="qt1">1. Zelar pelo patrimônio da companhia também faz parte da ética no nosso trabalho.</label>
            <legend class="small">Assinale a alternativa que mostra uma situação em que o colaborador NÃO age com ética em relação ao 
                patrimônio da Revenda.</legend><br/>
            <select name="qt1" class="form-control col-sm-8" style="width:300px;">
                    <option <?php echo $tela = ($qt[0]=='A')?'selected': '';?>>A) Cuida dos aparelhos eletrônicos que utiliza na Revenda.</option>
                    <option <?php echo $tela = ($qt[0]=='B')?'selected': '';?>>B)  Posta fotos nas redes sociais que foram tiradas durante o expediente na Revenda.</option>
                    <option <?php echo $tela = ($qt[0]=='C')?'selected': '';?>>C)  Cuida dos veículos da Revenda.</option>
                    <option <?php echo $tela = ($qt[0]=='D')?'selected': '';?>>D)  Segue o Código de Conduta Ética da Revenda e evita expor a imagem da revenda na internet.</option>
                </select><br/>
            <label for="qt2">2. Quais os EPI’s são necessários para que o repositor realize seu trabalho dentro do AS?</label><br/>
            <select name="qt2" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[1]=='A')?'selected': '';?> >A) Luvas, óculos, cinta lombar e calçado de segurança;</option>
                <option <?php echo $tela = ($qt[1]=='B')?'selected': '';?> >B) Luvas, óculos, cinta lombar, jaqueta e antena;</option>
                <option <?php echo $tela = ($qt[1]=='C')?'selected': '';?> >C) Luvas, óculos e cinta lombar;</option>
                <option <?php echo $tela = ($qt[1]=='D')?'selected': '';?> >D) Não é necessário o uso de EPI’s.</option>
            </select><br/>
            <label for="qt3">3. O que você perde com uma falta sem justificativa?</label><br/>
            <select name="qt3" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[2]=='A')?'selected': '';?> >A) Perde o dia de trabalho, diária e o DSR (Descanso semanal remunerado).</option>
                <option <?php echo $tela = ($qt[2]=='B')?'selected': '';?> >B) Perde somente a diária.</option>
                <option <?php echo $tela = ($qt[2]=='C')?'selected': '';?> >C) Perde o dia de trabalho e diária.</option>
                <option <?php echo $tela = ($qt[2]=='D')?'selected': '';?> >D) Perde as férias.</option>
            </select><br/>
            <label for="qt4">4. Quais os dias indispensáveis que o promotor de AS rota/repositor participa da reunião matinal de vendas com seu supervisor??</label><br/>
            <select name="qt4" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[3]=='A')?'selected': '';?> >A) Segunda, quarta e sexta;</option>
                <option <?php echo $tela = ($qt[3]=='B')?'selected': '';?> >B) Quarta e quinta;</option>
                <option <?php echo $tela = ($qt[3]=='C')?'selected': '';?> >C) Terça e quarta;</option>
                <option <?php echo $tela = ($qt[3]=='D')?'selected': '';?> >D) Terça e sábado.</option>
            </select><br/>
            <label for="qt5">5. O que é TTV e TTC?</label><br/>
            <select name="qt5" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[4]=='A')?'selected': '';?> >A) Preço TT Varejo e Preço TT Contrato;</option>
                <option <?php echo $tela = ($qt[4]=='B')?'selected': '';?> >B) Preço TT Varejo e Preço TT Concorrente;</option>
                <option <?php echo $tela = ($qt[4]=='C')?'selected': '';?> >C) Preço TT Varejo e Preço TT Cliente;</option>
                <option <?php echo $tela = ($qt[4]=='D')?'selected': '';?> >D) Preço TT Varejo e Preço TT Consumidor.</option>
            </select><br/>
            <label for="qt6">6. O que é ruptura em gôndolas?</label><br/>
            <select name="qt6" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[5]=='A')?'selected': '';?> >A) É o produto faltante;</option>
                <option <?php echo $tela = ($qt[5]=='B')?'selected': '';?> >B) É a falta de espaço;</option>
                <option <?php echo $tela = ($qt[5]=='C')?'selected': '';?> >C) É o produto vencido;</option>
                <option <?php echo $tela = ($qt[5]=='D')?'selected': '';?> >D) É o produto gelado.</option>
            </select>
            <label for="qt7">7. O que é Planograma?</label><br/>
            <select name="qt7" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[6]=='A')?'selected': '';?> >A) Produtos que faltam na gôndola;</option>
                <option <?php echo $tela = ($qt[6]=='B')?'selected': '';?> >B) Layout dos produtos na gôndola;</option>
                <option <?php echo $tela = ($qt[6]=='C')?'selected': '';?> >C) Produtos que ficam nas geladeiras;</option>
                <option <?php echo $tela = ($qt[6]=='D')?'selected': '';?> >D) Produtos sem preço.</option>
            </select><br/>
            <label for="qt8">8. O que significa GSR e para que ele serve?</label><br/>
            <select name="qt8" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[7]=='A')?'selected': '';?> >A) Gabarito de Segurança em Rota; para medir o desempenho dentro da Revenda;</option>
                <option <?php echo $tela = ($qt[7]=='B')?'selected': '';?> >B) Gabarito de Seleção em Rota; para medir o desempenho no trânsito;</option>
                <option <?php echo $tela = ($qt[7]=='C')?'selected': '';?> >C) Gabarito de Segurança em Rota; para medir o desempenho no trânsito;</option>
                <option <?php echo $tela = ($qt[7]=='D')?'selected': '';?> >D) Gabarito de Segurança em Rua; para medir o desempenho no trânsito;</option>
            </select><br/>
            <label for="qt9">09. Quais os 5 passos da execução das lojas do AS Rota?</label><br/>
            <select name="qt9" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[8]=='A')?'selected': '';?> >A) Pontos extras, produtos no depósito, TTC não aderido, produto não precificado e equipamentos de refrigeração desabastecidos; </option>
                <option <?php echo $tela = ($qt[8]=='B')?'selected': '';?> >B) Disponibilidade de produto, TTC correto, espaço em gôndola, ponto extra e produto gelado; </option>
                <option <?php echo $tela = ($qt[8]=='C')?'selected': '';?> >C) Merchandising, precificação, ponto extra, registro de chegada e registro de saída; </option>
                <option <?php echo $tela = ($qt[8]=='D')?'selected': '';?> >D) Disponibilidade de produto, TTC correto, espaço em gôndola, ponto extra e produto vencido.</option>
            </select><br/><br/>
            <label for="qt10">10. Quais os tipos de classificação do Ciclo de Gente?</label><br/>
            <select name="qt10" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[9]=='A')?'selected': '';?> >A) Novo, Bom, Muito Bom, Treinar, Recuperar e Desligar.</option>
                <option <?php echo $tela = ($qt[9]=='B')?'selected': '';?> >B) Novo, Razoável, Bom e Desligar;</option>
                <option <?php echo $tela = ($qt[9]=='C')?'selected': '';?> >C) Novo, Bom, Muito Bom, Preparar e Recuperar;</option>
                <option <?php echo $tela = ($qt[9]=='D')?'selected': '';?> >D) Novo, Bom, Muito Bom, Preparar, Recuperar e Desligar.</option>
            </select><br/>
            <label for="qt11">11. Quais os espaços mínimos exigidos para uma boa execução de gôndolas nas lojas do AS rota?</label><br/>
            <select name="qt11" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[10]=='A')?'selected': '';?> >A) 70% de cerveja e 30% de refri;</option>
                <option <?php echo $tela = ($qt[10]=='B')?'selected': '';?> >B) 50% de cerveja e 50% de refri;</option>
                <option <?php echo $tela = ($qt[10]=='C')?'selected': '';?> >C) 60% de cerveja e 40% de refri;</option>
                <option <?php echo $tela = ($qt[10]=='D')?'selected': '';?> >D) 40% de cerveja e 60% de refri.</option>
            </select><br/>
            <label for="qt12">12. Quais são as alavancas para execução de cervejas no AS rota?</label><br/>
            <select name="qt12" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[11]=='A')?'selected': '';?> >A) Share de Gôndola 70%; Share de Pontos Extras 70%; Share de Geladeiras 70% e Ponta de Gôndola de RGB ou Ponto Extra Fixo na entrada da loja; </option>
                <option <?php echo $tela = ($qt[11]=='B')?'selected': '';?> >B) Share de Gôndola 30%; Share de Pontos Extras 30%; Share de Geladeiras 30% e Ponta de Gôndola de RGB ou Ponto Extra Fixo no fundo da loja;</option>
                <option <?php echo $tela = ($qt[11]=='C')?'selected': '';?> >C) TTV aderido somente; </option>
                <option <?php echo $tela = ($qt[11]=='D')?'selected': '';?> >D) TTV e TTC aderidos.</option>
            </select><br/>
            <label for="qt13">13. Quais são as alavancas para execução de refri no AS rota?</label><br/>
            <select name="qt13" class="form-control col-sm-8" style="width:300px;">
                    <option <?php echo $tela = ($qt[12]=='A')?'selected': '';?> >A) Share de Gôndola 70%; Share de Pontos Extras 70%; Share de Geladeiras 70% e Ponta de Gôndola de refrigerante 2 litros ou Ponto Extra Fixo na entrada da loja;</option>
                    <option <?php echo $tela = ($qt[12]=='B')?'selected': '';?> >B) Share de Gôndola 30%; Share de Pontos Extras 30%; Share de Geladeiras 30% e Ponta de Gôndola de refrigerante 2 litros ou Ponto Extra Fixo no fundo da loja; </option>
                    <option <?php echo $tela = ($qt[12]=='C')?'selected': '';?> >C) TTV Aderido somente; </option>
                    <option <?php echo $tela = ($qt[12]=='D')?'selected': '';?> >D) TTV e TTC aderidos.</option>
            </select><br/>
            <label for="qt14">14. O que significa a sigla SOLCA?</label><br/>
            <select name="qt14" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[13]=='A')?'selected': '';?> >A) Seleção, Omissão, Limpeza, Conservação e Autodisciplina;</option>
                <option <?php echo $tela = ($qt[13]=='B')?'selected': '';?> >B) Seleção, Organização, Limpeza, Conservação e Autodisciplina;</option>
                <option <?php echo $tela = ($qt[13]=='C')?'selected': '';?> >C) Solução, Organização, Limpeza, Conservação e Autodisciplina;</option>
                <option <?php echo $tela = ($qt[13]=='D')?'selected': '';?> >D) Seleção, Organização, Limpeza, Comunicação e Autodisciplina.</option>
            </select><br/>
            <label for="qt15">15. O que significa GSAS e para que ele serve?</label><br/>
            <select name="qt15" class="form-control col-sm-8" style="width:300px;">
                <option <?php echo $tela = ($qt[14]=='A')?'selected': '';?> >A) Gabarito de Segurança em Auto serviço; para medir o desempenho de segurança dentro do AS;</option>
                <option <?php echo $tela = ($qt[14]=='B')?'selected': '';?> >B) Gabarito de Seleção em Auto serviço; para medir o desempenho no trânsito;</option>
                <option <?php echo $tela = ($qt[14]=='C')?'selected': '';?> >C) Gabarito de Solução em Auto serviço; para medir o desempenho de segurança dentro do AS;</option>
                <option <?php echo $tela = ($qt[14]=='D')?'selected': '';?> >D) Gabarito de Segurança em Auto serviço; para medir o desempenho físico dentro do AS;</option>
            </select><br/>
        </fieldset>
        <hr class="form col-sm-7 pull-left"/>
        <input name="tEnviar" type="submit" class="enviar radius" value="Salvar"/><i class="fas fa-arrow-circle-right"></i>
    </form> <!----------------------- Entrega ------------------------------------->
<?php elseif(isset($_REQUEST['entrega']) && (strtoupper(substr($setor,0,1))=="D")):?>
    <?php   $gabarito = array('B','D','D','A','C','A','B','B','C','D','A','D','D');
            $acerto=0;$erro=0;$total = count($gabarito);
            foreach ($gabarito as $key => $value) {
                if ($qt[$key]==$value) {
                    $acerto++;
                } else {
                    $erro++;
                }
            }
            if (!$exect) {
                $porcentagem = ($acerto/$total);
                $porcentagem *= 100;
                $porcentagem = number_format($porcentagem,1,",",".");
                echo "<h5><span class='pago'>Quant. de Acertos = $acerto</span></h5>"; 
                echo "<h5><span class='pendente'>Quant. Erros = $erro</span></h5>"; 
                echo "<h5>Quant. Total = $total -->  Acerto = $porcentagem %</h5><br/>"; 
            }
        ?>  
    <form method="POST" class="formmenu" action="_controller/controllerProva.php" name="form3e6Meses" onsubmit="return validarData();" >  
    <fieldset id="colaborador"><legend>Prova Distribuição Urbana</legend><br/>
            <label for="colaborador"> Colaborador:</label><legend>Colaborador avaliado</legend>
            <input type="text" class="form-control col-sm-8" id="colaborador" name="colaborador" 
            value="<?php echo $tela = (isset($_REQUEST['mat'])) ? $nome : ""; ?>" size="30" readonly="reandonly" /><br/>
            <label for="cargo"> Cargo:</label><legend>Cargo do avaliado</legend>
            <input type="text" class="form-control col-sm-8" id="cargo" name="cargo" 
            value="<?php echo $tela = (isset($_REQUEST['mat'])) ? $cargo : ""; ?>" size="30" readonly="reandonly" /><br/>
            <label for="admissao"> Data:</label><legend>Data Admissão do avaliado</legend>
            <input type="date" class="form-control col-sm-4" id="admissao" name="admissao" 
            value="<?php echo $tela = (isset($_REQUEST['mat'])) ? $admissao : ""; ?>" size="30" readonly="reandonly" /><br/>
            <label for="prova"> Tipo:</label><legend>Prova 3 e 6 meses</legend>
            <input type="radio" name="tipo" value="3 Meses" disabled="disabled" <?php echo $tela = ($tipo==3) ? 'checked="checked"' : '' ; ?> /> 3 Meses
            <input type="radio" name="tipo" value="6 Meses" disabled="disabled" <?php echo $tela = ($tipo==6) ? 'checked="checked"' : '' ; ?> /> 6 Meses <br/>
            <label for="data"> Data:</label><legend>Data da Prova</legend>
            <input type="date" id="data" name="data" class="form-control col-sm-4" value="<?php echo $tela = (isset($_REQUEST['mat']) && (!$exect)) ? $aplicacao : ""; ?>" />
            <input type="hidden" name="mat" id="mat" value="<?php echo $tela = (isset($_REQUEST['mat'])) ? $matricula : ""; ?>" />
            <input type="hidden" name="id" id="id" value="<?php echo $tela = (isset($_REQUEST['mat'])&& (!$exect)) ? $id : ""; ?>" />
            <input type="hidden" name="tipo" id="tipo" value="<?php echo $tela = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : ""; ?>" />
            <input type="hidden" name="cargo" id="cargo" value="<?php echo $tela = (isset($_REQUEST['entrega'])) ? $_REQUEST['entrega'] : ""; ?>" />
        </fieldset><br/>
        <fieldset id="Questões"><legend>Perguntas:</legend><br/>
            <label for="qt1">1. Zelar pelo patrimônio da companhia também faz parte da ética no nosso trabalho.</legend><br/>
            <legend class="small">Assinale a alternativa que mostra uma situação em que o colaborador NÃO age com ética em relação ao patrimônio da Revenda.</legend>
            <select name="qt1" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[0]=='A')?'selected': '';?> >A)Cuida dos aparelhos eletrônicos que utiliza na Revenda.</option>
                <option <?php echo $tela = ($qt[0]=='B')?'selected': '';?> >B) Posta fotos nas redes sociais que foram tiradas durante o expediente na Revenda.</option>
                <option <?php echo $tela = ($qt[0]=='C')?'selected': '';?> >C) Cuida dos veículos da Revenda.</option>
                <option <?php echo $tela = ($qt[0]=='D')?'selected': '';?> >D) Segue o Código de Conduta Ética da Revenda e evita expor a imagem da revenda na internet.</option>
            </select><br/><br/>
            <label for="qt2" >2. Qual o maior objetivo da Ergonomia?</label><br/>
            <select name="qt2" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[1]=='A')?'selected': '';?> >A) Nenhuma adaptação do trabalho.</option>
                <option <?php echo $tela = ($qt[1]=='B')?'selected': '';?> >B) A adaptação do trabalhador ao trabalho.</option>
                <option <?php echo $tela = ($qt[1]=='C')?'selected': '';?> >C) Nenhuma adaptação da empresa.</option>
                <option <?php echo $tela = ($qt[1]=='D')?'selected': '';?> >D) A adaptação do trabalho ao trabalhador.</option>
            </select><br/><br/>
            <label for="qt3">3. Qual motivo para que a empresa possa existir e sobreviver no mercado:</label><br/>
            <select name="qt3" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[2]=='A')?'selected': '';?> >A) Os caminhões são o maior motivo da empresa existir e se manter firme na redução de custos.</option>
                <option <?php echo $tela = ($qt[2]=='B')?'selected': '';?> >B) A equipe de vendas é o motivo da empresa existir pois são responsável pelo faturamento.</option>
                <option <?php echo $tela = ($qt[2]=='C')?'selected': '';?> >C) O indicador que mede a meta de liberação da equipa na unidade, sendo 30 minutos e 85% da equipe.</option>
                <option <?php echo $tela = ($qt[2]=='D')?'selected': '';?> >D) Os clientes são o maior motivo para um crescimento da empresa, além de sempre pensar em uma redução de custo.</option>
            </select><br/><br/>
            <label for="qt4">4. O que você perde com uma falta sem justificativa?</label><br/>
            <select name="qt4" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[3]=='A')?'selected': '';?> >A) Perde o dia de trabalho, diária e o DSR (Descanso semanal remunerado).</option>
                <option <?php echo $tela = ($qt[3]=='B')?'selected': '';?> >B) Perde somente a diária.</option>
                <option <?php echo $tela = ($qt[3]=='C')?'selected': '';?> >C) Perde o dia de trabalho e diária.</option>
                <option <?php echo $tela = ($qt[3]=='D')?'selected': '';?> >D) Perde as férias.</option>
            </select><br/><br/>
            <label for="qt5" >5. O que significa tempo médio de liberação</label><br/>
            <select name="qt5" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[4]=='A')?'selected': '';?> >A) A meta que a equipe tem para fazer o fechamento físico e financeiro.</option>
                <option <?php echo $tela = ($qt[4]=='B')?'selected': '';?> >B) O tempo que motorista tem para realizar a rota de entrega dos produtos.</option>
                <option <?php echo $tela = ($qt[4]=='C')?'selected': '';?> >C) O indicador que mede a meta de liberação da equipa na unidade, sendo 30 minutos e 85% da equipe.</option>
                <option <?php echo $tela = ($qt[4]=='D')?'selected': '';?> >D) O tempo necessário para motorista realizar a blitz de carregamento.</option>
            </select><br/><br/>
            <label for="qt6">6. Marque a alternativa onde TODAS as afirmativas são necessárias para que a equipe alcance a meta de TML.</label><br/>
            <select name="qt6" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[5]=='A')?'selected': '';?> >A) Chegar dentro do horário da matinal, ajudante encher garrafa d’agua, motorista conferir a carga e equipe na portaria para liberação.</option>
                <option <?php echo $tela = ($qt[5]=='B')?'selected': '';?> >B) Ajudante conferir a carga, motorista tomar café após a matinal, armazém chamar para blitz e equipe esperar na sala de matinal.</option>
                <option <?php echo $tela = ($qt[5]=='C')?'selected': '';?> >C) Motorista ir ao banheiro após a matinal, pegar seus EPI’s assim que chegar na revenda, ajudante tomar café após a matinal.</option>
                <option <?php echo $tela = ($qt[5]=='D')?'selected': '';?> >D) Equipe pegar EPI’s após a matinal, motorista conferir a carga, ajudante encher garrafa d’agua e equipe estar na sala de matinal pronta para liberação.</option>
            </select><br/><br/>
            <label for="qt7">7. Antes de iniciar as entregas qual é a primeira e mais importante passo da rotina básica que motorista e ajudante tem de fazer:</label><br/>
            <select name="qt7" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[6]=='A')?'selected': '';?> >A)Mostra NF para cliente e conferir quantidade, produto e forma de pagamento.</option>
                <option <?php echo $tela = ($qt[6]=='B')?'selected': '';?> >B) Pegar todos EPI’s para realizar a atividade de entrega.</option>
                <option <?php echo $tela = ($qt[6]=='C')?'selected': '';?> >C) Ajudar motorista a descer mercadoria do caminhão.</option>
                <option <?php echo $tela = ($qt[6]=='D')?'selected': '';?> >D) Conferir o vasilhame no estoque do cliente.</option>
            </select><br/><br/>
            <label for="qt8">8. O que é rotina básica:</label><br/>
            <select name="qt8" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[7]=='A')?'selected': '';?> >A) É momento que o colaborador tem para aprender o serviço.</option>
                <option <?php echo $tela = ($qt[7]=='B')?'selected': '';?> >B) São as etapas que o funcionário tem de seguir para realizar a atividade com segurança e eficiência.</option>
                <option <?php echo $tela = ($qt[7]=='C')?'selected': '';?> >C) São tarefas que não servem para utilizar no dia a dia.</option>
                <option <?php echo $tela = ($qt[7]=='D')?'selected': '';?> >D) É o procedimento que utilizado pelo supervisor para conhecer o serviço.</option>
            </select><br/><br/>
            <label for="qt13">9. Complete a frase com as palavras TEMPO EM ROTA e JORNADA LÍQUIDA de acordo com seus significados, logo após marque a alternativa correta:</label><br/>
            <legend class="small"> ______________ Significa momento em que o funcionário chega na revenda e termina quando vai embora registrando sempre seu ponto de entrada e saída.<br/> 
            Já ______________ é momento que o caminhão sai na portaria para realizar entrega e fecha quando retorna para revenda. <br/>
            A remuneração é atrelada diretamente com ______________.<br/> A responsabilidade do supervisor controlar ______________ da sua equipe afim de evitar o aumento do banco de horas.</legend>
            <select name="qt13" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[12]=='A')?'selected': '';?> >A) Tempo em Rota, Jornada Líquida, Jornada Líquida e Tempo em Rota.; </option>
                <option <?php echo $tela = ($qt[12]=='B')?'selected': '';?> >B) Jornada Líquida, Tempo em Rota, Jornada Líquida e Tempo em rota.; </option>
                <option <?php echo $tela = ($qt[12]=='C')?'selected': '';?> >C) Jornada Líquida, Tempo em Rota, Tempo em Rota e Jornada Líquida.; </option>
                <option <?php echo $tela = ($qt[12]=='D')?'selected': '';?> >D) Tempo em Rota, Jornada Líquida, Tempo em Rota e Jornada Líquida.;</option>
            </select><br/><br/><br/>
            <label for="qt9">10. Qual significado de tempo interno e suas atividades do motorista e ajudante:</label><br/>
            <select name="qt9" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[8]=='A')?'selected': '';?> >A) Tempo interno é calculado no momento que termina a última entrega até a chegada na revenda. O motorista tem a responsabilidade de registrar no telefone e o ajudante não tem nenhuma tarefa.</option>
                <option <?php echo $tela = ($qt[8]=='B')?'selected': '';?> >B) Tempo interno é monitorado quando inicia a matinal e termina quando o caminhão sai pela portaria. O motorista precisa fazer o checklist do caminhão enquanto o ajudante enche a garrafa d'agua.</option>
                <option <?php echo $tela = ($qt[8]=='C')?'selected': '';?> >C) Tempo interno é registrado pela central de monitoramento que liga para o motorista afim de justificar apontamento fora do raio e parada não programada.</option>
                <option <?php echo $tela = ($qt[8]=='D')?'selected': '';?> >D) Tempo interno é o calculado a partir do momento que o caminhão retorna da rota e entra na portaria até a finalização do acerto financeiro. O ajudante confere o físico junto com o conferente enquanto o motorista sobe para o financeiro e fecha o acerto com o(a) auxiliar de finanças.</option>
            </select><br/><br/>
            <label for="qt10">11. O que é TRACKING:</label><br/>
            <select name="qt10" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[9]=='A')?'selected': '';?> >A) É o indicador que mede o apontamento das entregas dentro do raio de 200 metros e tem uma meta acompanhada diariamente na matinal.</option>
                <option <?php echo $tela = ($qt[9]=='B')?'selected': '';?> >B) É a sequência de entregas realizadas pela equipe em rota e monitorada pelo analista de rota via programa MDM do computador.</option>
                <option <?php echo $tela = ($qt[9]=='C')?'selected': '';?> >C) É registrado por toda parada não programada do caminhão em rota.</option>
                <option <?php echo $tela = ($qt[9]=='D')?'selected': '';?> >D) É monitorada pelo supervisor no momento em que sai para rota com caminhão e realiza o gabarito de segurança.</option>
            </select><br/><br/>
            <label for="qt11">12. Quais os tipos de classificação do Ciclo de Gente?</label><br/>
            <select name="qt11" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[10]=='A')?'selected': '';?> >A) Novo, Bom, Muito Bom, Treinar, Recuperar e Desligar.</option>
                <option <?php echo $tela = ($qt[10]=='B')?'selected': '';?> >B) Novo, Razoável, Bom e Desligar;</option>
                <option <?php echo $tela = ($qt[10]=='C')?'selected': '';?> >C) Novo, Bom, Muito Bom, Preparar e Recuperar;</option>
                <option <?php echo $tela = ($qt[10]=='D')?'selected': '';?> >D) Novo, Bom, Muito Bom, Preparar, Recuperar e Desligar.</option>
            </select><br/><br/>
            <label for="qt12">13. Quando ocorre o acidente de trajeto?</label><br/>
            <select name="qt12" class="form-control col-sm-8">
                <option <?php echo $tela = ($qt[11]=='A')?'selected': '';?> >A) Acontece quando dá a hora de descanso; </option>
                <option <?php echo $tela = ($qt[11]=='B')?'selected': '';?> >B) Acontece dentro do armazém; </option>
                <option <?php echo $tela = ($qt[11]=='C')?'selected': '';?> >C) Acontece no trajeto na rua quando em visita aos PDV’S; </option>
                <option <?php echo $tela = ($qt[11]=='D')?'selected': '';?> >D) Acontece no caminho de casa para o trabalho ou vice-versa, sem alteração ou desvios;</option>
            </select><br/>
        </fieldset>
        <hr class="form col-sm-7 pull-left"/>
        <input name="tEnviar" type="submit" class="enviar radius" value="Salvar"/><i class="fas fa-arrow-circle-right"></i>
    </form>
<?php else: ?>
    <h2> Cargo ou setor do colaborador não é compatível com essa Prova</h2>
    <article class="servico bg-white radius">
     <div class="inner">
       <h4 class="center"><i class="fab fa-servicestack"></i> Tipos de Provas</h4>
        <ul class="formmenu consulta"> 
            <li>Nome: <?php echo $nome; ?></li>
            <li>Setor: <?php echo strtoupper($setor); ?></li>
            <li>Cargo: <?php echo strtoupper($cargo); ?></li>
            <li> <a href="findExam.php"> Consultar outra Prova</a></li>
        </ul>
    </div>
    </article>
<?php endif;?>
</div>
<?php require_once "./_page/footer.php"; ?>
<script type="text/javascript">
            var navegador = ObterBrowserUtilizado();
            var tela = ObterTela();
            var data = document.getElementById("data").value;
            if (navegador!=="Google Chrome" && tela && (data.substring(3,2)!=="/")) {
                var data = document.getElementById("data").value;
                var datatxt = InverterData(data);
                document.getElementById("data").value = datatxt;
            }
            var admissao = document.getElementById("admissao").value;
            if (navegador!=="Google Chrome" && tela && (admissao.substring(3,2)!=="/")) {
                var admissao = document.getElementById("admissao").value;
                var admissaotxt = InverterData(admissao);
                document.getElementById("admissao").value = admissaotxt;
            }
            function validarData() {
                var data = document.getElementById("data").value;
                if (data=="") {
                    alert("Campo Data é Obrigatório!!!");
                    document.getElementById("data").focus();
                    return false;
                }
            } 
</script>