<?php
  include_once "../Models/connection.php";
  session_start();

  if (isset($_SESSION['id'])) {
    $user_data = "SELECT nombres, apellidos, correo_electronico, fecha_nacimiento, telefono FROM persona WHERE ID_Persona =".$_SESSION['id'];
    $data_result = mysqli_query($dbConnection, $user_data) or die(mysqli_error($dbConnection));
    $user_data = mysqli_fetch_all($data_result, MYSQLI_NUM);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Mi Perfil</title>
  </head>
  <body>
    <main class="main-content">
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

<?php include_once "navbar.php"; ?>
<div class="profile">
    <h1 class="profile__header">Mi Perfil</h1>
    <p class="profile__p">Actualiza tus datos de perfil aquí</p>

  <!-- USER PHOTO -->
  <div class="profile-photo">
    <div class="profile-photo__title">Foto de Perfil</div>
            <img src="img/default.jpeg" alt="avatar" class="profile-photo__img">
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
            <img src="img/figures/profile-banner.png" alt="user" class="profile-banner__figure">
        </div>
        

        <!-- USER INFORMATION (DATA FIELDS) -->
        <form action="update-profile.php?id=<?php echo $_SESSION['id'] ?>" class="form profile__info" method="POST">
            <div class="profile__field">
              <div class="profile__field-label">Nombres</div>
                <input type="text" id="firstName" name="firstName" class="profile__field-input" value="<?php echo $user_data[0][0]?>">
              </div>

              <div class="profile__field">
                <div class="profile__field-label">Apellidos</div>
                <input type="text" id="lastName" name="lastName" class="profile__field-input" value="<?php echo $user_data[0][1]?>">
              </div>

              <div class="profile__field">
                <div class="profile__field-label">Correo electrónico</div>
                <input type="text" id="email" name="email" class="profile__field-input" value="<?php echo $user_data[0][2]?>">
              </div>

              <div class="profile__field">
                <div class="profile__field-label">Fecha de nacimiento</div>
                <input type="date" id="birthYear" name="birthYear" class="profile__field-input type-date" value="<?php echo $user_data[0][3]?>">
              </div>
              <div class="profile__field">
                <div class="profile__field-label">Teléfono</div>
                <input type="text" id="phone" name="phone" class="profile__field-input" value="<?php echo $user_data[0][4]?>" >
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
      border-bottom: 1px solid #c2c2c2;
    }
  </style>
</html>
<?php
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>