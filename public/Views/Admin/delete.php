<?php
  include_once "../../Models/connection.php";
  session_start();

  if(isset($_GET["id"])) $id = $_GET["id"];

  // UNLINK USER OF PROGRAM
  if(isset($_GET['program'])){
		$sql = $dbConnection->query("DELETE FROM ambiente_virtual WHERE ID_Persona = $id AND ID_Materia =".$_GET["program"]);
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
  
	// DELETE ANNOUNCEMENT
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

	// TODO: DELETE GROUP (VALIDATIONS)
	if(isset($_GET['delete_group'])){
		$sql = $dbConnection->query("DELETE FROM ficha WHERE ID_Ficha = ".$_GET['delete_group']);
		header('Location: courses.php?message=deleted');
		exit(); 
	}

	// TODO: DELETE SUBJECT (VALIDATIONS)
	if(isset($_GET['delete_subject'])){
		$sql = $dbConnection->query("DELETE FROM materia WHERE ID_Materia = ".$_GET['delete_subject']);
		header('Location: courses.php?message=deleted');
		exit(); 
	}

	// REMOVE SUBJECT FROM COURSE
	if(isset($_GET['course-subject'])){
		$sql = $dbConnection->query("DELETE FROM curso WHERE ID_Ficha = ".$_GET['course-subject']." AND ID_Materia =".$_GET['subject']);
		header('Location: manage-course.php?course='.$_GET['course-subject'].'&message=deleted');
		exit(); 
	}
?>