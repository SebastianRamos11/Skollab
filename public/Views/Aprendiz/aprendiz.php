<?php

  include_once "../../Models/connection.php";
  include_once "../../Models/session.php";

  $read_query = "SELECT * FROM persona WHERE ID_Persona = '$session'";
  $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);

  $program_query = "SELECT * FROM programa_formacion";
  $program_result= mysqli_query($dbConnection, $program_query) or die(mysqli_error($dbConnection));
  $program_array = mysqli_fetch_all($program_result, MYSQLI_NUM);
  
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/aprendiz.css" />
    <title>Inicio</title>
  </head>
  <body>
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">Bienvenido Aprendiz 👋</h1>

        <!-- BANNER (CONTADOR DE EVIDENCIAS PENDIENTES) -->
        <div class="banner">
          <p class="banner__p">Tienes 3 evidencias por entregar, ¡Ponte al día!</p>
        </div>

        <!-- TRANSVERSALES -->
        <div class="courses">
          <h2 class="courses__title">Transversales</h2>
          <div class="courses__list">
            <?php for ($j=0; $j < sizeof($temp_array); $j++) { 

              $program = $temp_array[$j][1];
              $ficha = $temp_array[$j][2]; 
              
              $get_program = "SELECT nombre FROM programa_formacion WHERE ID_Programa = '$program'";
              $get_program_result = mysqli_query($dbConnection, $get_program) or die(mysqli_error($dbConnection));
              $get_program_array = mysqli_fetch_all($get_program_result, MYSQLI_NUM);


              // $get_course = "SELECT A.ID_Programa, A.ID_Ficha FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Programa = '$program' AND A.ID_Ficha = $ficha";
              // $get_course_result = mysqli_query($dbConnection, $get_course) or die(mysqli_error($dbConnection));
              // $get_course_result_array = mysqli_fetch_all($get_course_result, MYSQLI_NUM);
            ?>
              <button class="course">
                <div class="course__title"><?php print_r($get_program_array[0][0]); ?></div>
                <div class="course__id"><?php echo $temp_array[$j][2]; ?></div>
                <img class="course__figure" src="../img/courses/sena-logo.png" alt="course">
              </button>
            <?php 
            }
            ?>

            
          </div>
        </div>

        

        <!-- EVIDENCIAS PENDIENTES -->
        <div class="evidences hidden">
          <h2 class="evidences__title">Evidencias</h2>
          <?php
            for($i=0; $i < sizeof($temp_array); $i++){
              $program = $temp_array[$i][1];
              $ficha = $temp_array[$i][2]; 

              $publication = "SELECT P.ID_Publicacion, P.asunto, P.descripcion, P.fecha, P.tipo_publicacion, P.url, A.ID_Programa FROM publicacion P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE P.ID_Ficha = $ficha AND A.ID_Programa = $program;";
              $publication_result = mysqli_query($dbConnection, $publication) or die(mysqli_error($dbConnection));
              $publication_array = mysqli_fetch_all($publication_result, MYSQLI_NUM);

              ?>
              <div class="publications-course publications-course--<?php echo $i; ?> hidden">
                <?php
                  for($j=0; $j < sizeof($publication_array); $j++){
                ?>
                    <div class="publication">
                      <div class="publication__title"><?php print_r($publication_array[$j][1]); ?></div>
                      <div class="publication__info">
                        <div class="publication__p"><?php print_r($publication_array[$j][2]); ?></div>
                        <div class="publication__date"><?php print_r($publication_array[$j][3]); ?></div>
                        <div class="publication__type"><?php print_r($publication_array[$j][4]); ?></div>
                      </div>
                      <div class="publication__btns">
                        <a href="<?php print_r($publication_array[$j][5]); ?>" class="publication__btns-file" download="">
                          <i class="fa-regular fa-file-lines"></i>
                          <span class="file-name"><?php print_r($publication_array[$j][5]); ?></span>
                        </a>
                        <a href="evidence.php?evidence=<?php echo $publication_array[$j][0]?>" class="publication__btns-link">Ver detalles...</a>
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
        ?><script>window.location.assign('../index.html')</script><?php
      }
?>  
