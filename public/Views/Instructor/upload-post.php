<?php
include_once "../../Models/connection.php";
session_start();

if(empty($_POST["subject"]) || (empty($_POST["group"]) && $_POST["group"] == 0) || empty($_POST["type"]) || empty($_POST["date"]) || empty($_POST["due-date"])){
    header('Location: publications.php?message=empty');
    exit();
}

if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/publications/'.$_FILES['file']['name'])){

            $subject = $_POST['subject'];
            $group = $_POST['group'];
            $description = $_POST['description'];
            $type = $_POST['type'];
            $date = $_POST['date'];
            $due_date = $_POST['due-date'];
            $url = '../file-store/publications/'.$_FILES['file']['name'];
            $sql = $dbConnection->query("INSERT INTO publicacion (ID_Persona, ID_Ficha, asunto, descripcion,fecha, fecha_limite, tipo_publicacion, url) VALUES ('".$_SESSION['id']."', '".$group."', '".$subject."', '".$description."','".$date."', '".$due_date."', '".$type."', '".$url."')");
            
            header('Location: publications.php?message=updated');
            exit();
        }else{
            header('Location: publications.php?message=error');
            exit();
        }
    }else{
        $subject = $_POST['subject'];
        $group = $_POST['group'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $date = $_POST['date'];
        $due_date = $_POST['due-date'];
        $sql = $dbConnection->query("INSERT INTO publicacion (ID_Persona, ID_Ficha, asunto, descripcion,fecha, fecha_limite, tipo_publicacion) VALUES ('".$_SESSION['id']."', '".$group."', '".$subject."', '".$description."','".$date."', '".$due_date."', '".$type."')");

        header('Location: publications.php?message=updated');
        exit();
    }
}
?>