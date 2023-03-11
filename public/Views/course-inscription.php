<?php
  include_once "../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    $course_num = intval($_POST['course-num']);
    $course_code = intval($_POST['course-code']);

    $course = "SELECT ID_Ficha, descripcion FROM ficha WHERE numero = $course_num AND codigo = $course_code";
    $course_result = mysqli_query($dbConnection, $course) or die(mysqli_error($dbConnection));
    $course = mysqli_fetch_all($course_result, MYSQLI_NUM);

    if(!$course){
      header('Location: main.php?message=error');
    }

    $subjects = "SELECT nombre FROM curso C JOIN materia M ON C.ID_Materia = M.ID_Materia WHERE C.ID_Ficha = ".$course[0][0];
    $subjects_result = mysqli_query($dbConnection, $subjects) or die(mysqli_error($dbConnection));
    $subjects = mysqli_fetch_all($subjects_result, MYSQLI_NUM);

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <title>Confirmar inscripción</title>
  </head>
  <body>
    <?php include_once "navbar.php"; ?>
    <div class="course-form-container">
      <div class="course-form course-form--inscription">
        <div class="course-form__header">
          <h2>Confirmar inscripción</h2>
          <hr>
        </div>
        <div class="course-form__data">
          <div class="course-form__field">
            <div class="course-info">
              <img class="course-info__img" src="./img/courses/sena-logo.png" alt="course-img">
              <div>
                <div class="course-info__title">Curso <?php echo $course_num; ?></div>
                <div class="course-info__description">
                  <?php
                    if($course[0][1]){
                      echo $course[0][1];
                    } else{
                      echo "Sin descripción...";
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="course-form__field">
            <label class="course-form__field-label">Materias (<?php echo sizeof($subjects) ?>)</label>
            <div class="course-subjects">
              <?php
                for($i = 0; $i < sizeof($subjects); $i++){
                  ?><div class="course-subjects__subject acronym"><?php echo $subjects[$i][0]; ?></div><?php
                }
              ?>
            </div>
          </div>
          <div class="course-form__field course-form__field--btns">
            <a href="main.php" class="course-form__btn"><i class="fa-solid fa-backward"></i> Cancelar</a>
            <a href="inscription.php?course=<?php echo $course[0][0] ?>" class="course-form__btn course-form__btn--submit"><i class="fa-solid fa-check"></i> Inscribir</a>
          </div>
        </div>
      </div>
    </div>
    <style>html{background-image: url('./img/backgrounds/signup-bg.svg');background-size: cover;}</style>
    <script src="../Controllers/course-acronym.js"></script>
  </body>
</html>
<?php
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>