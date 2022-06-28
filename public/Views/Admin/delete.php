<?php 

    if(!isset($_GET['id'])){
        header('Location: main.php?message=error');
        exit();
    }

    include_once "../../Models/new-connection.php";
    $id = $_GET["id"];

    $sentencia = $bd->prepare("DELETE FROM persona where ID_Persona = ?;");
    $resultado = $sentencia->execute([$id]);

    if($resultado){
        header('Location: main.php?message=deleted');
        exit(); 
    }
?>  