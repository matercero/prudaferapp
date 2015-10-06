<div class="clientes">
    <h2>
        <?php __('Maestro de Clientes'); ?>
        <?php echo $html->link(__('Nuevo Cliente', true), array('action' => 'add'), array('class' => 'button_link')); ?>
    </h2>
    <div id="search_form" class="edit">
        <?php echo $this->Form->create('Cliente', array('type' => 'get')) ?>
        <?php
        array_shift($this->params['url']);
        array_shift($this->params['url']);
        if (!empty($this->params['url'])) {
            $this->Paginator->options(array('url' => $this->params['url']));
        }
        ?>
        <table class="view">
            <tr>
                <?php if (!empty($this->params['named']['nombre'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre', array('label' => 'Nombre', 'value' => $this->params['named']['nombre'], 'style' => 'width: 400px;')) ?></td>
                <?php elseif (!empty($this->params['url']['nombre'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre', array('label' => 'Nombre', 'value' => $this->params['url']['nombre'], 'style' => 'width: 400px;')) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre', array('label' => 'Nombre', 'style' => 'width: 400px;')) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['cif'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.cif', array('label' => 'CIF', 'value' => $this->params['named']['cif'], 'style' => 'width: 400px;')) ?></td>
                <?php elseif (!empty($this->params['url']['cif'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.cif', array('label' => 'CIF', 'value' => $this->params['url']['cif'], 'style' => 'width: 400px;')) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.cif', array('label' => 'CIF', 'style' => 'width: 400px;')) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['riesgos'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.riesgos', array('label' => 'Riesgos', 'value' => $this->params['named']['riesgos'], 'style' => 'width: 400px;')) ?></td>
                <?php elseif (!empty($this->params['url']['riesgos'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.riesgos', array('label' => 'Riesgos', 'value' => $this->params['url']['riesgos'], 'style' => 'width: 400px;')) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.riesgos', array('label' => 'Riesgos', 'style' => 'width: 400px;')) ?></td>
                <?php endif; ?>
                
                <?php if (!empty($this->params['named']['resultados_por_pagina'])): ?>
                    <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000), 'default' => '20', 'selected' => $this->params['named']['resultados_por_pagina'])) ?></td>
                <?php elseif (!empty($this->params['url']['resultados_por_pagina'])): ?>
                    <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000), 'default' => '20', 'selected' => $this->params['url']['resultados_por_pagina'])) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000), 'default' => '20')) ?></td>
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
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        |	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>

            <th><?php echo $paginator->sort('CIF','cif'); ?></th>
            <th><?php echo $paginator->sort('Nombre Comercial','nombre'); ?></th>
            <th><?php echo $paginator->sort('Riesgos','riesgos'); ?></th>
            <th><?php echo $paginator->sort('Teléfono','telefono'); ?></th>
            <th><?php echo $paginator->sort('Forma de pago'); ?></th>
            <th><?php echo $paginator->sort('Email','email'); ?></th>
            <th class="actions"><div align="center"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($clientes as $cliente):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>

                <td>
                    <?php echo $cliente['Cliente']['cif']; ?>
                </td>
                <td>
                    <?php echo $cliente['Cliente']['nombre']; ?>
                </td>              
                <td>                
                    <?php echo $cliente['Cliente']['riesgos']== 0 ? 'No' : '<span style="color: red">SUPERADO</span>'; ?>
                </td>
                <td>
                    <?php echo $cliente['Cliente']['telefono']; ?>
                </td>
                <td>
                    <?php echo $cliente['Formapago']['nombre']; array('controller' => 'formapagos', 'action' => 'view', $cliente['Formapago']['nombre']); ?>
                </td>
                 <td>
                    <?php echo $cliente['Cliente']['email']; ?>
                </td>
                <td class="actions">
                    <?php echo $html->link(__('Editar', true), array('action' => 'edit', $cliente['Cliente']['id'])); ?>
                    <?php echo $html->link(__('Ver', true), array('action' => 'view', $cliente['Cliente']['id'])); ?>
                    <?php echo $html->link(__('Eliminar', true), array('action' => 'delete', $cliente['Cliente']['id']), null, sprintf(__('Está seguro que desea eliminar el cliente # %s?', true), $cliente['Cliente']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de un total de %count%, empezando en registro %start%, finalizando en el registro %end%', true)
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        |	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>
