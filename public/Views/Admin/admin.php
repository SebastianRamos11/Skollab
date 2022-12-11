<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    
    $announcements = "SELECT asunto, descripcion, fecha, url_portada, url_file, ID_Anuncio, ID_Persona FROM anuncio";
    $announcements_result= mysqli_query($dbConnection, $announcements) or die(mysqli_error($dbConnection));
    $announcements = mysqli_fetch_all($announcements_result, MYSQLI_NUM);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/admin.css" />
    <title>Inicio</title>
  </head>
  <body id="body">
    <?php include './sidebar.php' ?>
      <h1 class="main-content__header">Bienvenido administrador 👋</h1>
      <div class="main-options">
        <!-- TODO: Crear boton de crear anuncio -->
        <a href="#" class="main-option create-ad open-modal-btn">
          <i class="fa-solid fa-plus"></i>
          <div class="main-option__btn open-modal">Crear Anuncio</div>
        </a>
      </div>

      <form action="upload.php" method="post" enctype="multipart/form-data" class="modal-form modal-announcement float-form hidden" autocomplete="off">
        <!-- FORM HEADING -->
        <div class="float-form__title">Crear Anuncio</div>
        <hr>
        <!-- ASUNTO -->
        <div class="float-form__field">
          <input type="text" name="subject" class="float-form__field-input float-form__field-input--title" placeholder="Ingresa un título" maxlength="60" required>
        </div>
        <hr>
        <!-- DESCRIPCION -->
        <div class="float-form__field float-form__field--description">
          <div class="float-form__field-label">Descripción</div>
          <textarea name="description" class="float-form__field-input float" placeholder="Escribe una descripción" maxlength="600" required></textarea>
        </div>
        <hr>
        <div class="float-form__field-group">
          <div class="float-form__field ">
            <div class="float-form__field-label"><i class="fa-solid fa-paperclip"></i><span>Adjuntar archivo</span></div>
            <div class="file-choise">
              <label for="file"><i class="fa-solid fa-paperclip"></i><p class="uploaded-file"></p></label>
              <input type="file" name="file" id="file" class="file">
            </div>
          </div>
          <!-- IMAGE -->
          <div class="float-form__field">
            <div class="float-form__field-label"><i class="fa-regular fa-image"></i><span>Portada</span></div>
            <div class="file-choise">
              <label for="image"><i class="fa-solid fa-paperclip"></i><p class="uploaded-file"></p></label>
              <input type="file" name="image" id="image" class="file" accept="image/png, image/gif, image/jpeg">
            </div>
          </div>
        </div>
        <!-- FILE -->
        <hr>
        <div class="float-form__field">
          <input type="submit" class="btn-submit" name="submit" value="Publicar" style="margin-left: auto;">
        </div>
        <div class="btn-close close-modal"><i class="fa-solid fa-xmark"></i></div>
      </form>
      <div class="overlay hidden"></div>

      <div class="announcements">
        <h2 class="announcements__label">Anuncios y Novedades</h2>
        <hr>
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
                <div class="announcement">
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
                  <a href="delete.php?delete_announcement=<?php echo $announcements[$i][5] ?>" class="delete-button announcement-management__btn announcement-management__btn--delete"><i class="fa-solid fa-trash-can"></i></a>
                  <a href="edit-announcement.php?announcement=<?php echo $announcements[$i][5] ?>" class="announcement-management__btn announcement-management__btn--edit"><i class="fa-solid fa-pen-to-square"></i></a>
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
    </main>
    <script src="../../Controllers/modal-form.js"></script>
    <script src="../../Controllers/file-name.js"></script>
    <script src="../../Controllers/file-upload.js"></script>
    <script src="../../Controllers/confirm-deletion.js"></script>
    <script>confirmDeletion('¿Seguro que quieres eliminar este anuncio?')</script>
    <?php
      if(isset($_GET['message'])){
        if($_GET['message'] === 'uploaded') {
          ?><script>Swal.fire({icon: 'success',title: '¡Anuncio publicado!',text: 'El anuncio ha sido publicado correctamente'});</script><?php
        } else if($_GET['message'] === 'updated'){
          ?><script>Swal.fire({icon: 'success',title: '¡Anuncio modificado!',text: '¡El anuncio ha sido modificado correctamente!'});</script><?php
        } else if($_GET['message'] === 'deleted'){
          ?><script>Swal.fire({icon: 'success',title: 'Anuncio eliminado',text: 'El anuncio ha sido eliminado correctamente'});</script><?php
        }
      }
    ?>
  </body>
</html>
  <?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>
