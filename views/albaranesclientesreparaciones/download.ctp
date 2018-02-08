<?php 
$line = array('FECHA', 'SERIE', 'numero', 'Orden_numero', 'Observaciones', 'Nº_factura', 'Cliente', 'Centrostrabajo', 'Máquina', 'horas_maquina', 'Avisostallere');
$this->Csv->addRow($line);

foreach ($albaranes as $item) {
    $line = array($item['Albaranesclientesreparacione']['fecha'],
        $item['Albaranesclientesreparacione']['serie'],
        $item['Albaranesclientesreparacione']['numero'],
        $item['Ordene']['numero'],
        $item['Albaranesclientesreparacione']['observaciones'],
        $item['FacturasCliente']['numero'],
        $item['Cliente']['nombre'],
        $item['Centrostrabajo']['centrotrabajo'],
        $item['Maquina']['nombre'],
        $item['Albaranesclientesreparacione']['horas_maquina'],
        $item['Ordene']['Avisostallere']['numero']
    );
    $this->Csv->addRow($line);
}
echo $this->Csv->render();


echo '<pre>';
echo var_dump($parametros);
echo '</pre>';

?>


