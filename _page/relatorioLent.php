<?php ob_start();//inicio da sessao 
      session_start();//inicio da sessao
      require_once '../_model/urlDb.php';
        $url = new UrlBD();
        $url->iniciaAPI();
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
    require_once '../_model/colaborador.php';
    $colaborador = new colaborador($conexao);
    $matricula = $_SESSION['user'];
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
    $tipo = $resultado['tipo'];
    require_once '../_model/plano.php';
    $plano = new plano($conexao); 
    require_once '../_model/aplicabilidade.php';
    $aplic = new  aplicabilidade($conexao);
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou ger
    $REQUEST = (isset($post['tr'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    $id_consulta = base64_decode($REQUEST['tr']);
    $resultadoArea = $aplic->findArea($id_consulta);
    $matrizTreinemento = $plano->nomeTreinamento($id_consulta);
    $id = $REQUEST['tr'];
    if ($resultadoArea['id_area']<=3) {//<=3 somente as áreas gente gestão e seguranca
        $matriz = array('ADMINISTRATIVO','APOIO LOGÍSTICO',
            'DISTRIBUIÇÃO URBANA','PUXADA','VENDAS');
        $k = 0;
        foreach ($matriz as $key => $value) {
            $k++; $n = $matriz[$key];
        }
    }
    $frequencia = $plano->findFrequencia($id_consulta);
    $valor = $frequencia['frequencia'];
    $tamanhoString = strlen($valor) - 1;
    $texto = substr($valor,1,$tamanhoString);
    $qtd = substr($valor,0,1);
    if ($qtd>1) {
        for ($i=1; $i <= $qtd ; $i++) {
            $tr = (isset($REQUEST['tr'])) ? $REQUEST['tr'] : "" ;
            $w = (isset($REQUEST['aplic'])) ? "value='" . $REQUEST['aplic'] . "'" : "";
        }
    }   
    $tela = (count($matrizTreinemento)>1) ? $matrizTreinemento['Treinamento'] : "" ;
    // Definimos o nome do arquivo que será exportado
    $arquivo = 'Relatorio_' . $tela .'.xls';
    $dataHoje = date("Y-m-d");
    $dataPadrao = date("d/m/Y");
    $data = explode("/", $dataPadrao);
    list($dia, $mes, $ano) = $data;//divide matriz em variaveis
    $inicioAno = "$ano-01-01";
    $linkFreq = (isset($REQUEST['freq'])) ? $REQUEST['freq']: 1 ;            
    // Criamos uma tabela HTML com o formato da planilha
    $html = '';
    $html .= '<table border="0">';
    $html .= '<tr>';
    $html .= '<td><b>Participou?</b></td>';
    $html .= '<td><b>Matricula</b></td>';
    $html .= '<td><b>Nome</b></td>';
    $html .= '<td><b>Cargo</b></td>';
    $html .= '<td><b>Data</b></td>';
    $html .= '</tr>';

    if (isset($REQUEST['aplic'])) {
        $areaTxt = $matriz[($REQUEST['aplic'])-1];
        $resultadoAplic = $aplic->findTreinamentoArea($id_consulta,$areaTxt);
    } else {
        $resultadoAplic = $aplic->findTreinamento($id_consulta);
    }
    $totalAplic = count($resultadoAplic);
    $presenca = 0;
    foreach ($resultadoAplic as $key => $value1) {
        $freq = (isset($REQUEST['freq'])) ? $REQUEST['freq']  : 1;
        $m = $value1['matricula'] . "_" . base64_decode($REQUEST['tr']) . "_" . $freq;
        $buscarTreinamento = $plano->findTreinar($m);
        if ($buscarTreinamento['id_treinar']<>"") {
            $html .= "<tr><td> Sim </td>";
            $presenca++;
        } else {
            $html .= "<tr><td> Nao </td>";
        }
        foreach ($value1 as $key2 => $value2) {
            $html .= "<td>$value2</td>";
        }
        $buscardata = $plano->findDate($id_consulta); //data prevista
        if ($buscarTreinamento['data']<>"") {
            $valorData = $buscarTreinamento['data'];
            if ($valorData<>"" && strtotime($dataHoje)<strtotime($valorData))  {
                $dataHoje = $valorData;
            }  
            $html .= "<td>" . date("d/m/Y",strtotime($valorData)) . "</td></tr>";
        }elseif (count($buscardata['previsao'])==1) {
            $valorData = $buscardata['previsao'];
            if ($valorData<>"" && strtotime($dataHoje)<strtotime($valorData))  {
                $dataHoje = $valorData;
            }  
            $html .= "<td>" .   date("d/m/Y",strtotime($valorData)) . "</td></tr>";
        } else {
            $html .= "<td>" . date("d/m/Y",strtotime($dataHoje)) . "</td></tr>";
        }
    }
        // Configurações header para forçar o download
        header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header ("Cache-Control: no-cache, must-revalidate");
        header ("Pragma: no-cache");
        header ("Content-type: application/x-msexcel");
        header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
        header ("Content-Description: PHP Generated Data" );
        // Envia o conteúdo do arquivo
        echo $html;            