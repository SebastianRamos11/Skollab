<?php
	include_once "../Models/connection.php";
  session_start();

  if(isset($_GET['course']) && isset($_SESSION['id'])){
    $id_course = $_GET['course'];
    $id_student = $_SESSION['id'];

    $validation_query = "SELECT * FROM ambiente_virtual WHERE ID_Persona = $id_student AND ID_Ficha = $id_course";
    $validation_result = mysqli_query($dbConnection, $validation_query);

    if ($validation_result -> num_rows > 0) {
			header('Location: main.php?message=already-registered');
			exit();	
    } else {
      $inscription = $dbConnection->query("INSERT INTO ambiente_virtual (ID_Persona, ID_Ficha) VALUES ('$id_student', '$id_course')");
      header('Location: main.php?message=registered');
      exit();
    }

  } else{
    header('Location: main.php?message=error');
    exit();
  }
?>