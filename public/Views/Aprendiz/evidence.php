<?php
include_once "../../Models/connection.php";
session_start();
if (isset($_SESSION['id'])) {
  $evidence = $_GET['evidence'];  

  $activity = "SELECT AC.ID_Persona, AC.asunto, AC.descripcion, AC.fecha, AC.fecha_limite, AC.url FROM actividad AC JOIN ambiente_virtual A ON AC.ID_Persona = A.ID_Persona WHERE ID_Actividad = $evidence;";
  $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
  $activity_array = mysqli_fetch_all($activity_result, MYSQLI_NUM);

  $instructor_id = $activity_array[0][0];

  $instructor = "SELECT nombres, apellidos FROM persona WHERE ID_Persona = $instructor_id";
  $instructor_result = mysqli_query($dbConnection, $instructor) or die(mysqli_error($dbConnection));
  $instructor_array = mysqli_fetch_all($instructor_result, MYSQLI_NUM);
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
              text: '¡Tienes que adjuntar tu evidencia!'
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
              text: '¡Tu evidencia ha sido entregada correctamente!'
          });
      </script>
    <?php 
      }
    ?>
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">Entrega de actividad 📘</h1>

        <!-- activity -->
        <div class="evidence">
            <!-- HEADER -->
            <div class="evidence__header">
                <div class="evidence__instructor">
                    <img src="../img/default.jpeg" class="evidence__instructor-photo"></img>
                    <div class="evidence__instructor-name"><?php echo $instructor_array[0][0] ; echo " " ; echo $instructor_array[0][1] ?></div>
                </div>
                <div class="evidence__info">
                    <div class="evidence__info-date-limit"><?php echo $activity_array[0][4] ;?></div>
                    <div class="evidence__info-type">Evidencia</div>
                </div>
            </div>
            <hr>

            <!-- CONTENT -->
            <div class="evidence__content">
                <div class="evidence__title"><?php echo $activity_array[0][1] ;?></div>
                <div class="evidence__date">Fecha publicación: <?php echo $activity_array[0][3] ;?></div>
                <div class="evidence__p"><?php echo $activity_array[0][2] ;?></div>
                <?php
                  if($activity_array[0][5] != ''){
                ?>
                  <div class="evidence__file">
                    <i class="fa-regular fa-file-lines"></i>
                    <a class="file-name" href="<?php echo $activity_array[0][5];?>" download=""><?php echo $activity_array[0][5] ;?></a>
                  </div>
                <?php 
                  }
                ?>
            </div>  
        </div>

        <!-- UPLOAD FORM -->
        <form action="upload.php?evidence=<?php echo $evidence?>" method="post" enctype="multipart/form-data"  class="upload-form">
            <!-- FILE SELECTION -->
            <div class="upload-form__file">
                <label for="file"><i class="fa-solid fa-plus"></i>Agregar archivo</label>
                <div class="upload-form__file-choised">
                    <i class="fa-regular fa-file-lines hidden file-icon"></i>
                    <span class="file-selected-name"></span>
                </div>
                <input type="file" name="file" id="file">
            </div>
            <!-- DATE (HIDDEN) -->
            <div class="upload-form__date hidden">
              <input type="date" id="date" name="date">
            </div>
            <!-- DESCRIPTION -->
            <div class="upload-form__textarea">
                <div class="upload-form__textarea-label">Descripción</div>
                <textarea name="description" class="upload-form__textarea-input upload" placeholder="Escribe una descripción" maxlength="600"></textarea>
            </div>
            <label for="submit-btn" class="upload-form__btn-submit"><i class="fa-regular fa-paper-plane"></i></label>
            <input type="submit" id="submit-btn" name="submit" class="hidden">
          </form>
    </main>
    <script src="../../Controllers/aprendiz-control.js"></script>
</body>
</html>
<?php 
      } else {
        include('../../Models/logout.php');
        $location = header('Location: ../index.php');
      }
?> 