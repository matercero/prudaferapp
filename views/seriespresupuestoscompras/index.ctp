<div class="seriespresupuestoscompras">
    <h2>
        <?php __('Series de Presupuestos de Compra'); ?>
        <?php echo $this->Html->link(__('Nueva', true), array('action' => 'add'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Ir a Configuración', true), array('controller' => 'configs', 'action' => 'edit', 1), array('class' => 'button_link')); ?> 
    </h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('serie'); ?></th>
            <th class="actions"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($seriespresupuestoscompras as $seriespresupuestoscompra):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $seriespresupuestoscompra['Seriespresupuestoscompra']['serie']; ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $seriespresupuestoscompra['Seriespresupuestoscompra']['id'])); ?>
                    <?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $seriespresupuestoscompra['Seriespresupuestoscompra']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de %count% en total, comenzando en el registro %start%, finalizando en %end%', true)
        ));
        ?>	
    </p>
    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>