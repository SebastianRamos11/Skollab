<?php
include_once "../../Models/connection.php";
session_start();

if(empty($_POST["subject"]) || empty($_POST["description"])){
    header('Location: announcements.php?message=empty');
    exit();
}

if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])){
            
        move_uploaded_file($_FILES['image']['tmp_name'], '../file-store/announcements/'.$_FILES['image']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/announcements/'.$_FILES['file']['name']);

        $subject = $_POST['subject'];
        $description = $_POST['description'];
        $date = date('Y-m-d');
        $url_file = '../file-store/announcements/'.$_FILES['file']['name'];
        $url_image = '../file-store/announcements/'.$_FILES['image']['name'];

        $sql = $dbConnection->query("INSERT INTO anuncio (ID_Persona, asunto, descripcion, fecha, url_portada, url_file) VALUES ('".$_SESSION['id']."', '".$subject."', '".$description."','".$date."', '".$url_image."', '".$url_file."')");
        header('Location: announcements.php?message=uploaded');
        exit();

    } else if(file_exists($_FILES['file']['tmp_name']) && !file_exists($_FILES['image']['tmp_name'])){

        move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/announcements/'.$_FILES['file']['name']); 
        $subject = $_POST['subject'];
        $description = $_POST['description'];
        $date = date('Y-m-d');
        $url_file = '../file-store/announcements/'.$_FILES['file']['name'];

        $sql = $dbConnection->query("INSERT INTO anuncio (ID_Persona, asunto, descripcion, fecha, url_file) VALUES ('".$_SESSION['id']."', '".$subject."', '".$description."','".$date."', '".$url_file."')");
        header('Location: announcements.php?message=uploaded');
        exit();

    } else if(!file_exists($_FILES['file']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])){

        move_uploaded_file($_FILES['image']['tmp_name'], '../file-store/announcements/'.$_FILES['image']['name']);
        $subject = $_POST['subject'];
        $description = $_POST['description'];
        $date = date('Y-m-d');
        $url_image = '../file-store/announcements/'.$_FILES['image']['name'];

        $sql = $dbConnection->query("INSERT INTO anuncio (ID_Persona, asunto, descripcion, fecha, url_portada) VALUES ('".$_SESSION['id']."', '".$subject."', '".$description."','".$date."', '".$url_image."')");
        header('Location: announcements.php?message=uploaded');
        exit();
        
    } else{
        $subject = $_POST['subject'];
        $description = $_POST['description'];
        $date = date('Y-m-d');

        $sql = $dbConnection->query("INSERT INTO anuncio (ID_Persona, asunto, descripcion, fecha) VALUES ('".$_SESSION['id']."', '".$subject."', '".$description."','".$date."')");
        header('Location: announcements.php?message=uploaded');
        exit();

    }
}

?>