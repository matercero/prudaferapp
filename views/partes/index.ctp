<!DOCTYPE html>
<html lang="es-ES">
    <head>
        <meta http-equiv="cache-control" content="no-store, no-cache, must-revalidate" />
        <meta http-equiv="Pragma" content="no-store, no-cache" />
        <meta http-equiv="Expires" content="0" />
    </script>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php __('DAFER Gestión 1.0'); ?>
        <?php echo $title_for_layout; ?>
    </title>
    <?php
    echo $this->Html->css('cake.generic');
    echo $this->Html->css('new_style');
    ?>
</head>
<body>
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
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de %count% en total, comenzando en el registro %start%, finalizando en el %end%', true)
        ));
        ?>	
    </p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>|
        <?php echo $this->Paginator->numbers(); ?> |
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <div id="tabla_resumen" style="font-size: 0.7em;">
        <table>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="2">Horas Deplz.</th>
                <th colspan="2">Desplz.</th>
                <th colspan="2">Horas Trabajo</th>
                <th colspan="2">Dietas</th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th style="min-width: 150px">H. Inicio / H. Final</th>
                <th>Mecánico</th>
                <th>Nº Orden</th>
                <th>Nº Tarea</th>
                <th>Nº Parte</th>
                <th>Parte Descripción</th>
                <th>Real</th>
                <th>Imput</th>
                <th>Real</th>
                <th>Imput</th>
                <th>Real</th>
                <th>Imput</th>
                <th>Real</th>
                <th>Imput</th>
            </tr>
            <?php
            $total_hdez_real = 0;
            $total_hdez_imput = 0;
            $total_km_real = 0;
            $total_km_imput = 0;
            $total_h_real = 0;
            $total_h_imput = 0;
            $total_dieta_real = 0;
            $total_dieta_imput = 0;
            ?>
            <?php foreach ($partes as $parte) : ?>
                <tr>
                    <td><?php echo $this->Time->format('d-m-Y', $parte['Parte']['fecha']); ?> </td>
                    <td>
                        <p>De <?php echo $this->Time->format('H:i', $parte['Parte']['horasdesplazamientoinicio_ida']) ?> a <?php echo $this->Time->format('H:i', $parte['Parte']['horasdesplazamientofin_ida']) ?> ida</p>
                        <p>De <?php echo $this->Time->format('H:i', $parte['Parte']['horainicio']) ?> a <?php echo $this->Time->format('H:i', $parte['Parte']['horafinal']) ?> trabajo</p>
                        <p>De <?php echo $this->Time->format('H:i', $parte['Parte']['horasdesplazamientoinicio_vuelta']) ?> a <?php echo $this->Time->format('H:i', $parte['Parte']['horasdesplazamientofin_vuelta']) ?> vuelta</p>
                    </td>
                    <td><?php echo $parte['Mecanico']['nombre'] ?></td>
                    <td><?php echo $this->Html->link(zerofill($parte['Tarea']['Ordene']['numero']), array('controller' => 'ordenes', 'action' => 'view', $parte['Tarea']['Ordene']['id']), array('target' => '_blank')) ?></td>
                    <td><?php echo zerofill($parte['Tarea']['numero'], 2) ?></td>
                    <td><?php echo $parte['Parte']['numero'] ?></td>
                    <td title="<?php echo $parte['Parte']['operacion'] ?>"><?php echo substr($parte['Parte']['operacion'], 0, 45) ?>...</td>
                    <td><?php echo number_to_comma($parte['Parte']['horasdesplazamientoreales_ida'] + $parte['Parte']['horasdesplazamientoreales_vuelta']) ?></td>
                    <?php $total_hdez_real += $parte['Parte']['horasdesplazamientoreales_ida'] + $parte['Parte']['horasdesplazamientoreales_vuelta']; ?>
                    <td><?php echo number_to_comma($parte['Parte']['horasdesplazamientoimputables_ida'] + $parte['Parte']['horasdesplazamientoimputables_vuelta']) ?></td>
                    <?php $total_hdez_imput += $parte['Parte']['horasdesplazamientoimputables_ida'] + $parte['Parte']['horasdesplazamientoimputables_vuelta']; ?>
                    <td><?php echo number_to_comma($parte['Parte']['kilometrajereal_ida'] + $parte['Parte']['kilometrajereal_vuelta']) ?></td>
                    <?php $total_km_real += $parte['Parte']['kilometrajereal_ida'] + $parte['Parte']['kilometrajereal_vuelta']; ?>
                    <td><?php echo number_to_comma($parte['Parte']['kilometrajeimputable_ida'] + $parte['Parte']['kilometrajeimputable_vuelta']) ?></td>
                    <?php $total_km_imput += $parte['Parte']['kilometrajeimputable_ida'] + $parte['Parte']['kilometrajeimputable_vuelta']; ?>
                    <td><?php echo number_to_comma($parte['Parte']['horasreales']) ?></td>
                    <?php $total_h_real += $parte['Parte']['horasreales']; ?>
                    <td><?php echo number_to_comma($parte['Parte']['horasimputables']) ?></td>
                    <?php $total_h_imput += $parte['Parte']['horasimputables']; ?>
                    <td><?php echo number_to_comma($parte['Parte']['dietasreales']) ?></td>
                    <?php $total_dieta_real += $parte['Parte']['dietasreales']; ?>
                    <td><?php echo number_to_comma($parte['Parte']['dietasimputables']) ?></td>
                    <?php $total_dieta_imput += $parte['Parte']['dietasimputables']; ?>
                </tr>
            <?php endforeach; ?>
            <tr style="font-weight: bold;">
                <td colspan="7">TOTALES:</td>
                <td><?php echo number_to_comma($total_hdez_real) ?></td>
                <td><?php echo number_to_comma($total_hdez_imput) ?></td>
                <td><?php echo number_to_comma($total_km_real) ?></td>
                <td><?php echo number_to_comma($total_km_imput) ?></td>
                <td><?php echo number_to_comma($total_h_real) ?></td>
                <td><?php echo number_to_comma($total_h_imput) ?></td>
                <td><?php echo number_to_comma($total_dieta_real) ?></td>
                <td><?php echo number_to_comma($total_dieta_imput) ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
