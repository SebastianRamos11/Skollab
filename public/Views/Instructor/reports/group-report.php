<?php
  include_once "../../../Models/connection.php"; session_start();
  require_once('../../../../src/tcpdf/tcpdf.php');

  // create new PDF document
  $pdf = new TCPDF();

  $date = date("d/m/Y");
  $group = $_GET['group'];
  $group_num = $_GET['num'];


  // Introduction data
  $introduction = '
    <h1>Lista de estudiantes</h1>
    <i>Generado el '.$date.'</i> 
    <p>El siguiente listado contiene la lista de estudiantes del curso <strong>'.$group_num.'</strong>:</p>
    <br>
  ';


  // Table
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
    </style>
    <table border="1" style="text-align: center;padding: 5px 10px;">
      <tr>
        <th><strong>ID</strong></th>
        <th><strong>Nombres</strong></th>
        <th><strong>Apellidos</strong></th>
        <th><strong>Correo</strong></th>
        <th><strong>Teléfono</strong></th>
      </tr>
  ';

  // Get students data
  $students = "SELECT P.num_documento, P.nombres, P.apellidos, P.correo_electronico, P.telefono FROM persona P JOIN ambiente_virtual A ON P.ID_Persona = A.ID_Persona WHERE A.ID_Ficha = $group AND P.ID_Rol = 3";
  $students_result = mysqli_query($dbConnection, $students) or die(mysqli_error($dbConnection));
  $students = mysqli_fetch_all($students_result, MYSQLI_NUM);


  if(sizeof($students) > 0){
    for($i = 0; $i < sizeof($students); $i++){
      $table .= '
        <tr>
          <td>'.$students[$i][0].'</td>
          <td>'.$students[$i][1].'</td>
          <td>'.$students[$i][2].'</td>
          <td>'.$students[$i][3].'</td>
          <td>'.$students[$i][4].'</td>
        </tr>
      ';
    }
  }

  $table .= '</table>';

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Skollab');
  $pdf->SetTitle('Reporte de lista de estudiantes');
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
  $pdf->Output('ListaCurso'.$group_num.'.pdf', 'I');
?>
