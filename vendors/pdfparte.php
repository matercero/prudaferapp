<?php

App::import('Vendor', 'tcpdf/tcpdf');

class PDFPARTE extends TCPDF {

    //Page header
    public function Header() {
        // Logo
    }

    // Page footer
    public function Footer() {
    }

}

?>