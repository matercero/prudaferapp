<?php

App::import('Vendor', 'pdfa4');
// create new PDF document
$pdf = new PDFA4(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Talleres Dafer');
$pdf->SetTitle('Albaran de Reparación');
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
                font-size: 0.8em;
                width: 50%;
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
        <th colspan="4" style="font-size: 1.1em;" >ALBARÁN</th>
    </tr>
    <tr>
         <td style="width: 17%">SERIE</td>
         <td style="width: 20%">NUMERO</td>
         <td style="width: 23%">FECHA</td>
         <td style="width: 40%">Nº PEDIDO</td>
    </tr>
    <tr>
       <td>' . $albaranesclientesreparacione['Albaranesclientesreparacione']['serie'] . '</td>
       <td>' . zerofill($albaranesclientesreparacione['Albaranesclientesreparacione']['numero']) . '</td>
       <td>' . $this->Time->format('d-m-Y', $albaranesclientesreparacione['Albaranesclientesreparacione']['fecha']) . '</td>
       <td>' . $albaranesclientesreparacione['Albaranesclientesreparacione']['numero_aceptacion_aportado'] . '</td>
    </tr>
    <tr>
        <td class="left" colspan="4"><span>CENTRO DE TRABAJO:</span> ' . $albaranesclientesreparacione['Centrostrabajo']['centrotrabajo'] . '</td>
    </tr>
    <tr>
        <td class="left" colspan="4"><span>MÁQUINA:</span> ' . $albaranesclientesreparacione['Maquina']['nombre'] . '</td>
    </tr>
    <tr>
        <td class="left" colspan="2"><span>SERIE:</span> ' . $albaranesclientesreparacione['Maquina']['serie_maquina'] . '</td>
        <td class="left" colspan="2"><span>HORAS:</span> ' . $albaranesclientesreparacione['Albaranesclientesreparacione']['horas_maquina'] . '</td>
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
            font-size: 0.8em;
                width: 100%;
                border: 1px solid black;
            background-color: #ddd8c2;
        }
        .cif, .nombre_cliente {
            font-weight: bolder;
        }
    </style>
   
    <table class="cliente">
        <tr><td class="nombre_cliente">CLIENTE: ' . $albaranesclientesreparacione['Cliente']['nombre'] . '</td></tr>
        <tr><td class="cif">CIF: ' . $albaranesclientesreparacione['Cliente']['cif'] . '</td></tr>
        <tr><td>' . $albaranesclientesreparacione['Cliente']['direccion_fiscal'] . '</td></tr>
        <tr><td>' . $albaranesclientesreparacione['Cliente']['codigopostalfiscal'] . '  ' . $albaranesclientesreparacione['Cliente']['poblacionfiscal'] . '</td></tr>
        <tr><td>' . $albaranesclientesreparacione['Cliente']['provinciafiscal'] . '</td></tr>
    </table>
';
$pdf->writeHTMLCell('', '', $x + 95, $y_de_subcabecera + 10, $tbl, 0, 1, 0, true, 'J', true);

/*
 * Fin Area de Cliente
 */


/*
 * FIN DE SUBCABECERA 
 */

/*
 * OBSERVACIONES
 */
$pdf->writeHTMLCell('', '',  $x, $y_de_subcabecera + 33, 'Observaciones: '.$albaranesclientesreparacione['Albaranesclientesreparacione']['observaciones'].'', 0, 1, 0, true, 'J', true);


/*
 * FIN DE OBSERVACIONES
 */

/*
 * Area de Articulos
 */

//Un poco de margen abajo para separar
$pdf->SetY($pdf->GetY() + 8);
$total = 0;

$lineas = '';
$html = '';
$i = 1;
foreach ($albaranesclientesreparacione['TareasAlbaranesclientesreparacione'] as $TareasAlbaranesclientesreparacione) {
    if ($TareasAlbaranesclientesreparacione['tipo'] == 'centro') {
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
                font-size: 7pt;
            }
        </style>';
        $hay_hd = false;
        $hay_km = false;
        foreach ($TareasAlbaranesclientesreparacione['TareasAlbaranesclientesreparacionesParte'] as $partecentro) {
            $hd = $partecentro['horasdesplazamientoimputables_ida'] + $partecentro['horasdesplazamientoimputables_vuelta'];
            if (!empty($hd))
                $hay_hd = true;
            $km = $partecentro['kilometrajeimputable_ida'] + $partecentro['kilometrajeimputable_vuelta'];
            if (!empty($km))
                $hay_km = true;
        }
        $html .= '<h5 style="text-align: left;border-bottom: 1px solid black;background-color: #e8e8e8;">TAREA ' . $TareasAlbaranesclientesreparacione['numero'] . ': ' . $TareasAlbaranesclientesreparacione['descripcion'] . '</h5>';
        $html .= '<h5 style="text-align: left;">&nbsp; &nbsp; &nbsp; MANO DE OBRA, DESPLAZAMIENTOS Y OTROS SERVICIOS:</h5>';
        $html .= '<table class="manodeobras">';
        $html .= '<tr>';
        $html .= '<th style="text-align:  left;width: 6%;">Nº PARTE</th>';
        $html .= '<th style="text-align:  left;width: 9%;">FECHA</th>';
        if ($hay_hd) {
            $html .= '<th style="text-align:  left;width: 32%;">DESCRIPCIÓN</th>';
            $html .= '<th style="text-align:  right;width: 5%;">H.D</th>';
        } else {
            $html .= '<th style="text-align:  left;width: 41%;">DESCRIPCIÓN</th>';
        }
        if ($hay_km) {
            $html .= '<th style="text-align:  right;width: 6%;">KM</th>';
            $html .= '<th style="text-align:  right;width: 7%;">IMPORTE DESPLAZ.</th>';
        } else {
            $html .= '<th style="text-align:  right;width: 9%;">IMPORTE DESPLAZ.</th>';
        }

        $html .= '<th style="text-align:  right;width: 7%;">DIETA</th>';
        $html .= '<th style="text-align:  right;width: 7%;">H.TRA</th>';
        $html .= '<th style="text-align:  right;width: 7%;">PRECIO H.TRAB</th>';
        $html .= '<th style="text-align:  right;width: 7%;">OTROS SERV.</th>';
        $html .= '<th style="text-align:  right;width: 8%;">TOTAL</th>';
        $html .= '</tr>';

        foreach ($TareasAlbaranesclientesreparacione['TareasAlbaranesclientesreparacionesParte'] as $partecentro) {
            $html .= '<tr>';
            $html .= '<td style="text-align:  left;widtd: 6%;">' . $partecentro['numero'] . ' </td>';
            $html .= '<td style="text-align:  left;widtd: 8%;">' . $this->Time->format('d-m-Y', $partecentro['fecha']) . '</td>';
            if ($hay_hd) {
                $html .= '<td style="text-align:  left;widtd: 25%;">' . $partecentro['operacion'] . '</td>';
                $html .= '<td style="text-align:  right;widtd: 5%;">' . number_to_comma($partecentro['horasdesplazamientoimputables_ida'] + $partecentro['horasdesplazamientoimputables_vuelta']) . '</td>';
            } else {
                $html .= '<td style="text-align:  left;widtd: 30%;">' . $partecentro['operacion'] . '</td>';
            }
            $kilometrajeprecio = ($partecentro['kilometrajeimputable_ida'] + $partecentro['kilometrajeimputable_vuelta']) * $albaranesclientesreparacione['Centrostrabajo']['preciokm'];
            $horasdesplazamientoprecio = ($partecentro['horasdesplazamientoimputables_ida'] + $partecentro['horasdesplazamientoimputables_vuelta']) * $albaranesclientesreparacione['Centrostrabajo']['preciohoradesplazamiento'];
            $totaldesplazamiento = $horasdesplazamientoprecio + $kilometrajeprecio + $partecentro['preciodesplazamiento'];


            if ($hay_km) {
                $html .= '<td style="text-align:  right;widtd: 5%;">' . number_to_comma($partecentro['kilometrajeimputable_ida'] + $partecentro['kilometrajeimputable_vuelta']) . '</td>';
                $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($totaldesplazamiento) . ' €</td>';
            } else {
                $html .= '<td style="text-align:  right;widtd: 15%;">' . number_to_comma($totaldesplazamiento) . ' €</td>';
            }


            $html .= '<td style="text-align:  right;widtd: 6%;">' . number_to_comma($partecentro['dietasimputables']) . ' €</td>';
            $html .= '<td style="text-align:  right;widtd: 6%;">' . number_to_comma($partecentro['horasimputables']) . ' h</td>';
            $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($partecentro['preciohoraencentro']) . ' €</td>';
            $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($partecentro['otrosservicios_imputable']) . ' €</td>';
            $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($totaldesplazamiento + $partecentro['dietasimputables'] + $partecentro['otrosservicios_imputable'] + ($partecentro['horasimputables'] * $partecentro['preciohoraencentro'])) . ' €</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        $html .= '<h5 style="text-align: right;">SUBTOTAL MANO DE OBRA, DESPLAZAMIENTO Y OTROS SERVICIOS: ' . number_to_comma($TareasAlbaranesclientesreparacione['total_partes_imputable']) . ' €</h5>';
        $html .= '<h5 style="text-align: left;">&nbsp; &nbsp; &nbsp; MATERIALES:</h5>';


        $hay_descuento = false;
        foreach ($TareasAlbaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione'] as $materiale) {
            if (!empty($materiale['descuento']))
                $hay_descuento = true;
        }

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
        if ($hay_descuento) {
            $html .= '<th style="text-align:  right;width: 10%;">DTO.</th>';
            $html .= '<th style="text-align:  right;width: 15%;">IMPORTE</th>';
        } else {
            $html .= '<th style="text-align:  right;width: 25%;">IMPORTE</th>';
        }
        $html .= '</tr>';
        foreach ($TareasAlbaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione'] as $materiale) {
            if ($materiale['cantidad'] > 0) {
                $html .= '<tr>';
                if ($albaranesclientesreparacione['Cliente']['imprimir_con_ref'] == 1) {
                    $html .= '<td style="text-align:  left;width: 15%;">' . $materiale['Articulo']['ref'] . '</td>';
                    $html .= '<td style="text-align:  left;width: 40%">' . $materiale['Articulo']['nombre'] . '</td>';
                } else {
                    $html .= '<td style="text-align:  left;width: 55%">' . $materiale['Articulo']['nombre'] . '</td>';
                }
                $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['cantidad']) . '</td>';
                $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['precio_unidad']) . ' €</td>';
                if ($hay_descuento) {
                    $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['descuento']) . ' %</td>';
                    $html .= '<td style="text-align:  right;width: 15%;">' . number_to_comma(($materiale['precio_unidad'] * $materiale['cantidad']) * (1 - ($materiale['descuento'] / 100))) . ' €</td>';
                } else {

                    $html .= '<td style="text-align:  right;width: 25%;">' . number_to_comma(($materiale['precio_unidad'] * $materiale['cantidad']) * (1 - ($materiale['descuento'] / 100))) . ' €</td>';
                } $html .= '</tr>';
            }
        }
        $html .= '</table>';
        $html .= '<h5 style="text-align: right;">SUBTOTAL MATERIALES: ' . number_to_comma($TareasAlbaranesclientesreparacione['total_materiales_imputables']) . ' €<h5>';
        $i++;
    } else {
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
        $html .= '<h5 style="text-align: left;border-bottom: 1px solid black;background-color: #e8e8e8;">TAREA ' . $TareasAlbaranesclientesreparacione['numero'] . ': ' . $TareasAlbaranesclientesreparacione['descripcion'] . '</h5>';
        $html .= '<h5 style="text-align: left;">&nbsp; &nbsp; &nbsp; MANO DE OBRA, DESPLAZAMIENTOS Y OTROS SERVICIOS:</h5>';
        $html .= '<table class="manodeobras">';
        $html .= '<tr>';
        $html .= '<th style="text-align:  left;width: 50%;">DESCRIPCIÓN</th>';
        $html .= '<th style="text-align:  right;width: 10%;">H.TRA</th>';
        $html .= '<th style="text-align:  right;width: 10%;">PRECIO H.TRAB</th>';
        $html .= '<th style="text-align:  right;width: 15%;">OTROS SERVICIOS</th>';
        $html .= '<th style="text-align:  right;width: 15%;">TOTAL</th>';
        $html .= '</tr>';
        $total_horas_trabajo_tarea_imputable = 0;
        $preciohoraentraller = 0;
        $otrosservicios_imputable = 0;
        $total = 0;
        foreach ($TareasAlbaranesclientesreparacione['TareasAlbaranesclientesreparacionesPartestallere'] as $partestallere) {
            $total_horas_trabajo_tarea_imputable += $partestallere['horasimputables'];
            $preciohoraentraller = $partestallere['preciohoraentraller'];
            $otrosservicios_imputable += $partestallere['otrosservicios_imputable'];
            $total += ($partestallere['horasimputables'] * $partestallere['preciohoraentraller']) * (1 - ($partestallere['descuento_manodeobra'] / 100)) + $partestallere['otrosservicios_imputable'];
            /* $html .= '<tr>';
              $html .= '<td style="text-align:  left;widtd: 10%;">' . $this->Time->format('d-m-Y', $partestallere['fecha']) . '</td>';
              $html .= '<td style="text-align:  left;widtd: 40%;">' . $partestallere['operacion'] . '</td>';
              $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($partestallere['horasimputables']) . '</td>';
              $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($partestallere['preciohoraentraller']) . '</td>';
              $html .= '<td style="text-align:  right;widtd: 15%;">' . number_to_comma($partestallere['otrosservicios_imputable']) . ' €</td>';
              $html .= '<td style="text-align:  right;widtd: 15%;">' . number_to_comma(($partestallere['horasimputables'] * $partestallere['preciohoraentraller']) * (1 - ($partestallere['descuento_manodeobra'] / 100)) + $partestallere['otrosservicios_imputable']) . ' €</td>';
              $html .= '</tr>'; */
        }

        $html .= '<tr>';
        $html .= '<td style="text-align:  left;widtd: 50%;">' . $TareasAlbaranesclientesreparacione['descripcion'] . '</td>';
        $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($total_horas_trabajo_tarea_imputable) . '</td>';
        $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($preciohoraentraller) . '</td>';
        $html .= '<td style="text-align:  right;widtd: 15%;">' . number_to_comma($otrosservicios_imputable) . ' €</td>';
        $html .= '<td style="text-align:  right;widtd: 15%;">' . number_to_comma($total) . ' €</td>';
        $html .= '</tr>';


        $html .= '</table>';
        $html .= '<h5 style="text-align: right;">SUBTOTAL MANO DE OBRA, DESPLAZAMIENTO Y OTROS SERVICIOS: ' . number_format($TareasAlbaranesclientesreparacione['totaldesplazamientoimputado'] + $TareasAlbaranesclientesreparacione['totalkilometrajeimputable'] + $TareasAlbaranesclientesreparacione['total_horastrabajoprecio_imputable'] + $TareasAlbaranesclientesreparacione['totaldietasimputables'] + $TareasAlbaranesclientesreparacione['totalotroserviciosimputables']) . ' €</h5>';
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

        $hay_descuento = false;
        foreach ($TareasAlbaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione'] as $materiale) {
            if (!empty($materiale['descuento']))
                $hay_descuento = true;
        }

        if ($hay_descuento) {
            $html .= '<th style="text-align:  right;width: 10%;">DTO.</th>';
            $html .= '<th style="text-align:  right;width: 15%;">IMPORTE</th>';
        } else {
            $html .= '<th style="text-align:  right;width: 25%;">IMPORTE</th>';
        }
        $html .= '</tr>';

        foreach ($TareasAlbaranesclientesreparacione['ArticulosTareasAlbaranesclientesreparacione'] as $materiale) {
            $html .= '<tr>';
            if ($albaranesclientesreparacione['Cliente']['imprimir_con_ref'] == 1) {
                $html .= '<td style="text-align:  left;width: 15%;">' . $materiale['Articulo']['ref'] . '</td>';
                $html .= '<td style="text-align:  left;width: 40%">' . $materiale['Articulo']['nombre'] . '</td>';
            } else {
                $html .= '<td style="text-align:  left;width: 55%">' . $materiale['Articulo']['nombre'] . '</td>';
            }
            $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['cantidad']) . '</td>';
            $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['precio_unidad']) . ' €</td>';
            if ($hay_descuento) {
                $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['descuento']) . ' %</td>';
                $html .= '<td style="text-align:  right;width: 15%;">' . number_to_comma(($materiale['precio_unidad'] * $materiale['cantidad']) * (1 - ($materiale['descuento'] / 100))) . ' €</td>';
            } else {
                $html .= '<td style="text-align:  right;width: 25%;">' . number_to_comma(($materiale['precio_unidad'] * $materiale['cantidad']) * (1 - ($materiale['descuento'] / 100))) . ' €</td>';
            }


            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '<h5 style="text-align: right;">SUBTOTAL MATERIALES: ' . number_to_comma($TareasAlbaranesclientesreparacione['total_materiales_imputables']) . ' €<h5>';
        $i++;
    }
}
// output the HTML content
//$pdf->Rect($pdf->GetX(), $pdf->GetY(), 198, 200,'S');
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->setY($pdf->getY() - 7);
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
            font-size: 0.8em;
            font-weight: bolder;
            background-color: #ddd8c2;
            vertical-align: middle;
        }
        table#totales tr td.precio {
            border: 1px solid #ddd8c2;
            line-height: 2em;
            text-align: center;
            font-size: 0.8em;
            font-weight: bolder;
            background-color: #ddd8c2;
            vertical-align: middle;
        }
    </style>
                <table style="border: 1px solid black; font-size: 0.8em;">
                    <tr>
                        <td>Total de Obra, Desplazamientos y Otros Servicios:</td>
                        <td style="text-align: right;"> ' . number_to_comma($albaranesclientesreparacione['Albaranesclientesreparacione']['total_manoobra']) . ' € </td>
                    </tr>
                    <tr>
                        <td>Total Materiales: </td>
                        <td style="text-align: right;">' . number_to_comma($albaranesclientesreparacione['Albaranesclientesreparacione']['total_materiales']) . ' € </td>
                    </tr>
                </table>
                <p style="font-size: 0.7em;">DOY MI CONFORMIDAD A LA REPARACION Y AL IMPORTE FACTURADO RECIBIENDO LA MAQUINA A MI ENTERA SATISFACCION Y A LA ELIMINACION DE LOS MATERIALES  Y RESIDUOS  DESECHADOS DE LA  MISMA <br/>FIRMA DEL CLIENTE: </p>
                <table id="totales" cellspacing="20" >
                    <tr>
                        <td class="nombre">BASE IMPONIBLE</td>
                        <td class="precio">' . number_to_comma($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible']) . ' €</td>
                        <td class="nombre">IVA</td>
                        <td class="precio">' . number_to_comma($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] * $albaranesclientesreparacione['Tiposiva']['porcentaje_aplicable'] / 100) . ' €</td>
                        <td class="nombre">TOTAL</td>
                        <td class="precio">' . number_to_comma(($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] * $albaranesclientesreparacione['Tiposiva']['porcentaje_aplicable'] / 100) + $albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible']) . ' €</td>
                    </tr>
                </table>';
$pdf->SetY(239, true, true);
$pdf->SetAutoPageBreak(FALSE, 2);
$pdf->writeHTML($html, 0, 0, 0, true, 'J', true);

$pdf->SetY(-14);
$pdf->SetX(33);
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell('', '', 'LOS TRABAJOS, REPUESTOS Y ACCESORIOS ESTÁN SUJETOS A LAS GARANTIAS ESTABLECIDAS LEGALMENTE');

$pdf->SetY(-11);
$pdf->SetX(14);
$pdf->SetFont('helvetica', 'I', 5);
$pdf->Cell('', '', 'EL CLIENTE, CON EXPRESA RENUNCIA AL FUERO QUE PUDIERA CORRESPONDERLE, SE SOMENTE A LOS JUZGADOS Y TRIBUNALES DE MORÓN DE LA FRONTERA PARA CUALQUIER LITIGIO QUE PUDIERA');
$pdf->SetY(-8);
$pdf->SetX(85);
$pdf->SetFont('helvetica', 'I', 5);
$pdf->Cell('', '', 'SUSCITARSE CON ESTE CONTRATO');

$pdf->SetY(-4);
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell('', '', ' ( Inscrita en el Registro Mercantil de Sevilla, Tomo 4225, Libro 0, Sección 8ª, Folio 1, Hoja SE 63.758, Inscripción 1ª, C.I.F.B-91/475319 )' . 'Pag. ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('albarandereparacion.pdf', 'I');
?>
