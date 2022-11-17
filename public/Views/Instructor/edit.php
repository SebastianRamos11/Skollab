<?php
  include_once "../../Models/connection.php";
  session_start();

  $id_activity = $_GET['activity'];

  if(isset($_POST["subject"]) && isset($_POST["description"]) && isset($_POST["due-date"])){
    if(!empty($_FILES['file']['name'])){
      if(move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/activities/'.$_FILES['file']['name'])){
        $subject = $_POST['subject'];
        $description = $_POST['description'];
        $date = date('Y-m-d');
        $due_date = $_POST['due-date'];
        $url = '../file-store/activities/'.$_FILES['file']['name'];
        $sql = $dbConnection->query("UPDATE actividad SET asunto = '$subject', descripcion = '$description', fecha = '$date', fecha_limite = '$due_date', url='$url' WHERE ID_Actividad = $id_activity");

        header('Location: activities.php?message=updated');
        exit();
      }else{
        header('Location: activities.php?message=error');
        exit();
      }
    } else{
      $subject = $_POST['subject'];
      $description = $_POST['description'];
      $date = date('Y-m-d');
      $due_date = $_POST['due-date'];
      $sql = $dbConnection->query("UPDATE actividad SET asunto = '$subject', descripcion = '$description', fecha = '$date', fecha_limite = '$due_date' WHERE ID_Actividad = $id_activity");

      header('Location: activities.php?message=updated');
      exit();    
    }
  } else {
    header('Location: activities.php?message=error');
    exit();
  }
?>