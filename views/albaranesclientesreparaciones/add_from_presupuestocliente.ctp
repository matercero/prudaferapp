<div class="albaranesclientesreparaciones">
    <?php echo $this->Form->create('Albaranesclientesreparacione', array('type' => 'file')); ?>
    <fieldset>
        <legend>
            <?php __('Nuevo Albarán de Reparación desde el Presupuesto de Cliente ' . $presupuestoscliente['Presupuestoscliente']['serie'] . '-' . zerofill($presupuestoscliente['Presupuestoscliente']['numero']) . '<br/> para la Orden ' . zerofill($ordene['Ordene']['numero'])); ?>
            <?php echo $this->Html->link(__('Listar Albaranes de Reparación', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <table class="view edit">
            <tr>
                <td><span>Serie</span></td>
                <td><?php echo $this->Form->input('serie', array('type' => 'select', 'options' => $series, 'value' => $config['SeriesAlbaranesventa']['serie'], 'label' => false)); ?></td>
                <td colspan="4"></td>
                <td><span>Estado</span></td>
                <td><?php echo $this->Form->input('estadosalbaranesclientesreparacione_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Número'); ?></span></td>
                <td><?php echo $this->Form->input('numero', array('value' => $numero, 'label' => false)); ?></td>
                <td><span><?php __('Fecha'); ?></span></td>
                <td><?php echo $this->Form->input('fecha', array('label' => false)); ?></td>
                <td><span><?php __('Almacén de los Materiales'); ?></span></td>
                <td><?php echo $ordene['Almacene']['nombre'] ?><?php echo $this->Form->input('almacene_id', array('type' => 'hidden', 'value' => $ordene['Ordene']['almacene_id'])); ?></td>
                <td><span><?php __('Comercial'); ?></span></td>
                <td><?php echo $this->Form->input('comerciale_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Cliente') ?></span></td>
                <td>
                    <?php echo $this->Html->link($ordene['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $ordene['Cliente']['id'])); ?>
                    <?php echo $this->Form->input('cliente_id', array('type' => 'hidden', 'value' => $ordene['Ordene']['cliente_id'])); ?>
                </td>
                <td><span><?php __('Centro de Trabajo') ?></span></td>
                <td>
                    <?php echo $ordene['Centrostrabajo']['centrotrabajo'] ?>
                    <?php echo $this->Form->input('centrostrabajo_id', array('type' => 'hidden', 'value' => $ordene['Ordene']['centrostrabajo_id'])); ?>
                </td>
                <td><span><?php __('Maquina') ?></span></td>
                <td>
                    <?php echo $this->Html->link($ordene['Maquina']['nombre'], array('controller' => 'maquinas', 'action' => 'view', $ordene['Maquina']['id'])); ?>
                    <label>Horas Máquina:</label><?php echo $this->Form->input('horas_maquina', array('label' => false, 'default' => $ordene['Ordene']['horas_maquina'])); ?>
                    <?php echo $this->Form->input('maquina_id', array('type' => 'hidden', 'value' => $ordene['Ordene']['maquina_id'])); ?>
                </td>
            </tr>
            <tr>
                <td><h4><?php __('Nº Orden'); ?></h4></td>
                <td>
                    <?php echo $this->Html->link($ordene['Ordene']['numero'], array('controller' => 'ordenes', 'action' => 'view', $ordene['Ordene']['id'])); ?>
                    <?php echo $this->Form->input('ordene_id', array('type' => 'hidden', 'value' => $ordene['Ordene']['id'])); ?>
                </td>
                <td colspan="3"><span><?php __('Número Aceptación Aportado por el Cliente') ?></span></td>
                <td><?php echo $this->Form->input('numero_aceptacion_aportado', array('label' => false)) ?></td>
            </tr>
            <tr>
                <td><span><?php __('Albarán de Reparación Escaneado'); ?></span></td>
                <td colspan="5"><?php echo $this->Form->input('file', array('type' => 'file', 'label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Observaciones'); ?></span></td>
                <td colspan="5"><?php echo $this->Form->input('observaciones', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Centro de Coste') ?></span></td>
                <td><?php echo $this->Form->input('centrosdecoste_id', array('label' => false)); ?></td>
                <td><span><?php __('Tipo de IVA') ?></span></td>
                <td><?php echo $this->Form->input('tiposiva_id', array('label' => false, 'default' => $presupuestoscliente['Presupuestoscliente']['tiposiva_id'])); ?></td>
                <td><span><?php __('Facturable'); ?></span></td>
                <td><?php echo $this->Form->input('facturable', array('label' => false, 'checked' => true)); ?><?php echo $this->Form->input('es_presupuestado', array('type' => 'hidden', 'label' => false, 'value' => $presupuestoscliente['Presupuestoscliente']['id'])); ?></td>
                <td><span><?php __('Es devolución') ?></span></td>
                <td><?php echo $this->Form->input('es_devolucion', array('label' => false)); ?></td>
            </tr>
        </table>
        <div class="related">
            <h3><?php __('Tareas'); ?> <?php echo $this->Html->link(__('Nueva Tarea', true), array('controller' => 'tareas', 'action' => 'add', $ordene['Ordene']['id']), array('class' => 'popup button_link')); ?></h3>
            <?php if (!empty($ordene['Tarea'])): ?>
                <table cellpadding = "0" cellspacing = "0">
                    <tr>
                        <th><?php __(''); ?></th>
                        <th><?php __('Descripción'); ?></th>
                        <th class="actions"><?php __('Validar'); ?></th>
                    </tr>
                    <?php
                    $i = 0;
                    foreach ($presupuestoscliente['Tareaspresupuestocliente'] as $tarea):
                        $class = ' class="altrow"';
                        if ($i++ % 2 == 0) {
                            $class = ' class="altrow"';
                        }
                        $total_horas_desplazamiento_real = 0;
                        $total_horas_desplazamiento_imputable = 0;
                        $total_km_desplazamiento_real = 0;
                        $total_km_desplazamiento_imputable = 0;
                        $total_horas_trabajo_tarea_real = 0;
                        $total_horas_trabajo_tarea_imputable = 0;
                        $total_cantidad_materiales_presupuestados = 0;
                        ?>
                        <tr<?php echo $class; ?>>
                            <td style="background-color: #FACC2E">Tarea <?php echo $i ?> - <?php echo $tarea['tipo'] ?></td>
                            <td style="background-color: #FACC2E"><?php echo $tarea['asunto']; ?></td>
                            <td class="actions" style="background-color: #FACC2E">
                                <?php echo $this->Html->link(__('Ver Contenido', true), '#?', array('class' => 'ver-relaciones')); ?>
                                <?php echo $this->Form->input('TareaPresupuesto.' . $i . '.id', array('label' => false, 'div' => false, 'class' => 'validartarea', 'type' => 'checkbox', 'checked' => true, 'value' => $tarea['id'], 'hiddenField' => false)) ?>
                                <span class="importe_tarea">Importe Tarea <?php echo redondear_dos_decimal($tarea['mano_de_obra'] + $tarea['servicios'] + $tarea['materiales']) ?> &euro;</span>
                            </td>
                        </tr>
                        <tr class="tarea-relations">
                            <td colspan="4" style="background-color: #FBEEE1;">
                                <?php if (!empty($tarea['Materiale'])): ?>
                                    <h4>Articulos de la Tarea</h4>
                                    <table>
                                        <thead>
                                        <th>Ref.</th>
                                        <th>Nombre</th>
                                        <th>Localizacion</th>
                                        <th>Cant.<br/>Real</th>
                                        <th class="columna-presupuestado">Cant.<br/>Presup</th>
                                        <th>Cant.<br/>Imp.</th>
                                        <th>Precio<br/>Costo</th>
                                        <th>Total<br/>Costo</th>
                                        <th>PVP</th>
                                        <th>Total PVP</th>
                                        <th>Descuento</th>
                                        <th class="columna-presupuestado">Presup.</th>
                                        <th>Total con<br/> Descuento Aplicado</th>
                                        </thead>
                                        <?php
                                        $total_cantidad_material_real = 0;
                                        $total_cantidad_material_imputable = 0;
                                        ?>
                                        <?php foreach ($tarea['Materiale'] as $articulo_tarea): ?>
                                            <tr>
                                                <td><?php echo $this->Html->link(__($articulo_tarea['Articulo']['ref'], true), array('controller' => 'articulos', 'action' => 'view', $articulo_tarea['Articulo']['id'])); ?></td>
                                                <td><?php echo $articulo_tarea['Articulo']['nombre'] ?></td>
                                                <td><?php echo $articulo_tarea['Articulo']['localizacion'] ?></td>
                                                <td>
                                                    <?php
                                                    echo $articulo_tarea['cantidad'];
                                                    $total_cantidad_material_real += $articulo_tarea['cantidad'];
                                                    ?>
                                                </td>
                                                <td class="columna-presupuestado">
                                                    <?php
                                                    echo redondear_dos_decimal($articulo_tarea['cantidad']);
                                                    $total_cantidad_materiales_presupuestados += $articulo_tarea['cantidad']
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo $articulo_tarea['cantidad'];
                                                    $total_cantidad_material_imputable += $articulo_tarea['cantidad'];
                                                    ?>
                                                </td>
                                                <td><?php echo $articulo_tarea['Articulo']['ultimopreciocompra'] ?></td>
                                                <td><?php echo $articulo_tarea['cantidad'] * $articulo_tarea['Articulo']['ultimopreciocompra'] ?></td>
                                                <td><?php echo $articulo_tarea['Articulo']['precio_sin_iva'] ?></td>
                                                <td><?php echo $articulo_tarea['cantidad'] * $articulo_tarea['Articulo']['precio_sin_iva'] ?></td>
                                                <td><?php echo $articulo_tarea['descuento'] ?> &percnt;</td>
                                                <td class="columna-presupuestado"><?php echo redondear_dos_decimal($articulo_tarea['cantidad'] * $articulo_tarea['Articulo']['precio_sin_iva']); ?></td>
                                                <td>
                                                    <?php
                                                    $totalcondescuento = ($articulo_tarea['cantidad'] * $articulo_tarea['Articulo']['precio_sin_iva']) - (($articulo_tarea['cantidad'] * $articulo_tarea['Articulo']['precio_sin_iva']) * ($articulo_tarea['descuento'] / 100));
                                                    echo redondear_dos_decimal($totalcondescuento);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="3" style="text-align: right;" class="total_articulos">Totales</td>
                                            <td class="total_articulos"><?php echo $total_cantidad_material_real ?></td>
                                            <td class="columna-presupuestado total_articulos"><?php echo $total_cantidad_materiales_presupuestados ?></td>
                                            <td class="total_articulos"><?php echo $total_cantidad_material_imputable ?></td>
                                            <td class="total_articulos"></td>
                                            <td class="total_articulos"><?php echo redondear_dos_decimal($tarea['materiales']) ?> &euro; </td>
                                            <td class="total_articulos"></td>
                                            <td class="total_articulos"></td>
                                            <td class="total_articulos"></td>
                                            <td class="columna-presupuestado total_articulos"><?php echo redondear_dos_decimal($tarea['materiales']) ?> &euro; </td>
                                            <td class="total_articulos"><?php echo redondear_dos_decimal($tarea['materiales']) ?> &euro; </td>
                                            <td class="total_articulos"></td>
                                        </tr>
                                    </table>
                                <?php endif; ?>
                                <table class="rendimientos_tarea">
                                    <tr>
                                        <td colspan="10"></td>
                                        <td colspan="3" class="total_importe_tarea" style="background-color: #ca87ce;">
                                            TOTAL IMPORTE TAREA <?php echo redondear_dos_decimal($tarea['materiales'] + $tarea['mano_de_obra']+ $tarea['servicios']); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
            <table>
                <tr>
                    <td class="total_orden">Total Mano de Obra y Otros Servicios</td>
                    <td class="total_orden"><?php echo redondear_dos_decimal($totalmanoobrayservicios) ?> &euro;</td>
                    <td class="total_orden">Total Repuestos</td>
                    <td class="total_orden"><?php echo redondear_dos_decimal($totalrepuestos) ?> &euro;</td>
                    <td class="total_orden">Base Imponible</td>
                    <td class="total_orden"><?php echo redondear_dos_decimal($presupuestoscliente['Presupuestoscliente']['precio']) ?> &euro;</td>
                </tr>
            </table>
        </div>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>
<script type="text/javascript">
    $('.tarea-relations').hide();
    $('.ver-relaciones').click(function(){
        $(this).parent().parent().next('.tarea-relations').fadeToggle("slow", "linear");
    });
</script>