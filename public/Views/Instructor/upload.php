<?php
include_once "../../Models/connection.php";
  include_once "../../Models/session.php";
if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/'.$_FILES['file']['name'])){
            $asunto = $_POST['asunto'];
            $fecha = $_POST['fecha_pub'];
            $url = '../file-store/'.$_FILES['file']['name'];
            $tipo = $_POST['tipo_p'];
            $sql = $dbConnection->query("INSERT INTO publicacion (ID_Persona,asunto,fecha,tipo_publicacion,url) VALUES ('".$session."', '".$asunto."', '".$fecha."', '".$tipo."', '".$url."')");
            echo "Archivos subidos con exito";
        }else{
            echo "Archivos no subidos vuelva a intentar";
        }
    }else{
        echo "Archivos no subidos vuelva a intentar";
    }
}
?>