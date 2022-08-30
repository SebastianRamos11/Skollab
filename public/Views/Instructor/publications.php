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
        <form action="upload.php" method="post" enctype="multipart/form-data" class="form-upload">
          <input type="text" name="asunto" class="form-upload__title" placeholder="Título">
          <input type="file" name="file">
          <select name="tipo_p" id="tipo_publicacion" >
          <option value="0">-Seleccione una opción-</option>
            <option value="Material">Materail</option>
            <option value="Evidencia">Evidencia</option>
            <option value="Asunto">Asunto</option>
          </select>
          <input type="date" name="fecha_pub">
          <input type="submit" name="submit" value="Publicar">
        </form>
      </main>
    </div>
    <script src="../../Controllers/instructor-control.js"></script>
  </body>
</html>