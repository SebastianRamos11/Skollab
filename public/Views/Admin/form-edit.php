<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../css/bootstrap-grid.min.css" />
    <link rel="stylesheet" href="../css/admin.css" />
      <!-- Header -->
      <?php include '../components/header.php' ?>  
      </header>

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
        <form action="edit.php" class="form" method="POST">
          <!-- ID -->
          <div class="form__field hidden">
            <label for="id">Identificación</label>
            <input type="text" id="id" name="id" maxlength="10" placeholder="Número de identificación" class="register-input" value="<?php echo $persona -> ID_Persona; ?>"/>
          </div>

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
              <div class="rol__option">
                <input type="radio" name="rol" id="administrador" value="ADMINISTRADOR" class="administrador" <?php if(($persona -> rol) == 'ADMINISTRADOR'){ ?> checked <?php } ?> />
                <label for="administrador">Administrador</label>
              </div>
              <div class="rol-option">
                <input type="radio" name="rol" id="aprendiz" value="APRENDIZ" class="aprendiz" <?php if(($persona -> rol) == 'APRENDIZ'){ ?> checked <?php } ?> />
                <label for="aprendiz">Aprendiz</label>
              </div>
              <div class="rol-option">
                <input type="radio" name="rol" id="instructor" value="INSTRUCTOR" class="instructor" <?php if(($persona -> rol) == 'INSTRUCTOR'){ ?> checked <?php } ?> />
                <label for="instructor">Instructor</label>
              </div> 
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

          <!-- SUBMIT -->
          <div class="form__field submit__field">
            <input type="submit" name="recover-submited" value="Guardar" class="submit-btn" />
          </div>
        </form>
      </div>

      <script src="../../Controllers/edit-control.js"></script>
    </body>
</html>
