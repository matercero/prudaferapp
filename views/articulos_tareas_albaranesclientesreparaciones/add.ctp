<?php echo $this->Form->create('ArticulosTareasAlbaranesclientesreparacione'); ?>
<fieldset>
    <legend><?php __('Añadir Artículo a la Tarea del Albarán'); ?></legend>
    <?php 
    echo $this->Autocomplete->replace_select('Articulo', null, true,$tarea['Albaranesclientesreparacione']['almacene_id']);
    echo $this->Form->input('numero_tarea', array('label' => 'Número del Parte'));
    echo $this->Form->input('tareas_albaranesclientesreparacione_id', array('type' => 'hidden', 'value' => $tareas_albaranesclientesreparacione_id));
    echo $this->Form->input('precio_unidad',array('label'=>'Precio Unidad'));
    echo $this->Form->input('cantidadreal',array('label'=>'Cantidad Real'));
    echo $this->Form->input('cantidad',array('label' => 'Cantidad Imputable'));
    echo $this->Form->input('descuento',array('label' => 'Descuento','value' =>$descuento));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Guardar', true)); ?>