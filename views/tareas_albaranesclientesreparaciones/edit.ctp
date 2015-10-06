<?php echo $this->Form->create('TareasAlbaranesclientesreparacione'); ?>
<fieldset>
    <legend><?php __('Editando Nueva Tarea al Albarán de Reparación'); ?></legend>
    <label>Tipo de Tarea</label>
    <?php
    $options = array('taller' => 'En taller', 'centro' => 'En el Centro de Trabajo');
    echo $this->Form->select('tipo',array('type'=>'select','options'=>$options,'empty' => False));
    ?>
    <?php
    echo $this->Form->input('tareas_albaranesclientesreparacione_id',array('type'=>'hidden'));
    echo $this->Form->input('numero');
    echo $this->Form->input('descripcion');
    ?>
</fieldset>
<?php echo $this->Form->end(__('Guardar', true)); ?>