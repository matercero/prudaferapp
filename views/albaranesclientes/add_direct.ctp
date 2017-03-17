<div class="albaranesclientes">
    <?php echo $this->Form->create('Albaranescliente', array('type' => 'file')); ?>
    <fieldset>
        <legend><?php __('Nuevo Albaran de Venta Directa'); ?></legend>
        <table class="view">
            <tr>
                <td><?php echo $this->Form->input('serie', array('type' => 'select', 'options' => $series, 'value' => $config['SeriesAlbaranesventa']['serie'], 'label' => 'Serie')); ?></td>
                <td>
                    <?php
                    echo $this->Form->input('id');
                    echo $this->Form->input('numero', array('label' => 'Numero', 'value' => $numero));
                    ?>
                </td>
                <td><?php echo $this->Form->input('fecha', array('label' => 'Fecha', 'dateFormat' => 'DMY')); ?></td>
                <td><?php echo $this->Form->input('almacene_id', array('label' => 'Almacén de los Materiales')); ?></td>
            </tr>
            <tr>

                <td>
                    <?php
                    echo $this->Form->input('cliente_id', array(
                        'label' => 'Cliente',
                        'class' => 'select_basico',
                        'empty' => '--- Seleccione un centro de trabajo ---',
                        'div' => array(
                            'id' => 'ClienteSelectDiv'
                        )
                    ));
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

                <td>
                    <?php
                    echo $this->Form->input('centrostrabajo_id', array(
                        'label' => 'Centro de Trabajo',
                        'empty' => '--- Seleccione un centro de trabajo ---',
                        'div' => array(
                            'id' => 'CentrostrabajoSelectDiv'
                            )
                        )
                    );
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
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php
                    echo $this->Form->input('file', array('type' => 'file', 'label' => 'Albarán Escaneado'));
                    ?>
                </td>
                <td><?php echo $this->Form->input('estadosalbaranescliente_id', array('label' => 'Estado')) ?></td>
            </tr>
            <tr>
                <td><span><?php __('Observaciones'); ?></span></td>
                <td colspan="2"><?php echo $this->Form->input('observaciones', array('label' => False)); ?></td>
                <td><span><?php __('Nº Aceptación Aportado por el Cliente'); ?></span></td>
                <td><?php echo $this->Form->input('numero_aceptacion_aportado', array('label' => False)); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('centrosdecoste_id', array('label' => 'Centro de Coste')); ?></td>
                <td><?php echo $this->Form->input('tiposiva_id', array('label' => 'Tipo de IVA Aplicado', 'default' => $config['Config']['tiposiva_id'])); ?></td>
                <td><?php echo $this->Form->input('facturable', array('label' => 'Facturable', 'checked' => true)); ?></td>
                <td><?php echo $this->Form->input('comerciale_id', array('label' => 'Comercial', 'empty' => ' -- Ninguno --')); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('agenciadetransporte', array('label' => 'Agencia de Transporte')); ?></td>
                <td><?php echo $this->Form->input('portes', array('label' => 'Portes', 'options' => array('Debidos' => 'Debidos', 'Pagados' => 'Pagados'), 'empty' => '')); ?></td>
                <td><?php echo $this->Form->input('bultos', array('label' => 'Bultos')); ?></td>
            </tr>

        </table>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>
