<div class="articulosReferenciasintercambiables form">
<?php echo $this->Form->create('ArticulosReferenciasintercambiable');?>
	<fieldset>
 		<legend><?php __('Edit Articulos Referenciasintercambiable'); ?></legend>
	<?php
		echo $this->Form->input('articulo_id');
		echo $this->Form->input('referenciasintercambiable_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ArticulosReferenciasintercambiable.articulo_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ArticulosReferenciasintercambiable.articulo_id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Articulos Referenciasintercambiables', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Articulos', true), array('controller' => 'articulos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Articulo', true), array('controller' => 'articulos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Referenciasintercambiables', true), array('controller' => 'referenciasintercambiables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Referenciasintercambiable', true), array('controller' => 'referenciasintercambiables', 'action' => 'add')); ?> </li>
	</ul>
</div>