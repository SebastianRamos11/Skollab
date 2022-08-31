<?php
include_once "../../Models/connection.php";
include_once "../../Models/session.php";

if(empty($_POST["subject"]) || (empty($_POST["group"]) && $_POST["group"] == 0) || empty($_POST["type"]) || empty($_POST["date"])){
    header('Location: publications.php?message=empty');
    exit();
}

if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/'.$_FILES['file']['name'])){

            $subject = $_POST['subject'];
            $group = $_POST['group'];
            $description = $_POST['description'];
            $type = $_POST['type'];
            $date = $_POST['date'];
            $url = '../file-store/'.$_FILES['file']['name'];
            $sql = $dbConnection->query("INSERT INTO publicacion (ID_Persona, ID_Ficha, asunto,descripcion,fecha,tipo_publicacion,url) VALUES ('".$session."', '".$group."', '".$subject."', '".$description."','".$date."', '".$type."', '".$url."')");
            
            header('Location: publications.php?message=updated');
            exit();
        }else{
            header('Location: publications.php?message=error');
            exit();
        }
    }else{
        header('Location: publications.php?message=error');
        exit();
    }
}
?>