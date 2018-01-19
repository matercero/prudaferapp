<div class="pedidosproveedores">
    <h2>
        <?php __('Pedidos a Proveedores'); ?>
        <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Listar Presupuestos', true), array('controller' => 'presupuestosproveedores', 'action' => 'index'), array('class' => 'button_link')); ?>
    </h2>
    <div id="search_form" class="edit">
        <?php echo $this->Form->create('Pedidosproveedore', array('type' => 'get')) ?>
        <?php
        array_shift($this->params['url']);
        array_shift($this->params['url']);
        if (!empty($this->params['url'])) {
            $this->Paginator->options(array('url' => $this->params['url']));
        }
        // Inicializa fechas inicio Fin
        if (empty($this->params['url']['FechaInicio'])) {
            $this->params['url']['FechaInicio'] = '1998-01-01';
        }
        if (empty($this->params['url']['FechaFin'])) {
            $this->params['url']['FechaFin'] = date("Y-m-d");
        }
        // Inicializa fechas inicio Fin
        if (empty($this->params['url']['FechaInicioEntrega'])) {
            $this->params['url']['FechaInicioEntrega'] = '1998-01-01';
        }
        if (empty($this->params['url']['FechaFinEntrega'])) {
            $this->params['url']['FechaFinEntrega'] = date("Y-m-d");
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

                <!-- Fecha inicio NUEVA -->
                <td style="width: 250px">
                    <?php
                    echo $this->Form->input('FechaInicio', array('type' => 'text', 'id' => 'calendar_inputEnt',
                        'value' => $this->params['url']['FechaInicio'], 'style' => 'width: 100px;'));
                    ?>
                </td>

                <!-- Fecha Fin NUEVA -->
                <td style="width: 250px">
                    <?php
                    echo $this->Form->input('FechaFin', array('type' => 'text', 'id' => 'calendar_inputFin',
                        'value' => $this->params['url']['FechaFin'], 'style' => 'width: 100px;'));
                    ?>
                </td>

                <td><?php echo $this->Form->input('Search.articulo_id', array('label' => 'Árticulo', 'type' => 'text', 'class' => 'articulos_select', 'style' => 'width: 300px;')) ?></td>
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
            <td><?php echo $this->Form->input('Search.proveedore_id', array('label' => 'Proveedor', 'type' => 'text', 'class' => 'proveedores_select', 'style' => 'width: 300px;')) ?></td>
            <?php if (!empty($this->params['named']['proveedore_id'])): ?>
                <script>
                    $(document).ready(function () {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>proveedores/get_json/<?php echo $this->params['named']['proveedore_id'] ?>', function (data) {
                                    $(".proveedores_select").select2("data", {
                                        'id': data.id,
                                        'nombre': data.nombre
                                    });
                                });
                            });
                </script>
            <?php elseif (!empty($this->params['url']['proveedore_id'])): ?>
                <script>
                    $(document).ready(function () {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>proveedores/get_json/<?php echo $this->params['url']['proveedore_id'] ?>', function (data) {
                                    $(".proveedores_select").select2("data", {
                                        'id': data.id,
                                        'nombre': data.nombre
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
                    $(document).ready(function () {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>maquinas/get_json/<?php echo $this->params['named']['maquina_id'] ?>', function (data) {
                                    $(".maquinas_select").select2("data", {
                                        'id': data.id,
                                        'codigo': data.codigo,
                                        'nombre': data.nombre
                                    });
                                });
                            });
                </script>
            <?php elseif (!empty($this->params['url']['maquina_id'])): ?>
                <script>
                    $(document).ready(function () {
                        $.getJSON('<?php echo Configure::read('proyect_url') ?>maquinas/get_json/<?php echo $this->params['url']['maquina_id'] ?>', function (data) {
                                    $(".maquinas_select").select2("data", {
                                        'id': data.id,
                                        'codigo': data.codigo,
                                        'nombre': data.nombre
                                    });
                                });
                            });
                </script>
            <?php endif; ?>


            <?php if (!empty($this->params['named']['estadoProveedor_id'])): ?>
                <td><?php echo $this->Form->input('Search.estadoProveedor_id', array('label' => 'Estado', 'type' => 'select', 'class' => 'select_basico', 'options' => $estadoProveedor, 'empty' => True, 'selected' => $this->params['named']['estadoProveedor_id'])) ?></td>
            <?php elseif (!empty($this->params['url']['estadoProveedor_id'])): ?>
                <td><?php echo $this->Form->input('Search.estadoProveedor_id', array('label' => 'Estado', 'type' => 'select', 'class' => 'select_basico', 'options' => $estadoProveedor, 'empty' => True, 'selected' => $this->params['url']['estadoProveedor_id'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.estadoProveedor_id', array('label' => 'Estado', 'type' => 'select', 'class' => 'select_basico', 'empty' => True, 'options' => $estadoProveedor)) ?></td>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['comerciale_id'])): ?>
                <td><?php echo $this->Form->input('Search.comerciale_id', array('label' => 'Comercial', 'type' => 'select', 'class' => 'select_basico', 'options' => $comerciales, 'empty' => True, 'selected' => $this->params['named']['comerciale_id'])) ?></td>
            <?php elseif (!empty($this->params['url']['comerciale_id'])): ?>
                <td><?php echo $this->Form->input('Search.comerciale_id', array('label' => 'Comercial', 'type' => 'select', 'class' => 'select_basico', 'options' => $comerciales, 'empty' => True, 'selected' => $this->params['url']['comerciale_id'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.comerciale_id', array('label' => 'Comercial', 'type' => 'select', 'class' => 'select_basico', 'empty' => True, 'options' => $comerciales)) ?></td>
            <?php endif; ?>
            </tr>
            <tr>

                <!-- Fecha inicio Entrega NUEVA -->
                <td style="width: 250px">
                    <?php
                    echo $this->Form->input('FechaInicioEntrega', array('type' => 'text', 'id' => 'calendar_inputEntEntrega',
                        'value' => $this->params['url']['FechaInicioEntrega'], 'style' => 'width: 100px;'));
                    ?>
                </td>

                <!-- Fecha Fin Entrega NUEVA -->
                <td style="width: 250px">
                    <?php
                    echo $this->Form->input('FechaFinEntrega', array('type' => 'text', 'id' => 'calendar_inputFinEntrega',
                        'value' => $this->params['url']['FechaFinEntrega'], 'style' => 'width: 100px;'));
                    ?>
                </td>

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
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('Serie', 'serie'); ?></th>
            <th><?php echo $this->Paginator->sort('Número', 'numero'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha', 'Presupuestosproveedore.fecha'); ?></th>
            <th><?php echo $this->Paginator->sort('Proveedor', 'Presupuestosproveedore.proveedore_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Almacen', 'Presupuestosproveedore.almacene_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Aviso de repuesto', 'Presupuestosproveedore.avisosrepuesto_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Aviso de taller', 'Presupuestosproveedore.avisostallere_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Orden', 'Presupuestosproveedore.ordene_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha de entrega', 'fecharecepcion'); ?></th>
            <th><?php echo $this->Paginator->sort('Observaciones', 'Presupuestosproveedore.observaciones'); ?></th>
            <th><?php echo $this->Paginator->sort('confirmado'); ?></th>
            <th><?php echo $this->Paginator->sort('Adjunto', 'pedidoescaneado'); ?></th>
            <th><?php echo $this->Paginator->sort('Estado', 'estadospedidosproveedore_id'); ?></th>
            <th class="actions"><?php __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($pedidosproveedores as $pedidosproveedore):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $pedidosproveedore['Pedidosproveedore']['serie']; ?>&nbsp;</td>
                <td><?php echo $pedidosproveedore['Pedidosproveedore']['numero']; ?>&nbsp;</td>
                <td><?php echo $this->Time->format('d-m-Y', $pedidosproveedore['Pedidosproveedore']['fecha']); ?>&nbsp;</td>
                <td><?php echo $this->Html->link($pedidosproveedore['Proveedore']['nombre'], array('controller' => 'proveedores', 'action' => 'view', $pedidosproveedore['Proveedore']['id'])); ?></td>
                <td><?php echo $this->Html->link($pedidosproveedore['Almacene']['nombre'], array('controller' => 'almacenes', 'action' => 'view', $pedidosproveedore['Almacene']['id'])); ?></td>  
                <td><?php echo @$this->Html->link($pedidosproveedore['Presupuestosproveedore']['Avisosrepuesto']['numero'], array('controller' => 'avisosrepuestos', 'action' => 'view', $pedidosproveedore['Presupuestosproveedore']['avisosrepuesto_id'])); ?></td>    
                <td><?php echo @$this->Html->link($pedidosproveedore['Presupuestosproveedore']['Avisostallere']['numero'], array('controller' => 'avisostalleres', 'action' => 'view', $pedidosproveedore['Presupuestosproveedore']['avisostallere_id'])); ?></td>   
                <td><?php echo @$this->Html->link($pedidosproveedore['Presupuestosproveedore']['Ordene']['numero'], array('controller' => 'ordenes', 'action' => 'view', $pedidosproveedore['Presupuestosproveedore']['ordene_id'])); ?></td>
                <td><?php echo $pedidosproveedore['Pedidosproveedore']['fecharecepcion']; ?>&nbsp;</td>
                <td><?php echo $pedidosproveedore['Pedidosproveedore']['observaciones']; ?>&nbsp;</td>
                <td><?php echo!empty($pedidosproveedore['Pedidosproveedore']['confirmado']) ? 'Sí' : 'No'; ?></td>
                <td><?php if (!empty($pedidosproveedore['Pedidosproveedore']['pedidoescaneado'])) echo $this->Html->image('clip.png', array('url' => '/files/pedidosproveedore/' . $pedidosproveedore['Pedidosproveedore']['pedidoescaneado'])); ?></td>
                <?php if ($pedidosproveedore['Estadospedidosproveedore']['id'] == 4): ?>
                    <td  style="background-color: #FF0000; color: #ffffff"><?php echo $pedidosproveedore['Estadospedidosproveedore']['estado']; ?>&nbsp;</td>
                <?php else: ?>
                    <td><?php echo $pedidosproveedore['Estadospedidosproveedore']['estado']; ?>&nbsp;</td>
                <?php endif; ?>

                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $pedidosproveedore['Pedidosproveedore']['id'])); ?>
                    <?php echo $this->Html->link(__('Pdf', true), array('action' => 'pdf', $pedidosproveedore['Pedidosproveedore']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de un total de %count%, desde %start% hasta  %end%', true)
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
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
    var myCalendar = new dhtmlXCalendarObject(["calendar_inputEnt", "calendar_inputFin", "calendar_inputEntEntrega", "calendar_inputFinEntrega"]);
    myCalendar.loadUserLanguage("es");
    myCalendar.hideTime();
</script>