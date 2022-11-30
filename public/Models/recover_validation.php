<?php
    require('connection.php');

    if (isset($_REQUEST['recover-submited'])) {
        $email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($dbConnection, $email);
    
        $pass = mysqli_real_escape_string($dbConnection, $_REQUEST['pass']);
        $pass = mysqli_real_escape_string($dbConnection, $pass);
        $pass = hash('sha512', $pass);
    
        $birthYear = stripslashes($_REQUEST['birthYear']);
        $birthYear = mysqli_real_escape_string($dbConnection, $birthYear);
    
        $confirm_query = "SELECT correo_electronico, fecha_nacimiento FROM persona WHERE correo_electronico = '$email' AND fecha_nacimiento = '$birthYear'";
        $confirm_result = mysqli_query($dbConnection, $confirm_query) or die(mysqli_errno($dbConnection));
        $confirm_array = mysqli_fetch_all($confirm_result);

        $recover_query = "UPDATE persona SET contraseña = '$pass' WHERE correo_electronico = '$email' AND fecha_nacimiento = '$birthYear'";
        $query_result = mysqli_query($dbConnection, $recover_query) or die(mysqli_error($dbConnection));

        if ($confirm_array == null) {
            header('Location: ../Views/recover-pass.php?message=unknow');
            exit(); 
        } elseif ($confirm_array[0][0] === $email && $confirm_array[0][1] === $birthYear) {
            header('Location: ../Views/login.php?message=recovered');
            exit;   
        }
    }
?>
