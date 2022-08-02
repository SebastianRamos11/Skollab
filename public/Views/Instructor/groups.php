<?php
  include_once "../../Models/connection.php";
  $id = $_GET['id'];
  $read_query = "SELECT *  FROM persona WHERE ID_Persona = '$id'";
  $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);

  $get_info = "SELECT  A.ID_Persona, P.nombres, P.apellidos, P.telefono, P.correo_electronico, A.ID_Programa, A.ID_Ficha FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona";
  $get_info_result = mysqli_query($dbConnection, $get_info) or die(mysqli_error($dbConnection));
  $get_info_result_array = mysqli_fetch_all($get_info_result, MYSQLI_NUM);
  
  
  

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/bootstrap-grid.min.css" />
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Inicio</title>
  </head>
  <body>

    <?php include './blocks/sidebar.php' ?>
        <h1 class="main-content__header">Bienvenido Instructor 👋</h1>
        <div class="main-content__info">
          <div class="card mb-50">
              <div class="card-header">Aprendices</div>
              <div class="p-4">
                <table class="table align-middle">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Nombres</th>
                      <th scope="col">Apellidos</th>
                      <th scope="col">Teléfono</th>
                      <th scope="col">Correo</th>
                      <th scope="col" colspan="2"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      for($i=0; $i < sizeof($get_info_result_array); $i++){
                        
                    ?>

                    <tr>
                      <td scope="row"><?php echo $get_info_result_array[$i][0]; ?></td>
                      <td><?php echo $get_info_result_array[$i][1]; ?></td>
                      <td><?php echo $get_info_result_array[$i][2]; ?></td>
                      <td><?php echo $get_info_result_array[$i][3]; ?></td>
                      <td><?php echo $get_info_result_array[$i][4] ?></td>
                      <td><a href="#?id=<?php echo $get_info_result_array[$i][0]; ?>" class="see-button"><i class="fa-solid fa-eye"></i></a></td>
                      <td><a href="#?id=<?php echo $get_info_result_array[$i][0]; ?>" class="message-button"><i class="fa-solid fa-envelope"></i></a></td>
                    </tr>

                    <?php 
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
      </main>
    </div>
    <script src="../../Controllers/instructor-control.js"></script>
  </body>
</html>
