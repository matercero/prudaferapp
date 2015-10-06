<div class="seriespresupuestosventas">
    <?php echo $this->Form->create('Seriespresupuestosventa'); ?>
    <fieldset>
        <legend>
            <?php __('Nueva Serie para Presupuestos de Venta'); ?>
            <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <?php
        echo $this->Form->input('serie');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>