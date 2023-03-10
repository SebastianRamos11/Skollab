<?php
  include_once "../../Models/connection.php";
  session_start();
  include_once "../validations.php";

  $group_num = "SELECT numero FROM ficha WHERE ID_Ficha = $group";
  $group_num_result = mysqli_query($dbConnection, $group_num) or die(mysqli_error($dbConnection));
  $group_num = mysqli_fetch_all($group_num_result, MYSQLI_NUM)[0][0];
?>
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
    <?php include './sidebar.php' ?>
      <h1 class="main-content__header">Gestión de aprendices</h1>

      <!-- GROUP LIST -->
      <div class="container group-list">

        <div class="row">
          <div class="col-md-11">
            <?php 
              $students = "SELECT P.num_documento, P.nombres, P.apellidos, P.telefono, P.correo_electronico, A.ID_Persona FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Ficha = $group AND P.ID_Rol = 3";
              $students_result = mysqli_query($dbConnection, $students) or die(mysqli_error($dbConnection));
              $students = mysqli_fetch_all($students_result, MYSQLI_NUM);
              ?>
              <!-- GROUP (hidden) -->
              <div class="group">
                  <div class="card mb-50">
                    <div class="card-header">Curso <?php echo $group_num; ?></div>
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
                              for($i=0; $i < sizeof($students); $i++){  
                                ?>
                                <tr>
                                  <td scope="row"><?php echo $students[$i][0]; ?></td>
                                  <td><?php echo $students[$i][1]; ?></td>
                                  <td><?php echo $students[$i][2]; ?></td>
                                  <td><?php echo $students[$i][3]; ?></td>
                                  <td><?php echo $students[$i][4] ?></td>
                                  <td><a href="see-aprendiz.php?group=<?php echo $group ?>&student=<?php echo $students[$i][5]; ?>" class="see-button"><i class="fa-regular fa-eye"></i></a></td>
                                </tr>
                                <?php 
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
              </div>
              <?php
            ?>
        </div>
        
        <div class="actions actions--group-list">
          <a download="" href="./reports/group-report.php?group=<?php echo $group ?>&num=<?php echo $group_num ?>" title="Generar reporte" class="btn btn-report"><i class="fa-regular fa-file-pdf"></i> Generar Reporte de Lista</a>
        </div>
      </div>
    </main>
    <script src="../../Controllers/groups-control.js"></script>
  </body>
</html>