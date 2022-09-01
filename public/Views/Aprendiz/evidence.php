<?php
  include_once "../../Models/connection.php";
  include_once "../../Models/session.php";

  $read_query = "SELECT * FROM persona WHERE ID_Persona = '$session'";
  $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);
  
  $evidence = $_GET['evidence'];  

  $publication = "SELECT P.ID_Persona, P.asunto, P.descripcion, P.fecha, P.tipo_publicacion, P.url, A.ID_Programa FROM publicacion P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE ID_Publicacion = $evidence;";
  $publication_result = mysqli_query($dbConnection, $publication) or die(mysqli_error($dbConnection));
  $publication_array = mysqli_fetch_all($publication_result, MYSQLI_NUM);

  $instructor_id= $publication_array[0][0];

  $instructor = "SELECT nombres, apellidos FROM persona WHERE ID_Persona = $instructor_id";
  $instructor_result = mysqli_query($dbConnection, $instructor) or die(mysqli_error($dbConnection));
  $instructor_array = mysqli_fetch_all($instructor_result, MYSQLI_NUM);

      if (isset($session)) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/aprendiz.css" />
    <title>Entregar evidencia</title>
</head>
<body>
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
    <!-- Upload successfully -->
    <?php 
      if(isset($_GET['message']) and $_GET['message'] == 'updated'){
    ?>
      <script>
          Swal.fire({
              icon: 'success',
              title: '¡Evidencia entregada!',
              text: '¡Tu evidencia ha sido cargada correctamente!'
          });
      </script>
    <?php 
      }
    ?>
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">Entrega de evidencia 📘</h1>

        <!-- PUBLICATION -->
        <div class="evidence">
            <!-- HEADER -->
            <div class="evidence__header">
                <div class="evidence__instructor">
                    <img src="../img/default.jpeg" class="evidence__instructor-photo"></img>
                    <div class="evidence__instructor-name"><?php echo $instructor_array[0][0] ; echo " " ; echo $instructor_array[0][1] ?></div>
                </div>
                <div class="evidence__info">
                    <div class="evidence__info-date"><?php echo $publication_array[0][3] ;?></div>
                    <div class="evidence__info-type"><?php echo $publication_array[0][4] ;?></div>
                </div>
            </div>
            <hr>

            <!-- CONTENT -->
            <div class="evidence__content">
                <div class="evidence__title"><?php echo $publication_array[0][1] ;?></div>
                <div class="evidence__p"><?php echo $publication_array[0][2] ;?></div>
                <div class="evidence__file">
                    <i class="fa-regular fa-file-lines"></i>
                    <a class="file-name" href="<?php echo $publication_array[0][5];?>" download=""><?php echo $publication_array[0][5] ;?></a>
                </div>
            </div>  
        </div>

        
        <!-- UPLOAD FORM -->
        <form action="#" method="post" enctype="multipart/form-data"  class="upload-form">
            <!-- FILE SELECTION -->
            <div class="upload-form__file">
                <label for="file"><i class="fa-solid fa-plus"></i>Agregar archivo</label>
                <div class="upload-form__file-choised">
                    <i class="fa-regular fa-file-lines hidden file-icon"></i>
                    <span class="file-selected-name"></span>
                </div>
                <input type="file" name="file" id="file">
            </div>
            <!-- DESCRIPTION -->
            <div class="upload-form__textarea">
                <div class="upload-form__textarea-label">Descripción</div>
                <textarea name="description" class="upload-form__textarea-input upload" placeholder="Escribe una descripción" maxlength="600"></textarea>
            </div>

            <!-- FIXME -->
            <input type="text" value="<?php echo $evidence  ?>" class="hidden" name="evidence">
            
            <button type="submit" name="submit" class="upload-form__btn-submit"><i class="fa-regular fa-paper-plane"></i></button>
        </form>
    </main>
    <script src="../../Controllers/aprendiz-control.js"></script>
</body>
</html>
<?php 
      } else {
        ?><script>window.location.assign('../index.html')</script><?php
      }
?> 