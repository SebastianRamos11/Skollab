<?php
  include_once "../../Models/connection.php";
  session_start();
  include_once "../validations.php";
	
	$group_num = "SELECT numero FROM ficha WHERE ID_Ficha = $group";
  $group_num_result = mysqli_query($dbConnection, $group_num) or die(mysqli_error($dbConnection));
  $group_num = mysqli_fetch_all($group_num_result, MYSQLI_NUM)[0][0];
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
				// GET COURSE DATA
				$course = "SELECT ID_Materia, ID_Instructor FROM curso WHERE ID_Ficha = $group";
				$course_result = mysqli_query($dbConnection, $course) or die(mysqli_error($dbConnection));
				$course = mysqli_fetch_all($course_result, MYSQLI_NUM);

				?>
				<div class="user-course">
					<h2 class="user-course__name">Curso <?php echo $group_num ?></h2>
					<hr>
					<?php
						for($j = 0; $j < sizeof($course); $j++){
							$id_subject = $course[$j][0];
							$id_instructor = $course[$j][1];

							// GET SUBJECT
							$subject = "SELECT img, nombre FROM materia WHERE ID_Materia = $id_subject";
							$subject_result= mysqli_query($dbConnection, $subject) or die(mysqli_error($dbConnection));
							$subject = mysqli_fetch_all($subject_result, MYSQLI_NUM);

							// GET INSTRUCTOR'S ACTIVITIES
							$activities = "SELECT ID_Actividad, asunto, fecha FROM `actividad` WHERE ID_Ficha = $group AND ID_Persona = $id_instructor";
							$activities_result = mysqli_query($dbConnection, $activities) or die(mysqli_error($dbConnection));
							$activities_array = mysqli_fetch_all($activities_result, MYSQLI_NUM);

							?>
							<!-- SUBJECT -->
							<a class="program program-<?php echo $i ?>" href="#briefcase-<?php echo $j ?>">
								<img class="program__figure" src="<?php echo $subject[0][0]; ?>" alt="program">
								<div class="program__id">
									<div class="program__title"><?php echo $subject[0][1]; ?></div>
								</div>
							</a>

							<!-- SUBJECT'S ACTIVITIES-->
							<div class="briefcase hidden" id="briefcase-<?php echo $i ?>">
									<?php
										if(sizeof($activities_array) > 0){
											for($k=0; $k < sizeof($activities_array); $k++){
												$id_activity = $activities_array[$k][0];
												$activity_title = $activities_array[$k][1];
												
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
																		?><span class="gradeValue"><?php echo $evidences_array[0][1] ?>/100</span><?php
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
																			?>" style="width: <?php echo $evidences_array[0][1] ?>%;">
																		</span>
																		<?php
																	} else{
																		?><span style="width: 0;"></span><?php
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
															<a href="activity.php?group=<?php echo $group ?>&activity=<?php echo $evidences_array[0][4] ;?>" class="briefcase-evidence__link"><i class="fa-regular fa-eye"></i></a>
															<a href="<?php echo $evidences_array[0][3] ;?>" class="briefcase-evidence__link" download=""><i class="fa-regular fa-file-lines"></i></a>
															<?php if(!$evidences_array[0][1]) { ?> <a href="delete.php?group=<?php echo $group ?>&evidence=<?php echo $evidences_array[0][5];?>&b=1" class="briefcase-evidence__link briefcase-evidence__link--highlight delete-button"><i class="fa-regular fa-trash-can"></i></a> <?php }?>
														</div>
													</div>
													<?php
												} else{
													?>
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
											?><div class="briefcase-empty">No se han publicado actividades en esta materia.</div><?php
										}
									?>
									<hr class="program-divider">
							</div>
							<?php
						}
					?>
				</div>
				<?php
      ?>
    </main>
		<script src="../../Controllers/confirm-deletion.js"></script>
		<script>confirmDeletion('¿Seguro que quieres eliminar esta evidencia?')</script>
		<?php 
		  if(isset($_GET['message'])){
				if($_GET['message'] === 'error') {
					?><script>Swal.fire({icon: 'error',title: 'Error',text: 'Esta evidencia ya esta calificada y no puede ser eliminada'});</script><?php
				} else if($_GET['message'] === 'deleted'){
					?><script>Swal.fire({icon: 'success',title: 'Evidencia eliminada',text: 'La evidencia ha sido eliminada correctamente'});</script><?php
				}
			}
		?>
		<script src="../../Controllers/aprendiz-briefcase.js"></script>
	</body>
</html>