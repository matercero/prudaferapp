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
                width: 37%;
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
        <th colspan="3" style="font-size: 1.2em;">PEDIDO PROVEEDOR</th>
    </tr>
    <tr>
         <td>SERIE</td>
         <td>NUMERO</td>
         <td>FECHA</td>
    </tr>
    <tr>
       <td>' . $pedidosproveedore['Pedidosproveedore']['serie'] . '</td>
       <td>' . zerofill($pedidosproveedore['Pedidosproveedore']['numero']) . '</td>
       <td>' . $this->Time->format('d-m-Y', $pedidosproveedore['Pedidosproveedore']['fecha']) . '</td>
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
        <tr><td class="nombre_cliente">PROVEEDOR: ' . $pedidosproveedore['Proveedore']['nombre'] . '</td></tr>
        <tr><td class="cif">CIF: ' . $pedidosproveedore['Proveedore']['cif'] . '</td></tr>
        <tr><td>' . $pedidosproveedore['Proveedore']['direccion'] . '</td></tr>
        <tr><td>' . $pedidosproveedore['Proveedore']['cp'] . '  ' . $pedidosproveedore['Proveedore']['poblacion'] . '</td></tr>
        <tr><td>' . $pedidosproveedore['Proveedore']['provincia'] . '</td></tr>
    </table>
';
$pdf->writeHTMLCell('', '', $x + 70, $y_de_subcabecera + 10, $tbl, 0, 1, 0, true, 'J', true);

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
            width: 170px;
            border: 2px solid #ddd8c2;
        }
        .nombre_direccion, .negrita {
            font-weight: bolder;
        }
    </style>
    <table class="direccion">
        <tr><td class="negrita">DIRECCIÓN DE ENVIO: ' . $pedidosproveedore['Almacene']['direccion'] . '</td></tr>        
        <tr><td class="negrita">' . $pedidosproveedore['Almacene']['telefono'] . '</td></tr>
        <tr><td></td></tr>
    </table>
';
$pdf->writeHTMLCell('', '', $x + 130, $y_de_subcabecera + 10, $tbl, 0, 1, 0, true, 'J', true);

/*
 * Fin Dirección de Envio
 */
$y = $pdf->getY();
$tbl = '
    <style>
        table.mas_datos {
            font-size: 0.7em;
            text-align: left;
            width: 100%;
            border: 1px dashed #ddd8c2;
        }
       span {
            font-weight: bold;
        }
    </style>
    <table class="mas_datos">
        <tr>
            <td colspan="2"><span>REFERENCIA PROVEEDOR: </span>' . $pedidosproveedore['Pedidosproveedore']['referencia_proveedor'] . '</td>
            <td><span>ATENDIDO POR: </span>' . '' . '</td>
            <td><span>FORMA DE PAGO: </span>' . $pedidosproveedore['Proveedore']['Formapago']['nombre'] . '</td>
        </tr>
        <tr>
            <td><span>AGENCIA TPTES.: </span>' . $pedidosproveedore['Presupuestosproveedore']['agenciadetransporte'] . '</td>
            <td><span>PORTES: </span>' . $pedidosproveedore['Presupuestosproveedore']['portes'] . '</td>
        </tr>
        <tr>
            <td colspan="3"><span>OBSERVACIONES: </span>' . $pedidosproveedore['Pedidosproveedore']['observaciones'] . '</td>
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
$total = 0;

$lineas = '';
foreach ($pedidosproveedore['ArticulosPedidosproveedore'] as $ArticulosPedidosproveedore) {
    $lineas .= '<tr>';
    $lineas .= '<td>' . $ArticulosPedidosproveedore['Articulo']['ref'] . '</td>';
    $lineas .= '<td>' . $ArticulosPedidosproveedore['Articulo']['nombre'] . '</td>
        <td>' . number_to_comma($ArticulosPedidosproveedore['cantidad']) . '</td>';
    $lineas .='<td>' . number_to_comma($ArticulosPedidosproveedore['precio_proveedor']) . '</td>';
    $lineas .='<td>' . number_to_comma($ArticulosPedidosproveedore['descuento']) . ' %</td>';
    $lineas .='<td>' . number_to_comma($ArticulosPedidosproveedore['total']) . '</td></tr>';
    $total +=$ArticulosPedidosproveedore['total'];
}

$html = '
<style>
            table.articulos {
                font-size: 0.8em;
            }

            th {
                font-weight: bolder;
                text-align: left;
                background-color: #e5e5e5;
                border-bottom: 1px solid black;
                border-left: 1px solid black;
                border-right: 1px solid black;
            }
            .descripcion{
                width: 40%;
            }
            .small {
                width: 10%;
            }
            .medium {
                width: 15%;
            }
            td {
                /*border-right: 1px solid black;*/
            }
            </style>
    <table class="articulos">
        <tr class="header">';
$html .= '<th class="medium">REFERENCIA</th>';
$html.= '<th class="descripcion">DESCRIPCIÓN</th>
            <th class="medium">CANTIDAD</th>
            <th class="small">PRECIO</th>
            <th class="small">DTO.</th>
            <th class="small">IMPORTE</th>
        </tr>
    ' . $lineas . '
</table>
';

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
                <table id="totales" cellspacing="20" >
                    <tr>
                        <td class="nombre">BASE IMPONIBLE</td>
                        <td class="precio">' . number_to_comma($total) . ' €</td>
                        <td class="nombre">IVA</td>
                        <td class="precio">' . number_to_comma($total * ($pedidosproveedore['Tiposiva']['porcentaje_aplicable'] / 100)) . ' €</td>
                        <td class="nombre">TOTAL PRESUPUESTO</td>
                        <td class="precio">' . number_to_comma($total + ($total * ($pedidosproveedore['Tiposiva']['porcentaje_aplicable'] / 100))) . ' €</td>
                    </tr>
                </table>';
$pdf->SetY(275, true, true);
$pdf->SetAutoPageBreak(FALSE, 10);
$pdf->writeHTML($html, 0, 1, 0, true, 'J', true);
$pdf->SetY(-5);
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell('', '', ' ( Inscrita en el Registro Mercantil de Sevilla, Tomo 4225, Libro 0, Sección 8ª, Folio 1, Hoja SE 63.758, Inscripción 1ª, C.I.F.B-91/475319 )' . 'Pag. ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');


// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('pedidoproveedor_'.zerofill($pedidosproveedore['Pedidosproveedore']['numero']).'.pdf', 'I');
?>
