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

        $pass = mysqli_real_escape_string($dbConnection, $_REQUEST['pass']);
        $pass = mysqli_real_escape_string($dbConnection, $pass);
        $pass = hash('sha512', $pass);

        $validation_query = "SELECT * FROM persona WHERE ID_Persona = '$id' || correo_electronico = '$email' || telefono = '$phone'";
        $validation_result = mysqli_query($dbConnection, $validation_query);

        if ($validation_result -> num_rows > 0) {
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
        } else {
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
                            if ($rol == 'APRENDIZ') {
                                ?>
                                window.location.assign('../Views/Aprendiz/aprendiz.php?id=<?php echo $id;?>')
                                <?php
                            } elseif ($rol == 'INSTRUCTOR') {
                                ?>
                                window.location.assign('../Views/Instructor/instructor.php?id=<?php echo $id;?>')
                                <?php
                            }
                        ?>
                        });
                    </script>
                </body>
                </html>
                <?php
            }            
        }
    }
?>
