<?php echo $this->Form->create('Articulosparamantenimiento');?>
	<fieldset>
 		<legend><?php __('Editar Articulo para mantenimiento'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('articulo_id',array('type'=>'hidden'));
		echo $this->Form->input('maquina_id',array('type'=>'hidden'));
		echo $this->Form->input('cantidad');
		echo $this->Form->input('precio_sin_iva');
		echo $this->Form->input('C_Horas');	
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar', true));?>
