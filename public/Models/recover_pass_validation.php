<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../Views/css/signup.css">
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Validación de Recuperación</title>
</head>
<body>
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
    
        $confirm_query = "SELECT * FROM persona WHERE correo_electronico = '$email' AND fecha_nacimiento = '$birthYear'";
        $confirm_result = mysqli_query($dbConnection, $confirm_query) or die(mysqli_errno($dbConnection));
        $confirm_array = mysqli_fetch_all($confirm_result);

        $recover_query = "UPDATE persona SET contraseña = '$pass' WHERE correo_electronico = '$email' AND fecha_nacimiento = '$birthYear'";
        $query_result = mysqli_query($dbConnection, $recover_query) or die(mysqli_error($dbConnection));

        if ($confirm_array == null) {
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Los datos ingresados no corresponden.'
                }).then(function() {
                    history.back();
                });
            </script>
        </body>
        </html>
        <?php 
        exit;   
        } elseif ($confirm_array[0][5] === $email && $confirm_array[0][3] === $birthYear) {
            ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Actualización completada',
                    text: 'Su contraseña se actualizó.'
                }).then(function() {
                    window.location.href = "../Views/login.php";
                });
            </script>
        </body>
        </html>
        <?php
        }
    }
?>
</body>
</html>
