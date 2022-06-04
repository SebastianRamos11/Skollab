<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../Views/css/signup.css">
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
<?php
    require('connection.php');

    if (isset($_REQUEST['signup-submited'])) {
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
            ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro satisfactorio',
                        text: '¡Ahora puedes disfrutar de Skollab!',
                    }).then(function() {
                        <?php 
                            if($rol == 'INSTRUCTOR'){
                                header('Location: ../Views/Instructor/instructor.html');
                            } else if ($rol == 'APRENDIZ'){
                                header('Location: ../Views/Aprendiz/aprendiz.html');
                            }
                        ?>
                    });
                </script>
            </body>
            </html>
            <?php
        } else {
            ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Usuario ya registrado',
                        footer: '<a href="../Views/login.php">¡Inicia sesión ahora!</a>'
                    }).then(function() {
                        history.back();
                    });
                </script>
            </body>
            </html>
            <?php
        }
    }
?>
