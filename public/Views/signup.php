<?php
  include_once "../Models/connection.php";

  // GET DOCUMENT TYPES
  $type_doc = "SELECT tipo FROM tipo_documento";
  $type_doc_result = mysqli_query($dbConnection, $type_doc) or die(mysqli_error($dbConnection));
  $type_doc_array = mysqli_fetch_all($type_doc_result, MYSQLI_NUM);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <title>Registro</title>
  </head>
  <body class="signup-body">
    <div class="signup-container">
      <h1 class="header">Regístrate</h1>
      <hr />

      <!-- Progress -->
      <div class="progress-bar">
        <div class="progress" id="progress"></div>
        <div class="progress-step progress-step--active" data-title="Personal"></div>
        <div class="progress-step" data-title="Rol"></div>
        <div class="progress-step" data-title="Cuenta"></div>
      </div>
      <!-- Steps -->
      <div class="form-container">
        <form action="../Models/signup_validation.php" method="POST" class="form signup-form" id="form">
          <!-- Step 1: Personal information-->
          <div class="step step--active">
            <div class="field-group personal-data">
              <!-- Document Type -->
              <div class="step__field" id="group_type-id">
                <label for="doc-type">Tipo de documento</label>
                <select name="doc-type" id="doc-type" class="register-input register-input--outline">
                  <?php 
                    for($i = 1; $i <= sizeof($type_doc_array); $i++){
                      ?><option value="<?php echo $i ?>"><?php echo $type_doc_array[$i - 1][0]; ?></option><?php
                    }
                  ?>
                </select>
              </div>
              <!-- Document Number -->
              <div class="step__field" id="group-id">
                <label for="id">Número de documento</label>
                <div class="step__input">
                  <input type="text" id="id" name="id" maxlength="10" placeholder="Número de identificación" class="register-input" />
                  <i class="step__field-state fas fa-times-circle"></i>
                </div>
                <p class="step__field-error">El documento solo puede contener números, y debe contener exactamente 10 digitos.</p>
              </div>
              <!-- FirstName -->
              <div class="step__field" id="group-firstName">
                <label for="firstName">Nombres</label>
                <div class="step__input">
                  <input
                    type="text"
                    id="firstName"
                    name="firstName"
                    placeholder="Nombres"
                    onkeyup="upper(this);"
                    maxlength="20"
                    class="register-input"
                  />
                  <i class="step__field-state fas fa-times-circle"></i>
                </div>
                <p class="step__field-error">Los nombres solo pueden contener letras y acentos.</p>
              </div>
              <!-- LastName -->
              <div class="step__field" id="group-lastName">
                <label for="lastName">Apellidos</label>
                <div class="step__input">
                  <input
                    type="text"
                    id="lastName"
                    name="lastName"
                    placeholder="Apellidos"
                    onkeyup="upper(this);"
                    maxlength="20"
                    class="register-input"
                  />
                  <i class="step__field-state fas fa-times-circle"></i>
                </div>
                <p class="step__field-error">Los apellidos solo pueden contener letras y acentos.</p>
              </div>
              <!-- Buttons -->
              <div class="btn-only">
                <input type="button" value="Siguiente" class="btn btn-next width-50 ml-auto" />
              </div>
            </div>
          </div>

          <!-- Step 2: Rol -->
          <div class="step rol">
            <div class="field-group rol__group">
              <div class="step__field rol__field group-rol">
                <!-- Instructor option -->
                <label class="rol__label" for="instructor">
                  <div class="rol__option rol__instructor">
                    <input type="radio" name="rol" id="instructor" value="2" class="instructor" />
                      <div class="rol__figure">
                        <img src="./img/figures/rol-instructor.png" alt="instructor" />
                      </div>
                      <span>Profesor</span>
                    </div>
                  </div>
                </label>
              <div class="step__field rol__field group-rol">
                <!-- Student option -->
                <label class="rol__label" for="student">
                  <div class="rol__option rol__student">
                    <input type="radio" name="rol" id="student" value="3" class="student" />
                      <div class="rol__figure">
                        <img src="./img/figures/rol-student.png" alt="student" />
                      </div>
                      <span>Estudiante</span>
                    </div>
                  </div>
                </label>
              <!-- Error message -->
              <p class="step__field-error">Escoja un rol.</p>
              <!-- Buttons -->
              <div class="btns-group">
                <input type="button" value="Regresar" class="btn btn-prev" />
                <input type="button" value="Siguiente" class="btn btn-next" id="btn-next-rol" />
              </div>
            </div>
          </div>

          <!-- Step 3: Login data-->
          <div class="step login-data">
            <div class="field-group">
              <!-- Phone -->
              <div class="step__field" id="group-phone">
                <label for="phone">Celular</label>
                <div class="step__input">
                  <input type="text" name="phone" id="phone" maxlength="10" placeholder="Celular" class="register-input" />
                  <i class="step__field-state fas fa-times-circle"></i>
                </div>
                <p class="step__field-error">El teléfono solo puede contener números y el máximo son 10 dígitos.</p>
              </div>
              <!-- Email -->
              <div class="step__field" id="group-email">
                <label for="email">Correo Institucional</label>
                <div class="step__input">
                  <input type="text" name="email" id="email" placeholder="example@misena.edu.co" class="register-input" />
                  <i class="step__field-state fas fa-times-circle"></i>
                </div>
                <p class="step__field-error">El correo debe ser institucional. Solo puede contener letras, números y puntos.</p>
              </div>
              <!-- Pass -->
              <div class="step__field" id="group-pass">
                <label for="pass">Contraseña</label>
                <div class="step__input">
                  <input type="password" id="pass" name="pass" placeholder="Contraseña" class="register-input" />
                  <i class="step__field-state fas fa-times-circle"></i>
                </div>
                <p class="step__field-error">La contraseña tiene que ser de 4 a 20 dígitos.</p>
              </div>
              <!-- Confirm pass -->
              <div class="step__field" id="group-confirm-pass">
                <label for="confirm-pass">Confirmar contraseña</label>
                <div class="step__input">
                  <input type="password" id="confirm-pass" name="confirm-pass" placeholder="Contraseña" class="register-input" />
                  <i class="step__field-state fas fa-times-circle"></i>
                </div>
                <p class="step__field-error">Ambas contraseñas deben ser iguales.</p>
              </div>
              <!-- Send error message -->
              <div class="step__error-message" id="step__error-message">
                <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente.</p>
              </div>
              <!-- Buttons -->
              <div class="btns-group">
                <input type="button" value="Regresar" class="btn btn-prev" />
                <input type="submit" name="signup-submited" value="Registrarse" id="btn-submit" class="btn btn-submit" />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <script src="../Controllers/signup-control.js"></script>
  </body>
</html>
