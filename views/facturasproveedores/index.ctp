<div class="facturasproveedores">
    <h2>
        <?php __('Facturas de proveedores'); ?>
        <?php echo $this->Html->link(__('Listar Facturas de Proveedores', true), array('controller' => 'facturasproveedores', 'action' => 'index'), array('class' => 'button_link')); ?>
    </h2>
    <div id="search_form" class="edit">
        <?php
        array_shift($this->params['url']);
        array_shift($this->params['url']);
        if (!empty($this->params['url'])) {
            $this->Paginator->options(array('url' => $this->params['url']));
        }
        // Inicializa fechas inicio Fin
        $valueFechaInicio = date("Y-m-d", strtotime('1998-01-01'));
        $valueFechaFin = date("Y-m-d");

        // Inicializa fechas inicio Fin
        if (!empty($this->params['url']['FechaInicio'])) {
            $fechaUrlInicio = date("Y-m-d", strtotime($this->params['url']['FechaInicio']));
            if ($fechaUrlInicio > $valueFechaInicio) {
                $valueFechaInicio = $fechaUrlInicio;
            }
        }

        if (!empty($this->params['named']['FechaInicio'])) {
            $valueFechaInicio = $this->params['named']['FechaInicio'];
        }

        if (!empty($this->params['url']['FechaFin'])) {
            $valueFechaFin = date("Y-m-d", strtotime($this->params['url']['FechaFin']));
        }

        if (!empty($this->params['named']['FechaFin'])) {
            $valueFechaFin = $this->params['named']['FechaFin'];
        }
        ?>
        <?php echo $this->Form->create('Facturasproveedore', array('type' => 'get')) ?>
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
                        'value' => $valueFechaInicio, 'style' => 'width: 100px;'));
                    ?>
                </td>

                <!-- Fecha Fin NUEVA -->
                <td style="width: 250px">
                    <?php
                    echo $this->Form->input('FechaFin', array('type' => 'text', 'id' => 'calendar_inputFin',
                        'value' => $valueFechaFin, 'style' => 'width: 100px;'));
                    ?>
                </td>


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

            <?php if (!empty($this->params['named']['serie_albaran'])): ?>
                <td><?php echo $this->Form->input('Search.serie_albaran', array('label' => 'Serie Albarán', 'type' => 'select', 'options' => $series_albaranes, 'empty' => True, 'selected' => $this->params['named']['serie_albaran'])) ?></td>
            <?php elseif (!empty($this->params['url']['serie_albaran'])): ?>
                <td><?php echo $this->Form->input('Search.serie_albaran', array('label' => 'Serie Albarán', 'type' => 'select', 'options' => $series_albaranes, 'empty' => True, 'selected' => $this->params['url']['serie_albaran'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.serie_albaran', array('label' => 'Serie Albarán', 'type' => 'select', 'empty' => True, 'options' => $series_albaranes)) ?></td>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['numero_albaran'])): ?>
                <td style="width: 250px"><?php echo $this->Form->input('Search.numero_albaran', array('label' => 'Nº Albarán', 'value' => $this->params['named']['numero_albaran'])) ?></td>
            <?php elseif (!empty($this->params['url']['numero_albaran'])): ?>
                <td style="width: 250px"><?php echo $this->Form->input('Search.numero_albaran', array('label' => 'Nº Albarán', 'value' => $this->params['url']['numero_albaran'])) ?></td>
            <?php else: ?>
                <td style="width: 250px"><?php echo $this->Form->input('Search.numero_albaran', array('label' => 'Nº Albarán')) ?></td>
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
            'format' => __('Página %page% de %pages%, mostrando %current% filas de %count% total, empezando en la fila %start%, finalizando en %end%', true)
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
            <th><?php echo $this->Paginator->sort('serie'); ?></th>
            <th><?php echo $this->Paginator->sort('numero'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha', 'fechafactura'); ?></th>
            <th><?php echo $this->Paginator->sort('Proveedor', 'proveedore_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Base imponible', 'baseimponible'); ?></th>
            <th>Impuestos</th>
            <th>Total</th>
            <th><?php echo $this->Paginator->sort('Observaciones'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha limite de pago', 'fechalimitepago'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha de pago', 'fechapagada'); ?></th>
            <th><?php echo $this->Paginator->sort('Factura escaneada'); ?></th>
            <th><?php echo $this->Paginator->sort('Estado', 'estadosfacturasproveedore_id'); ?></th>
            <th class="actions"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($facturasproveedores as $facturasproveedore):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $facturasproveedore['Facturasproveedore']['serie']; ?>&nbsp;</td>
                <td><?php echo $facturasproveedore['Facturasproveedore']['numero']; ?>&nbsp;</td>
                <td><?php echo $this->Time->format('d-m-Y', $facturasproveedore['Facturasproveedore']['fechafactura']); ?>&nbsp;</td>
                <td><?php echo $facturasproveedore['Proveedore']['nombre']; ?>&nbsp;</td>
                <td><?php echo redondear_dos_decimal($facturasproveedore['Facturasproveedore']['baseimponible']); ?>&nbsp;</td>
                <td><?php echo redondear_dos_decimal($facturasproveedore['Facturasproveedore']['baseimponible'] * ($facturasproveedore['Tiposiva']['porcentaje_aplicable'] / 100)); ?>&nbsp;</td>
                <td><?php echo redondear_dos_decimal($facturasproveedore['Facturasproveedore']['baseimponible']) + redondear_dos_decimal($facturasproveedore['Facturasproveedore']['baseimponible'] * ($facturasproveedore['Tiposiva']['porcentaje_aplicable'] / 100)); ?>&nbsp;</td>
                <td><?php echo $facturasproveedore['Facturasproveedore']['observaciones']; ?>&nbsp;</td>
                <td><?php echo $this->Time->format('d-m-Y', $facturasproveedore['Facturasproveedore']['fechalimitepago']); ?>&nbsp;</td>
                <td><?php echo $this->Time->format('d-m-Y', $facturasproveedore['Facturasproveedore']['fechapagada']); ?>&nbsp;</td>
                <td><?php echo $this->Html->link(__($facturasproveedore['Facturasproveedore']['facturaescaneada'], true), '/files/facturasproveedore/' . $facturasproveedore['Facturasproveedore']['facturaescaneada']); ?></td>
                <td><?php echo $facturasproveedore['Estadosfacturasproveedore']['estado']; ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $facturasproveedore['Facturasproveedore']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $facturasproveedore['Facturasproveedore']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $facturasproveedore['Facturasproveedore']['id'])); ?>
                </td>
            </tr>
            <?php
            $sumatorio_baseimponible += redondear_dos_decimal($facturasproveedore['Facturasproveedore']['baseimponible']);
            $sumatorio_impuestos += redondear_dos_decimal($facturasproveedore['Facturasproveedore']['baseimponible'] * ($facturasproveedore['Tiposiva']['porcentaje_aplicable'] / 100));
            $sumatorio_total += redondear_dos_decimal($facturasproveedore['Facturasproveedore']['baseimponible']) + redondear_dos_decimal($facturasproveedore['Facturasproveedore']['baseimponible'] * ($facturasproveedore['Tiposiva']['porcentaje_aplicable'] / 100));
            ?>
        <?php endforeach; ?>
        <tr class="totales_pagina">
            <td colspan="4">TOTALES</td>
            <td><?php echo redondear_dos_decimal($sumatorio_baseimponible) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_impuestos) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_total) ?></td>
            <td colspan="7"></td>
        </tr>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% filas de %count% total, empezando en la fila %start%, finalizando en %end%', true)
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
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