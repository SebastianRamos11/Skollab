<?php
  if(empty($_POST["id"]) || empty($_POST["doc-type"]) || empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($_POST["birthYear"]) || empty($_POST["phone"]) || empty($_POST["rol"]) || empty($_POST["email"]) || empty($_POST["pass"])){
    header('Location: crud.php?message=empty');
    exit();
  }

  include_once "../../Models/new-connection.php";
  require('../../Models/connection.php');

  $doc_num = $_POST["id"];
  $doc_type = $_POST["doc-type"];
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $birthYear = $_POST["birthYear"];
  $phone = $_POST["phone"];
  $rol = $_POST["rol"];
  $email = $_POST["email"];
  $pass = $_POST["pass"];
  $pass = hash('sha512', $pass);
    
  $validation_query = "SELECT * FROM persona WHERE (num_documento = '$doc_num' && ID_Tipo_Documento = $doc_type) || correo_electronico = '$email' || telefono = '$phone'";
  $validation_result = mysqli_query($dbConnection, $validation_query);

  if ($validation_result -> num_rows > 0) {
    header('Location: crud.php?message=already-registered');
    exit();
  } else {
    $create_query = $bd -> prepare("INSERT INTO persona(ID_Rol, ID_Tipo_Documento, num_documento, nombres, apellidos, fecha_nacimiento, correo_electronico, contraseña, telefono) VALUES (?,?,?,?,?,?,?,?,?);");
    $create_result = $create_query -> execute([$rol, $doc_type, $doc_num, $firstName, $lastName, $birthYear, $email, $pass, $phone]);

    if($create_result){
      header('Location: crud.php?message=created');
      exit();
    }
  }
?>