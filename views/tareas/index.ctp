<div class="tareas">
	<h2>
    <?php __('Tareas'); ?>
    <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
    </h2>
	<div id="search_form" class="edit">
        <?php
        array_shift($this->params['url']);
        array_shift($this->params['url']);?>      
         <table class="view">
            <tr>
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
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        ?>	
    </p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>|
        <?php echo $this->Paginator->numbers(); ?> |
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <?php
    $sumatorio_total_materiales_costo = 0;
    ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID');?></th>
			<th><?php echo $this->Paginator->sort('Nº Orden');?></th>
			<th><?php echo $this->Paginator->sort('Descripción');?></th>
			<th><?php echo $this->Paginator->sort('Coste materiales');?></th>
			<th class="actions"><div align="center"><?php __('Acciones');?></th>
	</tr>
	
	
	<?php
	$i = 0;
	foreach ($tareas as $tarea):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $tarea['Tarea']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($tarea['Ordene']['id'], array('controller' => 'ordenes', 'action' => 'view', $tarea['Ordene']['id'])); ?>
		</td>
		<td><?php echo $tarea['Tarea']['descripcion']; ?>&nbsp;</td>
		<td><?php echo $tarea['Tarea']['total_materiales_costo']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $tarea['Tarea']['id'])); ?>
			<?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $tarea['Tarea']['id'])); ?>
			<?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $tarea['Tarea']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tarea['Tarea']['id'])); ?>
            <?php echo $this->Html->link(__('Pdf', true), array('action' => 'pdf', $tarea['Tarea']['id'])); ?>
		</td>
		 <?php
            $sumatorio_total_materiales_costo += $tarea['Tarea']['total_materiales_costo'];
            
            ?>
        <?php endforeach; ?>
        <tr class="totales_pagina">
            <td colspan="3" style="text-align: right">TOTAL</td>
            <td><?php echo redondear_dos_decimal($sumatorio_total_materiales_costo) ?></td>
            <td></td>
            <td class="actions"></td>
        </tr>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<!--<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Tarea', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Ordenes', true), array('controller' => 'ordenes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ordene', true), array('controller' => 'ordenes', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
