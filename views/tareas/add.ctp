<?php echo $this->Form->create('Tarea'); ?>
<fieldset>
    <legend><?php __('Añadir nueva tarea'); ?></legend>
    <?php
    if (isset($ordene)) {
        echo $this->Form->label('Nº de Orden de Taller');
        echo $ordene['Ordene']['id'] . '<br><br>';
        echo '<input type="hidden" value="' . $ordene['Ordene']['id'] . '" name="ordene_id"/>';
    }
    ?>
    <label>Tipo de Tarea</label>
    <?php
    $options = array( 'centro' => 'En el Centro de Trabajo','taller' => 'En taller');
    echo $this->Form->input('tipo',array('empty' => False,'options'=>$options));
    ?>
    <br/><br/>
    <?php
    echo $this->Form->input('numero',array('default'=>$numero));
    echo $this->Form->input('descripcion');
    ?>
</fieldset>
<?php echo $this->Form->end(__('Guardar', true)); ?>