<div class="articulos">
    <h2>
        <?php __('Maestro de Artículos'); ?>
        <?php echo $this->Html->link(__('Nuevo Artículo', true), array('action' => 'add'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Listar Artículos', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Regularizar Almacén', true), '#?', array('class' => 'button_link', 'id' => 'regularizar')); ?>
    </h2>
    <div id="search_form" class="edit">
        <?php echo $this->Form->create('Articulo', array('type' => 'get')) ?>
        <?php
        array_shift($this->params['url']);
        array_shift($this->params['url']);
        if (!empty($this->params['url'])) {
            $this->Paginator->options(array('url' => $this->params['url']));
        }
        ?>
        <table class="view">
            <tr>
                <?php if (!empty($this->params['named']['ref'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.ref', array('label' => 'Referencia', 'value' => $this->params['named']['ref'])) ?></td>
                <?php elseif (!empty($this->params['url']['ref'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.ref', array('label' => 'Referencia', 'value' => $this->params['url']['ref'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.ref', array('label' => 'Referencia')) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['nombre'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre', array('label' => 'Descripcion', 'value' => $this->params['named']['nombre'])) ?></td>
                <?php elseif (!empty($this->params['url']['nombre'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre', array('label' => 'Descripcion', 'value' => $this->params['url']['nombre'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.nombre', array('label' => 'Descripcion',)) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['codigobarras'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.codigobarras', array('value' => $this->params['named']['codigobarras'])) ?></td>
                <?php elseif (!empty($this->params['url']['codigobarras'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.codigobarras', array('value' => $this->params['url']['codigobarras'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.codigobarras') ?></td>
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

            <?php if (!empty($this->params['named']['almacene_id'])): ?>
                <td><?php echo $this->Form->input('Search.almacene_id', array('label' => 'Almacén', 'type' => 'select', 'options' => $almacenes, 'class' => 'select_basico', 'empty' => True, 'selected' => $this->params['named']['almacene_id'])) ?></td>
            <?php elseif (!empty($this->params['url']['almacene_id'])): ?>
                <td><?php echo $this->Form->input('Search.almacene_id', array('label' => 'Almacén', 'type' => 'select', 'options' => $almacenes, 'class' => 'select_basico', 'empty' => True, 'selected' => $this->params['url']['almacene_id'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.almacene_id', array('label' => 'Almacén', 'type' => 'select', 'empty' => True, 'options' => $almacenes, 'class' => 'select_basico')) ?></td>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['familia_id'])): ?>
                <td><?php echo $this->Form->input('Search.familia_id', array('label' => 'Familia', 'type' => 'select', 'options' => $familias, 'class' => 'select_basico', 'empty' => True, 'selected' => $this->params['named']['familia_id'])) ?></td>
            <?php elseif (!empty($this->params['url']['familia_id'])): ?>
                <td><?php echo $this->Form->input('Search.familia_id', array('label' => 'Familia', 'type' => 'select', 'options' => $familias, 'class' => 'select_basico', 'empty' => True, 'selected' => $this->params['url']['familia_id'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.familia_id', array('label' => 'Familia', 'type' => 'select', 'empty' => True, 'options' => $familias, 'class' => 'select_basico')) ?></td>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['resultados_por_pagina'])): ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '500' => 500, '1000' => 1000, '5000' => 5000, '10000' => 10000, '100000' => 100000), 'default' => '20', 'selected' => $this->params['named']['resultados_por_pagina'])) ?></td>
            <?php elseif (!empty($this->params['url']['resultados_por_pagina'])): ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '500' => 500, '1000' => 1000, '5000' => 5000, '10000' => 10000, '100000' => 100000), 'default' => '20', 'selected' => $this->params['url']['resultados_por_pagina'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados por Página', 'type' => 'select', 'options' => array('20' => 20, '500' => 500, '1000' => 1000, '5000' => 5000, '10000' => 10000, '100000' => 100000), 'default' => '20')) ?></td>
            <?php endif; ?>
            </tr>
            <tr>
                <?php if (!empty($this->params['named']['localizacion_de'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.localizacion_de', array('label' => 'Localización de', 'value' => $this->params['named']['localizacion_de'])) ?></td>
                <?php elseif (!empty($this->params['url']['localizacion_de'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.localizacion_de', array('label' => 'Localización de', 'value' => $this->params['url']['localizacion_de'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.localizacion_de', array('label' => 'Localización de')) ?></td>
                <?php endif; ?>
                <?php if (!empty($this->params['named']['localizacion_hasta'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.localizacion_hasta', array('label' => 'Localización hasta', 'value' => $this->params['named']['localizacion_hasta'])) ?></td>
                <?php elseif (!empty($this->params['url']['localizacion_hasta'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.localizacion_hasta', array('label' => 'Localización hasta', 'value' => $this->params['url']['localizacion_hasta'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.localizacion_hasta', array('label' => 'Localización hasta')) ?></td>
                <?php endif; ?>
            </tr>   
        </table>          
        <?php echo $this->Form->button('Nueva Búsqueda', array('type' => 'reset', 'class' => 'button_css_green')); ?>
        <?php echo $this->Form->end(array('label' => 'Buscar', 'div' => True, 'class' => 'button_css_blue')) ?>
    </div>
    <div class="actions" style="width: 30%;margin: 10px"> 
        <?php echo $this->Html->link(__('IMPORTAR Articulos desde .CSV', true), array('action' => 'import'), array('class' => 'button_link_import')) . "<br />" ?>
    </div>
    <?php echo $this->Form->create('Presupuestosproveedore', array('action' => 'add')) ?>
    <?php echo $this->Form->submit('Nuevo Presupuesto Directo', array('div' => false, 'style' => 'font-size: 20px;')); ?>
    <h4 style="margin-top: 20px;"></h4>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Página %page% de %pages%, mostrando %current% registros de un total de %count%, empezando en registro %start%, finalizando en el registro %end%', true)
        ));
        ?>
    </p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('Anterior', true), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__('Siguiente', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
    <?php
    $sumatorio_ultimopreciocompra = 0;
    $sumatorio_valoracion = 0;
    $sumatorio_precio_sin_iva = 0;
    $sumatorio_existencias = 0;
    $sumatorio_costetuds = 0;
    ?>
    <table cellpadding="0" cellspacing="0" class="view">
        <tr>
            <th><?php echo $paginator->sort('Referencia', 'ref'); ?></th>
            <th><?php echo $paginator->sort('Descripción', 'nombre'); ?></th>
            <th><?php echo $paginator->sort('Cód. barras', 'codigobarras'); ?></th>
            <th><?php echo $paginator->sort('Precio Coste (* uds)', 'ultimopreciocompra'); ?></th>
            <th><?php echo $paginator->sort('Valoración', 'valoracion'); ?></th>
            <th><?php echo $paginator->sort('PVP', 'precio_sin_iva'); ?></th>
            <th><?php echo $paginator->sort('Almacén', 'almacene_id'); ?></th>
            <th><?php echo $paginator->sort('Localización', 'localizacion'); ?></th>
            <th><?php echo $paginator->sort('Existencias', 'existencias'); ?></th>
            <th><?php echo $paginator->sort('Coste T uds', 'costetuds'); ?></th>
            <th><?php echo $paginator->sort('Stock Min.', 'stock_minimo'); ?></th>
            <th><?php echo $paginator->sort('Stock Max.', 'stock_maximo'); ?></th>
            <th><?php echo __('A Pedir'); ?></th>
            <th><?php echo __('Validar'); ?></th>
            <th><?php echo $paginator->sort('Familia', 'familia_id'); ?></th>
            <th><?php echo $paginator->sort('Peso (Kgs)', 'peso'); ?></th>
            <th><?php echo $paginator->sort('largo (mm)', 'largo'); ?></th>
            <th><?php echo $paginator->sort('Ancho (mm)', 'ancho'); ?></th>
            <th><?php echo $paginator->sort('Alto (mm)', 'alto'); ?></th>
            <th><?php echo $paginator->sort('Importado', 'es_importado'); ?></th>
            <th class="actions"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($articulos as $articulo):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $articulo['Articulo']['ref']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['nombre']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['codigobarras']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['ultimopreciocompra']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['valoracion']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['precio_sin_iva']; ?>&nbsp;</td>
                <td><?php echo $articulo['Almacene']['nombre']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['localizacion']; ?>&nbsp;</td>
                <td id="<?php echo $articulo['Articulo']['id']; ?>" class="existencias-field"><?php echo $articulo['Articulo']['existencias']; ?>&nbsp;</td>
                <td><?php echo ($articulo['Articulo']['ultimopreciocompra'] * $articulo['Articulo']['existencias']) ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['stock_minimo']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['stock_maximo']; ?>&nbsp;</td>
                <td><?php echo ($articulo['Articulo']['stock_maximo'] - $articulo['Articulo']['existencias']) < 0 ? 0 : $articulo['Articulo']['stock_maximo'] - $articulo['Articulo']['existencias']; ?>&nbsp;</td>
                <td><?php echo $this->Form->input('validar', array('name' => 'data[articulos_validados][]', 'type' => 'checkbox', 'value' => $articulo['Articulo']['id'], 'hiddenField' => false, 'label' => false)) ?></td>
                <td><?php echo $this->Html->link($articulo['Familia']['nombre'], array('controller' => 'familias', 'action' => 'view', $articulo['Familia']['id'])); ?></td>
                <td><?php echo $articulo['Articulo']['peso']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['largo']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['ancho']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['alto']; ?>&nbsp;</td>
                <td><?php echo $articulo['Articulo']['es_importado']==1? 'Sí': 'No'; ?>&nbsp;</td>
                <td class="actions">
                    <?php
                    echo $this->Html->image("icon/pencil.svg", [
                        'alt' => 'Editar',
                        'url' => ['controller' => 'articulos',
                            'action' => 'edit', $articulo['Articulo']['id']]]);
                    ?>
                    <?php
                    echo $this->Html->image("icon/eye.svg", [
                        'alt' => 'Ver',
                        'url' => ['controller' => 'articulos',
                            'action' => 'view', $articulo['Articulo']['id']]]);
                    ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $articulo['Articulo']['id']), null, sprintf(__('¿Desea borrar el artículo %s?', true), $articulo['Articulo']['id'])); ?>
                </td>

                <?php
                $sumatorio_ultimopreciocompra += $articulo['Articulo']['ultimopreciocompra'];
                $sumatorio_valoracion += $articulo['Articulo']['valoracion'];
                $sumatorio_precio_sin_iva+= $articulo['Articulo']['precio_sin_iva'];
                $sumatorio_existencias += $articulo['Articulo']['existencias'];
                $sumatorio_costetuds += ($articulo['Articulo']['ultimopreciocompra'] * $articulo['Articulo']['existencias']);
                ?>                
            <?php endforeach; ?>
        <tr class="totales_pagina">
            <td colspan="1" style="text-align: right">TOTAL</td>
            <td></td>
            <td></td>                
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo redondear_dos_decimal($sumatorio_existencias) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_costetuds) ?></td>
            <td></td>
            <td></td>
            <td></td>     
            <td></td>
            <td></td>
            <td></td>                      
            <td></td>
            <td></td>                      
            <td class="actions"></td>
        </tr>
    </table>
    <?php echo $this->Form->end(); ?>
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
<script type="text/javascript">
    $(function () {
        var regularizar_activado = 0;
        $('#regularizar').click(function () {
            var rows = $('.existencias-field');
            if (regularizar_activado == 0) {
                rows.each(function (index) {
                    var existencias = $(this).html();
                    if (isNaN(parseInt(existencias))) {
                        existencias = 0;
                    }
                    html = '<input type="text" value="' + parseInt(existencias) + '" class="regularizar-input" />';
                    $(this).html(html);
                });
                regularizar_activado = 1;
            } else {
                rows.each(function (index) {
                    $(this).html($(this).children().val());
                });
                regularizar_activado = 0;
            }

        });

        $('.regularizar-input').live("change", function () {
            var id = $(this).parent().attr('id');
            $.post("<?php echo Configure::read('proyect_url') ?>articulos/regularizar/" + id, {nueva_existencia: $(this).val()},
                    function (data) {
                        alert(data);
                    });
        });
    });
</script>
