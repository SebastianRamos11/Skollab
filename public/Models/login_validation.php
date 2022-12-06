<?php
  require('connection.php');
  
  if (isset($_POST['login'])) {
		$email = $_POST["email"];
		$pass = $_POST["pass"];
    $pass = hash('sha512', $pass);

    $login_query = "SELECT ID_Persona, ID_Rol FROM persona WHERE correo_electronico = '$email' AND contraseña = '$pass'";
    $query_result = mysqli_query($dbConnection, $login_query) or die(mysqli_error($dbConnection));
    $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);
    
    $row = mysqli_num_rows($query_result);
    if ($row == 1) {
      session_start();
      $_SESSION['id'] = $result_array[0][0];
      
      if ($result_array[0][1] == 1) {
        header('Location: ../Views/Admin/admin.php');
      } elseif ($result_array[0][1] == 2) {
        header('Location: ../Views/Instructor/instructor.php');
      } elseif ($result_array[0][1] == 3) {
        header('Location: ../Views/Aprendiz/aprendiz.php');
      }

    } else {
      header('Location: ../Views/login.php?message=error');
      exit();
    }
  }
?>