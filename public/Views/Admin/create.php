<?php
    
    if(empty($_POST["id"]) || empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($_POST["birthYear"]) || empty($_POST["rol"]) || empty($_POST["phone"]) || empty($_POST["email"]) || empty($_POST["pass"])){
        header('Location: main.php?message=empty');
        exit();
    }

    include_once "../../Models/new-connection.php";

    $id = $_POST["id"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $birthYear = $_POST["birthYear"];
    $rol = $_POST["rol"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    $create_query = $bd -> prepare("INSERT INTO persona(ID_Persona, nombres, apellidos, fecha_nacimiento, rol, correo_electronico, contraseña, telefono) VALUES (?,?,?,?,?,?,?,?);");
    $query_result = $create_query -> execute([$id, $firstName, $lastName, $birthYear, $rol, $email, $pass, $phone]);

    if($query_result){
        header('Location: main.php?message=created');
        exit();
    }

?>
