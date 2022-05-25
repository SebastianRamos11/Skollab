<?php
    require('connection.php');

    if (isset($_REQUEST['recover-submited'])) {
        $email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($dbConnection, $email);
    
        $pass = stripslashes($_REQUEST['pass']);
        $pass = mysqli_real_escape_string($dbConnection, $pass);
    
        $birthYear = stripslashes($_REQUEST['birthYear']);
        $birthYear = mysqli_real_escape_string($dbConnection, $birthYear);
    
        $recover_query = "UPDATE persona SET contraseña = '$pass' WHERE correo_electronico = '$email' AND fecha_nacimiento = '$birthYear'";
        $query_result = mysqli_query($dbConnection, $recover_query);

        if ($query_result){
            echo 'Contraseña actualizada correctamente.';
        } else {
            echo 'No se pudo actualizar la contraseña.';
        }
    }
?>