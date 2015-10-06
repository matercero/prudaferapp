<?php

App::import('Vendor', 'pdfa4');
// create new PDF document
$pdf = new PDFA4(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Talleres Dafer');
$pdf->SetTitle('Orden');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(5, 28, PDF_MARGIN_RIGHT, true);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 50);

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
                width: 35%;
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
        <th colspan="3" >ORDEN</th>
    </tr>
    <tr>
         <td>NÚMERO</td>
         <td>FECHA</td>
         <td>NÚMERO AVISO</td>
    </tr>
    <tr>
       <td>' . zerofill($ordene['Ordene']['numero']) . '</td>
       <td>' . $this->Time->format('d-m-Y', $ordene['Ordene']['fecha']) . '</td>
       <td>' . $ordene['Avisostallere']['numero'] . '</td>
    </tr>
    <tr>
        <td class="left" colspan="3"><span>CENTRO DE TRABAJO:</span> ' . $ordene['Centrostrabajo']['centrotrabajo'] . '</td>
    </tr>
    <tr>
        <td class="left" colspan="3"><span>MÁQUINA:</span> ' . $ordene['Maquina']['nombre'] . '</td>
    </tr>
    <tr>
        <td class="left" colspan="2"><span>SERIE:</span> ' . $ordene['Maquina']['serie_maquina'] . '</td>
        <td class="left" ><span>HORAS:</span> ' . $ordene['Ordene']['horas'] . '</td>
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
        <tr><td class="nombre_cliente">CLIENTE: ' . $ordene['Cliente']['nombre'] . '</td></tr>
        <tr><td class="cif">CIF: ' . $ordene['Cliente']['cif'] . '</td></tr>
        <tr><td>' . $ordene['Cliente']['direccion_postal'] . '</td></tr>
        <tr><td>' . $ordene['Cliente']['codigopostal'] . '  ' . $ordene['Cliente']['poblacionpostal'] . '</td></tr>
        <tr><td>' . $ordene['Cliente']['provinciapostal'] . '</td></tr>
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
$total = 0;

$lineas = '';
$html = '';
$i = 1;
foreach ($ordene['Tarea'] as $tarea) {
    if ($tarea['tipo'] == 'centro') {
        $html .= '
        <style>
            table.manodeobras {
                border: 1px solid black;
                font-size: 7pt;
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
        $html .= '<h5 style="text-align: left;border-bottom: 1px solid black;background-color: #e8e8e8;">TAREA ' . $tarea['numero'] . ': ' . $tarea['descripcion'] . '</h5>';
        $html .= '<h5 style="text-align: left;">&nbsp; &nbsp; &nbsp; MANO DE OBRA, DESPLAZAMIENTOS Y OTROS SERVICIOS:</h5>';
        $html .= '<table class="manodeobras">';
        $html .= '<tr>';
        $html .= '<th style="text-align:  left;width: 6%;">Nº PARTE</th>';
        $html .= '<th style="text-align:  left;width: 9%;">FECHA</th>';
        $html .= '<th style="text-align:  left;width: 25%;">DESCRIPCIÓN</th>';
        $html .= '<th style="text-align:  right;width: 6%;">H.D</th>';
        $html .= '<th style="text-align:  right;width: 6%;">KM</th>';
        $html .= '<th style="text-align:  right;width: 9%;">IMPORTE DESPLAZ.</th>';
        $html .= '<th style="text-align:  right;width: 6%;">DIETA</th>';
        $html .= '<th style="text-align:  right;width: 6%;">H.TRA</th>';
        $html .= '<th style="text-align:  right;width: 10%;">PRECIO H.TRAB</th>';
        $html .= '<th style="text-align:  right;width: 9%;">OTROS SERVICIOS</th>';
        $html .= '<th style="text-align:  right;width: 9%;">TOTAL</th>';
        $html .= '</tr>';
        foreach ($tarea['Parte'] as $partecentro) {
            $html .= '<tr>';
            $html .= '<td style="text-align:  left;widtd: 6%;">' . $partecentro['numero'] . ' </td>';
            $html .= '<td style="text-align:  left;widtd: 8%;">' . $this->Time->format('d-m-Y', $partecentro['fecha']) . '</td>';
            $html .= '<td style="text-align:  left;widtd: 25%;">' . $partecentro['operacion'] . '</td>';
            $html .= '<td style="text-align:  right;widtd: 5%;">' . number_to_comma($partecentro['horasdesplazamientoimputables_ida'] + $partecentro['horasdesplazamientoimputables_vuelta']) . '</td>';
            $html .= '<td style="text-align:  right;widtd: 5%;">' . number_to_comma($partecentro['kilometrajeimputable_ida'] + $partecentro['kilometrajeimputable_vuelta']) . '</td>';
            $kilometrajeprecio = ($partecentro['kilometrajeimputable_ida'] + $partecentro['kilometrajeimputable_vuelta']) * $ordene['Centrostrabajo']['preciokm'];
            $horasdesplazamientoprecio = ($partecentro['horasdesplazamientoimputables_ida'] + $partecentro['horasdesplazamientoimputables_vuelta']) * $ordene['Centrostrabajo']['preciohoradesplazamiento'];
            $totaldesplazamiento = $horasdesplazamientoprecio + $kilometrajeprecio + $partecentro['preciodesplazamiento'];

            $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($totaldepslazamiento) . ' €</td>';
            $html .= '<td style="text-align:  right;widtd: 6%;">' . number_to_comma($partecentro['dietasimputables']) . ' €</td>';
            $html .= '<td style="text-align:  right;widtd: 6%;">' . number_to_comma($partecentro['horasimputables']) . ' h</td>';
            $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($partecentro['preciohoraencentro']) . ' €</td>';
            $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($partecentro['otrosservicios_imputable']) . ' €</td>';
            $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($totaldesplazamiento + $partecentro['dietasimputables'] + $partecentro['otrosservicios_imputable'] + ($partecentro['horasimputables'] * $partecentro['preciohoraencentro'])) . ' €</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '<h5 style="text-align: right;">SUBTOTAL MANO DE OBRA, DESPLAZAMIENTO Y OTROS SERVICIOS: ' .number_format($tarea['totaldesplazamientoimputado'] + $tarea['totalkilometrajeimputable'] + $tarea['total_horastrabajoprecio_imputable'] + $tarea['totaldietasimputables'] + $tarea['totalotroserviciosimputables'] ). ' €</h5>';
        $html .= '<h5 style="text-align: left;">&nbsp; &nbsp; &nbsp; MATERIALES:</h5>';
        $html .= '<table class="materiales">';
        $html .= '<tr>';
        if ($albaranesclientesreparacione['Cliente']['imprimir_con_ref'] == 1) {
            $html .= '<th style="text-align:  left;width: 15%;">REFERENCIA</th>';
            $html .= '<th style="text-align:  left;width: 40%;">DESCRIPCIÓN</th>';
        } else {
            $html .= '<th style="text-align:  left;width: 55%;">DESCRIPCIÓN</th>';
        }
        $html .= '<th style="text-align:  right;width: 10%;">CANTIDAD</th>';
        $html .= '<th style="text-align:  right;width: 10%;">PRECIO</th>';
        $html .= '<th style="text-align:  right;width: 10%;">DTO.</th>';
        $html .= '<th style="text-align:  right;width: 15%;">IMPORTE</th>';
        $html .= '</tr>';
        foreach ($tarea['ArticulosTarea'] as $materiale) {
            $html .= '<tr>';
            if ($albaranesclientesreparacione['Cliente']['imprimir_con_ref'] == 1) {
                $html .= '<td style="text-align:  left;width: 15%;">' . $materiale['Articulo']['ref'] . '</td>';
                $html .= '<td style="text-align:  left;width: 40%">' . $materiale['Articulo']['nombre'] . '</td>';
            } else {
                $html .= '<td style="text-align:  left;width: 55%">' . $materiale['Articulo']['nombre'] . '</td>';
            }
            $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['cantidad']) . '</td>';
            $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['precio_unidad']) . ' €</td>';
            $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['descuento']) . ' %</td>';
            $html .= '<td style="text-align:  right;width: 15%;">' . number_to_comma(($materiale['precio_unidad'] * $materiale['cantidad']) * (1 - ($materiale['descuento'] / 100))) . ' €</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '<h5 style="text-align: right;">SUBTOTAL MATERIALES: ' . number_to_comma($tarea['total_materiales_imputables']) . ' €<h5>';
        $i++;
    }else {
        $html .= '
        <style>
            table.manodeobras {
                border: 1px solid black;
                font-size: 7pt;
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
        $html .= '<h5 style="text-align: left;border-bottom: 1px solid black;background-color: #e8e8e8;">TAREA ' . $tarea['numero'] . ': ' . $tarea['descripcion'] . '</h5>';
        $html .= '<h5 style="text-align: left;">&nbsp; &nbsp; &nbsp; MANO DE OBRA, DESPLAZAMIENTOS Y OTROS SERVICIOS:</h5>';
        $html .= '<table class="manodeobras">';
        $html .= '<tr>';
        $html .= '<th style="text-align:  left;width: 10%;">FECHA</th>';
        $html .= '<th style="text-align:  left;width: 40%;">DESCRIPCIÓN</th>';
        $html .= '<th style="text-align:  right;width: 10%;">H.TRA</th>';
        $html .= '<th style="text-align:  right;width: 10%;">PRECIO H.TRAB</th>';
        $html .= '<th style="text-align:  right;width: 15%;">OTROS SERVICIOS</th>';
        $html .= '<th style="text-align:  right;width: 15%;">TOTAL</th>';
        $html .= '</tr>';
        foreach ($tarea['Partestallere'] as $partestallere) {
            $html .= '<tr>';
            $html .= '<td style="text-align:  left;widtd: 10%;">' . $this->Time->format('d-m-Y', $partestallere['fecha']) . '</td>';
            $html .= '<td style="text-align:  left;widtd: 40%;">' . $partestallere['operacion'] . '</td>';
            $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($partestallere['horasimputables']) . '</td>';
            $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($partestallere['preciohoraentraller']) . '</td>';
            $html .= '<td style="text-align:  right;widtd: 15%;">' . number_to_comma($partestallere['otrosservicios_imputable']) . ' €</td>';
            $html .= '<td style="text-align:  right;widtd: 15%;">' . number_to_comma(($partestallere['horasimputables']*$partestallere['preciohoraentraller'])*(1-($partestallere['descuento_manodeobra']/100))+$partestallere['otrosservicios_imputable']) . ' €</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '<h5 style="text-align: right;">SUBTOTAL MANO DE OBRA, DESPLAZAMIENTO Y OTROS SERVICIOS: ' .number_format($tarea['totaldesplazamientoimputado'] + $tarea['totalkilometrajeimputable'] + $tarea['total_horastrabajoprecio_imputable'] + $tarea['totaldietasimputables'] + $tarea['totalotroserviciosimputables'] ). ' €</h5>';
        $html .= '<h5 style="text-align: left;">&nbsp; &nbsp; &nbsp; MATERIALES:</h5>';
        $html .= '<table class="materiales">';
        $html .= '<tr>';
        if ($albaranesclientesreparacione['Cliente']['imprimir_con_ref'] == 1) {
            $html .= '<th style="text-align:  left;width: 15%;">REFERENCIA</th>';
            $html .= '<th style="text-align:  left;width: 40%;">DESCRIPCIÓN</th>';
        } else {
            $html .= '<th style="text-align:  left;width: 55%;">DESCRIPCIÓN</th>';
        }
        $html .= '<th style="text-align:  right;width: 10%;">CANTIDAD</th>';
        $html .= '<th style="text-align:  right;width: 10%;">PRECIO</th>';
        $html .= '<th style="text-align:  right;width: 10%;">DTO.</th>';
        $html .= '<th style="text-align:  right;width: 15%;">IMPORTE</th>';
        $html .= '</tr>';
        foreach ($tarea['ArticulosTarea'] as $materiale) {
            $html .= '<tr>';
            if ($albaranesclientesreparacione['Cliente']['imprimir_con_ref'] == 1) {
                $html .= '<td style="text-align:  left;width: 15%;">' . $materiale['Articulo']['ref'] . '</td>';
                $html .= '<td style="text-align:  left;width: 40%">' . $materiale['Articulo']['nombre'] . '</td>';
            } else {
                $html .= '<td style="text-align:  left;width: 55%">' . $materiale['Articulo']['nombre'] . '</td>';
            }
            $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['cantidad']) . '</td>';
            $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['precio_unidad']) . ' €</td>';
            $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['descuento']) . ' %</td>';
            $html .= '<td style="text-align:  right;width: 15%;">' . number_to_comma(($materiale['precio_unidad'] * $materiale['cantidad']) * (1 - ($materiale['descuento'] / 100))) . ' €</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '<h5 style="text-align: right;">SUBTOTAL MATERIALES: ' . number_to_comma($tarea['total_materiales_imputables']) . ' €<h5>';
        $i++;
    }
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
            font-size: 0.9em;
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
                        <td>Total de Obra, Desplazamientos y Otros Servicios:</td>
                        <td style="text-align: right;"> ' . number_to_comma($totalmanoobra_servicios) . ' € </td>
                    </tr>
                    <tr>
                        <td>Total Materiales: </td>
                        <td style="text-align: right;">' . number_to_comma($totalrepuestos) . ' € </td>
                    </tr>
                </table>
                <p style="font-size: 0.7em;">'.$ordene['Mensajesordene']['mensaje'].'<br/>FIRMA DEL CLIENTE: </p>
                <table id="totales" cellspacing="20" >
                    <tr>
                        <td class="nombre">BASE IMPONIBLE</td>
                        <td class="precio">' . number_to_comma($baseimponible) . ' €</td>
                    </tr>
                </table>';
$pdf->SetY(245, true, true);
$pdf->SetAutoPageBreak(FALSE, 10);
$pdf->writeHTML($html, 0, 1, 0, true, 'J', true);
$pdf->SetY(-5);
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell('', '', ' ( Inscrita en el Registro Mercantil de Sevilla, Tomo 4225, Libro 0, Sección 8ª, Folio 1, Hoja SE 63.758, Inscripción 1ª, C.I.F.B-91/475319 )' . 'Pag. ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');


// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('presupuestoproveedor.pdf', 'I');
?>