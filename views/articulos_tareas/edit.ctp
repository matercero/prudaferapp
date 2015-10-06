<?php echo $this->Form->create('ArticulosTarea'); ?>
<fieldset>
    <legend><?php __('Editar Artículo de la Tarea'); ?></legend>
    <label>Articulo: <?php echo $this->Form->value('Articulo.nombre') ?></label>
    <p>Existencias: <span id="stock"><?php echo $this->Form->value('Articulo.existencias') ?></span></p>
    <?php 
    echo $this->Form->input('numero_tarea', array('label' => 'Número del Parte'));
    echo $this->Form->input('precio_unidad', array('label' => 'Precio Unidad','readonly'=>false));
    echo $this->Form->input('cantidadreal',array('label'=>'Cantidad Real'));
    echo $this->Form->input('cantidad',array('label' => 'Cantidad Imputable'));
    echo $this->Form->input('descuento',array('label' => 'Descuento'));
    echo $this->Form->input('id');
    echo $this->Form->input('articulo_id',array('type'=>'hidden','label'=>False));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Guardar', true)); ?>