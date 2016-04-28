<div class="seriesfacturascompras">
    <?php echo $this->Form->create('Seriesfacturascompra'); ?>
    <fieldset>
        <legend>
            <?php __('Editando Serie de Facturas de Compra'); ?>
            <?php echo $this->Html->link(__('Borrar', true), array('action' => 'delete', $this->Form->value('Seriesfacturascompra.id')), array('class' => 'button_link'), sprintf(__('¿Seguro que quieres borrar la serie # %s?', true), $this->Form->value('Seriesfacturascompra.serie'))); ?>
            <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'),array('class' => 'button_link')); ?>
            <?php echo $this->Html->link(__('Ir a Configuración', true), array('controller' => 'configs', 'action' => 'edit',1),array('class' => 'button_link')); ?> 
        </legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('serie');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>