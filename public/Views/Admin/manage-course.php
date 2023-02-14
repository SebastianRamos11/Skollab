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
      <form action="create.php?course" method="POST" class="course-form group-form" autocomplete="off">
				<div class="course-form__header">
					<h2>Administrar curso</h2>
					<hr>
				</div>
				<div class="course-form__data">
          <!-- TODO:  Formulario para agregar las materias al curso ($_GET[])-->
				</div>
      </form>
    </main>
    <script src="../../Controllers/course-search.js"></script>
    <script src="../../Controllers/random-number.js"></script>
    <style>body{background-image: url('../img/backgrounds/signup-bg.svg');background-position: center;background-size: cover;background-repeat: no-repeat;}</style>
    <?php
      // FIXME: arreglar desbordamiento por la alerta
      if(isset($_GET['message'])){
        if($_GET['message'] === 'created') {
          ?><script>Swal.fire({icon: 'success',title: '¡Ficha creada!',text: 'Ficha creada correctamente, ahora necesitas agregar contenido a este curso'});</script><?php
        }
      }
    ?>
  </body>
</html>
<?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>
