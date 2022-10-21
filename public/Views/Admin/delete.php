<?php 

    if(!isset($_GET['id'])){
        header('Location: crud.php?message=error');
        exit();
    }

    include_once "../../Models/new-connection.php";
    $id = $_GET["id"];
    
    // UNLINK USER OF PROGRAM
    if(isset($_GET['program'])){
        $sentencia = $bd->prepare("DELETE FROM ambiente_virtual where ID_Persona = ? and ID_Programa = ?;");
        $resultado = $sentencia->execute([$id, $_GET['program']]);
        if($resultado){
            header('Location: view-user.php?user='.$id.'&message=unlinked');
            exit(); 
        }
    }

    // DELETE ALL USER DATA
    if(isset($_GET['delete_user'])){
        $sentencia = $bd->prepare("DELETE FROM actividad where ID_Persona = ?;");
        $resultado = $sentencia->execute([$id]);
    
        $sentencia = $bd->prepare("DELETE FROM ambiente_virtual where ID_Persona = ?;");
        $resultado = $sentencia->execute([$id]);
    
        $sentencia = $bd->prepare("DELETE FROM persona where ID_Persona = ?;");
        $resultado = $sentencia->execute([$id]);

        if($resultado){
            header('Location: crud.php?message=deleted');
            exit(); 
        }
    }
    
    // DELETE USER'S EVIDENCES
    if(isset($_GET['delete_evidence'])){
        $sentencia = $bd->prepare("DELETE FROM evidencia where ID_Persona = ? and ID_Evidencia = ?;");
        $resultado = $sentencia->execute([$id, $_GET['delete_evidence']]);
        if($resultado){
            header('Location: view-user.php?user='.$id.'&message=evidence_deleted');
            exit(); 
        }  
    }

    // DELETE USER'S activities
    if(isset($_GET['delete_activity'])){
        $sentencia = $bd->prepare("DELETE FROM evidencia where ID_Actividad = ?;");
        $resultado = $sentencia->execute([$_GET['delete_activity']]);

        $sentencia = $bd->prepare("DELETE FROM actividad where ID_Persona = ? and ID_Actividad = ?;");
        $resultado = $sentencia->execute([$id, $_GET['delete_activity']]);
        
        if($resultado){
            header('Location: view-user.php?user='.$id.'&message=activity_deleted');
            exit(); 
        }  
    }
    

?>