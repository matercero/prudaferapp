<?php

App::import('Vendor', 'pdfa4naranja');
// create new PDF document
$pdf = new PDFA4NARANJA(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Talleres Dafer');
$pdf->SetTitle('Factura de Cliente');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(5, 70, PDF_MARGIN_RIGHT, true);
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
  font-size: 1em;
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
  width: 350px;
  background-color: #ddd8c2;
  }
  .cif, .nombre_cliente {
  font-weight: bolder;
  }
  </style>

  <table class="cliente">
  <tr><td class="nombre_cliente">CLIENTE: ' . $facturasCliente['Cliente']['nombre'] . '</td></tr>
  <tr><td class="cif">CIF: ' . $facturasCliente['Cliente']['cif'] . '</td></tr>
  <tr><td>' . $facturasCliente['Cliente']['direccion_postal'] . '</td></tr>
  <tr><td>' . $facturasCliente['Cliente']['codigopostal'] . '  ' . $facturasCliente['Cliente']['poblacionpostal'] . '</td></tr>
  <tr><td>' . $facturasCliente['Cliente']['provinciapostal'] . '</td></tr>
  </table>
  ';
$pdf->writeHTMLCell('', '', $x + 80, $y_de_subcabecera + 0, $tbl, 0, 1, 0, true, 'J', true);

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
$pdf->SetY($pdf->GetY() + 10);

foreach ($facturasCliente['Albaranesclientesreparacione'] as $albaranesclientesreparacione) {
    $html = '';
    $html .= '
        <table style="border: 1px solid black;font-size: 0.7em;background-color: #F5D0A9;">
            <tr>
                <td><b>Nº DE ALBARÁN: </b> ' . $albaranesclientesreparacione['serie'] . ' / ' . zerofill($albaranesclientesreparacione['numero']) . '</td>
                <td><b>FECHA: </b> ' . $this->Time->format('d-m-Y', $albaranesclientesreparacione['fecha']) . '</td>
                <td><b>PEDIDO: </b> ' . $albaranesclientesreparacione['numero_aceptacion_aportado'] . '</td>
                <td><b>C.TRABAJO: </b> ' . $albaranesclientesreparacione['Centrostrabajo']['centrotrabajo'] . '</td>
            </tr>
            <tr>
                <td><b>MÁQUINA: </b>' . $albaranesclientesreparacione['Maquina']['nombre'] . '</td>
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
            $html .= '<h5 style="text-align: left;border-bottom: 1px solid black;background-color: #e8e8e8;">TAREA ' . $TareasAlbaranesclientesreparacione['numero'] . ': ' . $TareasAlbaranesclientesreparacione['descripcion'] . '</h5>';
            $html .= '<h5 style="text-align: left;">&nbsp; &nbsp; &nbsp; MANO DE OBRA, DESPLAZAMIENTOS Y OTROS SERVICIOS:</h5>';
            $html .= '<table class="manodeobras">';
            $html .= '<tr>';
            $html .= '<th style="text-align:  left;width: 6%;">Nº PARTE</th>';
            $html .= '<th style="text-align:  left;width: 9%;">FECHA</th>';
            $html .= '<th style="text-align:  left;width: 25%;">DESCRIPCIÓN</th>';
            $html .= '<th style="text-align:  right;width: 5%;">H.D</th>';
            $html .= '<th style="text-align:  right;width: 5%;">KM</th>';
            $html .= '<th style="text-align:  right;width: 9%;">IMPORTE DESPLAZ.</th>';
            $html .= '<th style="text-align:  right;width: 6%;">DIETA</th>';
            $html .= '<th style="text-align:  right;width: 6%;">H.TRA</th>';
            $html .= '<th style="text-align:  right;width: 10%;">PRECIO H.TRAB</th>';
            $html .= '<th style="text-align:  right;width: 10%;">OTROS SERVICIOS</th>';
            $html .= '<th style="text-align:  right;width: 10%;">TOTAL</th>';
            $html .= '</tr>';
            foreach ($TareasAlbaranesclientesreparacione['TareasAlbaranesclientesreparacionesParte'] as $partecentro) {
                $html .= '<tr>';
                $html .= '<td style="text-align:  left;widtd: 6%;">' . $partecentro['numero'] . ' </td>';
                $html .= '<td style="text-align:  left;widtd: 8%;">' . $this->Time->format('d-m-Y', $partecentro['fecha']) . '</td>';
                $html .= '<td style="text-align:  left;widtd: 25%;">' . $partecentro['operacion'] . '</td>';
                $html .= '<td style="text-align:  right;widtd: 5%;">' . number_to_comma($partecentro['horasdesplazamientoimputables_ida'] + $partecentro['horasdesplazamientoimputables_vuelta']) . '</td>';
                $html .= '<td style="text-align:  right;widtd: 5%;">' . number_to_comma($partecentro['kilometrajeimputable_ida'] + $partecentro['kilometrajeimputable_vuelta']) . '</td>';
                $kilometrajeprecio = ($partecentro['kilometrajeimputable_ida'] + $partecentro['kilometrajeimputable_vuelta']) * $albaranesclientesreparacione['Centrostrabajo']['preciokm'];
                $horasdesplazamientoprecio = ($partecentro['horasdesplazamientoimputables_ida'] + $partecentro['horasdesplazamientoimputables_vuelta']) * $albaranesclientesreparacione['Centrostrabajo']['preciohoradesplazamiento'];
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
            $html .= '<th style="text-align:  left;width: 10%;">FECHA</th>';
            $html .= '<th style="text-align:  left;width: 40%;">DESCRIPCIÓN</th>';
            $html .= '<th style="text-align:  right;width: 10%;">H.TRA</th>';
            $html .= '<th style="text-align:  right;width: 10%;">PRECIO H.TRAB</th>';
            $html .= '<th style="text-align:  right;width: 15%;">OTROS SERVICIOS</th>';
            $html .= '<th style="text-align:  right;width: 15%;">TOTAL</th>';
            $html .= '</tr>';
            foreach ($TareasAlbaranesclientesreparacione['TareasAlbaranesclientesreparacionesPartestallere'] as $partestallere) {
                $html .= '<tr>';
                $html .= '<td style="text-align:  left;widtd: 10%;">' . $this->Time->format('d-m-Y', $partestallere['fecha']) . '</td>';
                $html .= '<td style="text-align:  left;widtd: 40%;">' . $partestallere['operacion'] . '</td>';
                $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($partestallere['horasimputables']) . '</td>';
                $html .= '<td style="text-align:  right;widtd: 10%;">' . number_to_comma($partestallere['preciohoraentraller']) . '</td>';
                $html .= '<td style="text-align:  right;widtd: 15%;">' . number_to_comma($partestallere['otrosservicios_imputable']) . ' €</td>';
                $html .= '<td style="text-align:  right;widtd: 15%;">' . number_to_comma(($partestallere['horasimputables'] * $partestallere['preciohoraentraller']) * (1 - ($partestallere['descuento_manodeobra'] / 100)) + $partestallere['otrosservicios_imputable']) . ' €</td>';
                $html .= '</tr>';
            }
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
            <td><b>CENTRO TRABAJO: </b>' . $albaranescliente['Centrostrabajo']['centrotrabajo'] . '</td>
            <td><b>AGENCIA TPTES.: </b>' . $albaranescliente['agenciadetransporte'] . '</td>
            <td><b>CENTRO TRABAJO: </b>' . $albaranescliente['Centrostrabajo']['centrotrabajo'] . '</td>
            <td><b>MAQUINA: </b>' . $albaranescliente['Maquina']['nombre'] . '</td>
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

/*
 * FIN DE ALBARANES DE REPUESTOS
 */

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
                <table id="totales" cellspacing="20" >
                    <tr>
                        <td class="nombre">BASE IMPONIBLE</td>
                        <td class="precio">' . number_to_comma($facturasCliente['FacturasCliente']['baseimponible']) . ' €</td>
                        <td class="nombre">IVA</td>
                        <td class="precio">' . number_to_comma($facturasCliente['FacturasCliente']['impuestos']) . ' €</td>
                        <td class="nombre">TOTAL FACTURA</td>
                        <td class="precio">' . number_to_comma($facturasCliente['FacturasCliente']['total']) . ' €</td>
                    </tr>
                </table>';
$pdf->SetY(255, true, true);
$pdf->SetAutoPageBreak(FALSE, 10);
$pdf->writeHTML($html, 1, 1, 0, true, 'J', true);

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
  <table style="font-size: 0.8em;">
    <tr>example_001
        <td><b>FORMA DE PAGO: </b>' . $facturasCliente['Cliente']['Formapago']['nombre'] . '</td>
        <td rowspan="2"><b>VENCIMIENTOS :</b>' . $vencimientoshtml . '</td>
    </tr>
    <tr>
        <td><b>CUENTA BANCARIA: </b>' . $facturasCliente['Cliente']['Cuentasbancaria']['numero_entidad'] . ' ' . $facturasCliente['Cliente']['Cuentasbancaria']['numero_sucursal'] . ' ' . $facturasCliente['Cliente']['Cuentasbancaria']['numero_dc'] . ' ' . $facturasCliente['Cliente']['Cuentasbancaria']['numero_cuenta'] . '</td>
    </tr>
  </table>
  <p style="font-size: 0.8em;">TALLERES DAFER S.L. - P.I. LOS PERALES, C/ TARANTA 9 - 42530  MORON DE LA FRA. (SEVILLA) APTDO. 62 </p>
';
$pdf->SetX(10);
$pdf->writeHTML($html, 1);
$pdf->SetY(-5);
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell('', '', ' ( Inscrita en el Registro Mercantil de Sevilla, Tomo 4225, Libro 0, Sección 8ª, Folio 1, Hoja SE 63.758, Inscripción 1ª, C.I.F.B-91/475319 )' . 'Pag. ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

// ---------------------------------------------------------
//Close and output PDF document

//$path = 'C:\\xampp\\htdocs\\';
$path = '../webroot/files/facturaEmails/' ;
$nombre_fichero = 'factura_' . $facturasCliente['FacturasCliente']['id'] . '.pdf';
$varFct = $path . $nombre_fichero;
$pdf->Output($varFct, 'F'); // Opcion F, save in disk
?>
