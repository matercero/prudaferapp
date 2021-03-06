<?php echo $this->Form->create('ArticulosTarea', array('action' => 'add')); ?>
<fieldset>
    <legend><?php __('Añadir Artículo a la Tarea'); ?></legend>
    <?php
    echo $this->Autocomplete->replace_select('Articulo', null, true, $tarea['Ordene']['almacene_id']);
    ?>
    <p>Existencias: <span id="stock"></span></p>
    <?php
    echo $this->Form->input('numero_tarea', array('label' => 'Número del Parte'));
    echo $this->Form->input('tarea_id', array('type' => 'hidden', 'value' => $tarea_id));
    echo $this->Form->input('precio_unidad', array('label' => 'Precio Unidad','readonly'=>False,'default'=>0));
    echo $this->Form->input('cantidadreal', array('label' => 'Cantidad Real','default'=>0));
    echo $this->Form->input('cantidad', array('label' => 'Cantidad Imputable','default'=>0));
    echo $this->Form->input('descuento', array('label' => 'Descuento', 'value' => $descuento));
    ?>
</fieldset>
<?php echo $this->Ajax->submit(__('Guardar y Nuevo', true), array('url' => array('controller'=>'articulos_tareas','action' => 'add_ajax', $tarea_id), 'update' => 'dialog-modal')); ?>
<?php echo $this->Form->end(__('Guardar y Cerrar', true)); ?>