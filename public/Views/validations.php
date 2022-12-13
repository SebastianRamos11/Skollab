<?php
  if (!isset($_SESSION['id'])) {
    include('../../Models/logout.php');
    header('Location: ../index.php');
  }
  	$group = $_GET['group'];
?>