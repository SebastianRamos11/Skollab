<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    $groups = "SELECT ID_Ficha FROM ambiente_virtual WHERE ID_Persona =".$_SESSION['id'];
    $groups_result = mysqli_query($dbConnection, $groups) or die(mysqli_error($dbConnection));
    $groups = mysqli_fetch_all($groups_result, MYSQLI_NUM);
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
          for($i = 0; $i < sizeof($groups); $i++){
            $ficha = $groups[$i][0]; 
            
            // GET COURSE'S SUBJECTS
            $course = "SELECT C.ID_Materia, C.ID_Instructor, F.numero FROM curso C JOIN ficha F ON C.ID_Ficha = F.ID_Ficha WHERE C.ID_Ficha = $ficha";
            $course_result = mysqli_query($dbConnection, $course) or die(mysqli_error($dbConnection));
            $course = mysqli_fetch_all($course_result, MYSQLI_NUM);
					  
            $course_num = $course[$i][2];

            ?>
            <div class="user-course">
              <h2 class="user-course__name">Curso <?php echo $course_num ?></h2>
              <hr>
              <?php
							  for($j = 0; $j < sizeof($course); $j++){
                  $id_subject = $course[$j][0];
                  $id_instructor = $course[$j][1];

                  // GET SUBJECT
                  $subject = "SELECT nombre FROM materia WHERE ID_Materia = $id_subject";
                  $subject_result= mysqli_query($dbConnection, $subject) or die(mysqli_error($dbConnection));
                  $subject = mysqli_fetch_all($subject_result, MYSQLI_NUM)[0][0];

                  // GET ACTIVITIES ID'S (TO LOOP)
                  $act = "SELECT ID_Actividad, asunto, fecha FROM `actividad` WHERE ID_Ficha = $ficha AND ID_Persona = $id_instructor";
                  $act_result = mysqli_query($dbConnection, $act) or die(mysqli_error($dbConnection));
                  $act_array = mysqli_fetch_all($act_result, MYSQLI_NUM);
                  $activities = [];
                  for($k=0; $k < sizeof($act_array); $k++) array_push($activities, $act_array[$k][0]);

                  // EVIDENCES (ID'S) ARRAY
                  $evi = "SELECT ID_Actividad FROM evidencia WHERE ID_Persona = $id_user";
                  $evi_result = mysqli_query($dbConnection, $evi) or die(mysqli_error($dbConnection));
                  $evi_array = mysqli_fetch_all($evi_result, MYSQLI_NUM);
                  $evidences = [];
                  for($k=0; $k < sizeof($evi_array); $k++) array_push($evidences, $evi_array[$k][0]);

                  // CREATE DEFINITIVE ACTIVITIES TO SHOW
                  $pending = array_merge(array(), $activities);
                  for($k = 0; $k < sizeof($evidences); $k++){
                    if(in_array($evidences[$k], $activities)){
                      $elem = array_search($evidences[$k], $pending);
                      array_splice($pending, $elem, 1);
                    }
                  }
                  ?>
                  <div class="activities-course">
                    <div class="activities-course__label"><?php echo $subject; ?></div>
                    <hr>
                    <?php
                      if (sizeof($pending) > 0){
                        ?>
                        <div class="activities">
                          <?php
                            for($k=0; $k < sizeof($pending); $k++){
                              $id_activity = $pending[$k];
                              $activity = "SELECT AC.ID_Actividad, AC.asunto, AC.descripcion, AC.fecha, AC.fecha_limite, AC.url FROM actividad AC JOIN ambiente_virtual A ON AC.ID_Persona = A.ID_Persona WHERE AC.ID_Ficha = $ficha AND AC.ID_Actividad = $id_activity;";
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
                                  <a href="activity.php?activity=<?php echo $activity_array[0][0]?>" class="activity__btns-link">Entregar>></a>
                                </div>
                              </div>
                              <?php
                            }
                          ?>
                        </div>
                        <?php
                      } else{
                        ?><div class="good-message"><i class="fa-solid fa-check"></i> No hay evidencias por entregar.</div><?php
                      }
                    ?>
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
  </body>
</html>
<?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>