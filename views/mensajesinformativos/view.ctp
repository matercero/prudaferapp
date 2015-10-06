<div class="mensajesinformativos view">
<h2><?php  __('Mensajesinformativo');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mensajesinformativo['Mensajesinformativo']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mensaje'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mensajesinformativo['Mensajesinformativo']['mensaje']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mensajesinformativo', true), array('action' => 'edit', $mensajesinformativo['Mensajesinformativo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Mensajesinformativo', true), array('action' => 'delete', $mensajesinformativo['Mensajesinformativo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mensajesinformativo['Mensajesinformativo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Mensajesinformativos', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mensajesinformativo', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Presupuestosclientes', true), array('controller' => 'presupuestosclientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Presupuestoscliente', true), array('controller' => 'presupuestosclientes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Presupuestosclientes');?></h3>
	<?php if (!empty($mensajesinformativo['Presupuestoscliente'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Serie'); ?></th>
		<th><?php __('Numero'); ?></th>
		<th><?php __('Comerciale Id'); ?></th>
		<th><?php __('Fecha'); ?></th>
		<th><?php __('Fecha Enviado'); ?></th>
		<th><?php __('Avisar'); ?></th>
		<th><?php __('Observaciones'); ?></th>
		<th><?php __('Precio Mat'); ?></th>
		<th><?php __('Precio Obra'); ?></th>
		<th><?php __('Precio'); ?></th>
		<th><?php __('Impuestos'); ?></th>
		<th><?php __('Avisosrepuesto Id'); ?></th>
		<th><?php __('Ordene Id'); ?></th>
		<th><?php __('Avisostallere Id'); ?></th>
		<th><?php __('Tiposiva Id'); ?></th>
		<th><?php __('Presupuestosproveedore Id'); ?></th>
		<th><?php __('Cliente Id'); ?></th>
		<th><?php __('Centrostrabajo Id'); ?></th>
		<th><?php __('Maquina Id'); ?></th>
		<th><?php __('Almacene Id'); ?></th>
		<th><?php __('Confirmado'); ?></th>
		<th><?php __('Mensajesinformativo Id'); ?></th>
		<th><?php __('Estadospresupuestoscliente Id'); ?></th>
		<th><?php __('Presupuestoescaneado'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mensajesinformativo['Presupuestoscliente'] as $presupuestoscliente):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $presupuestoscliente['id'];?></td>
			<td><?php echo $presupuestoscliente['serie'];?></td>
			<td><?php echo $presupuestoscliente['numero'];?></td>
			<td><?php echo $presupuestoscliente['comerciale_id'];?></td>
			<td><?php echo $presupuestoscliente['fecha'];?></td>
			<td><?php echo $presupuestoscliente['fecha_enviado'];?></td>
			<td><?php echo $presupuestoscliente['avisar'];?></td>
			<td><?php echo $presupuestoscliente['observaciones'];?></td>
			<td><?php echo $presupuestoscliente['precio_mat'];?></td>
			<td><?php echo $presupuestoscliente['precio_obra'];?></td>
			<td><?php echo $presupuestoscliente['precio'];?></td>
			<td><?php echo $presupuestoscliente['impuestos'];?></td>
			<td><?php echo $presupuestoscliente['avisosrepuesto_id'];?></td>
			<td><?php echo $presupuestoscliente['ordene_id'];?></td>
			<td><?php echo $presupuestoscliente['avisostallere_id'];?></td>
			<td><?php echo $presupuestoscliente['tiposiva_id'];?></td>
			<td><?php echo $presupuestoscliente['presupuestosproveedore_id'];?></td>
			<td><?php echo $presupuestoscliente['cliente_id'];?></td>
			<td><?php echo $presupuestoscliente['centrostrabajo_id'];?></td>
			<td><?php echo $presupuestoscliente['maquina_id'];?></td>
			<td><?php echo $presupuestoscliente['almacene_id'];?></td>
			<td><?php echo $presupuestoscliente['confirmado'];?></td>
			<td><?php echo $presupuestoscliente['mensajesinformativo_id'];?></td>
			<td><?php echo $presupuestoscliente['estadospresupuestoscliente_id'];?></td>
			<td><?php echo $presupuestoscliente['presupuestoescaneado'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'presupuestosclientes', 'action' => 'view', $presupuestoscliente['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'presupuestosclientes', 'action' => 'edit', $presupuestoscliente['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'presupuestosclientes', 'action' => 'delete', $presupuestoscliente['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $presupuestoscliente['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Presupuestoscliente', true), array('controller' => 'presupuestosclientes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
