<?php
  include_once "../../Models/connection.php";
  session_start();
  include_once "../validations.php";

  $id_activity = $_GET['activity'];  

  $activity = "SELECT AC.ID_Persona, AC.asunto, AC.descripcion, AC.fecha, AC.fecha_limite, AC.url FROM actividad AC JOIN ambiente_virtual A ON AC.ID_Persona = A.ID_Persona WHERE ID_Actividad = $id_activity;";
  $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
  $activity = mysqli_fetch_all($activity_result, MYSQLI_NUM);

  if(empty($activity)){
      header('Location: ./briefcase.php');
      exit();
  }

  $id_instructor = $activity[0][0];

  $instructor = "SELECT nombres, apellidos FROM persona WHERE ID_Persona = $id_instructor";
  $instructor_result = mysqli_query($dbConnection, $instructor) or die(mysqli_error($dbConnection));
  $instructor = mysqli_fetch_all($instructor_result, MYSQLI_NUM);
  $instructor = $instructor[0][0]." ".$instructor[0][1];

  $evidence = "SELECT url, descripcion, observacion, nota, ID_Evidencia, nivelada FROM evidencia WHERE ID_Actividad = $id_activity AND ID_Persona =".$_SESSION['id'];
  $evidence_result = mysqli_query($dbConnection, $evidence) or die(mysqli_error($dbConnection));
  $evidence = mysqli_fetch_all($evidence_result, MYSQLI_NUM);
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
      <title>Actividad</title>
  </head>
  <body>
    <?php include './sidebar.php' ?>
      <h1 class="main-content__header">Entrega de actividad 📘</h1>
      <a href="activities-center.php?group=<?php echo $group ?>" title="Volver" class="back-button back-button--profile-position"><i class="fa-solid fa-arrow-left"></i> Volver</a>

      <div class="evidence">
        <div class="evidence__header">
          <div class="evidence__instructor">
            <img src="../img/default.jpeg" class="evidence__instructor-photo"></img>
            <div class="evidence__instructor-name"><?php echo $instructor ?></div>
          </div>
          <div class="evidence__info">
            <div class="evidence__info-date-limit"><?php echo $activity[0][4] ;?></div>
            <div class="evidence__info-type">Evidencia</div>
          </div>
        </div>
        <hr>
        <!-- CONTENT -->
        <div class="evidence__content">
          <div class="evidence__title"><?php echo $activity[0][1] ;?></div>
          <div class="evidence__date">Fecha publicación: <?php echo $activity[0][3] ;?></div>
          <div class="evidence__p"><?php echo $activity[0][2] ;?></div>
          <?php
            if($activity[0][5] != ''){
              ?>
              <div class="evidence__file">
                <i class="fa-regular fa-file-lines"></i>
                <a class="file-name" href="<?php echo $activity[0][5];?>" download=""><?php echo $activity[0][5] ;?></a>
              </div>
              <?php 
            }
          ?>
        </div>  
      </div>

      <?php 
        if(sizeof($evidence) === 0){
          ?>
          <form action="upload.php?group=<?php echo $group?>&activity=<?php echo $id_activity?>" method="POST" enctype="multipart/form-data"  class="upload-form">
            <!-- FILE SELECTION -->
            <div class="upload-form__file">
              <label for="file"><i class="fa-solid fa-plus"></i>Agregar evidencia</label>
              <div class="upload-form__file-choised">
                <span class="file-selected-name uploaded-file"></span>
              </div>
              <input type="file" name="file" id="file" class="file">
            </div>
            <!-- DESCRIPTION -->
            <div class="upload-form__textarea">
              <div class="upload-form__textarea-label">Descripción</div>
              <textarea name="description" class="upload-form__textarea-input upload" placeholder="Escribe una descripción" maxlength="600"></textarea>
            </div>
            <label for="submit-btn" class="upload-form__btn-submit"><i class="fa-regular fa-paper-plane"></i></label>
            <input type="submit" id="submit-btn" name="submit" class="hidden">
          </form>
          <?php
        } else {
          ?>
          <div class="turned-evidence">
            <div class="turned-evidence__data">
              <div class="turned-evidence__file">
                <i class="fa-regular fa-file-lines"></i>
                <a class="file-name" href="<?php echo $evidence[0][0]; ?>" download=""><?php echo $evidence[0][0]; ?></a>
              </div>
              <div class="turned-evidence__p"><?php echo $evidence[0][1]; ?></div>
            </div>
            <div class="turned-evidence__observation">
              <div class="turned-evidence__observation-label">Observación</div>
              <div class="turned-evidence__observation-p">
                <?php
                  if($evidence[0][2]){
                    echo $evidence[0][2]; 
                  } else{
                    echo "Sin observación...";
                  }
                ?>
              </div>
            </div>
            <div class="turned-evidence__observation-calification">
              <?php
                if($evidence[0][3]){
                  echo $evidence[0][3]; 
                } else{
                  echo "--";
                }
              ?>/100
            </div>
            <?php 
              if($evidence[0][5]){
                ?><div class="turned-evidence__recovered"><i class="fa-sharp fa-solid fa-circle-exclamation"></i> NIVELADA</div><?php
              }
            ?>
            <?php
              if($evidence[0][3]){
                if(intval($evidence[0][3]) < 70) {
                  ?>
                    <a href="#upload-form" class="turned-evidence__link recover-button"><i class="fa-solid fa-turn-up"></i> <span>Nivelar evidencia</span></a>
                  </div>
                  <form action="upload.php?group=<?php echo $group ?>&activity=<?php echo $id_activity?>&recover-evidence=<?php echo $evidence[0][4] ?>" method="POST" id="upload-form" enctype="multipart/form-data"  class="upload-form hidden">
                    <!-- FILE SELECTION -->
                    <div class="upload-form__file">
                      <label for="file"><i class="fa-solid fa-plus"></i>Agregar evidencia</label>
                      <div class="upload-form__file-choised">
                        <span class="file-selected-name uploaded-file"></span>
                      </div>
                      <input type="file" name="file" class="file" id="file">
                    </div>
                    <!-- DESCRIPTION -->
                    <div class="upload-form__textarea">
                      <div class="upload-form__textarea-label">Descripción</div>
                      <textarea name="description" class="upload-form__textarea-input upload" placeholder="Escribe una descripción" maxlength="600"></textarea>
                    </div>
                    <label for="submit-btn" class="upload-form__btn-submit"><i class="fa-regular fa-paper-plane"></i></label>
                    <input type="submit" id="submit-btn" name="submit" class="hidden">
                  </form>
                  <?php 
                }
              } else{
                ?><a href="delete.php?group=<?php echo $group ?>&evidence=<?php echo $evidence[0][4];?>" class="turned-evidence__link delete-button"><i class="fa-solid fa-rotate-left"></i> <span>Cancelar entrega</span></a><?php
              }
            ?>
          </div>
          <?php
        }
      ?>
    </main>
    <script>
      const recoverEvidence = document.querySelector('.recover-button');
      const recoverEvidenceForm = document.querySelector('.upload-form');

      recoverEvidence?.addEventListener('click', () => {
        recoverEvidenceForm.classList.toggle('hidden');
      })
    </script>
    <script src="../../Controllers/file-upload.js"></script>
    <script src="../../Controllers/file-name.js"></script>
    <script src="../../Controllers/confirm-deletion.js"></script>
    <script>confirmDeletion('¿Seguro que quieres eliminar esta evidencia?')</script>
    <?php
      if(isset($_GET['message'])){
        if($_GET['message'] === 'empty') {
          ?><script>Swal.fire({icon: 'error',title: 'Error',text: '¡Tienes que adjuntar tu evidencia!'});</script><?php
        } else if($_GET['message'] === 'error'){
          ?><script>Swal.fire({icon: 'error',title: 'Error',text: '¡Ha habido algun problema!'});</script><?php
        } else if($_GET['message'] === 'uploaded'){
          ?><script>Swal.fire({icon: 'success',title: '¡Evidencia entregada!',text: 'Tu evidencia ha sido entregada correctamente'});</script><?php
        } else if($_GET['message'] === 'deleted'){
          ?><script>Swal.fire({icon: 'success',title: 'La evidencia fue eliminada correctamente'});</script><?php
        }
      }
    ?>
  </body>
</html>