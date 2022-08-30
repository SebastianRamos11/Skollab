<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Publicaciones</title>
  </head>
  <body>
    <?php
      include_once "../../Models/connection.php";
      include_once "../../Models/session.php";
      $read_query = "SELECT *  FROM persona WHERE ID_Persona = '$session'";
      $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
      $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);
    ?>
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">Centro de publicaciones 📚</h1>
        <div class="publication">
          <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">

            <!-- FORM HEADING -->
            <div class="upload-form__title">Crear Publicación</div>

            <!-- ASUNTO -->
            <div class="upload-form__field">
              <input type="text" name="subject" class="upload-form__field-input" placeholder="Ingresa un título" maxlength="60">
              <div class="field-length">60</div>
            </div>

            <!-- DESCRIPCION -->
            <div class="upload-form__field">
              <input type="textarea" name="description" class="upload-form__field-input" placeholder="Escribe una descripción" maxlength="600">
            </div>

            <!-- CATEGORIA -->
            <div class="upload-form__field">
              <div class="upload-form__label">
                <i class="fa-solid fa-border-all"></i>
                Categoría
              </div>
              <select name="type" id="type" class="upload-form__field-input">
                <option value="Evidencia" default="">Evidencia</option>
                <option value="Material">Material</option>
              </select>
            </div>

            <!-- FECHA -->
            <div class="upload-form__field">
              <div class="upload-form__label">
                <i class="fa-regular fa-calendar"></i>
                Fecha
              </div>
              <input type="date" name="date" class="upload-form__field-input upload-form__field-input--date">
            </div>

            <!-- DELETE | FILE | SUBMIT -->
            <div class="upload-form__field">
              <button class="btn-delete"><i class="fa-solid fa-trash-can"></i></button>
              <input type="file" name="file">
              <input type="submit" name="submit" value="Publicar">
            </div>
          </form>
        </div>

        <!-- PUBLICATIONS... -->

      </main>
    </div>
    <script src="../../Controllers/instructor-control.js"></script>
  </body>
</html>