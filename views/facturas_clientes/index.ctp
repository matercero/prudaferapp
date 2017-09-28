<div>
    <h2><?php __('Facturas Clientes'); ?></h2>
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
            $this->Paginator->options(array('url' => $this->params['url']));
        }
        ?>
        <?php echo $this->Form->create('FacturasCliente', array('type' => 'get')) ?>
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
                    <td style="width: 150px"><?php echo $this->Form->input('Search.numero', array('value' => $this->params['named']['numero'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero'])): ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.numero', array('value' => $this->params['url']['numero'])) ?></td>
                <?php else: ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.numero') ?></td>
                <?php endif; ?>


                <td><?php echo $this->Form->input('Search.cliente_id', array('label' => 'Cliente', 'type' => 'text', 'class' => 'clientes_select', 'style' => 'width:250px;')) ?></td>
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

            <?php if (!empty($this->params['named']['serie_albaran'])): ?>
                <td><?php echo $this->Form->input('Search.serie_albaran', array('label' => 'Serie Albarán', 'type' => 'select', 'options' => $series_albaranes, 'empty' => True, 'selected' => $this->params['named']['serie_albaran'])) ?></td>
            <?php elseif (!empty($this->params['url']['serie_albaran'])): ?>
                <td><?php echo $this->Form->input('Search.serie_albaran', array('label' => 'Serie Albarán', 'type' => 'select', 'options' => $series_albaranes, 'empty' => True, 'selected' => $this->params['url']['serie_albaran'])) ?></td>
            <?php else: ?>
                <td><?php echo $this->Form->input('Search.serie_albaran', array('label' => 'Serie Albarán', 'type' => 'select', 'empty' => True, 'options' => $series_albaranes)) ?></td>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['numero_albaran'])): ?>
                <td style="width: 150px"><?php echo $this->Form->input('Search.numero_albaran', array('label' => 'Nº Albarán', 'value' => $this->params['named']['numero_albaran'])) ?></td>
            <?php elseif (!empty($this->params['url']['numero_albaran'])): ?>
                <td style="width: 150px"><?php echo $this->Form->input('Search.numero_albaran', array('label' => 'Nº Albarán', 'value' => $this->params['url']['numero_albaran'])) ?></td>
            <?php else: ?>
                <td style="width: 150px"><?php echo $this->Form->input('Search.numero_albaran', array('label' => 'Nº Albarán')) ?></td>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['fecha_inicio[day]'])): ?>
                <td style="width: 300px"><?php echo $this->Form->input('Search.fecha_inicio', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => $this->params['named']['fecha_inicio[day]'], 'month' => $this->params['named']['fecha_inicio[month]'], 'year' => $this->params['named']['fecha_inicio[year]']))) ?></td>
            <?php elseif (!empty($this->params['url']['fecha_inicio[day]'])): ?>
                <td style="width: 300px"><?php echo $this->Form->input('Search.fecha_inicio', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => $this->params['url']['fecha_inicio[day]'], 'month' => $this->params['url']['fecha_inicio[month]'], 'year' => $this->params['url']['fecha_inicio[year]']))) ?></td>
            <?php else: ?>
                <td style="width: 300px"><?php echo $this->Form->input('Search.fecha_inicio', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => 1, 'month' => 1, 'year' => 1998))) ?></td>
            <?php endif; ?>

            <?php if (!empty($this->params['named']['fecha_fin[day]'])): ?>
                <td style="width: 300px"><?php echo $this->Form->input('Search.fecha_fin', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => $this->params['named']['fecha_fin[day]'], 'month' => $this->params['named']['fecha_fin[month]'], 'year' => $this->params['named']['fecha_fin[year]']))) ?></td>
            <?php elseif (!empty($this->params['url']['fecha_fin[day]'])): ?>
                <td style="width: 300px"><?php echo $this->Form->input('Search.fecha_fin', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => array('day' => $this->params['url']['fecha_fin[day]'], 'month' => $this->params['url']['fecha_fin[month]'], 'year' => $this->params['url']['fecha_fin[year]']))) ?></td>
            <?php else: ?>
                <td style="width: 300px"><?php echo $this->Form->input('Search.fecha_fin', array('type' => 'date', 'dateFormat' => 'DMY')) ?></td>
            <?php endif; ?>

            </tr>
            <tr>
                <?php if (!empty($this->params['named']['numero_avisosrepuesto'])): ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Rep.', 'value' => $this->params['named']['numero_avisosrepuesto'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_avisosrepuesto'])): ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Rep.', 'value' => $this->params['url']['numero_avisosrepuesto'])) ?></td>
                <?php else: ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.numero_avisosrepuesto', array('label' => 'Nº Aviso de Rep.',)) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['numero_avisostallere'])): ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller', 'value' => $this->params['named']['numero_avisostallere'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_avisostallere'])): ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller', 'value' => $this->params['url']['numero_avisostallere'])) ?></td>
                <?php else: ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.numero_avisostallere', array('label' => 'Nº Aviso de Taller',)) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['numero_ordene'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº Orden', 'value' => $this->params['named']['numero_ordene'])) ?></td>
                <?php elseif (!empty($this->params['url']['numero_ordene'])): ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº Orden', 'value' => $this->params['url']['numero_ordene'])) ?></td>
                <?php else: ?>
                    <td style="width: 250px"><?php echo $this->Form->input('Search.numero_ordene', array('label' => 'Nº Orden',)) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['resultados_por_pagina'])): ?>
                    <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000), 'default' => '20', 'selected' => $this->params['named']['resultados_por_pagina'])) ?></td>
                <?php elseif (!empty($this->params['url']['resultados_por_pagina'])): ?>
                    <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000), 'default' => '20', 'selected' => $this->params['url']['resultados_por_pagina'])) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.resultados_por_pagina', array('label' => 'Resultados', 'type' => 'select', 'options' => array('20' => 20, '50' => 50, '100' => 100, '500' => 500, '1000' => 1000), 'default' => '20')) ?></td>
                <?php endif; ?>

                <?php if (!empty($this->params['named']['pago'])): ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.pago', array('label' => 'Pago 0/1', 'value' => $this->params['named']['pago'])) ?></td>
                <?php elseif (!empty($this->params['url']['pago'])): ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.pago', array('label' => 'Pago 0/1', 'value' => $this->params['url']['pago'])) ?></td>
                <?php else: ?>
                    <td style="width: 150px"><?php echo $this->Form->input('Search.pago', array('label' => 'Pago 0/1',)) ?></td>
                <?php endif; ?>


                <?php $is_email = FALSE; ?>
                <?php if (!empty($this->params['named']['modoEnvFac'])): ?>
                    <?php $is_email = True; ?>
                    <td><?php echo $this->Form->input('Search.modoEnvFac', array('label' => 'Modo envio Factura', 'options' => array('direccionpostal' => 'direccionpostal', 'direccionfiscal' => 'direccionfiscal', 'email' => 'email'), 'selected' => $this->params['named']['modoEnvFac'])) ?></td>
                <?php elseif (!empty($this->params['url']['modoEnvFac'])): ?>
                    <?php $is_email = True; ?>
                    <td><?php echo $this->Form->input('Search.modoEnvFac', array('label' => 'Modo envio Factura', 'options' => array('direccionpostal' => 'direccionpostal', 'direccionfiscal' => 'direccionfiscal', 'email' => 'email'), 'selected' => $this->params['url']['modoEnvFac'])) ?></td>
                <?php else: ?>
                    <td><?php echo $this->Form->input('Search.modoEnvFac', array('label' => 'Modo envio Factura', 'options' => array('direccionpostal' => 'direccionpostal', 'direccionfiscal' => 'direccionfiscal', 'email' => 'email'), 'empty' => '')); ?></td>
                <?php endif; ?>

                <td>
                    <?php echo $this->Form->input('estadosfacturascliente_id', array('label' => 'Estado Factura')); ?>
                </td>
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
    <?php
    $sumatorio_baseimponible = 0;
    $sumatorio_impuestos = 0;
    $sumatorio_Comp_21 = 0;
    $sumatorio_total = 0;
    ?>
    <!-- SI CARGA EN COMBO MODOENVIO = EMAIL,  -->
    <?php if ($is_email) : ?>
        <?php echo $this->Form->create('FacturasCliente', array('action' => 'enviarfacturasemail')) ?>
    <?php else : ?>
        <?php echo $this->Form->create('FacturasCliente', array('action' => 'imprimirfacturacion')) ?>
    <?php endif; ?>

    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('Serie', 'FacturasCliente.serie'); ?></th>
            <th><?php echo $this->Paginator->sort('Numero', 'numero'); ?></th>
            <th><?php echo $this->Paginator->sort('Cliente', 'cliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Fecha', 'fecha'); ?></th>
            <th><?php echo $this->Paginator->sort('Observaciones', 'observaciones'); ?></th>
            <th><?php echo $this->Paginator->sort('Base Imponible', 'baseimponible'); ?></th>
            <th><?php echo $this->Paginator->sort('Iva', 'impuestos'); ?></th>
            <th><?php echo $this->Paginator->sort('Comp. 21%', 'Comp_21'); ?></th>
            <th></th>
            <th><?php echo $this->Paginator->sort('Total', 'total'); ?></th>
            <th><?php echo $this->Paginator->sort('Factura escaneada', 'facturaescaneada'); ?></th>
            <th><?php echo $this->Paginator->sort('Estado', 'estadosfacturascliente_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Modo envío Fcta.', 'Cliente.modoenviofactura'); ?></th>
            <th><?php echo __('Imp.'); ?></th> 
            <th><?php echo $this->Paginator->sort('Pago', 'pago'); ?></th>
            <?php if ($is_email) : ?>
                <th><?php echo __('Email enviado'); ?></th>                 
            <?php endif; ?>
            <th class="actions"><div align="center"><?php __('Acciones'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($facturasClientes as $facturasCliente):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $facturasCliente['FacturasCliente']['serie']; ?>&nbsp;</td>
                <td><?php echo $facturasCliente['FacturasCliente']['numero']; ?>&nbsp;</td>
                <td><?php echo $this->Html->link($facturasCliente['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $facturasCliente['Cliente']['id'])); ?></td>
                <td><?php echo $this->Time->format('d-m-Y', $facturasCliente['FacturasCliente']['fecha']); ?>&nbsp;</td>
                <td><?php echo $facturasCliente['FacturasCliente']['observaciones']; ?>&nbsp;</td>
                <td><?php echo redondear_dos_decimal($facturasCliente['FacturasCliente']['baseimponible']); ?>&nbsp;</td>
                <td><?php echo redondear_dos_decimal($facturasCliente['FacturasCliente']['impuestos']); ?>&nbsp;</td>
                <td><?php echo redondear_dos_decimal($facturasCliente['FacturasCliente']['baseimponible'] * 21 / 100); ?>&nbsp;</td>
                <td><?php echo redondear_dos_decimal(($facturasCliente['FacturasCliente']['impuestos']) == redondear_dos_decimal($facturasCliente['FacturasCliente']['baseimponible'] * 21 / 100)) ? '<span style="color: green">OK</span>' : '<span style="color: red">DIF.</span>'; ?>&nbsp;</td>
                <td><?php echo redondear_dos_decimal($facturasCliente['FacturasCliente']['total']); ?></td>
                <td><?php if (!empty($facturasCliente['FacturasCliente']['facturaescaneada'])) echo $this->Html->image('clip.png', array('url' => array('action' => 'downloadFile', $facturasCliente['FacturasCliente']['id']))); ?>&nbsp;</td>
                <td><?php echo $facturasCliente['Estadosfacturascliente']['estado']; ?></td>
                <td><?php echo $facturasCliente['Cliente']['modoenviofactura']; ?>
                    <?php if ($facturasCliente['Cliente']['modoenviofactura'] == 'email' && $facturasCliente['Cliente']['email'] == ''): ?>
                        <?php echo '<span style="color: red;font-size:smaller">(No tiene)</span>'; ?>
                    <?php elseif ($facturasCliente['Cliente']['modoenviofactura'] == 'email') : ?>
                        <?php echo '<span style="color: green;font-size:smaller">' . $facturasCliente['Cliente']['email'] . '</span>'; ?>
                        <?php
                        $path = '../webroot/files/facturaEmails/factura_' . $facturasCliente['FacturasCliente']['id'] . '.pdf';
                        if (file_exists($path)) {
                            echo '<span style="color: orange;font-size:smaller">Existe Fcta. en disco</span>';
                        } endif;
                    ?>
                </td>
                <td>
                    <?php if ($facturasCliente['Cliente']['facturaelectronica'] == 0): ?>
                        <?php echo $this->Form->checkbox('FacturasClienteIds', array('name' => 'data[FacturasCliente][ids][]', 'value' => $facturasCliente['FacturasCliente']['id'], 'checked' => True, 'hiddenField' => False)); ?>
                    <?php else: ?>
                        <?php echo $this->Form->checkbox('FacturasClienteIds', array('name' => 'data[FacturasCliente][ids][]', 'value' => $facturasCliente['FacturasCliente']['id'], 'checked' => False, 'hiddenField' => False)); ?>
                    <?php endif; ?>
                </td>
                <td><?php echo $facturasCliente['FacturasCliente']['pago'] == 0 ? '<span style="color: red">PENDIENTE</span>' : '<span style="color: green">PAGADA</span>'; ?>&nbsp;</td>
                <?php if ($is_email) : ?>
                    <td><?php echo $facturasCliente['FacturasCliente']['emailEnviado'] == 0 ? '<span style="color: red">No</span>' : '<span style="color: green">Si</span>'; ?>&nbsp;</td>
                <?php endif; ?>

                <td class="actions">
                    <?php echo $html->link(__('Editar', true), array('action' => 'edit', $facturasCliente['FacturasCliente']['id'])); ?>
                    <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $facturasCliente['FacturasCliente']['id'])); ?>
                    <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $facturasCliente['FacturasCliente']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $facturasCliente['FacturasCliente']['id'])); ?>
                    <?php echo $this->Html->link(__('Pdf', true), array('action' => 'pdf', $facturasCliente['FacturasCliente']['id'])); ?>
                    <?php echo $this->Html->link(__('Pdf.Compl', true), array('action' => 'imprimirtotal', $facturasCliente['FacturasCliente']['id'])); ?>
                    <?php echo $this->Html->link(__('Imp.carta', true), array('action' => 'imprimircarta', $facturasCliente['FacturasCliente']['id'])); ?>            
                    <?php if ($facturasCliente['Cliente']['modoenviofactura'] == 'email') : ?>
                        <?php
                        echo $this->Html->link(__('Generar Fact. Disco', true), array('action' => 'facturaPdfDisco', $facturasCliente['FacturasCliente']['id']), array('style' => 'color:blue', 'target' => '_blank'));
                        ?>
                    <?php endif; ?>
                </td>
            </tr>

            <?php
            $sumatorio_baseimponible += redondear_dos_decimal($facturasCliente['FacturasCliente']['baseimponible']);
            $sumatorio_impuestos += redondear_dos_decimal($facturasCliente['FacturasCliente']['impuestos']);
            $sumatorio_Comp_21 += redondear_dos_decimal($facturasCliente['FacturasCliente']['baseimponible'] * 21 / 100);
            $sumatorio_total += redondear_dos_decimal($facturasCliente['FacturasCliente']['total']);
            ?>
        <?php endforeach; ?>
        <tr class="totales_pagina">
            <td colspan="5">TOTALES</td>
            <td><?php echo redondear_dos_decimal($sumatorio_baseimponible) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_impuestos) ?></td>
            <td><?php echo redondear_dos_decimal($sumatorio_Comp_21) ?></td>
            <td></td>
            <td><?php echo redondear_dos_decimal($sumatorio_total) ?></td>
            <td colspan="3"></td>
        </tr>
    </table>
    <?php if ($facturasCliente['Cliente']['modoenviofactura'] == 'email') : ?>
        <?php echo $this->Form->end('Enviar Facturas por Email'); ?> 
    <?php else : ?>
        <?php echo $this->Form->end('Imprimir Facturación'); ?> 
    <?php endif; ?>
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
