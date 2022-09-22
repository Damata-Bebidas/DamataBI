<?php ob_start();//inicio da sessao 
    session_start();//inicio da sessao
    require_once './_model/urlDb.php';
        $url = new UrlBD();
        $url->inicia();
        $dsn = $url->getDsn();
        $username = $url->getUsername();
        $passwd = $url->getPasswd();
        $url->logarUser();//verificar root
    try {
        $conexao= new \PDO($dsn, $username, $passwd);//cria conexão com banco de dados 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    require_once './_model/analisesimulador.php';
    $simulador = new analisesimulador($conexao);
    if (isset($_REQUEST['consultar'])) {
        $nb = htmlspecialchars($_REQUEST['consultar']);
        $opcao = htmlspecialchars($_REQUEST['vasilhame']);
        $opcoes = explode("-", $opcao);
        $vasilhame = trim($opcoes[1]);
        $resultado = $simulador->findSimulador($nb, $vasilhame);
        if(count($resultado)<=1){
            echo '<script> alert("Cliente Inativo ou Não Cadastrado!!!") </script>';
        }
    }
    require_once './_model/planobh.php';
    $plano = new planobh($conexao);
?>
<!-- ----------------------------------PDF---------------------------------------------- -->
<?php if(isset($_REQUEST['consultar'])):?>
<?php 
    include ('_pdf/mpdf.php');    
    $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "" ; 
    $nb = (count($resultado)>0) ? $resultado['nb'] : "" ;
    $nome = (count($resultado)>0) ? $resultado['nome'] : "" ;
    $vasilhame = (count($resultado)>0) ? $resultado['vasilhame'] : "" ;
    $descr = (count($resultado)>0) ? $resultado['descr'] : "" ;
    require_once '_model/analisesimulador.php';
    $analisesimulador = new analisesimulador($conexao);
    if (isset($_REQUEST['update'])) {
        $updateId = $_REQUEST['id'];
        $resultado = $analisesimulador->find($updateId);
    }else {
        $resultado = $analisesimulador->find(0);
    }
    if ($resultado['classerisco']=="") { //caso esteja vazio puxar da tabela original do simulador 
        $resultado = $simulador->findSimulador($nb, $vasilhame);
    } 
    $classe = (count($resultado)>0) ? $resultado['classerisco'] : "" ;
    $docs = (count($resultado)>0) ? str_replace("S","Sim",str_replace("N", "Não", $resultado['docs'])) : "" ;
    $inad = (count($resultado)>0) ? str_replace("S","Sim",str_replace("N", "Não",$resultado['inad'])) : "" ;
    $giro = (count($resultado)>0) ? 
        str_replace("N", "NOK",str_replace("O", "OK",str_replace("Z", "Giro Zero", $resultado['giro']))) : "" ;
    $comodato = (count($resultado)>0) ? $resultado['comodato'] : "" ; 
    $ttcompracxs = (count($resultado)>0) ? $resultado['ttcompracxs'] : "" ;
    
    switch ($vasilhame) {
        case 'Barril':
            $meta = 4;
            break;
        case 'Refri 1/2':
            $meta = 4;
            break;
        default:
            $meta = 2;
            break;
    }

    require_once '_model/analisesimulador.php';
    $analisesimulador = new analisesimulador($conexao);
    if (isset($_REQUEST['update'])) {
        $updateId = $_REQUEST['id'];
        $resultado = $analisesimulador->find($updateId);
    }else {
        $resultado = $analisesimulador->find(0);
    }
    $qtd = (count($resultado)>1) ? $resultado['qtd'] : "" ;
    $meta = (count($resultado)>0) ? $meta*$qtd : "" ;
    
    $lacuna = $ttcompracxs - $meta;

    $serasa = (count($resultado)>0) ? 
    str_replace("P", "Pendência",str_replace("O", "OK s/ pendência", $resultado['serasa'])) : "" ;
    $status = (count($resultado)>1) ? $resultado['status'] : "" ;
    $motivo = (count($resultado)>1) ? $resultado['motivo'] : "" ;
    $codAprovador = (count($resultado)>1) ? $resultado['aprovador'] : "" ;
    $log = (count($resultado)>1) ? $resultado['log'] : "" ;
    
    switch ($codAprovador) {
        case 1009:
            $aprovador = 'LUCIANA RIBEIRO';
            break;
        case 102:
            $aprovador = 'FABIANO A. CALIL';
            break;
       case 103:
            $aprovador = 'FARID CALIL';
            break;
       case 104:
            $aprovador = 'JOSE CARLOS CALIL JR';
            break;
       case 101:
            $aprovador = 'RICARDO CALIL';
            break;
       case 100:
            $aprovador = 'VIRGÍNIA RIBEIRO';
            break;
        default:
            $aprovador = null;
            break;
    }

	$pagina = 
		"<html>
            <head>
                <style type='text/css'>
                    /* definimos o quão arredondado irá ficar nosso box */
                    img{
                        width:200px; 
                        height:50px;
                        border-radius: 100px;
                    }
                </style>
            </head>
			<body>
                <h1> <img src='_imagens/logo.png' />   <br/>
                 Simulador Damata</h1>
                <h4>Nº = $id </h4>
                <h4>NB = $nb - $nome</h4>
				<ul>
					<li>Vasilhame: $vasilhame</li>
					<li>Classe de Risco: $classe</li>
					<li>Situação de Documento: $docs</li>
                    <li>Inadimplência: $inad</li>
                    <li>Giro: $giro </li>
                    <li>Comodato: $comodato cxs</li>
                    <li>Total de Caixas Compra: $ttcompracxs cxs</li>
                    <li>Meta Giro: $meta cxs</li>
                    <li>Lacuna: $lacuna cxs</li>
                    <hr/>
                    <li>Quantidade Solicitada: $qtd cxs</li>
                    <li>Serasa: $serasa </li>
                    <li>Status Aprovação: $status </li>
                    <li>Motivo caso Reprovado: $motivo </li>
                    <li>Aprovador: $aprovador </li>
                    <li>Assinatura: $log </li>
				</ul>
			</body>
		</html>
		";

    $arquivo = "Simulador - $nb - $nome.pdf";

    $mpdf = new mPDF();
    $mpdf->WriteHTML($pagina);

    $mpdf->Output($arquivo, 'I');

    // I - Abre no navegador
    // F - Salva o arquivo no servido
    // D - Salva o arquivo no computador do usuário
?>
<?php endif;?>