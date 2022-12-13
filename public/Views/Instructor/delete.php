<?php
  include_once "../../Models/connection.php";
  session_start();
  include_once "../validations.php";

  $activity = $_GET['activity'];
   
  if(!$activity){
    header('Location: ../main.php');
    exit();
  }

  $delete_evidences = $dbConnection->query("DELETE FROM evidencia WHERE ID_Actividad = $activity");
  $delete_activity = $dbConnection->query("DELETE FROM actividad WHERE ID_Actividad = $activity");

  header('Location: activities.php?group='.$group.'&message=deleted');
  exit();
?>