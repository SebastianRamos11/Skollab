<?php 

    include_once "../../Models/new-connection.php";

    if(isset($_GET["user"])){
        $id_user = $_GET["user"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $birthYear = $_POST["birthYear"];
        $rol = $_POST["rol"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $doc_type = $_POST["doc-type"];
    
        $edit_query = $bd -> prepare("UPDATE persona SET nombres = ?, apellidos = ?, fecha_nacimiento = ?, ID_Rol = ?, telefono = ?, correo_electronico = ?, ID_Tipo_Documento = ? WHERE ID_Persona = ?;");
        $query_result = $edit_query -> execute([$firstName, $lastName, $birthYear, $rol, $phone, $email, $doc_type, $id_user]);
    
        if($query_result){
            header('Location: crud.php?message=modified');
            exit();
        }
    }

    if(isset($_GET["announcement"])){

        $id_announcement = $_GET["announcement"];

        if(file_exists($_FILES['file']['tmp_name'])){
            move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/announcements/'.$_FILES['file']['name']);
            $subject = $_POST['subject'];
            $description = $_POST['description'];
            $date = date('Y-m-d');
            $url_file = '../file-store/announcements/'.$_FILES['file']['name'];
    
            $edit_query = $bd -> prepare("UPDATE anuncio SET asunto = ?, descripcion = ?, fecha = ?, url_file = ? WHERE ID_Anuncio = ?;");
            $query_result = $edit_query -> execute([$subject, $description, $date, $url_file, $id_announcement]);

            header('Location: admin.php?message=updated');
            exit();
            
        } else{
            $subject = $_POST['subject'];
            $description = $_POST['description'];
            $date = date('Y-m-d');
    
            $edit_query = $bd -> prepare("UPDATE anuncio SET asunto = ?, descripcion = ?, fecha = ? WHERE ID_Anuncio = ?;");
            $query_result = $edit_query -> execute([$subject, $description, $date, $id_announcement]);

            header('Location: admin.php?message=updated');
            exit();
        }
    }

?>