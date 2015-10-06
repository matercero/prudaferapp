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
                <th colspan="2">Horas Trabajo</th>
            </tr>
            <tr>
                <th style="width: 100px;">Fecha</th>
                <th>H. Inicio / H. Final</th>
                <th>Mecánico</th>
                <th>Nº Orden</th>
                <th>Nº Tarea</th>
                <th>Parte Descripción</th>
                <th>Real</th>
                <th>Imput</th>
            </tr>
            <?php
            $total_h_real = 0;
            $total_h_imput = 0;
            ?>
            <?php foreach ($partestalleres as $parte) : ?>
                <tr>
                    <td><?php echo $this->Time->format('d-m-Y', $parte['Partestallere']['fecha']); ?> </td>
                    <td><p><?php echo $this->Time->format('H:i', $parte['Partestallere']['horainicio']) ?></p><p><?php echo $this->Time->format('H:i', $parte['Partestallere']['horafinal']) ?></p></td>
                    <td><?php echo $parte['Mecanico']['nombre'] ?></td>
                    <td><?php echo $this->Html->link(zerofill($parte['Tarea']['Ordene']['numero']), array('controller' => 'ordenes', 'action' => 'view', $parte['Tarea']['Ordene']['id']), array('target' => '_blank')) ?></td>
                    <td><?php echo zerofill($parte['Tarea']['numero'], 2) ?></td>
                    <td title="<?php echo $parte['Partestallere']['operacion'] ?>"><?php echo substr($parte['Partestallere']['operacion'], 0, 45) ?>...</td>
                    <td><?php echo number_to_comma($parte['Partestallere']['horasreales']) ?></td>
                    <?php $total_h_real += $parte['Partestallere']['horasreales']; ?>
                    <td><?php echo number_to_comma($parte['Partestallere']['horasimputables']) ?></td>
                    <?php $total_h_imput += $parte['Partestallere']['horasimputables']; ?>
                </tr>
            <?php endforeach; ?>
            <tr style="font-weight: bold;">
                <td colspan="6">TOTALES: </td>
                <td><?php echo number_to_comma($total_h_real) ?></td>
                <td><?php echo number_to_comma($total_h_imput) ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
