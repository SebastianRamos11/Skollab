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

if(!$_GET['recover-evidence']){
    if(file_exists($_FILES['file']['tmp_name'])){
        move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/evidences/'.$_FILES['file']['name']);
        $description = $_POST['description'];
        $date = date('Y-m-d');
        $url = '../file-store/evidences/'.$_FILES['file']['name'];
        $sql = $dbConnection->query("INSERT INTO evidencia (ID_Persona, ID_Actividad, descripcion, fecha, url) VALUES ('".$_SESSION['id']."', '".$activity."', '".$description."', '".$date."', '".$url."')");
        
        header('Location: activity.php?activity='.$activity.'&message=uploaded');
        exit();
    } else{
        header('Location: activity.php?activity='.$activity.'&message=error');
        exit();
    }
} else{
    if(file_exists($_FILES['file']['tmp_name'])){
            move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/evidences/'.$_FILES['file']['name']);
            $description = $_POST['description'];
            $date = date('Y-m-d');
            $url = '../file-store/evidences/'.$_FILES['file']['name'];
            $sql = $dbConnection->query("UPDATE evidencia SET url = '$url', descripcion = '$description', fecha = '$date', nivelada = 1 WHERE ID_Evidencia = ".$_GET['recover-evidence']);
            
            header('Location: activity.php?activity='.$activity.'&message=uploaded');
            exit();
    } else{
        header('Location: activity.php?activity='.$activity.'&message=error');
        exit();
    }
}


?>