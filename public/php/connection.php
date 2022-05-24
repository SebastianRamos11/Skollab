<?php
    $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"];
    try {
        $dbConnection = new PDO('mysql:host=localhost;dbname=skollab', 'root', '', $options);
        $dbConnection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'Conexión exitosa.';
    } catch (PDOException $dbError) {
        echo 'Falló la conexión: ' . $dbError -> getMessage();
    }
?>