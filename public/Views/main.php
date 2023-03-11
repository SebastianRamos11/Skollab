<?php
  include_once "../Models/connection.php";
  session_start();

  if (isset($_SESSION['id'])) {
    // GET USER ROL
    $user_role = "SELECT ID_Rol FROM persona WHERE ID_Persona = ".$_SESSION['id'];
    $user_role_result = mysqli_query($dbConnection, $user_role) or die(mysqli_error($dbConnection));
    $user_role = mysqli_fetch_all($user_role_result, MYSQLI_NUM)[0][0];

    // GET COURSES
    $groups = "SELECT A.ID_Ficha, F.numero FROM ambiente_virtual A JOIN ficha F ON A.ID_Ficha = F.ID_Ficha WHERE ID_Persona =".$_SESSION['id'];
    $groups_result = mysqli_query($dbConnection, $groups) or die(mysqli_error($dbConnection));
    $groups = mysqli_fetch_all($groups_result, MYSQLI_NUM);

    $announcements = "SELECT asunto, descripcion, fecha, url_portada, url_file, ID_Anuncio, ID_Persona FROM anuncio";
    $announcements_result= mysqli_query($dbConnection, $announcements) or die(mysqli_error($dbConnection));
    $announcements = mysqli_fetch_all($announcements_result, MYSQLI_NUM);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <title>Mi Perfil</title>
  </head>
  <body>
    <?php include_once "navbar.php"; ?>
    <main class="main-content">
      <h1 class="main-content__title" style="margin: 0;">Bienvenido, <?php if($user[0][0] == 2){ echo "Instructor";} else { echo "Aprendiz";}?> 👋</h1>
      <div class="banner"><p class="banner__p">¡Skollab es la mejor app para gestionar tu aprendizaje!</p></div>
      <div class="user-courses">
        <div class="main-content__title"><h2>Cursos en formación</h2><hr></div>
        <div class="user-courses__container" <?php if(sizeof($groups) > 0){ echo 'style="margin-top: 30px;"'; }?>>
          <?php 
            for($i = 0; $i < sizeof($groups); $i++){
              ?>
              <div class="course">
                <div class="course__title"><?php echo $groups[$i][1]; ?></div>
                <img class="course__figure" src="./img/courses/sena-logo.png" alt="course">
                <a href="<?php if($user[0][0] == 2) { echo "./Instructor/activities.php"; } else { echo "./Aprendiz/activities-center.php"; } ?>?group=<?php echo $groups[$i][0] ?>" class="course__link">Ambiente virtual >></a>
              </div>
              <?php
            }
            if($user_role == 3){
              ?><a href="#" class="add-course-btn open-modal-btn" title="Unirse a un curso"><i class="fa-solid fa-plus"></i> Unirse a un curso</a><?php
            }
            ?>
        </div>
        <?php 
          if($user_role == 2 && sizeof($groups) < 1){
            ?><div class="alert-message"><i class="fas fa-exclamation-triangle"></i> No estas instruyendo ningún curso, espera a que algún administrador te registre a uno.</div><?php
          }
        ?>
      </div>
      <div class="announcements">
        <h2 class="announcements__label">Anuncios y novedades</h2>
        <hr>
        <?php
          if(sizeof($announcements) > 0){
            ?>
            <div class="announcements__container">
              <?php
                for($i = sizeof($announcements) - 1; $i >= 0; $i--){
                  $id_owner = $announcements[$i][6];

                  // GET ANNOUNCEMENT'S OWNER
                  $owner = "SELECT nombres, apellidos FROM persona WHERE ID_Persona = $id_owner";
                  $owner_result= mysqli_query($dbConnection, $owner) or die(mysqli_error($dbConnection));
                  $owner = mysqli_fetch_all($owner_result, MYSQLI_NUM);
                
                  ?>
                  <div class="announcement">
                    <div class="announcement__owner">
                      <img class="announcement__owner-photo" src="img/default.jpeg" alt="owner-photo">
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
                  <?php
                }
              ?>
            </div>
            <?php
          } else {
            ?><div class="neutral-message"><i class="fas fa-exclamation-triangle"></i> No hay anuncios publicados.</div><?php
          }
        ?>
      </div>
    </main>
    
    <!-- ADD COURSE FORM -->
    <form action="course-inscription.php" method="POST" class="course-form modal-form hidden" autocomplete="off">
      <div class="close-modal">&times;</div>
      <div class="course-form__data">
        <div class="course-form__field">
          <label for="course-num" class="course-form__field-label">Número de curso</label>
          <input type="text" name="course-num" id="course-num" class="course-form__field-input" placeholder="Escribe el número de curso.">
        </div>
        <div class="course-form__field">
          <label for="course-code" class="course-form__field-label">Código de unión</label>
          <input type="text" name="course-code" id="course-code" class="course-form__field-input" placeholder="Escribe el código enviado por el instructor.">
        </div>
        <input type="submit" value="Siguiente" class="course-form__submit">
      </div>
    </form>
    <div class="overlay hidden"></div>
    <?php
      if(isset($_GET['message'])){
        if($_GET['message'] === 'error') {
          ?><script>Swal.fire({icon: 'error',title: 'Error',text: 'El número de curso o el código de unión son incorrectos.'});</script><?php
        } else if($_GET['message'] === 'registered'){
          ?><script>Swal.fire({icon: 'success',title: 'Inscrito',text: 'Te has inscrito correctamente a este curso.'});</script><?php
        } else if($_GET['message'] === 'already-registered'){
          ?><script>Swal.fire({icon: 'error',title: 'Error',text: 'Ya estás inscrito a este curso.'});</script><?php
        }
      }
    ?>
    <script src="../Controllers/modal-form.js"></script>
  </body>
  <style>body, html{background: #fff !important;}.nav{border-bottom: 1px solid #c2c2c2;}.announcement{border: 1px solid #868686;}.main-content{padding: 40px;}</style>
</html>
<?php
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>