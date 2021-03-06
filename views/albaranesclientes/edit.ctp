<div class="albaranesclientes">
    <?php echo $this->Form->create('Albaranescliente', array('type' => 'file')); ?>
    <fieldset>
        <legend>
            <?php __('Editar Albaran de Cliente Nº ' . $this->Form->value('Albaranescliente.numero')); ?>
            <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $this->Form->value('Albaranescliente.id')), array('class' => 'button_link')); ?>
            <?php echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $this->Form->value('Albaranescliente.id')), array('class' => 'button_link'), sprintf(__('Eliminar el Albarán de Repuesto Nº # %s?', true), $this->Form->value('Albaranescliente.numero'))); ?>
            <?php echo $this->Html->link(__('Listar Albaranes de Clientes', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <table class="view">
            <tr>
                <td><span>Serie</span></td>
                <td><?php echo $this->Form->input('serie', array('type' => 'select', 'options' => $series, 'label' => false)); ?></td>
                <td><span><?php __('Número'); ?></span></td>
                <td>
                    <?php
                    echo $this->Form->input('id');
                    echo $this->Form->input('numero', array('label' => False));
                    ?>
                </td>
                <td><span><?php __('Fecha'); ?></span></td>
                <td><?php echo $this->Form->input('fecha', array('label' => False, 'dateFormat' => 'DMY')); ?></td>
                <td><span><?php __('Almacén de los Materiales'); ?></span></td>
                <td><?php echo $this->Form->input('almacene_id', array('label' => False)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Cliente') ?></span></td>
                <td>
                    <?php
                    echo $this->Form->input('cliente_id', array(
                        'label' => False,
                        'div' => array(
                            'id' => 'ClienteSelectDiv',
                        ),
                        'class' => 'select_basico',
                        'empty' => '--- Seleccione un cliente ---'));
                    ?>
                    <?php
                    echo $ajax->observeField('AlbaranesclienteClienteId', array(
                        'frequency' => '1',
                        'update' => 'CentrostrabajoSelectDiv',
                        'url' => array(
                            'controller' => 'centrostrabajos',
                            'action' => 'selectAlbaranesclientes'
                        ))
                    );
                    ?>
                </td>
                <td><span><?php __('Centro de Trabajo') ?> </span></td>
                <td>
                    <?php
                    echo $this->Form->input('centrostrabajo_id', array(
                        'label' => False,
                        'class' => 'select_basico',
                        'div' => array(
                            'id' => 'CentrostrabajoSelectDiv'
                        ),
                        'empty' => '--- Seleccione un centro de trabajo ---'));
                    echo $ajax->observeField('AlbaranesclienteCentrostrabajoId', array(
                        'frequency' => '1',
                        'update' => 'MaquinaSelectDiv',
                        'url' => array(
                            'controller' => 'maquinas',
                            'action' => 'selectAlbaranesclientes'
                        ))
                    );
                    ?>
                </td>
                <td><span><?php __('Maquina') ?> </span></td>
                <td>
                    <?php
                    echo $this->Form->input('maquina_id', array(
                        'label' => False,
                        'class' => 'select_basico',
                        'empty' => '--- Seleccione una máquina ---',
                        'div' => array(
                            'id' => 'MaquinaSelectDiv'
                        )
                    ));
                    ?>
                </td>
                <td><span><?php __('Pedido de cliente'); ?></span></td>
                <td>
                    <?php echo $this->Form->input('pedidoscliente_id', array('type' => 'select', 'class' => 'select_basico', 'label' => False, 'empty' => '---------')); ?>
                </td>
            </tr>
            <tr>
                <?php if (!empty($albaranescliente['Albaranescliente']['avisosrepuesto_id'])): ?>
                    <td><h4><?php __('Aviso de Repuestos'); ?></h4></td>
                    <td><?php echo $this->Html->link($albaranescliente['Avisosrepuesto']['numero'], array('controller' => 'avisosrepuestos', 'action' => 'view', $albaranescliente['Avisosrepuesto']['id'])); ?></td>
                    <td><span><?php __('Centro de Trabajo del Aviso'); ?></span></td>
                    <td><?php echo $albaranescliente['Centrostrabajo']['centrotrabajo']; ?></td>
                    <td><span><?php __('Máquina'); ?></span></td>
                    <td><?php echo $this->Html->link($albaranescliente['Avisosrepuesto']['Maquina']['nombre'], array('controller' => 'maquinas', 'action' => 'view', $albaranescliente['Avisosrepuesto']['Maquina']['id'])); ?></td>
                    <td><span><?php __('Nº Serie Máquina'); ?></span></td>
                    <td><?php echo $albaranescliente['Avisosrepuesto']['Maquina']['serie_maquina']; ?></td>
                    <td><span><?php __('Horas'); ?></span></td>
                    <td><?php echo $albaranescliente['Avisosrepuesto']['horas_maquina']; ?></td>
                <?php endif; ?>
            </tr>
            <tr>
                <td><span><?php __('Albarán Escaneado'); ?></span></td>
                <td colspan="5">
                    <?php
                    echo $this->Html->link(__('Albaran Escaneado Actual: ' . $this->Form->value('Albaranescliente.albaranescaneado'), true), '/files/albaranescliente/' . $this->Form->value('Albaranescliente.albaranescaneado'));
                    echo $this->Form->input('remove_file', array('type' => 'checkbox', 'label' => 'Borrar Albaran Escaneado Actual', 'hiddenField' => false));
                    echo $this->Form->input('file', array('type' => 'file', 'label' => False));
                    ?>
                </td>
                <td><span><?php __('Estado') ?></span></td>
                <td>
                    <!-- Si el estado es Facturado(3) y se quiere Reactivar el albaran 
                         cargamos el estado a Enviado pdte de firma o pedido (trello ID 5) -->
                    <?php if ($this->Form->value('Estadosalbaranescliente.id') == '3'): ?>
                        <?php echo $this->Form->input('estadosalbaranescliente_id', array('label' => False, 'value' => 1)) ?>                   
                    <?php else : ?>
                        <?php echo $this->Form->input('estadosalbaranescliente_id', array('label' => False))  ?>
                    <?php endif; ?>
                </td>
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
                <td><?php echo $this->Form->input('facturable', array('label' => False)); ?></td>
                <td><span><?php __('Comercial'); ?></span></td>
                <td><?php echo $this->Form->input('comerciale_id', array('label' => False, 'empty' => ' -- Ninguno --')); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Agencia de Transporte') ?></span></td>
                <td><?php echo $this->Form->input('agenciadetransporte', array('label' => False)); ?></td>
                <td><span><?php __('Portes') ?></span></td>
                <td><?php echo $this->Form->input('portes', array('label' => False, 'options' => array('Debidos' => 'Debidos', 'Pagados' => 'Pagados'), 'empty' => '')); ?></td>
                <td><span><?php __('Bultos'); ?></span></td>
                <td><?php echo $this->Form->input('bultos', array('label' => False)); ?></td>
            </tr>
        </table>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>