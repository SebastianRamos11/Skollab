<?php 
  session_start();
  if (!isset($_SESSION['id'])) {
?>
<!DOCTYPE html>
<html lang="es" class="login-html">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Inicio de Sesión</title>
  </head>
  <body>
    <div class="login-container">
      <div class="login">
        <h1 class="login__title">Inicio de Sesión</h1>
        <form action="../Models/login_validation.php" method="POST" class="login__form">
          <input type="email" name="email" id="email" placeholder="Correo electrónico" class="register-input" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES);?>" required />
          <div class="pass__field">
            <input type="password" name="pass" placeholder="Contraseña" class="register-input pass-input" required />
            <i class="fa-solid fa-eye eye see-btn"></i>
            <i class="fa-solid fa-eye-slash eye unsee-btn"></i>
          </div>
          <button type="submit" name="login" class="login__btn">Ingresar</button>
        </form>
      </div>
      <div class="signup">
        <p>¿No tienes cuenta?</p>
        <a href="./signup.php" class="signup__link">Regístrate</a>
      </div>
      <div class="recover">
        <a href="./recover-pass.php">¿Se te olvidó la contraseña?</a>
      </div>
    </div>
    <?php 
      if(isset($_GET['message'])){
        if($_GET['message'] === 'error') {
          ?><script>Swal.fire({ icon: 'error', title: '¡Credenciales incorretas!', text: 'El correo o contraseña son incorrectos'});</script><?php
        } else if($_GET['message'] === 'recovered'){
          ?><script>Swal.fire({icon: 'success', title: 'Contraseña restablecida', text: 'Tu contraseña se ha cambiado correctamente'});</script><?php
        }
      }
    ?>
    <script src="../Controllers/pass-visualization.js"></script>
  </body>
</html>
<?php 
} else{
    include_once "../Models/connection.php";
  
    $read_query = "SELECT ID_Rol FROM persona WHERE ID_Persona =".$_SESSION['id'];
    $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
    $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);
  
    if ($result_array[0][0] == 1) {
      header('Location: ./Admin/admin.php');
    } elseif ($result_array[0][0] == 2) {
      header('Location: ./Instructor/instructor.php');
    } elseif ($result_array[0][0] == 3) {
      header('Location: ./Aprendiz/aprendiz.php');
    }
  }
?>