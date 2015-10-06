<div class="familias form">
<?php echo $this->Form->create('Familia');?>
	<fieldset>
 		<legend><?php __('Añadir Familia'); ?></legend>
	<?php
		echo $this->Form->input('nombre',array('label'=>'Nombre'));
		echo $this->Form->input('descripcion',array('label'=>'Descripción'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Añadir', true));?>
</div>
<div class="actions">
	<h3><?php __('Acciones'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Listar Familias', true), array('action' => 'index'));?></li>
	</ul>
</div>
