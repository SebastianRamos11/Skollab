<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    // GET INSTRUCTOR'S GROUPS
    $get_group = "SELECT ID_Ficha FROM ambiente_virtual WHERE ID_Persona =".$_SESSION['id'];
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
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Actividades</title>
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
    <!-- Created successfully -->
    <?php 
      if(isset($_GET['message']) and $_GET['message'] == 'created'){
        ?>
      <script>
          Swal.fire({
              icon: 'success',
              title: '¡Actividad publicada!',
              text: '¡Tu actividad se ha publicado correctamente!'
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
              title: '¡Actividad modificada!',
              text: '¡Tu evidencia ha sido modificada correctamente!'
            });
      </script>
    <?php 
      }
    ?>

    <h1 class="main-content__header">Centro de actividades 📚</h1>

        <!-- activities... -->

        
        <!-- activities CONTAINER -->
        <div class="instructor-activities">
          <div class="container">
            <!-- activities BY GROUP -->
            <?php for($i=0; $i < sizeof($get_group_array); $i++){ 
              $ficha = $get_group_array[$i][0];
              
              // GET GROUP'S activities
              $activities = "SELECT ID_Actividad, asunto, descripcion, fecha, fecha_limite, url FROM actividad WHERE ID_Ficha = $ficha AND ID_Persona =".$_SESSION['id'];
              $activities_result = mysqli_query($dbConnection, $activities) or die(mysqli_error($dbConnection));
              $activities_array = mysqli_fetch_all($activities_result, MYSQLI_NUM);

              ?>
              <div class="activities-course">
                <div class="activities-course__label">Ficha <?php echo $ficha ?></div>
                <hr>

                <?php 
                  if(sizeof($activities_array) > 0 ){
                    ?>
                    <div class="activities">
                      <?php
                      for($j=0; $j < sizeof($activities_array); $j++){
                      ?>
                        <!-- activity -->
                        <div class="activity">
                          <div class="activity__title"><?php echo $activities_array[$j][1]; ?></div>
                          <div class="activity__date">Fecha publicación: <?php echo $activities_array[$j][3]; ?></div>
                          <div class="activity__info">
                            <div class="activity__p"><?php echo $activities_array[$j][2]; ?></div>
                            <div class="activity__date-limit"><?php echo $activities_array[$j][4]; ?></div>
                            <div class="activity__type">Actividad</div>
                            <!-- VALIDAR EXISTENCIA FILE -->
                            <?php
                              if($activities_array[$j][5] != ''){
                                ?>
                                <a href="<?php print_r($activities_array[$j][5]); ?>" class="activity__file" download=""><i class="fa-regular fa-file-lines"></i></a>
                                <?php 
                              }
                            ?>
                          </div>
                          <div class="activity__btns">
                            <a href="edit-activity.php?activity=<?php echo $activities_array[$j][0]?>" class="activity__btns-link"><i class="fa-regular fa-pen-to-square"></i> Editar</a>
                            <a href="deliveries.php?activity=<?php echo $activities_array[$j][0]?>" class="activity__btns-link activity__btns-link--active">Ver entregas</a>
                          </div>
                        </div>
                      <?php
                      }
                    ?>
                    </div>
                    <?php 
                  } else{
                    ?>
                    <div class="alert-message"><i class="fa-solid fa-triangle-exclamation"></i>No has realizado publicaciones para esta ficha.</div>
                    <?php
                  }  
                  ?>
              </div>
            <?php 
            }
            ?>
          </div>
          <!-- CREATE activity BUTTON -->
          <a href="#" class="create-button"><i class="fa-solid fa-plus"></i></a>
        </div>
      </main>
    </div>

    <!-- CREATE ACTIVITY FORM -->
    <form action="upload-post.php" method="post" enctype="multipart/form-data" class="upload-form float-form hidden">
      <!-- FORM HEADING -->
      <div class="upload-form__title">Crear Actividad</div>
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
          <option value="0" default="">Seleccione la ficha</option>
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
      <!-- FECHA FIN -->
      <div class="upload-form__field">
        <div class="upload-form__field-label">
          <i class="fa-regular fa-calendar"></i>
          <span>Fecha límite</span>
        </div>
        <input type="date" name="due-date" class="upload-form__field-input upload-form__field-input--date">
      </div>
      <hr>
      <!-- FILE | SUBMIT -->
      <div class="upload-form__field">
        <div class="file-choise">
          <label for="file">
            <i class="fa-regular fa-file-lines"></i>
            <p class="file-name"></p>
          </label>
          <input type="file" name="file" id="file">
        </div>
        <input type="submit" class="btn-submit" name="submit" value="Publicar" >
      </div>
      <div class="btn-close"><i class="fa-solid fa-xmark"></i></div>
    </form>
    <div class="overlay hidden"></div>

    <script src="../../Controllers/activity-control.js"></script>
    <script src="../../Controllers/instructor-control.js"></script>
  </body>
  </html>
<?php
    } else {
      include('../../Models/logout.php');
      $location = header('Location: ../index.php');
    }
?>