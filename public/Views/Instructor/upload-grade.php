<?php
    include_once "../../Models/new-connection.php";
    session_start();
    if(empty($_POST["calification"])){
        header('Location: review-center.php?message=empty');
        exit();
    }

    $evidence = $_GET["evidence"];
    $activity = $_GET["activity"];

    $calification = $_POST["calification"];
    $observation = $_POST["observation"];

    $grade_query = $bd -> prepare("UPDATE evidencia SET nota = ?, observacion = ? WHERE ID_Evidencia = ?;");
    $query_result = $grade_query -> execute([$calification, $observation, $evidence]);

    if($query_result){
        header('Location: deliveries.php?activity='.$activity.'&message=qualified');
        exit();
    }else{
        header('Location: deliveries.php?activity='.$activity.'&message=error');
        exit();
    }
?>