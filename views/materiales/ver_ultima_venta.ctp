<?php if (!empty($materiale['MaterialesTareasalbaranescliente']['precio_unidad'])): ?>
    <p style="font-size: 2.5em; text-align: center;"><?php echo $materiale['MaterialesTareasalbaranescliente']['precio_unidad']-($materiale['MaterialesTareasalbaranescliente']['precio_unidad']*$materiale['MaterialesTareasalbaranescliente']['descuento']/100 )?> &euro;</p>
    <p style="font-size: 1.4em; text-align: center; color: #3AA29C">Fecha: <?php echo $materiale['Tareasalbaranescliente']['Albaranescliente']['fecha'] ?></p>
    <p style="font-size: 1.4em; text-align: center; color: #3AA29C">Ver Albarán: <?php echo $this->Html->link($materiale['Tareasalbaranescliente']['Albaranescliente']['numero'], array('controller' => 'albaranesclientes', 'action' => 'view', $materiale['Tareasalbaranescliente']['Albaranescliente']['id'])) ?></p>
<?php else: ?>
    <p style="font-size: 2.5em; text-align: center;">No se ha encontrado última venta</p>
<?php endif; ?>
