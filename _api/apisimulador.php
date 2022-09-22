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
    
    require_once '../_model/analisesimulador.php';
    $simulador = new analisesimulador($conexao);
    $data = date('Y-m-d');
    $data = date('Y-m-d', strtotime('-1 days', strtotime($data)));
    $resultado = $simulador->consultData($data);
    
    foreach ($resultado as $key => $value) {
        foreach ($value as $key2 => $value2) {
            if ($key2=="simulador") {
                $id = $value2;
                $simuladorConfig = $simulador->findIdSimulador($id);
                $classerisco = $simuladorConfig['classerisco']; 
                $docs = $simuladorConfig['docs'] ;
                $inad = $simuladorConfig['inad']; 
                $giro = $simuladorConfig['giro'];
                $comodato = $simuladorConfig['comodato'];
                $ttcompracxs = $simuladorConfig['ttcompracxs'];
                $idsimulador = $value['id'];
                
                $simulador->alterarApiSimulador($classerisco, $docs, $inad, $giro, 
                        $comodato, $ttcompracxs, $idsimulador);            
            }
        }
    }
    $json = array(array($data));
    echo json_encode($json,JSON_PRETTY_PRINT);