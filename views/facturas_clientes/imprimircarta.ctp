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



   /* LA CARTA */
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->AddPage('', 'A4');

    $pdf->SetMargins(5, 28, PDF_MARGIN_RIGHT, true);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


//set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Logo
    $image_file = './img/dafer_pdf.jpg';
    $pdf->Image($image_file, 10, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    // Set font
    $pdf->SetFont('helvetica', 'B', 15);
    // Title
    $pdf->Cell(100, 15, 'TALLERES DAFER S.L.', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    //Direccion Moron
    $pdf->SetFont('helvetica', 'B', 6);
    $html = '<style>
            .header_direccion p {   
                line-height: 0.2em;
            }
            </style>
            <div class="header_direccion">
            <p>41530 - MORON (Sevilla )</p>
            <p>Polig.Industrial " Los Perales "</p>
            <p>C/Taranta, 9 - Tel. 95 485 04 40</p>
            <p>Fax.:954 85 27 41</p>
            <p>repuesto@talleresdafer.com</p></div>';
    $pdf->writeHTMLCell('', '', 65, 13, $html, $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true);
    //Direccion Alcala
    $html = '<style>
            .header_direccion p {   
                line-height: 0.2em;
            }
            </style>
            <div class="header_direccion">
            <p>41500 - Alcalá De Guadaira</p>
            <p>P. I. Recisur - C/ Píe sólo 6, no 27</p>
            <p>Tel. 95 485 04 40</p>
            <p>Fax.:954 10 28 82</p>
            <p>repuesto2@talleresdafer.com</p></div>';
    $pdf->writeHTMLCell('', '', 115, 13, $html, $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true);
    //Partners
    $image_file = './img/servicio_oficial.jpg';
    $pdf->Image($image_file, 150, 5, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    /*
     * Area de Cliente
     */
    $tbl = '
    <style>
        table.cliente {
            font-size: 1.5em;
            text-align: left;
            width: 380px;
            background-color: #f5f5f5;
            border: 1px solid #000000;
        }
        .cif, .nombre_cliente {
            font-weight: bolder;
        }
    </style>
   
    <table class="cliente">
        <tr><td class="nombre_cliente">CLIENTE: ' . $facturasCliente['Cliente']['nombre'] . '</td></tr>
        <tr><td>' . $facturasCliente['Cliente']['direccion_postal'] . '</td></tr>
        <tr><td>' . $facturasCliente['Cliente']['codigopostal'] . '  ' . $facturasCliente['Cliente']['poblacionpostal'] . '</td></tr>
        <tr><td>' . $facturasCliente['Cliente']['provinciapostal'] . '</td></tr>
    </table>
';
    $pdf->writeHTMLCell('', '', 100, 45, $tbl, 0, 1, 0, true, 'J', true);

    /*
     * Fin Area de Cliente
     */


    /* CUERPO */
    $pdf->writeHTMLCell('', '', '', 100, $config['Config']['cartafacturacion'], 0, 1, 0, true, 'J', true);
    /* FIN DE CUERPO */


    /* FIN DE LA CARTA */
    
$pdf->SetY(265, true, true);
$pdf->SetAutoPageBreak(FALSE, 10);
$pdf->SetY(-5);
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell('', '', ' ( Inscrita en el Registro Mercantil de Sevilla, Tomo 4225, Libro 0, Sección 8ª, Folio 1, Hoja SE 63.758, Inscripción 1ª, C.I.F.B-91/475319 )' . 'Pag. ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');


// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('carta.pdf', 'I');
?>
