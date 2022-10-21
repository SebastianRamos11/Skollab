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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Centro de revisión</title>
  </head>
  <body>
      <?php include './sidebar.php' ?>

      <!-- ALERTS -->

      <!-- Empty data -->
      <?php 
        if(isset($_GET['message']) and $_GET['message'] == 'empty'){
      ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '¡Tienes que asignar una calificación!'
            });
        </script>
      <?php 
        }
      ?>

      <!-- Error -->
      <?php 
        if(isset($_GET['message']) and $_GET['message'] == 'error'){
      ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '¡Ha habido algún problema!'
            });
        </script>
      <?php 
        }
      ?>
      <!-- Updated successfully -->
      <?php 
        if(isset($_GET['message']) and $_GET['message'] == 'qualified'){
      ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Evidencia calificada!',
                text: '¡Tu calificación ha sido registrada correctamente!'
            });
        </script>
      <?php 
        }
      ?>
      <h1 class="main-content__header">Centro de revisión</h1>

      <p>Selecciona una ficha para consultar las actividades que has realizado.</p>
      <!-- GROUPS NAVIGATION -->
      <div class="nav-group">
        <div class="nav-group__title">Ficha</div>
        <select class="nav-group__select">
          <option value="-1" default="">Seleccione ficha</option>
          <?php
            for($i=0; $i < sizeof($course_array); $i++){
          ?>
            <option value="<?php echo $i; ?>" default="" class="ficha"><?php echo $course_array[$i][2]; ?></option>
          <?php
            }
          ?>

        </select>
        <a href="#activities" class="nav-group__btn">Buscar</a>
      </div>

      <!-- activities OF GROUP SELECTED -->
      <div id="activities" class="activities">
        <?php
          for($i=0; $i < sizeof($course_array); $i++){
            $program = $course_array[$i][1];
            $ficha = $course_array[$i][2];

            $activity = "SELECT AC.ID_Actividad, AC.asunto, AC.descripcion, AC.fecha, AC.fecha_limite, AC.url, A.ID_Programa FROM actividad AC JOIN ambiente_virtual A ON AC.ID_Persona = A.ID_Persona WHERE AC.ID_Ficha = $ficha AND A.ID_Programa = $program;";
            $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
            $activity_array = mysqli_fetch_all($activity_result, MYSQLI_NUM);
          ?>
            <!-- CONTENEDOR DE actividadES PARA FICHA <?php echo $i ?> -->
            <div class="activities-course activities-course<?php echo $i; ?> hidden">
              <!-- LABEL  -->
              <div class="activities-course__label">
                <?php 
                  if(sizeof($activity_array) > 0){
                    echo 'Selecciona la evidencia a consultar';
                  } else{
                    echo 'No has realizado ninguna publicación';
                  }
                ?>
              </div>
              <hr>
              <?php for($j=0; $j < sizeof($activity_array); $j++){?>

                <!-- actividad <?php echo $j ?> -->
                <div class="activity">
                  <div class="activity__title"><?php print_r($activity_array[$j][1]); ?></div>
                  <div class="publcation__date">Fecha publicación: <?php print_r($activity_array[$j][3]); ?></div>
                  <div class="activity__info">
                    <div class="activity__p"><?php print_r($activity_array[$j][2]); ?></div>
                    <div class="activity__date-limit"><?php print_r($activity_array[$j][4]); ?></div>
                    <div class="activity__type">Actividad</div>
                    <?php
                      if($activity_array[$j][5] != ''){
                    ?>
                      <a href="<?php print_r($activity_array[$j][5]); ?>" class="activity__file" download="">
                        <i class="fa-regular fa-file-lines"></i>
                      </a>
                    <?php 
                      }
                    ?>
                  </div>
                  <div class="activity__btns">
                    <a href="FIXME?activity=<?php echo $activity_array[$j][0]?>" class="activity__btns-link">Editar>></a>
                    <a href="#evidences" id="<?php echo $i; ?>-<?php echo $j; ?>" class="activity__btns-evidences activity-btn">
                      Ver entregas
                    </a>
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

      <div id="evidences" class="evidences">
        <?php
          for($i=0; $i < sizeof($course_array); $i++){
            $ficha = $course_array[$i][2];

            // activities BY GROUP
            $activities = "SELECT ID_Actividad FROM `actividad` WHERE ID_Persona =".$_SESSION['id']." AND ID_Ficha = $ficha";
            $activities_result = mysqli_query($dbConnection, $activities) or die(mysqli_error($dbConnection));
            $activities_array = mysqli_fetch_all($activities_result, MYSQLI_NUM);
            ?> 

            <!-- CONTENEDOR PARA FICHA <?php echo $i?> -->
            <div class="evidences-course evidences-course--<?php echo $i?>">
              <?php
                for($j=0; $j < sizeof($activities_array); $j++){
                  $ID_Actividad = $activities_array[$j][0];
                  ?>
                    <!-- CONTENEDOR DE EVIDENCIAS SUBIDAS DE actividad <?php echo $j ?>-->
                    <div class="evidences-<?php echo $i; ?>-<?php echo $j; ?> evidences evidences-activity hidden">
                      <?php 
                        $evidences = "SELECT E.ID_Evidencia, E.ID_Persona, E.ID_Actividad, E.fecha, AC.ID_Ficha FROM evidencia E JOIN actividad AC ON E.ID_Actividad = AC.ID_Actividad WHERE AC.ID_Ficha = $ficha AND AC.ID_Actividad = $ID_Actividad AND E.nota IS NULL";
                        $evidences_result = mysqli_query($dbConnection, $evidences) or die(mysqli_error($dbConnection));
                        $evidences_array = mysqli_fetch_all($evidences_result, MYSQLI_NUM);
                        ?>
                        
                        <!-- LABEL EVIDENCIAS-->
                        <div class="evidences-course__label">
                          <?php
                            if(sizeof($evidences_array) > 1){
                              echo sizeof($evidences_array); echo " "; echo "Actividades por calificar";
                            } else if (sizeof($evidences_array) == 1) {
                              echo sizeof($evidences_array); echo " "; echo "Evidencia por calificar";
                            } else{
                              echo "No hay actividades por calificar";
                            }
                          ?>
                        </div>
                        <hr>

                        <?php
                        for($k=0; $k < sizeof($evidences_array); $k++){

                          // CONSULTA: OBTENER NOMBRE DEL PROPIETARIO DE LA EVIDENCIA
                          $aprendiz_id = $evidences_array[$k][1];
                          $aprendiz_name = "SELECT nombres, apellidos FROM `persona` WHERE ID_Persona = $aprendiz_id";
                          $aprendiz_name_result = mysqli_query($dbConnection, $aprendiz_name) or die(mysqli_error($dbConnection));
                          $aprendiz_name_array = mysqli_fetch_all($aprendiz_name_result, MYSQLI_NUM);

                          ?>
                          <!-- <?php echo "EVIDENCIAS DE actividad CON ID "; echo $ID_Actividad; ?> -->

                            <!-- EVIDENCIA -->
                            <div class="evidence">
                              <div class="evidence__user">
                                <i class="fa-solid fa-book evidence__icon"></i>
                                <div class="evidence__name"><?php echo $aprendiz_name_array[0][0]; echo " "; echo $aprendiz_name_array[0][1]; ?></div>
                              </div>
                              <div class="evidence__date"><?php echo $evidences_array[$k][3]; ?></div>
                              <a href="grade-evidence.php?evidence=<?php echo $evidences_array[$k][0]; ?>" class="evidence__link">Calificar</a>
                            </div>
                          <?php
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
      
          <!-- ESTRUCTURA PARA CALIFICACION DE EVIDENCIA (NO BORRAR) -->
      <!-- <div class="evidence">
          <div class="evidence__data">
            <div>
              <div class="evidence__name">Andrés Ramos</div>
              <div class="evidence__p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi non voluptatibus similique placeat dolorum inventore asperiores, minus enim voluptas eaque harum ea, culpa repellendus et nesciunt? Atque non aspernatur nostrum!</div>
            </div>
            <a href="#" class="evidence__file"><i class="fa-solid fa-circle-down"></i></a>
          </div>
          <form action="#" method="POST" class="evidence__form">
            <div class="evidence__calification">
              <input type="range" min="0" max="100" value="0" name="calification" id="calification" class="evidence__calification-range" onChange="rangeSlide(this.value)" onmousemove="rangeSlide(this.value)">
              <div class="evidence__calification-value"><span id="rangeValue">0</span>/100</div>
            </div>
            <textarea name="observation" class="evidence__observation" placeholder="Escribe un comentario..."></textarea>
            <input type="submit" value="Asignar" class="evidence__btn-sub">
          </form>
        </div> -->
    </main>
    <script type="text/javascript">
        function rangeSlide(value) {
            document.getElementById('rangeValue').innerHTML = value;
        }
    </script>
    <script src="../../Controllers/instructor-control.js"></script>
    <script src="../../Controllers/review-center-control.js"></script>
  </body>
</html>
<?php
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>