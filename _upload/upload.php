<?php 
    ob_start();//inicio da sessao 
    session_start();//inicio da sessao 
    if(isset($_SESSION['emails'])){    
    }else {
        header("Location: login.php?acesso='logar'");exit;
    } 
?>
<?php 
/*pasta que vc deseja salvar o arquivo*/
$uploaddir = 'upload';

$uploadfile = $uploaddir . $_FILES['arquivo']['name'];

if(move_uploaded_file($_FILES['arquivo']['tmp_name'],$uploadfile)){
    header("Location: ../upload.php?upload=true");exit;
}else {
    header("Location: ../upload.php?nupload=false");exit;
}
?>