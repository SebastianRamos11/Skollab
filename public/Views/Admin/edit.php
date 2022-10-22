<?php 
    if(!isset($_GET['id'])){
        header('Location: crud.php?message=error');
        exit();
    }
    
    include_once "../../Models/new-connection.php";

    $id = $_GET["id"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $birthYear = $_POST["birthYear"];
    $rol = $_POST["rol"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $doc_type = $_POST["doc-type"];

    $edit_query = $bd -> prepare("UPDATE persona SET nombres = ?, apellidos = ?, fecha_nacimiento = ?, ID_Rol = ?, telefono = ?, correo_electronico = ?, ID_Tipo_Documento = ? WHERE ID_Persona = ?;");
    $query_result = $edit_query -> execute([$firstName, $lastName, $birthYear, $rol, $phone, $email, $doc_type, $id]);

    if($query_result){
        header('Location: crud.php?message=modified');
        exit();
    }

?>