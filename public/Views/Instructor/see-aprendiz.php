<?php
  include_once "../../Models/connection.php";
  session_start();
  include_once "../validations.php";

  if (isset($_SESSION['id'])) {
    $id_student = $_GET['student'];
  
    // GET APRENDIZ DATA
    $student = "SELECT nombres, apellidos, ID_Rol, ID_Tipo_Documento, num_documento, correo_electronico, telefono FROM `persona` WHERE ID_Persona = $id_student";
    $student_result = mysqli_query($dbConnection, $student) or die(mysqli_error($dbConnection));
    $student = mysqli_fetch_all($student_result, MYSQLI_NUM);

    // GET ROL
    $role = $student[0][2];
    $role = "SELECT tipo FROM rol WHERE ID_Rol = $role";
    $role_result = mysqli_query($dbConnection, $role) or die(mysqli_error($dbConnection));
    $role = mysqli_fetch_all($role_result, MYSQLI_NUM);

    // GET DOCUMENT TYPE
    $type_doc = $student[0][3];
    $type_doc = "SELECT tipo FROM tipo_documento WHERE ID_Tipo_Documento = $type_doc";
    $type_doc_result = mysqli_query($dbConnection, $type_doc) or die(mysqli_error($dbConnection));
    $type_doc = mysqli_fetch_all($type_doc_result, MYSQLI_NUM);

    // GET AMBIENTE VIRTUAL OF APRENDIZ 
	  $student_groups = "SELECT A.ID_Ficha, F.numero FROM ambiente_virtual A JOIN ficha F ON A.ID_Ficha = F.ID_Ficha WHERE ID_Persona = $id_student";
	  $student_groups_result = mysqli_query($dbConnection, $student_groups) or die(mysqli_error($dbConnection));
	  $student_groups = mysqli_fetch_all($student_groups_result, MYSQLI_NUM);

    // GET INSTRUCTOR ACTIVITIES (TO LOOP)
    $activity_array = array();
    for($i=0; $i < sizeof($student_groups); $i++){
      $ficha = $student_groups[$i][0];
			
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
			<h1 class="main-content__header">👨‍🎓 Gestión de Estudiante</h1>
      <a href="activities.php?group=<?php echo $group ?>" title="Volver" class="back-button back-button--profile-position"><i class="fa-solid fa-arrow-left"></i> Volver</a>

			<div class="user">
				<div class="user-profile">
					<img class="user-profile__photo" src="../img/default.jpeg" alt="user-photo">
					<div class="user-profile__info">
						<div class="user-profile__name"><?php echo $student[0][0] ;?> <?php echo $student[0][1] ;?></div>
						<div class="user-profile__label">
							<div class="user-profile__rol"><?php echo $role[0][0] ;?></div>
							<div class="dot"></div>
							<div class="user-profile__type-id"><?php echo $type_doc[0][0] ;?></div>
							<div class="user-profile__id"><?php echo $student[0][4] ;?></div>
						</div>
						<div class="user-profile__contact">
							<div class="user-profile__contact-data"><i class="fa-regular fa-envelope"></i><?php echo $student[0][5] ;?></div>
							<div class="user-profile__contact-data"><i class="fa-solid fa-phone"></i><?php echo $student[0][6] ;?></div>
						</div>
					</div>
				</div>
				<hr>
				<div class="user-programs">
					<div class="user-programs__label">Cursos en formación</div>
					<?php 
						for($i=0; $i < sizeof($student_groups); $i++){
							?>
							<div class="course">
								<div class="course__title acronym"><?php echo $student_groups[$i][1]; ?></div>
								<img class="course__figure" src="../img/courses/sena-logo.png" alt="course">
							</div>
							<?php 
						}
					?>
				</div>
				<hr>
				<div class="user-evidences">
					<h2 class="user-evidences__label">Estado de actividades</h2>
					<div class="actions actions--student-grades">
          	<a download="" href="./reports/student-grades.php?student=<?php echo $id_student ?>&group=<?php echo $group ?>" title="Generar reporte" class="btn btn-report"><i class="fa-regular fa-file-pdf"></i> Generar Reporte de Notas</a>
					</div>
					<?php 
						if(sizeof($activity_array) > 0){
							for($i = 0; $i < sizeof($activity_array); $i++){ 
								$id_activity = $activity_array[$i][0];
								$title_activity = $activity_array[$i][1];

								$evidences = "SELECT fecha, nota, observacion, url FROM `evidencia` WHERE ID_Persona = $id_student AND ID_Actividad = $id_activity";
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
														?><span class="gradeValue"><?php echo $evidences_array[0][1] ?>/100</span><?php
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
														?>" style="width: <?php echo $evidences_array[0][1] ?>%;">
														</span>
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
							?><div class="alert-message"><i class="fas fa-exclamation-triangle"></i>No has publicado ningúna evidencia</div><?php
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