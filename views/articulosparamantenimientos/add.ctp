<?php echo $this->Form->create('Articulosparamantenimiento',array('action' => 'add')); ?>
<fieldset>
    <legend><?php __('Añadir Artículo para Mantenimiento'); ?></legend>
    <?php
    echo $this->Autocomplete->replace_select('Articulo', null, true, null);
    echo $this->Form->input('maquina_id', array('type' => 'hidden', 'value' => $maquina_id));
    echo $this->Form->input('cantidad',array('default'=>0));
    echo $this->Form->input('precio_sin_iva',array('default'=>0));
    echo $this->Form->input('C_Horas',array('default'=>500));
    ?>
</fieldset>
<?php echo $this->Ajax->submit(__('Guardar y Nuevo', true), array('url' => array('controller'=>'articulosparamantenimientos','action' => 'add_ajax', $maquina_id), 'update' => 'dialog-modal')); ?>
<?php echo $this->Form->end(__('Guardar y Cerrar', true)); ?>
