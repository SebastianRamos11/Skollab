<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
  $read_query = "SELECT * FROM persona WHERE ID_Persona =".$_SESSION['id'];
  $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);

  // GET AMBIENTE VIRTUAL
  $temp = "SELECT * FROM ambiente_virtual WHERE ID_Persona =".$_SESSION['id'];
  $temp_result = mysqli_query($dbConnection, $temp) or die(mysqli_error($dbConnection));
  $temp_array = mysqli_fetch_all($temp_result, MYSQLI_NUM);

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
            for($i=0; $i<sizeof($temp_array); $i++){
                $program = $temp_array[$i][1];
                $ficha = $temp_array[$i][2];

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
                $instructor = "SELECT A.ID_Persona, P.nombres, P.apellidos,  A.ID_Ficha FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Programa = '$program' AND A.ID_Ficha = $ficha AND P.rol = 'INSTRUCTOR'";
                $instructor_result = mysqli_query($dbConnection, $instructor) or die(mysqli_error($dbConnection));
                $instructor_array = mysqli_fetch_all($instructor_result, MYSQLI_NUM);
                $id_instructor = $instructor_array[0][0];

                // GET INSTRUCTOR'S PUBLICATIONS
                $publications = "SELECT ID_Publicacion, asunto FROM `publicacion` WHERE ID_Persona = $id_instructor";
                $publications_result = mysqli_query($dbConnection, $publications) or die(mysqli_error($dbConnection));
                $publications_array = mysqli_fetch_all($publications_result, MYSQLI_NUM);

                ?>
                <div class="briefcase hidden" id="briefcase-<?php echo $i ?>">
                    <?php
                    if(sizeof($publications_array) > 0){
                        for($j=0; $j < sizeof($publications_array); $j++){
                            $id_publication = $publications_array[$j][0];
                            $publication_title = $publications_array[$j][1];
                        
                            // GET EVIDENCES DELIVERED BY PUBLICATION
                            $evidences = "SELECT fecha, nota, observacion, url, ID_Publicacion FROM `evidencia` WHERE ID_Persona =".$_SESSION['id']." AND ID_Publicacion = $id_publication";
                            $evidences_result = mysqli_query($dbConnection, $evidences) or die(mysqli_error($dbConnection));
                            $evidences_array = mysqli_fetch_all($evidences_result, MYSQLI_NUM);

                            if(sizeof($evidences_array)){
                                ?>
                                    <div class="briefcase-evidence">
                                        <div class="briefcase-evidence__publication">
                                            <i class="fa-solid fa-book briefcase-evidence__icon"></i>
                                            <div class="briefcase-evidence__title"><?php echo $publication_title; ?></div>
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
                                            <a href="<?php echo $evidences_array[0][3] ;?>" class="briefcase-evidence__file"><i class="fa-regular fa-file-lines"></i></a>
                                            <a href="turned-evidence.php?evidence=<?php echo $evidences_array[0][4] ;?>" class="briefcase-evidence__link"><i class="fa-regular fa-eye"></i></a>
                                        </div>
                                    </div>
                                <?php
                            }

                        }
                    } else{
                        ?>
                        <div class="briefcase-empty">
                            Aún no has entregado ninguna evidencia en este programa.
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
<script src="../../Controllers/aprendiz-briefcase.js"></script>
</html>
<?php 
      } else {
        include('../../Models/logout.php');
        $location = header('Location: ../index.php');
      }
?> 