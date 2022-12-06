<?php
  require('connection.php');

  if (isset($_REQUEST['recover-submited'])) {
		$email = $_POST["email"];
		$doc_num = $_POST["id"];
		$pass = $_POST["pass"];
		$pass = hash('sha512', $pass);

    $confirm_query = "SELECT correo_electronico, num_documento FROM persona WHERE correo_electronico = '$email' AND num_documento = '$doc_num'";
    $confirm_result = mysqli_query($dbConnection, $confirm_query) or die(mysqli_errno($dbConnection));
    $confirm_array = mysqli_fetch_all($confirm_result);

    $recover_query = "UPDATE persona SET contraseña = '$pass' WHERE correo_electronico = '$email' AND num_documento = '$doc_num'";
    $query_result = mysqli_query($dbConnection, $recover_query) or die(mysqli_error($dbConnection));

    if ($confirm_array == null) {
      header('Location: ../Views/recover-pass.php?message=unknow');
      exit(); 
    } else if ($confirm_array[0][0] === $email && $confirm_array[0][1] === $doc_num) {
        header('Location: ../Views/login.php?message=recovered');
        exit;   
    }
  }
?>
