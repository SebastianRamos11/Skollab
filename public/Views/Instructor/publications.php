<?php
  include_once "../../Models/connection.php";
  include_once "../../Models/session.php";
  $read_query = "SELECT *  FROM persona WHERE ID_Persona = '$session'";
  $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);

  // GET INSTRUCTOR'S GROUPS
  $get_group = "SELECT ID_Ficha FROM ambiente_virtual WHERE ID_Persona = '$session'";
  $get_group_result = mysqli_query($dbConnection, $get_group) or die(mysqli_error($dbConnection));
  $get_group_array = mysqli_fetch_all($get_group_result, MYSQLI_NUM);
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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Publicaciones</title>
  </head>
  <body>
    <?php include './sidebar.php' ?>
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
        <h1 class="main-content__header">Centro de publicaciones 📚</h1>

        <!-- CREATE PUBLICATION FORM -->
        <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form hidden">
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
          <!-- FECHA INICIO (HIDDEN) -->
          <div class="upload-form__field hidden">
            <input type="date" id="date" name="date" class="upload-form__field-input upload-form__field-input--date">
          </div>
          <!-- FECHA FIN -->
          <div class="upload-form__field">
            <div class="upload-form__field-label">
              <i class="fa-regular fa-calendar"></i>
              <span>Fecha límite</span>
            </div>
            <input type="date" name="due-date" class="upload-form__field-input upload-form__field-input--date">
          </div>
          <hr>
          <!-- DELETE | FILE | SUBMIT -->
          <div class="upload-form__field">
            <div class="btn-close"><i class="fa-solid fa-trash-can"></i></div>
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

        
        <!-- PUBLICATIONS CONTAINER -->
        <div class="instructor-publications">
        <div class="publications">
          <!-- PUBLICATIONS BY GROUP -->
          
          <?php for($i=0; $i < sizeof($get_group_array); $i++){ 
            $ficha = $get_group_array[$i][0];
            ?>
            <div class="publications-course">
              <?php 
                // GET GROUP'S PUBLICATIONS
                $publications = "SELECT ID_Publicacion, asunto, descripcion, fecha, fecha_limite, tipo_publicacion, url FROM publicacion WHERE ID_Ficha = $ficha AND ID_Persona = $session";
                $publications_result = mysqli_query($dbConnection, $publications) or die(mysqli_error($dbConnection));
                $publications_array = mysqli_fetch_all($publications_result, MYSQLI_NUM);
                if(sizeof($publications_array) > 0 ){
                  ?>
                  <div class="publications-course__label">Publicaciones para <?php echo $ficha ?></div>
                  <hr>
                  <?php
                  for($j=0; $j < sizeof($publications_array); $j++){
              ?>
                    <!-- PUBLICATION -->
                    <div class="publication">
                      <div class="publication__title"><?php echo $publications_array[$j][1]; ?></div>
                      <div class="publcation__date">Fecha publicación: <?php echo $publications_array[$j][3]; ?></div>
                      <div class="publication__info">
                        <div class="publication__p"><?php echo $publications_array[$j][2]; ?></div>
                        <div class="publication__date-limit"><?php echo $publications_array[$j][4]; ?></div>
                        <div class="publication__type"><?php echo $publications_array[$j][5]; ?></div>
                        <!-- VALIDAR EXISTENCIA FILE -->
                        <?php
                          if($publications_array[$j][6] != ''){
                        ?>
                          <a href="<?php print_r($publications_array[$j][6]); ?>" class="publication__file" download="">
                            <i class="fa-regular fa-file-lines"></i>
                          </a>
                        <?php 
                          }
                        ?>
                      </div>
                      <div class="publication__btns">
                        <a href="FIXME?publication=<?php echo $publications_array[$j][0]?>" class="publication__btns-link">Editar>></a>
                      </div>
                    </div>
                <?php
                    } 
                  } else{
                    ?>
                    <div class="publications-course__label">No se han realizado publicaciones para <?php echo $ficha ?></div>
                    <hr>
                    <?php
                  }  
                ?>
            </div>
          <?php 
          }
          ?>
        </div>
        <!-- CREATE PUBLICATION BUTTON -->
        <a href="#"><i class="fa-solid fa-plus create-button"></i></a>
        </div>
        <div class="overlay hidden"></div>
      </main>
    </div>
    <script src="../../Controllers/set-date.js"></script>
    <script src="../../Controllers/publication-control.js"></script>
    <script src="../../Controllers/instructor-control.js"></script>
  </body>
</html>