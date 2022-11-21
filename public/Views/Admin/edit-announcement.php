<?php
include_once "../../Models/connection.php";
session_start();
if (isset($_SESSION['id'])) {
  $id_announcement = $_GET['announcement'];
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
    <link rel="stylesheet" href="../css/admin.css" />
  </head>
  <body>
    <?php include './sidebar.php' ?>
    <!-- TODO: Form to edit announcement -->
  </body>
  <style>
    body{
      background-image: url('../img/backgrounds/signup-bg.svg');
      background-size: cover;

    }
  </style>
  <script>
    const fileName = document.querySelector('.file-name');
    if(fileName) fileName.textContent = fileName.textContent.slice(fileName.textContent.lastIndexOf('/') + 1);
  </script>
</html>
<?php
} else {
  include('../../Models/logout.php');
  $location = header('Location: ../index.php');
}
?>
