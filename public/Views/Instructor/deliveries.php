<?php
  include_once "../../Models/connection.php";
  session_start();
  include_once "../validations.php";

  $id_user = $_SESSION['id'];

  if (isset($_SESSION['id'])) {
    $id_activity = $_GET['activity'];

    // ACTIVITY DATA
    $activity = "SELECT asunto, fecha, fecha_limite FROM actividad WHERE ID_Actividad = $id_activity;";
    $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
    $activity = mysqli_fetch_all($activity_result, MYSQLI_NUM);
    
    $student = "SELECT P.num_documento, P.nombres, P.apellidos, P.telefono, P.correo_electronico, A.ID_Persona FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Ficha = $group AND P.ID_Rol = 3";
    $student_result = mysqli_query($dbConnection, $student) or die(mysqli_error($dbConnection));
    $student = mysqli_fetch_all($student_result, MYSQLI_NUM);

    $group_num = "SELECT numero FROM ficha WHERE ID_Ficha = $group";
    $group_num_result = mysqli_query($dbConnection, $group_num) or die(mysqli_error($dbConnection));
    $group_num = mysqli_fetch_all($group_num_result, MYSQLI_NUM)[0][0];

    $pending_users = array();
    
    for($i=0; $i < sizeof($student); $i++){
      $id_student = $student[$i][5];
      
      $delivery = "SELECT url FROM `evidencia` WHERE ID_Persona = $id_student AND ID_Actividad = $id_activity";
      $delivery_result = mysqli_query($dbConnection, $delivery) or die(mysqli_error($dbConnection));
      $delivery_array = mysqli_fetch_all($delivery_result, MYSQLI_NUM);

      if(sizeof($delivery_array) === 0) array_push($pending_users, $student[$i]);
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
      <a href="activities.php?group=<?php echo $group ?>" title="Volver" class="back-button"><i class="fa-solid fa-arrow-left"></i> Volver</a>
			<h2 style="margin-top: 40px">Actividad a calificar</h2>
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

			<div class="actions actions--deliveries">
        <a download="" href="./reports/activity-grades.php?activity=<?php echo $id_activity ?>&group=<?php echo $group ?>&num=<?php echo $group_num ?>" title="Generar reporte de notas" class="btn btn-report"><i class="fa-regular fa-file-pdf"></i> Generar Reporte de Notas</a>
      </div>

			<div class="pending-grades">
				<h2>📝 Evidencias por calificar</h2>
				<hr>
				<div class="evidences">
					<?php 
						$evidences = "SELECT ID_Evidencia, fecha, ID_Persona, nivelada FROM evidencia WHERE ID_Actividad = $id_activity AND nota IS NULL OR ID_Actividad = $id_activity AND nivelada = 1";
						$evidences_result = mysqli_query($dbConnection, $evidences) or die(mysqli_error($dbConnection));
						$evidences = mysqli_fetch_all($evidences_result, MYSQLI_NUM);
						if(sizeof($evidences) > 0){
							for($i = 0; $i < sizeof($evidences); $i++){
								$id_student = $evidences[$i][2];

								$student_name = "SELECT nombres, apellidos FROM `persona` WHERE ID_Persona = $id_student";
								$student_name_result = mysqli_query($dbConnection, $student_name) or die(mysqli_error($dbConnection));
								$student_name = mysqli_fetch_all($student_name_result, MYSQLI_NUM);
								$student_name =  $student_name[0][0]." ".$student_name[0][1];
								?>
								<div class="evidence">
									<div class="evidence__user">
										<i class="fa-solid fa-book evidence__icon"></i>
										<div class="evidence__name"><?php echo $student_name ?></div>
									</div>
									<div class="evidence__date"><?php echo $evidences[$i][1]; ?></div>
									<?php if($evidences[$i][3]) { ?> <div class="evidence-recovered"><i class="fa-sharp fa-solid fa-circle-exclamation"></i> NIVELADA</div> <?php }?>
									<a href="evidence.php?group=<?php echo $group ?>&evidence=<?php echo $evidences[$i][0]; ?>" class="evidence__link">Calificar</a>
								</div>
								<?php
							}
						} else{
							?><div class="neutral-message"><i class="fa-solid fa-check"></i> No hay evidencias por calificar.</div><?php
						}
					?>
				</div>
			</div>

			<div class="qualified-evidences">
				<h2>✅ Evidencias calificadas</h2>
				<hr>
				<div class="evidences">
					<?php 
						$qualified_evidences = "SELECT fecha, nota, observacion, ID_Evidencia, ID_Persona  FROM evidencia WHERE ID_Actividad = $id_activity AND nota IS NOT NULL AND nivelada = 0";
						$qualified_evidences_result = mysqli_query($dbConnection, $qualified_evidences) or die(mysqli_error($dbConnection));
						$qualified_evidences = mysqli_fetch_all($qualified_evidences_result, MYSQLI_NUM);
						
						if(sizeof($qualified_evidences) > 0){
							for($i = 0; $i < sizeof($qualified_evidences); $i++){
								$id_student = $qualified_evidences[$i][4];
		
								$student_name = "SELECT nombres, apellidos FROM `persona` WHERE ID_Persona = $id_student";
								$student_name_result = mysqli_query($dbConnection, $student_name) or die(mysqli_error($dbConnection));
								$student_name = mysqli_fetch_all($student_name_result, MYSQLI_NUM);
								$student_name =  $student_name[0][0]." ".$student_name[0][1];
								?>
								<div class="qualified-evidence">
									<div class="qualified-evidence__owner">
										<i class="fa-solid fa-book qualified-evidence__icon"></i>
										<div class="qualified-evidence__title"><?php echo $student_name ?></div>
									</div>
									<div class="qualified-evidence__date"><?php echo $qualified_evidences[$i][0] ;?></div>
									<div class="qualified-evidence__grade">
										<div class="qualified-evidence__grade-value">
											<?php
												if($qualified_evidences[$i][1] != ''){
													?><span class="gradeValue"><?php echo $qualified_evidences[$i][1] ?>/100</span><?php
												} else{
													echo "--/100";
												}
											?>
										</div>
										<div class="qualified-evidence__grade-range">
											<?php
												if($qualified_evidences[$i][1] != ''){
													?>
													<span class="<?php 
														if(intval($qualified_evidences[$i][1]) > 80){
															echo "grade-a";
														}else if(intval($qualified_evidences[$i][1]) > 60){
															echo "grade-b";
														} else{
															echo "grade-d";
														}
													?>" style="width: <?php echo $qualified_evidences[$i][1] ?>%;">
													</span>
													<?php
												} else{
													?><span style="width: 0;"></span><?php
												}
											?>
										</div>
										<div class="qualified-evidence__grade-edit"></div>
									</div>
									<div class="qualified-evidence__icons">
										<a href="evidence.php?group=<?php echo $group ?>&evidence=<?php echo $qualified_evidences[$i][3] ;?>" class="qualified-evidence__link"><i class="fa-regular fa-eye"></i> Gestionar</a>
									</div>
								</div>
								<?php
							}
						} else {
							?><div class="alert-message"><i class="fa-solid fa-triangle-exclamation"></i> No hay evidencias calificadas.</div><?php
						}
					?>
				</div>
			</div>

			<div class="pending-users">
				<h2>🔴 (<?php echo sizeof($pending_users); ?>) Estudiantes pendientes por entregar</h2>
				<hr>
				<?php 
					if(sizeof($pending_users) > 0){
						?>
						<div class="card mb-50">
							<div class="card-header" style="background-color: #ff3030;"></div>
							<div class="p-4">
									<table class="table align-middle">
										<thead>
											<tr>
												<th scope="col">ID</th>
												<th scope="col">Nombres</th>
												<th scope="col">Apellidos</th>
												<th scope="col">Teléfono</th>
												<th scope="col">Correo</th>
												<th scope="col"></th>
											</tr>
										</thead>
										<tbody>
											<?php 
												for($i=0; $i < sizeof($pending_users); $i++){  
													?>
													<tr>
														<td scope="row"><?php echo $pending_users[$i][0]; ?></td>
														<td><?php echo $pending_users[$i][1]; ?></td>
														<td><?php echo $pending_users[$i][2]; ?></td>
														<td><?php echo $pending_users[$i][3]; ?></td>
														<td><?php echo $pending_users[$i][4] ?></td>
														<td><a href="see-aprendiz.php?group=<?php echo $group ?>&student=<?php echo $pending_users[$i][5]; ?>" class="see-button"><i class="fa-regular fa-eye"></i></a></td>
													</tr>
													<?php 
												}
											?>
										</tbody>
									</table>
							</div>
						</div>
						<?php
					} else {
						?><div class="good-message"><i class="fa-solid fa-check"></i> No estudiantes pendientes por entregar esta evidencia.</div><?php
					}
				?>
			</div>
		</main>


    <?php
      if(isset($_GET['message'])){
        if($_GET['message'] === 'qualified') {
          ?><script>Swal.fire({icon: 'success',title: 'Evidencia calificada',text: 'La evidencia se ha calificado correctamente'});</script><?php
        } else if($_GET['message'] === 'error'){
          ?><script>Swal.fire({icon: 'error',title: 'Error',text: '¡Ha ocurrido un error inesperado!'});</script><?php
        }
      }
    ?>
  </body>
  </html>
<?php
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>