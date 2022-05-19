<?php
    $connection = new mysqli('localhost', 'root', '', 'skollab');
    if ($connection->connect_errno){
        echo "Error: no se pudo conectar a nuestra base de datos.";
    }
    
    $email = $_POST['email'];
    $pass = $_POST['pass'];
        if ($email == "" || $_POST['pass'] == null){
            echo "Error: usuario y/o contraseña vacíos."; 
        }else{
            $sqlinsert = "SELECT * FROM persona WHERE correo_electronico = '$email' AND contraseña = '$pass'";
            if (!$query = $connection->query($sqlinsert)){
                echo "Usuario no registrado.";
            }
            else{
                $rows = mysqli_num_rows($query);
                if ($rows==0){
                    echo "Error: usuario y/o contraseña incorrectos."; 
                }
                else{
                    header('location:index.html');
                }
            }
        }
?>