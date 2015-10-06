<div class="seriespedidoscompras">
    <?php echo $this->Form->create('Seriespedidoscompra'); ?>
    <fieldset>
        <legend>
            <?php __('Nueva Serie para Pedidos de Compra'); ?>
            <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <?php
        echo $this->Form->input('serie');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>