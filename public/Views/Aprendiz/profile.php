<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/instructor.css" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Mi Perfil</title>
  </head>
  <body>
  <?php
      include_once "../../Models/connection.php";
      include_once "../../Models/session.php";
      $read_query = "SELECT *  FROM persona WHERE ID_Persona = '$session'";
      $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
      $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);
    ?>
    <?php include './sidebar.php' ?>
    <h1 class="main-content__header">Mi Perfil</h1>
    <p class="main-content__p">Actualiza tus datos de perfil aquí</p>

    <!-- ALERTS -->

    <!-- Empty data -->
    <?php 
      if(isset($_GET['message']) and $_GET['message'] == 'empty'){
    ?>
      <script>
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: '¡Tiene que llenar todos los campos!'
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
              text: '¡Ha habido algun problema!'
          });
      </script>
    <?php 
      }
    ?>
    <!-- Updated successfully -->
    <?php 
      if(isset($_GET['message']) and $_GET['message'] == 'updated'){
    ?>
      <script>
          Swal.fire({
              icon: 'success',
              title: '¡Datos actualizados!',
              text: '¡Tus datos han sido actualizados correctamente!'
          });
      </script>
    <?php 
      }
    ?>

    <div class="profile">

        <!-- USER PHOTO -->
        <div class="profile-photo">
            <div class="profile-photo__title">Foto de Perfil</div>
            <img src="../img/default.jpeg" alt="avatar" class="profile-photo__img">
            <div class="profile-photo__btns">
                <button class="profile-photo__btn-change">Cambiar foto</button>
                <button class="profile-photo__btn-delete"><i class="fa-solid fa-trash-can"></i>Suprimir</button>
            </div>
            <p class="profile-photo__p">Actualiza tu foto. El tamaño recomendado es de 256x256px</p>
        </div>

        <!-- BANNER -->
        <div class="profile-banner">
            <div class="profile-banner__info">
                <div class="profile-banner__title">Mantén tus datos actualizados</div>
                <div class="profile-banner__p">Te recomendamos que mantengas tus datos actualizados para que los demás usuarios puedan contectarte correctamente</div>
            </div>
            <img src="../img/figures/profile-banner.png" alt="user" class="profile-banner__figure">
        </div>
        

        <!-- USER INFORMATION (DATA FIELDS) -->
        <form action="update.php" class="form profile__info" method="POST">
            <div class="profile__field">
                <div class="profile__field-label">Nombres</div>
                <input type="text" id="firstName" name="firstName" class="profile__field-input" value="<?php echo $result_array[0][1]?>">
            </div>
            <div class="profile__field">
                <div class="profile__field-label">Apellidos</div>
                <input type="text" id="lastName" name="lastName" class="profile__field-input" value="<?php echo $result_array[0][2]?>">
            </div>
            <div class="profile__field">
                <div class="profile__field-label">Correo electrónico</div>
                <input type="text" id="email" name="email" class="profile__field-input" value="<?php echo $result_array[0][5]?>">
            </div>
            <div class="profile__field hidden">
                <div class="profile__field-label">Documento de identidad</div>
                    <input type="text" id="id" name="id" class="profile__field-input" value="<?php echo $result_array[0][0]?>">
            </div>
            <div class="profile__field">
                <div class="profile__field-label">Fecha de nacimiento</div>
                <input type="date" id="birthYear" name="birthYear" class="profile__field-input type-date" value="<?php echo $result_array[0][3]?>">
            </div>
            <div class="profile__field">
                <div class="profile__field-label">Teléfono</div>
                <input type="text" id="phone" name="phone" class="profile__field-input" value="<?php echo $result_array[0][7]?>" >
            </div>
            <input type="submit" class="submit-btn" value="Guardar">
        </div>

    </div>

  </body>

  <style>
    body{
        background: #fff !important;
    }
    .nav{
        border-right: 1px solid #c2c2c2;
    }
  </style>
</html>