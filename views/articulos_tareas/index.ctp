<div class="articulosTareas index">
    <h2><?php __('Articulos Tareas'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('articulo_id'); ?></th>
            <th><?php echo $this->Paginator->sort('tarea_id'); ?></th>
            <th><?php echo $this->Paginator->sort('cantidad'); ?></th>
            <th class="actions"><?php __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($articulosTareas as $articulosTarea):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $articulosTarea['ArticulosTarea']['id']; ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($articulosTarea['Articulo']['nombre'], array('controller' => 'articulos', 'action' => 'view', $articulosTarea['Articulo']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($articulosTarea['Tarea']['id'], array('controller' => 'tareas', 'action' => 'view', $articulosTarea['Tarea']['id'])); ?>
                </td>
                <td><?php echo $articulosTarea['ArticulosTarea']['cantidad']; ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View', true), array('action' => 'view', $articulosTarea['ArticulosTarea']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $articulosTarea['ArticulosTarea']['id'])); ?>
                    <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $articulosTarea['ArticulosTarea']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $articulosTarea['ArticulosTarea']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New Articulos Tarea', true), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Articulos', true), array('controller' => 'articulos', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Articulo', true), array('controller' => 'articulos', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Tareas', true), array('controller' => 'tareas', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Tarea', true), array('controller' => 'tareas', 'action' => 'add')); ?> </li>
    </ul>
</div>