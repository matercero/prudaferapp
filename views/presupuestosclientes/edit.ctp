<div class="presupuestosclientes">
    <?php echo $this->Form->create('Presupuestoscliente', array('type' => 'file')); ?>
    <fieldset>
        <legend>
            <?php __('Edit Presupuestoscliente'); ?>
            <?php echo $this->Html->link(__('Borrar', true), array('action' => 'delete', $this->Form->value('Presupuestoscliente.id')), array('class' => 'button_link'), sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Presupuestoscliente.numero'))); ?>
            <?php echo $this->Html->link(__('Listar Presupuestos a Clientes', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <?php echo $this->Form->input('id'); ?>
        <table class="edit">
            <tr>
                <td><span>Serie</span></td>
                <td><?php echo $this->Form->input('serie', array('type' => 'select', 'options' => $series, 'label' => false)); ?></td>
                <td><span><?php __('Número'); ?></span></td>
                <td><?php echo $this->Form->input('numero', array('label' => false)); ?></td>
                <td><span><?php __('Fecha'); ?></span></td>
                <td><?php echo $this->Form->input('fecha', array('label' => false,'dateFormat'=>'DMY')); ?></td>
                <td><span><?php __('Almacén de los Materiales'); ?></span></td>
                <td><?php echo $this->Form->input('almacene_id', array('label' => false)); ?></td>
                <td><span><?php __('Confirmado'); ?></span></td>
                <td><?php echo $this->Form->input('confirmado', array('label' => false)); ?></td>
                <td><span><?php __('Comercial'); ?></span></td>
                <td><?php echo $this->Form->input('comerciale_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Cliente'); ?></span></td>
                <td colspan="2">
                    
                    <?php echo $this->Form->input('cliente_id', array(
                        'label' => false,
                         'class' => 'select_basico',
                        'div' => array(
                            'id' => 'ClienteSelectDiv'
                        ),
                        'empty' => '--- Seleccione un Cliente ---')); ?>
                    <?php
                    echo $ajax->observeField('PresupuestosclienteClienteId', array(
                        'frequency' => '1',
                        'update' => 'CentrostrabajoSelectDiv',
                        'url' => array(
                            'controller' => 'centrostrabajos',
                            'action' => 'selectPresupuestoscliente'
                            ))
                    );
                    ?>
                </td>
                <td><span><?php __('Centro de Trabajo'); ?></span></td>
                <td colspan="2">
                    <?php
                    echo $this->Form->input('centrostrabajo_id', array(
                        'label' => false,
                        'div' => array(
                            'id' => 'CentrostrabajoSelectDiv'
                        ),
                        'empty' => '--- Seleccione un centro de trabajo ---'));
                    echo $ajax->observeField('PresupuestosclienteCentrostrabajoId', array(
                        'frequency' => '1',
                        'update' => 'MaquinaSelectDiv',
                        'url' => array(
                            'controller' => 'maquinas',
                            'action' => 'selectPresupuestosclientes'
                            ))
                    );
                    ?>
                </td>
                <td><span><?php __('Máquina'); ?></span></td>
                <td colspan="3">
                    <?php
                    echo $this->Form->input('maquina_id', array(
                        'label' => false,
                        'empty' => '--- Seleccione una máquina ---',
                        'div' => array(
                            'id' => 'MaquinaSelectDiv'
                        )
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><span><?php __('Mensaje'); ?></span></td>
                <td colspan="9"><?php echo $this->Form->input('mensajesinformativo_id', array('label' => false, 'empty' => '-- Sin Mensaje --')); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Observaciones'); ?></span></td>
                <td colspan="7"><?php echo $this->Form->input('observaciones', array('label' => false)); ?></td>
                <td><span><?php __('Avisar'); ?></span></td>
                <td><?php echo $this->Form->input('avisar', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Presupuesto Enviado Fecha'); ?></span></td>
                <td><?php echo $this->Form->input('fecha_enviado', array('label' => false, 'empty' => '--','dateFormat'=>'DMY')); ?></td>
                <td><span><?php __('Tipo de IVA') ?></span></td>
                <td><?php echo $this->Form->input('tiposiva_id', array('label' => false)); ?></td>
                <td><span>Estado</span></td>
                <td colspan="3"><?php echo $this->Form->input('estadospresupuestoscliente_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td colspan="9">
                    <?php
                    echo $this->Html->link(__('Presupuesto Escaneado Actual: ' . $this->Form->value('Presupuestoscliente.presupuestoescaneado'), true), '/files/presupuestoscliente/' . $this->Form->value('Presupuestoscliente.presupuestoescaneado'));
                    echo $this->Form->input('remove_file', array('type' => 'checkbox', 'label' => 'Borrar Presupuesto Escaneado Actual', 'hiddenField' => false));
                    echo $this->Form->input('file', array('type' => 'file', 'label' => False));
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>
