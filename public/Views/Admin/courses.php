<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    $groups = "SELECT ID_Ficha, numero, codigo FROM `ficha`";
    $groups_result= mysqli_query($dbConnection, $groups) or die(mysqli_error($dbConnection));
    $groups = mysqli_fetch_all($groups_result, MYSQLI_NUM);

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
      <h1 class="main-content__header">🎒 Cursos</h1>

      <div class="crud-choise crud-choise--no-centered">
        <div class="crud-option">
          <div class="crud-option__label">Cursos</div>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 65 65" xml:space="preserve"><path fill="#656D78" d="M39 55.504h24v4a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-4h38z"/><path fill="#E6E9ED" d="M46 23.504v5a2 2 0 0 1-2 2H19.99c-1.11 0-2-.89-2-2v-5H5v32h54v-32H46z"/><path fill="#434A54" d="M5 22.494a2 2 0 0 1 2-2h10.99v3.01H5v-1.01z"/><path fill="#AAB2BD" d="M38 55.504c.55 0 1 .45 1 1v.99c0 .55-.45 1-1 1H26c-.55 0-1-.45-1-1v-.99c0-.55.45-1 1-1h12z"/><path fill="#656D78" d="m8.02 11.504-.03-.01 24.01-8 24 8-10.09 3.36L32 19.494l-13.92-4.64z"/><path fill="#434A54" d="M59 22.494v1.01H46v-3.01h11a2 2 0 0 1 2 2z"/><path fill="#545C66" d="M17.99 23.504V15.134l.09-.279L32 19.494l13.91-4.64.09.28V28.504a2 2 0 0 1-2 2H19.99c-1.11 0-2-.89-2-2v-5z"/><path fill="#AAB2BD" d="M25 55.504h14v1H25z"/><path fill="#545C66" d="M45.998 29.505a1 1 0 0 1-1-1V15.134a1 1 0 1 1 2 0v13.371a1 1 0 0 1-1 1z"/><path fill="#545C66" d="M43.998 31.505a1 1 0 1 1 0-2 1 1 0 0 0 1-1 1 1 0 1 1 2 0c0 1.654-1.346 3-3 3zM17.99 29.505a1 1 0 0 1-1-1V15.132a1 1 0 1 1 2 0v13.373a1 1 0 0 1-1 1z"/><path fill="#545C66" d="M19.99 31.505c-1.654 0-3-1.346-3-3a1 1 0 1 1 2 0 1 1 0 0 0 1 1 1 1 0 1 1 0 2z"/><path fill="#545C66" d="M43.998 31.505H19.99a1 1 0 1 1 0-2h24.008a1 1 0 1 1 0 2z"/><path d="M19.003 38.499H45v-1H19.003v1z"/><path fill="#CCD1D9" d="M46 44.503H18.003a1 1 0 1 1 0-2H46a1 1 0 1 1 0 2zM46 47.501H18.003a1 1 0 1 1 0-2H46a1 1 0 1 1 0 2z"/><g><path fill="#CCD1D9" d="M37 50.497h-9.997a1 1 0 1 1 0-2H37a1 1 0 1 1 0 2z"/></g><path fill="#434A54" d="M5 23.504h1.99v32H5zM57.002 23.504h1.99v32h-1.99z"/><g><path fill="#656D78" d="M31.996 20.497c-.106 0-.214-.018-.316-.052l-24.006-8a.998.998 0 0 1 0-1.896L31.68 2.547c.205-.068.428-.068.633 0l24.006 8.002a1 1 0 0 1 0 1.896l-24.006 8c-.103.034-.21.052-.317.052zm-20.843-9 20.843 6.946 20.843-6.946-20.843-6.948-20.843 6.948z"/></g><g><path fill="#FFCE54" d="M31.996 12.501H7.99a1 1 0 1 1 0-2h24.006a1 1 0 1 1 0 2z"/></g><g><path fill="#FFCE54" d="M7.99 17.501a1 1 0 0 1-1-1v-5a1 1 0 1 1 2 0v5a1 1 0 0 1-1 1z"/></g><g><path fill="#CCD1D9" d="M46.996 38.499c0 .55-.45 1-1 1H18.008c-.55 0-1-.45-1-1v-1c0-.55.45-1 1-1h27.988c.55 0 1 .45 1 1v1z"/><path fill="#5D9CEC" d="M18.008 36.499c-.55 0-1 .45-1 1v1c0 .55.45 1 1 1h15.489l-3-3H18.008z"/></g></svg>
          <div class="crud-option__num"><?php echo sizeof($groups) ?> Existentes</div>
          <a href="#body" class="crud-0 crud-option__btn-create open-modal-btn"><i class="fa-solid fa-plus"></i> Crear</a>
          <a href="#crud-0" class="crud-0 crud-option__btn">Consultar</a>
        </div>
        <div class="crud-option">
          <div class="crud-option__label">Materias</div>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><defs><style>.cls-1{fill:#db5669}.cls-2{fill:#edebf2}.cls-3{fill:#dad7e5}.cls-4{fill:#c4455e}.cls-5{fill:#9dcc6b}.cls-6{fill:#a82af4}.cls-7{fill:#f26674}</style></defs><g id="Book_Virus" data-name="Book Virus"><path class="cls-1" d="M28 8H10v8h17.2A10 10 0 0 0 37 28v2a4 4 0 0 1-4 4H6a5 5 0 0 0-5 5V9a8 8 0 0 1 8-8h24a4 4 0 0 1 4 4v3a9.94 9.94 0 0 0-8 4c-1.3 1.31-1 4.37-1-4z"/><path class="cls-2" d="M37 30v10a4 4 0 0 1-4 4H15v-5H9v5H6a5 5 0 0 1 0-10h27a4 4 0 0 0 4-4z"/><path class="cls-3" d="M33 34H6a5 5 0 0 0-4.9 6A5 5 0 0 1 6 36h27a4 4 0 0 0 4-4v-2a4 4 0 0 1-4 4z"/><path class="cls-3" d="M32 40H7a1 1 0 0 1 0-2h25a1 1 0 0 1 0 2z"/><path class="cls-1" d="M15 39v8l-3-2-3 2v-8h6z"/><path class="cls-4" d="M28 9c0 7.75-.08 3.23-.8 7H11a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1z"/><path class="cls-1" d="M28 9c0 5.34.14 4.51-.35 5H18a6 6 0 0 1-6-6h15a1 1 0 0 1 1 1z"/><path class="cls-3" d="M47 18a10 10 0 0 1-2 6c-5.76 7.67-18 3.54-18-6a10 10 0 0 1 20 0z"/><path class="cls-2" d="M47 18a10 10 0 0 1-2 6 10 10 0 0 1-16-8 9.88 9.88 0 0 1 2-6 10 10 0 0 1 16 8z"/><path class="cls-5" d="M36 14v-1a1 1 0 0 1 2 0v1a1 1 0 0 1-2 0zM36 23v-1a1 1 0 0 1 2 0v1a1 1 0 0 1-2 0zM33 19h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zM42 19h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zM34.17 16.17c-.49 0-.64-.22-1.41-1a1 1 0 0 1 1.41-1.41l.71.7a1 1 0 0 1-.71 1.71zM40.54 22.54c-.5 0-.64-.23-1.42-1a1 1 0 0 1 1.42-1.42l.7.71a1 1 0 0 1-.7 1.71zM34.17 19.83c-.49 0-.64.22-1.41 1a1 1 0 0 0 1.41 1.41l.71-.7a1 1 0 0 0-.71-1.71zM40.54 13.46c-.5 0-.64.23-1.42 1a1 1 0 0 0 1.42 1.42l.7-.71a1 1 0 0 0-.7-1.71z"/><circle class="cls-5" cx="37" cy="18" r="4"/><path class="cls-6" d="M37 17a1 1 0 0 0-2 0 1 1 0 0 0 2 0zM39 19a1 1 0 0 0-2 0 1 1 0 0 0 2 0z"/><path class="cls-7" d="M28 13.65V9a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h16.2A10 10 0 0 0 37 28c0 1.94.13 2.83-.54 4H25A20 20 0 0 1 5 12V2.08A7.85 7.85 0 0 1 9 1h24a4 4 0 0 1 4 4v3a10 10 0 0 0-9 5.65z"/><path class="cls-1" d="M37 28v1.8A10 10 0 0 1 25.84 16h1.36A10 10 0 0 0 37 28zM29 12a11.75 11.75 0 0 0-.78 1.21c-.32.54-.24.77-.24-.33A9.47 9.47 0 0 1 29 12z"/><path class="cls-4" d="M28 13.65a10.21 10.21 0 0 0-.8 2.35h-1.36A9.72 9.72 0 0 1 27 14c.78 0 .56.09 1-.35z"/><path class="cls-4" d="M28 12.87c0 .94.09.69-.35 1.13H27a9.65 9.65 0 0 1 1-1.13z"/><path class="cls-7" d="M15 40v5a4 4 0 0 1-4-4v-1z"/></g></svg>
          <div class="crud-option__num"><?php echo sizeof($subjects) ?> Existentes</div>
          <a href="#body" class="crud-1 crud-option__btn-create open-modal-btn"><i class="fa-solid fa-plus"></i> Crear</a>
          <a href="#crud-1" class="crud-1 crud-option__btn">Consultar</a>
        </div>
      </div>

      <!-- CRUD -->
      <div class="crud-modal">
        <div class="row">
          <div class="col-md-12">
            <!-- CRUD CURSOS -->
            <div id="crud-1" class="crud crud-group card mb-50 hidden">
              <div class="card-header">Cursos</div>
              <div class="p-4">
                <table class="table align-middle">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Número de ficha</th>
                      <th scope="col">Código de unión</th>
                      <th scope="col" colspan="2"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      for($i = 0; $i < sizeof($groups); $i++){
                        ?>
                        <tr>
                          <td scope="row"><?php echo $groups[$i][0] ?></td>
                          <td><?php echo $groups[$i][1] ?></td>
                          <td><?php echo $groups[$i][2] ?></td>
                          <td><a href="manage-course.php?course=<?php echo $groups[$i][0] ?>" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a></td>
                          <td><a href="delete.php?delete_group=<?php echo $groups[$i][0] ?>" class="delete-button"><i class="fa-solid fa-trash-can"></i></a></td>
                        </tr>
                        <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- CRUD MATERIAS -->
            <div id="crud-2" class="crud card md-50 hidden">
              <div class="card-header">Materias</div>
              <?php
                for($i = 0; $i < sizeof($subjects); $i++){
                  ?>
                  <div class="subject">
                    <img class="subject__image" src="<?php echo $subjects[$i][0] ?>" alt="subject-img">
                    <div class="subject__name"><?php echo $subjects[$i][1] ?></div>
                    <div class="subject__actions">
                      <a href="#?subject=<?php echo $subjects[$i][2] ?>" class="subject__btn"><i class="fa-solid fa-pen-to-square"></i></a>
                      <a href="delete.php?delete_subject=<?php echo $subjects[$i][2] ?>" class="subject__btn delete-button subject__btn--delete"><i class="fa-solid fa-trash-can"></i></a>
                    </div>
                  </div>
                  <?php
                }
              ?>
            </div>
          </div>
        </div>
      </div>

      <!-- COURSE FORM -->
      <form action="create.php?course" method="POST" class="course-form group-form modal-form hidden" autocomplete="off">
        <button class="close-modal">&times;</button>
				<div class="course-form__header"><h2>Crear Curso</h2><hr></div>
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
          <input type="submit" value="Crear" class="course-form__submit">
				</div>
      </form>
      
			<!-- SUBJECT FORM -->
      <form action="create.php?subject" method="POST" enctype="multipart/form-data" class="course-form modal-form subject-form hidden" autocomplete="off">
        <button class="close-modal">&times;</button>
				<div class="course-form__header">
					<h2>Crear Materia</h2>
					<hr>
				</div>
				<div class="course-form__data">
					<div class="course-form__field">
						<label for="subject-name" class="course-form__field-label">Nombre de la materia</label>
						<input type="text" name="subject-name" id="subject-name" class="course-form__field-input course-form__field-input--large" placeholder="Ej: Matemáticas">
					</div>
					<div class="course-form__field">
						<label class="course-form__field-label">Miniatura</label>
						<div class="file-choise">
							<label for="file"><i class="fa-solid fa-paperclip"></i><p class="uploaded-file"></p></label>
							<input type="file" name="subject-img" id="file" class="file" accept="image/png, image/gif, image/jpeg">
						</div>
					</div>
          <input type="submit" value="Crear" class="course-form__submit">
				</div>
			</form>
      <div class="overlay hidden"></div>
    </main>
    <script src="../../Controllers/confirm-deletion.js"></script>
    <script src="../../Controllers/random-number.js"></script>
    <script src="../../Controllers/show-crud.js"></script>
    <script src="../../Controllers/modal-form.js"></script>
    <script src="../../Controllers/file-upload.js"></script>
    <script>confirmDeletion('¿Seguro que quieres eliminar este elemento?')</script>
  </body>
  </html>
  <?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>
