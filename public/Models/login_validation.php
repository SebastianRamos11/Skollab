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
    session_start();
    if (isset($_POST['login'])) {
        $email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($dbConnection, $email);
        
        $pass = $_POST['pass'];
        $pass = hash('sha512', $pass);

        $login_query = "SELECT * FROM persona WHERE correo_electronico = '$email' AND contraseña = '$pass'";
        $query_result = mysqli_query($dbConnection, $login_query) or die(mysqli_error($dbConnection));
        $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);
        $row = mysqli_num_rows($query_result);
        if ($row == 1) {
            $_SESSION['id'] = $result_array[0][0];
            ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Ingreso satisfactorio',
                        text: '¡Ahora puedes disfrutar de Skollab!'
                    }).then(function() {
                        <?php
                            if ($result_array[0][4] == 'APRENDIZ') {
                                ?>
                                window.location.assign('../Views/Aprendiz/aprendiz.php')
                                <?php
                            } elseif ($result_array[0][4] == 'INSTRUCTOR') {
                                ?>
                                window.location.assign('../Views/Instructor/instructor.php')
                                <?php
                            } elseif ($result_array[0][4] == 'ADMINISTRADOR') {
                                ?>
                                window.location.assign('../Views/Admin/main.php')
                                <?php
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