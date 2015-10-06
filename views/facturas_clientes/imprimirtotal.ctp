<?php

App::import('Vendor', 'concat_pdf');
// create new PDF document
$pdf = new concat_pdf();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Talleres Dafer');
$pdf->SetTitle('Factura de Cliente');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
   
// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
    $pdf->SetMargins(5, 60, PDF_MARGIN_RIGHT, true);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->setPrintHeader(true);
    $pdf->setPrintFooter(true);


//set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 50);

//set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------
// set font
    $pdf->SetFont('dejavusans', '', 10);




// add a page
    $pdf->AddPage('', 'A4');


    /*
     * SUBCABECERA
     */

    /*
     * Area de Tipo de Documento
     */

    $tbl = '
  <style>
  table.tipodoc {
  font-size: 1em;
  width: 47%;
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
  <th colspan="3" >FACTURA</th>
  </tr>
  <tr>
  <td>SERIE</td>
  <td>NUMERO</td>
  <td>FECHA</td>
  </tr>
  <tr>
  <td>' . $facturasCliente['FacturasCliente']['serie'] . '</td>
  <td>' . zerofill($facturasCliente['FacturasCliente']['numero']) . '</td>
  <td>' . $this->Time->format('d-m-Y', $facturasCliente['FacturasCliente']['fecha']) . '</td>
  </tr>
  </table>
  ';
    $y_de_subcabecera = $pdf->GetY();
    $pdf->writeHTMLCell('', '', '', $y_de_subcabecera + 0, $tbl, 0, 1, 0, true, 'J', true);
    $x = $pdf->GetX();

    /*
     * Area de Cliente
     */

    $tbl = '
  <style>
  table.cliente {
  font-size: 0.9em;
  text-align: left;
  width: 100%;
  background-color: #ddd8c2;
  }
  .cif, .nombre_cliente {
  font-weight: bolder;
  }
  </style>

  <table class="cliente">
  <tr><td class="nombre_cliente">CLIENTE: ' . $facturasCliente['Cliente']['nombrefiscal'] . '</td></tr>
  <tr><td>' . $facturasCliente['Cliente']['direccion_fiscal'] . '</td></tr>
  <tr><td>' . $facturasCliente['Cliente']['codigopostalfiscal'] . '  ' . $facturasCliente['Cliente']['poblacionfiscal'] . '</td></tr>
  <tr><td>' . $facturasCliente['Cliente']['provinciafiscal'] . '</td></tr>
  <tr><td class="cif">CIF: ' . $facturasCliente['Cliente']['cif'] . '</td></tr>
  </table>
  ';
    $pdf->writeHTMLCell('', '', $x + 90, $y_de_subcabecera + 0, $tbl, 0, 1, 0, true, 'J', true);

    /*
     * Fin Area de Cliente
     */


    /*
     * FIN DE SUBCABECERA 
     */


    /*
     * Area De ALBARANES DE REPARACIÓN
     */

//Un poco de margen abajo para separar
    $pdf->SetY($pdf->GetY() + 3);

    foreach ($facturasCliente['Albaranesclientesreparacione'] as $albaranesclientesreparacione) {
        $html = '';
        $html .= '
        <table style="border: 1px solid black;font-size: 0.7em;background-color: #F5D0A9;">
            <tr>
                <td><b>Nº DE ALBARÁN: </b> ' . $albaranesclientesreparacione['serie'] . ' / ' . zerofill($albaranesclientesreparacione['numero']) . '</td>
                <td><b>FECHA: </b> ' . $this->Time->format('d-m-Y', $albaranesclientesreparacione['fecha']) . '</td>
                <td><b>PEDIDO: </b> ' . $albaranesclientesreparacione['numero_aceptacion_aportado'] . '</td>
            </tr>
            <tr>    
                <td><b>C.TRABAJO: </b> ' . $albaranesclientesreparacione['Centrostrabajo']['centrotrabajo'] . '</td>
				<td><b>MÁQUINA: </b>' . $albaranesclientesreparacione['Maquina']['nombre'] . '</td>
            </tr>
            <tr> 
                <td colspan="3"><b>OBSERVACIONES: </b>' . $albaranesclientesreparacione['observaciones'] . '</td>
            </tr>
        </table>
        ';
        $pdf->writeHTML($html, 1);

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
                font-size: 8pt;
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
                    $html .= '<th style="text-align:  left;width: 33%;">DESCRIPCIÓN</th>';
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
                $html .= '<th style="text-align:  right;width: 6%;">H.TRA</th>';
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
                    $html .= '<td style="text-align:  right;widtd: 9%;">' . number_to_comma($totaldesplazamiento + $partecentro['dietasimputables'] + $partecentro['otrosservicios_imputable'] + ($partecentro['horasimputables'] * $partecentro['preciohoraencentro'])) . ' €</td>';
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
                $html .= '<th style="text-align:  right;width: 10%;">DTO.</th>';
                $html .= '<th style="text-align:  right;width: 15%;">IMPORTE</th>';
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
                    $html .= '<td style="text-align:  right;width: 10%;">' . number_to_comma($materiale['descuento']) . ' %</td>';
                    $html .= '<td style="text-align:  right;width: 15%;">' . number_to_comma(($materiale['precio_unidad'] * $materiale['cantidad']) * (1 - ($materiale['descuento'] / 100))) . ' €</td>';
                    $html .= '</tr>';
                }
                $html .= '</table>';
                $html .= '<h5 style="text-align: right;">SUBTOTAL MATERIALES: ' . number_to_comma($TareasAlbaranesclientesreparacione['total_materiales_imputables']) . ' €<h5>';
                $i++;
            }
        }
        $pdf->writeHTML($html, 1, false, false, false, '');
        $html = '';
        $html .= '
        <table style="border: 1px solid black; font-size: 0.9em;">
                    <tr>
                        <td>Total de Obra, Desplazamientos y Otros Servicios:</td>
                        <td style="text-align: right;"> ' . number_to_comma($albaranesclientesreparacione['total_manoobra']) . ' € </td>
                    </tr>
                    <tr>
                        <td>Total Materiales: </td>
                        <td style="text-align: right;">' . number_to_comma($albaranesclientesreparacione['total_materiales']) . ' € </td>
                    </tr>
                    <tr>
                        <td>Total Albarán: </td>
                        <td style="text-align: right;">' . number_to_comma($albaranesclientesreparacione['baseimponible']) . ' € </td>
                    </tr>
                </table>
        ';
        $pdf->writeHTML($html, 1);
    }
    /*
     * FIN DE ALBARANES DE REPARACIÓN
     */

    /*
     * Area de ALBARANES DE REPUESTOS
     */

    foreach ($facturasCliente['Albaranescliente'] as $albaranescliente) {

        $pdf->SetY($pdf->GetY() + 2);
        $html = '';
        $html .= '
    <table style="border: 1px solid black;font-size: 0.7em;background-color: #F5D0A9;">
    <tr>
         <td><b>Nº ALBARÁN: </b>' . $albaranescliente['serie'] . ' / ' . zerofill($albaranescliente['numero']) . '</td>
         <td colspan="2"><b>FECHA: </b>' . $this->Time->format('d-m-Y', $albaranescliente['fecha']) . '</td>
         <td><b>SU PEDIDO: </b>' . @$albaranescliente['numero_aceptacion_aportado'] . '</td>
    </tr>
        <tr>
            <td colspan="2"><b>CENTRO TRABAJO: </b>' . $albaranescliente['Centrostrabajo']['centrotrabajo'] . '</td>
            <td><b>COMERCIAL: </b>' . $albaranescliente['Comerciale']['nombre'] . ' ' . $albaranescliente['Comerciale']['apellidos'] . '</td>
            <td><b>MAQUINA: </b>' . $albaranescliente['Maquina']['nombre'] . '</td>
        </tr>
        <tr> 
             <td colspan="3"><b>OBSERVACIONES: </b>' . $albaranescliente['observaciones'] . '</td>
        </tr>
</table>
    ';
        $pdf->writeHTML($html, 1);


        $lineas = '';
        foreach ($albaranescliente['Tareasalbaranescliente'] as $tarea) {
            foreach ($tarea['MaterialesTareasalbaranescliente'] as $material) {
                $lineas .= '
    <tr>';
                if ($albaranescliente['Cliente']['imprimir_con_ref'] == 1)
                    $lineas .= '<td>' . $material['Articulo']['ref'] . '</td>';

                $lineas .= '<td>' . $material['Articulo']['nombre'] . '</td>
        <td>' . number_to_comma($material['cantidad']) . '</td>';
                if ($material['descuento'] > 0)
                    $lineas .='<td>' . number_to_comma($material['precio_unidad']) . '   Dto: ' . number_to_comma($material['descuento']) . ' %</td>';
                else
                    $lineas .='<td>' . number_to_comma($material['precio_unidad']) . '</td>';
                $lineas .='
        <td>' . number_to_comma($material['importe']) . '</td>
    </tr>
    ';
            }
        }

        $html = '
<style>
             table.articulos {
                font-size: 0.8em;
                width: 100%;
         
            }

            th {
                font-weight: bolder;
                text-align: left;
                background-color: #e5e5e5;
                border-bottom: 1px solid black;
                border-left: 1px solid black;
                border-right: 1px solid black;
            }';
        if ($albaranescliente['Cliente']['imprimir_con_ref'] == 1)
            $html .='.descripcion{
                width: 47%;
            }
            ';
        else
            $html .='.descripcion{
                width: 58.5%;
            }
            ';
        $html .='.small {
                width: 70px;
            }
            .medium {
                width: 140px;
            }
            td {
                border-right: 1px solid black;
            }
            </style>
            
<table class="articulos">
        <tr>';
        if ($albaranescliente['Cliente']['imprimir_con_ref'] == 1)
            $html .= '<th>REFERENCIA</th>';
        $html.= '
    <th class="descripcion">DESCRIPCIÓN</th>
            <th class="small">CANTIDAD</th>
            <th class="medium">PRECIO</th>
            <th class="small">IMPORTE</th>
        </tr>
    ' . $lineas . '
</table>
';

// output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = '';
        $html .= '
        <table style="border: 1px solid black; font-size: 0.9em;">
                    <tr>
                        <td>Total Albarán: </td>
                        <td style="text-align: right;">' . number_to_comma($albaranescliente['precio']) . ' € </td>
                    </tr>
                </table>
        ';
        $pdf->writeHTML($html, 1);
    }

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
            font-size: 1.1em;
            font-weight: bolder;
        }
    </style>
                <table id="totales" cellspacing="4" >
                    <tr>
                        <td class="nombre">BASE IMPONIBLE</td>
                        <td class="precio">' . number_to_comma($facturasCliente['FacturasCliente']['baseimponible']) . ' €</td>
                        <td class="nombre">IVA</td>
                        <td class="precio">' . number_to_comma($facturasCliente['FacturasCliente']['impuestos']) . ' €</td>
                        <td class="nombre">TOTAL FACTURA</td>
                        <td class="precio">' . number_to_comma($facturasCliente['FacturasCliente']['total']) . ' €</td>
                    </tr>
                </table>';
   $pdf->SetY(245, true, true);
$pdf->SetAutoPageBreak(FALSE, 2);
$pdf->writeHTML($html, 0, 0, 0, true, 'J', true);

$vencimientoshtml = '';
$primera_fecha_de_vencimiento = date("d-m-Y", strtotime($this->Time->format('d-m-Y', $facturasCliente['FacturasCliente']['fecha'] . " +" . $facturasCliente['Cliente']['Formapago']['dias_entre_vencimiento'] . " days")));
if (!empty($facturasCliente['Cliente']['Formapago']['dia_mes_fijo_vencimiento'])) {
    if ($facturasCliente['Cliente']['Formapago']['dia_mes_fijo_vencimiento'] < (int) date("d", strtotime($primera_fecha_de_vencimiento))) {
        $primera_fecha_de_vencimiento = date("d-m-Y", strtotime($primera_fecha_de_vencimiento . " +1 month"));
        $primera_fecha_de_vencimiento = date('d-m-Y', mktime(0, 0, 0, date("m", strtotime($primera_fecha_de_vencimiento)), $facturasCliente['Cliente']['Formapago']['dia_mes_fijo_vencimiento'], date("Y", strtotime($primera_fecha_de_vencimiento))));
    } else {
        $primera_fecha_de_vencimiento = date('d-m-Y', mktime(0, 0, 0, date("m", strtotime($primera_fecha_de_vencimiento)), $facturasCliente['Cliente']['Formapago']['dia_mes_fijo_vencimiento'], date("Y", strtotime($primera_fecha_de_vencimiento))));
    }
}
$vencimientoshtml .= '<ul>';
for ($index = 0; $index < $facturasCliente['Cliente']['Formapago']['numero_vencimientos']; $index++) {
    if ($primera_fecha_de_vencimiento != '01-01-1970')
        $vencimientoshtml .= '<li>' . $primera_fecha_de_vencimiento . '</li>';
    $primera_fecha_de_vencimiento = date("d-m-Y", strtotime($primera_fecha_de_vencimiento . " +" . $facturasCliente['Cliente']['Formapago']['dias_entre_vencimiento'] . " days"));
}
$vencimientoshtml .= '</ul>';

    $html = '';
    $html .= '
  <table style="font-size: 0.7em;">
    <tr>
        <th colspan="2" ><b>FORMA DE PAGO:</b></th>
        <th colspan="3" >' . $facturasCliente['Cliente']['Formapago']['nombre'] . '</th>
        <th colspan="4" ><b>VENCIMIENTOS :</b></th>
        <th colspan="2" >' . $vencimientoshtml . '</th>
    </tr>
    <tr>
        <th colspan="2" ><b>CUENTA BANCARIA: </b></th>
        <th colspan="4" >' . $facturasCliente['Cliente']['Cuentasbancaria']['numero_entidad'] . ' ' . $facturasCliente['Cliente']['Cuentasbancaria']['numero_sucursal'] . ' ' . $facturasCliente['Cliente']['Cuentasbancaria']['numero_dc'] . ' ' . $facturasCliente['Cliente']['Cuentasbancaria']['numero_cuenta'] . '</th>
    </tr>
  <tr><th> </th></tr>
  </table>
  <table style="border: 1px dashed #ddd8c2;">
  <tr>
  <th style="text-align:  centre; font-size: 6 pt;">LOS TRABAJOS, REPUESTOS Y ACCESORIOS ESTÁN SUJETOS A LAS GARANTIAS ESTABLECIDAS LEGALMENTE</th>
  </tr>
  </table>
  <table style="font-size: 0.7em;">
  <tr><td  style="font-size: 0.6em;"> </td></tr>
  <tr><td style="text-align: centre;"><span style="font-size: 0.7em;">EL CLIENTE, CON EXPRESA RENUNCIA AL FUERO QUE PUDIERA CORRESPONDERLE, SE SOMENTE A LOS JUZGADOS Y TRIBUNALES DE MORÓN DE LA FRONTERA PARA CUALQUIER LITIGIO QUE PUDIERA SUSCITARSE CON ESTE CONTRATO</span></td></tr>
  <tr><td style="text-align: centre;">TALLERES DAFER S.L. - P.I. LOS PERALES, C/ TARANTA 9 - 41530  MORON DE LA FRA. (SEVILLA) </td></tr>
  </table>
';
       
$pdf->SetX(6);
$pdf->writeHTML($html, 1);
$pdf->SetY(-10);
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell('', '', '                                            ( Inscrita en el Registro Mercantil de Sevilla, Tomo 4225, Libro 0, Sección 8ª, Folio 1, Hoja SE 63.758, Inscripción 1ª, C.I.F.B-91475319 )' . '                  Pag. ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');




    $pdf->setPrintHeader(false);

    $files = array();
    
    foreach ($facturasCliente['Albaranescliente'] as $albaranescliente) {
        if (!empty($albaranescliente['albaranescaneado'])) {
            $templatefile = $albaranescliente['albaranescaneado'];
            $files[] = '../webroot/files/albaranescliente/' . $templatefile;
        }
    }
    
    foreach ($facturasCliente['Albaranesclientesreparacione'] as $albaranescliente) {
       if (!empty($albaranescliente['albaranescaneado'])) {
            $templatefile = $albaranescliente['albaranescaneado'];
            $files[] = '../webroot/files/albaranesclientesreparacione/' . $templatefile;
        }
        foreach ($albaranescliente['TareasAlbaranesclientesreparacione'] as $tarea) {
           foreach ($tarea['TareasAlbaranesclientesreparacionesParte'] as $partecentro) {
                if (!empty($partecentro['parteescaneado'])) {
                    $templatefile = $partecentro['parteescaneado'];
                    $files[] = '../webroot/files/parte/' . $templatefile;
                }
            }
            foreach ($tarea['TareasAlbaranesclientesreparacionesPartestallere'] as $partetaller) {
                if (!empty($partetaller['parteescaneado'])) {
                    $templatefile = $partetaller['parteescaneado'];
                    $files[] = '../webroot/files/partestallere/' . $templatefile;
                }
            }
        }
    }
    if (!empty($files)) {
        $pdf->setFiles($files);
        $pdf->concat();
    }


$pdf->Output('facturacion.pdf', 'I');
?>
