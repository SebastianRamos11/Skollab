<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    $id_course = $_GET['course'];

    $course = "SELECT numero, codigo, descripcion FROM `ficha` WHERE ID_Ficha = $id_course";
    $course_result= mysqli_query($dbConnection, $course) or die(mysqli_error($dbConnection));
    $course = mysqli_fetch_all($course_result, MYSQLI_NUM);

    $course_subjects = "SELECT ID_Materia, ID_Instructor FROM `curso` WHERE ID_Ficha = $id_course";
    $course_subjects_result= mysqli_query($dbConnection, $course_subjects) or die(mysqli_error($dbConnection));
    $course_subjects = mysqli_fetch_all($course_subjects_result, MYSQLI_NUM);

    $subjects = "SELECT ID_Materia, nombre FROM `materia` WHERE ID_Materia NOT IN (SELECT ID_Materia FROM curso WHERE ID_Ficha = $id_course)";
    $subjects_result= mysqli_query($dbConnection, $subjects) or die(mysqli_error($dbConnection));
    $subjects = mysqli_fetch_all($subjects_result, MYSQLI_NUM);

    $instructors = "SELECT ID_Persona, apellidos, nombres, num_documento FROM `persona` WHERE ID_Rol = 2";
    $instructors_result= mysqli_query($dbConnection, $instructors) or die(mysqli_error($dbConnection));
    $instructors = mysqli_fetch_all($instructors_result, MYSQLI_NUM);

    $students = "SELECT P.num_documento, P.ID_Tipo_Documento, P.nombres, P.apellidos, P.telefono, P.correo_electronico, A.ID_Persona FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Ficha = $id_course AND P.ID_Rol = 3";
    $students_result = mysqli_query($dbConnection, $students) or die(mysqli_error($dbConnection));
    $students = mysqli_fetch_all($students_result, MYSQLI_NUM);

    $type_doc = "SELECT tipo FROM tipo_documento";
    $type_doc_result = mysqli_query($dbConnection, $type_doc) or die(mysqli_error($dbConnection));
    $type_doc_array = mysqli_fetch_all($type_doc_result, MYSQLI_NUM);
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="../css/admin.css" />
    <title>Cursos</title>
  </head>
  <body id="body">
    <?php include './sidebar.php' ?>
      <a href="admin.php" title="Volver" class="back-button"><i class="fa-solid fa-arrow-left"></i> Volver</a>
      <form action="edit.php?course=<?php echo $id_course ?>&data" method="POST" autocomplete="off" class="manage-course center-form-2">
        <div class="form-header">
          <h2>Administrar curso</h2>
          <hr>
        </div>
        <div class="form-data">
          <div class="form-field form-field--large">
            <label for="course-num" class="form-field__label">Número de ficha</label>
						<input type="text" name="course-num" id="course-num" class="form-field__input" value="<?php echo $course[0][0] ?>">
          </div>
          <div class="form-field form-field--large">
            <label for="course-code" class="form-field__label">Código de unión</label>
						<input type="text" name="course-code" id="course-code" class="form-field__input" value="<?php echo $course[0][1] ?>">
          </div>
          <div class="form-field form-field--description">
						<label for="course-description" class="form-field__label">Descripción</label>
						<textarea id="course-description" name="course-description" placeholder="Escribe una descripción de lo que tratará este curso..." maxlength="1000"><?php echo $course[0][2] ?></textarea>
					</div>
          <div class="form-field form-field--subjects">
            <label class="form-field__label">Materias</label>
            <hr>
            <?php 
              if(!$course_subjects) {
                ?><div class="alert-message"><i class="fas fa-exclamation-triangle"></i> Este curso no tiene materias agregadas.</div><?php
              } else {
                // TODO: Print course's subjects
                for($i = 0; $i < sizeof($course_subjects); $i++){
                  $subject = "SELECT nombre, img FROM `materia` WHERE ID_Materia =".$course_subjects[$i][0];
                  $subject_result= mysqli_query($dbConnection, $subject) or die(mysqli_error($dbConnection));
                  $subject = mysqli_fetch_all($subject_result, MYSQLI_NUM);

                  $instructor = "SELECT nombres, apellidos FROM `persona` WHERE ID_Persona =".$course_subjects[$i][1];
                  $instructor_result= mysqli_query($dbConnection, $instructor) or die(mysqli_error($dbConnection));
                  $instructor = mysqli_fetch_all($instructor_result, MYSQLI_NUM);

                  ?>
                  <div class="manage-subject">
								    <img class="manage-subject__figure" src="<?php echo $subject[0][1]; ?>" alt="subject">
								    <div class="manage-subject__data">
									    <div class="manage-subject__title"><?php echo $subject[0][0]; ?></div>
									    <div class="manage-subject__instructor"><i class="fa-solid fa-chalkboard-user"></i> Instruida por: <?php echo $instructor[0][0]." ".$instructor[0][1]; ?></div>
								    </div>
                    <a href="delete.php?course-subject=<?php echo $id_course ?>&subject=<?php echo $course_subjects[$i][0]  ?>" class="manage-subject__action delete-button"><i class="fa-solid fa-trash-can"></i></a>
                  </div>

                  <?php
                }
              }
            ?>
            <?php 
              if($subjects){
                ?><a href="#body" class="add-course-btn open-modal-btn"><i class="fa-solid fa-plus"></i>Agregar materia</a><?php
              }
            ?>
          </div>
        </div>
        <div class="form-submit">
          <input type="submit" value="Guardar cambios">
        </div>
      </form>

      <!-- APRENDICES -->
      <div class="student-list crud card mb-50">
        <div class="form-header">
          <h2>Aprendices en formación</h2>
          <hr>
        </div>
        <?php 
          if(sizeof($students) > 0){
            ?>
            <div class="p-4">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">Documento</th>
                    <th scope="col">Tipo Documento</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col" colspan="3"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    for($i = 0; $i < sizeof($students); $i++){
                      ?>
                      <tr>
                        <td scope="row"><?php echo $students[$i][0] ?></td>
                        <td scope="row"><?php echo $type_doc_array[$students[$i][1] - 1][0] ?></td>
                        <td><?php echo $students[$i][2] ?></td>
                        <td><?php echo $students[$i][3] ?></td>
                        <td><?php echo $students[$i][4] ?></td>
                        <td><?php echo $students[$i][5] ?></td>
                        <td><a href="view-user.php?user=<?php echo $students[$i][6] ?>" class="see-button"><i class="fa-regular fa-eye" title="Ver perfil"></i></a></td>
                      </tr>
                      <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
            <?php
          }
          else {
            ?><div class="neutral-message"><i class="fas fa-exclamation-triangle"></i> No hay aprendices inscritos</div><?php
          }
        ?>
      </div>

      <!-- ADD SUBJECT FORM -->
      <form action="edit.php?course=<?php echo $id_course ?>&subject" method="POST" enctype="multipart/form-data" class="course-form modal-form add-subject-form hidden" autocomplete="off">
        <button class="close-modal">&times;</button>
				<div class="course-form__header">
					<h2>Añadir materia</h2>
					<hr>
				</div>
				<div class="course-form__data">
					<div class="course-form__field">
						<label for="subject-name" class="course-form__field-label">1. Elige una materia</label>
            <select name="subject" class="subject-selection">
              <option></option>
              <?php 
                for($i = 0; $i < sizeof($subjects); $i++){
                  ?><option value="<?php echo $subjects[$i][0] ?>"><?php echo $subjects[$i][1] ?></option><?php
                }
              ?>
            </select>
					</div>
					<div class="course-form__field">
						<label class="course-form__field-label">2. Elige quién la instruirá</label>
            <select name="instructor" class="instructor-selection">
              <option></option>
              <?php 
                for($i = 0; $i < sizeof($instructors); $i++){
                  ?><option value="<?php echo $instructors[$i][0] ?>"><?php echo $instructors[$i][1]." ".$instructors[$i][2]." (CC. ".$instructors[$i][3].")" ?></option><?php
                }
              ?>
            </select>
					</div>
          <input type="submit" value="Crear" class="course-form__submit">
				</div>
			</form>

      <div class="overlay hidden"></div>
    </main>
    <script src="../../Controllers/select-control.js"></script>
    <script src="../../Controllers/modal-form.js"></script>
    <script src="../../Controllers/random-number.js"></script>
    <script src="../../Controllers/confirm-deletion.js"></script>
    <script>confirmDeletion('¿Seguro que quieres eliminar esta materia para este curso?')</script>
    <style>body{background-image: url('../img/backgrounds/signup-bg.svg');background-position: center;background-size: cover;background-repeat: no-repeat;}</style>
    <?php
      if(isset($_GET['message'])){
        if($_GET['message'] === 'created') {
          ?><script>Swal.fire({icon: 'success',title: '¡Curso creado!',text: 'Ahora es necesario que agregues materias a este curso.'});</script><?php
        } else if($_GET['message'] === 'added'){
          ?><script>Swal.fire({icon: 'success',title: '¡Materia agregada!',text: 'La materia ha sido correctamente a este curso'});</script><?php
        } else if($_GET['message'] === 'deleted'){
          ?><script>Swal.fire({icon: 'success',title: '¡Materia eliminada!',text: 'La materia ha sido eliminada de este curso'});</script><?php
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
