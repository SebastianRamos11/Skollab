<?php 
  include_once "../../Models/connection.php";
  session_start();

  // GET ROLES
  $role = "SELECT tipo FROM rol";
  $role_result = mysqli_query($dbConnection, $role) or die(mysqli_error($dbConnection));
  $role_array = mysqli_fetch_all($role_result, MYSQLI_NUM);

  // GET DOCUMENT TYPES
  $type_doc = "SELECT tipo FROM tipo_documento";
  $type_doc_result = mysqli_query($dbConnection, $type_doc) or die(mysqli_error($dbConnection));
  $type_doc_array = mysqli_fetch_all($type_doc_result, MYSQLI_NUM);

  if (isset($_SESSION['id'])) {
    if(isset($_GET['id'])){
      $id = $_GET['id'];
  
      $user = "SELECT ID_Persona, nombres, apellidos, ID_Rol, telefono, correo_electronico, ID_Tipo_Documento FROM persona WHERE ID_Persona = $id";
      $user_result = mysqli_query($dbConnection, $user) or die(mysqli_errno($dbConnection));
      $user = mysqli_fetch_all($user_result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
  <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
  <title>Editar Usuario</title>
  <link rel="stylesheet" href="../css/admin.css" />
</head>
<body class="edit-user-body">
  <a href="crud.php" title="Volver" class="back-button back-button--position"><i class="fa-solid fa-arrow-left"></i> Volver</a>
  <div class="modal card">
    <div class="modal__header">
      <h2>Editar usuario</h2>
      <hr />
    </div>
    <form action="edit.php?user=<?php echo $user[0][0] ?>" class="form" method="POST">
      <!-- FIRST NAME -->
      <div class="form__field">
        <label for="firstName">Nombres</label>
        <input type="text" id="firstName" name="firstName" placeholder="Nombres" onkeyup="upper(this);" maxlength="20" class="register-input" value="<?php echo $user[0][1] ?>"/>
      </div>

      <!-- LAST NAME -->
      <div class="form__field">
        <label for="lastName">Apellidos</label>
        <input type="text" id="firstName" name="lastName" placeholder="Apellidos" onkeyup="upper(this);" maxlength="20" class="register-input" value="<?php echo $user[0][2] ?>" />
      </div>

      <!-- ROL -->
      <div class="rol grid-col-3">
        <div class="rol__title">Rol</div>
        <div class="rol__options">
          <?php 
            for($i = 1; $i <= sizeof($role_array); $i++){
              ?>
              <div class="rol__option">
                <input type="radio" name="rol" id="rol-<?php echo $i?>" value="<?php echo $i?>" <?php if(($user[0][3]) == $i){ ?> checked <?php } ?> />
                <label for="rol-<?php echo $i?>"><?php print_r($role_array[$i - 1][0]) ?></label>
              </div>
              <?php 
            }
          ?>
        </div>
      </div>

      <!-- PHONE -->
      <div class="form__field">
        <label for="phone">Celular</label>
        <input type="text" name="phone" id="phone" maxlength="10" placeholder="Celular" class="register-input" value="<?php echo $user[0][4] ?>" />
      </div>

      <!-- EMAIL -->
      <div class="email form__field">
        <label for="email">Correo electrónico</label>
        <input type="text" name="email" id="email"placeholder="Correo electrónico" class="register-input" value="<?php echo $user[0][5] ?>" />
      </div>

      <!-- DOCUMENT TYPE -->
      <div class="doc-type form__field">
        <label for="doc-type">Tipo de documento</label>
        <select name="doc-type" id="doc-type" class="upload-form__field-input">
          <?php 
            for($i = 1; $i <= sizeof($type_doc_array); $i++){
              ?>
              <option value="<?php echo $i ?>" <?php if(($user[0][6]) == $i){ ?> selected <?php } ?> ><?php echo $type_doc_array[$i - 1][0]; ?></option>
              <?php
            }
          ?>
        </select>
      </div>
      <div class="form__field submit__field"><input type="submit" name="recover-submited" value="Guardar" class="submit-btn" /></div>
    </form>
  </div>
  <script src="../../Controllers/edit-control.js"></script>
</body>
</html>
<?php 
    } else {
      header('Location: crud.php?message=error');
      exit();
    }
  } else{
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>