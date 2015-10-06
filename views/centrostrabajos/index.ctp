<div class="centrostrabajos">
    <h2>
        <?php __('Centros de Trabajo'); ?>
        <?php echo $this->Html->link(__('Nuevo Centro Trabajo', true), array('action' => 'add'), array('class' => 'button_link')); ?>
    </h2>
    <div id="search_form" class="edit">
        <?php echo $this->Form->create('Centrostrabajo', array('type' => 'get')) ?>
        <?php
        array_shift($this->params['url']);
        array_shift($this->params['url']);
        if (!empty($this->params['url'])) {
            $this->Paginator->options(array('url' => $this->params['url']));
        }
        ?>
        <table class="view">
            <tr>
                <?php if (!empty($this->params['named']['centrotrabajo'])): ?>
                    <td style="width: 100px"><?php echo $this->Form->input('Search.centrotrabajo', array('label' => 'Nombre del Centro de Trabajo', 'value' => $this->params['named']['centrotrabajo'], 'style' => 'width: 400px;')) ?></td>
                <?php elseif (!empty($this->params['url']['centrotrabajo'])): ?>
                    <td style="width: 100px"><?php echo $this->Form->input('Search.centrotrabajo', array('label' => 'Nombre del Centro de Trabajo', 'value' => $this->params['url']['centrotrabajo'], 'style' => 'width: 400px;')) ?></td>
                <?php else: ?>
                    <td style="width: 100px"><?php echo $this->Form->input('Search.centrotrabajo', array('label' => 'Nombre del Centro de Trabajo', 'style' => 'width: 400px;')) ?></td>
                <?php endif; ?>

                <td><?php echo $this->Form->input('Search.cliente_id', array('label' => 'Cliente', 'type' => 'text', 'class' => 'clientes_select', 'style' => 'width: 500px;')) ?></td>
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

			 <?php if (!empty($this->params['named']['preciohoraencentro'])): ?>
                    <td style="width: 100px"><?php echo $this->Form->input('Search.preciohoraencentro', array('label' => 'Precio hora centro', 'value' => $this->params['named']['preciohoraencentro'], 'style' => 'width: 400px;')) ?></td>
                <?php elseif (!empty($this->params['url']['preciohoraencentro'])): ?>
                    <td style="width: 100px"><?php echo $this->Form->input('Search.preciohoraencentro', array('label' => 'Precio hora centro', 'value' => $this->params['url']['preciohoraencentro'], 'style' => 'width: 400px;')) ?></td>
                <?php else: ?>
                    <td style="width: 100px"><?php echo $this->Form->input('Search.preciohoraencentro', array('label' => 'Precio hora centro', 'style' => 'width: 400px;')) ?></td>
                <?php endif; ?>

            <?php if (!empty($this->params['named']['resultados_por_pagina'])): ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '100' => 100, '500' => 500, '1000' => 1000,  '5000' => 5000), 'default' => '20', 'selected' => $this->params['named']['resultados_por_pagina'])) ?></td>
            <?php elseif (!empty($this->params['url']['resultados_por_pagina'])): ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '100' => 100, '500' => 500, '1000' => 1000,  '5000' => 5000), 'default' => '20', 'selected' => $this->params['url']['resultados_por_pagina'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '100' => 100, '500' => 500, '1000' => 1000,  '5000' => 5000), 'default' => '20')) ?></td>
            <?php endif; ?>

            </tr>
        </table>
        <?php echo $this->Form->button('Nueva Búsqueda', array('type' => 'reset', 'class' => 'button_css_green')); ?>
        <?php echo $this->Form->end(array('label' => 'Buscar', 'div' => True, 'class' => 'button_css_blue')) ?>
    </div>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de un total de %count%, empezando en registro %start%, finalizando en el registro %end%', true)
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

            <th><?php echo $this->Paginator->sort('Centro de Trabajo','centrotrabajo'); ?></th>


            <th><?php echo $this->Paginator->sort('Cliente'); ?></th>
            <th><?php echo $this->Paginator->sort('Precio H.C.','preciohoraencentro'); ?></th>
            <th><?php echo $this->Paginator->sort('Precio H.T.','preciohoraentraller'); ?></th>
            <th><?php echo $this->Paginator->sort('Distancia','distancia'); ?></th>
			<th><?php echo $this->Paginator->sort('Tiempo despl.','tiempodesplazamiento'); ?></th>
			<th><?php echo $this->Paginator->sort('Precio Despl.','preciohoradesplazamiento'); ?></th>
			<th><?php echo $this->Paginator->sort('Precio Fijo D.','preciofijodesplazamiento'); ?></th>
            <th class="actions"><div align="center"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($centrostrabajos as $centrostrabajo):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>

                <td><?php echo $centrostrabajo['Centrostrabajo']['centrotrabajo']; ?>&nbsp;</td>

                <td>
                    <?php echo $this->Html->link($centrostrabajo['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $centrostrabajo['Cliente']['id'])); ?>
                </td>
                <td><?php echo $centrostrabajo['Centrostrabajo']['preciohoraencentro']; ?>&nbsp;</td>
                <td><?php echo $centrostrabajo['Centrostrabajo']['preciohoraentraller']; ?>&nbsp;</td>
                <td><?php echo $centrostrabajo['Centrostrabajo']['distancia']; ?>&nbsp;</td>
                <td><?php echo $centrostrabajo['Centrostrabajo']['tiempodesplazamiento']; ?>&nbsp;</td>
                <td><?php echo $centrostrabajo['Centrostrabajo']['preciohoradesplazamiento']; ?>&nbsp;</td>
                <td><?php echo $centrostrabajo['Centrostrabajo']['preciofijodesplazamiento']; ?>&nbsp;</td>
                

                <td class="actions">
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $centrostrabajo['Centrostrabajo']['id'])); ?>
                    <?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $centrostrabajo['Centrostrabajo']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $centrostrabajo['Centrostrabajo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $centrostrabajo['Centrostrabajo']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de un total de %count%, empezando en registro %start%, finalizando en el registro %end%', true)
        ));
        ?>	</p>


    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>
