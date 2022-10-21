<?php
include_once "../../Models/connection.php";
session_start();

if(empty($_POST["subject"]) || empty($_POST["description"]) || empty($_FILES['file']['name'])){
    header('Location: announcements.php?message=empty');
    exit();
}

if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/announcements/'.$_FILES['file']['name'])){

            $subject = $_POST['subject'];
            $description = $_POST['description'];
            $date = date('Y-m-d');
            $url = '../file-store/announcements/'.$_FILES['file']['name'];
            print_r("Título: " . $subject . "<br>");
            print_r("Descripción: " . $description . "<br>");
            print_r("URL: " . $url . "<br>");
            print_r("DATE: " . $date . "<br>");

            
            // TODO: Announcements upload
            // $sql = $dbConnection->query("INSERT INTO publicacion (ID_Persona, ID_Ficha, asunto, descripcion,fecha, fecha_limite, tipo_publicacion, url) VALUES ('".$_SESSION['id']."', '".$group."', '".$subject."', '".$description."','".$date."', '".$due_date."', '".$type."', '".$url."')");
            
            // header('Location: activities.php?message=updated');
            // exit();
        }else{
            header('Location: announcements.php?message=error');
            exit();
        }
    }
}
?>