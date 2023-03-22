<?php
	include_once "../../Models/connection.php";
	session_start();
  include_once "../validations.php";

	if (isset($_SESSION['id'])) {
		$id_evidencia = $_GET['evidence'];  

		$evidence = "SELECT E.ID_Actividad, E.ID_Persona, AC.ID_Ficha, E.fecha, E.descripcion, E.url, E.nota, E.observacion, E.nivelada FROM evidencia E JOIN actividad AC ON E.ID_Actividad = AC.ID_Actividad WHERE ID_Evidencia = $id_evidencia;";
		$evidence_result = mysqli_query($dbConnection, $evidence) or die(mysqli_error($dbConnection));
		$evidence_array = mysqli_fetch_all($evidence_result, MYSQLI_NUM);

		$id_actividad = $evidence_array[0][0];
		$id_student = $evidence_array[0][1];

		$activity = "SELECT asunto, fecha, fecha_limite FROM actividad WHERE ID_Actividad = $id_actividad;";
		$activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
		$activity_array = mysqli_fetch_all($activity_result, MYSQLI_NUM);

		$student = "SELECT nombres, apellidos FROM persona WHERE ID_Persona = $id_student";
		$student_result = mysqli_query($dbConnection, $student) or die(mysqli_error($dbConnection));
		$student_array = mysqli_fetch_all($student_result, MYSQLI_NUM);
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
      <div class="activity-selected">
        <i class="fa-solid fa-book activity-selected__icon"></i>
        <div class="activity-selected__title"><?php echo $activity_array[0][0]; ?></div>
        <div class="activity-selected__term">
          <div class="activity-selected__time">
            <div class="activity-selected__time-label">Fecha publicación</div>
            <div class="activity-selected__time-date"><?php echo $activity_array[0][1]; ?></div>
          </div>
          <div class="activity-selected__time">
            <div class="activity-selected__time-label">Fecha límite</div>
            <div class="activity-selected__time-date activity-selected__time-date--due"><?php echo $activity_array[0][2]; ?></div>
          </div>
        </div>
      </div>
			
      <div class="evidence-element">
				<div class="user-evidence">
					<div class="user-evidence__info">
						<img src="../img/default.jpeg" class="user-evidence__photo"></img>
						<div class="user-evidence__group">
							<div class="user-evidence__group-label">Curso</div>
							<div class="user-evidence__group-num"><?php echo $group_num; ?></div>
						</div>
					</div>
					<div class="user-evidence__data">
						<div class="user-evidence__name"><?php echo $student_array[0][0];?>  <?php echo $student_array[0][1];?></div>
						<div class="user-evidence__date">Fecha de entrega: <?php echo $evidence_array[0][3]; ?></div>
						<div class="user-evidence__description"><?php echo $evidence_array[0][4]; ?></div>
						<?php if(intval($evidence_array[0][8]) === 1) {?> <div class="evidence-recovered"><i class="fa-sharp fa-solid fa-circle-exclamation"></i> Evidencia nivelada</div> <?php } ?>
					</div>
					<div class="user-evidence__file">
						<div class="user-evidence__file-label">Evidencia:</div>
						<a href="<?php echo $evidence_array[0][5]; ?>" class="user-evidence__file-src" download=""><i class="fa-regular fa-file-lines"></i></a>
					</div>
				</div>
        <hr>
        <!-- CALIFICATION FORM -->
        <form action="upload-grade.php?group=<?php echo $group ?>&evidence=<?php echo $id_evidencia; ?>&activity=<?php echo $id_actividad; ?>" class="calification-form" method="POST">
          <div class="calification-form__grade">
            <div class="calification-form__grade-label">Calificación</div>
            <div class="calification-form__grade-input">
              <input type="number" min="0" max="100" class="calification-form__grade-input--inp" placeholder="0" name="calification" <?php if($evidence_array[0][6]) {?> value ="<?php echo $evidence_array[0][6] ?>" disabled <?php } ?> >
              <span>/100</span>
            </div>
          </div>
          <div class="calification-form__observation">
            <div class="calification-form__observation-label">Observación</div>
            <textarea name="observation" class="calification-form__observation-input" placeholder="Escribe una observación" maxlength="600" <?php if($evidence_array[0][7]) {?> disabled <?php }?> ><?php if($evidence_array[0][7]) echo $evidence_array[0][7] ?></textarea>
          </div>
          <label for="submit-btn" class="calification-form__btn-submit <?php if($evidence_array[0][6]) {?> hidden <?php }?>"><i class="fa-regular fa-paper-plane"></i></label>
          <input type="submit" id="submit-btn" name="submit" class="hidden">
        </form>
        <div class="user-evidence__modify-grade"><i class="fa-solid fa-pen-to-square"></i> Modificar nota</div>
      </div>
    </main>
  <?php
    if(isset($_GET['message']) && $_GET['message'] === 'empty'){
      ?><script>Swal.fire({icon: 'error', title: 'Error', text: 'Debes ingresar una calificación'});</script><?php
    }
  ?>
  <script src="../../Controllers/modify-grade.js"></script>
</body>
</html>
<?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?> 