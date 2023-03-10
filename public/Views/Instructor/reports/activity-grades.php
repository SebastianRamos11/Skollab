<?php
  include_once "../../../Models/connection.php"; session_start();
  require_once('../../../../src/tcpdf/tcpdf.php');

  // Primary data
  $id_user = $_SESSION['id'];
  $id_activity = $_GET['activity'];
  $group = $_GET['group'];
  $group_num = $_GET['num'];

  // Instructor
  $instructor = "SELECT nombres, apellidos FROM persona WHERE ID_Persona = $id_user";
  $instructor_result = mysqli_query($dbConnection, $instructor) or die(mysqli_error($dbConnection));
  $instructor = mysqli_fetch_all($instructor_result, MYSQLI_NUM);

  // Subject
  $subject = "SELECT nombre FROM materia M JOIN curso C ON M.ID_Materia = C.ID_Materia WHERE ID_Instructor = $id_user";
  $subject_result = mysqli_query($dbConnection, $subject) or die(mysqli_error($dbConnection));
  $subject = mysqli_fetch_all($subject_result, MYSQLI_NUM)[0][0];

  // Activity
  $activity = "SELECT asunto, fecha, fecha_limite FROM actividad WHERE ID_Actividad = $id_activity;";
  $activity_result = mysqli_query($dbConnection, $activity) or die(mysqli_error($dbConnection));
  $activity = mysqli_fetch_all($activity_result, MYSQLI_NUM);

  // Students
  $student = "SELECT P.num_documento, P.nombres, P.apellidos, P.telefono, P.correo_electronico, A.ID_Persona FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Ficha = $group AND P.ID_Rol = 3";
  $student_result = mysqli_query($dbConnection, $student) or die(mysqli_error($dbConnection));
  $student = mysqli_fetch_all($student_result, MYSQLI_NUM);

  // create new PDF document
  $pdf = new TCPDF();
  $date = date("d/m/Y");

  // Introduction data
  $introduction = '
    <h1>Reporte de notas de actividad</h1>
    <h3>Nombre de la actividad: '.$activity[0][0].'</h3>
    <i>Generado el '.$date.'</i> 
    <p>El siguiente listado presenta el reporte de notas de la actividad <strong>'.$activity[0][0].'</strong>, de la materia <strong>'.$subject.'</strong>, instruida por <strong>'.$instructor[0][0].' '.$instructor[0][1].'</strong>, la cual fue publicada el <strong>'.$activity[0][1].'</strong>, con fecha límite <strong>'.$activity[0][2].'</strong>.</strong></p>
    <br>
  ';


  // Student evidences
  $evidences = "SELECT fecha, nota, nivelada, ID_Persona FROM evidencia WHERE ID_Actividad = $id_activity";
  $evidences_result = mysqli_query($dbConnection, $evidences) or die(mysqli_error($dbConnection));
  $evidences = mysqli_fetch_all($evidences_result, MYSQLI_NUM);

  // Print students
  if(sizeof($evidences) > 0){
    // Table  
    $table_evidences = '
      <style>
        .evidences th {
          display: block;
          background-color: #0066ff ;
          font-size: 16px;
          color: #fff;
        }
        td {
          font-size: 14px;
        }
      </style>
      <h3>Estudiantes que entregaron la actividad:</h3>
      <br>
      <table border="1" style="text-align: center;padding: 5px 10px;">
        <thead>
          <tr class="evidences">
            <th><strong>ID</strong></th>
            <th><strong>Nombres</strong></th>
            <th><strong>Apellidos</strong></th>
            <th><strong>Fecha de entrega</strong></th>
            <th><strong>Nota</strong></th>
            <th><strong>Nivelada</strong></th>
          </tr>
        <thead>
        <tbody>
    ';
    for($i = 0; $i < sizeof($evidences); $i++){
      $id_student = $evidences[$i][3];
      
      $student_name = "SELECT num_documento, nombres, apellidos FROM `persona` WHERE ID_Persona = $id_student";
      $student_name_result = mysqli_query($dbConnection, $student_name) or die(mysqli_error($dbConnection));
      $student_name = mysqli_fetch_all($student_name_result, MYSQLI_NUM);

      $calification = $evidences[$i][1] ? $evidences[$i][1] : 'Sin calificación';
      $leveled = $evidences[$i][2] ? 'Si' : 'No';

      $table_evidences .= '
        <tr>
          <td>'.$student_name[0][0].'</td>
          <td>'.$student_name[0][1].'</td>
          <td>'.$student_name[0][2].'</td>
          <td>'.$evidences[$i][0].'</td>
          <td>'.$calification.'</td>
          <td>'.$leveled.'</td>
        </tr>
      ';
    }
    $table_evidences .= '</tbody></table>';
  } else{
    $table_evidences = '<p>Ningún estudiante ha entregado la actividad.</p>';
  }

  // Pending students
  $pending_students = array();
  for($i=0; $i < sizeof($student); $i++){
    $id_student = $student[$i][5];
    $delivery = "SELECT url FROM `evidencia` WHERE ID_Persona = $id_student AND ID_Actividad = $id_activity";
    $delivery_result = mysqli_query($dbConnection, $delivery) or die(mysqli_error($dbConnection));
    $delivery_array = mysqli_fetch_all($delivery_result, MYSQLI_NUM);
    if(sizeof($delivery_array) === 0) array_push($pending_students, $student[$i]);
  }

  if(sizeof($pending_students) > 0){
    $table_pending = '
      <style>
        .pending th {
          display: block;
          background-color: #ff3030;
          font-size: 16px;
          color: #fff;
        }
        td {
          font-size: 14px;
        }
      </style>
      <br>
      <h3>Estudiantes pendientes por entregar:</h3>
      <br>
      <table border="1" style="text-align: center;padding: 5px 10px;">
        <thead>
          <tr class="pending">
            <th><strong>ID</strong></th>
            <th><strong>Nombres</strong></th>
            <th><strong>Apellidos</strong></th>
            <th><strong>Teléfono</strong></th>
            <th><strong>Correo</strong></th>
          </tr>
        </thead>
        <tbody>
    ';
    for($i = 0; $i < sizeof($pending_students); $i++){

      $table_pending .= '
        <tr>
          <td>'.$pending_students[$i][0].'</td>
          <td>'.$pending_students[$i][1].'</td>
          <td>'.$pending_students[$i][2].'</td>
          <td>'.$pending_students[$i][3].'</td>
          <td>'.$pending_students[$i][4].'</td>
        </tr>
      ';
    }
    $table_pending .= '</tbody></table>';
  }

  // Print prending students


  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Skollab');
  $pdf->SetTitle('Reporte de estudiante');
  $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

  // set default header data
  $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

  // set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  // set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // ---------------------------------------------------------

  // set font
  $pdf->SetFont('helvetica', '', 12);

  // add a page
  $pdf->AddPage();

  // column titles
  $header = array('ID', 'Nombres', 'Apellidos', 'Correo electrónico');

  // Load html content
  $pdf->writeHTMLCell(0, 0, '', '', $introduction, 0, 1, 0, true, '', true);
  $pdf->writeHTMLCell(0, 0, '', '', $table_evidences, 0, 1, 0, true, '', true);
  $pdf->writeHTMLCell(0, 0, '', '', $table_pending, 0, 1, 0, true, '', true);

  // ---------------------------------------------------------

  // close and output PDF document
  $pdf->Output('NotasActividad'.$activity[0][0].'.pdf', 'I');
?>
