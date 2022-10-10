<?php
  include_once "../../Models/connection.php";
  session_start();
  if (isset($_SESSION['id'])) {
  $id_evidencia = $_GET['evidence'];  

  $evidence = "SELECT E.ID_Publicacion, E.ID_Persona, P.ID_Ficha, E.fecha, E.descripcion, E.url FROM evidencia E JOIN publicacion P ON E.ID_Publicacion = P.ID_Publicacion WHERE ID_Evidencia = $id_evidencia;";
  $evidence_result = mysqli_query($dbConnection, $evidence) or die(mysqli_error($dbConnection));
  $evidence_array = mysqli_fetch_all($evidence_result, MYSQLI_NUM);

  $id_publicacion = $evidence_array[0][0];
  $id_aprendiz = $evidence_array[0][1];

  $publication = "SELECT asunto, fecha, fecha_limite FROM publicacion WHERE ID_Publicacion = $id_publicacion;";
  $publication_result = mysqli_query($dbConnection, $publication) or die(mysqli_error($dbConnection));
  $publication_array = mysqli_fetch_all($publication_result, MYSQLI_NUM);

  $aprendiz = "SELECT nombres, apellidos FROM persona WHERE ID_Persona = $id_aprendiz";
  $aprendiz_result = mysqli_query($dbConnection, $aprendiz) or die(mysqli_error($dbConnection));
  $aprendiz_array = mysqli_fetch_all($aprendiz_result, MYSQLI_NUM);
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
    <title>Calificar evidencia</title>
</head>
<body>
    <?php include './sidebar.php' ?>
        <h1 class="main-content__header">Calificar evidencia 📝</h1>


        <!-- PUBLICATION SELECTED -->
        <div class="publication-selected">
            <i class="fa-solid fa-book publication-selected__icon"></i>
            <div class="publication-selected__title"><?php echo $publication_array[0][0]; ?></div>
            <div class="publication-selected__term">
                <div class="publication-selected__time">
                    <div class="publication-selected__time-label">Fecha publicación</div>
                    <div class="publication-selected__time-date"><?php echo $publication_array[0][1]; ?></div>
                </div>
                <div class="publication-selected__time">
                    <div class="publication-selected__time-label">Fecha límite</div>
                    <div class="publication-selected__time-date publication-selected__time-date--due"><?php echo $publication_array[0][2]; ?></div>
                </div>
            </div>
        </div>

        <div class="evidence-element">
            <!-- USER EVIDENCE -->
            <div class="user-evidence">
                <div class="user-evidence__info">
                    <img src="../img/default.jpeg" class="user-evidence__photo"></img>
                    <div class="user-evidence__group">
                        <div class="user-evidence__group-label">Ficha</div>
                        <div class="user-evidence__group-num"><?php echo $evidence_array[0][2]; ?></div>
                    </div>
                </div>
                <div class="user-evidence__data">
                    <div class="user-evidence__name"><?php echo $aprendiz_array[0][0];?>  <?php echo $aprendiz_array[0][1];?></div>
                    <div class="user-evidence__date">Fecha de entrega: <?php echo $evidence_array[0][3]; ?></div>
                    <div class="user-evidence__description"><?php echo $evidence_array[0][4]; ?></div>
                </div>
                <div class="user-evidence__file">
                    <div class="user-evidence__file-label">Evidencia:</div>
                    <a href="<?php echo $evidence_array[0][5]; ?>" class="user-evidence__file-src" download=""><i class="fa-regular fa-file-lines"></i></a>
                </div>
            </div>
            <hr>
            <!-- CALIFICATION FORM -->
            <form action="upload-grade.php?evidence=<?php echo $id_evidencia; ?>" class="calification-form" method="POST">
                <div class="calification-form__grade">
                    <div class="calification-form__grade-label">Calificación</div>
                    <div class="calification-form__grade-input">
                        <input type="range" min="0" max="100" value="0" name="calification" id="calification" class="calification-form__grade-input-range" onChange="rangeSlide(this.value)" onmousemove="rangeSlide(this.value)">
                        <div class="calification-form__grade-input-value"><span id="rangeValue">0</span>/100</div>
                    </div>
                </div>
                <div class="calification-form__observation">
                    <div class="calification-form__observation-label">Observación</div>
                    <textarea name="observation" class="calification-form__observation-input" placeholder="Escribe una observación" maxlength="600"></textarea>
                </div>
                <label for="submit-btn" class="calification-form__btn-submit"><i class="fa-regular fa-paper-plane"></i></label>
                <input type="submit" id="submit-btn" name="submit" class="hidden">
            </form>
        </div>
    </main>
    <script type="text/javascript">
        const rangeValue = document.getElementById('rangeValue');
        function rangeSlide(value) {
            rangeValue.innerHTML = value;
            if(value > 80){
                rangeValue.style.color = "#00D809";
            } else if(value > 60){
                rangeValue.style.color = "#FF782D";
            } else{
                rangeValue.style.color = "#ff3030";
            }
        }
    </script>
    <script src="../../Controllers/set-date.js"></script>
    <script src="../../Controllers/aprendiz-control.js"></script>
</body>
</html>
<?php 
      } else {
        include('../../Models/logout.php');
        $location = header('Location: ../index.php');
      }
?> 