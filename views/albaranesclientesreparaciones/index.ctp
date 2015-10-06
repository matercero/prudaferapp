<div class="albaranesclientesreparaciones">
    <h2>
        <?php __('Albaranes de Reparaciones'); ?>
        <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?> 
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
        <?php echo $this->Form->create('Albaranesclientesreparacione', array('type' => 'get')) ?>
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
                <?php if (!empty($this->params['named']['numero_avisostallere'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller', 'value' => $this->params['named']['numero_avisostallere'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_avisostallere'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller', 'value' => $this->params['url']['numero_avisostallere'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller',)) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['numero_ordene'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº de Orden', 'value' => $this->params['named']['numero_ordene'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_ordene'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº de Orden', 'value' => $this->params['url']['numero_ordene'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº de Orden',)) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['comerciale_id'])): ?>
                    <td><?php echo $this->Form->input('Search.comerciale_id', array('label' => 'Comercial', 'type' => 'select', 'class' => 'select_basico', 'options' => $comerciales, 'empty' => True, 'selected' => $this->params['named']['comerciale_id'])) ?></td>
                <?php elseif (!empty($this->params['url']['comerciale_id'])): ?>
                    <td><?php echo $this->Form->input('Search.comerciale_id', array('label' => 'Comercial', 'type' => 'select', 'class' => 'select_basico', 'options' => $comerciales, 'empty' => True, 'selected' => $this->params['url']['comerciale_id'])) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.comerciale_id', array('label' => 'Comercial', 'type' => 'select', 'class' => 'select_basico', 'empty' => True, 'options' => $comerciales)) ?></td>
                <?php endif; ?>
                    
                <?php if (!empty($this->params['named']['estadosalbaranesclientesreparacione_id'])): ?>
                    <td><?php echo $this->Form->input('Search.estadosalbaranesclientesreparacione_id', array('label' => 'Estado', 'type' => 'select', 'class' => 'select_basico', 'options' => $estadosalbaranesclientesreparaciones, 'empty' => True, 'selected' => $this->params['named']['estadosalbaranesclientesreparacione_id'])) ?></td>
                <?php elseif (!empty($this->params['url']['estadosalbaranesclientesreparacione_id'])): ?>
                    <td><?php echo $this->Form->input('Search.estadosalbaranesclientesreparacione_id', array('label' => 'Estado', 'type' => 'select', 'class' => 'select_basico', 'options' => $estadosalbaranesclientesreparaciones, 'empty' => True, 'selected' => $this->params['url']['estadosalbaranesclientesreparacione_id'])) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.estadosalbaranesclientesreparacione_id', array('label' => 'Estado', 'type' => 'select', 'class' => 'select_basico', 'empty' => True, 'options' => $estadosalbaranesclientesreparaciones)) ?></td>
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
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <?php
    $sumatorio_precio_mat = 0;
    $sumatorio_precio_obra = 0;
    $sumatorio_baseimponible = 0;
    $sumatorio_impuestos = 0;
    $sumatorio_total = 0;
    ?>
    <table cellpadding="0" cellspacing="0">
        <tr>  
            <th><?php echo $this->Paginator->sort('fecha'); ?></th>
            <th><?php echo $this->Paginator->sort('Serie', 'serie'); ?></th>
            <th><?php echo $this->Paginator->sort('Nº', 'numero'); ?></th>
            <th><?php echo $this->Paginator->sort('cliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('observaciones'); ?></th>
            <th>Precio<br/>Mat.</th>
            <th>Precio<br/>Obra.</th>
            <th>Base<br/>Imp.</th>
            <th>Iva</th>
            <th>Total</th>
            <th><?php echo $this->Paginator->sort('Aviso<br/>Taller', 'Ordene.avisostallere_id', array('escape' => False)); ?></th>
            <th><?php echo $this->Paginator->sort('Orden', 'ordene_id'); ?></th>
            <th><?php echo $this->Paginator->sort('comercial_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Albarán<br/>Escaneado', 'albaranescaneado', array('escape' => False)); ?></th>
            <th><?php echo $this->Paginator->sort('Estado', 'estadosalbaranesclientesreparacione_id'); ?></th>
            <th><?php echo $this->Paginator->sort('fact.'); ?></th>
            <th><?php echo $this->Paginator->sort('facturas_cliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('centrosdecoste_id'); ?></th>
            <th class="actions"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($albaranesclientesreparaciones as $albaranesclientesreparacione):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $this->Time->format('d-m-Y', $albaranesclientesreparacione['Albaranesclientesreparacione']['fecha']); ?></td>
                <td><?php echo $albaranesclientesreparacione['Albaranesclientesreparacione']['serie']; ?>&nbsp;</td>
                <td><?php echo $albaranesclientesreparacione['Albaranesclientesreparacione']['numero']; ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($albaranesclientesreparacione['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $albaranesclientesreparacione['Cliente']['id'])); ?>
                </td>
                <td><span title="<?php echo $albaranesclientesreparacione['Albaranesclientesreparacione']['observaciones']; ?>"><?php echo substr($albaranesclientesreparacione['Albaranesclientesreparacione']['observaciones'], 0, 65); ?>...</span></td>
                <td><?php echo $albaranesclientesreparacione['Albaranesclientesreparacione']['total_materiales']; ?>&nbsp;</td>
                <td><?php echo $albaranesclientesreparacione['Albaranesclientesreparacione']['total_manoobra']; ?></td>
                <td><?php echo $albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible']; ?></td>
                <td><?php echo redondear_dos_decimal($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] * $albaranesclientesreparacione['Tiposiva']['porcentaje_aplicable'] / 100); ?></td>
                <td><?php echo redondear_dos_decimal($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] + ($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] * $albaranesclientesreparacione['Tiposiva']['porcentaje_aplicable'] / 100)); ?></td>
                <td><?php echo!empty($albaranesclientesreparacione['Ordene']['avisostallere_id']) ? $this->Html->link(@$albaranesclientesreparacione['Ordene']['Avisostallere']['numero'], array('controller' => 'avisostalleres', 'action' => 'view', $albaranesclientesreparacione['Ordene']['avisostallere_id'])) : ''; ?></td>
                <td><?php echo $this->Html->link($albaranesclientesreparacione['Ordene']['numero'], array('controller' => 'ordenes', 'action' => 'view', $albaranesclientesreparacione['Ordene']['id'])); ?></td>
                <td><?php echo $this->Html->link($albaranesclientesreparacione['Comerciale']['nombre'], array('controller' => 'comerciales', 'action' => 'view', $albaranesclientesreparacione['Comerciale']['id'])); ?></td>
                <td><?php if (!empty($albaranesclientesreparacione['Albaranesclientesreparacione']['albaranescaneado'])) echo $this->Html->image('clip.png', array('url' => '/files/albaranesclientesreparacione/' . $albaranesclientesreparacione['Albaranesclientesreparacione']['albaranescaneado'])); ?>&nbsp;</td>
                <td><?php echo $albaranesclientesreparacione['Estadosalbaranesclientesreparacione']['estado']; ?>&nbsp;</td>
                <td><?php echo $albaranesclientesreparacione['Albaranesclientesreparacione']['facturable'] == 1 ? 'Sí' : 'No'; ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($albaranesclientesreparacione['FacturasCliente']['numero'], array('controller' => 'facturas_clientes', 'action' => 'view', $albaranesclientesreparacione['FacturasCliente']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($albaranesclientesreparacione['Centrosdecoste']['denominacion'], array('controller' => 'centrosdecostes', 'action' => 'view', $albaranesclientesreparacione['Centrosdecoste']['id'])); ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $albaranesclientesreparacione['Albaranesclientesreparacione']['id'])); ?>
                    <?php echo $this->Html->link(__('PDF', true), array('action' => 'pdf', $albaranesclientesreparacione['Albaranesclientesreparacione']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $albaranesclientesreparacione['Albaranesclientesreparacione']['id']), array('class' => 'button_link'), sprintf(__('¿Seguro que quieres borrar el Albaran de Reparación Nº # %s?', true), $albaranesclientesreparacione['Albaranesclientesreparacione']['numero'])); ?> 
                </td>
            </tr>

            <?php
            $sumatorio_precio_mat += $albaranesclientesreparacione['Albaranesclientesreparacione']['total_materiales'];
            $sumatorio_precio_obra += $albaranesclientesreparacione['Albaranesclientesreparacione']['total_manoobra'];
            $sumatorio_baseimponible += $albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'];
            $sumatorio_impuestos += redondear_dos_decimal($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] * $albaranesclientesreparacione['Tiposiva']['porcentaje_aplicable'] / 100);
            $sumatorio_total += redondear_dos_decimal($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] + ($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] * $albaranesclientesreparacione['Tiposiva']['porcentaje_aplicable'] / 100));
            ?>
<?php endforeach; ?>
        <tr class="totales_pagina">
            <td colspan="5">TOTALES</td>
            <td><?php echo redondear_dos_decimal($sumatorio_precio_mat) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_precio_obra) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_baseimponible) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_impuestos) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_total) ?></td>
            <td colspan="9"></td>
        </tr>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
<?php echo $this->Paginator->next(__('siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>
