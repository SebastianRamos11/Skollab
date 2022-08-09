<?php

if(isset($_POST['submit']) && isset($_FILES['file'])){
    echo "<pre>";
    print_r($_FILES['file']);
    echo "</pre>";
} else{
    header("Location: publication.php");
}

?>