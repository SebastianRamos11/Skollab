<?php
  include_once "../../../Models/connection.php"; session_start();
  require_once('../../tcpdf/tcpdf.php');

  // create new PDF document
  $pdf = new TCPDF();

  $date = date("d/m/Y");
  $group = $_GET['group'];
  $id_student = $_GET['student'];
  $id_instructor = $_SESSION['id'];

  // Get student data
  $student = "SELECT nombres, apellidos, ID_Tipo_Documento, num_documento, correo_electronico, telefono FROM `persona` WHERE ID_Persona = $id_student";
  $student_result = mysqli_query($dbConnection, $student) or die(mysqli_error($dbConnection));
  $student = mysqli_fetch_all($student_result, MYSQLI_NUM);

  // Get document type
  $type_doc = "SELECT tipo FROM tipo_documento WHERE ID_Tipo_Documento =".$student[0][2];
  $type_doc_result = mysqli_query($dbConnection, $type_doc) or die(mysqli_error($dbConnection));
  $type_doc = mysqli_fetch_all($type_doc_result, MYSQLI_NUM)[0][0];

  // Get instructor name
  $instructor = "SELECT nombres, apellidos FROM persona WHERE ID_Persona = $id_instructor";
  $instructor_result = mysqli_query($dbConnection, $instructor) or die(mysqli_error($dbConnection));
  $instructor = mysqli_fetch_all($instructor_result, MYSQLI_NUM);

  // Get instructor's activities
  $activities = "SELECT ID_Actividad, asunto, fecha, fecha_limite FROM actividad WHERE ID_Persona = $id_instructor AND ID_Ficha = $group";
  $activities_result = mysqli_query($dbConnection, $activities) or die(mysqli_error($dbConnection));
  $activities = mysqli_fetch_all($activities_result, MYSQLI_NUM);

  // Get subject
  $subject = "SELECT nombre FROM materia M JOIN curso C ON M.ID_Materia = C.ID_Materia WHERE ID_Instructor = $id_instructor";
  $subject_result = mysqli_query($dbConnection, $subject) or die(mysqli_error($dbConnection));
  $subject = mysqli_fetch_all($subject_result, MYSQLI_NUM)[0][0];

  // Get group number
  $group_num = "SELECT numero FROM ficha WHERE ID_Ficha = $group";
  $group_num_result = mysqli_query($dbConnection, $group_num) or die(mysqli_error($dbConnection));
  $group_num = mysqli_fetch_all($group_num_result, MYSQLI_NUM)[0][0];

  // Introduction data
  $introduction = '
    <h1>Reporte de estudiante</h1>
    <i>Generado el '.$date.'</i> 
    <p>En el presente documento se presenta el reporte de calificaciones del estudiante <strong>'.$student[0][0].' '.$student[0][1].'</strong> con <strong>'.$type_doc.'</strong> <strong>'.$student[0][3].'</strong> del curso <strong>'.$group_num.'</strong> respecto a todas las actividades de la materia <strong>'.$subject.'</strong>, instruida por <strong>'.$instructor[0][0].' '.$instructor[0][1].'</strong>.</p>
    <br>
  ';

  $table = '
    <style>
      th {
        display: block;
        background-color: #0066ff ;
        font-size: 16px;
        color: #fff;
      }
      td {
        font-size: 14px;
      }
      .highlight{
        background-color: #FF3D3D;
      }
    </style>
    <table border="1" style="text-align: center;padding: 5px 10px;">
      <thead>
        <tr>
          <th><strong>Actividad</strong></th>
          <th><strong>Fecha inicio</strong></th>
          <th><strong>Fecha límite</strong></th>
          <th><strong>Nota</strong></th>
          <th><strong>Nivelada</strong></th>
        </tr>
      <thead>
      <tbody>
  ';

  for($i = 0; $i < sizeof($activities); $i++){
    $evidence = "SELECT nota, nivelada FROM evidencia WHERE ID_Actividad = ".$activities[$i][0]." AND ID_Persona = $id_student";
    $evidence_result = mysqli_query($dbConnection, $evidence) or die(mysqli_error($dbConnection));
    $evidence = mysqli_fetch_all($evidence_result, MYSQLI_NUM);

    
    if(sizeof($evidence) > 0){
      $calification = $evidence[0][0] ? $evidence[0][0] : 'Sin calificación';
      $leveled = $evidence[0][1] ? 'Si' : 'No';
      $table .= '
        <tr>
          <td>'.$activities[$i][1].'</td>
          <td>'.$activities[$i][2].'</td>
          <td>'.$activities[$i][3].'</td>
          <td>'.$calification.'</td>
          <td>'.$leveled.'</td>
        </tr>
      ';
    } else {
      $table .= '
        <tr>
          <td>'.$activities[$i][1].'</td>
          <td>'.$activities[$i][2].'</td>
          <td>'.$activities[$i][3].'</td>
          <td colspan="2" class="highlight">SIN ENTREGA</td>
        </tr>
      ';
    }
  }

  $table .= '</tbody></table>';


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
  $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 1, 0, true, '', true);

  // ---------------------------------------------------------

  // close and output PDF document
  $pdf->Output('NotasEstudiante'.$student[0][1].'.pdf', 'I');
?>
