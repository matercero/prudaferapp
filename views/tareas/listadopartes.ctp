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
    }
    ?>
    <?php echo $this->Form->create('Tarea', array('type' => 'get')) ?>
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
                <td style="width: 250px"><?php echo $this->Form->input('Search.fecha_inicio', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => 1, 'month' => 1, 'year' => 2012))) ?></td>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['fecha_fin[day]'])): ?>
                <td><?php echo $this->Form->input('Search.fecha_fin', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => $this->params['named']['fecha_fin[day]'], 'month' => $this->params['named']['fecha_fin[month]'], 'year' => $this->params['named']['fecha_fin[year]']))) ?></td>
            <?php elseif (!empty($this->params['url']['fecha_fin[day]'])): ?>
                <td><?php echo $this->Form->input('Search.fecha_fin', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => $this->params['url']['fecha_fin[day]'], 'month' => $this->params['url']['fecha_fin[month]'], 'year' => $this->params['url']['fecha_fin[year]']))) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.fecha_fin', array('type' => 'date', 'dateFormat' => 'DMY')) ?></td>
            <?php endif; ?>
            <?php if (!empty($this->params['named']['mecanicos'])): ?>
                <td><?php echo $this->Form->input('Search.mecanico_id', array('label' => 'Mecanicos', 'type' => 'select', 'multiple' => True, 'options' => $mecanicos, 'style' => 'width: 300px;', 'selected' => $this->params['named']['mecanicos'])) ?></td>
            <?php elseif (!empty($this->params['url']['mecanicos'])): ?>
                <td><?php echo $this->Form->input('Search.mecanico_id', array('label' => 'Mecanicos', 'type' => 'select', 'multiple' => True, 'options' => $mecanicos, 'style' => 'width: 300px;', 'selected' => $this->params['url']['mecanicos'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.mecanico_id', array('label' => 'Mecanicos', 'type' => 'select', 'multiple' => True, 'options' => $mecanicos, 'style' => 'width: 300px;')) ?></td>
            <?php endif; ?>   
            <?php if (!empty($this->params['named']['resultados_por_pagina'])): ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '40' => 40, '60' => 60, '80' => 80), 'default' => '20', 'selected' => $this->params['named']['resultados_por_pagina'])) ?></td>
            <?php elseif (!empty($this->params['url']['resultados_por_pagina'])): ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '40' => 40, '60' => 60, '80' => 80), 'default' => '20', 'selected' => $this->params['url']['resultados_por_pagina'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '40' => 40, '60' => 60, '80' => 80), 'default' => '20')) ?></td>
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
    </table>
    <?php echo $this->Form->button('Nueva Búsqueda', array('type' => 'reset', 'class' => 'button_css_green')); ?>
    <?php echo $this->Form->end(array('label' => 'Buscar', 'div' => True, 'class' => 'button_css_blue')) ?>
</div>
<iframe src="<?php echo Configure::read('proyect_url'); ?>partes/index<?php echo substr($_SERVER['QUERY_STRING'], 24) ?>" width="58%" frameborder='0' height="500px "></iframe>
<iframe src="<?php echo Configure::read('proyect_url'); ?>partestalleres/index<?php echo substr($_SERVER['QUERY_STRING'], 24) ?>" width="40%" frameborder='0' height="500px"></iframe>
<div  id="tabla_resumen">
    <table>
        <tr>
            <th>Mecánicos</th>
            <th colspan="2">Horas Desplz.</th>
            <th></th>
            <th colspan="2">Km Desplaz.</th>
            <th colspan="2">Dietas</th>
            <th colspan="2">Horas Centro</th>
            <th colspan="2">Horas Taller</th>
        </tr>
        <tr>
            <th></th>
            <th>Real</th>
            <th>Imput</th>
            <th>Productividad h.d. %</th>
            <th>Real</th>
            <th>Imput</th>
            <th>Real</th>
            <th>Imput</th>
            <th>Real</th>
            <th>Imput</th>
            <th>Real</th>
            <th>Imput</th>
            <th>Total H. R</th>
            <?php if ($es_un_dia == true): ?>
                <th>Total h. día</th>
            <?php endif ?>
            <th>Productividad h.t. %</th>
            <th>Horas Extra</th>
            <th>Productividad %</th>
        </tr>
        <?php
        $total_dez_real = 0;
        $total_dez_imput = 0;
        $total_km_real = 0;
        $total_km_imput = 0;
        $total_diet_real = 0;
        $total_diet_imput = 0;
        $total_hc_real = 0;
        $total_hc_imput = 0;
        $total_ht_real = 0;
        $total_ht_imput = 0;
        $total_h_real = 0;
        $total_h_imput = 0;
        $total_h_extra = 0;
        ?>
        <?php foreach ($partestotales_group as $partestotal): ?>
            <?php if (!empty($partestotal['nombre'])): ?>
                <tr>
                    <td><?php echo $partestotal['nombre'] ?></td>
                    <td><?php echo @number_to_comma($partestotal['total_horasdesplazamiento_real']) ?></td>
                    <?php $total_dez_real += @$partestotal['total_horasdesplazamiento_real']; ?>
                    <td><?php echo @number_to_comma($partestotal['total_horasdesplazamiento_imputables']) ?></td>
                    <?php $total_dez_imput += @$partestotal['total_horasdesplazamiento_imputables']; ?>
                    <td><?php echo @number_to_comma(($partestotal['total_horasdesplazamiento_imputables']) * 100 / ($partestotal['total_horasdesplazamiento_real'])) ?> %</td>
                    <td><?php echo @number_to_comma($partestotal['total_kilometrajereal']) ?></td>
                    <?php $total_km_real += @$partestotal['total_kilometrajereal']; ?>
                    <td><?php echo @number_to_comma($partestotal['total_kilometrajeimputable']) ?></td>
                    <?php $total_km_imput += @$partestotal['total_kilometrajeimputable']; ?>
                    <td><?php echo @number_to_comma($partestotal['total_dietasreales']) ?></td>
                    <?php $total_diet_real += @$partestotal['total_dietasreales']; ?>
                    <td><?php echo @number_to_comma($partestotal['total_dietasimputables']) ?></td>
                    <?php $total_diet_imput += @$partestotal['total_dietasimputables']; ?>
                    <td><?php echo @number_to_comma($partestotal['total_horascentro_reales']) ?></td>
                    <?php $total_hc_real += @$partestotal['total_horascentro_reales']; ?>
                    <td><?php echo @number_to_comma($partestotal['total_horascentro_imputables']) ?></td>
                    <?php $total_hc_imput += @$partestotal['total_horascentro_imputables']; ?>
                    <td><?php echo @number_to_comma($partestotal['total_horastaller_reales']) ?></td>
                    <?php $total_ht_real += @$partestotal['total_horastaller_reales']; ?>
                    <td><?php echo @number_to_comma($partestotal['total_horastaller_imputables']) ?></td>
                    <?php $total_ht_imput += @$partestotal['total_horastaller_imputables']; ?>
                    <td><?php echo @number_to_comma($partestotal['total_horasdesplazamiento_real'] + $partestotal['total_horascentro_reales'] + $partestotal['total_horastaller_reales']) ?></td>
                    <?php $total_h_real += @($partestotal['total_horasdesplazamiento_real'] + $partestotal['total_horascentro_reales'] + $partestotal['total_horastaller_reales']); ?>
                    <?php $total_h_imput += @($partestotal['total_horastaller_imputables'] + $partestotal['total_horascentro_imputables']); ?>
                    <?php if ($es_un_dia): ?>
                        <td><?php echo @number_to_comma($partestotal['total_horascentro_reales'] + $partestotal['total_horastaller_reales'] + $partestotal['total_horasdesplazamiento_real']) ?></td>
                    <?php endif ?>
                    <td><?php echo @number_to_comma(($partestotal['total_horascentro_imputables'] + $partestotal['total_horastaller_imputables']) * 100 / ($partestotal['total_horascentro_reales'] + $partestotal['total_horastaller_reales'])) ?> %</td>
                    <?php
                    if ($partestotal['total_horas_extra'] < 0) {
                        $partestotal['total_horas_extra'] = 0;
                    }
                    ?>
                    <td><?php echo @number_to_comma($partestotal['total_horas_extra']) ?></td>
                    <?php $total_h_extra += @($partestotal['total_horas_extra']); ?>
                    <td><?php echo @number_to_comma(($partestotal['total_horasdesplazamiento_imputables'] + $partestotal['total_horascentro_imputables'] + $partestotal['total_horastaller_imputables']) / ($partestotal['total_horasdesplazamiento_real'] + $partestotal['total_horascentro_reales'] + $partestotal['total_horastaller_reales']) * 100) ?> %</td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td style="font-weight: bold">TOTALES</td>
            <td><?php echo @number_to_comma($total_dez_real) ?></td>
            <td><?php echo @number_to_comma($total_dez_imput) ?></td>
            <td><?php echo @number_to_comma($total_dez_imput * 100 / $total_dez_real) ?> %</td>
            <td><?php echo @number_to_comma($total_km_real) ?></td>
            <td><?php echo @number_to_comma($total_km_imput) ?></td>
            <td><?php echo @number_to_comma($total_diet_real) ?></td>
            <td><?php echo @number_to_comma($total_diet_imput) ?></td>
            <td><?php echo @number_to_comma($total_hc_real) ?></td>
            <td><?php echo @number_to_comma($total_hc_imput) ?></td>
            <td><?php echo @number_to_comma($total_ht_real) ?></td>
            <td><?php echo @number_to_comma($total_ht_imput) ?></td>
            <td><?php echo @number_to_comma($total_h_real) ?></td>
            <?php if ($es_un_dia): ?>
                <td></td>
            <?php endif ?>
            <td><?php echo @number_to_comma($total_h_imput * 100 / $total_h_real) ?> %</td>
            <td><?php echo @number_to_comma($total_h_extra) ?></td>
            <td><?php echo @number_to_comma(($total_dez_imput + $total_hc_imput + $total_ht_imput) / ($total_dez_real + $total_hc_real + $total_ht_real) * 100) ?> %</td>
            <td></td>
        </tr>
    </table>
</div>
