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
        <th colspan="4" style="font-size: 1.2em;">PRESUPUESTO PROVEEDOR</th>
    </tr>
    <tr>
         <td>SERIE</td>
         <td>NUMERO</td>
         <td>FECHA</td>
         <td>Nº PEDIDO</td>
    </tr>
    <tr>
       <td>' . $presupuestosproveedore['Presupuestosproveedore']['serie'] . '</td>
       <td>' . zerofill($presupuestosproveedore['Presupuestosproveedore']['numero']) . '</td>
       <td>' . $this->Time->format('d-m-Y', $presupuestosproveedore['Presupuestosproveedore']['fecha']) . '</td>
       <td>' . '' . '</td>
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
        <tr><td class="nombre_cliente">PROVEEDOR: ' . $presupuestosproveedore['Proveedore']['nombre'] . '</td></tr>
        <tr><td class="cif">CIF: ' . $presupuestosproveedore['Proveedore']['cif'] . '</td></tr>
        <tr><td>' . $presupuestosproveedore['Proveedore']['direccion'] . '</td></tr>
        <tr><td>' . $presupuestosproveedore['Proveedore']['cp'] . '  ' . $presupuestosproveedore['Proveedore']['poblacion'] . '</td></tr>
        <tr><td>' . $presupuestosproveedore['Proveedore']['provincia'] . '</td></tr>
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
        <tr><td class="negrita">DIRECCIÓN DE ENVIO: ' . $presupuestosproveedore['Almacene']['nombre'] . '</td></tr>
        <tr><td> ' . $presupuestosproveedore['Almacene']['direccion'] . '</td></tr>
        <tr><td> ' . $presupuestosproveedore['Almacene']['telefono'] . '</td></tr>
        <tr><td> ' . '' . '</td></tr>
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
            <td colspan="2"><span>FORMA DE PAGO: </span>' . $presupuestosproveedore['Proveedore']['Formapago']['nombre'] . '</td>
            <td><span>ATENDIDO POR: </span>' . '' . '</td>
        </tr>
        <tr>
            <td><span>AGENCIA TPTES.: </span>' . $presupuestosproveedore['Presupuestosproveedore']['agenciadetransporte'] . '</td>
            <td><span>PORTES: </span>' . $presupuestosproveedore['Presupuestosproveedore']['portes'] . '</td>
        </tr>
        <tr>
            <td colspan="3"><span>OBSERVACIONES: </span>' . $presupuestosproveedore['Presupuestosproveedore']['observaciones'] . '</td>
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
foreach ($presupuestosproveedore['ArticulosPresupuestosproveedore'] as $ArticulosPresupuestosproveedore) {
    $lineas .= '<tr>';
    $lineas .= '<td>' . $ArticulosPresupuestosproveedore['Articulo']['ref'] . '</td>';
    $lineas .= '<td>' . $ArticulosPresupuestosproveedore['Articulo']['nombre'] . '</td>
        <td>' . number_to_comma($ArticulosPresupuestosproveedore['cantidad']) . '</td>';
    $lineas .='<td>' . number_to_comma($ArticulosPresupuestosproveedore['precio_proveedor']) . '</td>';
     $lineas .='<td>' . number_to_comma($ArticulosPresupuestosproveedore['descuento']) . ' %</td>';
   $lineas .='<td>' . number_to_comma($ArticulosPresupuestosproveedore['total']) . '</td></tr>';
    $total +=$ArticulosPresupuestosproveedore['total'];
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
                        <td class="precio">' . number_to_comma($total * ($presupuestosproveedore['Tiposiva']['porcentaje_aplicable'] / 100)) . ' €</td>
                        <td class="nombre">TOTAL PRESUPUESTO</td>
                        <td class="precio">' . number_to_comma($total + ($total * ($presupuestosproveedore['Tiposiva']['porcentaje_aplicable'] / 100))) . ' €</td>
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
$pdf->Output('presupuestoproveedor.pdf', 'I');
?>