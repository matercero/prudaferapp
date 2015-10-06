<div class="avisostalleres">
    <h2>
        <?php __('Avisos de Taller'); ?>
        <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Nuevo Aviso de Taller', true), array('action' => 'add'), array('class' => 'button_link')); ?>
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
        <?php echo $this->Form->create('Avisostallere', array('type' => 'get')) ?>
        <table class="view">
            <tr>
                <td style="width: 250px"><?php echo $this->Form->input('Search.numero') ?></td>
                <td style="width: 250px"><?php echo $this->Form->input('Search.fecha_inicio', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => 1, 'month' => 1, 'year' => 1998))) ?></td>
                <td><?php echo $this->Form->input('Search.fecha_fin', array('type' => 'date', 'dateFormat' => 'DMY')) ?></td>
                
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
            <th><?php echo $this->Paginator->sort('Número', 'numero'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha de Aviso', 'fechaaviso'); ?></th>
            <th><?php echo $this->Paginator->sort('Cliente', 'cliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Centro de Trabajo', 'centrostrabajo_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Maquina', 'maquina_id'); ?></th>
            <th style="width: 20%"><?php echo $this->Paginator->sort('Descripcion'); ?></th>
            <th><?php echo $this->Paginator->sort('Cambio', 'aviso_mantenimiento'); ?></th>
            <th><?php echo $this->Paginator->sort('Urgente', 'marcarurgente'); ?></th>
            <th><?php echo $this->Paginator->sort('Estado', 'estadosavisostallere_id'); ?></th>
            <th><?php __('Orden'); ?></th>
            <th class="actions"><div align="center"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($avisostalleres as $avisostallere):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $avisostallere['Avisostallere']['numero']; ?></td>
                <td><?php echo $this->Time->format('d-m-Y', $avisostallere['Avisostallere']['fechaaviso']); ?></td>
                <td><?php echo $this->Html->link($avisostallere['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $avisostallere['Cliente']['id'])); ?></td>
                <td><?php echo $this->Html->link($avisostallere['Centrostrabajo']['centrotrabajo'], array('controller' => 'centrostrabajos', 'action' => 'view', $avisostallere['Centrostrabajo']['id'])); ?></td>
                <td><?php echo $this->Html->link($avisostallere['Maquina']['nombre'], array('controller' => 'maquinas', 'action' => 'view', $avisostallere['Maquina']['id'])); ?></td>
                <td><?php echo $avisostallere['Avisostallere']['descripcion']; ?></td>
                <td></span><span style="color: green"> <?php echo $avisostallere['Avisostallere']['aviso_mantenimiento']; ?></td>
                <td><?php echo!empty($avisostallere['Avisostallere']['marcarurgente']) ? 'Sí' : 'No'; ?></td>
                <td><?php echo $avisostallere['Estadosavisostallere']['estado']; ?></td>
                <td>
                    <?php foreach ($avisostallere['Ordene'] as $ordene): ?>
                        <?php echo $this->Html->link($ordene['numero'], array('controller' => 'ordenes', 'action' => 'view', $ordene['id'])); ?> | 
                    <?php endforeach; ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $avisostallere['Avisostallere']['id'])); ?>
                    <?php echo $this->Html->link(__('Pdf', true), array('action' => 'pdf', $avisostallere['Avisostallere']['id'])); ?>
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
