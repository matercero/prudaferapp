<?php

require_once("pdfa4.php");
require_once("fpdi/fpdi.php");
 
class concat_pdf extends FPDI {
     var $files = array();
     function setFiles($files) {
          $this->files = $files;
     }
     function concat() {
          foreach($this->files as $file) {
               $pagecount = $this->setSourceFile($file);
               for ($i = 1; $i <= $pagecount; $i++) {
                    $tplidx = $this->ImportPage($i);
                    $s = $this->getTemplatesize($tplidx);
                    $this->AddPage('P', 'A4');
                    $this->useTemplate($tplidx);
               }
          }
     }
}

?>
