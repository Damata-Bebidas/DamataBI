<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once '../_model/session.php';
    $session = new session();
    $session->logarUser(); //verificar se esta logado
    require_once '../_model/urlDb.php';
    $url = new UrlBD();
    $url->iniciaAPI();
    $dsn = $url->getDsn();
    $username = $url->getUsername();
    $passwd = $url->getPasswd();
    $url->logarUser();
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    //relatório
    if (isset($_REQUEST['rel'])) {
        require_once '../_model/entrevista.php';
        $entrevista = new entrevista($conexao);
        $resultado = $entrevista->consult();
        // Definimos o nome do arquivo que será exportado
        $arquivo = 'Entrevista_absenteismo.xls';

        // Criamos uma tabela HTML com o formato da planilha
        $html = '';
        $html .= '<table border="0">';
        $html .= '<tr>';
        $html .= '<td><b>Data</b></td>';
        $html .= '<td><b>Atividade</b></td>';
        $html .= '<td><b>Colaborador</b></td>';
        $html .= '<td><b>Cargo</b></td>';
        $html .= '<td><b>Tipo de Falta</b></td>';
        $html .= '<td><b>Motivo de Falta</b></td>';
        $html .= '<td><b>Ocorrência de falta(s) anterior(es) sem justificativa ?</b></td>';
        $html .= '<td><b>Comunicação prévia desta(s) falta(s) à empresa ?</b></td>';
        $html .= '<td><b>Apresentação de justificativa compatível ?</b></td>';
        $html .= '<td><b>Ação Tomada</b></td>';
        $html .= '<td><b>Justificativa para a falta acatada pela empresa ?</b></td>';
        $html .= '<td><b>Dia de Trabalho descontado ?</b></td>';
        $html .= '<td><b>Falta poderia ter sido evitada através de folga alinhada ?</b></td>';
        $html .= '<td><b>Início</b></td>';
        $html .= '<td><b>Fim</b></td>';
        $html .= '<td><b>Comentários Adicionais / RH e Liderança:</b></td>';
        $html .= '</tr>';
        
        foreach ($resultado as $key => $value) {
            $html .= "<tr>";
            foreach ($value as $key2 => $value2) {
                if($key2=='data' || $key2=='inicio' || $key2=='fim' ) {
                   $html .= "<td>" . date("d/m/y",strtotime($value2)) . "</td>";
                } else {
                   $html .= "<td>$value2</td>";
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