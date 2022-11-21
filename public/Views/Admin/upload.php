<?php
include_once "../../Models/connection.php";
session_start();

if(empty($_POST["subject"]) || empty($_POST["description"])){
    header('Location: announcements.php?message=empty');
    exit();
}

// TODO: Multiple file validations
if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/announcements/'.$_FILES['file']['name'])){
            $subject = $_POST['subject'];
            $description = $_POST['description'];
            $date = date('Y-m-d');
            $url_file = '../file-store/announcements/'.$_FILES['file']['name'];
            $url_image = '../file-store/announcements/'.$_FILES['image']['name'];
            print_r("Título: " . $subject . "<br>");
            print_r("Descripción: " . $description . "<br>");
            print_r("FILE: " . $url_file . "<br>");
            print_r("IMAGE: " . $url_image . "<br>");
            print_r("DATE: " . $date . "<br>");

            
            // $sql = $dbConnection->query("INSERT INTO anuncio (ID_Persona, asunto, descripcion, fecha, tipo_publicacion, url) VALUES ('".$_SESSION['id']."', '".$group."', '".$subject."', '".$description."','".$date."', '".$due_date."', '".$type."', '".$url."')");
            
            // header('Location: activities.php?message=uploaded');
            // exit();
        }else{
            header('Location: announcements.php?message=error');
            exit();
        }
    } else{
        $subject = $_POST['subject'];
        $description = $_POST['description'];
        $date = date('Y-m-d');

        // print_r("Título: " . $subject . "<br>");
        // print_r("Descripción: " . $description . "<br>");
        // print_r("DATE: " . $date . "<br>");

    }
}
?>