<?php
  include_once "../../Models/connection.php";
  session_start();
  $evidence = $_GET['evidence'];
   
  if(!$evidence){
    header('Location: aprendiz.php');
    exit();
  }

  $validate_evidence = "SELECT nota, ID_Actividad FROM `evidencia` WHERE ID_Evidencia = $evidence";
  $validate_result = mysqli_query($dbConnection, $validate_evidence) or die(mysqli_error($dbConnection));
  $validate_evidence = mysqli_fetch_all($validate_result, MYSQLI_NUM);

  if(empty($validate_evidence[0][0])){
    $sql = $dbConnection->query("DELETE FROM evidencia WHERE ID_Evidencia = $evidence");

    if(isset($_GET['b'])){
      header('Location: briefcase.php?message=deleted');
    } else {
      header('Location: activity.php?activity='.$validate_evidence[0][1].'&message=deleted');
      exit(); 
    }
  } else{
    header('Location: briefcase.php?message=error');
    exit(); 
  }
?>