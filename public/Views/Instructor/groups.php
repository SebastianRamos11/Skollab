<?php
  include_once "../../Models/connection.php";
  include_once "../../Models/session.php";
  $read_query = "SELECT *  FROM persona WHERE ID_Persona = '$session'";
  $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);

  $program_query = "SELECT * FROM programa_formacion";
  $program_result= mysqli_query($dbConnection, $program_query) or die(mysqli_error($dbConnection));
  $program_array = mysqli_fetch_all($program_result, MYSQLI_NUM);

  $temp = "SELECT * FROM ambiente_virtual WHERE ID_Persona = '$session'";
  $temp_result = mysqli_query($dbConnection, $temp) or die(mysqli_error($dbConnection));
  $temp_array = mysqli_fetch_all($temp_result, MYSQLI_NUM);
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
    <title>Fichas</title>
  </head>
  <body>

    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">Fichas</h1>

        <!-- PROGRAMS -->
        <?php 
          for ($j=0; $j < sizeof($temp_array); $j++) {
            $program = $temp_array[$j][1];
            $ficha = $temp_array[$j][2];

            $get_program = "SELECT nombre FROM programa_formacion WHERE ID_Programa = '$program'";
            $get_program_result = mysqli_query($dbConnection, $get_program) or die(mysqli_error($dbConnection));
            $get_program_array = mysqli_fetch_all($get_program_result, MYSQLI_NUM);

            $get_group = "SELECT A.ID_Persona, P.nombres, P.apellidos, P.telefono, P.correo_electronico, P.rol, A.ID_Programa, A.ID_Ficha FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Programa = '$program' AND A.ID_Ficha = $ficha AND P.rol = 'APRENDIZ'";
            $get_group_result = mysqli_query($dbConnection, $get_group) or die(mysqli_error($dbConnection));
            $get_group_result_array = mysqli_fetch_all($get_group_result, MYSQLI_NUM);

       



            ?>
            
            <!-- Course buttons (programa_formacion) -->
            <button class="course">
              <div class="course__title"><?php print_r($get_program_array[0][0]); ?></div>
              <div class="course__id"><?php echo $temp_array[$j][2]; ?></div>
              <img class="course__figure" src="../img/courses/sena-logo.png" alt="course">
            </button>
            
            <?php
          }
        ?>

        <!-- GROUPS -->
        <div class="container">
          <div class="row">
            <div class="col-md-11">
                <?php 
                  for($j=0; $j < sizeof($temp_array); $j++){
                ?>
                    <!-- GROUP (hidden) -->
                    <div class="group hidden">
                    <div class="card mb-50">
                      <div class="card-header">Ficha <?php echo $temp_array[$j][2]; ?></div>
                        <div class="p-4">
                          <table class="table align-middle">
                            <thead>
                              <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombres</th>
                                <th scope="col">Apellidos</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Correo</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                for($i=0; $i < sizeof($get_group_result_array); $i++){  
                              ?>
                                  <tr>
                                    <td scope="row"><?php echo $get_group_result_array[$i][0]; ?></td>
                                    <td><?php echo $get_group_result_array[$i][1]; ?></td>
                                    <td><?php echo $get_group_result_array[$i][2]; ?></td>
                                    <td><?php echo $get_group_result_array[$i][3]; ?></td>
                                    <td><?php echo $get_group_result_array[$i][4] ?></td>
                                    <td><a href="#?id=<?php echo $get_group_result_array[$i][0]; ?>" class="see-button"><i class="fa-solid fa-eye"></i></a></td>
                                  </tr>
                              <?php 
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                <?php 
                  }
                ?>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="../../Controllers/instructor-control.js"></script>
  </body>
</html>
