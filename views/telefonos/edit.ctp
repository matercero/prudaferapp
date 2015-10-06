<div class="Telefono">
<?php echo $this->Form->create('Telefono');?>
	<fieldset>
 		<legend><?php __('Edit Telefono'); ?></legend>
	<?php
		echo $this->Form->input('nombre');
		echo $this->Form->input('telefeno');
		echo $this->Form->input('e-mail');
    if (!empty($transportista_id))
        echo $this->Form->input('transportista_id', array('type' => 'hidden', 'value' => $transportista_id));
    if (!empty($centrostrabajo_id))
        echo $this->Form->input('centrostrabajo_id', array('type' => 'hidden', 'value' => $centrostrabajo_id));
    if (!empty($cliente_id))
        echo $this->Form->input('cliente_id', array('type' => 'hidden', 'value' => $cliente_id));
    if (!empty($proveedore_id))
        echo $this->Form->input('proveedore_id', array('type' => 'hidden', 'value' => $proveedore_id));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Guardar', true)); ?>
</div>
