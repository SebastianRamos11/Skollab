<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    $program_query = "SELECT * FROM programa_formacion";
    $program_result= mysqli_query($dbConnection, $program_query) or die(mysqli_error($dbConnection));
    $program_array = mysqli_fetch_all($program_result, MYSQLI_NUM);
    
    $course = "SELECT * FROM ambiente_virtual WHERE ID_Persona =".$_SESSION['id'];
    $course_result = mysqli_query($dbConnection, $course) or die(mysqli_error($dbConnection));
    $course_array = mysqli_fetch_all($course_result, MYSQLI_NUM);
?>

<!DOCTYPE html>
<html lang="es">
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
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">📚 Centro de actividades</h1>

        <!-- TRANSVERSALES -->
        <div class="courses">
          <h2 class="courses__title">Programas de formación</h2>
          <!-- <div class="courses__label">Elige un programa para ver las actividades pendientes del mismo.</div> -->
          <div class="courses__list">
            <?php for ($j=0; $j < sizeof($course_array); $j++) { 

              $program = $course_array[$j][1];
              $ficha = $course_array[$j][2]; 
              
              $get_program = "SELECT nombre FROM programa_formacion WHERE ID_Programa = '$program'";
              $get_program_result = mysqli_query($dbConnection, $get_program) or die(mysqli_error($dbConnection));
              $get_program_array = mysqli_fetch_all($get_program_result, MYSQLI_NUM);


              // $get_course = "SELECT A.ID_Programa, A.ID_Ficha FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Programa = '$program' AND A.ID_Ficha = $ficha";
              // $get_course_result = mysqli_query($dbConnection, $get_course) or die(mysqli_error($dbConnection));
              // $get_course_result_array = mysqli_fetch_all($get_course_result, MYSQLI_NUM);
            ?>
              <a href="#activities" class="course">
                <div class="course__title"><?php print_r($get_program_array[0][0]); ?></div>
                <div class="course__id"><?php echo $course_array[$j][2]; ?></div>
                <img class="course__figure" src="../img/courses/sena-logo.png" alt="course">
              </a>
            <?php 
            }
            ?>

            
          </div>
        </div>

        

        <!-- EVIDENCIAS PENDIENTES -->
        <div id="activities" class="activities hidden">
          <?php
            for($i=0; $i < sizeof($course_array); $i++){
              $program = $course_array[$i][1];
              $ficha = $course_array[$i][2]; 

              $activity = "SELECT AC.ID_Actividad, AC.asunto, AC.descripcion, AC.fecha, AC.fecha_limite, AC.url, A.ID_Programa FROM actividad AC JOIN ambiente_virtual A ON AC.ID_Persona = A.ID_Persona WHERE AC.ID_Ficha = $ficha AND A.ID_Programa = $program;";
              $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
              $activity_array = mysqli_fetch_all($activity_result, MYSQLI_NUM);

              ?>
              <div class="activities-course activities-course--<?php echo $i; ?> hidden">
                
                <!-- LABEL EVIDENCIAS-->
                <div class="activities-course__label">
                  <?php
                    if(sizeof($activity_array) > 1){
                      echo sizeof($activity_array); echo " "; echo "Actividades";
                    } else if (sizeof($activity_array) == 1) {
                      echo sizeof($activity_array); echo " "; echo "Actividad";
                    } else{
                      echo "Tu instructor no ha realizado ninguna actividad";
                    }
                  ?>
                </div>
                <hr>

                <?php
                  for($j=0; $j < sizeof($activity_array); $j++){
                ?>
                    <div class="activity">
                      <div class="activity__title"><?php print_r($activity_array[$j][1]); ?></div>
                      <div class="activity__date">Fecha actividad: <?php print_r($activity_array[$j][3]); ?></div>
                      <div class="activity__info">
                        <div class="activity__p"><?php print_r($activity_array[$j][2]); ?></div>
                        <div class="activity__date-limit"><?php print_r($activity_array[$j][4]); ?></div>
                        <div class="activity__type">Actividad</div>
                      </div>
                      <div class="activity__btns">
                        <?php
                          if($activity_array[$j][5] != ''){
                        ?>
                          <a href="<?php print_r($activity_array[$j][5]); ?>" class="activity__btns-file" download="">
                            <i class="fa-regular fa-file-lines"></i>
                            <span class="file-name"><?php print_r($activity_array[$j][5]); ?></span>
                          </a>
                        <?php 
                          }
                        ?>
                        <a href="evidence.php?evidence=<?php echo $activity_array[$j][0]?>" class="activity__btns-link">Entregar>></a>
                      </div>
                    </div>
                <?php
                  }
                ?>
              </div>
              <?php
            }
          ?>
        </div>

      </main> 
    </div>
    <script src="../../Controllers/aprendiz-control.js"></script>
  </body>
</html>
<?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>  