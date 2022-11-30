<?php
  include_once "../../Models/connection.php";

  session_start();

  if (isset($_SESSION['id'])) {

  $id_user = $_GET['user'];

  // GET USER DATA
  $user = "SELECT nombres, apellidos, ID_Rol, ID_Tipo_documento, num_documento, correo_electronico, telefono FROM `persona` WHERE ID_Persona = $id_user";
  $user_result = mysqli_query($dbConnection, $user) or die(mysqli_error($dbConnection));
  $user_array = mysqli_fetch_all($user_result, MYSQLI_NUM);

  // GET ROL
  $role = $user_array[0][2];
  $role = "SELECT tipo FROM rol WHERE ID_Rol = $role";
  $role_result = mysqli_query($dbConnection, $role) or die(mysqli_error($dbConnection));
  $role = mysqli_fetch_all($role_result, MYSQLI_NUM);

  // GET DOCUMENT TYPE
  $type_doc = $user_array[0][3];
  $type_doc = "SELECT tipo FROM tipo_documento WHERE ID_Tipo_Documento = $type_doc";
  $type_doc_result = mysqli_query($dbConnection, $type_doc) or die(mysqli_error($dbConnection));
  $type_doc = mysqli_fetch_all($type_doc_result, MYSQLI_NUM);
    
  // GET AMBIENTE VIRTUAL OF USER
  $course_user = "SELECT * FROM ambiente_virtual WHERE ID_Persona = $id_user";
  $course_user_result = mysqli_query($dbConnection, $course_user) or die(mysqli_error($dbConnection));
  $course_user = mysqli_fetch_all($course_user_result, MYSQLI_NUM);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/admin.css" />
    <title>Gestión Usuario</title>
</head>
<body>
        <?php include './sidebar.php' ?>
        <h1 class="main-content__header">Gestión Usuario</h1>
        <div class="user">
            <div class="user-profile">
                <img class="user-profile__photo" src="../img/default.jpeg" alt="user-photo">
                <div class="user-profile__info">
                    <div class="user-profile__name"><?php echo $user_array[0][0] ;?> <?php echo $user_array[0][1] ;?></div>
                    <div class="user-profile__label">
                        <div class="user-profile__rol"><?php echo $role[0][0] ;?></div>
                        <div class="dot"></div>
                        <div class="user-profile__type-id"><?php echo $type_doc[0][0] ;?></div>
                        <div class="user-profile__id"><?php echo $user_array[0][4] ;?></div>
                    </div>
                    <div class="user-profile__contact">
                        <div class="user-profile__contact-data"><i class="fa-regular fa-envelope"></i><?php echo $user_array[0][5] ;?></div>
                        <div class="user-profile__contact-data"><i class="fa-solid fa-phone"></i><?php echo $user_array[0][6] ;?></div>
                    </div>
                </div>
            </div>
            <hr>

            <?php

              if($user_array[0][2] == 1){
                $announcements = "SELECT asunto, descripcion, fecha, url_portada, url_file, ID_Anuncio, ID_Persona FROM anuncio WHERE ID_Persona = $id_user";
                $announcements_result= mysqli_query($dbConnection, $announcements) or die(mysqli_error($dbConnection));
                $announcements = mysqli_fetch_all($announcements_result, MYSQLI_NUM);
                ?>
                <div class="announcements">
                    <h2 class="announcements__label">Anuncios publicados</h2>
                    <?php
                    if(sizeof($announcements) > 0){ 
                    for($i=0; $i < sizeof($announcements); $i++){
                        $id_owner = $announcements[$i][6];

                        // GET ANNOUNCEMENT'S OWNER
                        $owner = "SELECT nombres, apellidos FROM persona WHERE ID_Persona = $id_owner";
                        $owner_result= mysqli_query($dbConnection, $owner) or die(mysqli_error($dbConnection));
                        $owner = mysqli_fetch_all($owner_result, MYSQLI_NUM);
                    
                        ?>
                        <div class="announcement-management">
                        <div class="announcement" style="border: 2px solid rgba(186, 186, 186, 0.7294117647);">
                            <div class="announcement__owner">
                            <img class="announcement__owner-photo" src="../img/default.jpeg" alt="owner-photo">
                            <div>
                                <div class="announcement__owner-name"><?php echo $owner[0][0].' '.$owner[0][1] ?></div>
                                <div class="announcement__date">Fecha de publicación: <?php echo $announcements[$i][2] ?></div>
                            </div>
                            </div>
                            <div class="announcement__info">
                            <div class="announcement__title"><?php echo $announcements[$i][0] ?></div>
                            <div class="announcement__p"><?php echo $announcements[$i][1] ?></div>
                            <?php
                                if($announcements[$i][4] != ''){
                            ?>
                                <div class="announcement__file">
                                <div class="announcement__file-label">Archivos adjuntos:</div>
                                <a href="<?php echo $announcements[$i][4] ?>" class="file-element" download=""><i class="fa-regular fa-file-lines"></i> <span class="file-name"><?php echo $announcements[$i][4] ?></span></a>
                                </div>
                            <?php 
                                }
                            ?>
                            </div>
                            <?php
                                if($announcements[$i][3] != ''){
                            ?>
                                <img class="announcement__img" src="<?php echo $announcements[$i][3] ?>" alt="announcement-image">
                            <?php 
                                }
                            ?>
                        </div>
                        <div class="announcement-management__actions">
                            <a href="delete.php?delete_announcement=<?php echo $announcements[$i][5] ?>&id=<?php echo $id_user ?>" class="delete-button announcement-management__btn announcement-management__btn--delete"><i class="fa-solid fa-trash-can"></i></a>
                        </div>
                        </div>
                        <?php
                    }
                    } else {
                    ?>
                    <div class="neutral-message"><i class="fas fa-exclamation-triangle"></i> No hay anuncios publicados.</div>
                    <?php
                    }
                    ?>
                    
                </div>
                <?php
              }

              // TODO: If User is not Administrador -> Print Programs
              if($user_array[0][2] == 2 || $user_array[0][2] == 3){
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

              // TODO: If User is Instructor -> Print activities
              if($user_array[0][2] == 2){
                for($i=0; $i < sizeof($course_user); $i++){
                    $program = $course_user[$i][1];
                    $ficha = $course_user[$i][2];

                    $activities = "SELECT ID_Actividad, asunto, descripcion, fecha, fecha_limite, url FROM actividad WHERE ID_Ficha = $ficha AND ID_Persona =".$id_user;
                    $activities_result = mysqli_query($dbConnection, $activities) or die(mysqli_error($dbConnection));
                    $activities_array = mysqli_fetch_all($activities_result, MYSQLI_NUM);

                    ?>
                    <div class="user-activities">
                        <div class="user-label">Actividades para <?php echo $ficha ?></div>
                        <?php
                        if(sizeof($activities_array) > 0){
                            ?>
                            <div class="activities-course">
                                <div class="activities">
                                    <?php
                                    for($j=0; $j < sizeof($activities_array); $j++){
                                    ?>
                                    <!-- activity -->
                                    <div class="activity">
                                        <div class="activity__title"><?php echo $activities_array[$j][1]; ?></div>
                                        <div class="activity__date">Fecha publicación: <?php echo $activities_array[$j][3]; ?></div>
                                        <div class="activity__info">
                                        <div class="activity__p"><?php echo $activities_array[$j][2]; ?></div>
                                        <div class="activity__date-limit"><?php echo $activities_array[$j][4]; ?></div>
                                        <div class="activity__type">Actividad</div>
                                        <!-- VALIDAR EXISTENCIA FILE -->
                                        <?php
                                            if($activities_array[$j][5] != ''){
                                            ?>
                                            <a href="<?php print_r($activities_array[$j][5]); ?>" class="activity__file" download="">
                                            <i class="fa-regular fa-file-lines"></i>
                                            </a>
                                            <?php 
                                            }
                                        ?>
                                        </div>
                                        <a href="delete.php?delete_activity=<?php echo $activities_array[$j][0] ?>&id=<?php echo $id_user ?>" class="activity__btn-delete"><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php
                        } else {
                            ?>
                            <div class="activity-management">
                                <div class="alert-message"><i class="fas fa-exclamation-triangle"></i>El instructor no ha publicado actividades para esta ficha.</div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
              }

              // TODO: If User is Aprendiz -> Print Evidences
              if($user_array[0][2] == 3){

                for ($i=0; $i < sizeof($course_user); $i++) {
                    $program = $course_user[$i][1];
                    $ficha = $course_user[$i][2];

                    // GET PROGRAM NAME
                    $program_query = "SELECT nombre FROM programa_formacion WHERE ID_Programa = $program";
                    $program_result= mysqli_query($dbConnection, $program_query) or die(mysqli_error($dbConnection));
                    $program_array = mysqli_fetch_all($program_result, MYSQLI_NUM);
                    $program_name = $program_array[0][0];

                    // GET INSTRUCTOR BY AMBIENTE VIRTUAL
                    $instructor = "SELECT A.ID_Persona FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Programa = '$program' AND A.ID_Ficha = $ficha AND P.ID_Rol = 2";
                    $instructor_result = mysqli_query($dbConnection, $instructor) or die(mysqli_error($dbConnection));
                    $instructor_array = mysqli_fetch_all($instructor_result, MYSQLI_NUM);
                    
                    ?>
                        <div class="user-evidences">
                          <div class="user-label"><?php echo $program_name ?></div>
                          <?php
                          
                    if(sizeof($instructor_array) > 0){
                        $id_instructor = $instructor_array[0][0];

                        // GET INSTRUCTOR'S activity
                        $activity = "SELECT ID_Actividad, asunto FROM `actividad` WHERE ID_Persona = $id_instructor AND ID_Ficha = $ficha";
                        $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
                        $activity_array = mysqli_fetch_all($activity_result, MYSQLI_NUM);

                          if(sizeof($activity_array) > 0){
                              for ($j=0; $j < sizeof($activity_array); $j++) { 
                                  $id_activity = $activity_array[$j][0];
                                  $title_activity = $activity_array[$j][1];

                                  // GET EVIDENCES DELIVERED BY activity
                                  $evidences = "SELECT ID_Evidencia, fecha, nota, observacion, url, ID_Actividad FROM `evidencia` WHERE ID_Persona = $id_user AND ID_Actividad = $id_activity";
                                  $evidences_result = mysqli_query($dbConnection, $evidences) or die(mysqli_error($dbConnection));
                                  $evidences_array = mysqli_fetch_all($evidences_result, MYSQLI_NUM);

                                  if(sizeof($evidences_array) > 0){
                                      ?>
                                      <div class="evidence-management">
                                          <div class="user-evidence">
                                              <div class="user-evidence__activity">
                                                  <i class="fa-solid fa-book user-evidence__icon"></i>
                                                  <div class="user-evidence__title"><?php echo $title_activity ;?></div>
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
                                                  <div class="user-evidence__activity">
                                                      <i class="fa-solid fa-triangle-exclamation user-evidence__icon"></i>
                                                      <div class="user-evidence__title"><?php echo $title_activity ;?></div>
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
    <?php
      if(isset($_GET['message'])){
        if($_GET['message'] === 'unlinked') {
          ?><script>Swal.fire({icon: 'success',title: '¡Usuario desvinculado!',text: '¡El usuario ha sido desvinculado correctamente del programa!'});</script><?php
        } else if($_GET['message'] === 'evidence_deleted'){
          ?><script>Swal.fire({icon: 'success',title: 'Evidencia eliminada!',text: '¡La evidencia del aprendiz ha sido correctamente eliminada!'});</script><?php
        } else if($_GET['message'] === 'activity_deleted'){
          ?><script>Swal.fire({icon: 'success',title: 'Actividad eliminada!',text: 'La actividad y todos los entregables de aprendices de la misma han sido correctamente eliminados'});</script><?php
        } else if($_GET['message'] === 'announcement_deleted'){
          ?><script>Swal.fire({icon: 'success',title: 'Anuncio eliminado!',text: 'El anuncio ha sido correctamente eliminado'});</script><?php
        }
    	}
    ?>
    <script src="../../Controllers/file-name.js"></script>
    <script src="../../Controllers/course-acronym.js"></script>
    <script src="../../Controllers/view-user-control.js"></script>
</body>
</html>
<?php
      } else {
        include('../../Models/logout.php');
        $location = header('Location: ../index.php');
      }
?>