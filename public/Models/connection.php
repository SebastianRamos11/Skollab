<?php
  $dbConnection = mysqli_connect('localhost', 'root', '', 'skollab');
  if (!$dbConnection) echo 'Error: no se pudo conectar a Skollab.';
?>