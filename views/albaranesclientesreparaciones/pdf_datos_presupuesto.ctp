<?php

App::import('Vendor', 'pdfa4');
// create new PDF document
$pdf = new PDFA4(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Talleres Dafer');
$pdf->SetTitle('Albaran de Venta');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(15, 28, PDF_MARGIN_RIGHT, true);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------
// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

/*
 * SUBCABECERA
 */

/*
 * Area de Tipo de Documento
 */

$tbl = '
<style>
            table.tipodoc {
                font-size: 0.7em;
                width: 38%;
                border: 1px solid black;
            }

            th {
                font-weight: bolder;
                text-align: center;
                border: 1px solid black;
            }
            td {   
                text-align: center;
                border: 0.1px solid #bbbbbb;
            }
            td.left{
                text-align: left;
            }
            td.left span {
                font-weight: bolder;
            }
            </style>
<table class="tipodoc">
    <tr>
        <th colspan="4" >ALBARÁN</th>
    </tr>
    <tr>
         <td>SERIE</td>
         <td>NUMERO</td>
         <td>FECHA</td>
         <td>Nº PEDIDO</td>
    </tr>
    <tr>
       <td>' . $albaranesclientesreparacione['Albaranesclientesreparacione']['serie'] . '</td>
       <td>' . zerofill($albaranesclientesreparacione['Albaranesclientesreparacione']['numero']) . '</td>
       <td>' . $this->Time->format('d-m-Y', $albaranesclientesreparacione['Albaranesclientesreparacione']['fecha']) . '</td>
       <td>' . $albaranesclientesreparacione['Albaranesclientesreparacione']['numero_aceptacion_aportado']  . '</td>
    </tr>
    <tr>
        <td class="left" colspan="4"><span>CENTRO DE TRABAJO:</span> ' . $presupuestoscliente['Centrostrabajo']['centrotrabajo'] . '</td>
    </tr>
    <tr>
        <td class="left" colspan="4"><span>MÁQUINA:</span> ' . $presupuestoscliente['Maquina']['nombre'] . '</td>
    </tr>
    <tr>
        <td class="left" colspan="2"><span>SERIE:</span> ' . $presupuestoscliente['Maquina']['serie_maquina'] . '</td>
        <td class="left" colspan="2"><span>HORAS:</span> ' . $presupuestoscliente['Maquina']['horas'] . '</td>
    </tr>
</table>
';
$y_de_subcabecera = $pdf->GetY();
$pdf->writeHTMLCell('', '', '', $y_de_subcabecera + 10, $tbl, 0, 1, 0, true, 'J', true);
$x = $pdf->GetX();

/*
 * Area de Cliente
 */

$tbl = '
    <style>
        table.cliente {
            font-size: 0.7em;
            text-align: left;
            width: 400px;
            background-color: #ddd8c2;
        }
        .cif, .nombre_cliente {
            font-weight: bolder;
        }
    </style>
   
    <table class="cliente">
        <tr><td class="nombre_cliente">CLIENTE: ' . $presupuestoscliente['Cliente']['nombre'] . '</td></tr>
        <tr><td class="cif">CIF: ' . $presupuestoscliente['Cliente']['cif'] . '</td></tr>
        <tr><td>' . $presupuestoscliente['Cliente']['direccion_postal'] . '</td></tr>
        <tr><td>' . $presupuestoscliente['Cliente']['codigopostal'] . '  ' . $presupuestoscliente['Cliente']['poblacionpostal'] . '</td></tr>
        <tr><td>' . $presupuestoscliente['Cliente']['provinciapostal'] . '</td></tr>
    </table>
';
$pdf->writeHTMLCell('', '', $x + 70, $y_de_subcabecera + 10, $tbl, 0, 1, 0, true, 'J', true);

/*
 * Fin Area de Cliente
 */


/*
 * FIN DE SUBCABECERA 
 */


/*
 * Area de Articulos
 */

//Un poco de margen abajo para separar
$pdf->SetY($pdf->GetY() + 10);

$html = '<p style="font-size: 0.8em">'.$presupuestoscliente['Mensajesinformativo']['mensaje'].'</p>';
$html .= '<p style="font-size: 0.8em">Observaciones: '.$albaranesclientesreparacione['Albaranesclientesreparacione']['observaciones'].'</p>';

$pdf->writeHTML($html, true, false, false, false, '');


$pdf->SetY($pdf->GetY() + 10);
$total = 0;
$lineas = '';
$html = '';
$i = 1;
foreach ($presupuestoscliente['Tareaspresupuestocliente'] as $tareaspresupuestocliente) {
    $html .= '
        <style>
            table.manodeobras {
                border: 1px solid black;
                font-size: 8pt;
            }
            th {
                font-weight: bold;
                border: 1px solid black;
            }
            td {
                font-weight: normal;
                border-right: 1px solid black;
            }
            table.materiales {
                border: 1px solid black;
                font-size: 8pt;
            }
        </style>';
    $html .= '<h5 style="text-align: left;border-bottom: 1px solid black;background-color: #e8e8e8;">TAREA ' . $i . ': ' . $tareaspresupuestocliente['asunto'] . '</h5>';
    $html .= '<h5 style="text-align: left;">&nbsp; &nbsp; &nbsp; MANO DE OBRA, DESPLAZAMIENTOS Y OTROS SERVICIOS:</h5>';
    $html .= '<table class="manodeobras">';
    $html .= '<tr>';
    $html .= '<th style="text-align:  left;width: 85%;">DESCRIPCIÓN</th>';
    $html .= '<th style="text-align:  right;width: 15%;">IMPORTE</th>';
    $html .= '</tr>';
    foreach ($tareaspresupuestocliente['Manodeobra'] as $manodeobra) {
        $html .= '<tr>';
        $html .= '<td style="text-align:  left;width: 85%;">' . $manodeobra['descripcion'] . '</td>';
        $html .= '<td style="text-align: right;width: 15%;">' . number_to_comma($manodeobra['importe']) . ' €</td>';
        $html .= '</tr>';
    }
    if (!empty($tareaspresupuestocliente['TareaspresupuestoclientesOtrosservicio'])) {
        $html .= '<tr>';
        $html .= '<td style="text-align:  left;">OTROS SERVICIOS - ' . $tareaspresupuestocliente['TareaspresupuestoclientesOtrosservicio']['varios_descripcion'] . '</td>';
        $html .= '<td style="text-align: right;">' . number_to_comma($tareaspresupuestocliente['TareaspresupuestoclientesOtrosservicio']['total']) . ' €</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    $html .= '<h5 style="text-align: right;">SUBTOTAL MANO DE OBRA, DESPLAZAMIENTO Y OTROS SERVICIOS: ' . number_to_comma($tareaspresupuestocliente['mano_de_obra'] + $tareaspresupuestocliente['servicios']) . ' €</h5>';
    $html .= '<h5 style="text-align: left;">&nbsp; &nbsp; &nbsp; MATERIALES:</h5>';
    $html .= '<table class="materiales">';
    $html .= '<tr>';
    if ($presupuestoscliente['Cliente']['imprimir_con_ref'] == 1) {
        $html .= '<th style="text-align:  left;width: 15%;">REFERENCIA</th>';
        $html .= '<th style="text-align:  left;width: 38%;">DESCRIPCIÓN</th>';
    } else {
        $html .= '<th style="text-align:  left;width: 53%;">DESCRIPCIÓN</th>';
    }

    $hay_descuento = false;
    foreach ($tareaspresupuestocliente['Materiale'] as $materiale) {
        if (!empty($materiale['descuento']))
            $hay_descuento = true;
    }

    $html .= '<th style="text-align:  right;width: 12%;">CANTIDAD</th>';
    $html .= '<th style="text-align:  right;width: 10%;">PRECIO</th>';
    if ($hay_descuento) {
        $html .= '<th style="text-align:  right;width: 10%;">DTO.</th>';
        $html .= '<th style="text-align:  right;width: 15%;">IMPORTE</th>';
    } else {
        $html .= '<th style="text-align:  right;width: 25%;">IMPORTE</th>';
    }
    $html .= '</tr>';


    foreach ($tareaspresupuestocliente['Materiale'] as $materiale) {
        $html .= '<tr>';
        if ($presupuestoscliente['Cliente']['imprimir_con_ref'] == 1) {
            $html .= '<td style="text-align:  left;width: 15%;">' . $materiale['Articulo']['ref'] . '</td>';
            $html .= '<td style="text-align:  left;width: 38%">' . $materiale['Articulo']['nombre'] . '</td>';
        } else {
            $html .= '<td style="text-align:  left;width: 53%">' . $materiale['Articulo']['nombre'] . '</td>';
        }
        $html .= '<td style="text-align:  right;width: 12%;">' . number_to_comma($materiale['cantidad']) . '</td>';
        $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['precio_unidad']) . ' €</td>';
        if ($hay_descuento) {
            $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['descuento']) . ' %</td>';
            $html .= '<td style="text-align:  right;width: 15%;">' . number_to_comma($materiale['importe']) . ' €</td>';
        } else {
            $html .= '<td style="text-align:  right;width: 25%;">' . number_to_comma($materiale['importe']) . ' €</td>';
        }

        $html .= '</tr>';
    }
    $html .= '</table>';
    $html .= '<h5 style="text-align: right;">SUBTOTAL MATERIALES: ' . number_to_comma($tareaspresupuestocliente['materiales']) . ' €<h5>';
    $i++;
}


// output the HTML content
//$pdf->Rect($pdf->GetX(), $pdf->GetY(), 198, 200,'S');
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->setY($pdf->getY() - 8);
/*
 * Area de totales
 */

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// reset pointer to the last page
$pdf->lastPage();
$pdf->setPrintFooter(false);
$html = '    
                <style>
        table#totales tr td.nombre {
            line-height: 2em;
            text-align: center;
            font-size: 0.7em;
            font-weight: bolder;
            background-color: #ddd8c2;
            vertical-align: middle;
        }
        table#totales tr td.precio {
            border: 1px solid #ddd8c2;
            line-height: 2em;
            text-align: center;
            font-size: 0.7em;
        }
    </style>
                <table style="border: 1px solid black; font-size: 0.9em;">
                    <tr>
                        <td>Total Mano de Obra y Otros Servicios:</td>
                        <td style="text-align: right;"> ' . number_to_comma($totalmanoobrayservicios) . ' € </td>
                    </tr>
                    <tr>
                        <td>Total Materiales: </td>
                        <td style="text-align: right;">' . number_to_comma($totalrepuestos) . ' € </td>
                    </tr>
                </table>
                <table id="totales" cellspacing="20" >
                    <tr>
                        <td class="nombre">BASE IMPONIBLE</td>
                        <td class="precio">' . number_to_comma($presupuestoscliente['Presupuestoscliente']['precio']) . ' €</td>
                        <td class="nombre">IVA</td>
                        <td class="precio">' . number_to_comma($presupuestoscliente['Presupuestoscliente']['impuestos']) . ' €</td>
                        <td class="nombre">TOTAL</td>
                        <td class="precio">' . number_to_comma($presupuestoscliente['Presupuestoscliente']['impuestos'] + $presupuestoscliente['Presupuestoscliente']['precio']) . ' €</td>
                    </tr>
                </table>';
$pdf->SetY(265, true, true);
$pdf->SetAutoPageBreak(FALSE, 10);
$pdf->writeHTML($html, 0, 1, 0, true, 'J', true);
$pdf->SetY(-5);
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell('', '', ' ( Inscrita en el Registro Mercantil de Sevilla, Tomo 4225, Libro 0, Sección 8ª, Folio 1, Hoja SE 63.758, Inscripción 1ª, C.I.F.B-91/475319 )' . 'Pag. ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');


// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('presupuestoproveedor.pdf', 'I');
?>
