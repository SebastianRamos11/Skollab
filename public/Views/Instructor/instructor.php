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
      $read_query = "SELECT * FROM persona WHERE ID_Persona =".$_SESSION['id'];
      $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
      $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);

      $program_query = "SELECT * FROM programa_formacion";
      $program_result= mysqli_query($dbConnection, $program_query) or die(mysqli_error($dbConnection));
      $program_array = mysqli_fetch_all($program_result, MYSQLI_NUM);

      $get_info_query = "SELECT 
            P.nombres,
            P.apellidos,
            P.telefono,
            P.rol,
            A.ID_Persona,
            A.ID_Programa,
            A.ID_Ficha
        FROM persona P
        JOIN ambiente_virtual A
        ON P.ID_Persona = A.ID_Persona";
      $get_info_result = mysqli_query($dbConnection, $get_info_query) or die(mysqli_error($dbConnection));
      $get_info_array = mysqli_fetch_all($get_info_result, MYSQLI_NUM);
      $ficha = $get_info_array[0][5];
    ?>
    <?php include './sidebar.php' ?>
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
        $location = header('Location: ../index.html');
      }
  ?>