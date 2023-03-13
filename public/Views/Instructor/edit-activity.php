<?php
  include_once "../../Models/connection.php";
  session_start();
  include_once "../validations.php";

  $id_activity = $_GET['activity'];

  $activity = "SELECT asunto, descripcion, ID_Ficha, fecha_limite, url FROM actividad WHERE ID_Actividad = $id_activity";
  $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
  $activity_array = mysqli_fetch_all($activity_result, MYSQLI_NUM);

  $group_num = "SELECT numero FROM ficha WHERE ID_Ficha = $group";
  $group_num_result = mysqli_query($dbConnection, $group_num) or die(mysqli_error($dbConnection));
  $group_num = mysqli_fetch_all($group_num_result, MYSQLI_NUM)[0][0];
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/instructor.css" />
  </head>
  <body>
    <?php include './sidebar.php' ?>
      <a href="activities.php?group=<?php echo $group ?>" title="Volver" class="back-button"><i class="fa-solid fa-arrow-left"></i> Volver</a>

      <form action="edit.php?group=<?php echo $group ?>&activity=<?php echo $id_activity ?>" method="post" enctype="multipart/form-data" class="upload-form" style="margin: 0 auto">
        <!-- FORM HEADING -->
        <div class="upload-form__title">Editar Actividad</div>
        <hr>
        <!-- ASUNTO -->
        <div class="upload-form__field">
          <input type="text" name="subject" class="upload-form__field-input upload-form__field-input--title" placeholder="Ingresa un título" maxlength="60" value="<?php echo $activity_array[0][0] ?>">
        </div>
        <hr>
        <!-- DESCRIPCION -->
        <div class="upload-form__field upload-form__field--description">
          <div class="upload-form__field-label">Descripción</div>
          <textarea name="description" class="upload-form__field-input upload" placeholder="Escribe una descripción" maxlength="600"><?php echo $activity_array[0][1]?></textarea>
        </div>
        <hr>
        <!-- FICHA -->
        <div class="upload-form__field">
          <div class="upload-form__field-label"><i class="fa-solid fa-user-group"></i><span>Dirigido a</span></div>
          <div class="group-activity"><?php echo $group_num ?> </div>
        </div>
        <hr>
        <!-- FECHA FIN -->
        <div class="upload-form__field">
          <div class="upload-form__field-label"><i class="fa-regular fa-calendar"></i><span>Fecha límite</span></div>
          <input type="date" name="due-date" class="upload-form__field-input upload-form__field-input--date" value="<?php echo $activity_array[0][3]?>" >
        </div>
        <hr>
        <div class="upload-form__field">
          <div class="upload-form__field-label"><i class="fa-regular fa-file-lines"></i><span>Archivos adjuntos</span></div>
          <?php 
            if($activity_array[0][4] != ''){
              ?><a href="<?php echo $activity_array[0][4]; ?>" class="upload-form__file" name="file-name" download=""><i class="fa-regular fa-file-lines"></i><span class="file-name"><?php echo $activity_array[0][4]?></span></a><?php 
            } else{
              ?><p class="file-empty">No hay archivos adjuntos</p><?php
            }
          ?>
        </div>
        <hr>
        <!-- FILE | CANCEL | SUBMIT -->
        <div class="upload-form__field">
          <div class="file-choise">
            <label for="file">
              <i class="fa-solid fa-paperclip"></i>
              <p class="file-name uploaded-file"></p>
            </label>
            <input type="file" name="file" class="file" id="file">
          </div>
          <div class="upload-form__buttons">
            <a href="activities.php?group=<?php echo $group ?>" title="Cancelar" class="cancel-btn">Cancelar</a>
            <input type="submit" class="btn-submit" name="submit" value="Guardar">
          </div>
        </div>
      </form>
    </main>
  </body>
  <style>
    html{background-image: url('../img/backgrounds/signup-bg.svg');background-size: cover;}
  </style>
  <script src="../../Controllers/file-name.js"></script>
  <script src="../../Controllers/file-upload.js"></script>
</html>