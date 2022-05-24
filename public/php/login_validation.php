<?php
    require('connection.php');

    session_start();
    
    if (isset($_POST['login'])) {
        $email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($dbConnection, $email);
        $pass = stripslashes($_REQUEST['pass']);
        $pass = mysqli_real_escape_string($dbConnection, $pass);

        $login_query = ("SELECT * FROM persona WHERE correo_electronico = '$email' AND contraseña = '$pass'");
        $query_result = mysqli_query($dbConnection, $login_query) or die(mysql_error()); 
        $row = mysqli_num_rows($query_result);
        if ($row == 1) {
            $_SESSION['email'] = $email;
            header("Location: ../index.html");
        } else {
            echo 'Error: usuario no encotrado.';
        }
    }
?>