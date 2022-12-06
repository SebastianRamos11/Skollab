<?php 
  include_once "../../Models/connection.php";
  session_start();

  if(isset($_GET["user"])){
    $id_user = $_GET["user"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $rol = $_POST["rol"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $doc_type = $_POST["doc-type"];
    
		$edit_query = "UPDATE persona SET nombres = '$firstName', apellidos = '$lastName', ID_Rol = $rol, telefono = $phone, correo_electronico = '$email', ID_Tipo_Documento = $doc_type WHERE ID_Persona = $id_user;";
    $query_result = mysqli_query($dbConnection, $edit_query) or die(mysqli_error($dbConnection));
		
		header('Location: crud.php?message=modified');
		exit();
  }

  if(isset($_GET["announcement"])){
		$id_announcement = $_GET["announcement"];

		if(file_exists($_FILES['file']['tmp_name'])){
			move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/announcements/'.$_FILES['file']['name']);
			$subject = $_POST['subject'];
			$description = $_POST['description'];
			$date = date('Y-m-d');
			$url_file = '../file-store/announcements/'.$_FILES['file']['name'];

			$edit_query = "UPDATE anuncio SET asunto = '$subject', descripcion = '$description', fecha = $date, url_file = '$url_file' WHERE ID_Anuncio = $id_announcement;";
			$query_result = mysqli_query($dbConnection, $edit_query) or die(mysqli_error($dbConnection));

			header('Location: admin.php?message=updated');
			exit();
		} else{
			$subject = $_POST['subject'];
			$description = $_POST['description'];
			$date = date('Y-m-d');
	
			$edit_query = "UPDATE anuncio SET asunto = '$subject', descripcion = '$description', fecha = $date WHERE ID_Anuncio = $id_announcement;";
			$query_result = mysqli_query($dbConnection, $edit_query) or die(mysqli_error($dbConnection));
	
			header('Location: admin.php?message=updated');
			exit();
		}
  }
?>