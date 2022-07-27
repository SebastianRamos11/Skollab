<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Fichas</title>
  </head>
  <body>
  <?php
      include_once "../../Models/connection.php";
      $id = $_GET['id'];
      $read_query = "SELECT *  FROM persona WHERE ID_Persona = '$id'";
      $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
      $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);
    ?>
      <?php include './blocks/sidebar.php' ?>
        <h1 class="main-content__header">Fichas</h1>
        <div class="main-content__info">
          
        </div>
      </main>
    </div>
    <script src="../../Controllers/instructor-control.js"></script>
  </body>
</html>
