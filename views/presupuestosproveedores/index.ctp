<div class="presupuestosproveedores">
    <h2>
        <?php __('Presupuestos de proveedores'); ?>
        <?php echo $this->Html->link(__('Nuevo Presupuesto Directo', true), array('controller' => 'presupuestosproveedores', 'action' => 'add'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Listar Presupuestos', true), array('controller' => 'presupuestosproveedores', 'action' => 'index'), array('class' => 'button_link')); ?>
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
        <?php echo $this->Form->create('Presupuestosproveedore', array('type' => 'get')) ?>
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
            <th><?php echo $this->Paginator->sort('Serie', 'serie'); ?></th>
            <th><?php echo $this->Paginator->sort('Nº', 'numero'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha', 'fecha'); ?></th>
            <th style="width: 200px;"><?php echo $this->Paginator->sort('Proveedor', 'proveedore_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Almacén', 'almacene_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Aviso de Repuesto', 'avisosrepuesto_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Aviso de Taller', 'avisostallere_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Orden', 'ordene_id'); ?></th>
            <th style="min-width: 150px;"><?php echo $this->Paginator->sort('Plazo de Entrega', 'fechaplazo'); ?></th>
            <th><?php echo $this->Paginator->sort('Observaciones', 'observaciones'); ?></th>
            <th><?php echo $this->Paginator->sort('Estado', 'estadospresupuestosproveedore_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Presupuesto escaneado', 'presupuestoescaneado'); ?></th>
            <th class="actions"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($presupuestosproveedores as $presupuestosproveedore):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $presupuestosproveedore['Presupuestosproveedore']['serie']; ?>&nbsp;</td>
                <td><?php echo $presupuestosproveedore['Presupuestosproveedore']['numero']; ?>&nbsp;</td>
                <td><?php echo $this->Time->format('d-m-Y', $presupuestosproveedore['Presupuestosproveedore']['fecha']); ?>&nbsp;</td>
                <td><?php echo $this->Html->link($presupuestosproveedore['Proveedore']['nombre'], array('controller' => 'proveedores', 'action' => 'view', $presupuestosproveedore['Proveedore']['id'])); ?></td>
                <td><?php echo $this->Html->link($presupuestosproveedore['Almacene']['nombre'], array('controller' => 'almacenes', 'action' => 'view', $presupuestosproveedore['Almacene']['id'])); ?></td>     
                <td><?php echo @$this->Html->link($presupuestosproveedore['Avisosrepuesto']['numero'], array('controller' => 'avisosrepuestos', 'action' => 'view', $presupuestosproveedore['Avisosrepuesto']['id'])); ?></td>    
                <td><?php echo @$this->Html->link($presupuestosproveedore['Avisostallere']['numero'], array('controller' => 'avisostalleres', 'action' => 'view', $presupuestosproveedore['Avisostallere']['id'])); ?></td>   
                <td><?php echo @$this->Html->link($presupuestosproveedore['Ordene']['numero'], array('controller' => 'ordenes', 'action' => 'view', $presupuestosproveedore['Ordene']['id'])); ?></td>
                <td><?php echo $presupuestosproveedore['Presupuestosproveedore']['fechaplazo']; ?>&nbsp;</td>
                <td><?php echo $presupuestosproveedore['Presupuestosproveedore']['observaciones']; ?>&nbsp;</td>
                <td><?php echo $presupuestosproveedore['Estadospresupuestosproveedore']['estado']; ?>&nbsp;</td>
                <td><?php echo $this->Html->link(__($presupuestosproveedore['Presupuestosproveedore']['presupuestoescaneado'], true), '/files/presupuestosproveedore/' . $presupuestosproveedore['Presupuestosproveedore']['presupuestoescaneado']); ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $presupuestosproveedore['Presupuestosproveedore']['id'])); ?>
                    <?php echo $this->Html->link(__('Pdf', true), array('action' => 'pdf', $presupuestosproveedore['Presupuestosproveedore']['id'])); ?>
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