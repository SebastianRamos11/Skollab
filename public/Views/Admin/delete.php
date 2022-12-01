<?php
  include_once "../../Models/connection.php";
  session_start();

  $id = $_GET["id"];

  // UNLINK USER OF PROGRAM
  if(isset($_GET['program'])){
		$sql = $dbConnection->query("DELETE FROM ambiente_virtual WHERE ID_Persona = $id AND ID_Programa =".$_GET["program"]);
		header('Location: view-user.php?user='.$id.'&message=unlinked');
		exit();
  }

  // DELETE ALL USER DATA
  if(isset($_GET['delete_user'])){
		$sql = $dbConnection->query("DELETE FROM actividad WHERE ID_Persona = $id");
		$sql = $dbConnection->query("DELETE FROM ambiente_virtual WHERE ID_Persona = $id");
		$sql = $dbConnection->query("DELETE FROM persona WHERE ID_Persona = $id");
  
		header('Location: crud.php?message=deleted');
		exit();
  }
  
  // DELETE USER'S EVIDENCES
  if(isset($_GET['delete_evidence'])){
		$sql = $dbConnection->query("DELETE FROM evidencia WHERE ID_Persona = $id AND ID_Evidencia =".$_GET['delete_evidence']);
		header('Location: view-user.php?user='.$id.'&message=evidence_deleted');
		exit(); 
  }

  // DELETE USER'S ACTIVITIES
  if(isset($_GET['delete_activity'])){
		$sql = $dbConnection->query("DELETE FROM evidencia WHERE ID_Actividad =".$_GET['delete_activity']);
		$sql = $dbConnection->query("DELETE FROM actividad WHERE ID_Persona = $id AND ID_Actividad =".$_GET['delete_activity']);

		header('Location: view-user.php?user='.$id.'&message=activity_deleted');
		exit(); 
  }
  
  if(isset($_GET['delete_announcement'])){
		$sql = $dbConnection->query("DELETE FROM anuncio WHERE ID_Anuncio =".$_GET['delete_announcement']);
		if(isset($_GET['id'])){
			header('Location: view-user.php?user='.$id.'&message=announcement_deleted');
			exit(); 
		} else{
			header('Location: admin.php?message=deleted');
			exit(); 
		}
  }
?>