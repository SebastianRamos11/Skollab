<?php
  include_once "../../Models/connection.php";
  session_start();
  $id_user = $_SESSION['id'];

  if (isset($_SESSION['id'])) {
    $id_activity = $_GET['activity'];

    // SELECT ACTIVITY DATA
    $activity = "SELECT asunto, fecha, fecha_limite, ID_Ficha FROM actividad WHERE ID_Actividad = $id_activity;";
    $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
    $activity = mysqli_fetch_all($activity_result, MYSQLI_NUM);
    $ficha = $activity[0][3];
    
    // SELECT PROGRAM OF CURRENT ACTIVITY
    $program = "SELECT ID_Programa FROM ambiente_virtual WHERE ID_Persona = $id_user AND ID_Ficha = $ficha;";
    $program_result = mysqli_query($dbConnection, $program) or die(mysqli_error($dbConnection));
    $program = mysqli_fetch_all($program_result, MYSQLI_NUM)[0][0];

    $group = "SELECT P.num_documento, P.nombres, P.apellidos, P.telefono, P.correo_electronico, P.ID_Persona FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Programa = '$program' AND A.ID_Ficha = $ficha AND P.ID_Rol = 3";
    $group_result = mysqli_query($dbConnection, $group) or die(mysqli_error($dbConnection));
    $group = mysqli_fetch_all($group_result, MYSQLI_NUM);

    $pending_users = array();
    
    for($i=0; $i < sizeof($group); $i++){
        $id_aprendiz = $group[$i][5];
        
        $delivery = "SELECT url FROM `evidencia` WHERE ID_Persona = $id_aprendiz AND ID_Actividad = $id_activity";
        $delivery_result = mysqli_query($dbConnection, $delivery) or die(mysqli_error($dbConnection));
        $delivery_array = mysqli_fetch_all($delivery_result, MYSQLI_NUM);

        if(sizeof($delivery_array) === 0) array_push($pending_users, $group[$i]);
    }
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
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Centro de revisión</title>
  </head>
  <body>
    <?php include './sidebar.php' ?>
    <h1 class="main-content__header">Centro de revisión</h1>
    <!-- activity SELECTED -->
    <h2>Actividad a calificar</h2>
    <hr>
    <div class="activity-selected">
        <i class="fa-solid fa-book activity-selected__icon"></i>
        <div class="activity-selected__title"><?php echo $activity[0][0]; ?></div>
        <div class="activity-selected__term">
            <div class="activity-selected__time">
                <div class="activity-selected__time-label">Fecha publicación</div>
                <div class="activity-selected__time-date"><?php echo $activity[0][1]; ?></div>
            </div>
            <div class="activity-selected__time">
                <div class="activity-selected__time-label">Fecha límite</div>
                <div class="activity-selected__time-date activity-selected__time-date--due"><?php echo $activity[0][2]; ?></div>
            </div>
        </div>
    </div>

    <div class="pending-grades">
        <h2>Evidencias por calificar</h2>
        <hr>
        <div class="evidences">
            <?php 
                $evidences = "SELECT ID_Evidencia, fecha, ID_Persona FROM evidencia WHERE ID_Actividad = $id_activity AND nota IS NULL";
                $evidences_result = mysqli_query($dbConnection, $evidences) or die(mysqli_error($dbConnection));
                $evidences = mysqli_fetch_all($evidences_result, MYSQLI_NUM);

                for($i = 0; $i < sizeof($evidences); $i++){
                    $id_aprendiz = $evidences[$i][2];

                    $aprendiz_name = "SELECT nombres, apellidos FROM `persona` WHERE ID_Persona = $id_aprendiz";
                    $aprendiz_name_result = mysqli_query($dbConnection, $aprendiz_name) or die(mysqli_error($dbConnection));
                    $aprendiz_name = mysqli_fetch_all($aprendiz_name_result, MYSQLI_NUM);
                    ?>
                    <!-- EVIDENCIA -->
                    <div class="evidence">
                        <div class="evidence__user">
                            <i class="fa-solid fa-book evidence__icon"></i>
                            <div class="evidence__name"><?php echo $aprendiz_name[0][0]; echo " "; echo $aprendiz_name[0][1]; ?></div>
                        </div>
                        <div class="evidence__date"><?php echo $evidences[$i][1]; ?></div>
                        <a href="grade-evidence.php?evidence=<?php echo $evidences[$i][0]; ?>" class="evidence__link">Calificar</a>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>

    <div class="qualified-evidences">
        <h2>Evidencias calificadas</h2>
        <hr>
        <div class="evidences">
            <?php 
                $qualified_evidences = "SELECT fecha, nota, observacion, ID_Evidencia  FROM evidencia WHERE ID_Actividad = $id_activity AND nota IS NOT NULL";
                $qualified_evidences_result = mysqli_query($dbConnection, $qualified_evidences) or die(mysqli_error($dbConnection));
                $qualified_evidences = mysqli_fetch_all($qualified_evidences_result, MYSQLI_NUM);
              
                for($i = 0; $i < sizeof($qualified_evidences); $i++){
                    $id_aprendiz = $qualified_evidences[$i][1];

                    $aprendiz_name = "SELECT nombres, apellidos FROM `persona` WHERE ID_Persona = $id_aprendiz";
                    $aprendiz_name_result = mysqli_query($dbConnection, $aprendiz_name) or die(mysqli_error($dbConnection));
                    $aprendiz_name = mysqli_fetch_all($aprendiz_name_result, MYSQLI_NUM);
                    ?>
                    <!-- TODO: Evidence elemnent - template 👇 -->
                    <!-- <div class="evidence">
                        <div class="evidence__activity">
                            <i class="fa-solid fa-book evidence__icon"></i>
                            <div class="evidence__title"><?php echo "NOMBRE" ;?></div>
                        </div>
                        <div class="evidence__date"><?php echo $qualified_evidences[0][0] ;?></div>
                        <div class="evidence__grade">
                            <div class="evidence__grade-value">
                                <?php
                                    if($qualified_evidences[0][1] != ''){
                                        ?>
                                        <span class="gradeValue"><?php echo $qualified_evidences[0][1] ?>/100</span>
                                        <?php
                                    } else{
                                        echo "--/100";
                                    }
                                ?>
                            </div>
                            <div class="evidence__grade-range">
                                <?php
                                    if($qualified_evidences[0][1] != ''){
                                        ?>
                                        <span class="<?php 
                                                if(intval($qualified_evidences[0][1]) > 80){
                                                    echo "grade-a";
                                                }else if(intval($qualified_evidences[0][1]) > 60){
                                                    echo "grade-b";
                                                } else{
                                                    echo "grade-d";
                                                }
                                            ?>" style="width: <?php echo $qualified_evidences[0][1] ?>%;"></span>
                                        <?php
                                    } else{
                                        ?>
                                        <span style="width: 0;"></span>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="evidence__icons">
                            <div class="evidence__observation">
                                <i class="fa-regular fa-comment-dots"></i>
                                <div class="evidence__observation-p">
                                    <?php
                                        if($qualified_evidences[0][2] != ''){
                                            echo "1";
                                        } else{
                                            echo "0";
                                        }
                                    ?>
                                </div>
                            </div>
                            <a href="<?php echo $qualified_evidences[0][3] ;?>" class="evidence__file" download=""><i class="fa-regular fa-file-lines"></i></a>
                            <a href="<?php echo $qualified_evidences[0][3] ;?>" class="evidence__file" download=""><i class="fa-regular fa-file-lines"></i></a>

                        </div>
                    </div> -->
                    <?php
                }
            ?>
        </div>
    </div>

    <div class="pending-users">
        <h2>Estudiantes pendientes por entregar</h2>
        <hr>
        <?php 
            print_r($pending_users);
        ?>
    </div>

  </body>
  </html>
<?php
    } else {
      include('../../Models/logout.php');
      $location = header('Location: ../index.php');
    }
?>