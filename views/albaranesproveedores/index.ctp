<div class="albaranesproveedores">
    <h2>
        <?php __('Albaranes de proveedores'); ?>
        <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?> 
    </h2>
    <div id="search_form" class="edit">
        <?php echo $this->Form->create('Albaranesproveedore', array('type' => 'get')) ?>
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
        <table class="view">
            <tr>
                <?php if (!empty($this->params['named']['serie'])): ?>
                    <td><?php echo $this->Form->input('Search.serie', array('label' => 'Serie', 'type' => 'select', 'options' => $series, 'empty' => True, 'selected' => $this->params['named']['serie'])) ?></td>
                <?php elseif (!empty($this->params['url']['serie'])): ?>
                    <td><?php echo $this->Form->input('Search.serie', array('label' => 'Serie', 'type' => 'select', 'options' => $series, 'empty' => True, 'selected' => $this->params['url']['serie'])) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.serie', array('label' => 'Serie', 'type' => 'select', 'empty' => True, 'options' => $series)) ?></td>
                <?php endif; ?>
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
            </tr>
            <tr>
                <?php if (!empty($this->params['named']['numero_avisostallere'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller', 'value' => $this->params['named']['numero_avisostallere'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_avisostallere'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller', 'value' => $this->params['url']['numero_avisostallere'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller')) ?></td>
                <?php endif; ?>
                <?php if (!empty($this->params['named']['numero_avisosrepuesto'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Repuestos', 'value' => $this->params['named']['numero_avisosrepuesto'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_avisosrepuesto'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Repuestos', 'value' => $this->params['url']['numero_avisosrepuesto'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Repuestos')) ?></td>
                <?php endif; ?>
                <?php if (!empty($this->params['named']['numero_ordene'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº Orden', 'value' => $this->params['named']['numero_ordene'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_ordene'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº Orden', 'value' => $this->params['url']['numero_ordene'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº Orden')) ?></td>
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
            <td><?php echo $this->Form->input('Search.almacene_id', array('label' => 'Almacén 1,2,3', 'type' => 'text', 'class' => 'almacenes_select', 'style' => 'width: 300px;')) ?></td>
            <?php if (!empty($this->params['named']['almacene_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>almacenes/get_json/<?php echo $this->params['named']['almacene_id'] ?>', function(data) {
                            $(".almacenes_select").select2("data", {
                                'id' : data.id,
                                'nombre' : data.nombre
                            });
                        });
                    });
                </script>
            <?php elseif (!empty($this->params['url']['almacene_id'])): ?>
                <script>
                    $(document).ready(function() {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>almacenes/get_json/<?php echo $this->params['url']['almacene_id'] ?>', function(data) {
                            $(".almacenes_select").select2("data", {
                                'id' : data.id,
                                'nombre' : data.nombre
                            });
                        });
                    });
                </script>    
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
    <?php
    $sumatorio_baseimponible = 0;
    $sumatorio_impuestos = 0;
    $sumatorio_total = 0;
    ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('Serie', 'serie'); ?></th>
            <th><?php echo $this->Paginator->sort('Número', 'numero'); ?></th>
            <th><?php echo $this->Paginator->sort('Proveedor', 'proveedore_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha', 'Albaranesproveedore.fecha'); ?></th>
            <th><?php echo $this->Paginator->sort('Almacén', 'almacene_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Aviso de repuesto', 'Presupuestosproveedore.avisosrepuesto_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Aviso de taller', 'Presupuestosproveedore.avisostallere_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Orden', 'Presupuestosproveedore.ordene_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Base Imp.', 'baseimponible'); ?></th>
            <th>Iva</th>
            <th>Total</th>
            <th><?php echo $this->Paginator->sort('Observaciones', 'Albaranesproveedore.observaciones'); ?></th>
            <th><?php echo $this->Paginator->sort('Estado', 'estadosalbaranesproveedore_id'); ?></th>
            <th><?php echo $this->Paginator->sort('albaranescaneado'); ?></th>
            <th class="actions"><div align="center"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($albaranesproveedores as $albaranesproveedore):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $albaranesproveedore['Albaranesproveedore']['serie']; ?>&nbsp;</td>
                <td><?php echo zerofill($albaranesproveedore['Albaranesproveedore']['numero']); ?>&nbsp;</td>
                <td><?php echo $this->Html->link($albaranesproveedore['Proveedore']['nombre'], array('controller' => 'proveedores', 'action' => 'view', $albaranesproveedore['Proveedore']['id'])); ?></td>
                <td style="width: 100px;"><?php echo $this->Time->format('d-m-Y', $albaranesproveedore['Albaranesproveedore']['fecha']); ?>&nbsp;</td>
                <td><?php echo $this->Html->link($albaranesproveedore['Almacene']['nombre'], array('controller' => 'almacenes', 'action' => 'view', $albaranesproveedore['Almacene']['id'])); ?></td>   
                <td><?php echo @$this->Html->link($albaranesproveedore['Pedidosproveedore']['Presupuestosproveedore']['avisosrepuesto_id'], array('controller' => 'avisosrepuestos', 'action' => 'view', $albaranesproveedore['Pedidosproveedore']['Presupuestosproveedore']['avisosrepuesto_id'])); ?></td>    
                <td><?php echo @$this->Html->link($albaranesproveedore['Pedidosproveedore']['Presupuestosproveedore']['avisostallere_id'], array('controller' => 'avisostalleres', 'action' => 'view', $albaranesproveedore['Pedidosproveedore']['Presupuestosproveedore']['avisostallere_id'])); ?></td>   
                <td><?php echo @$this->Html->link($albaranesproveedore['Pedidosproveedore']['Presupuestosproveedore']['ordene_id'], array('controller' => 'ordenes', 'action' => 'view', $albaranesproveedore['Pedidosproveedore']['Presupuestosproveedore']['ordene_id'])); ?></td>
                <td><?php echo redondear_dos_decimal($albaranesproveedore['Albaranesproveedore']['baseimponible']); ?>&nbsp;</td>
                <td><?php echo redondear_dos_decimal($albaranesproveedore['Albaranesproveedore']['baseimponible'] * ($albaranesproveedore['Proveedore']['Tiposiva']['porcentaje_aplicable'] / 100)); ?>&nbsp;</td>
                <td><?php echo redondear_dos_decimal($albaranesproveedore['Albaranesproveedore']['baseimponible']) + redondear_dos_decimal($albaranesproveedore['Albaranesproveedore']['baseimponible'] * ($albaranesproveedore['Proveedore']['Tiposiva']['porcentaje_aplicable'] / 100)); ?>&nbsp;</td>
                <td><span title="<?php echo $albaranesproveedore['Albaranesproveedore']['observaciones']; ?>"><?php echo substr($albaranesproveedore['Albaranesproveedore']['observaciones'], 0, 50); ?></span></td>
                <td><?php echo $albaranesproveedore['Estadosalbaranesproveedore']['estado']; ?></td>
                <td><?php echo $this->Html->link(__($albaranesproveedore['Albaranesproveedore']['albaranescaneado'], true), '/files/albaranesproveedore/' . $albaranesproveedore['Albaranesproveedore']['albaranescaneado']); ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $albaranesproveedore['Albaranesproveedore']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $albaranesproveedore['Albaranesproveedore']['id']), null, sprintf(__('¿ Seguro que quieres eliminar el Albarán # %s?', true), $albaranesproveedore['Albaranesproveedore']['serie'] . ' --- ' . $albaranesproveedore['Albaranesproveedore']['numero'])); ?>
                </td>
            </tr>
            <?php
            $sumatorio_baseimponible += redondear_dos_decimal($albaranesproveedore['Albaranesproveedore']['baseimponible']);
            $sumatorio_impuestos += redondear_dos_decimal($albaranesproveedore['Albaranesproveedore']['baseimponible'] * ($albaranesproveedore['Proveedore']['Tiposiva']['porcentaje_aplicable'] / 100));
            $sumatorio_total += redondear_dos_decimal($albaranesproveedore['Albaranesproveedore']['baseimponible']) + redondear_dos_decimal($albaranesproveedore['Albaranesproveedore']['baseimponible'] * ($albaranesproveedore['Proveedore']['Tiposiva']['porcentaje_aplicable'] / 100));
            ?>
        <?php endforeach; ?>
            <tr class="totales_pagina">
                <td colspan="8">TOTALES</td>
                <td><?php echo redondear_dos_decimal($sumatorio_baseimponible) ?></td>
                <td><?php echo redondear_dos_decimal($sumatorio_impuestos) ?></td>
                <td><?php echo redondear_dos_decimal($sumatorio_total) ?></td>
                <td colspan="4"></td>
            </tr>
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
