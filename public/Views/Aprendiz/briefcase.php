<?php
include_once "../../Models/connection.php";
session_start();

if (isset($_SESSION['id'])) {
  // GET AMBIENTE VIRTUAL
  $course = "SELECT * FROM ambiente_virtual WHERE ID_Persona =".$_SESSION['id'];
  $course_result = mysqli_query($dbConnection, $course) or die(mysqli_error($dbConnection));
  $course_array = mysqli_fetch_all($course_result, MYSQLI_NUM);

  
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
    <link rel="stylesheet" href="../css/aprendiz.css" />
    <title>Portafolio</title>
</head>
<body>
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">💼 Portafolio</h1>
        <?php 
            for($i=0; $i<sizeof($course_array); $i++){
                $program = $course_array[$i][1];
                $ficha = $course_array[$i][2];

                // GET PROGRAM NAME
                $program_query = "SELECT nombre FROM programa_formacion WHERE ID_Programa = $program";
                $program_result= mysqli_query($dbConnection, $program_query) or die(mysqli_error($dbConnection));
                $program_array = mysqli_fetch_all($program_result, MYSQLI_NUM);
                $program_name = $program_array[0][0];

                ?>
                    <a class="program program-<?php echo $i ?>" href="#briefcase-<?php echo $i ?>">
                        <img class="program__figure" src="../img/courses/sena-logo.png" alt="program">
                        <div class="program__id">
                            <div class="program__title"><?php echo $program_name; ?></div>
                            <div class="program__group"><?php echo $ficha; ?></div>
                        </div>
                    </a>
                <?php

                // GET INSTRUCTOR BY AMBIENTE VIRTUAL
                $instructor = "SELECT A.ID_Persona, P.nombres, P.apellidos,  A.ID_Ficha FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Programa = '$program' AND A.ID_Ficha = $ficha AND P.ID_Rol = 2";
                $instructor_result = mysqli_query($dbConnection, $instructor) or die(mysqli_error($dbConnection));
                $instructor_array = mysqli_fetch_all($instructor_result, MYSQLI_NUM);
                $id_instructor = $instructor_array[0][0];

                // GET INSTRUCTOR'S activities
                $activities = "SELECT ID_Actividad, asunto, fecha FROM `actividad` WHERE ID_Persona = $id_instructor AND ID_Ficha = $ficha";
                $activities_result = mysqli_query($dbConnection, $activities) or die(mysqli_error($dbConnection));
                $activities_array = mysqli_fetch_all($activities_result, MYSQLI_NUM);
                ?>
                <div class="briefcase hidden" id="briefcase-<?php echo $i ?>">
                    <?php
                    if(sizeof($activities_array) > 0){
                        for($j=0; $j < sizeof($activities_array); $j++){
                            $id_activity = $activities_array[$j][0];
                            $activity_title = $activities_array[$j][1];
                        
                            // GET EVIDENCES DELIVERED BY activity
                            $evidences = "SELECT fecha, nota, observacion, url, ID_Actividad, ID_Evidencia FROM `evidencia` WHERE ID_Persona =".$_SESSION['id']." AND ID_Actividad = $id_activity";
                            $evidences_result = mysqli_query($dbConnection, $evidences) or die(mysqli_error($dbConnection));
                            $evidences_array = mysqli_fetch_all($evidences_result, MYSQLI_NUM);

                            if(sizeof($evidences_array) > 0){
                                ?>
                                    <div class="briefcase-evidence">
                                        <div class="briefcase-evidence__activity">
                                            <i class="fa-solid fa-book briefcase-evidence__icon"></i>
                                            <div class="briefcase-evidence__title"><?php echo $activity_title; ?></div>
                                        </div>
                                        <div class="briefcase-evidence__date"><?php echo $evidences_array[0][0] ;?></div>
                                        <div class="briefcase-evidence__grade">
                                            <div class="briefcase-evidence__grade-value">
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
                                            <div class="briefcase-evidence__grade-range">
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
                                        <div class="briefcase-evidence__icons">
                                            <div class="briefcase-evidence__observation">
                                                <i class="fa-regular fa-comment-dots"></i>
                                                <div class="briefcase-evidence__observation-p">
                                                    <?php
                                                        if($evidences_array[0][2] != ''){
                                                            echo "1";
                                                        } else{
                                                            echo "0";
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <a href="activity.php?activity=<?php echo $evidences_array[0][4] ;?>" class="briefcase-evidence__link"><i class="fa-regular fa-eye"></i></a>
                                            <a href="<?php echo $evidences_array[0][3] ;?>" class="briefcase-evidence__link" download=""><i class="fa-regular fa-file-lines"></i></a>
                                            <a href="delete.php?evidence=<?php echo $evidences_array[0][5] ;?>" class="briefcase-evidence__link briefcase-evidence__link--highlight delete-button"><i class="fa-regular fa-trash-can"></i></a>
                                        </div>
                                    </div>
                                <?php
                            } else{
                                ?>
                                <!-- EVIDENCE NOT DELIVERED -->
                                    <div class="briefcase-evidence briefcase-evidence--empty">
                                        <div class="briefcase-evidence__activity">
                                            <i class="fa-solid fa-triangle-exclamation briefcase-evidence__icon"></i>
                                            <div class="briefcase-evidence__title"><?php echo $activity_title ;?></div>
                                        </div>
                                        <div class="briefcase-evidence--empty__alert">SIN ENTREGA</div>
                                    </div>
                                <?php
                            }

                        }
                    } else{
                        ?>
                        <div class="briefcase-empty">
                            No se han publicado actividades en este programa.
                        </div>
                        <?php
                    }
                    ?>
                    <hr class="program-divider">
                </div>
                <?php
            }
        ?>
    </main>
</body>
<script>
    const deleteUser = document.querySelectorAll('.delete-button');
    deleteUser.forEach((e, i) => {
        deleteUser[i].addEventListener('click', (e) => {
            e.preventDefault();
            console.log(deleteUser[i].getAttribute('href'));
            Swal.fire({
                title: '¿Seguro que quieres eliminar esta evidencia?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.assign(deleteUser[i].getAttribute('href'));
            }
            })
        })
    })
</script>
<?php
    if(isset($_GET['message']) && $_GET['message'] === 'error'){
      ?><script>Swal.fire({icon: 'error',title: 'Error',text: 'Esta evidencia ya esta calificada y no puede ser eliminada'});</script><?php
    }
  ?>
<script src="../../Controllers/aprendiz-briefcase.js"></script>
</html>
<?php 
      } else {
        include('../../Models/logout.php');
        $location = header('Location: ../index.php');
      }
?> 