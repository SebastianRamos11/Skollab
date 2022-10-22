<?php 
  include_once "../../Models/connection.php";

  // GET ROLES
  $role = "SELECT tipo FROM rol";
  $role_result = mysqli_query($dbConnection, $role) or die(mysqli_error($dbConnection));
  $role_array = mysqli_fetch_all($role_result, MYSQLI_NUM);

  // GET DOCUMENT TYPES
  $type_doc = "SELECT tipo FROM tipo_documento";
  $type_doc_result = mysqli_query($dbConnection, $type_doc) or die(mysqli_error($dbConnection));
  $type_doc_array = mysqli_fetch_all($type_doc_result, MYSQLI_NUM);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../css/bootstrap-grid.min.css" />
    <link rel="stylesheet" href="../css/admin.css" />

      <?php
        if(!isset($_GET['id'])){
            header('Location: crud.php?message=error');
            exit();
        }

        include_once "../../Models/new-connection.php";
        $id = $_GET['id'];

        $edit_query = $bd -> prepare("SELECT * FROM persona WHERE ID_Persona = ?;");
        $edit_query -> execute([$id]);
        $persona = $edit_query->fetch(PDO::FETCH_OBJ);
      ?>

      <div class="modal card">
        <div class="modal__header">
          <h2>Editar usuario</h2>
          <hr />
        </div>
        <form action="edit.php?id=<?php echo $persona -> ID_Persona; ?>" class="form" method="POST">

          <!-- FIRST NAME -->
          <div class="form__field">
            <label for="firstName">Nombres</label>
            <input type="text" id="firstName" name="firstName" placeholder="Nombres" onkeyup="upper(this);" maxlength="20" class="register-input" value="<?php echo $persona -> nombres; ?>"/>
          </div>

          <!-- LAST NAME -->
          <div class="form__field">
            <label for="lastName">Apellidos</label>
            <input type="text" id="firstName" name="lastName" placeholder="Apellidos" onkeyup="upper(this);" maxlength="20" class="register-input" value="<?php echo $persona -> apellidos; ?>" />
          </div>

          <!-- BIRTH YEAR -->
          <div class="form__field">
            <label for="birthYear">Fecha de nacimiento</label>
            <input type="date" id="birthYear" name="birthYear" value="2000-02-02" class="register-input" value="<?php echo $persona -> fecha_nacimiento; ?>"/>
          </div>

          <!-- ROL -->
          <div class="rol grid-col-3">
            <div class="rol__title">Rol</div>
            <div class="rol__options">
              <?php 
                for($i = 1; $i <= sizeof($role_array); $i++){
                ?>
                  <div class="rol__option">
                    <input type="radio" name="rol" id="rol-<?php echo $i?>" value="<?php echo $i?>" <?php if(($persona -> ID_Rol) == $i){ ?> checked <?php } ?> />
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
            <input type="text" name="phone" id="phone" maxlength="10" placeholder="Celular" class="register-input" value="<?php echo $persona -> telefono; ?>" />
          </div>

          <!-- EMAIL -->
          <div class="email form__field">
            <label for="email">Correo electrónico</label>
            <input type="text" name="email" id="email" placeholder="Correo electrónico" class="register-input" value="<?php echo $persona -> correo_electronico; ?>" />
          </div>

          <!-- DOCUMENT TYPE -->
          <div class="doc-type form__field">
            <label for="doc-type">Tipo de documento</label>
            <select name="doc-type" id="doc-type" class="upload-form__field-input">
            <?php 
              for($i = 1; $i <= sizeof($type_doc_array); $i++){
                ?>
                <option value="<?php echo $i ?>" <?php if(($persona -> ID_Tipo_Documento) == $i){ ?> selected <?php } ?> ><?php echo $type_doc_array[$i - 1][0]; ?></option>
            <?php
              }
            ?>
            </select>
          </div>
          
          <!-- SUBMIT -->
          <div class="form__field submit__field">
            <input type="submit" name="recover-submited" value="Guardar" class="submit-btn" />
          </div>
        </form>
      </div>

      <script src="../../Controllers/edit-control.js"></script>
    </body>
</html>