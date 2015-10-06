<?php echo $this->Form->create('Tarea'); ?>
<fieldset>
    <legend><?php __('Editando la Tarea'); ?></legend>
    <label>Tipo de Tarea</label>
    
    <?php
    echo $this->Form->input('numero');
    ?>
    <?php
    $options = array('taller' => 'En taller', 'centro' => 'En el Centro de Trabajo');
    echo $this->Form->input('tipo',array('empty' => False,'options'=>$options));
    ?>
    <?php
    echo $this->Form->input('descripcion');
    ?>
</fieldset>
<?php echo $this->Form->end(__('Guardar', true)); ?>