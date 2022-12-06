<?php   
  include_once "../Models/connection.php";
  session_start();

  if(!isset($_GET['id'])){
    header('Location: profile.php?message=error');
    exit();
  }
  if(empty($_GET["id"]) || empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($_POST["phone"]) || empty($_POST["email"])){
    header('Location: profile.php?message=empty');
    exit();
  }

  $id = $_GET["id"];
  $doc_type = $_POST["doc-type"];
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];

  $edit_query = "UPDATE persona SET ID_Tipo_Documento = '$doc_type', nombres = '$firstName', apellidos = '$lastName', correo_electronico = '$email', telefono = '$phone' WHERE ID_Persona = '$id';";
	$query_result = mysqli_query($dbConnection, $edit_query) or die(mysqli_error($dbConnection));

  if($query_result){
    header('Location: profile.php?message=updated');
    exit();
  }
?>