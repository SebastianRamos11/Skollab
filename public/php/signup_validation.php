<?php
    require_once('connection.php');
    
    if (isset($_POST['id']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['birthYear']) && isset($_POST['rol']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['phone'])
        ){
            $id = $_POST['id'];
            $names = $_POST['firstName'];
            $lastnames =$_POST['lastName'];
            $birthday = $_POST['birthYear'];
            $role = $_POST['rol'];
            $email = $_POST['email'];
            $password = $_POST['pass'];
            $phonenumber = $_POST['phone'];
            $sqlinsert = $dbConnection -> exec("INSERT INTO persona VALUES ('$id','$names','$lastnames','$birthday', '$role', '$email', '$password', '$phonenumber')");
        if ($names = 1){
            header('location:../index.html');
        }
        } else {
            echo 'No se pudo registrar.';
        }
?>