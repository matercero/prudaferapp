<div class="ordenes">
    <h2>
        <?php __('Ordenes'); ?>
        <?php echo $this->Html->link(__('Listar Ordenes', true), array('controller' => 'ordenes', 'action' => 'index'), array('class' => 'button_link')); ?>
    </h2>
    <div id="search_form" class="edit">
        <?php
        array_shift($this->params['url']);
        array_shift($this->params['url']);
        if (!empty($this->params['url'])) {
            if (!empty($this->params['url']['fecha_inicio'])) {
                $this->params['url']['fecha_inicio[day]'] = $this->params['url']['fecha_inicio']['day'];
                $this->params['url']['fecha_inicio[month]'] = $this->params['url']['fecha_inicio']['month'];
                $this->params['url']['fecha_inicio[year]'] = $this->params['url']['fecha_inicio']['year'];
                unset($this->params['url']['fecha_inicio']);
            }
            if (!empty($this->params['url']['fecha_fin'])) {
                $this->params['url']['fecha_fin[day]'] = $this->params['url']['fecha_fin']['day'];
                $this->params['url']['fecha_fin[month]'] = $this->params['url']['fecha_fin']['month'];
                $this->params['url']['fecha_fin[year]'] = $this->params['url']['fecha_fin']['year'];
                unset($this->params['url']['fecha_fin']);
            }
            $this->Paginator->options(array('url' => $this->params['url']));
        }
        ?>
        <?php echo $this->Form->create('Ordene', array('type' => 'get')) ?>
        <table class="view">
            <tr>
                <?php if (!empty($this->params['named']['numero'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero', array('value' => $this->params['named']['numero'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero', array('value' => $this->params['url']['numero'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero') ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['fecha_inicio[day]'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.fecha_inicio', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => $this->params['named']['fecha_inicio[day]'], 'month' => $this->params['named']['fecha_inicio[month]'], 'year' => $this->params['named']['fecha_inicio[year]']))) ?></td>
                <?php elseif (!empty($this->params['url']['fecha_inicio[day]'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.fecha_inicio', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => $this->params['url']['fecha_inicio[day]'], 'month' => $this->params['url']['fecha_inicio[month]'], 'year' => $this->params['url']['fecha_inicio[year]']))) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.fecha_inicio', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => 1, 'month' => 1, 'year' => 1998))) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['fecha_fin[day]'])): ?>
                    <td><?php echo $this->Form->input('Search.fecha_fin', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => $this->params['named']['fecha_fin[day]'], 'month' => $this->params['named']['fecha_fin[month]'], 'year' => $this->params['named']['fecha_fin[year]']))) ?></td>
                <?php elseif (!empty($this->params['url']['fecha_fin[day]'])): ?>
                    <td><?php echo $this->Form->input('Search.fecha_fin', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => $this->params['url']['fecha_fin[day]'], 'month' => $this->params['url']['fecha_fin[month]'], 'year' => $this->params['url']['fecha_fin[year]']))) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.fecha_fin', array('type' => 'date', 'dateFormat' => 'DMY')) ?></td>
                <?php endif; ?>

                <td><?php echo $this->Form->input('Search.articulo_id', array('label' => 'Árticulo', 'type' => 'text', 'class' => 'articulos_select', 'style' => 'width: 300px;')) ?></td>
                <?php if (!empty($this->params['named']['articulo_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>articulos/get_json/<?php echo $this->params['named']['articulo_id'] ?>', function(data) {
                            $(".articulos_select").select2("data", {
                                'id' : data.id,
                                'ref' : data.ref,
                                'nombre' : data.nombre
                            });
                        });
                    });
                </script>
            <?php elseif (!empty($this->params['url']['articulo_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>articulos/get_json/<?php echo $this->params['url']['articulo_id'] ?>', function(data) {
                            $(".articulos_select").select2("data", {
                                'id' : data.id,
                                'ref' : data.ref,
                                'nombre' : data.nombre
                            });
                        });
                    });
                </script>
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
                        <?php if (!empty($this->params['named']['mantenimientos'])): ?>
                <td style="width: 125px"><?php echo $this->Form->input('Search.mantenimientos', array('value' => $this->params['named']['mantenimientos'])) ?></td>
            <?php elseif (!empty($this->params['url']['mantenimientos'])): ?>
                <td style="width: 125px"><?php echo $this->Form->input('Search.mantenimientos', array('value' => $this->params['url']['mantenimientos'])) ?></td>
            <?php else: ?>
                <td style="width: 125px"><?php echo $this->Form->input('Search.mantenimientos') ?></td>
            <?php endif; ?> 
            </tr>
            <tr>
                <?php if (!empty($this->params['named']['descripcion'])): ?>
                    <td><?php echo $this->Form->input('Search.descripcion', array('label' => 'Descripción de la Orden', 'value' => $this->params['named']['descripcion'])) ?></td>
                <?php elseif (!empty($this->params['url']['descripcion'])): ?>
                    <td><?php echo $this->Form->input('Search.descripcion', array('label' => 'Descripción de la Orden', 'value' => $this->params['url']['descripcion'])) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.descripcion', array('label' => 'Descripción de la Orden')) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['descripcion_tarea'])): ?>
                    <td><?php echo $this->Form->input('Search.descripcion_tarea', array('label' => 'Descripción de la Tarea', 'value' => $this->params['named']['descripcion_tarea'])) ?></td>
                <?php elseif (!empty($this->params['url']['descripcion_tarea'])): ?>
                    <td><?php echo $this->Form->input('Search.descripcion_tarea', array('label' => 'Descripción de la Tarea', 'value' => $this->params['url']['descripcion_tarea'])) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.descripcion_tarea', array('label' => 'Descripción de la Tarea')) ?></td>
                <?php endif; ?>

                <td><?php echo $this->Form->input('Search.maquina_id', array('label' => 'Máquina', 'type' => 'text', 'class' => 'maquinas_select', 'style' => 'width: 300px;')) ?></td>
                <?php if (!empty($this->params['named']['maquina_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>maquinas/get_json/<?php echo $this->params['named']['maquina_id'] ?>', function(data) {
                            $(".maquinas_select").select2("data", {
                                'id' : data.id,
                                'codigo' : data.codigo,
                                'nombre' : data.nombre
                            });
                        });
                    });
                </script>
            <?php elseif (!empty($this->params['url']['maquina_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>maquinas/get_json/<?php echo $this->params['url']['maquina_id'] ?>', function(data) {
                            $(".maquinas_select").select2("data", {
                                'id' : data.id,
                                'codigo' : data.codigo,
                                'nombre' : data.nombre
                            });
                        });
                    });
                </script>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['resultados_por_pagina'])): ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000), 'default' => '20', 'selected' => $this->params['named']['resultados_por_pagina'])) ?></td>
            <?php elseif (!empty($this->params['url']['resultados_por_pagina'])): ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000), 'default' => '20', 'selected' => $this->params['url']['resultados_por_pagina'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000), 'default' => '20')) ?></td>
            <?php endif; ?>
                           
            <?php if (!empty($this->params['named']['estadosordene_id'])): ?>
                <td><?php echo $this->Form->input('Search.estadosordene_id', array('label' => 'Estado de la Orden', 'class' => 'chzn-select-not-required', 'empty' => 'Seleciona un estado...', 'value' => $this->params['named']['estadosordene_id'])) ?></td>
            <?php elseif (!empty($this->params['url']['estadosordene_id'])): ?>
                <td><?php echo $this->Form->input('Search.estadosordene_id', array('label' => 'Estado de la Orden', 'class' => 'chzn-select-not-required', 'empty' => 'Seleciona un estado...', 'value' => $this->params['url']['estadosordene_id'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.estadosordene_id', array('label' => 'Estado de la Orden', 'empty' => 'Seleciona un estado...', 'class' => 'chzn-select-not-required')) ?></td>
            <?php endif; ?>
            </tr>
        </table>
        <?php echo $this->Form->button('Nueva Búsqueda', array('type' => 'reset', 'class' => 'button_css_green')); ?>
        <?php echo $this->Form->end(array('label' => 'Buscar', 'div' => True, 'class' => 'button_css_blue')) ?>
    </div>

    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% filas de %count% total, starting on record %start%, finalizando en %end%', true)
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
            <th><?php echo $this->Paginator->sort('Nº', 'numero'); ?></th>
            <th style="width: 6.5em;"><?php echo $this->Paginator->sort('Fecha'); ?></th>
            <th><?php echo $this->Paginator->sort('Aviso', 'avisostallere_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Cliente', 'cliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Centros de Trabajo', 'centrostrabajo_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Máquina', 'maquina_id'); ?></th>
            <th style="width: 20%"><?php echo $this->Paginator->sort('Descripción'); ?></th>
            <th><?php echo $this->Paginator->sort('Cambio', 'mantenimientos'); ?></th>
            <th><?php echo $this->Paginator->sort('Estado'); ?></th>
            <th><?php echo $this->Paginator->sort('Urgente'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha reparación'); ?></th>
            <th class="actions"><div align="center"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($ordenes as $ordene):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><a href="#" class="selecionado" id="<?php echo $ordene['Ordene']['id']; ?>"><?php echo $ordene['Ordene']['numero']; ?></a></td>
            <script type="text/javascript">
                $('.selecionado').click(function(){
                    if(window.opener){
                        window.opener.$('#AlbaranesclientesreparacioneOrdeneId').val($(this).attr('id'));
                        window.opener.$('#OrdeneNumero').val($(this).html());
                        window.close();
                    }
                });
            </script>
            <td><?php echo $this->Time->format('d-m-Y', $ordene['Ordene']['fecha']); ?></td>
            <td><?php echo $this->Html->link($ordene['Avisostallere']['numero'], array('controller' => 'avisostalleres', 'action' => 'view', $ordene['Avisostallere']['id'])); ?></td>
            <td><?php echo!empty($ordene['Cliente']['nombre']) ? $this->Html->link($ordene['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $ordene['Cliente']['id'])) : ''; ?></td>
            <td><?php echo!empty($ordene['Centrostrabajo']) ? $this->Html->link($ordene['Centrostrabajo']['centrotrabajo'], array('controller' => 'centrostrabajos', 'action' => 'view', $ordene['Centrostrabajo']['id'])) : ''; ?></td>
            <td><?php echo!empty($ordene['Maquina']['nombre']) ? $this->Html->link($ordene['Maquina']['nombre'], array('controller' => 'maquinas', 'action' => 'view', $ordene['Maquina']['id'])) : ''; ?></td>
            <td><?php echo $ordene['Ordene']['descripcion']; ?></td>
            <td></span><span style="color: green"> <?php echo $ordene['Ordene']['mantenimientos']; ?></td>
            <td><?php echo $ordene['Estadosordene']['estado']; ?></td>
            <td><?php echo!empty($ordene['Ordene']['urgente']) ? 'Sí' : 'No' ?></td>
            <td><?php echo $ordene['Ordene']['fecha_prevista_reparacion']; ?></td>
            <td class="actions">
                <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $ordene['Ordene']['id'])); ?>
                <?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $ordene['Ordene']['id'])); ?>
                <?php echo $this->Html->link(__('Pdf', true), array('action' => 'pdf', $ordene['Ordene']['id'])); ?>
            </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% filas de %count% total, starting on record %start%, finalizando en %end%', true)
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

