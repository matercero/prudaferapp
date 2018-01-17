<div class="albaranesclientes">
    <h2>
        <?php __('Albaranes a Clientes'); ?>
        <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?> 
        <?php echo $this->Html->link(__('Nuevo Albarán Directo', true), array('action' => 'add'), array('class' => 'button_link')); ?> 
    </h2>
    <div id="search_form" class="edit">
        <?php
        array_shift($this->params['url']);
        array_shift($this->params['url']);
        if (!empty($this->params['url'])) {
            $this->Paginator->options(array('url' => $this->params['url']));
        }
        // Inicializa fechas Inicio y  Fin
        if (empty($this->params['url']['FechaInicio'])) {
            $this->params['url']['FechaInicio'] = '1998-01-01';
        }
        if (empty($this->params['url']['FechaFin'])) {
            $this->params['url']['FechaFin'] = date("d-m-Y");
            ;
        }
        ?>
        <?php echo $this->Form->create('Albaranescliente', array('type' => 'get')) ?>
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
                <!-- Fecha inicio NUEVA -->
                <td style="width: 250px">
                    <?php
                    echo $this->Form->input('FechaInicio', array('type' => 'text', 'id' => 'calendar_inputEnt',
                        'value' => $this->params['url']['FechaInicio'], 'style' => 'width: 100px;'))
                    ?>
                </td>

                <!-- Fecha Fin NUEVA -->
                <td style="width: 250px">
                    <?php
                    echo $this->Form->input('FechaFin', array('type' => 'text', 'id' => 'calendar_inputFin',
                        'value' => $this->params['url']['FechaFin'], 'style' => 'width: 100px;'))
                    ?>
                </td>

                <td><?php echo $this->Form->input('Search.articulo_id', array('label' => 'Artículo', 'type' => 'text', 'class' => 'articulos_select', 'style' => 'width: 300px;')) ?></td>
                <?php if (!empty($this->params['named']['articulo_id'])): ?>
                <script>
                    $(document).ready(function () {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>articulos/get_json/<?php echo $this->params['named']['articulo_id'] ?>', function (data) {
                                    $(".articulos_select").select2("data", {
                                        'id': data.id,
                                        'ref': data.ref,
                                        'nombre': data.nombre
                                    });
                                });
                            });
                </script>
            <?php elseif (!empty($this->params['url']['articulo_id'])): ?>
                <script>
                    $(document).ready(function () {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>articulos/get_json/<?php echo $this->params['url']['articulo_id'] ?>', function (data) {
                                    $(".articulos_select").select2("data", {
                                        'id': data.id,
                                        'ref': data.ref,
                                        'nombre': data.nombre
                                    });
                                });
                            });
                </script>
            <?php endif; ?>
            </tr>
            <tr>    
                <td>
                    <?php echo $this->Form->input('Search.cliente_id', array('label' => 'Cliente', 'type' => 'text', 'class' => 'clientes_select', 'style' => 'width: 300px;')) ?></td>
                <?php if (!empty($this->params['named']['cliente_id'])): ?>
                <script>
                    $(document).ready(function () {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>clientes/get_json/<?php echo $this->params['named']['cliente_id'] ?>', function (data) {
                                    $(".clientes_select").select2("data", {
                                        'id': data.id,
                                        'nombre': data.nombre
                                    });
                                });
                            });
                </script>
            <?php elseif (!empty($this->params['url']['cliente_id'])): ?>
                <script>
                    $(document).ready(function () {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>clientes/get_json/<?php echo $this->params['url']['cliente_id'] ?>', function (data) {
                                    $(".clientes_select").select2("data", {
                                        'id': data.id,
                                        'nombre': data.nombre
                                    });
                                });
                            });
                </script>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['numero_avisosrepuesto'])): ?>
                <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Repuestos', 'value' => $this->params['named']['numero_avisosrepuesto'])) ?></td>
            <?php elseif (!empty($this->params['url']['numero_avisosrepuesto'])): ?>
                <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Repuestos', 'value' => $this->params['url']['numero_avisosrepuesto'])) ?></td>
            <?php else: ?>
                <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Repuestos',)) ?></td>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['comerciale_id'])): ?>
                <td><?php echo $this->Form->input('Search.comerciale_id', array('label' => 'Comercial', 'type' => 'select', 'class' => 'select_basico', 'options' => $comerciales, 'empty' => True, 'selected' => $this->params['named']['comerciale_id'])) ?></td>
            <?php elseif (!empty($this->params['url']['comerciale_id'])): ?>
                <td><?php echo $this->Form->input('Search.comerciale_id', array('label' => 'Comercial', 'type' => 'select', 'class' => 'select_basico', 'options' => $comerciales, 'empty' => True, 'selected' => $this->params['url']['comerciale_id'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.comerciale_id', array('label' => 'Comercial', 'type' => 'select', 'class' => 'select_basico', 'empty' => True, 'options' => $comerciales)) ?></td>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['estadosalbaranescliente_id'])): ?>
                <td><?php echo $this->Form->input('Search.estadosalbaranescliente_id', array('label' => 'Estado', 'type' => 'select', 'class' => 'select_basico', 'options' => $estadosalbaranesclientes, 'empty' => True, 'selected' => $this->params['named']['estadosalbaranescliente_id'])) ?></td>
            <?php elseif (!empty($this->params['url']['estadosalbaranescliente_id'])): ?>
                <td><?php echo $this->Form->input('Search.estadosalbaranescliente_id', array('label' => 'Estado', 'type' => 'select', 'class' => 'select_basico', 'options' => $estadosalbaranesclientes, 'empty' => True, 'selected' => $this->params['url']['estadosalbaranescliente_id'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.estadosalbaranescliente_id', array('label' => 'Estado', 'type' => 'select', 'class' => 'select_basico', 'empty' => True, 'options' => $estadosalbaranesclientes)) ?></td>
            <?php endif; ?>

            <!--  Add filtro por maquina-->       
            <?php if (!empty($this->params['named']['maquina_id'])): ?>
                <td><?php echo $this->Form->input('Search.maquina_id', array('label' => 'Máquina', 'type' => 'select', 'class' => 'select_basico', 'options' => $maquina, 'empty' => True, 'selected' => $this->params['named']['maquina_id'])) ?></td>
            <?php elseif (!empty($this->params['url']['maquina_id'])): ?>
                <td><?php echo $this->Form->input('Search.maquina_id', array('label' => 'Máquina', 'type' => 'select', 'class' => 'select_basico', 'options' => $maquina, 'empty' => True, 'selected' => $this->params['url']['maquina_id'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.maquina_id', array('label' => 'Máquina', 'type' => 'select', 'class' => 'select_basico', 'empty' => True, 'options' => $maquina)) ?></td>
            <?php endif; ?>
            </tr>
            <tr>   

                <?php if (!empty($this->params['named']['articulo_nombre'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.articulo_nombre', array('label' => 'Descripción de artículo', 'title' => 'Recomendable !! el uso de este campo requiere también  filtrar por fecha !', 'value' => $this->params['named']['articulo_nombre'])) ?></td>
                <?php elseif (!empty($this->params['url']['articulo_nombre'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.articulo_nombre', array('label' => 'Descripción de artículo', 'title' => 'Recomendable !! el uso de este campo requiere tambien filtrar por fecha !', 'value' => $this->params['url']['articulo_nombre'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.articulo_nombre', array('label' => 'Descripción de artículo',)) ?></td>
                <?php endif; ?>


                <?php if (!empty($this->params['named']['resultados_por_pagina'])): ?>
                    <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000, '2000' => 2000, '3000' => 3000), 'default' => '20', 'selected' => $this->params['named']['resultados_por_pagina'])) ?></td>
                <?php elseif (!empty($this->params['url']['resultados_por_pagina'])): ?>
                    <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000, '2000' => 2000, '3000' => 3000), 'default' => '20', 'selected' => $this->params['url']['resultados_por_pagina'])) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000, '2000' => 2000, '3000' => 3000), 'default' => '20')) ?></td>
                <?php endif; ?>

            </tr>
        </table>
        <?php echo $this->Form->button('Nueva Búsqueda', array('type' => 'reset', 'class' => 'button_css_green')); ?>
        <?php echo $this->Form->end(array('label' => 'Buscar', 'div' => True, 'class' => 'button_css_blue')) ?>
    </div>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Pag. %page% de %pages%, mostrando %current% registros de %count% total. Registro %start%, de %end%', true)
        ));
        ?>	
    </p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('anterior', true), array(), null, array('class' => 'disabled')); ?>|
        <?php echo $this->Paginator->numbers(); ?> |
        <?php echo $this->Paginator->next(__('siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <?php
    $sumatorio_precio = 0;
    $sumatorio_impuestos = 0;
    $sumatorio_total = 0;
    $sumatorio_comision = 0;
    ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('serie'); ?></th>
            <th><?php echo $this->Paginator->sort('numero'); ?></th>
            <th><?php echo $this->Paginator->sort('cliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('fecha'); ?></th>
            <th><?php echo $this->Paginator->sort('observaciones'); ?></th>
            <th><?php echo $this->Paginator->sort('precio'); ?></th>
            <th><?php echo $this->Paginator->sort('impuestos'); ?></th>
            <th>Total</th>
            <th><?php echo $this->Paginator->sort('Comercial', 'comerciale_id'); ?></th>
            <th><?php echo $this->Paginator->sort('comision'); ?></th>
            <th><?php echo $this->Paginator->sort('Aviso de Repuestos', 'avisosrepuesto_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Pedido de Cliente', 'pedidoscliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Albarán Escaneado', 'albaranescaneado'); ?></th>
            <th><?php echo $this->Paginator->sort('facturable'); ?></th>
            <th><?php echo $this->Paginator->sort('Estado', 'estadosalbaranescliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('facturas_cliente_id'); ?></th>
            <th class="actions"><div align="center"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($albaranesclientes as $albaranescliente):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $albaranescliente['Albaranescliente']['serie']; ?>&nbsp;</td>
                <td><?php echo zerofill($albaranescliente['Albaranescliente']['numero']); ?>&nbsp;</td>
                <td><?php echo $albaranescliente['Cliente']['nombre']; ?>&nbsp;</td>
                <td><?php echo $this->Time->format('d-m-Y', $albaranescliente['Albaranescliente']['fecha']); ?>&nbsp;</td>
                <td>
                    <p title="<?php echo $albaranescliente['Albaranescliente']['observaciones'] ?>"><?php echo substr($albaranescliente['Albaranescliente']['observaciones'], 0, 15); ?>...</p>
                </td>
                <td><?php echo $albaranescliente['Albaranescliente']['precio']; ?>&nbsp;</td>
                <td><?php echo $albaranescliente['Albaranescliente']['impuestos']; ?>&nbsp;</td>
                <td><?php echo $albaranescliente['Albaranescliente']['precio'] + $albaranescliente['Albaranescliente']['impuestos']; ?>&nbsp;</td>
                <td><?php echo $albaranescliente['Comerciale']['nombre']; ?>&nbsp;</td>
                <td>
                    <?php if ($this->Session->read('Auth.User.role_id') == '1' || $this->Session->read('Auth.User.comerciale_id') == $albaranescliente['Albaranescliente']['comerciale_id']): ?>
                        <?php
                        echo redondear_dos_decimal($albaranescliente['Albaranescliente']['comision']);
                        $sumatorio_comision += redondear_dos_decimal($albaranescliente['Albaranescliente']['comision']);
                        ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo $this->Html->link($albaranescliente['Avisosrepuesto']['numero'], array('controller' => 'avisosrepuestos', 'action' => 'view', $albaranescliente['Avisosrepuesto']['id'])); ?>
                </td>
                <?php if (!empty($albaranescliente['Pedidoscliente']['numero'])): ?>
                    <td><?php echo $this->Html->link($albaranescliente['Pedidoscliente']['serie'] . '-' . zerofill($albaranescliente['Pedidoscliente']['numero'], 4), array('controller' => 'pedidosclientes', 'action' => 'view', $albaranescliente['Pedidoscliente']['id'])); ?></td>
                <?php else: ?>
                    <td></td>
                <?php endif; ?>
                <td><?php echo $this->Html->link(__($albaranescliente['Albaranescliente']['albaranescaneado'], true), '/files/albaranescliente/' . $albaranescliente['Albaranescliente']['albaranescaneado']); ?>&nbsp;</td>
                <td><?php echo $albaranescliente['Albaranescliente']['facturable'] == 0 ? 'No' : 'Si' ?></td>
                <td><?php echo $albaranescliente['Estadosalbaranescliente']['estado'] ?></td>
                <td>
                    <?php if (!empty($albaranescliente['Albaranescliente']['facturas_cliente_id'])): ?>
                        <?php echo $this->Html->link($albaranescliente['FacturasCliente']['numero'], array('controller' => 'facturas_clientes', 'action' => 'view', $albaranescliente['Albaranescliente']['facturas_cliente_id'])); ?></td>
                <?php else: ?>
                    No Facturado
                <?php endif; ?>

                <td class="actions">
                    <?php echo $this->Html->link(__('Prev.', true), array('action' => 'view', $albaranescliente['Albaranescliente']['id']), array('target' => '_blank'));
                    ?>
                    <?php if ($albaranescliente['Estadosalbaranescliente']['id'] <> '3'): ?>
                        <?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $albaranescliente['Albaranescliente']['id'])); ?>
                    <?php else: ?>
                        <?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $albaranescliente['Albaranescliente']['id']), array('class' => 'btn-is-disabled')); ?>
                    <?php endif; ?>
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $albaranescliente['Albaranescliente']['id'])); ?>
                    <?php echo $this->Html->link(__('PDF', true), array('action' => 'pdf', $albaranescliente['Albaranescliente']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $albaranescliente['Albaranescliente']['id']), null, sprintf(__('¿Estas seguro de eliminar el albarán nº # %s?', true), $albaranescliente['Albaranescliente']['numero'])); ?>
                </td>
            </tr>
            <?php
            $sumatorio_precio += $albaranescliente['Albaranescliente']['precio'];
            $sumatorio_impuestos += $albaranescliente['Albaranescliente']['impuestos'];
            $sumatorio_total += $albaranescliente['Albaranescliente']['precio'] + $albaranescliente['Albaranescliente']['impuestos'];
            ?>
        <?php endforeach; ?>
        <tr class="totales_pagina">
            <td colspan="5" style="text-align: right">TOTAL</td>
            <td><?php echo redondear_dos_decimal($sumatorio_precio) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_impuestos) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_total) ?></td>
            <td></td>
            <td><?php echo redondear_dos_decimal($sumatorio_comision) ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="actions"></td>
        </tr>
    </table>
    <p> 
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Pag. %page% de %pages%, mostrando %current% registros de %count% total. Registro %start%, de %end%', true)
        ));
        ?>	
    </p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('anterior', true), array(), null, array('class' => 'disabled')); ?>|
        <?php echo $this->Paginator->numbers(); ?> |
        <?php echo $this->Paginator->next(__('siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>
<script>
    dhtmlXCalendarObject.prototype.langData["es"] = {
        dateformat: '%d-%m-%Y',
        monthesFNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthesSNames: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        daysFNames: ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado", "Domingo"],
        daysSNames: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        weekstart: 1,
        weekname: "S",
        today: "Hoy",
        clear: "Limpiar"
    };
    var myCalendar = new dhtmlXCalendarObject(["calendar_inputEnt", "calendar_inputFin"]);
    myCalendar.loadUserLanguage("es");
    myCalendar.hideTime();
</script>