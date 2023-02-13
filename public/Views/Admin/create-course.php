<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
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
      <!-- TODO: Create course creation form (multistep) -->
      <form action="create.php?course" method="POST" class="course-form group-form" autocomplete="off">
				<div class="course-form__header">
					<h2>Crear Curso</h2>
					<hr>
				</div>
				<div class="course-form__data">
					<div class="course-form__field">
						<label for="group-num" class="course-form__field-label">Número de ficha</label>
						<input type="number" name="group-num" id="group-num" class="course-form__field-input" placeholder="Ej: 1101">
					</div>
					<div class="course-form__field">
						<label for="group-code" class="course-form__field-label">Código de unión</label>
						<div  class="course-form__field--flex">
							<input type="number" name="group-code" id="group-code" class="random-number-input course-form__field-input" placeholder="Ej: 300391">
							<div class="random-number"><i class="fa-solid fa-rotate"></i></div>
						</div>
					</div>
          <div class="course-form__field course-form__field--description input-description">
						<label for="course-description" class="course-form__field-label">Descripción</label>
						<textarea id="course-description" name="course-description" placeholder="Escribe una descripción de lo que tratará este curso..." maxlength="600"></textarea>
					</div>
          <div class="course-form__field course-form__field--subjects">
						<div class="course-form__field-label">Materias</div>
            <div class="course-subjects">
              <input type="text" name="" id="filterInput" placeholder="Busca una materia..." class="course-form__field-input"><i class="fa-solid fa-magnifying-glass"></i>
              <ul class="course-subjects__list">
                <?php 
                  for($i = 0; $i < sizeof($subjects); $i++){
                    ?><li class="course-subject"><label for="<?php echo $i + 1 ?>"><input type="checkbox" name="subjects[]" id="<?php echo $i + 1 ?>" value="<?php echo $subjects[$i][2] ?>"><span class="checkmark"></span><span class="subject-name"><?php echo $subjects[$i][1] ?></span></label></li><?php
                  }
                ?>
              </ul>
            </div>
          </div>
					<input type="submit" value="Crear" class="course-form__submit">
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
