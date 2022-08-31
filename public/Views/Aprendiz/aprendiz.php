<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/aprendiz.css" />
    <title>Inicio</title>
  </head>
  <body>
    <?php

      include_once "../../Models/connection.php";
      session_start();
      $session = $_SESSION['id'];

      $read_query = "SELECT * FROM persona WHERE ID_Persona = '$session'";
      $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
      $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);


      $get_group = "SELECT ID_Ficha FROM ambiente_virtual WHERE ID_Persona = '$session'";
      $get_group_result = mysqli_query($dbConnection, $get_group) or die(mysqli_error($dbConnection));
      $get_group_array = mysqli_fetch_all($get_group_result, MYSQLI_NUM);

      if (isset($session)) {
    ?>
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">Bienvenido Aprendiz 👋</h1>
        <div class="main-content__info">
          <?php print_r($get_group_array) ?>
        </div>
      </main> 
    </div>
    <script src="../../Controllers/aprendiz-control.js"></script>
  </body>
</html>
<?php 
      } else {
        ?><script>window.location.assign('../index.html')</script><?php
      }
?>  
