<?php   
    if(!isset($_POST['id'])){
        header('Location: profile.php?message=error');
        exit();
    }
    if(empty($_POST["id"]) || empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($_POST["birthYear"]) || empty($_POST["phone"]) || empty($_POST["email"])){
        header('Location: profile.php?message=empty');
        exit();
    }

    include_once "../../Models/new-connection.php";

    $id = $_POST["id"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $birthYear = $_POST["birthYear"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    $edit_query = $bd -> prepare("UPDATE persona SET nombres = ?, apellidos = ?, fecha_nacimiento = ?, correo_electronico = ?, telefono = ? WHERE ID_Persona = ?;");
    $query_result = $edit_query -> execute([$firstName, $lastName, $birthYear, $email, $phone, $id]);

    if($query_result){
        header('Location: profile.php?message=updated');
        exit();
    }
?>