<?php

App::import('Vendor', 'pdfparte');
// create new PDF document
$pdf = new PDFPARTE(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Talleres Dafer');
$pdf->SetTitle('Parte');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(5, 5, 5, true);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(FALSE, 10);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------
// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

$html = '';

$html .= '
    <style>
        .cabecera, .cabecera td {
            border: 1px solid #000000;
            font-size: 9pt;
            font-weight: bold;
        }
    </style>
';

$html .= '
  <table class="cabecera">
    <tr>
        <td style="width: 33%; font-size:11pt; font-weight: bold;" colspan="2">PARTE TRABAJO <img src="./img/dafer.jpg"/></td>
        <td style="width: 66%;">CLIENTE: ' . $tarea['Ordene']['Cliente']['nombre'] . '</td>
    </tr>
    <tr>
        <td>NÚMERO PARTE</td>
        <td>FECHA</td>
        <td>CENTRO DE TRABAJO: ' . $tarea['Ordene']['Centrostrabajo']['centrotrabajo'] . '</td>
    </tr>
    <tr>
        <td></td>
        <td>' . $this->Time->format('d-m-Y', $tarea['Ordene']['fecha']) . '</td>
        <td>MAQUINA: ' . $tarea['Ordene']['Maquina']['nombre'] . '  Nº SERIE: ' . $tarea['Ordene']['Maquina']['serie_maquina'] . '  HORAS: ' . $tarea['Ordene']['horas_maquina']. '</td>
    </tr>
    <tr>
        <td>Nº ORDEN:</td>
        <td>' . $tarea['Ordene']['numero'] . '</td>
        <td>Nº SERIE MOTOR: ' . $tarea['Ordene']['Maquina']['serie_motor'] . '  Nº SERIE TRANSMISIÓN: ' . $tarea['Ordene']['Maquina']['serie_transmision'] . '</td>
    </tr>
    <tr>
        <td colspan="2"  style="width: 66%;">OPERARIO 1: </td>
        <td style="width: 33%;">ENTREGA MATERIAL:</td>
    </tr>
    <tr>
        <td colspan="2"  style="width: 66%;">OPERARIO 2: </td>
        <td style="width: 33%;"> </td>
    </tr>
    <tr>
        <td colspan="3" style="height: 30px;">TAREA: ' . $tarea['Tarea']['descripcion'] . '</td>
    </tr>
    <tr>
        <td colspan="3" style="height: 50px;">INSTRUCIONES:</td>
    </tr>
  </table>
';

$pdf->writeHTML($html);

$html = '
    <style>
        .material {
            font-size: 0.93em;
        }
    
    </style>
    <table class="material" style="border-bottom: 1px solid #000000" >
        <tr>
            <th style="border-bottom: 1px solid #000000; width: 19%;">REFERENCIA</th>
            <th style="border-bottom: 1px solid #000000; width: 53%;">NOMBRE</th>
            <th style="border-bottom: 1px solid #000000; width: 10%;">LOCALIZ</th>
            <th style="border-bottom: 1px solid #000000; width: 8%;">CANT</th>
            <th style="border-bottom: 1px solid #000000; width: 5%;">SI</th>
            <th style="border-bottom: 1px solid #000000; width: 5%;">NO</th>
        </tr>
';
$i = 0;
if (!empty($articulos_tareas))
    foreach ($articulos_tareas as $articulo) {
        if ($i == 18) {
            break;
        }
        $i++;
        $html .= '
        <tr>
            <td>' . $articulo['Articulo']['ref'] . '</td>
            <td>' . $articulo['Articulo']['nombre'] . '</td>
            <td>' . $articulo['Articulo']['localizacion'] . '</td>
            <td>' . $articulo['ArticulosTarea']['cantidadreal'] . '</td>
            <td><b>____</b></td>
            <td><b>____</b></td>
        </tr>
        ';
    }
$html .= '</table>';



$pdf->writeHTMLCell(198, 126, 5, '', $html, 1);


$image_file = './img/partetaller.jpg';
$pdf->Image($image_file, 4, 198, 200);

$pdf->lastPage();

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('parte.pdf', 'I');
?>
