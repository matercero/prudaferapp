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
            <td><?php echo $this->Form->input('Search.cliente_id', array('label' => 'Cliente', 'type' => 'text', 'class' => 'clientes_select', 'style' => 'width: 300px;')) ?></td>
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
    $sumatorio_totaldesplazamiento = 0;
    $sumatorio_totaldietasimputables = 0;
    $sumatorio_totalotroserviciosimputables = 0;
    $sumatorio_baseimponible = 0;
    $sumatorio_impuestos = 0;
    $sumatorio_total = 0;
    $flagBlanco = true;
    ?>
    <table cellpadding="0" cellspacing="0">
        <tr>  
            <th><?php echo $this->Paginator->sort('fecha'); ?></th>
            <th><?php echo $this->Paginator->sort('Serie', 'serie'); ?></th>
            <th><?php echo $this->Paginator->sort('Nº', 'numero'); ?></th>
            <th><?php echo $this->Paginator->sort('cliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('observaciones'); ?></th>
            <th>Precio<br/>Mat.</th>
            <th>Precio<br/>M.Obra</th>
            <th>Dezplaz.</th>
            <th>Dieta</th>
            <th>Otros Servicios</th>            
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
//        echo('<pre>');
//        var_dump($albaranesclientesreparaciones);
//        echo('</pre>');

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

                <?php if (!empty($albaranesclientesreparacione['TareasAlbaranesclientesreparacione'])): ?>
                    <?php
                    echo 'SIZE=' . sizeof($albaranesclientesreparacione['TareasAlbaranesclientesreparacione']);
                    $sizeTareas = sizeof($albaranesclientesreparacione['TareasAlbaranesclientesreparacione']);
                    $acumuladoHoras = 0;
                    $acumuladoDezpl = 0;
                    $acumuladoDieta = 0;
                    $acumuladoServ = 0;
                    ?>
                    <?php foreach ($albaranesclientesreparacione['TareasAlbaranesclientesreparacione'] as $tarea): ?>
                        <?php if ($sizeTareas >= 2) : ?>
                            <?php
                            $acumuladoHoras += $tarea['total_horastrabajoprecio_imputable'];
                            if ($tarea['totaldesplazamientoimputado'] != 0) :
                                $acumuladoDezpl += $tarea['totaldesplazamientoimputado'];
                            else :
                                $acumuladoDezpl += $tarea['totalpreciodesplazamiento'];
                            endif;
                            $acumuladoDieta += $tarea['totaldietasimputables'];
                            $acumuladoServ += $tarea['totalotroserviciosimputables'];
                            ?>
                        <?php else : ?>
                            <!-- SOLO ES DE UN TIPO. CENTRO O TALLER -->
                            <?php if ($tarea['tipo'] == 'centro'): ?>
                                <td><?php echo $tarea['total_horastrabajoprecio_imputable'] ?></td>
                                <td><?php if ($tarea['totaldesplazamientoimputado'] != 0) : ?>
                                        <?php echo $tarea['totaldesplazamientoimputado']; ?>
                                    <?php else : ?>
                                        <?php echo $tarea['totalpreciodesplazamiento']; ?>
                                    <?php endif; ?>                        
                                </td>
                                <td><?php echo $tarea['totaldietasimputables'] ?> </td>
                                <td><?php echo $tarea['totalotroserviciosimputables'] ?></td>
                                <?php ?>
                            <?php elseif ($tarea['tipo'] == 'taller'): ?>
                                <td><?php echo $tarea['total_horastrabajoprecio_imputable'] ?></td>
                                <td>0</td>
                                <td>0</td>
                                <td><?php echo $tarea['totalotroserviciosimputables'] ?></td>
                            <?php else : //no hace nada  ?>                            
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($sizeTareas >= 2) : ?>
                        <!-- IMPRIMIMOS POR PANTALLA  -->
                        <td><?php echo $acumuladoHoras ?></td>
                        <td><?php echo $acumuladoDezpl ?></td>
                        <td><?php echo $acumuladoDieta ?></td>
                        <td><?php echo $acumuladoServ ?></td>                            
                    <?php endif; ?>

                <?php endif; ?>


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
                    <?php echo $this->Html->link(__('Prev.', true), array('action' => 'view', $albaranesclientesreparacione['Albaranesclientesreparacione']['id']), array('target' => '_blank'));
                    ?>
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $albaranesclientesreparacione['Albaranesclientesreparacione']['id'])); ?>
                    <?php echo $this->Html->link(__('PDF', true), array('action' => 'pdf', $albaranesclientesreparacione['Albaranesclientesreparacione']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $albaranesclientesreparacione['Albaranesclientesreparacione']['id']), array('class' => 'button_link'), sprintf(__('¿Seguro que quieres borrar el Albaran de Reparación Nº # %s?', true), $albaranesclientesreparacione['Albaranesclientesreparacione']['numero'])); ?> 
                </td>
            </tr>

            <?php
            $sumatorio_precio_mat += $albaranesclientesreparacione['Albaranesclientesreparacione']['total_materiales'];
            $sumatorio_precio_obra += $tarea['total_horastrabajoprecio_imputable'];
            if ($tarea['totaldesplazamientoimputado'] != 0) {
                $sumatorio_totaldesplazamiento += $tarea['totaldesplazamientoimputado'];
            } else {
                $sumatorio_totaldesplazamiento += $tarea['totalpreciodesplazamiento'];
            }
            $sumatorio_totaldietasimputables += $tarea['totaldietasimputables'];
            $sumatorio_totalotroserviciosimputables += $tarea['totalotroserviciosimputables'];
            $sumatorio_baseimponible += $albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'];
            $sumatorio_impuestos += redondear_dos_decimal($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] * $albaranesclientesreparacione['Tiposiva']['porcentaje_aplicable'] / 100);
            $sumatorio_total += redondear_dos_decimal($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] + ($albaranesclientesreparacione['Albaranesclientesreparacione']['baseimponible'] * $albaranesclientesreparacione['Tiposiva']['porcentaje_aplicable'] / 100));
            ?>
        <?php endforeach; ?>
        <tr class="totales_pagina">
            <td colspan="5">TOTALES</td>
            <td><?php echo redondear_dos_decimal($sumatorio_precio_mat) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_precio_obra) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_totaldesplazamiento) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_totaldietasimputables) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_totalotroserviciosimputables) ?></td>            
            <td><?php echo redondear_dos_decimal($sumatorio_baseimponible) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_impuestos) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_total) ?></td>
            <td colspan="9"></td>
        </tr>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Pag. %page% de %pages%, mostrando %current% registros de %count% total. Registro %start%, de %end%', true)
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
    var myCalendar = new dhtmlXCalendarObject(["calendar_inputEnt", "calendar_inputFin"]);
    myCalendar.loadUserLanguage("es");
    myCalendar.hideTime();
</script>