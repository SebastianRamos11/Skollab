<?php
include_once "../../Models/connection.php";
  include_once "../../Models/session.php";
if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'], 'upload/'.$_FILES['file']['name'])){
            $asunto = $_POST['asunto'];
            $url = 'upload/'.$_FILES['file']['name'];
            $fecha = $_POST['fecha_pub'];
            $tipo = $_POST['tipo_p'];

            $sql = $dbConnection->query("INSERT INTO publi (asunto,direccion,fecha,tipo_publicacion) VALUES ('".$asunto."', '".$url."', '".$fecha."', '".$tipo."')");
            echo "Archivos subidos con exito";
        }else{
            echo "Archivos no subidos vuelva a intentar";
        }
    }else{
        echo "Archivos no subidos vuelva a intentar";
    }
}
?>