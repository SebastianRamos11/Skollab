<?php
  include_once "../../Models/connection.php";

  session_start();

  if (isset($_SESSION['id'])) {

  $id_user = $_GET['user'];

  // GET USER DATA
  $user = "SELECT nombres, apellidos, rol, correo_electronico, telefono FROM `persona` WHERE ID_Persona = $id_user";
  $user_result = mysqli_query($dbConnection, $user) or die(mysqli_error($dbConnection));
  $user_array = mysqli_fetch_all($user_result, MYSQLI_NUM);

  // GET AMBIENTE VIRTUAL OF USER
  $course_user = "SELECT * FROM ambiente_virtual WHERE ID_Persona = $id_user";
  $course_user_result = mysqli_query($dbConnection, $course_user) or die(mysqli_error($dbConnection));
  $course_user = mysqli_fetch_all($course_user_result, MYSQLI_NUM);

  // TODO: Function that removes the user from the program
  

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, qinitial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/admin.css" />
    <title>Gestión Usuario</title>
</head>
<body>
    <?php 
      if(isset($_GET['message']) and $_GET['message'] == 'unlinked'){
    ?>
      <script>
          Swal.fire({
              icon: 'success',
              title: '¡Usuario desvinculado!',
              text: '¡El usuario ha sido desvinculado correctamente del programa!'
          });
      </script>
    <?php 
      }
    ?>
    <?php 
      if(isset($_GET['message']) and $_GET['message'] == 'evidence_deleted'){
    ?>
      <script>
          Swal.fire({
              icon: 'success',
              title: 'Evidencia eliminada!',
              text: '¡La evidencia del aprendiz ha sido correctamente eliminada!'
          });
      </script>
    <?php 
      }
    ?>
        <?php 
      if(isset($_GET['message']) and $_GET['message'] == 'publication_deleted'){
    ?>
      <script>
          Swal.fire({
              icon: 'success',
              title: 'Publicación eliminada!',
              text: 'La publicación y todos los entregables de aprendices de la misma han sido correctamente eliminados'
          });
      </script>
    <?php 
      }
    ?>
        <?php include './sidebar.php' ?>
        <h1 class="main-content__header">Gestión Usuario</h1>
        <div class="user">
            <div class="user-profile">
                <img class="user-profile__photo" src="../img/default.jpeg" alt="user-photo">
                <div class="user-profile__info">
                    <div class="user-profile__name"><?php echo $user_array[0][0] ;?> <?php echo $user_array[0][1] ;?></div>
                    <div class="user-profile__label">
                        <div class="user-profile__rol"><?php echo $user_array[0][2] ;?></div>
                        <div class="dot"></div>
                        <div class="user-profile__id"><?php echo $id_user ;?></div>
                    </div>
                    <div class="user-profile__contact">
                        <div class="user-profile__contact-data"><i class="fa-regular fa-envelope"></i><?php echo $user_array[0][3] ;?></div>
                        <div class="user-profile__contact-data"><i class="fa-solid fa-phone"></i><?php echo $user_array[0][4] ;?></div>
                    </div>
                </div>
            </div>
            <hr>

            <?php

              // TODO: If User is Administrador -> Print Anuncios (No created for now)
              if($user_array[0][2] == "ADMINISTRADOR"){
                echo 'Anuncios';
              }

              // TODO: If User is not Administrador -> Print Programs
              if($user_array[0][2] == "INSTRUCTOR" || $user_array[0][2] == "APRENDIZ"){
                ?>
                <div class="user-programs">
                <div class="user-programs__label">Programas de formación</div>

                <?php
                if(sizeof($course_user) > 0){
                    for($i=0; $i < sizeof($course_user); $i++){
                        $program = $course_user[$i][1];
                        $ficha = $course_user[$i][2];

                        // GET PROGRAM NAME
                        $program_query = "SELECT nombre FROM programa_formacion WHERE ID_Programa = $program";
                        $program_result= mysqli_query($dbConnection, $program_query) or die(mysqli_error($dbConnection));
                        $program_array = mysqli_fetch_all($program_result, MYSQLI_NUM);
                        $program_name = $program_array[0][0];
                    ?>
                        <div class="course course--management course-<?php echo $i ?>">
                          <div class="course__title"><?php echo $program_name; ?></div>
                          <div class="course__id"><?php echo $ficha; ?></div>
                          <img class="course__figure" src="../img/courses/sena-logo.png" alt="course">
                          <a class="course__unlink" href="delete.php?program=<?php echo $program ?>&id=<?php echo $id_user ?>"><i class="fa-solid fa-trash-can"></i>Desvincular</a>
                        </div>
                    <?php
                    }
                } else{
                    ?>
                    <div class="alert-message"><i class="fas fa-exclamation-triangle"></i>Este usuario no está vinculado a ningún programa de formación.</div>
                    <?php
                }
                ?>
                </div>
                <hr>
                <?php
              }

              // TODO: If User is Instructor -> Print publication
              if($user_array[0][2] == "INSTRUCTOR"){
                for($i=0; $i < sizeof($course_user); $i++){
                    $program = $course_user[$i][1];
                    $ficha = $course_user[$i][2];

                    $publications = "SELECT ID_Publicacion, asunto, descripcion, fecha, fecha_limite, tipo_publicacion, url FROM publicacion WHERE ID_Ficha = $ficha AND ID_Persona =".$id_user;
                    $publications_result = mysqli_query($dbConnection, $publications) or die(mysqli_error($dbConnection));
                    $publications_array = mysqli_fetch_all($publications_result, MYSQLI_NUM);

                    ?>
                    <div class="user-publications">
                        <div class="user-label">Evidencias para <?php echo $ficha ?></div>
                        <?php
                        if(sizeof($publications_array) > 0){
                            ?>
                            <div class="publications-course">
                                <?php
                                for($j=0; $j < sizeof($publications_array); $j++){
                                ?>
                                  <!-- PUBLICATION -->
                                  <div class="publication">
                                    <div class="publication__title"><?php echo $publications_array[$j][1]; ?></div>
                                    <div class="publcation__date">Fecha publicación: <?php echo $publications_array[$j][3]; ?></div>
                                    <div class="publication__info">
                                      <div class="publication__p"><?php echo $publications_array[$j][2]; ?></div>
                                      <div class="publication__date-limit"><?php echo $publications_array[$j][4]; ?></div>
                                      <div class="publication__type"><?php echo $publications_array[$j][5]; ?></div>
                                      <!-- VALIDAR EXISTENCIA FILE -->
                                      <?php
                                        if($publications_array[$j][6] != ''){
                                          ?>
                                        <a href="<?php print_r($publications_array[$j][6]); ?>" class="publication__file" download="">
                                          <i class="fa-regular fa-file-lines"></i>
                                        </a>
                                        <?php 
                                        }
                                      ?>
                                    </div>
                                    <a href="delete.php?delete_publication=<?php echo $publications_array[$j][0] ?>&id=<?php echo $id_user ?>" class="publication__btn-delete"><i class="fa-solid fa-trash-can"></i></a>
                                  </div>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        } else {
                            ?>
                            <div class="publication-management">
                                <div class="alert-message"><i class="fas fa-exclamation-triangle"></i>El instructor no ha publicado evidencias para esta ficha.</div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
              }

              // TODO: If User is Aprendiz -> Print Evidences
              if($user_array[0][2] == "APRENDIZ"){

                for ($i=0; $i < sizeof($course_user); $i++) {
                    $program = $course_user[$i][1];
                    $ficha = $course_user[$i][2];

                    // GET PROGRAM NAME
                    $program_query = "SELECT nombre FROM programa_formacion WHERE ID_Programa = $program";
                    $program_result= mysqli_query($dbConnection, $program_query) or die(mysqli_error($dbConnection));
                    $program_array = mysqli_fetch_all($program_result, MYSQLI_NUM);
                    $program_name = $program_array[0][0];

                    // GET INSTRUCTOR BY AMBIENTE VIRTUAL
                    $instructor = "SELECT A.ID_Persona FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Programa = '$program' AND A.ID_Ficha = $ficha AND P.rol = 'INSTRUCTOR'";
                    $instructor_result = mysqli_query($dbConnection, $instructor) or die(mysqli_error($dbConnection));
                    $instructor_array = mysqli_fetch_all($instructor_result, MYSQLI_NUM);
                    
                    ?>
                        <div class="user-evidences">
                          <div class="user-label"><?php echo $program_name ?></div>
                          <?php
                          
                    if(sizeof($instructor_array) > 0){
                        $id_instructor = $instructor_array[0][0];

                        // GET INSTRUCTOR'S publication
                        $publication = "SELECT ID_Publicacion, asunto FROM `publicacion` WHERE ID_Persona = $id_instructor AND ID_Ficha = $ficha";
                        $publication_result = mysqli_query($dbConnection, $publication) or die(mysqli_error($dbConnection));
                        $publication_array = mysqli_fetch_all($publication_result, MYSQLI_NUM);

                          if(sizeof($publication_array) > 0){
                              for ($j=0; $j < sizeof($publication_array); $j++) { 
                                  $id_publication = $publication_array[$j][0];
                                  $title_publication = $publication_array[$j][1];

                                  // GET EVIDENCES DELIVERED BY PUBLICATION
                                  $evidences = "SELECT ID_Evidencia, fecha, nota, observacion, url, ID_Publicacion FROM `evidencia` WHERE ID_Persona = $id_user AND ID_Publicacion = $id_publication";
                                  $evidences_result = mysqli_query($dbConnection, $evidences) or die(mysqli_error($dbConnection));
                                  $evidences_array = mysqli_fetch_all($evidences_result, MYSQLI_NUM);

                                  if(sizeof($evidences_array) > 0){
                                      ?>
                                      <div class="evidence-management">
                                          <div class="user-evidence">
                                              <div class="user-evidence__publication">
                                                  <i class="fa-solid fa-book user-evidence__icon"></i>
                                                  <div class="user-evidence__title"><?php echo $title_publication ;?></div>
                                              </div>
                                              <div class="user-evidence__date"><?php echo $evidences_array[0][1] ;?></div>
                                              <div class="user-evidence__grade">
                                                  <div class="user-evidence__grade-value">
                                                      <?php
                                                          if($evidences_array[0][2] != ''){
                                                              ?>
                                                              <span class="gradeValue"><?php echo $evidences_array[0][2] ?>/100</span>
                                                              <?php
                                                          } else{
                                                              echo "--/100";
                                                          }
                                                      ?>
                                                  </div>
                                                  <div class="user-evidence__grade-range">
                                                      <?php
                                                          if($evidences_array[0][2] != ''){
                                                              ?>
                                                              <span class="<?php
                                                                      if(intval($evidences_array[0][2]) > 80){
                                                                          echo "grade-a";
                                                                      }else if(intval($evidences_array[0][2]) > 60){
                                                                          echo "grade-b";
                                                                      } else{
                                                                          echo "grade-d";
                                                                      }
                                                                  ?>" style="width: <?php echo $evidences_array[0][2] ?>%;"></span>
                                                              <?php
                                                          } else{
                                                              ?>
                                                              <span style="width: 0;"></span>
                                                              <?php
                                                          }
                                                      ?>
                                                  </div>
                                              </div>
                                              <div class="user-evidence__icons">
                                                  <div class="user-evidence__observation">
                                                      <i class="fa-regular fa-comment-dots"></i>
                                                      <div class="user-evidence__observation-p">
                                                          <?php
                                                              if($evidences_array[0][3] != ''){
                                                                  echo "1";
                                                              } else{
                                                                  echo "0";
                                                              }
                                                          ?>
                                                      </div>
                                                  </div>
                                                  <a href="<?php echo $evidences_array[0][4] ;?>" class="user-evidence__file" download=""><i class="fa-regular fa-file-lines"></i></a>
                                              </div>
                                          </div>
                                          <a href="delete.php?delete_evidence=<?php echo $evidences_array[0][0] ?>&id=<?php echo $id_user ?>" class="evidence-management__btn-delete"><i class="fa-solid fa-trash-can"></i></a>
                                      </div>
                                  <?php
                                  } else{
                                      ?>
                                          <div class="evidence-management">
                                              <div class="user-evidence user-evidence--empty">
                                                  <div class="user-evidence__publication">
                                                      <i class="fa-solid fa-triangle-exclamation user-evidence__icon"></i>
                                                      <div class="user-evidence__title"><?php echo $title_publication ;?></div>
                                                  </div>
                                                  <div class="user-evidence--empty__alert">SIN ENTREGA</div>
                                              </div>
                                          </div>
                                      <?php
                                  }
                              }
                          } else{
                              ?>
                              <div class="alert-message"><i class="fas fa-exclamation-triangle"></i>El instructor no ha publicado ninguna evidencia.</div>
                              <?php
                          }   
                          ?>
                          </div>
                          <?php
                    } else{
                        ?>
                            <div class="alert-message"><i class="fas fa-exclamation-triangle"></i>Ningún instructor ha sido asignado para esta ficha.</div>
                        <?php
                    }
                }
                }
              ?>
            <!-- TODO: If User is Aprendiz -> Print 👇 -->

        </div>
    </main>
    <style>
      body, html{
          background: #fff !important;
      }
      .nav{
          border-right: 1px solid #c2c2c2;
      }
    </style>
    <script src="../../Controllers/view-user-control.js"></script>
</body>
</html>
<?php
      } else {
        include('../../Models/logout.php');
        $location = header('Location: ../index.php');
      }
?>