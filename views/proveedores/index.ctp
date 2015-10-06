<div class="proveedores">
    <h2>
        <?php __('Proveedores'); ?>
        <?php echo $this->Html->link(__('Nuevo proveedor', true), array('action' => 'add'), array('class' => 'button_link')); ?>
		<?php echo $this->Html->link(__('Listar Proveedores', true), array('action' => 'index'), array('class' => 'button_link')); ?> 
    </h2>
    <div id="search_form" class="edit">
        <?php echo $this->Form->create('Proveedores', array('type' => 'get')) ?>
        <?php
        array_shift($this->params['url']);
        array_shift($this->params['url']);
        if (!empty($this->params['url'])) {
            $this->Paginator->options(array('url' => $this->params['url']));
        }
        ?>
        <table class="view">
            <tr>
                <?php if (!empty($this->params['named']['nombre_cif'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre_cif', array('label' => 'Búsqueda en CIF o Nombre', 'style' => 'width: 600px;', 'value' => $this->params['named']['nombre_cif'])) ?></td>
                <?php elseif (!empty($this->params['url']['nombre_cif'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre_cif', array('label' => 'Búsqueda en CIF o Nombre', 'style' => 'width: 600px;', 'value' => $this->params['url']['nombre_cif'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre_cif', array('label' => 'Búsqueda en CIF o Nombre', 'style' => 'width: 600px;')) ?></td>
                <?php endif; ?>
                
                <?php if (!empty($this->params['named']['proveedoresde'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.proveedoresde', array('label' => 'Proveedores de(material)', 'value' => $this->params['named']['proveedoresde'])) ?></td>
                <?php elseif (!empty($this->params['url']['nombre'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.proveedoresde', array('label' => 'Proveedores de(material)', 'value' => $this->params['url']['proveedoresde'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.proveedoresde', array('label' => 'Proveedores de',)) ?></td>
                <?php endif; ?>
                
                 <?php if (!empty($this->params['named']['observaciones'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.observaciones', array('label' => 'Observaciones', 'value' => $this->params['named']['observaciones'])) ?></td>
                <?php elseif (!empty($this->params['url']['nombre'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.observaciones', array('label' => 'Observaciones', 'value' => $this->params['url']['observaciones'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.observaciones', array('label' => 'Observaciones',)) ?></td>
                <?php endif; ?>

            <?php if (!empty($this->params['named']['resultados_por_pagina'])): ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '40' => 40, '60' => 60, '80' => 80), 'default' => '20', 'selected' => $this->params['named']['resultados_por_pagina'])) ?></td>
            <?php elseif (!empty($this->params['url']['resultados_por_pagina'])): ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '40' => 40, '60' => 60, '80' => 80), 'default' => '20', 'selected' => $this->params['url']['resultados_por_pagina'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '40' => 40, '60' => 60, '80' => 80), 'default' => '20')) ?></td>
            <?php endif; ?>

            </tr>
        </table>
        <?php echo $this->Form->button('Nueva Búsqueda', array('type' => 'reset', 'class' => 'button_css_green')); ?>
        <?php echo $this->Form->end(array('label' => 'Buscar', 'div' => True, 'class' => 'button_css_blue')) ?>
    </div>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de un total de %count%, empezando en registro %start%, finalizando en el registro %end%', true)
        ));
        ?>
    </p>
    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('CIF', 'cif'); ?></th>
            <th><?php echo $this->Paginator->sort('Nombre', 'nombre'); ?></th>
            <th><?php echo $this->Paginator->sort('Proveedores de', 'proveedoresde'); ?></th>
            <th><?php echo $this->Paginator->sort('Observaciones', 'observaciones'); ?></th>
            <th><?php echo $this->Paginator->sort('Teléfono', 'telefono'); ?></th>
            <th class="actions"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($proveedores as $proveedore):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $proveedore['Proveedore']['cif']; ?>&nbsp;</td>
                <td><?php echo $proveedore['Proveedore']['nombre']; ?>&nbsp;</td>
                <td><?php echo $proveedore['Proveedore']['proveedoresde']; ?>&nbsp;</td>
                <td><?php echo $proveedore['Proveedore']['observaciones']; ?>&nbsp;</td>
                <td><?php echo $proveedore['Proveedore']['telefono']; ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $html->link(__('Editar', true), array('action' => 'edit', $proveedore['Proveedore']['id'])); ?>
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $proveedore['Proveedore']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $proveedore['Proveedore']['id']), null, sprintf(__('Está seguro que desea eliminar el proveedor # %s?', true), $proveedore['Proveedore']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de un total de %count%, empezando en registro %start%, finalizando en el registro %end%', true)
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
