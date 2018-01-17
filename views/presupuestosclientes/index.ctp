<div class="presupuestosclientes">
    <h2>
        <?php __('Presupuestos a Clientes'); ?>
        <?php echo $this->Html->link(__('Listar Presupuestos a Clientes', true), array('action' => 'index'), array('class' => 'button_link')); ?> 
        <?php echo $this->Html->link(__('Nuevo Presupuesto a Cliente', true), array('action' => 'add'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Imprimir', true), '#?', array('class' => 'button_link')); ?> 
    </h2>
    <div id="search_form" class="edit">
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
        ?>
        <?php echo $this->Form->create('Presupuestoscliente', array('type' => 'get')) ?>
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
                    echo $this->Form->input('FechaInicio', array('type' => 'text', 'id' => 'calendar_inputEnt2',
                        'value' => $this->params['url']['FechaInicio'], 'style' => 'width: 100px;'))
                    ?>
                </td>

                <!-- Fecha Fin NUEVA -->
                <td style="width: 250px">
                    <?php
                    echo $this->Form->input('FechaFin', array('type' => 'text', 'id' => 'calendar_inputFin2',
                        'value' => $this->params['url']['FechaFin'], 'style' => 'width: 100px;'))
                    ?>
                </td>

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
                <?php if (!empty($this->params['named']['numero_avisosrepuesto'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Repuestos', 'value' => $this->params['named']['numero_avisosrepuesto'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_avisosrepuesto'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Repuestos', 'value' => $this->params['url']['numero_avisosrepuesto'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Repuestos',)) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['numero_avisostallere'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller', 'value' => $this->params['named']['numero_avisostallere'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_avisostallere'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller', 'value' => $this->params['url']['numero_avisostallere'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller',)) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['numero_ordene'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº Orden', 'value' => $this->params['named']['numero_ordene'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_ordene'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº Orden', 'value' => $this->params['url']['numero_ordene'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº Orden',)) ?></td>
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
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <?php
    $sumatorio_precio_mat = 0;
    $sumatorio_precio_obra = 0;
    $sumatorio_precio = 0;
    $sumatorio_impuestos = 0;
    ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('Serie.', 'serie'); ?></th>
            <th><?php echo $this->Paginator->sort('Nº.', 'numero'); ?></th>
            <th><?php echo $this->Paginator->sort('Cliente', 'cliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('fecha'); ?></th>
            <th><?php echo $this->Paginator->sort('observaciones'); ?></th>
            <th><?php echo $this->Paginator->sort('precio_mat'); ?></th>
            <th><?php echo $this->Paginator->sort('precio_obra'); ?></th>
            <th><?php echo $this->Paginator->sort('precio'); ?></th>
            <th><?php echo $this->Paginator->sort('impuestos'); ?></th>
            <th><?php echo $this->Paginator->sort('Av. Repuestos', 'avisosrepuesto_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Orden', 'ordene_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Av. Taller', 'avisostallere_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Estado', 'estadospresupuestoscliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Comercial', 'comerciale_id'); ?></th>
            <th><?php echo $this->Paginator->sort('avisar'); ?></th>
            <th class="actions"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($presupuestosclientes as $presupuestoscliente):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $presupuestoscliente['Presupuestoscliente']['serie']; ?>&nbsp;</td>
                <td><?php echo $presupuestoscliente['Presupuestoscliente']['numero']; ?>&nbsp;</td>
                <td><?php echo $this->Html->link($presupuestoscliente['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $presupuestoscliente['Cliente']['id'])); ?></td>
                <td><?php echo $this->Time->format('d-m-Y', $presupuestoscliente['Presupuestoscliente']['fecha']); ?></td>
                <td><span title="<?php echo $presupuestoscliente['Presupuestoscliente']['observaciones']; ?>"><?php echo substr($presupuestoscliente['Presupuestoscliente']['observaciones'], 0, 40); ?>...</span></td>
                <td><?php echo $presupuestoscliente['Presupuestoscliente']['precio_mat']; ?>&nbsp;</td>
                <td><?php echo $presupuestoscliente['Presupuestoscliente']['precio_obra']; ?>&nbsp;</td>
                <td><?php echo $presupuestoscliente['Presupuestoscliente']['precio']; ?>&nbsp;</td>
                <td><?php echo $presupuestoscliente['Presupuestoscliente']['impuestos']; ?>&nbsp;</td>
                <td><?php echo $this->Html->link($presupuestoscliente['Avisosrepuesto']['numero'], array('controller' => 'avisosrepuestos', 'action' => 'view', $presupuestoscliente['Avisosrepuesto']['id'])); ?></td>
                <td><?php echo $this->Html->link($presupuestoscliente['Ordene']['numero'], array('controller' => 'ordenes', 'action' => 'view', $presupuestoscliente['Ordene']['id'])); ?></td>
                <td><?php echo $this->Html->link($presupuestoscliente['Avisostallere']['numero'], array('controller' => 'avisostalleres', 'action' => 'view', $presupuestoscliente['Avisostallere']['id'])); ?></td>
                <td><?php echo $presupuestoscliente['Estadospresupuestoscliente']['estado']; ?>&nbsp;</td>
                <td><?php echo $this->Html->link($presupuestoscliente['Comerciale']['nombre'], array('controller' => 'comerciales', 'action' => 'view', $presupuestoscliente['Comerciale']['id'])); ?></td>
                <td><?php echo $presupuestoscliente['Presupuestoscliente']['avisar']; ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $presupuestoscliente['Presupuestoscliente']['id'])); ?>
                    <?php echo $this->Html->link(__('PDF', true), array('action' => 'pdf', $presupuestoscliente['Presupuestoscliente']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $presupuestoscliente['Presupuestoscliente']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $presupuestoscliente['Presupuestoscliente']['id'])); ?>
                </td>
            </tr>

            <?php
            $sumatorio_precio_mat += $presupuestoscliente['Presupuestoscliente']['precio_mat'];
            $sumatorio_precio_obra += $presupuestoscliente['Presupuestoscliente']['precio_obra'];
            $sumatorio_precio += $presupuestoscliente['Presupuestoscliente']['precio'];
            $sumatorio_impuestos += $presupuestoscliente['Presupuestoscliente']['impuestos'];
            ?>
        <?php endforeach; ?>
        <tr class="totales_pagina">
            <td colspan="5">Totales</td>
            <td><?php echo redondear_dos_decimal($sumatorio_precio_mat) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_precio_obra) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_precio) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_impuestos) ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="actions">?></td>
        </tr>
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
    var myCalendar = new dhtmlXCalendarObject(["calendar_inputEnt2", "calendar_inputFin2"]);
    myCalendar.loadUserLanguage("es");
    myCalendar.hideTime();
</script>