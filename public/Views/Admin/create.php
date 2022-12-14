<?php
	include_once "../../Models/connection.php";
  session_start();

  // TODO: Unified create.php and upload.php

  // USER CREATION
  if(isset($_GET['user'])){
    if(empty($_POST["id"]) || empty($_POST["doc-type"]) || empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($_POST["phone"]) || empty($_POST["rol"]) || empty($_POST["email"]) || empty($_POST["pass"])){
      header('Location: crud.php?message=empty');
      exit();
    }
  
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
      header('Location: crud.php?message=already-registered');
      exit();
    } else {
      $create_query = $dbConnection->query("INSERT INTO persona (ID_Rol, ID_Tipo_Documento, num_documento, nombres, apellidos, correo_electronico, contraseña, telefono ) VALUES ('".$rol."', '".$doc_type."', '".$doc_num."','".$firstName."', '".$lastName."', '".$email."', '".$pass."', '".$phone."')");
      header('Location: crud.php?message=created');
      exit();
    }
  }

  // GROUP CREATION
  else if(isset($_GET['course'])){
    if(empty($_POST["group-num"]) || empty($_POST["group-code"])){
      header('Location: courses.php?message=empty');
      exit();
    }
    $group_num = $_POST["group-num"];
    $group_code = $_POST["group-code"];
    $group_desc = $_POST["course-description"];

    echo $group_num."<br>".$group_code."<br>".$group_desc."<br>";
    
    $create_group = $dbConnection->query("INSERT INTO ficha (numero, descripcion, codigo) VALUES ('$group_num', '$group_desc', '$group_code')");

    // Get last group created
    $id_group = "SELECT ID_Ficha FROM ficha";
    $id_group_result= mysqli_query($dbConnection, $id_group) or die(mysqli_error($dbConnection));
    $id_group = mysqli_fetch_all($id_group_result, MYSQLI_NUM);
    $id_group = end($id_group)[0];

    print_r($id_group);

    // TODO: COURSE CREATION QUERY
    // foreach($_POST['subjects'] as $subject){
    //   $create_course = $dbConnection->query("INSERT INTO curso (ID_Ficha, ID_Materia) VALUES ('$id_group', '$subject')");
    // }
    
    // header('Location: courses.php?message=created');
    // exit();
  }

  // SUBJECT CREATION
  else if(isset($_GET['subject'])){
    if(empty($_POST["subject-name"])){
      header('Location: courses.php?message=empty');
      exit();
    }
    
    $subject_name = $_POST["subject-name"];

    if(file_exists($_FILES['subject-img']['tmp_name'])){
      move_uploaded_file($_FILES['subject-img']['tmp_name'], '../file-store/subjects/'.$_FILES['subject-img']['name']);
      $subject_img = '../file-store/subjects/'.$_FILES['subject-img']['name'];
      $create_query = $dbConnection->query("INSERT INTO materia (nombre, img) VALUES ('$subject_name', '$subject_img')");
      header('Location: courses.php?message=created');
      exit();
    } else {
      $subject_img = '../file-store/subjects/sena-logo.png';
      $create_query = $dbConnection->query("INSERT INTO materia (nombre, img) VALUES ('$subject_name', '$subject_img')");
      header('Location: courses.php?message=created');
      exit();
    }

  }
?>