<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    $course = "SELECT * FROM ambiente_virtual WHERE ID_Persona =".$_SESSION['id'];
    $course_result = mysqli_query($dbConnection, $course) or die(mysqli_error($dbConnection));
    $course_array = mysqli_fetch_all($course_result, MYSQLI_NUM);
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
      <h1 class="main-content__header">Fichas</h1>

      <!-- PROGRAMS -->
      <?php 
        for ($j=0; $j < sizeof($course_array); $j++) {
          $subject = $course_array[$j][1];
          $ficha = $course_array[$j][2];

          $get_program = "SELECT nombre FROM materia WHERE ID_Materia = '$subject'";
          $get_program_result = mysqli_query($dbConnection, $get_program) or die(mysqli_error($dbConnection));
          $get_program_array = mysqli_fetch_all($get_program_result, MYSQLI_NUM);
          ?>
          <a class="course" href="#group-<?php echo $j ?>">
            <div class="course__title"><?php print_r($get_program_array[0][0]); ?></div>
            <div class="course__id"><?php echo $course_array[$j][2]; ?></div>
            <img class="course__figure" src="../img/courses/sena-logo.png" alt="course">
          </a>
          <?php
        }
      ?>

      <!-- GROUPS -->
      <div class="container">
        <div class="row">
          <div class="col-md-11">
            <?php 
              for($j=0; $j < sizeof($course_array); $j++){
                $subject = $course_array[$j][1];
                $ficha = $course_array[$j][2];
                      
                $get_group = "SELECT P.num_documento, P.nombres, P.apellidos, P.telefono, P.correo_electronico, A.ID_Persona, A.ID_Materia, A.ID_Ficha FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Materia = '$subject' AND A.ID_Ficha = $ficha AND P.ID_Rol = 3";
                $get_group_result = mysqli_query($dbConnection, $get_group) or die(mysqli_error($dbConnection));
                $group_array = mysqli_fetch_all($get_group_result, MYSQLI_NUM);
                ?>
                <!-- GROUP (hidden) -->
                <div class="group hidden">
                  <div class="card mb-50">
                    <div class="card-header" id="group-<?php echo $j ?>">Ficha <?php echo $course_array[$j][2]; ?></div>
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
                              for($i=0; $i < sizeof($group_array); $i++){  
                                ?>
                                <tr>
                                  <td scope="row"><?php echo $group_array[$i][0]; ?></td>
                                  <td><?php echo $group_array[$i][1]; ?></td>
                                  <td><?php echo $group_array[$i][2]; ?></td>
                                  <td><?php echo $group_array[$i][3]; ?></td>
                                  <td><?php echo $group_array[$i][4] ?></td>
                                  <td><a href="see-aprendiz.php?aprendiz=<?php echo $group_array[$i][5]; ?>" class="see-button"><i class="fa-regular fa-eye"></i></a></td>
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
              }
            ?>
          </div>
        </div>
      </div>
    </main>
    <script src="../../Controllers/groups-control.js"></script>
  </body>
</html>
<?php
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>