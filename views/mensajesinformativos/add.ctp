<?php echo $this->Form->create('Mensajesinformativo');?>
	<fieldset>
 		<legend>
                    <?php __('Nuevo Mensaje Informativo'); ?>
                    <?php echo $this->Html->link(__('Listar Mensajes Informativos', true), array('action' => 'index'),array('class' => 'button_link'));?>
                </legend>
	<?php
		echo $this->Form->input('mensaje');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar', true));?>