<?php
  require('connection.php');
  if (isset($_REQUEST['signup-submited'])) {
		$doc_num = $_POST["id"];
		$doc_type = $_POST["doc-type"];
		$firstName = $_POST["firstName"];
		$lastName = $_POST["lastName"];
		$phone = $_POST["phone"];
		$rol = $_POST["rol"];
		$email = $_POST["email"];
		$pass = $_POST["pass"];
		$pass = hash('sha512', $pass);

    $validation_query = "SELECT * FROM persona WHERE (num_documento = '$doc_num' && ID_Tipo_Documento = $doc_type) || correo_electronico = '$email' || telefono = '$phone'";
    $validation_result = mysqli_query($dbConnection, $validation_query);

    if ($validation_result -> num_rows > 0) {
			header('Location: ../Views/login.php?message=already-registered');
			exit();	
    } else {
			$create_query = $dbConnection->query("INSERT INTO persona (ID_Rol, ID_Tipo_Documento, num_documento, nombres, apellidos, correo_electronico, contraseña, telefono ) VALUES ('".$rol."', '".$doc_type."', '".$doc_num."','".$firstName."', '".$lastName."', '".$email."', '".$pass."', '".$phone."')");
			header('Location: ../Views/login.php?message=registered');
			exit();		
    }
  }
?>
