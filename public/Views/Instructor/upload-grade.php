<?php
	include_once "../../Models/connection.php";
	session_start();

	$evidence = $_GET["evidence"];
	$activity = $_GET["activity"];

	if(empty($_POST["calification"])){
	  header('Location: evidence.php?evidence='.$evidence.'&message=empty');
	  exit();
	}

	$calification = $_POST["calification"];
	$observation = $_POST["observation"];

	$edit_query = "UPDATE evidencia SET nota = $calification, observacion = '$observation', nivelada = 0 WHERE ID_Evidencia = $evidence";
	$query_result = mysqli_query($dbConnection, $edit_query) or die(mysqli_error($dbConnection));

	if($query_result){
	  header('Location: deliveries.php?activity='.$activity.'&message=qualified');
	  exit();
	}else{
	  header('Location: deliveries.php?activity='.$activity.'&message=error');
	  exit();
	}
?>