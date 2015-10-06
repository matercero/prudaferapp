<div class="avisosrepuestos">
    <h2>
        <?php __('Avisos de repuestos'); ?>
        <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Nuevo Aviso de Repuestos', true), array('action' => 'add'), array('class' => 'button_link')); ?>
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
        <?php echo $this->Form->create('Avisosrepuesto', array('type' => 'get')) ?>
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
            </tr>
            <tr>
                <?php if (!empty($this->params['named']['descripcion'])): ?>
                    <td><?php echo $this->Form->input('Search.descripcion', array('label' => 'Descripción del Aviso', 'value' => $this->params['named']['descripcion'])) ?></td>
                <?php elseif (!empty($this->params['url']['descripcion'])): ?>
                    <td><?php echo $this->Form->input('Search.descripcion', array('label' => 'Descripción del Aviso', 'value' => $this->params['url']['descripcion'])) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.descripcion', array('label' => 'Descripción del Aviso')) ?></td>
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
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('Nº', 'numero'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha', 'fechahora'); ?></th>
            <th><?php echo $this->Paginator->sort('Cliente', 'cliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Centro de trabajo', 'centrostrabajo_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Máquina', 'maquina_id'); ?></th>
            <th style="width: 30%"><?php echo $this->Paginator->sort('Descripción'); ?></th>
            <th><?php echo $this->Paginator->sort('Estado', 'estado_id'); ?></th>
            <th class="actions"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($avisosrepuestos as $avisosrepuesto):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $avisosrepuesto['Avisosrepuesto']['numero']; ?>&nbsp;</td>
                <td><?php echo $this->Time->format('d-m-Y', $avisosrepuesto['Avisosrepuesto']['fechahora']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($avisosrepuesto['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $avisosrepuesto['Cliente']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($avisosrepuesto['Centrostrabajo']['centrotrabajo'], array('controller' => 'centrostrabajos', 'action' => 'view', $avisosrepuesto['Centrostrabajo']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($avisosrepuesto['Maquina']['nombre'], array('controller' => 'maquinas', 'action' => 'view', $avisosrepuesto['Maquina']['id'])); ?>
                </td>
                <td><?php echo $avisosrepuesto['Avisosrepuesto']['descripcion']; ?></td>
                <td>
                    <?php echo $this->Html->link($avisosrepuesto['Estadosaviso']['estado'], array('controller' => 'estadosavisos', 'action' => 'view', $avisosrepuesto['Estadosaviso']['id'])); ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $avisosrepuesto['Avisosrepuesto']['id'])); ?>
                    <?php echo $this->Html->link(__('Pdf', true), array('action' => 'pdf', $avisosrepuesto['Avisosrepuesto']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% filas de %count% total, starting on record %start%, finalizando en %end%', true)
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>
