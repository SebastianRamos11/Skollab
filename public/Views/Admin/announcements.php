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
      <div class="edit-slider">
        <i class="fa-solid fa-pen-to-square"></i>
        <div class="edit-slider__btn">Editar Slider</div>
      </div>

      <div class="announcements">
        <h2 class="announcements__label">Anuncios publicados</h2>
        <hr>
        <div class="announcement-management">
          <div class="announcement">
            <div class="announcement__title">Fondo Emprender SENA</div>
            <div class="announcement__p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis delectus, suscipit quo numquam at odit, eveniet tenetur aliquam dolorem beatae ad tempora consectetur laborum, perspiciatis accusamus voluptatum rerum recusandae! Doloremque?</div>
            <img class="announcement__img" src="../file-store/publications/wallpaper.png" alt="">
          </div>
          <div class="announcement-management__actions">
            <a href="#" class="announcement-management__btn announcement-management__btn--delete"><i class="fa-solid fa-trash-can"></i></a>
            <a href="#" class="announcement-management__btn announcement-management__btn--edit"><i class="fa-solid fa-pen-to-square"></i></a>
          </div>
        </div>
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
