<div>
    <?php echo $this->Form->create('Mensajesinformativo'); ?>
    <fieldset>
        <legend>
            <?php __('Editar Mensajes Informativo'); ?>
            <?php echo $this->Html->link(__('Borrar', true), array('action' => 'delete', $this->Form->value('Mensajesinformativo.id')),array('class' => 'button_link'), sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Mensajesinformativo.id'))); ?>
            <?php echo $this->Html->link(__('Listar Mensajes Informativos', true), array('action' => 'index'),array('class' => 'button_link')); ?>

        </legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('mensaje');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>