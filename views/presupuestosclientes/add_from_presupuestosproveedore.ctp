<div class="presupuestosclientes">
    <?php echo $this->Form->create('Presupuestoscliente', array('type' => 'file')); ?>
    <fieldset>
        <legend>
            <?php __('Nuevo Presupuesto a Cliente desde el Presupuesto de Proveedor '); ?>
            <?php echo $this->Html->link(__('Listar Presupuestos a clientes', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <table class="edit">
            <tr>
                <td><span>Serie</span></td>
                <td><?php echo $this->Form->input('serie', array('type' => 'select', 'options' => $series, 'value' => $config['Seriespresupuestosventa']['serie'], 'label' => false)); ?></td>
                <td><span><?php __('Número'); ?></span></td>
                <td><?php echo $this->Form->input('numero', array('label' => false, 'readonly' => false, 'value' => $numero)); ?></td>
                <td><span><?php __('Fecha'); ?></span></td>
                <td><?php echo $this->Form->input('fecha', array('label' => false,'dateFormat'=>'DMY')); ?></td>
                <td><span><?php __('Almacén de los Materiales'); ?></span></td>
                <td>
                    <?php
                    echo $this->Html->link($presupuestosproveedore['Almacene']['nombre'], array('controller' => 'almacenes', 'action' => 'view', $presupuestosproveedore['Almacene']['id']));
                    echo $this->Form->input('Presupuestoscliente.almacene_id', array('type' => 'hidden', 'value' => $presupuestosproveedore['Presupuestosproveedore']['almacene_id']));
                    ?>
                </td>
                <td><span><?php __('Confirmado'); ?></span></td>
                <td><?php echo $this->Form->input('confirmado', array('label' => false)); ?></td>
                <td><span><?php __('Comercial'); ?></span></td>
                <td><?php echo $this->Form->input('comerciale_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Cliente'); ?></span></td>
                <td colspan="9">
                    <?php
                    echo $this->Form->input(
                            'cliente_id', array(
                        'label' => 'Cliente',
                        'selected' => @$cliente['Cliente']['id'],
                        'class' => 'chzn-select-required',
                        'empty' => 'Selecionar Cliente...'
                            )
                    );
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
                <?php
                if (!empty($presupuestosproveedore['Avisostallere']['Centrostrabajo'])) {
                    $centrostrabajo = $presupuestosproveedore['Avisostallere']['Centrostrabajo'];
                } elseif (!empty($presupuestosproveedore['Avisosrepuesto']['Centrostrabajo'])) {
                    $centrostrabajo = $presupuestosproveedore['Avisosrepuesto']['Centrostrabajo'];
                } elseif (!empty($presupuestosproveedore['Ordene']['Avisostallere']['Centrostrabajo'])) {
                    $centrostrabajo = $presupuestosproveedore['Ordene']['Avisostallere']['Centrostrabajo'];
                } elseif (!empty($presupuestosproveedore['Presupuestosproveedore']['Centrostrabajo'])) {
                    $centrostrabajo = $presupuestosproveedore['Presupuestosproveedore']['Centrostrabajo'];
                }
                ?>
                <td>
                    <?php
                    echo $this->Form->input('centrostrabajo_id', array(
                        'label' => 'Centro de Trabajo',
                        'selected' => @$centrostrabajo['id'],
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
                <?php
                if (!empty($presupuestosproveedore['Avisostallere']['Maquina'])) {
                    $maquina = $presupuestosproveedore['Avisostallere']['Maquina'];
                } elseif (!empty($presupuestosproveedore['Avisosrepuesto']['Maquina'])) {
                    $maquina = $presupuestosproveedore['Avisosrepuesto']['Maquina'];
                } elseif (!empty($presupuestosproveedore['Ordene']['Avisostallere']['Maquina'])) {
                    $maquina = $presupuestosproveedore['Ordene']['Avisostallere']['Maquina'];
                } elseif (!empty($presupuestosproveedore['Presupuestosproveedore']['Maquina'])) {
                    $maquina = $presupuestosproveedore['Presupuestosproveedore']['Maquina'];
                }
                ?>
                <td>
                    <?php
                    echo $this->Form->input('maquina_id', array(
                        'label' => 'Máquina',
                        'selected' => @$maquina['id'],
                        'empty' => '--- Seleccione una máquina ---',
                        'div' => array(
                            'id' => 'MaquinaSelectDiv'
                        )
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><h4><?php __('Nº Presupuesto Proveedor'); ?></h4></td>
                <td><?php echo $presupuestosproveedore['Presupuestosproveedore']['numero'] ?><?php echo $this->Form->input('Presupuestoscliente.presupuestosproveedore_id', array('type' => 'hidden', 'value' => $presupuestosproveedore['Presupuestosproveedore']['id'], 'readonly' => true)); ?></td>
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
                <td colspan="2"><span><?php __('Presupuesto Enviado Fecha'); ?></span></td>
                <td colspan="3"><?php echo $this->Form->input('fecha_enviado', array('label' => false, 'empty' => '--','dateFormat'=>'DMY')); ?></td>
                <td><span><?php __('Tipo de IVA') ?></span></td>
                <td><?php echo $this->Form->input('tiposiva_id', array('label' => false,'default'=>$presupuestosproveedore['Presupuestosproveedore']['tiposiva_id'])); ?></td>
                <td><span>Estado</span></td>
                <td colspan="3"><?php echo $this->Form->input('estadospresupuestoscliente_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td colspan="9"><?php echo $this->Form->input('file', array('type' => 'file', 'label' => 'Presupuesto Escaneado')); ?></td>
            </tr>
        </table>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>