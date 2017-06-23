<div class="albaranesclientes">
    <?php echo $this->Form->create('Albaranescliente', array('type' => 'file')); ?>
    <fieldset>
        <legend><?php
            __('Nuevo Albaran de Cliente proveniente del albaran de proveedor ' .
                    $albaranesproveedore['Albaranesproveedore']['numero']);
            ?></legend>
        <table class="view">
            <pre>
            
                <?php // print_r('aviso id=' . $idAviso) . '<br/>'; ?>
 
                <?php //print_r ($centroTrabajoAvisoRep); ?>
                <?php //print_r ($maquinaAvisoRep); ?>

                <?php // print_r($albaranesproveedore); ?>
                <?php  // print_r($articulos_albaranesproveedore); ?>
               

            </pre>
            <tr>
                <td><span>Serie</span></td>
                <td><?php
                    echo $this->Form->input('serie', array('type' => 'select', 'options' => $series,
                        'value' => $config['SeriesAlbaranesventa']['serie'], 'label' => false));
                    ?></td>
                <td><span><?php __('Número'); ?></span></td>
                <td>
                    <?php
                    echo $this->Form->input('id');
                    echo $this->Form->input('numero', array('label' => False, 'value' => $numero));
                    ?>
                </td>
                <td><span><?php __('Fecha'); ?></span></td>
                <td><?php echo $this->Form->input('fecha', array('label' => False)); ?></td>
                <td><span><?php __('Almacén de los Materiales'); ?></span></td>
                <td><?php echo $this->Form->input('almacene_id', array('label' => False)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Cliente') ?></span></td>
                <td>
                    <?php if (empty($idAviso)): ?>
                        <?php
                        echo $this->Form->input('cliente_id', array('type' => 'hidden', 'label' => False,
                            'value' => $clienteAvisoRep['Clientes']['id']));
                        ?>
                        <?php echo $clienteAvisoRep['Clientes']['nombre']; ?>
                    <?php else: ?>                    
                        <?php
                        echo $this->Form->input('cliente_id', array('type' => 'hidden', 'label' => False,
                            'value' => $clienteAvisoRep['Cliente']['id']));
                        ?>
                        <?php echo $clienteAvisoRep['Cliente']['nombre']; ?>                    
                    <?php endif; ?>                    
                </td>

                <td><span><?php __('Centro de Trabajo') ?> </span></td>
                <td>
                    <?php if (empty($idAviso)): ?>
                        <?php
                        echo $this->Form->input('centrostrabajo_id', array('type' => 'hidden',
                            'label' => False, 'value' => $centroTrabajoAvisoRep['Centrostrabajo']['id']));
                        ?>
                        <?php echo $centroTrabajoAvisoRep['Centrostrabajo']['centrotrabajo']; ?>
                    <?php else: ?> 
                        <?php
                        echo $this->Form->input('centrostrabajo_id', array('type' => 'hidden',
                            'label' => False, 'value' => $centroTrabajoAvisoRep['id']));
                        ?>
                        <?php echo $centroTrabajoAvisoRep['centrotrabajo']; ?>
                    <?php endif; ?>  
                </td>

                <td><span><?php __('Máquina') ?> </span></td>
                <td>
                    <?php if (empty($idAviso)): ?>
                        <?php echo $this->Form->input('maquina_id', array('type' => 'hidden',
                            'label' => False, 'value' => $maquinaAvisoRep['Maquinas']['id']));
                        ?>
                        <?php echo $maquinaAvisoRep['Maquinas']['nombre']; ?>
                    <?php else: ?> 
                        <?php echo $this->Form->input('maquina_id', array('type' => 'hidden',
                            'label' => False, 'value' => $maquinaAvisoRep['id']));
                        ?>
    <?php echo $maquinaAvisoRep['nombre']; ?>
<?php endif; ?>  

                </td>
            </tr>
            <tr>
                <td><span><?php __('Albarán Escaneado'); ?></span></td>
                <td colspan="5"><?php echo $this->Form->input('file', array('type' => 'file', 'label' => False)); ?></td>
                <td><span><?php __('Estado') ?></span></td>
                <td><?php echo $this->Form->input('estadosalbaranescliente_id', array('label' => False)) ?></td>
            </tr>
            <tr>
                <td><span><?php __('Observaciones'); ?></span></td>
                <td colspan="5"><?php echo $this->Form->input('observaciones', array('label' => False)); ?></td>
                <td><span><?php __('Nº Aceptación Aportado por el Cliente'); ?></span></td>
                <td><?php echo $this->Form->input('numero_aceptacion_aportado', array('label' => False)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Centro de Coste') ?></span></td>
                <td><?php echo $this->Form->input('centrosdecoste_id', array('label' => False)); ?></td>
                <td><span><?php __('Tipo de IVA Aplicado') ?></span></td>
                <td><?php echo $this->Form->input('tiposiva_id', array('label' => False)); ?></td>
                <td><span><?php __('Facturable'); ?></span></td>
                <td><?php echo $this->Form->input('facturable', array('label' => False, 'checked' => true)); ?></td>
            </tr>

            <tr>
                <td><span><?php __('Agencia de Transporte') ?></span></td>
                <td><?php echo $this->Form->input('agenciadetransporte', array('label' => False)); ?></td>
                <td><span><?php __('Portes') ?></span></td>
                <td><?php echo $this->Form->input('portes', array('label' => False, 'options' => array('Debidos' => 'Debidos', 'Pagados' => 'Pagados'), 'empty' => '')); ?></td>
                <td><span><?php __('Bultos'); ?></span></td>
                <td><?php echo $this->Form->input('bultos', array('label' => False)); ?></td>
                <td><span><?php __('Comercial'); ?></span></td>
                <td><?php echo $this->Form->input('comerciale_id', array('label' => False, 'empty' => ' -- Ninguno --')); ?></td>
            </tr>
        </table>
    </fieldset>
    <div class="related">
        <h3>Tareas a realizar </h3>
        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('+ Tarea', true), array('controller' => 'tareasalbaranesclientes', 'action' => 'add', $albaranescliente['Albaranescliente']['id']), array('class' => 'popup')); ?></li>
            </ul>
        </div>
        <table style="background-color: #FFE6CC;">
            <thead><th>Tipo</th><th>Asunto</th><th>Acciones</th></thead>
<?php foreach ($albaranescliente['Tareasalbaranescliente'] as $indice => $tarea): ?>
                <tr>
                    <td style="background-color: #FFE6CC"><?php echo $tarea['tipo'] ?></td>                  
                    <td style="background-color: #FFE6CC">Tarea <?php echo $indice + 1 ?> - <?php echo $tarea['asunto'] ?></td>                  
                    <td class="actions"  style="background-color: #FFE6CC">
                        <?php echo $this->Html->link(__('+ Material', true), array('controller' => 'materiales_tareasalbaranesclientes', 'action' => 'add', $tarea['id']), array('class' => 'popup')); ?>
                        <?php if ($tarea['tipo'] != 'repuestos'): ?>
                            <?php echo $this->Html->link(__('+ Mano de Obra', true), array('controller' => 'manodeobras_tareasalbaranesclientes', 'action' => 'add', $tarea['id']), array('class' => 'popup')); ?>
                            <?php if (empty($tarea['TareasalbaranesclientesOtrosservicio'])): ?>
                                <?php echo $this->Html->link(__('+ Otros Conceptos', true), array('controller' => 'tareasalbaranesclientes_otrosservicios', 'action' => 'add', $tarea['id']), array('class' => 'popup')); ?>
                            <?php endif; ?>
                        <?php endif; ?>

    <?php echo $this->Html->link(__('Editar', true), array('controller' => 'tareasalbaranesclientes', 'action' => 'edit', $tarea['id']), array('class' => 'popup')); ?>
    <?php echo $this->Html->link(__('Borrar', true), array('controller' => 'tareasalbaranesclientes', 'action' => 'delete', $tarea['id'])); ?>
                    </td>
                </tr>
                <tr class="tarea-relations">
                    <td colspan="5">
    <?php if (!empty($tarea['ManodeobrasTareasalbaranescliente'])): ?>
                            <h4>Mano de Obra</h4>
                            <table>
                                <tr><th>Descripcion</th><th>Horas</th><th>Precio Hora</th><th>Descuento</th><th>Importe</th><th>Acciones</th></tr>
                                <?php foreach ($tarea['ManodeobrasTareasalbaranescliente'] as $manodeobra): ?>
                                    <tr><td><?php echo $manodeobra['descripcion'] ?></td><td><?php echo $manodeobra['horas'] ?></td><td><?php echo $manodeobra['precio_hora'] ?></td><td><?php echo $manodeobra['descuento'] ?> %</td><td><?php echo $manodeobra['importe'] ?></td><td class="actions"><?php echo $this->Html->link('Eliminar', array('controller' => 'manodeobras_tareasalbaranesclientes', 'action' => 'delete', $manodeobra['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $manodeobra['id'])) ?></td></tr>
        <?php endforeach; ?>
                            </table>
                            <p style="background-color: #fff; text-align: right;font-weight: bold;">Total de Mano de Obra</p>
                            <p style="background-color: #fff; text-align: right;"><?php echo $tarea['mano_de_obra'] ?> &euro;</p>
    <?php endif; ?>
    <?php if (!empty($tarea['TareasalbaranesclientesOtrosservicio'])): ?>
                            <h4>Otros Conceptos</h4>
                            <table>
                                <tr><th colspan="4">Desplazamiento</th></tr>
                                <tr><th>Precio Fijo Desplazamiento</th><th>Precio Desplazamiento de Mano de Obra</th><th>Precio Kilometraje</th><th>Total Desplazamiento</th><th>Dietas</th><th>Varios</th><th>Varios Descripción</th><th>Total</th><th>Acciones</th></tr>
        <?php if (!empty($tarea['TareasalbaranesclientesOtrosservicio'])): ?>
                                    <tr>
                                        <td><?php echo $tarea['TareasalbaranesclientesOtrosservicio']['desplazamiento'] ?> &euro;</td>
                                        <td><?php echo $tarea['TareasalbaranesclientesOtrosservicio']['manoobradesplazamiento'] ?> &euro;</td>
                                        <td><?php echo $tarea['TareasalbaranesclientesOtrosservicio']['kilometraje'] ?> &euro;</td>
                                        <td><?php echo $tarea['TareasalbaranesclientesOtrosservicio']['total_desplazamiento'] ?> &euro;</td>
                                        <td><?php echo $tarea['TareasalbaranesclientesOtrosservicio']['dietas'] ?> &euro;</td>
                                        <td><?php echo $tarea['TareasalbaranesclientesOtrosservicio']['varios'] ?> &euro;</td>
                                        <td><?php echo $tarea['TareasalbaranesclientesOtrosservicio']['varios_descripcion'] ?></td>
                                        <td><?php echo $tarea['TareasalbaranesclientesOtrosservicio']['total'] ?> &euro;</td>
                                        <td class="actions"><?php echo $this->Html->link('Eliminar', array('controller' => 'tareasalbaranesclientes_otrosservicios', 'action' => 'delete', $tarea['TareasalbaranesclientesOtrosservicio']['id']), null, sprintf(__('Seguro que quieres eliminar los otros conceptos?', true), $tarea['TareasalbaranesclientesOtrosservicio']['id'])) ?></td>
                                    </tr>
        <?php endif; ?>
                            </table>
                            <p style="background-color: #fff; text-align: right;font-weight: bold;">Otros Conceptos</p>
                            <p style="background-color: #fff; text-align: right;"><?php echo!empty($tarea['TareasalbaranesclientesOtrosservicio']['total']) ? $tarea['TareasalbaranesclientesOtrosservicio']['total'] : 0 ?> &euro;</p>
    <?php endif; ?>
    <?php if (!empty($tarea['MaterialesTareasalbaranescliente'])): ?>
                            <h4>Materiales</h4>
                            <div id="ajax_message"></div>
                            <table>
                                <tr>
                                    <th>Ref</th>
                                    <th>Articulo</th>
                                    <th>Stock</th>
                                    <th>Localización</th>
                                    <th>Precio Costo <br/>(*Últ. compra)</th>
                                    <th>Total costo <br/>
                                    <th>Cantidad</th>
                                    <th>Precio Ud.</th>
                                    <th>Descuento</th>
                                    <th>Importe</th>
                                    <th>Acciones</th>
                                </tr>
        <?php foreach ($tarea['MaterialesTareasalbaranescliente'] as $materiale): ?>
                                    <tr>
                                        <td><?php echo $this->Html->link(__($materiale['Articulo']['ref'], true), array('controller' => 'articulos', 'action' => 'view', $materiale['Articulo']['id'])); ?></td>                                       
                                        <td><?php echo $materiale['Articulo']['nombre'] ?></td>
                                        <td><?php echo $materiale['Articulo']['existencias'] ?></td>
                                        <td><?php echo $materiale['Articulo']['localizacion'] ?></td>
                                        <td><?php echo $materiale['Articulo']['ultimopreciocompra'] ?></td>
                                        <td><?php echo $materiale['cantidad'] * $materiale['Articulo']['ultimopreciocompra'] ?></td>
                                        <td><?php echo $materiale['cantidad'] ?></td>
                                        <td><?php echo $materiale['precio_unidad'] ?></td>
                                        <td><?php echo $materiale['descuento'] ?> %</td>
                                        <td><?php echo $materiale['importe'] ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link('Editar', array('controller' => 'materiales_tareasalbaranesclientes', 'action' => 'edit', $materiale['id']), array('class' => 'button_link popup')) ?>
            <?php echo $this->Html->link('Eliminar', array('controller' => 'materiales_tareasalbaranesclientes', 'action' => 'delete', $materiale['id']), null, sprintf(__('Seguro que quieres borrar el material?', true), $materiale['id'])) ?>
            <?php echo $this->Html->link('Ver Ultima Venta', array('controller' => 'materiales_tareasalbaranesclientes', 'action' => 'ver_ultima_venta', $materiale['id']), array('class' => 'button_link popup')) ?>
                                        </td>
                                    </tr>

            <?php $sumatorio_materiales_costo +=(redondear_dos_decimal($materiale['Articulo']['ultimopreciocompra'] * $materiale['cantidad'])) ?>
        <?php endforeach; ?>
                                <tr class="totales_pagina">
                                    <td colspan="5">TOTALES</td>
                                    <td><?php echo redondear_dos_decimal($sumatorio_materiales_costo) ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="9"></td>
                                </tr>	
                            </table>
                            <p style="background-color: #fff; text-align: right;font-weight: bold;">Total de Materiales</p>
                            <p style="background-color: #fff; text-align: right;"><?php echo $tarea['materiales'] ?> &euro;</p>                        
    <?php endif; ?>
                        <p style="background-color: #FFE6CC; text-align: right;font-weight: bold;font-size: 15px;">Total Tarea</p>
                        <p style="background-color: #FFE6CC; text-align: right;"><?php echo $tarea['total']; ?> &euro;</p>
                    </td>
                </tr>
<?php endforeach; ?>
            <tr>
                <td colspan="3">
                    <table style="font-size: 16px; font-weight: bold;text-align: right;">
                        <tr>
                            <td>Total Mano de Obra y Otros Conceptos</td>
                            <td><?php echo $totalmanoobrayservicios; ?> &euro;</td>
                            <td>Total Repuestos</td>
                            <td><?php echo $totalrepuestos; ?> &euro;</td>
                            <td>Base Imponible</td>
                            <td><?php echo $albaranescliente['Albaranescliente']['precio']; ?> &euro;</td>
                            <td>Impuestos</td>
                            <td><?php echo $albaranescliente['Albaranescliente']['impuestos']; ?> &euro;</td>
                        </tr>
                        <tr>
                            <td>Comision</td>
                            <td><?php echo redondear_dos_decimal($albaranescliente['Albaranescliente']['comision']); ?>  &euro;</td>
                            <td colspan="4" style="text-align: right;">Total Albarán</td>
                            <td colspan="2"><?php echo $albaranescliente['Albaranescliente']['impuestos'] + $albaranescliente['Albaranescliente']['precio']; ?> &euro;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>



</fieldset>
<?php echo $this->Form->end(__('Guardar', true)); ?>
</div>

<script type="text/javascript">
    $('.validartarea').change(function () {
        tr = $(this).parent().parent().parent();
        tr_hermano = tr.next('tr');
        if ($(this).attr('checked') != 'checked') {
            tr_hermano.find('input:checked').attr('checked', false);
        } else {
            tr_hermano.find('input:checkbox').attr('checked', true);
        }
    });
    $('.childcheckbox').change(function () {
        tr = $(this).parent().parent().parent().parent().parent().parent().parent().prev('tr');
        if (tr.find('.validartarea').is(':checked') == false) {
            tr.find('.validartarea').attr('checked', true);
        }
        ;
        // MIRAR QUE PONER AQUI
    });
</script>
