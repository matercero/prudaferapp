<div class="seriesfacturascompras">
    <?php echo $this->Form->create('Seriesfacturascompra'); ?>
    <fieldset>
        <legend>
            <?php __('Nueva Serie para Facturas de Compra'); ?>
            <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <?php
        echo $this->Form->input('serie');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>