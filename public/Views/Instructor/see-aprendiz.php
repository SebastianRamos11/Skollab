<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
    $id_aprendiz = $_GET['aprendiz'];
  
    // GET APRENDIZ DATA
    $aprendiz = "SELECT nombres, apellidos, ID_Rol, ID_Tipo_Documento, num_documento, correo_electronico, telefono FROM `persona` WHERE ID_Persona = $id_aprendiz";
    $aprendiz_result = mysqli_query($dbConnection, $aprendiz) or die(mysqli_error($dbConnection));
    $aprendiz_array = mysqli_fetch_all($aprendiz_result, MYSQLI_NUM);

    // GET ROL
    $role = $aprendiz_array[0][2];
    $role = "SELECT tipo FROM rol WHERE ID_Rol = $role";
    $role_result = mysqli_query($dbConnection, $role) or die(mysqli_error($dbConnection));
    $role = mysqli_fetch_all($role_result, MYSQLI_NUM);

    // GET DOCUMENT TYPE
    $type_doc = $aprendiz_array[0][3];
    $type_doc = "SELECT tipo FROM tipo_documento WHERE ID_Tipo_Documento = $type_doc";
    $type_doc_result = mysqli_query($dbConnection, $type_doc) or die(mysqli_error($dbConnection));
    $type_doc = mysqli_fetch_all($type_doc_result, MYSQLI_NUM);

    // GET AMBIENTE VIRTUAL OF APRENDIZ 
    $course_aprendiz = "SELECT * FROM ambiente_virtual WHERE ID_Persona = $id_aprendiz";
    $course_aprendiz_result = mysqli_query($dbConnection, $course_aprendiz) or die(mysqli_error($dbConnection));
    $course_aprendiz_array = mysqli_fetch_all($course_aprendiz_result, MYSQLI_NUM);


    // GET INSTRUCTOR activities (TO LOOP)
    $activity_array = array();
    for($i=0; $i < sizeof($course_aprendiz_array); $i++){
        $ficha = $course_aprendiz_array[$i][2];
        $activity = "SELECT ID_Actividad, asunto FROM actividad WHERE ID_Persona =".$_SESSION['id']." AND ID_Ficha = ".$ficha;
        $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
        array_push($activity_array, mysqli_fetch_all($activity_result, MYSQLI_NUM));
    }
    $activity_array = $activity_array[0];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Gestión Aprendiz</title>
</head>
<body>
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">👨‍🎓 Gestión Aprendiz</h1>
        <div class="user">
            <div class="user-profile">
                <img class="user-profile__photo" src="../img/default.jpeg" alt="user-photo">
                <div class="user-profile__info">
                    <div class="user-profile__name"><?php echo $aprendiz_array[0][0] ;?> <?php echo $aprendiz_array[0][1] ;?></div>
                    <div class="user-profile__label">
                        <div class="user-profile__rol"><?php echo $role[0][0] ;?></div>
                        <div class="dot"></div>
                        <div class="user-profile__type-id"><?php echo $type_doc[0][0] ;?></div>
                        <div class="user-profile__id"><?php echo $aprendiz_array[0][4] ;?></div>
                    </div>
                    <div class="user-profile__contact">
                        <div class="user-profile__contact-data"><i class="fa-regular fa-envelope"></i><?php echo $aprendiz_array[0][5] ;?></div>
                        <div class="user-profile__contact-data"><i class="fa-solid fa-phone"></i><?php echo $aprendiz_array[0][6] ;?></div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="user-programs">
                <div class="user-programs__label">Programas de formación</div>

                <?php 
                for($i=0; $i < sizeof($course_aprendiz_array); $i++){
                    $program = $course_aprendiz_array[$i][1];
                    $ficha = $course_aprendiz_array[$i][2];
                        
                    // GET PROGRAM NAME
                    $program_query = "SELECT nombre FROM programa_formacion WHERE ID_Programa = $program";
                    $program_result= mysqli_query($dbConnection, $program_query) or die(mysqli_error($dbConnection));
                    $program_array = mysqli_fetch_all($program_result, MYSQLI_NUM);
                    $program_name = $program_array[0][0];
                ?>
                    <div class="course">
                      <div class="course__title"><?php echo $program_name; ?></div>
                      <div class="course__id"><?php echo $ficha; ?></div>
                      <img class="course__figure" src="../img/courses/sena-logo.png" alt="course">
                    </div>
                <?php 
                }
                ?>
            </div>
            <hr>
            <div class="user-evidences">
                <h2 class="user-evidences__label">Estado de actividades</h2>
                
                <?php 
                if(sizeof($activity_array) > 0){
                    for($i = 0; $i < sizeof($activity_array); $i++){ 
                    $id_activity = $activity_array[$i][0];
                    $title_activity = $activity_array[$i][1];

                    $evidences = "SELECT fecha, nota, observacion, url FROM `evidencia` WHERE ID_Persona = $id_aprendiz AND ID_Actividad = $id_activity";
                    $evidences_result = mysqli_query($dbConnection, $evidences) or die(mysqli_error($dbConnection));
                    $evidences_array = mysqli_fetch_all($evidences_result, MYSQLI_NUM);
                    
                    if(sizeof($evidences_array) > 0){
                        ?>
                        <div class="user-evidence">
                            <div class="user-evidence__activity">
                                <i class="fa-solid fa-book user-evidence__icon"></i>
                                <div class="user-evidence__title"><?php echo $title_activity ;?></div>
                            </div>
                            <div class="user-evidence__date"><?php echo $evidences_array[0][0] ;?></div>
                            <div class="user-evidence__grade">
                                <div class="user-evidence__grade-value">
                                    <?php
                                        if($evidences_array[0][1] != ''){
                                            ?>
                                            <span class="gradeValue"><?php echo $evidences_array[0][1] ?>/100</span>
                                            <?php
                                        } else{
                                            echo "--/100";
                                        }
                                    ?>
                                </div>
                                <div class="user-evidence__grade-range">
                                    <?php
                                        if($evidences_array[0][1] != ''){
                                            ?>
                                            <span class="<?php 
                                                    if(intval($evidences_array[0][1]) > 80){
                                                        echo "grade-a";
                                                    }else if(intval($evidences_array[0][1]) > 60){
                                                        echo "grade-b";
                                                    } else{
                                                        echo "grade-d";
                                                    }
                                                ?>" style="width: <?php echo $evidences_array[0][1] ?>%;"></span>
                                            <?php
                                        } else{
                                            ?>
                                            <span style="width: 0;"></span>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="user-evidence__icons">
                                <div class="user-evidence__observation">
                                    <i class="fa-regular fa-comment-dots"></i>
                                    <div class="user-evidence__observation-p">
                                        <?php
                                            if($evidences_array[0][2] != ''){
                                                echo "1";
                                            } else{
                                                echo "0";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <a href="<?php echo $evidences_array[0][3] ;?>" class="user-evidence__file" download=""><i class="fa-regular fa-file-lines"></i></a>
                            </div>
                        </div>
                <?php
                    } else{
                        ?>
                        <!-- EVIDENCE NOT DELIVERED -->
                            <div class="user-evidence user-evidence--empty">
                                <div class="user-evidence__activity">
                                    <i class="fa-solid fa-triangle-exclamation user-evidence__icon"></i>
                                    <div class="user-evidence__title"><?php echo $title_activity ;?></div>
                                </div>
                                <div class="user-evidence--empty__alert">SIN ENTREGA</div>
                            </div>
                        <?php
                    }
                    }
                } else {
                    ?>
                    <div class="alert-message"><i class="fas fa-exclamation-triangle"></i>No has publicado ningúna evidencia</div>
                    <?php
                }
                ?>
                
            </div>
        </div>
    </main>
    <script src="../../Controllers/course-acronym.js"></script>
</body>
<style>
    body{
        background: #fff !important;
        min-height: 100vh;
    }
    .nav{
        border-right: 1px solid #c2c2c2;
    }
</style>
</html>
<?php 
      } else {
        include('../../Models/logout.php');
        $location = header('Location: ../index.php');
      }
?> 