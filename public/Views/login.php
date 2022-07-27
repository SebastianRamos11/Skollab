<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/login.css" />
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Inicio de Sesión</title>
  </head>
  <body>
    <div class="login-container">
      <div class="login">
        <h1 class="login__title">Inicio de Sesión</h1>
        <form action="../Models/login_validation.php" method="POST" class="login__form">
          <input type="email" name="email" id="email" placeholder="Correo electrónico" class="register-input" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES);?>" required />
          <input type="password" name="pass" placeholder="Contraseña" class="register-input" required />
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
      <div class="media">
        <div class="media__title">Inicia sesión con tus redes sociales</div>
        <div class="media__links">
          <span class="iconify" data-icon="akar-icons:google-contained-fill"></span>
          <span class="iconify" data-icon="fa6-brands:facebook"></span>
          <span class="iconify" data-icon="akar-icons:github-fill"></span>
        </div>
      </div>
    </div>
  </body>
</html>