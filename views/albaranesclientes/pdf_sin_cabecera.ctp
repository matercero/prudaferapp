<?php

App::import('Vendor', 'pdfmostrador_sin_cabecera');
// create new PDF document
$pdf = new PDFMOSTRADOR('L', PDF_UNIT, array(210, 148.5), true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Talleres Dafer');
$pdf->SetTitle('Albaran de Venta');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(10, 28, PDF_MARGIN_RIGHT, true);
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
                font-size: 0.6em;
                width: 30%;
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
            </style>
<table class="tipodoc">
    <tr>
        <th colspan="4" >ALBARAN DE VENTA</th>
    </tr>
    <tr>
         <td style="width: 15%;">SERIE</td>
         <td style="width: 30%;">NUMERO</td>
         <td style="width: 30%;">FECHA</td>
         <td style="width: 25%;">SU PEDIDO</td>
    </tr>
    <tr>
       <td>' . $albaranescliente['Albaranescliente']['serie'] . '</td>
       <td>' . zerofill($albaranescliente['Albaranescliente']['numero']) . '</td>
       <td>' . $this->Time->format('d-m-Y', $albaranescliente['Albaranescliente']['fecha']) . '</td>
       <td>' . @$albaranescliente['Albaranescliente']['numero_aceptacion_aportado'] . '</td>
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
            width: 200px;
            background-color: #ddd8c2;
        }
        .cif, .nombre_cliente {
            font-weight: bolder;
        }
    </style>
   
    <table class="cliente">
        <tr><td class="nombre_cliente">CLIENTE: ' . $albaranescliente['Cliente']['nombre'] . '</td></tr>
        <tr><td class="cif">CIF: ' . $albaranescliente['Cliente']['cif'] . '</td></tr>
        <tr><td>' . $albaranescliente['Cliente']['direccion_postal'] . '</td></tr>
        <tr><td>' . $albaranescliente['Cliente']['codigopostal'] . '  ' . $albaranescliente['Cliente']['poblacionpostal'] . '</td></tr>
        <tr><td>' . $albaranescliente['Cliente']['provinciapostal'] . '</td></tr>
    </table>
';
$pdf->writeHTMLCell('', '', $x + 58, $y_de_subcabecera + 10, $tbl, 0, 1, 0, true, 'J', true);

/*
 * Fin Area de Cliente
 */

/*
 * Area de Dirección de Envio
 */

$tbl = '
    <style>
        table.direccion {
            font-size: 0.7em;
            text-align: left;
            width: 243px;
            border: 2px solid #ddd8c2;
        }
        .nombre_direccion, .negrita {
            font-weight: bolder;
        }
    </style>
    <table class="direccion">
        <tr><td class="negrita">DIRECCIÓN DE ENVIO: ' . $albaranescliente['Centrostrabajo']['centrotrabajo'] . '</td></tr>
        <tr><td> ' . $albaranescliente['Centrostrabajo']['direccion'] . '</td></tr>
        <tr><td> ' . $albaranescliente['Centrostrabajo']['cp'] . '  ' . $albaranescliente['Centrostrabajo']['poblacion'] . '</td></tr>
        <tr><td> ' . $albaranescliente['Centrostrabajo']['provincia'] . '</td></tr>
        <tr><td></td></tr>
    </table>
';
$pdf->writeHTMLCell('', '', $x + 118, $y_de_subcabecera + 10, $tbl, 0, 1, 0, true, 'J', true);

/*
 * Fin Dirección de Envio
 */
$y = $pdf->getY();
$tbl = '
    <style>
        table.mas_datos {
            font-size: 0.7em;
            text-align: left;
            width: 102%;
            border: 1px dashed #ddd8c2;
        }
       span {
            font-weight: bold;
        }
    </style>
    <table class="mas_datos">
        <tr>
            <td colspan="2"><span>FORMA DE PAGO: </span>' . $albaranescliente['Cliente']['Formapago']['nombre'] . '</td>
            <td><span>COMERCIAL: </span>' . $albaranescliente['Comerciale']['nombre'] . ' ' . $albaranescliente['Comerciale']['apellidos'] . '</td>
        </tr>
        <tr>
            <td><span>AGENCIA TPTES.: </span>' . $albaranescliente['Albaranescliente']['agenciadetransporte'] . '</td>
            <td><span>CENTRO TRABAJO: </span>' . $albaranescliente['Centrostrabajo']['centrotrabajo'] . '</td>
            <td><span>MAQUINA: </span>' . $albaranescliente['Maquina']['nombre'] . '</td>
        </tr>
        <tr>
            <td><span>PORTES: </span>' . $albaranescliente['Albaranescliente']['portes'] . '</td>
            <td colspan="2"><span>BULTOS: </span>' . $albaranescliente['Albaranescliente']['bultos'] . '</td>
        </tr>
        
        <tr>
            <td colspan="3"><span>OBSERVACIONES: </span>' . $albaranescliente['Albaranescliente']['observaciones'] . '</td>
        </tr>
    </table>
         ';
$pdf->writeHTMLCell('', '', '', $y + 3, $tbl, 0, 1, 0, true, 'J', true);

/*
 * Datos del Alabarán
 */

/*
 * Fin de Datos del Alabarán
 */


/*
 * FIN DE SUBCABECERA 
 */


/*
 * Area de Articulos
 */

//Un poco de margen abajo para separar
$pdf->SetY($pdf->GetY() + 2);

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
                width: 59%;
            }
            ';
else
    $html .='.descripcion{
                width: 59%;
            }
            ';
$html .='.small {
                width: 70px;
            }
            .medium {
                width: 140px;
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
                <table id="totales" cellspacing="20" >
                    <tr>
                        <td class="nombre">BASE IMPONIBLE</td>
                        <td class="precio">' . number_to_comma($albaranescliente['Albaranescliente']['precio']) . ' €</td>
                        <td class="nombre">IVA</td>
                        <td class="precio">' . number_to_comma($albaranescliente['Albaranescliente']['impuestos']) . ' €</td>
                        <td class="nombre">TOTAL ALBARÁN</td>
                        <td class="precio">' . number_to_comma($albaranescliente['Albaranescliente']['precio'] + $albaranescliente['Albaranescliente']['impuestos']) . ' €</td>
                    </tr>
                </table>';
$pdf->SetY(132, true, true);
$pdf->SetAutoPageBreak(FALSE, 10);
$pdf->writeHTML($html, 0, 1, 0, true, 'J', true);
$pdf->SetY(-5);
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell('', '', '' . 'Pag. ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');


// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('albarandeventa.pdf', 'I');
?>
