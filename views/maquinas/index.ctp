<div class="maquinas ">
    <h2>
        <?php __('Máquinas'); ?>
        <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Nueva Maquina', true), array('action' => 'add'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Listar Centros Trabajo', true), array('controller' => 'centrostrabajos', 'action' => 'index'), array('class' => 'button_link')); ?>
    </h2>
    <div id="search_form" class="edit">
        <?php echo $this->Form->create('Maquina', array('type' => 'get')) ?>
        <?php
        array_shift($this->params['url']);
        array_shift($this->params['url']);
        if (!empty($this->params['url'])) {
            $this->Paginator->options(array('url' => $this->params['url']));
        }
        ?>
        <table class="view">
            <tr>
                <?php if (!empty($this->params['named']['codigo_nombre_serie'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.codigo_nombre_serie', array('label' => 'Búsqueda en Codigo, Nombre o Serie de la Máquina', 'style' => 'width: 500px;', 'value' => $this->params['named']['codigo_nombre_serie'])) ?></td>
                <?php elseif (!empty($this->params['url']['codigo_nombre_serie'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.codigo_nombre_serie', array('label' => 'Búsqueda en Codigo, Nombre o Serie de la Máquina', 'style' => 'width: 500px;', 'value' => $this->params['url']['codigo_nombre_serie'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.codigo_nombre_serie', array('label' => 'Búsqueda en Codigo, Nombre o Serie de la Máquina', 'style' => 'width: 500px;')) ?></td>
                <?php endif; ?>

                <td><?php echo $this->Form->input('Search.cliente_id', array('label' => 'Cliente', 'type' => 'text', 'class' => 'clientes_select', 'style' => 'width: 300px;')) ?></td>
                <?php if (!empty($this->params['named']['cliente_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON(proyect_url()+'clientes/get_json/<?php echo $this->params['named']['cliente_id'] ?>', function(data) {
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
                        $.getJSON(proyect_url()+'clientes/get_json/<?php echo $this->params['url']['cliente_id'] ?>', function(data) {
                            $(".clientes_select").select2("data", {
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
            'format' => __('Página %page% de %pages%, mostrando %current% registros de un total de %count%, empezando en registro %start%, finalizando en el registro %end%', true)
        ));
        ?>	
    </p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('Código Máquina', 'codigo'); ?></th>
            <th><?php echo $this->Paginator->sort('Nombre', 'nombre'); ?></th>
            <th><?php echo $this->Paginator->sort('Nº serie Máquina', 'serie_maquina'); ?></th>
            <th><?php echo $this->Paginator->sort('Cliente', 'Centrostrabajo.cliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Centro Trabajo', 'centrostrabajo_id'); ?></th>
            <th class="actions"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($maquinas as $maquina):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $maquina['Maquina']['codigo']; ?>&nbsp;</td>
                <td><?php echo $maquina['Maquina']['nombre']; ?>&nbsp;</td>
                <td><?php echo $maquina['Maquina']['serie_maquina']; ?>&nbsp;</td>
                <td><?php echo!empty($maquina['Centrostrabajo']['Cliente']['nombre']) ? $this->Html->link($maquina['Centrostrabajo']['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $maquina['Centrostrabajo']['Cliente']['id'])) : 'Sin cliente asociado' ?></td>
                <?php if (!empty($maquina['Centrostrabajo']['centrotrabajo'])): ?>
                    <td><?php echo $this->Html->link($maquina['Centrostrabajo']['centrotrabajo'], array('controller' => 'centrostrabajos', 'action' => 'view', $maquina['Centrostrabajo']['id'])); ?></td>
                <?php else : ?>
                    <td><?php echo $this->Html->link($maquina['Centrostrabajo']['direccion'], array('controller' => 'centrostrabajos', 'action' => 'view', $maquina['Centrostrabajo']['id'])); ?></td>
                <?php endif; ?>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $maquina['Maquina']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $maquina['Maquina']['id']), null, sprintf(__('¿Está seguro que desea eliminar # %s?', true), $maquina['Maquina']['id'])); ?>
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
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>