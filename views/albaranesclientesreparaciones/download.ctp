<?php 
$line = array('FECHA', 'SERIE', 'numero', 'Orden_numero', 'Comercial', 'Observaciones', 'Estado', 'Nº_factura', 'Cliente', 'Centrostrabajo', 'Máquina', 'numero_aceptacion_aportado','horas_maquina', 
    'total_materiales','total_manoobra','baseimponible');
$this->Csv->addRow($line);

foreach ($albaranes as $item) {
    $line = array($item['Albaranesclientesreparacione']['fecha'],
        $item['Albaranesclientesreparacione']['serie'],
        $item['Albaranesclientesreparacione']['numero'],
        $item['Ordene']['numero'],
        $item['Comerciale']['nombre'],
        $item['Albaranesclientesreparacione']['observaciones'],
        $item['Estadosalbaranesclientesreparacione']['estado'],
        $item['FacturasCliente']['numero'],
        $item['Cliente']['nombre'],
        $item['Centrostrabajo']['centrotrabajo'],
        $item['Maquina']['nombre'],
        $item['Albaranesclientesreparacione']['numero_aceptacion_aportado'],
        $item['Albaranesclientesreparacione']['horas_maquina'],
        $item['Albaranesclientesreparacione']['total_materiales'],
        $item['Albaranesclientesreparacione']['total_manoobra'],
        $item['Albaranesclientesreparacione']['baseimponible']        
    );
    $this->Csv->addRow($line);
}
echo $this->Csv->render();


//echo '<pre>';
//echo var_dump($parametros);
//echo '</pre>';

?>


