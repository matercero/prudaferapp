<div class="formapagos">
    <h2>
        <?php __('Formas de pagos'); ?>
        <?php echo $this->Html->link(__('Nueva Forma de Pago', true), array('action' => 'add'), array('class' => 'button_link')); ?>
    </h2>
    <div id="search_form" class="edit">
        <?php echo $this->Form->create('Formapago', array('type' => 'get')) ?>
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
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre', array('label' => 'Nombre', 'value' => $this->params['named']['nombre'])) ?></td>
                <?php elseif (!empty($this->params['url']['nombre'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre', array('label' => 'Nombre', 'value' => $this->params['url']['nombre'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre', array('label' => 'Nombre')) ?></td>
                <?php endif; ?>
                <td><?php echo $this->Form->input('Search.cliente_id', array('label' => 'Cliente', 'type' => 'text', 'class' => 'clientes_select', 'style' => 'width: 300px;')) ?></td>
                <?php if (!empty($this->params['named']['cliente_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>clientes/get_json/<?php echo $this->params['named']['cliente_id'] ?>', function(data) {
                            $(".clientes_select").select2("data", {
                                'id' : data.id,
                                'nombre' : data.nombre
                            });
                        });
                    });
                </script>
            <?php elseif (!empty($this->params['url']['cliente_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>clientes/get_json/<?php echo $this->params['url']['cliente_id'] ?>', function(data) {
                            $(".clientes_select").select2("data", {
                                'id' : data.id,
                                'nombre' : data.nombre
                            });
                        });
                    });
                </script>
            <?php endif; ?>
            <td><?php echo $this->Form->input('Search.proveedore_id', array('label' => 'Proveedor', 'type' => 'text', 'class' => 'proveedores_select', 'style' => 'width: 300px;')) ?></td>
            <?php if (!empty($this->params['named']['proveedore_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>proveedores/get_json/<?php echo $this->params['named']['proveedore_id'] ?>', function(data) {
                            $(".proveedores_select").select2("data", {
                                'id' : data.id,
                                'nombre' : data.nombre
                            });
                        });
                    });
                </script>
            <?php elseif (!empty($this->params['url']['proveedore_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>proveedores/get_json/<?php echo $this->params['url']['proveedore_id'] ?>', function(data) {
                            $(".proveedores_select").select2("data", {
                                'id' : data.id,
                                'nombre' : data.nombre
                            });
                        });
                    });
                </script>
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
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('nombre'); ?></th>
            <th><?php echo $this->Paginator->sort('tipodepago'); ?></th>
            <th><?php echo $this->Paginator->sort('numero_vencimientos'); ?></th>
            <th><?php echo $this->Paginator->sort('dias_entre_vencimiento'); ?></th>
            <th><?php echo $this->Paginator->sort('dia_mes_fijo_vencimiento'); ?></th>
            <th><?php echo $this->Paginator->sort('proveedore_id'); ?></th>
            <th><?php echo $this->Paginator->sort('cliente_id'); ?></th>
            <th class="actions"><?php __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($formapagos as $formapago):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $formapago['Formapago']['nombre']; ?>&nbsp;</td>
                <td><?php echo $formapago['Formapago']['tipodepago']; ?>&nbsp;</td>
                <td><?php echo $formapago['Formapago']['numero_vencimientos']; ?>&nbsp;</td>
                <td><?php echo $formapago['Formapago']['dias_entre_vencimiento']; ?>&nbsp;</td>
                <td><?php echo $formapago['Formapago']['dia_mes_fijo_vencimiento']; ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($formapago['Proveedore']['idnombre'], array('controller' => 'proveedores', 'action' => 'view', $formapago['Proveedore']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($formapago['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $formapago['Cliente']['id'])); ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $formapago['Formapago']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $formapago['Formapago']['id']), null, sprintf(__('¿ Seguro que deseas borrar la forma de pago # %s?', true), $formapago['Formapago']['nombre'])); ?>
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