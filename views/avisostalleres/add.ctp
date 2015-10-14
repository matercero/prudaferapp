<script> $(document).ready(function() { $("#datepicker").datepicker(); }); </script> 

<div class="avisostalleres">
    <?php echo $this->Form->create('Avisostallere', array('type' => 'file')); ?>
    <fieldset>
        <legend><?php __('Nuevo Aviso de Taller'); ?></legend>
        <table border="1">
            <tr>
                <td>
                    <?php echo $this->Form->input('numero', array('label' => 'Numero', 'value' => $numero)); ?>
                </td>

                <td>
                    <?php echo $this->Form->input('fechaaviso', array('label' => 'Fecha y hora aviso', 'dateFormat' => 'DMY', 'timeFormat' => '24')); ?>
                    <input id="datepicker" />
                </td>
                <td>
                    <?php echo $this->Form->input('estadosavisostallere_id', array('label' => 'Estado', 'default' => '1')); ?>
                </td>
                <td colspan="2">
                    <?php echo $this->Form->input('avisotelefonico', array('label' => 'Aviso Telefónico')); ?>
                    <?php echo $this->Form->input('avisoemail', array('label' => 'Aviso E-Mail')); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $this->Form->input('fechaaceptacion', array('label' => 'Fecha de Aceptación', 'dateFormat' => 'DMY', 'empty' => '--')); ?>
                </td>
           
                <td>
                    <?php
                    echo $this->Form->input('cliente_id', array('label' => 'Cliente', 'class' => 'chzn-select-required', 'empty' => 'Seleccionar Cliente...'));
                    echo $ajax->observeField('AvisostallereClienteId', array(
                        'frequency' => '1',
                        'update' => 'CentrostrabajoSelectDiv',
                        'url' => array(
                            'controller' => 'centrostrabajos',
                            'action' => 'selectAvisostalleres'
                            ))
                    );
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->Form->input('centrostrabajo_id', array(
                        'label' => 'Centro de Trabajo',
                        'div' => array(
                            'id' => 'CentrostrabajoSelectDiv'
                        ),
                        'empty' => '--- Seleccione un centro de trabajo ---'));
                    echo $ajax->observeField('AvisostallereCentrostrabajoId', array(
                        'frequency' => '1',
                        'update' => 'MaquinaSelectDiv',
                        'url' => array(
                            'controller' => 'maquinas',
                            'action' => 'selectAvisostalleres'
                            ))
                    );
                    ?>
                    <?php echo $this->Html->link(__('Nuevo Centro de Trabajo', true), array('controller' => 'centrostrabajos', 'action' => 'add_popup'), array('class' => 'button_link popup')); ?>
                </td>
                <td>
                    <?php
                    echo $this->Form->input('maquina_id', array(
                        'label' => 'Máquina',
                        'empty' => '--- Seleccione una máquina ---',
                        'div' => array(
                            'id' => 'MaquinaSelectDiv'
                        )
                    ));
                    ?>
                    <?php echo $this->Form->input('horas_maquina', array('label' => 'Horas de la Máquina', 'default' => 0)); ?>
                    <?php echo $this->Html->link(__('Nueva Máquina', true), array('controller' => 'maquinas', 'action' => 'add_popup'), array('class' => 'button_link popup')); ?>

                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $this->Form->input('solicitaresupuesto', array('label' => 'Solicita Presupuesto')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('marcarurgente', array('label' => 'Marcar como URGENTE')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('pendienteconfirmar', array('label' => 'Pendiente confirmar por el cliente')); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $this->Form->input('observaciones', array('label' => 'Observaciones:')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('confirmadopor', array('label' => 'Confirmado por:')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('enviara', array('label' => 'Enviar a:')); ?>
                </td>
           
                <td colspan="1">
                    <?php echo $this->Form->input('aviso_mantenimiento', array('label' => 'Mantenimiento:')); ?>
                </td>	
                <td>

            </tr>
            <tr>
                <td colspan="3">
                    <?php echo $this->Form->input('descripcion', array('label' => 'Descripción proporcionada por el cliente:')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php echo $this->Form->input('file', array('type' => 'file', 'label' => 'Documento Adjunto')); ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>
