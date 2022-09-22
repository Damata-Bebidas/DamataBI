<?php //api para pegar os dados
    require_once '../_model/urlDb.php';
    $url = new UrlBD();
    $url->iniciaAPI();
    $dsn = $url->getDsn();
    $username = $url->getUsername();
    $passwd = $url->getPasswd();
    try {
        $conexao = new \PDO($dsn, $username, $passwd);//cria conexão com banco de dadosX 
    } catch (\PDOException $ex) {
        die('Não foi possível estabelecer '
        . 'conexão com Banco de dados<br/>Erro Nº=> ' . $ex->getCode());
    }
    
    /* Esta é a maneira correta de se declarar uma superglobal */
    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    //verificar a rota post ou ger
    $REQUEST = (isset($post['w'])) ? filter_input_array(INPUT_POST, FILTER_DEFAULT) : filter_input_array(INPUT_GET, FILTER_DEFAULT);
    $option = (isset($REQUEST['w'])) ? base64_decode($REQUEST['w']) : false;
    switch ($option) {
        case 1:
            require_once '../_model/plano.php';
            $plano = new plano($conexao);
            $nome = "plano";
            $resultado = $plano->consult();
            break;
        case 2:
            require_once '../_model/treinar.php';
            $treinar = new treinar($conexao);
            $nome = "treinar";
            $resultado = $treinar->consult();
            break;
        case 3:
            require_once '../_model/treinamento.php';
            $treinamentos = new treinamento($conexao);
            $nome = "treinamento";
            $resultado = $treinamentos->consult();
            break;
        case 4:
            require_once '../_model/aplicabilidade.php';
            $aplic = new aplicabilidade($conexao);
            $nome = "aplicabilidade";
            $resultado = $aplic->consult();
            break;
        case 5:
            require_once '../_model/prova3e6meses.php';
            $prova = new prova3e6meses($conexao);
            $nome = "prova3e6meses";
            $resultado = $prova->consult();
            break;
        case 6:
            require_once '../_model/entrevista.php';
            $entrevista = new entrevista($conexao);
            $nome = "entrevista";
            $resultado = $entrevista->listar();
            break;
        case 7:
            require_once '../_model/medclin.php';
            $consulta = new medclin($conexao);
            $nome = "medclin";
            $resultado = $consulta->listar();
            break;
        case 8:
            require_once '../_model/checkResp.php';
            $consulta = new checkResp($conexao);
            $nome = "checkresp";
            $resultado = $consulta->consult();
            break;
        case 9:
            require_once '../_model/checkReacao.php';
            $consulta = new checkReacao($conexao);
            $nome = "checkreacao";
            $resultado = $consulta->consult();
            break;
        case 10:
            require_once '../_model/check.php';
            $consulta = new check($conexao);
            $nome = "check";
            $resultado = $consulta->consult();
            break;
        case 11:
            require_once '../_model/saneamento.php';
            $consulta = new saneamento($conexao);
            $nome = "saneamento";
            $resultado = $consulta->consult();
            break;
        case 99:
            require_once '../_model/pesquisaNPS.php';
            $consulta = new pesquisaNPS($conexao);
            $nome = "nps";
            $resultado = $consulta->consult();
            break;
        default:
            echo "Acesso Negado";
            break;
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firebase</title>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script language="javascript" type="text/javascript" src="https://www.gstatic.com/firebasejs/8.4.2/firebase-app.js"></script>
<script language="javascript" type="text/javascript" src="https://www.gstatic.com/firebasejs/8.4.2/firebase-database.js"></script>
<!-- TODO: Add SDKs for Firebase products that you want to use 
    https://firebase.google.com/docs/web/setup#available-libraries -->
<script language="javascript" type="text/javascript"  src="https://www.gstatic.com/firebasejs/8.4.2/firebase-analytics.js"></script>
<!-- Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional -->
<script language="javascript" type="text/javascript" src="../_javascript/firebase.js"></script>
<script type="text/javascript" language="javascript" >
    function list() {
        <?php echo "var refDB = firebase.database().ref('$nome'); /* ler os dados */"; ?>
        refDB.on('value', (snapshot) => {
                const data = snapshot.val();
                var texto = JSON.stringify(data);
                document.write(texto);
                return data;
            }
        );
    }
    function remover(no) {
        return firebase.database().ref().child(no).remove();//salvar dados   
    }
</script>
</head>
<body id ="corpo"; onload='<?php echo 'return list();';?>' >
<div id="resultado">
    <script>
        document.getElementById("resultado").innerHTML = "Firebase";
    </script>
</div>
</body>
</html>
<!-- Falta salvar o arquivo na pasta firebase --> 