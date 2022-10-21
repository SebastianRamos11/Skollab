<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Inicio</title>
  </head>
  <body>
    <?php
      include_once "../../Models/connection.php";
      session_start();
      if (isset($_SESSION['id'])) {
        include './sidebar.php';
        
        ?>
        <h1 class="main-content__header">Bienvenido Instructor 👋</h1>
        <!-- BANNER -->
        <div class="banner">
          <p class="banner__p">¡Skollab es la mejor app para gestionar tu aprendizaje!</p>
        </div>

        <!-- Content here... -->
      </main> 
    </div>
    <script src="../../Controllers/instructor-control.js"></script>
  </body>
</html>
<?php 
      } else {
        include('../../Models/logout.php');
        $location = header('Location: ../index.php');
      }
  ?>