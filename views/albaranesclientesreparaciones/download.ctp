<?php $line = array('FECHA', 'SERIE', 'numero', 'Comercial', 'Observaciones', 'Estado', 'Nº_factura', 'Cliente', 'Centrostrabajo', 'Máquina', 'numero_aceptacion_aportado', 'horas_maquina', 'total_materiales', 'total_manoobra', 'baseimponible', 'Orden_numero', 'Orden descripcion', 'Tareas descripción');
$this->Csv->addRow($line);
foreach ($albaranes as $item) {
    $line = array($item['Albaranesclientesreparacione']['fecha'],
        $item['Albaranesclientesreparacione']['serie'],
        $item['Albaranesclientesreparacione']['numero'],
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
        $item['Albaranesclientesreparacione']['baseimponible'],
        $item['Ordene']['numero'],
        $item['Ordene']['descripcion']
    );

    if (!empty($item['TareasAlbaranesclientesreparacione'])) {
        if (count($item['TareasAlbaranesclientesreparacione']) == 1) {
            array_push($line, $item['TareasAlbaranesclientesreparacione'][0]['descripcion']);            
        }  else {
            $i=0;
            foreach ($item['TareasAlbaranesclientesreparacione'] as $tarea) {
                array_push($line, $item['TareasAlbaranesclientesreparacione'][$i]['descripcion']);                                        
            }
        }        
    }

    $this->Csv->addRow($line);
}
echo $this->Csv->render();
?>


