<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    $id_announcement = $_GET['announcement'];
  
    // GET ANNOUNCEMENT DATA
    $announcement = "SELECT asunto, descripcion, fecha, url_file FROM anuncio WHERE ID_Anuncio = $id_announcement";
    $announcement_result= mysqli_query($dbConnection, $announcement) or die(mysqli_error($dbConnection));
    $announcement = mysqli_fetch_all($announcement_result, MYSQLI_NUM);
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
    <link rel="stylesheet" href="../css/admin.css" />
  </head>
  <body>
    <?php include './sidebar.php' ?>
      <form action="edit.php?announcement=<?php echo $id_announcement ?>" method="post" enctype="multipart/form-data" class="float-form" autocomplete="off" style="position: relative; margin-top: 30px;">
        <!-- FORM HEADING -->
        <div class="float-form__title">Editar Anuncio</div>
        <hr>
        <!-- ASUNTO -->
        <div class="float-form__field">
          <input type="text" name="subject" class="float-form__field-input float-form__field-input--title" placeholder="Ingresa un título" maxlength="60" value="<?php echo $announcement[0][0] ?>">
        </div>
        <hr>
        <!-- DESCRIPCION -->
        <div class="float-form__field float-form__field--description">
          <div class="float-form__field-label">Descripción</div>
          <textarea name="description" class="float-form__field-input float" placeholder="Escribe una descripción" maxlength="600"><?php echo $announcement[0][1] ?></textarea>
        </div>
        <hr>
        <div class="float-form__field">
          <div class="float-form__field-label"><i class="fa-regular fa-file-lines"></i><span>Archivos adjuntos</span></div>
          <?php 
              if($announcement[0][3] != ''){
                ?>
                <a href="<?php echo $announcement[0][3]; ?>" class="float-form__file" name="file-name" download=""><i class="fa-regular fa-file-lines"></i><span class="file-name"><?php echo $announcement[0][3]?></span></a>
                <?php 
              } else{
                ?>
                <p class="file-empty">No hay archivos adjuntos</p>
                <?php
              }
          ?>
        </div>
        <hr>
        <div class="float-form__field">
          <div class="file-choise">
              <label for="file"><i class="fa-solid fa-paperclip"></i><p class="uploaded-file uploaded-file--right"></p></label>
              <input type="file" name="file" id="file" class="file">
          </div>
          <a href="admin.php" title="Cancelar" class="cancel-btn" style="margin-left: auto;">Cancelar</a>
          <input type="submit" class="btn-submit" name="submit" value="Guardar">
        </div>
      </form>
  </body>
  <style>body{background-image: url('../img/backgrounds/signup-bg.svg');background-size: cover;height: 115vh !important; }.float-form {transform: translate(-50%, -55%) !important;}@media screen and (min-width: 1500px) {body{height: 100vh !important;}}</style>
  <script src="../../Controllers/admin-control.js"></script>
  <script src="../../Controllers/file-upload.js"></script>
  <script src="../../Controllers/file-name.js"></script>
</html>
<?php
} else {
  include('../../Models/logout.php');
  $location = header('Location: ../index.php');
}
?>