<?php
include_once "../../Models/connection.php";
  include_once "../../Models/session.php";
if($_POST['submit']){
    if(file_exists($_FILES['file']['tmp_name'])){
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../file-store/'.$_FILES['file']['name'])){

            $subject = $_POST['subject'];
            $description = $_POST['description'];
            $type = $_POST['type'];
            $date = $_POST['date'];
            $url = '../file-store/'.$_FILES['file']['name'];

            $sql = $dbConnection->query("INSERT INTO publicacion (ID_Persona,asunto,descripcion,fecha,tipo_publicacion,url) VALUES ('".$session."', '".$subject."', '".$description."','".$date."', '".$type."', '".$url."')");
            echo "Archivos subidos con exito";
        }else{
            echo "Archivos no subidos vuelva a intentar";
        }
    }else{
        echo "Archivos no subidos vuelva a intentar";
    }
}
?>