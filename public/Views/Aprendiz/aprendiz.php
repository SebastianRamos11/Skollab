<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <link rel="stylesheet" href="../css/aprendiz.css" />
    <title>Inicio</title>
  </head>
  <body>
    <h1>Bienvenido, aprendiz 👋</h1>
    <?php
      session_start();
      $session = $_SESSION['id'];
      if (isset($session)) {
        // Aquí va todo el cuerpo de la interfaz
    ?>
    Click here to <a href="../../Models/logout_validation.php" tite="Logout">Logout. <!--Esta línea equivale a un botón de cerrar sesión, lo más importante es el href-->
  </body>
</html>
<?php 
      } else {
        ?><script>window.location.assign('../index.html')</script><?php
      }
  ?>  
