<div class="seriesalbaranescompras">
    <?php echo $this->Form->create('Seriesalbaranescompra'); ?>
    <fieldset>
        <legend>
            <?php __('Nueva Serie para Albaranes de Compra'); ?>
            <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <?php
        echo $this->Form->input('serie');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>