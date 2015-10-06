<div>
    <p style="margin-bottom: 15px;font-style: italic;">* Solo se muestran los albaranes de compra confirmados que son posibles facturar.</p>
    <?php echo $this->Form->create('Facturasproveedore', array('action' => 'facturar')) ?>
    <?php echo $this->Form->submit('FACTURAR'); ?>
    <?php $factura_index = 0; ?>   
    <?php foreach ($proveedore_list as $nombre => $proveedore): ?>
        <h4>Posible Factura:  <?php echo $nombre ?> - Número Factura Aportado: <?php echo $this->Form->input('numero_factura_aportado', array('name' => 'data[facturable][' . $factura_index . '][numero_factura_aportado]','label' =>False, 'type' => 'text','div' => False,'style'=>'font-size: 0.8em;width: 100px; height: 20px; padding: 0;margin:0;')) ?> - Fecha: <?php echo $this->Form->input('fechafactura', array('name' => 'data[facturable][' . $factura_index . '][fechafactura][]','label' =>False,'div'=>False, 'type' => 'date', 'dateFormat' => 'DMY',)); ?></h4>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th>Serie</th>
                <th>Nº Albarán</th>
                <th>Fecha</th>
                <th>Nº Albarán Aportado</th>
                <th>Centro de Coste</th>
                <th>Base Imponible</th>
                <th>Impuestos</th>
                <th>Total</th>
                <th>Observaciones</th>
                <th>Albarán Escaneado</th>
                <th>Marcar</th>
            </tr>
            <?php
            $i = 0;
            $baseimponible_total = 0;
            $impuestos_total = 0;
            $total_total = 0;
            foreach ($proveedore as $albaranesproveedore):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>
                    <td><?php echo $albaranesproveedore['Albaranesproveedore']['serie']; ?>&nbsp;</td>
                    <td><?php echo $this->Html->link($albaranesproveedore['Albaranesproveedore']['numero'], array('controller' => 'albaranesproveedores', 'action' => 'view', $albaranesproveedore['Albaranesproveedore']['id'])); ?>&nbsp;</td>
                    <td><?php echo $this->Time->format('d-m-Y', $albaranesproveedore['Albaranesproveedore']['fecha']); ?>&nbsp;</td>
                    <td><?php echo $albaranesproveedore['Albaranesproveedore']['numero_albaran_proporcionado']; ?>&nbsp;</td>
                    <td><?php echo $albaranesproveedore['Centrosdecoste']['denominacion']; ?>&nbsp;</td>
                    <td><?php echo $albaranesproveedore['Albaranesproveedore']['baseimponible']; ?>&nbsp;</td>
                    <?php $baseimponible_total+= $albaranesproveedore['Albaranesproveedore']['baseimponible'];  ?> 
                    <td><?php echo redondear_dos_decimal($albaranesproveedore['Albaranesproveedore']['baseimponible']*$albaranesproveedore['Tiposiva']['porcentaje_aplicable']/100); ?>&nbsp;</td>
                    <?php $impuestos_total+=  $albaranesproveedore['Albaranesproveedore']['baseimponible']*$albaranesproveedore['Tiposiva']['porcentaje_aplicable']/100;  ?> 
                    <td><?php echo redondear_dos_decimal($albaranesproveedore['Albaranesproveedore']['baseimponible']+($albaranesproveedore['Albaranesproveedore']['baseimponible']*$albaranesproveedore['Tiposiva']['porcentaje_aplicable']/100)); ?>&nbsp;</td>
                    <?php $total_total+= $albaranesproveedore['Albaranesproveedore']['baseimponible']+($albaranesproveedore['Albaranesproveedore']['baseimponible']*$albaranesproveedore['Tiposiva']['porcentaje_aplicable']/100);  ?> 
                    <td><?php echo $albaranesproveedore['Albaranesproveedore']['observaciones']; ?>&nbsp;</td>
                    <td><?php echo $this->Html->link(__($albaranesproveedore['Albaranesproveedore']['albaranescaneado'], true), '/files/albaranesproveedore/' . $albaranesproveedore['Albaranesproveedore']['albaranescaneado']); ?></td>
                    <td><?php echo $this->Form->checkbox('marcado', array('name' => 'data[facturable][' . $factura_index . '][albaranes][]', 'hiddenField' => false, 'checked' => true, 'value' => $albaranesproveedore['Albaranesproveedore']['id'])) ?></td>
                </tr>
            <?php
            endforeach;
            $factura_index++;
            ?>
                <tr class="totales_pagina">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>TOTALES:</td>
                    <td><?php echo redondear_dos_decimal($baseimponible_total) ?></td>
                    <td><?php echo redondear_dos_decimal($impuestos_total) ?></td>
                    <td><?php echo redondear_dos_decimal($total_total) ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        </table>
    <?php endforeach; ?>
<?php echo $this->Form->end('FACTURAR'); ?>
</div>
