<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/main.css" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico" />
    <title>Reasignación de Contraseña</title>
  </head>
  <body class="recover-body">
    <?php if(isset($_GET['message']) and $_GET['message'] == 'unknow'){ ?> <script>Swal.fire({ icon: 'error', title: 'Error', text: '¡Los datos ingresados no corresponden!'});</script> <?php } ?>
    <div class="recover-container">
      <div class="header">
        <h1>Reasignar contraseña</h1>
        <hr />
      </div>
      <form action="../Models/recover_validation.php" class="form" method="POST">
        <!-- DOCUMENT NUMBER -->
        <div class="form__field">
          <label for="id">Documento de Identidad</label>
          <input type="number" name="id" id="id" placeholder="Número de documento" class="register-input"  />
        </div>
        <!-- EMAIL -->
        <div class="form__field">
          <label for="email">Correo electrónico</label>
          <input type="text" name="email" id="email" placeholder="Correo electrónico" class="register-input" required />
        </div>
        <!-- PASS -->
        <div class="form__field" id="group-pass">
          <label for="pass">Contraseña</label>
          <div class="pass__field">
            <input type="password" name="pass" id="pass" placeholder="Contraseña" class="register-input pass-input" />
            <i class="fa-solid fa-eye eye see-btn"></i>
            <i class="fa-solid fa-eye-slash eye unsee-btn"></i>
          </div>
          <p class="form__field-error">La contraseña tiene que ser de 4 a 20 dígitos.</p>
        </div>
        <!-- CONFIRM PASS -->
        <div class="form__field" id="group-confirm-pass">
          <label for="confirm-pass">Confirmar contraseña</label>
          <div class="pass__field">
            <input type="password" name="confirm-pass" id="confirm-pass" placeholder="Contraseña" class="register-input pass-input" />
            <i class="fa-solid fa-eye eye see-btn"></i>
            <i class="fa-solid fa-eye-slash eye unsee-btn"></i>
          </div>
          <p class="form__field-error">Ambas contraseñas deben ser iguales.</p>
        </div>
        <!-- Send error message -->
        <div class="form__error-message" id="form__error-message">
          <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente.</p>
        </div>
        <div class="form__field submit__field">
          <input type="submit" name="recover-submited" value="Recuperar" class="submit-btn" />
        </div>
      </form>
    </div>
    <script src="../Controllers/recover-control.js"></script>
    <script src="../Controllers/pass-visualization.js"></script>
  </body>
</html>
