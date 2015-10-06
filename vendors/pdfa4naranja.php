<?php

App::import('Vendor', 'tcpdf/tcpdf');

class PDFA4NARANJA extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = './img/dafer-cabecera.jpeg';
        $this->Image($image_file, 0, 0, 210, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 15);
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