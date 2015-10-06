<p style="margin-bottom: 15px;font-style: italic;">* Solo se muestran los albaranes no facturados y con la casilla Facturable marcada</p>
<?php echo $this->Form->create('FacturasCliente', array('action' => 'facturar')) ?>
<?php echo $this->Form->submit('FACTURAR'); ?>
<?php $factura_index = 0; ?>
<?php foreach ($cliente_facturable_list as $cliente_facturable): ?>
    <?php
    /*
     * En el caso de que el modo de facturacion este  vacio
     */
    ?>
    <?php if (empty($cliente_facturable['Cliente']['modo_facturacion'])): ?>
        <?php if (!empty($cliente_facturable['Albaranescliente']) || !empty($cliente_facturable['Albaranesclientesreparacione'])): ?>
            <h2><?php echo $cliente_facturable['Cliente']['nombre'] ?></h2>
            <?php foreach ($cliente_facturable['Albaranescliente'] as $albaranescliente): ?>
                <?php $factura_index++ ?>
                <h4>Nueva Posible Factura  Serie: <?php echo $this->Form->input('serie', array('type' => 'select', 'name' => 'data[facturable][' . $factura_index . '][serie]', 'div' => False, 'label' => False, 'options' => $seriesfacturasventas, 'selected' => $serie_selecionada)); ?> <?php echo $this->Form->input('facturable.' . $factura_index . '.fecha', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => $fecha_selecionada, 'div' => False, 'label' => False,)); ?> </h4>
				<?php
				$sumatorio_total = 0;  
				?>	
                <table>
                    <caption>Albaranes de Repuestos</caption>
                    <tr>
                        <th>Serie</th>
                        <th>Número</th>
                        <th>Fecha</th>
                        <th>Centro de Trabajo</th>
                        <th>Máquina</th>
                        <th>Base imp.</th>
                        <th>Iva</th>
                        <th>Total</th>
                        <th>Factura</th>
                        <th>Validar</th>
                    </tr>
                    <tr>
                        <td><?php echo $albaranescliente['serie'] ?></td>
                        <td><?php echo zerofill($albaranescliente['numero']) ?></td>
                        <td><?php echo $albaranescliente['fecha'] ?></td>
                        <td><?php echo @$albaranescliente['Centrostrabajo']['centrotrabajo'] ?></td>
                        <td><?php echo @$albaranescliente['Maquina']['nombre'] ?></td>
                        <td><?php echo $albaranescliente['precio'] ?></td>
                        <td><?php echo $albaranescliente['impuestos'] ?></td>
                        <td><?php echo $sumatorio_total += $albaranescliente['precio'] + $albaranescliente['impuestos']; ?></td>
                        <td><?php echo $albaranescliente['facturas_cliente_id'] ?></td>
                        <td>
                            <?php echo $this->Form->checkbox('marcado', array('name' => 'data[facturable][' . $factura_index . '][albaranescliente][]', 'hiddenField' => false, 'checked' => true, 'value' => $albaranescliente['id'])) ?>
                            <?php echo $this->Form->hidden('cliente_id', array('name' => 'data[facturable][' . $factura_index . '][cliente_id]', 'value' => $cliente_facturable['Cliente']['id'])) ?>
                        </td>
                    </tr>
                </table>

            <?php endforeach; ?>
            <?php foreach ($cliente_facturable['Albaranesclientesreparacione'] as $albaranesclientesreparacione): ?>
                <?php $factura_index++ ?>
                <h4>Nueva Posible Factura  Serie: <?php echo $this->Form->input('serie', array('type' => 'select', 'name' => 'data[facturable][' . $factura_index . '][serie]', 'div' => False, 'label' => False, 'options' => $seriesfacturasventas, 'selected' => $serie_selecionada)); ?> <?php echo $this->Form->input('facturable.' . $factura_index . '.fecha', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => $fecha_selecionada, 'div' => False, 'label' => False,)); ?></h4>
                <?php
				$sumatorio_total = 0;  
				?>
                <table>
                    <caption>Albaranes de Reparación</caption>
                    <tr>
                        <th>Serie</th>
                        <th>Número</th>
                        <th>Fecha</th>
                        <th>Centro de Trabajo</th>
                        <th>Máquina</th>
                        <th>Base imp.</th>
                        <th>Iva</th>
                        <th>Total</th> 
                        <th>factura</th>                    
                        <th>Validar</th>
                    </tr>
                    <tr>
                        <td><?php echo $albaranesclientesreparacione['serie'] ?></td>
                        <td><?php echo zerofill($albaranesclientesreparacione['numero']) ?></td>
                        <td><?php echo $albaranesclientesreparacione['fecha'] ?></td>
                        <td><?php echo @$albaranesclientesreparacione['Centrostrabajo']['centrotrabajo'] ?></td>
                        <td><?php echo @$albaranesclientesreparacione['Maquina']['nombre'] ?></td>
                        <td><?php echo @$albaranesclientesreparacione['baseimponible'] ?></td>
                        <td><?php echo @$albaranesclientesreparacione['tiposiva'] ?></td>
                        <td><?php echo $sumatorio_total += $albaranesclientereparacione['baseimponible'] + $albaranesclientereparacione['tiposiva']; ?></td>
                        <td><?php echo @$albaranesclientesreparacione['facturas_cliente_id'] ?></td>						
						</td>
                        <td>
                            <?php echo $this->Form->checkbox('marcado', array('name' => 'data[facturable][' . $factura_index . '][albaranesclientesreparacione][]', 'hiddenField' => false, 'checked' => true, 'value' => $albaranesclientesreparacione['id'])) ?>
                            <?php echo $this->Form->hidden('cliente_id', array('name' => 'data[facturable][' . $factura_index . '][cliente_id]', 'value' => $cliente_facturable['Cliente']['id'])) ?>
                        </td>
                    </tr>
                </table>

            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php
    /*
     * En el caso de que el modo de facturacion sea por albaran
     */
    ?>
    <?php if ($cliente_facturable['Cliente']['modo_facturacion'] == 'albaran'): ?>
        <?php if (!empty($cliente_facturable['Albaranescliente']) || !empty($cliente_facturable['Albaranesclientesreparacione'])): ?>
            <h2><?php echo $cliente_facturable['Cliente']['nombre'] ?></h2>
            <?php foreach ($cliente_facturable['Albaranescliente'] as $albaranescliente): ?>
                <?php $factura_index++ ?>
                <h4>Nueva Posible Factura  Serie: <?php echo $this->Form->input('serie', array('type' => 'select', 'name' => 'data[facturable][' . $factura_index . '][serie]', 'div' => False, 'label' => False, 'options' => $seriesfacturasventas, 'selected' => $serie_selecionada)); ?> -- <?php echo $this->Form->input('facturable.' . $factura_index . '.fecha', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => $fecha_selecionada, 'div' => False, 'label' => False,)); ?></h4>
                <?php
				$sumatorio_total = 0;  
				?>
                <table>
                    <caption>Albaranes de Repuestos</caption>
                    <tr>
                        <th>Serie</th>
                        <th>Número</th>
                        <th>Fecha</th>
                        <th>Centro de Trabajo</th>
                        <th>Máquina</th>
                        <th>Base imp.</th>
                        <th>Iva</th>
                        <th>Total</th>
                        <th>Factura</th>
                        <th>Validar</th>
                    </tr>
                    <tr>
                        <td><?php echo $albaranescliente['serie'] ?></td>
                        <td><?php echo zerofill($albaranescliente['numero']) ?></td>
                        <td><?php echo $albaranescliente['fecha'] ?></td>
                        <td><?php echo @$albaranescliente['Centrostrabajo']['centrotrabajo'] ?></td>
                        <td><?php echo @$albaranescliente['Maquina']['nombre'] ?></td>
                        <td><?php echo $albaranescliente['precio'] ?></td>
                        <td><?php echo $albaranescliente['impuestos'] ?></td>
                        <td><?php echo $sumatorio_total += $albaranescliente['precio'] + $albaranescliente['impuestos']; ?></td>
                        <td><?php echo $albaranescliente['facturas_cliente_id'] ?></td>
                        <td>
                            <?php echo $this->Form->checkbox('marcado', array('name' => 'data[facturable][' . $factura_index . '][albaranescliente][]', 'hiddenField' => false, 'checked' => true, 'value' => $albaranescliente['id'])) ?>
                            <?php echo $this->Form->hidden('cliente_id', array('name' => 'data[facturable][' . $factura_index . '][cliente_id]', 'value' => $cliente_facturable['Cliente']['id'])) ?>
                        </td>
                    </tr>
                </table>

            <?php endforeach; ?>
            <?php foreach ($cliente_facturable['Albaranesclientesreparacione'] as $albaranesclientesreparacione): ?>
                <?php $factura_index++ ?>
                <h4>Nueva Posible Factura  Serie: <?php echo $this->Form->input('serie', array('type' => 'select', 'name' => 'data[facturable][' . $factura_index . '][serie]', 'div' => False, 'label' => False, 'options' => $seriesfacturasventas, 'selected' => $serie_selecionada)); ?> <?php echo $this->Form->input('facturable.' . $factura_index . '.fecha', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => $fecha_selecionada, 'div' => False, 'label' => False,)); ?></h4>
                <?php
				$sumatorio_total = 0;  
				?>
                <table>
                    <caption>Albaranes de Reparación</caption>
                    <tr>
                        <th>Serie</th>
                        <th>Número</th>
                        <th>Fecha</th>
                        <th>Centro de Trabajo</th>
                        <th>Máquina</th>
                        <th>Base imp.</th>
                        <th>Iva</th>
                        <th>Total</th>
                        <th>Validar</th>
                    </tr>
                    <tr>
                        <td><?php echo $albaranesclientesreparacione['serie'] ?></td>
                        <td><?php echo zerofill($albaranesclientesreparacione['numero']) ?></td>
                        <td><?php echo $albaranesclientesreparacione['fecha'] ?></td>
                        <td><?php echo @$albaranesclientesreparacione['Centrostrabajo']['centrotrabajo'] ?></td>
                        <td><?php echo @$albaranesclientesreparacione['Maquina']['nombre'] ?></td>
                        <td><?php echo $albaranesclientesreparacione['baseimponible'] ?></td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php echo $this->Form->checkbox('marcado', array('name' => 'data[facturable][' . $factura_index . '][albaranesclientesreparacione][]', 'hiddenField' => false, 'checked' => true, 'value' => $albaranesclientesreparacione['id'])) ?>
                            <?php echo $this->Form->hidden('cliente_id', array('name' => 'data[facturable][' . $factura_index . '][cliente_id]', 'value' => $cliente_facturable['Cliente']['id'])) ?>
                        </td>
                    </tr>
                </table>

            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php
    /*
     * En el caso de que el modo de facturacion sea por centrotrabajo
     */
    ?>
    <?php if ($cliente_facturable['Cliente']['modo_facturacion'] == 'centrotrabajo'): ?>
        <?php
        $count = 0;
        foreach ($cliente_facturable['Centrostrabajo'] as $centrostrabajo) {
            $count += count($centrostrabajo['Albaranescliente']);
            $count += count($centrostrabajo['Albaranesclientesreparacione']);
        }
        ?>
        <?php if ($count > 0): ?>
            <h2><?php echo $cliente_facturable['Cliente']['nombre'] ?></h2>
            <?php foreach ($cliente_facturable['Centrostrabajo'] as $centrostrabajo): ?>
                <?php if (!empty($centrostrabajo['Albaranescliente']) || !empty($centrostrabajo['Albaranesclientesreparacione'])): ?>
                    <?php $factura_index++ ?>
                    <h4>Nueva Posible Factura  Serie: <?php echo $this->Form->input('serie', array('type' => 'select', 'name' => 'data[facturable][' . $factura_index . '][serie]', 'div' => False, 'label' => False, 'options' => $seriesfacturasventas, 'selected' => $serie_selecionada)); ?> <?php echo $this->Form->input('facturable.' . $factura_index . '.fecha', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => $fecha_selecionada, 'div' => False, 'label' => False,)); ?> -- Centro: <?php echo $centrostrabajo['centrotrabajo'] ?></h4>
                    <?php if (!empty($centrostrabajo['Albaranescliente'])): ?>
                        <?php
						$sumatorio_total = 0;  
						?>
                        <table>
                            <caption>Albaranes de Repuestos</caption>
                            <tr>
                                <th>Serie</th>
                                <th>Número</th>
                                <th>Fecha</th>
                                <th>Centro de Trabajo</th>
                                <th>Máquina</th>
                                <th>Base imp.</th>
                                <th>Iva</th>
                                <th>Total</th>
                                <th>Factura</th>
                                <th>Validar</th>
                            </tr>
                            <?php foreach ($centrostrabajo['Albaranescliente'] as $albaranescliente): ?>
                                <tr>
                                    <td><?php echo $albaranescliente['serie'] ?></td>
                                    <td><?php echo zerofill($albaranescliente['numero']) ?></td>
                                    <td><?php echo $albaranescliente['fecha'] ?></td>
                                    <td><?php echo @$centrostrabajo['centrotrabajo'] ?></td>
                                    <td><?php echo @$albaranescliente['Maquina']['nombre'] ?></td>
                                    <td><?php echo $albaranescliente['precio'] ?></td>
                                    <td><?php echo $albaranescliente['impuestos'] ?></td>
                                    <td><?php echo $sumatorio_total += $albaranescliente['precio'] + $albaranescliente['impuestos']; ?></td>
                                    <td><?php echo $albaranescliente['facturas_cliente_id'] ?></td>
                                    <td>
                                        <?php echo $this->Form->checkbox('marcado', array('name' => 'data[facturable][' . $factura_index . '][albaranescliente][]', 'hiddenField' => false, 'checked' => true, 'value' => $albaranescliente['id'])) ?>
                                        <?php echo $this->Form->hidden('cliente_id', array('name' => 'data[facturable][' . $factura_index . '][cliente_id]', 'value' => $cliente_facturable['Cliente']['id'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                    <?php if (!empty($centrostrabajo['Albaranesclientesreparacione'])): ?>
                        <?php
						$sumatorio_total = 0;  
						?>
                        <table>
                            <caption>Albaranes de Reparación</caption>
                            <tr>
                                <th>Serie</th>
                                <th>Número</th>
                                <th>Fecha</th>
                                <th>Centro de Trabajo</th>
                                <th>Máquina</th>
                                <th>Base imp.</th>
                                <th>Iva</th>
                                <th>Total</th>
                                <th>factura</th>
                                <th>Validar</th>                               
                            </tr>
                            <?php foreach ($centrostrabajo['Albaranesclientesreparacione'] as $albaranesclientesreparacione): ?>
                                <tr>
                                    <td><?php echo $albaranesclientesreparacione['serie'] ?></td>
                                    <td><?php echo zerofill($albaranesclientesreparacione['numero']) ?></td>
                                    <td><?php echo $albaranesclientesreparacione['fecha'] ?></td>
                                    <td><?php echo @$centrostrabajo['centrotrabajo'] ?></td>
                                    <td><?php echo @$albaranesclientesreparacione['Maquina']['nombre'] ?></td>
                                    <td><?php echo @$albaranesclientesreparacione['baseimponible'] ?></td>
									<td></td>
									<td></td>
									<td></td>
                                    <td>
                                        <?php echo $this->Form->checkbox('marcado', array('name' => 'data[facturable][' . $factura_index . '][albaranesclientesreparacione][]', 'hiddenField' => false, 'checked' => true, 'value' => $albaranesclientesreparacione['id'])) ?>
                                        <?php echo $this->Form->hidden('cliente_id', array('name' => 'data[facturable][' . $factura_index . '][cliente_id]', 'value' => $cliente_facturable['Cliente']['id'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>

                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?><?php
    /*
     * En el caso de que el modo de facturacion sea por maquina
     */
    ?>
    <?php if ($cliente_facturable['Cliente']['modo_facturacion'] == 'maquina'): ?>
        <?php
        $count = 0;
        foreach ($cliente_facturable['Centrostrabajo'] as $centrostrabajo) {
            foreach ($centrostrabajo['Maquina'] as $maquina) {
                $count += count($maquina['Albaranesclientesreparacione']);
                $count += count($maquina['Albaranescliente']);
            }
        }
        ?>
        <?php if ($count > 0): ?>
            <h2><?php echo $cliente_facturable['Cliente']['nombre'] ?></h2>
            <?php foreach ($cliente_facturable['Centrostrabajo'] as $centrostrabajo): ?>
                <?php foreach ($centrostrabajo['Maquina'] as $maquina): ?>
                    <?php if (!empty($maquina['Albaranescliente']) || !empty($maquina['Albaranesclientesreparacione'])): ?>
                        <?php $factura_index++ ?>
                        <h4>Nueva Posible Factura  Serie: <?php echo $this->Form->input('serie', array('type' => 'select', 'name' => 'data[facturable][' . $factura_index . '][serie]', 'div' => False, 'label' => False, 'options' => $seriesfacturasventas, 'selected' => $serie_selecionada)); ?>  <?php echo $this->Form->input('facturable.' . $factura_index . '.fecha', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => $fecha_selecionada, 'div' => False, 'label' => False,)); ?>-- Máquina:  <?php echo $maquina['nombre'] ?></h4>
                        <?php if (!empty($maquina['Albaranescliente'])): ?>
                            <?php
							$sumatorio_total = 0;  
							?>
                            <table>
                                <caption>Albaranes de Repuestos</caption>
                                <tr>
                                    <th>Serie</th>
                                    <th>Número</th>
                                    <th>Fecha</th>
                                    <th>Máquina</th>
                                    <th>Base imp.</th>
                                    <th>Iva</th>
                                    <th>Total</th>
                                    <th>Factura</th>
                                    <th>Validar</th>
                                </tr>
                                <?php foreach ($maquina['Albaranescliente'] as $albaranescliente): ?>
                                    <tr>
                                        <td><?php echo $albaranescliente['serie'] ?></td>
                                        <td><?php echo zerofill($albaranescliente['numero']) ?></td>
                                        <td><?php echo $albaranescliente['fecha'] ?></td>
                                        <td><?php echo @$maquina['nombre'] ?></td>
                                        <td><?php echo $albaranescliente['precio'] ?></td>
                                        <td><?php echo $albaranescliente['impuestos'] ?></td>
                                        <td><?php echo $sumatorio_total += $albaranescliente['precio'] + $albaranescliente['impuestos']; ?></td>
                                        <td><?php echo $albaranescliente['facturas_cliente_id'] ?></td>
                                        <td>
                                            <?php echo $this->Form->checkbox('marcado', array('name' => 'data[facturable][' . $factura_index . '][albaranescliente][]', 'hiddenField' => false, 'checked' => true, 'value' => $albaranescliente['id'])) ?>
                                            <?php echo $this->Form->hidden('cliente_id', array('name' => 'data[facturable][' . $factura_index . '][cliente_id]', 'value' => $cliente_facturable['Cliente']['id'])) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>
                        <?php if (!empty($maquina['Albaranesclientesreparacione'])): ?>
							<?php
							$sumatorio_total = 0;  
							?>	
                            <table>
                                <caption>Albaranes de Reparación</caption>
                                <tr>
                                    <th>Serie</th>
                                    <th>Número</th>
                                    <th>Fecha</th>
                                    <th>Máquina</th>
                                    <th>Base imp.</th>
                                    <th>Iva</th>
                                    <th>Total</th>
                                    <th>Validar</th>
                                </tr>
                                <?php foreach ($maquina['Albaranesclientesreparacione'] as $albaranesclientesreparacione): ?>
                                    <tr>
                                        <td><?php echo $albaranesclientesreparacione['serie'] ?></td>
                                        <td><?php echo zerofill($albaranesclientesreparacione['numero']) ?></td>
                                        <td><?php echo $albaranesclientesreparacione['fecha'] ?></td>
                                        <td><?php echo @$maquina['nombre'] ?></td>
                                        <td><?php echo @$albaranesclientesreparacione['baseimponible'] ?></td>
										<td></td>
										<td></td>
                                        <td>
                                            <?php echo $this->Form->checkbox('marcado', array('name' => 'data[facturable][' . $factura_index . '][albaranesclientesreparacione][]', 'hiddenField' => false, 'checked' => true, 'value' => $albaranesclientesreparacione['id'])) ?>
                                            <?php echo $this->Form->hidden('cliente_id', array('name' => 'data[facturable][' . $factura_index . '][cliente_id]', 'value' => $cliente_facturable['Cliente']['id'])) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>
<?php echo $this->Form->end('FACTURAR'); ?>
