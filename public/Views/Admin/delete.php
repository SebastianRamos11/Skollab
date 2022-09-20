<?php 

    if(!isset($_GET['id'])){
        header('Location: crud.php?message=error');
        exit();
    }

    include_once "../../Models/new-connection.php";
    $id = $_GET["id"];

    $sentencia = $bd->prepare("DELETE FROM publicacion where ID_Persona = ?;");
    $resultado = $sentencia->execute([$id]);

    $sentencia = $bd->prepare("DELETE FROM ambiente_virtual where ID_Persona = ?;");
    $resultado = $sentencia->execute([$id]);

    $sentencia = $bd->prepare("DELETE FROM persona where ID_Persona = ?;");
    $resultado = $sentencia->execute([$id]);

    if($resultado){
        header('Location: crud.php?message=deleted');
        exit(); 
    }
?>  