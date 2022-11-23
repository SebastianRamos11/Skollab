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
    <title>Actividades</title>
  </head>
  <body>
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">📚 Centro de actividades</h1>

        <div>
          <?php
            for($i = 0; $i < sizeof($course_array); $i++){
              $program = $course_array[$i][1];
              $ficha = $course_array[$i][2]; 

              // GET PROGRAM NAME
              $get_program = "SELECT nombre FROM programa_formacion WHERE ID_Programa = '$program'";
              $get_program_result = mysqli_query($dbConnection, $get_program) or die(mysqli_error($dbConnection));
              $get_program_array = mysqli_fetch_all($get_program_result, MYSQLI_NUM);


              // GET ACTIVITIES ID'S (TO LOOP)
              $act = "SELECT AC.ID_Actividad FROM actividad AC JOIN ambiente_virtual A ON AC.ID_Persona = A.ID_Persona WHERE AC.ID_Ficha = $ficha AND A.ID_Programa = $program;";
              $act_result = mysqli_query($dbConnection, $act) or die(mysqli_error($dbConnection));
              $act_array = mysqli_fetch_all($act_result, MYSQLI_NUM);
              $activities = [];
              for($j=0; $j < sizeof($act_array); $j++) array_push($activities, $act_array[$j][0]);

              // EVIDENCES (ID'S) ARRAY
              $evi = "SELECT ID_Actividad FROM evidencia WHERE ID_Persona = $id_user";
              $evi_result = mysqli_query($dbConnection, $evi) or die(mysqli_error($dbConnection));
              $evi_array = mysqli_fetch_all($evi_result, MYSQLI_NUM);
              $evidences = [];
              for($j=0; $j < sizeof($evi_array); $j++) array_push($evidences, $evi_array[$j][0]);

              // CREATE DEFINITIVE ACTIVITIES TO SHOW
              $pending = array_merge(array(), $activities);
              for($j = 0; $j < sizeof($evidences); $j++){
                if(in_array($evidences[$j], $activities)){
                  $elem = array_search($evidences[$j], $pending);
                  array_splice($pending, $elem, 1);
                }
              }

              ?>
              <div class="activities-course">
                <!-- LABEL EVIDENCIAS-->
                <div class="activities-course__label"><?php echo $get_program_array[0][0]; ?>
                </div>
                <hr>
                <?php
                if (sizeof($pending) > 0){
                  ?>
                  <div class="activities">
                  <?php
                    for($j=0; $j < sizeof($pending); $j++){
                      // GET ACTIVITY DATA
                      $id_activity = $pending[$j];
                      $activity = "SELECT AC.ID_Actividad, AC.asunto, AC.descripcion, AC.fecha, AC.fecha_limite, AC.url, A.ID_Programa FROM actividad AC JOIN ambiente_virtual A ON AC.ID_Persona = A.ID_Persona WHERE AC.ID_Ficha = $ficha AND AC.ID_Actividad = $id_activity AND A.ID_Programa = $program;";
                      $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
                      $activity_array = mysqli_fetch_all($activity_result, MYSQLI_NUM);
                    ?>
                      <div class="activity">
                        <div class="activity__title"><?php print_r($activity_array[0][1]); ?></div>
                        <div class="activity__date">Fecha actividad: <?php print_r($activity_array[0][3]); ?></div>
                        <div class="activity__info">
                          <div class="activity__p"><?php print_r($activity_array[0][2]); ?></div>
                          <div class="activity__date-limit"><?php print_r($activity_array[0][4]); ?></div>
                          <div class="activity__type">Actividad</div>
                          <?php
                            if($activity_array[0][5] != ''){
                          ?>
                            <a href="<?php print_r($activity_array[0][5]); ?>" class="activity__file" download=""><i class="fa-regular fa-file-lines"></i></a>
                          <?php 
                            }
                          ?>
                        </div>
                        <div class="activity__btns">
                          <a href="evidence.php?evidence=<?php echo $activity_array[0][0]?>" class="activity__btns-link">Entregar>></a>
                        </div>
                      </div>
                    <?php
                    }
                  ?>
                </div>
                <?php
                } else{
                  ?>
                  <div class="good-message"><i class="fa-solid fa-check"></i> No hay evidencias por entregar.</div>
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
    <!-- <script src="../../Controllers/aprendiz-control.js"></script> -->
  </body>
</html>
<?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>