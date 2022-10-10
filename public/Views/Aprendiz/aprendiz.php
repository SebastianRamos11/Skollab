<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
  $read_query = "SELECT * FROM persona WHERE ID_Persona =".$_SESSION['id'];
  $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);
  ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/aprendiz.css" />
    <title>Portafolio</title>
  </head>
  <body>
    <?php include './sidebar.php' ?>
    <h1 class="main-content__header">Bienvenido aprendiz 👋</h1>
    <!-- BANNER -->
    <div class="banner">
      <p class="banner__p">¡Skollab es la mejor app para gestionar tu aprendizaje!</p>
        </div>
    </main>
  </body>
  </html>
  <?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?> 