<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Publicaciones</title>
  </head>
  <body>
    <?php
      include_once "../../Models/connection.php";
      include_once "../../Models/session.php";
      $read_query = "SELECT *  FROM persona WHERE ID_Persona = '$session'";
      $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
      $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);

      $get_group = "SELECT ID_Ficha FROM ambiente_virtual WHERE ID_Persona = '$session'";
      $get_group_result = mysqli_query($dbConnection, $get_group) or die(mysqli_error($dbConnection));
      $get_group_array = mysqli_fetch_all($get_group_result, MYSQLI_NUM);
    ?>
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">Centro de publicaciones 📚</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">
          
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
                  title: '¡Publicación subida!',
                  text: '¡Tu evidencia ha sido cargada correctamente!'
              });
          </script>
        <?php 
          }
        ?>

        <!-- FORM HEADING -->
          <div class="upload-form__title">Crear Publicación</div>

          <hr>

          <!-- ASUNTO -->
          <div class="upload-form__field">
            <input type="text" name="subject" class="upload-form__field-input upload-form__field-input--title" placeholder="Ingresa un título" maxlength="60">
          </div>

          <hr>

            
          <!-- DESCRIPCION -->
          <div class="upload-form__field upload-form__field--description">
            <div class="upload-form__field-label">
              Descripción
            </div>
            <textarea name="description" class="upload-form__field-input upload" placeholder="Escribe una descripción" maxlength="600"></textarea>
          </div>
          
          <hr>

          <!-- FICHA -->
          <div class="upload-form__field">
            <div class="upload-form__field-label">
              <i class="fa-solid fa-user-group"></i>
              <span>Dirigido a</span>
            </div>
            <select name="group" id="group" class="upload-form__field-input">
              <option value="0" default="">Seleccione</option>
              <?php 
              for($i = 0; $i < sizeof($get_group_array); $i++){
              ?>
                <option value="<?php echo $get_group_array[$i][0]; ?>"><?php echo $get_group_array[$i][0]; ?></option>
              <?php
              }
              ?>
            </select>
          </div>

          <hr>
          
          <!-- CATEGORIA -->
          <div class="upload-form__field">
            <div class="upload-form__field-label">
              <i class="fa-solid fa-border-all"></i>
              <span>Categoría</span>
            </div>
            <select name="type" id="type" class="upload-form__field-input">
              <option value="Evidencia" default="">Evidencia</option>
              <option value="Material">Material</option>
            </select>
          </div>

          <hr>

          <!-- FECHA -->
          <div class="upload-form__field">
            <div class="upload-form__field-label">
              <i class="fa-regular fa-calendar"></i>
              <span>Fecha</span>
            </div>
            <input type="date" name="date" class="upload-form__field-input upload-form__field-input--date">
          </div>

          <hr>

          <!-- DELETE | FILE | SUBMIT -->
          <div class="upload-form__field">
            <button class="btn-delete"><i class="fa-solid fa-trash-can"></i></button>
            <div class="file-choise">
              <label for="file">
                <i class="fa-regular fa-file-lines"></i>
                <p class="file-name"></p>
              </label>
              <input type="file" name="file" id="file">
            </div>
            <input type="submit" class="btn-submit" name="submit" value="Publicar" >
          </div>
        </form>

        <!-- PUBLICATIONS... -->
      
      </main>
    </div>
    
    <script src="../../Controllers/publication-control.js"></script>
    <script src="../../Controllers/instructor-control.js"></script>
  </body>
</html>