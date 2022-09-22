<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once '../_model/urlDb.php';
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
    //relatório
    if (isset($_REQUEST['rel'])) {
        require_once '../_model/boleto.php';
        $boleto = new boleto($conexao);
        $data = base64_decode(htmlspecialchars($_REQUEST['data']));
        $hoje = date('Y-m-d');
        // Definimos o nome do arquivo que será exportado e buscamos os dados
        if (isset($_REQUEST['data'])) {
            $resultado = $boleto->consultBoletoData($url->converterData($data));
            $arquivo = 'Relatorio_Boletos' . $url->converterData($data) . '.xls';
        } else {
            $resultado = $boleto->consultBoletoData($hoje);
            $arquivo = 'Relatorio_Boletos' . $hoje . '.xls';
        }   
        // Criamos uma tabela HTML com o formato da planilha
        $html = '';
        $html .= '<table border="0">';
        $html .= '<tr>';
        $html .= '<td><b>NªDoc</b></td>';
        $html .= '<td><b>NB</b></td>';
        $html .= '<td><b>Nome</b></td>';
        $html .= '<td><b>Valor</b></td>';
        $html .= '<td><b>Vencimento</b></td>';
        $html .= '<td><b>Nota Fiscal</b></td>';
        $html .= '<td><b>IndicadorBaseCentral</b></td>';
        $html .= '<td><b>Código Barras</b></td>';
        $html .= '</tr>';
        
        foreach ($resultado as $key => $value) {
            $html .= "<tr>";
            foreach ($value as $key2 => $value2) {
                if ($key2=='valor') {
                   $html .= "<td>R$" . number_format($value2,2,',','.') . "</td>";
                } elseif($key2=='vencimento') {
                   $html .= "<td>" . date("d/m/y",strtotime($value2)) . "</td>";
                } elseif($key2=='data') {
                   $html .= "<td>" . date("d/m/y h:i a", strtotime("- 3 hours",strtotime($value2))) . "</td>";  
                } else {
                   $html .= "<td>&nbsp;$value2</td>";
                }
            }
            $html .= "</tr>";
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
        exit;
    }