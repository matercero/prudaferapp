<div class="seriespresupuestoscompras">
    <?php echo $this->Form->create('Seriespresupuestoscompra'); ?>
    <fieldset>
        <legend>
            <?php __('Nueva Serie para Presupuesto de Compra'); ?>
            <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <?php
        echo $this->Form->input('serie');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>