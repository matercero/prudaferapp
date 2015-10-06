<div class="seriespedidosventas">
    <?php echo $this->Form->create('Seriespedidosventa'); ?>
    <fieldset>
        <legend>
            <?php __('Nueva Serie para Pedidos de Venta'); ?>
            <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <?php
        echo $this->Form->input('serie');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>