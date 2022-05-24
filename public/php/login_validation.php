<?php
    require_once('connection.php');

    $email = $_POST['email'];
    $pass = $_POST['pass'];
        if ($email == "" || $_POST['pass'] == null){
            echo "Error: usuario y/o contraseña vacíos."; 
        }else{
            $sqlselect = "SELECT * FROM persona WHERE correo_electronico = '$email' AND contraseña = '$pass'";
            if (!$query = $dbConnection->query($sqlselect)){
                echo "Usuario no registrado.";
            } else {
                    echo "<h1>Bienvenido a Skollab.</h1>";
            }
        }
?>