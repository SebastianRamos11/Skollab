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

    // DELETE USER'S PUBLICATIONS
    if(isset($_GET['delete_publication'])){
        $sentencia = $bd->prepare("DELETE FROM evidencia where ID_Publicacion = ?;");
        $resultado = $sentencia->execute([$_GET['delete_publication']]);

        $sentencia = $bd->prepare("DELETE FROM publicacion where ID_Persona = ? and ID_Publicacion = ?;");
        $resultado = $sentencia->execute([$id, $_GET['delete_publication']]);
        
        if($resultado){
            header('Location: view-user.php?user='.$id.'&message=publication_deleted');
            exit(); 
        }  
    }
    

?>