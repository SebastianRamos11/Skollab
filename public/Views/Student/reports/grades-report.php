<?php
  include_once "../../../Models/connection.php"; session_start();
  require_once('../../tcpdf/tcpdf.php');

  // Primary data
  $id_user = $_SESSION['id'];
  $group = $_GET['group'];
  $group_num = $_GET['num'];

  $subjects = "SELECT ID_Materia, ID_Instructor FROM curso WHERE ID_Ficha = $group";
	$subjects_result = mysqli_query($dbConnection, $subjects) or die(mysqli_error($dbConnection));
	$subjects = mysqli_fetch_all($subjects_result, MYSQLI_NUM);

  $student = "SELECT nombres, apellidos, ID_Tipo_Documento, num_documento, correo_electronico, telefono FROM persona WHERE ID_Persona = $id_user";
  $student_result = mysqli_query($dbConnection, $student) or die(mysqli_error($dbConnection));
	$student = mysqli_fetch_all($student_result, MYSQLI_NUM);

  // Get document type
  $type_doc = "SELECT tipo FROM tipo_documento WHERE ID_Tipo_Documento =".$student[0][2];
  $type_doc_result = mysqli_query($dbConnection, $type_doc) or die(mysqli_error($dbConnection));
  $type_doc = mysqli_fetch_all($type_doc_result, MYSQLI_NUM)[0][0];

  // create new PDF document
  $pdf = new TCPDF();
  $date = date("d/m/Y");

  // Introduction data
  $introduction = '
    <h1>Boletín de notas</h1>
    <i>Generado el '.$date.'</i> 
    <p>En el presente documento se presenta el reporte de notas del estudiante <strong>'.$student[0][0].' '.$student[0][1].'</strong> con <strong>'.$type_doc.'</strong> <strong>'.$student[0][3].'</strong>, correo electrónico <strong>'.$student[0][4].'</strong> y número de teléfono <strong>'.$student[0][5].'</strong>  el cual se encuentra en formación en el curso <strong>'.$group_num.'</strong>.</p>
  ';

  $html = '<div>';
    for($i = 0; $i < sizeof($subjects); $i++){
      $id_subject = $subjects[$i][0];
      $id_instructor = $subjects[$i][1];

			$subject = "SELECT nombre FROM materia WHERE ID_Materia = $id_subject";
			$subject_result= mysqli_query($dbConnection, $subject) or die(mysqli_error($dbConnection));
			$subject = mysqli_fetch_all($subject_result, MYSQLI_NUM);

      $activities = "SELECT ID_Actividad, asunto, fecha FROM `actividad` WHERE ID_Ficha = $group AND ID_Persona = $id_instructor";
      $activities_result = mysqli_query($dbConnection, $activities) or die(mysqli_error($dbConnection));
      $activities = mysqli_fetch_all($activities_result, MYSQLI_NUM);

      $html.= '<section>';
        $html.= '<h2>'.$subject[0][0].'<h2>';
        $html.= '
          <style>
            th {
              display: block;
              background-color: #0066ff ;
              font-size: 14px;
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
                <th><strong>Fecha de inicio</strong></th>
                <th><strong>Fecha de entrega</strong></th>
                <th><strong>Nota</strong></th>
                <th><strong>Nivelada</strong></th>
              </tr>
            <thead>';
            $html.= '<tbody>';
              if(sizeof($activities) > 0){
                for($j = 0; $j < sizeof($activities); $j++){
                  $id_activity = $activities[$j][0];
                  $activity_title = $activities[$j][1];

                  // GET EVIDENCES
                  $evidence = "SELECT fecha, nota, nivelada FROM `evidencia` WHERE ID_Persona = $id_user AND ID_Actividad = $id_activity";
                  $evidence_result= mysqli_query($dbConnection, $evidence) or die(mysqli_error($dbConnection));
                  $evidence = mysqli_fetch_all($evidence_result, MYSQLI_NUM);
      
                  if(sizeof($evidence) > 0){
                    $calification = $evidence[0][1] ? $evidence[0][1] : 'Sin calificación';
                    $leveled = $evidence[0][2] ? 'Si' : 'No';

                    $html.='<tr>
                      <td>'.$activities[$j][1].'</td>
                      <td>'.$activities[$j][2].'</td>
                      <td>'.$evidence[0][0].'</td>
                      <td>'.$calification.'</td>
                      <td>'.$leveled.'</td>
                    </tr>';
                  } else{
                    $html.='<tr>
                      <td>'.$activities[$j][1].'</td>
                      <td>'.$activities[$j][2].'</td>
                      <td colspan="3" class="highlight">SIN ENTREGA</td>
                    </tr>';
                  }
                }
              } else{
                $html.='<tr><td colspan="5">No se han asignado actividades a esta materia.</td><tr>';
              }
            $html.= '</tbody>';
          $html.='</table><br>';
      $html.= '</section><hr>';

    }
  $html.='</div>';

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Skollab');
  $pdf->SetTitle('Boletín de notas');
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
  // $header = array('ID', 'Nombres', 'Apellidos', 'Correo electrónico');

  // Load html content
  $pdf->writeHTMLCell(0, 0, '', '', $introduction, 0, 1, 0, true, '', true);
  $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

  // ---------------------------------------------------------

  // close and output PDF document
  $pdf->Output('Boletin.pdf', 'I');
?>