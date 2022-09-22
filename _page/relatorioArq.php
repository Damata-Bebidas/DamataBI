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
        require_once '../_model/classarquivos.php';
        $arquivo = new Arquivos($conexao);
        $resultado = $arquivo->consult();
        
        // Definimos o nome do arquivo que será exportado
        $nomeArquivo = 'Relatorio_Arquivos.xls';
        // Criamos uma tabela HTML com o formato da planilha
        $html = '';
        $html .= '<table border="0">';
        $html .= '<tr>';
        $html .= '<td><b>Matricula</b></td>';
        $html .= '<td><b>arquivo</b></td>';
        $html .= '<td><b>data</b></td>';
        $html .= '<td><b>tipo</b></td>';
        $html .= '</tr>';
        
        foreach ($resultado as $key => $value) {
            $html .= "<tr>";
            foreach ($value as $key2 => $value2) {
                if($key2=='data') {
                    $html .= "<td>" . date("d/m/y h:i",strtotime($value2)) . "</td>";
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
        header ("Content-Disposition: attachment; filename=\"{$nomeArquivo}\"" );
        header ("Content-Description: PHP Generated Data" );
        // Envia o conteúdo do arquivo
        echo $html;
        exit;
    }