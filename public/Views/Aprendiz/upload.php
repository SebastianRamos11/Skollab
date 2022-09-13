<?php
include_once "../../Models/connection.php";
session_start();
$evidence = $_GET['evidence'];

if(!$evidence){
    header('Location: aprendiz.php');
    exit();
}

// Empty data
if(empty($_FILES['file']['name'])){
    header('Location: evidence.php?evidence='.$evidence.'&message=empty');
    exit();
}

if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/evidences/'.$_FILES['file']['name'])){
            
            $description = $_POST['description'];
            $date = $_POST['date'];
            $url = '../file-store/evidences/'.$_FILES['file']['name'];
            $sql = $dbConnection->query("INSERT INTO evidencia (ID_Persona, ID_Publicacion, descripcion, fecha, url) VALUES ('".$_SESSION['id']."', '".$evidence."', '".$description."', '".$date."', '".$url."')");
            
            header('Location: turned-evidence.php?evidence='.$evidence.'&message=updated');
            exit();
        }else{
            header('Location: evidence.php?evidence='.$evidence.'&message=error');
            exit();
        }
    }else{
        header('Location: evidence.php?evidence='.$evidence.'&message=error');
        exit();
    }
}


?>