<?php
    session_start();
    unset($_SESSION['id']);
    session_destroy();
    $location = header('Location: ../Views/index.php');
?>