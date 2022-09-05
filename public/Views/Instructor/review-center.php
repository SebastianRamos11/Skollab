<?php
  include_once "../../Models/connection.php";
  include_once "../../Models/session.php";

  $read_query = "SELECT *  FROM persona WHERE ID_Persona = '$session'";
  $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);

  $temp = "SELECT * FROM ambiente_virtual WHERE ID_Persona = '$session'";
  $temp_result = mysqli_query($dbConnection, $temp) or die(mysqli_error($dbConnection));
  $temp_array = mysqli_fetch_all($temp_result, MYSQLI_NUM);

  if (isset($session)) {
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

      <p>Selecciona una ficha para consultar las publicaciones que has realizado.</p>
      <!-- GROUPS NAVIGATION -->
      <div class="nav-group">
        <div class="nav-group__title">Ficha</div>
        <select class="nav-group__select">
          <option value="-1" default="">Seleccione ficha</option>
          <?php
            for($i=0; $i < sizeof($temp_array); $i++){
          ?>
            <option value="<?php echo $i; ?>" default="" class="ficha"><?php echo $temp_array[$i][2]; ?></option>
          <?php
            }
          ?>

        </select>
        <a href="#publications" class="nav-group__btn">Buscar</a>
      </div>

      <!-- PUBLICATIONS OF GROUP SELECTED -->
      <div id="publications" class="publications">
        <?php
          for($i=0; $i < sizeof($temp_array); $i++){
            $program = $temp_array[$i][1];
            $ficha = $temp_array[$i][2];

            $publication = "SELECT P.ID_Publicacion, P.asunto, P.descripcion, P.fecha, P.fecha_limite, P.tipo_publicacion, P.url, A.ID_Programa FROM publicacion P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE P.ID_Ficha = $ficha AND A.ID_Programa = $program;";
            $publication_result = mysqli_query($dbConnection, $publication) or die(mysqli_error($dbConnection));
            $publication_array = mysqli_fetch_all($publication_result, MYSQLI_NUM);
          ?>
            <!-- CONTENEDOR DE PUBLICACIONES PARA FICHA <?php echo $i ?> -->
            <div class="publications-course publications-course<?php echo $i; ?> hidden">
              <!-- LABEL  -->
              <div class="publications-course__label">
                <?php 
                  if(sizeof($publication_array) > 0){
                    echo 'Selecciona la evidencia a consultar';
                  } else{
                    echo 'No has realizado ninguna publicación';
                  }
                ?>
              </div>
              <hr>
              <?php for($j=0; $j < sizeof($publication_array); $j++){?>

                <!-- PUBLICACION <?php echo $j ?> -->
                <div class="publication">
                  <div class="publication__title"><?php print_r($publication_array[$j][1]); ?></div>
                  <div class="publcation__date">Fecha publicación: <?php print_r($publication_array[$j][3]); ?></div>
                  <div class="publication__info">
                    <div class="publication__p"><?php print_r($publication_array[$j][2]); ?></div>
                    <div class="publication__date-limit"><?php print_r($publication_array[$j][4]); ?></div>
                    <div class="publication__type"><?php print_r($publication_array[$j][5]); ?></div>
                    <a class="publication__file" href="<?php print_r($publication_array[$j][6]); ?>" download=""><i class="fa-regular fa-file-lines"></i></a>
                  </div>

                  <div class="publication__btns">
                    <a href="FIXME?publication=<?php echo $publication_array[$j][0]?>" class="publication__btns-link">Editar>></a>
                    <a href="#evidences" id="<?php echo $i; ?>-<?php echo $j; ?>" class="publication__btns-evidences publication-btn">
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
          for($i=0; $i < sizeof($temp_array); $i++){
            $ficha = $temp_array[$i][2];

            // PUBLICATIONS BY GROUP
            $publications = "SELECT ID_Publicacion FROM `publicacion` WHERE ID_Persona = $session AND ID_Ficha = $ficha";
            $publications_result = mysqli_query($dbConnection, $publications) or die(mysqli_error($dbConnection));
            $publications_array = mysqli_fetch_all($publications_result, MYSQLI_NUM);
            ?> 

            <!-- CONTENEDOR PARA FICHA <?php echo $i?> -->
            <div class="evidences-course evidences-course--<?php echo $i?>">
              <?php
                for($j=0; $j < sizeof($publications_array); $j++){
                  $ID_Publicacion = $publications_array[$j][0];
                  ?>
                    <!-- CONTENEDOR DE EVIDENCIAS SUBIDAS DE PUBLICACION <?php echo $j ?>-->
                    <div class="evidences-<?php echo $i; ?>-<?php echo $j; ?> evidences evidences-publication hidden">
                      <?php 
                        $evidences = "SELECT E.ID_Evidencia, E.ID_Persona, E.ID_Publicacion, E.fecha, P.ID_Ficha FROM evidencia E JOIN publicacion P ON E.ID_Publicacion = P.ID_Publicacion WHERE P.ID_Ficha = $ficha AND P.ID_Publicacion = $ID_Publicacion AND E.nota IS NULL";
                        $evidences_result = mysqli_query($dbConnection, $evidences) or die(mysqli_error($dbConnection));
                        $evidences_array = mysqli_fetch_all($evidences_result, MYSQLI_NUM);
                        ?>
                        
                        <!-- LABEL EVIDENCIAS-->
                        <div class="evidences-course__label">
                          <?php
                            if(sizeof($evidences_array) > 1){
                              echo sizeof($evidences_array); echo " "; echo "Evidencias por calificar";
                            } else if (sizeof($evidences_array) == 1) {
                              echo sizeof($evidences_array); echo " "; echo "Evidencia por calificar";
                            } else{
                              echo "No hay evidencias por calificar";
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
                          <!-- <?php echo "EVIDENCIAS DE PUBLICACION CON ID "; echo $ID_Publicacion; ?> -->

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
    ?><script>window.location.assign('../index.html')</script><?php
  }
?>