<?php

App::import('Vendor', 'concat_pdf');
// create new PDF document
$pdf = new concat_pdf();
$templatefile = 'Presupuesto.pdf';
$pdf->setFiles(array('../webroot/files/partestallere/' . $templatefile));
$pdf->concat();
$pdf->Output('prueba.pdf', 'I');
die();

?>