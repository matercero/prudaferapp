<?php

App::import('Vendor', 'tcpdf/tcpdf');

class PDFMOSTRADOR extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = './img/dafer_pdf_en_blanco.jpg';
        $this->Image($image_file, 10, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(100, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        //Direccion Moron
        $this->SetFont('helvetica', 'B', 6);
        $html = '<style>
            .header_direccion p {   
                line-height: 0.2em;
            }
            </style>
            <div class="header_direccion">
            <p> </p>
            <p> </p>
            <p> </p>
            <p> </p>
            <p> </p></div>';
        $this->writeHTMLCell('', '', 65, 13, $html, $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true);
        //Direccion Alcala
        $html = '<style>
            .header_direccion p {   
                line-height: 0.2em;
            }
            </style>
            <div class="header_direccion">
            <p> </p>
            <p> </p>
            <p> </p>
            <p> </p>
            <p> </p></div>';
        $this->writeHTMLCell('', '', 115, 13, $html, $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true);
        //Partners
        $image_file = './img/servicio_oficial_en_blanco.jpg';
        $this->Image($image_file, 150, 5, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Page number
        $this->SetY(-20);
        $this->SetFont('helvetica', 'I', 15);
        $this->Cell('', '', '' . 'Pag. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

?>
