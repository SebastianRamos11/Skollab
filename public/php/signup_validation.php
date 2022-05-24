<?php
    require('connection.php');

    if (isset($_REQUEST['signup'])) {
        $id = stripslashes($_REQUEST['id']);
        $id = mysqli_real_escape_string($dbConnection, $id);

        $firstName = stripslashes($_REQUEST['firstName']);
        $firstName = mysqli_real_escape_string($dbConnection, $firstName);
     
        $lastName = stripslashes($_REQUEST['lastName']);
        $lastName = mysqli_real_escape_string($dbConnection, $lastName);
 
        $birthYear = stripslashes($_REQUEST['birthYear']);
        $birthYear = mysqli_real_escape_string($dbConnection, $birthYear);

        $rol = stripslashes($_REQUEST['rol']);
        $rol = mysqli_real_escape_string($dbConnection, $rol);

        $phone = stripslashes($_REQUEST['phone']);
        $phone = mysqli_real_escape_string($dbConnection, $phone);

        $email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($dbConnection, $email);

        $pass = stripslashes($_REQUEST['pass']);
        $pass = mysqli_real_escape_string($dbConnection, $pass);

        $signup_query = "INSERT INTO persona VALUES ('$id', '$firstName', '$lastName', '$birthYear', '$rol', '$email', '$pass', '$phone')";
        $query_result = mysqli_query($dbConnection, $signup_query);

        if ($query_result) {
            header('location:../index.html');
        } else {
            echo 'Error: Datos invalidos';
        }
    }
?>