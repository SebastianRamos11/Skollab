<?php
include_once "../../Models/connection.php";
session_start();
$activity = $_GET['activity'];

if(!$activity){
    header('Location: aprendiz.php');
    exit();
}

// Empty data
if(empty($_FILES['file']['name'])){
    header('Location: activity.php?activity='.$activity.'&message=empty');
    exit();
}

if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/evidences/'.$_FILES['file']['name'])){
            
            $description = $_POST['description'];
            $date = date('Y-m-d');
            $url = '../file-store/evidences/'.$_FILES['file']['name'];
            $sql = $dbConnection->query("INSERT INTO evidencia (ID_Persona, ID_Actividad, descripcion, fecha, url) VALUES ('".$_SESSION['id']."', '".$activity."', '".$description."', '".$date."', '".$url."')");
            
            header('Location: activity.php?activity='.$activity.'&message=updated');
            exit();
        }else{
            header('Location: activity.php?activity='.$activity.'&message=error');
            exit();
        }
    }else{
        header('Location: activity.php?activity='.$activity.'&message=error');
        exit();
    }
}


?>