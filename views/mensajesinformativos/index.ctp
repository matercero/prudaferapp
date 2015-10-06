<div>
    <h2>
        <?php __('Mensajes Informativos'); ?>
        <?php echo $this->Html->link(__('Nuevo Mensaje Informativo', true), array('action' => 'add'),array('class' => 'button_link')); ?>
    </h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('mensaje'); ?></th>
            <th class="actions"><?php __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($mensajesinformativos as $mensajesinformativo):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $mensajesinformativo['Mensajesinformativo']['id']; ?>&nbsp;</td>
                <td><?php echo $mensajesinformativo['Mensajesinformativo']['mensaje']; ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $mensajesinformativo['Mensajesinformativo']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $mensajesinformativo['Mensajesinformativo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mensajesinformativo['Mensajesinformativo']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% fileas de %count% , comenzando en la fila %start%, finalizando en la %end%', true)
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>