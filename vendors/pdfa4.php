<?php

App::import('Vendor', 'tcpdf/tcpdf');

class PDFA4 extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = './img/dafer_pdf.jpg';
        $this->Image($image_file, 10, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 15);
        // Title
        $this->Cell(100, 15, 'TALLERES DAFER S.L.', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        //Direccion Moron
        $this->SetFont('helvetica', 'B', 6);
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
        $this->writeHTMLCell('', '', 65, 13, $html, $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true);
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
        $this->writeHTMLCell('', '', 115, 13, $html, $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true);
        //Partners
        $image_file = './img/servicio_oficial.jpg';
        $this->Image($image_file, 150, 5, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Page number
        $this->SetY(-5);
        $this->SetFont('helvetica', 'I', 7);
        $this->Cell('', '', ' ( Inscrita en el Registro Mercantil de Sevilla, Tomo 4225, Libro 0, Sección 8ª, Folio 1, Hoja SE 63.758, Inscripción 1ª, C.I.F.B-91/475319 )' . 'Pag. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

?>