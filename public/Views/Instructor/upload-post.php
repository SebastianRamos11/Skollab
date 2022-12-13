<?php
include_once "../../Models/connection.php";
session_start();
include_once "../validations.php";


if(empty($_POST["subject"]) || (empty($_POST["group"]) && $_POST["group"] == 0) || empty($_POST["due-date"])){
    header('Location: activities.php?group='.$group.'&message=empty');
    exit();
}

if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/activities/'.$_FILES['file']['name'])){

            $subject = $_POST['subject'];
            $group = $_POST['group'];
            $description = $_POST['description'];
            $date = date('Y-m-d');
            $due_date = $_POST['due-date'];
            $url = '../file-store/activities/'.$_FILES['file']['name'];
            $sql = $dbConnection->query("INSERT INTO actividad (ID_Persona, ID_Ficha, asunto, descripcion,fecha, fecha_limite, url) VALUES ('".$_SESSION['id']."', '".$group."', '".$subject."', '".$description."','".$date."', '".$due_date."', '".$url."')");
            
            header('Location: activities.php?group='.$group.'&message=created');
            exit();
        }else{
            header('Location: activities.php?group='.$group.'&message=error');
            exit();
        }
    }else{
        $subject = $_POST['subject'];
        $group = $_POST['group'];
        $description = $_POST['description'];
        $date = date('Y-m-d');
        $due_date = $_POST['due-date'];
        $sql = $dbConnection->query("INSERT INTO actividad (ID_Persona, ID_Ficha, asunto, descripcion,fecha, fecha_limite) VALUES ('".$_SESSION['id']."', '".$group."', '".$subject."', '".$description."','".$date."', '".$due_date."')");

        header('Location: activities.php?group='.$group.'&message=created');
        exit();
    }
}
?>