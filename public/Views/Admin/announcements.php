<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
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
    <title>Centro de Anuncios</title>
  </head>
  <body>
      <?php include './sidebar.php' ?>
      <h1 class="main-content__header">Centro de Anuncios 📢</h1>
      <div class="main-options">
        <!-- TODO: Crear boton de crear anuncio -->
        <a href="#" class="main-option create-ad">
          <i class="fa-solid fa-plus"></i>
          <div class="main-option__btn open-modal">Crear Anuncio</div>
        </a>
      </div>

      <!-- CREATE ANNOUNCEMENT FORM -->

      <form action="upload.php" method="post" enctype="multipart/form-data" class="modal-announcement float-form hidden" autocomplete="off">
        <!-- FORM HEADING -->
        <div class="float-form__title">Crear Anuncio</div>
        <hr>
        <!-- ASUNTO -->
        <div class="float-form__field">
          <input type="text" name="subject" class="float-form__field-input float-form__field-input--title" placeholder="Ingresa un título" maxlength="60">
        </div>
        <hr>
        <!-- DESCRIPCION -->
        <div class="float-form__field float-form__field--description">
          <div class="float-form__field-label">
            Descripción
          </div>
          <textarea name="description" class="float-form__field-input float" placeholder="Escribe una descripción" maxlength="600"></textarea>
        </div>
        <hr>

        <!-- FILE -->
        <div class="float-form__field">
          <div class="float-form__field-label">
            <i class="fa-solid fa-paperclip"></i>
            <span>Adjuntar archivo</span>
          </div>
          <div class="file-choise">
            <label for="file">
              <i class="fa-solid fa-paperclip"></i>
              <p class="file-name"></p>
            </label>
            <input type="file" name="file" id="file" class="file">
          </div>
        </div>
        <hr>

        <!-- IMAGE -->
        <div class="float-form__field">
          <div class="float-form__field-label">
            <i class="fa-regular fa-image"></i>
            <span>Portada (Opcional)</span>
          </div>
          <div class="file-choise">
            <label for="image">
              <i class="fa-solid fa-paperclip"></i>
              <p class="file-name"></p>
            </label>
            <input type="file" name="image" id="image" class="file">
          </div>
        </div>
        <hr>
        <div class="float-form__field">
          <div class="btn-close close-modal"><i class="fa-solid fa-trash-can"></i></div>
          <input type="submit" class="btn-submit" name="submit" value="Publicar" >
        </div>
      </form>
      <div class="overlay hidden"></div>


      <div class="announcements">
        <h2 class="announcements__label">Anuncios publicados</h2>
        <hr>
        <div class="announcement-management">
          <div class="announcement">
            <div class="announcement__owner">
              <img class="announcement__owner-photo" src="../img/default.jpeg" alt="owner-photo">
              <div>
                <div class="announcement__owner-name">Administrador</div>
                <div class="announcement__date">Fecha de publicación: 22-18-2</div>
              </div>
            </div>
            <div class="announcement__info">
              <div class="announcement__title">Fondo Emprender SENA</div>
              <div class="announcement__p">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita, dignissimos? Id ratione alias magnam ducimus at sit natus? Officia doloribus quisquam molestiae ullam in! Ab animi iure quidem quas? Quae, fuga quo. Ducimus est deserunt minima fugiat maiores nesciunt eius!</div>
            </div>
            <img class="announcement__img" src="../file-store/activities/wallpaper.png" alt="announcement-image">
          </div>
          <div class="announcement-management__actions">
            <a href="#" class="announcement-management__btn announcement-management__btn--delete"><i class="fa-solid fa-trash-can"></i></a>
            <a href="#" class="announcement-management__btn announcement-management__btn--edit"><i class="fa-solid fa-pen-to-square"></i></a>
          </div>
        </div>
        
      </div>
    </main>
    <style>
      body,html{
        scroll-behavior: unset !important;
      }
    </style>
    <script src="../../Controllers/admin-control.js"></script>
  </body>
</html>
  <?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?> 
