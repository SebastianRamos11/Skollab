<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    $id_course = $_GET['course'];

    $course = "SELECT numero, codigo, descripcion FROM `ficha` WHERE ID_Ficha = $id_course";
    $course_result= mysqli_query($dbConnection, $course) or die(mysqli_error($dbConnection));
    $course = mysqli_fetch_all($course_result, MYSQLI_NUM);

    $subjects = "SELECT img, nombre, ID_Materia FROM `materia`";
    $subjects_result= mysqli_query($dbConnection, $subjects) or die(mysqli_error($dbConnection));
    $subjects = mysqli_fetch_all($subjects_result, MYSQLI_NUM);
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
    <link rel="stylesheet" href="../css/admin.css" />
    <title>Cursos</title>
  </head>
  <body id="body">
    <?php include './sidebar.php' ?>
      <form action="create.php?course" method="POST" autocomplete="off" class="manage-course center-form-2">
        <div class="form-header">
          <h2>Administrar curso</h2>
          <hr>
        </div>
        <div class="form-data">
          <div class="form-field">
            <label for="course-num" class="form-field__label">Número de ficha</label>
						<input type="text" name="course-num" id="course-num" class="form-field__input" value="<?php echo $course[0][0] ?>">
          </div>
          <div class="form-field">
            <label for="course-code" class="form-field__label">Código de unión</label>
						<input type="text" name="course-code" id="course-code" class="form-field__input" value="<?php echo $course[0][1] ?>">
          </div>
          <div class="form-field form-field--description">
						<label for="course-description" class="form-field__label">Descripción</label>
						<textarea id="course-description" name="course-description" placeholder="Escribe una descripción de lo que tratará este curso..." maxlength="600"><?php echo $course[0][2] ?></textarea>
					</div>
        </div>
      </form>
    </main>
    <script src="../../Controllers/course-search.js"></script>
    <script src="../../Controllers/random-number.js"></script>
    <style>body{background-image: url('../img/backgrounds/signup-bg.svg');background-position: center;background-size: cover;background-repeat: no-repeat;}</style>
  </body>
</html>
<?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>
