<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../Views/css/login.css">
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
<?php
    require('connection.php');
    if (isset($_POST['login'])) {
        $email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($dbConnection, $email);
        
        $pass = $_POST['pass'];
        $pass = hash('sha512', $pass);

        $login_query = "SELECT ID_Persona, rol FROM persona WHERE correo_electronico = '$email' AND contraseña = '$pass'";
        $query_result = mysqli_query($dbConnection, $login_query) or die(mysqli_error($dbConnection));
        $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);
        
        $row = mysqli_num_rows($query_result);
        if ($row == 1) {
            session_start();
            $_SESSION['id'] = $result_array[0][0];
            
            if ($result_array[0][1] == 'APRENDIZ') {
                header('Location: ../Views/Aprendiz/aprendiz.php');
            } elseif ($result_array[0][1] == 'INSTRUCTOR') {
                header('Location: ../Views/Instructor/instructor.php');
            } elseif ($result_array[0][1] == 'ADMINISTRADOR') {
                header('Location: ../Views/Admin/admin.php');
            }

            ?>
            </body>
            </html>
            <?php
        } else {
            ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '¡Correo o contraseña incorrectos!',
                        footer: '<a href="../Views/recover-pass.php">¿Olvidaste tu contraseña?</a>'
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