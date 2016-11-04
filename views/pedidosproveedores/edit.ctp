<div class="pedidosproveedores">
    <h2>
        <?php __('Pedido a proveedor Nº ' . $this->Form->value('Pedidosproveedore.numero')); ?>
        <?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $this->Form->value('Pedidosproveedore.id')), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Listar', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        <?php echo $this->Html->link(__('Eliminar Pedido de proveedores', true), array('action' => 'delete', $this->Form->value('Pedidosproveedore.id')), array('class' => 'button_link'), sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Pedidosproveedore.numero'))); ?>
    </h2> 
    <?php echo $this->Form->create('Pedidosproveedore', array('type' => 'file')); ?>
    <fieldset>
        <table class="view">
            <tr>
                <td><?php echo $this->Form->input('serie', array('type' => 'select', 'options' => $series, 'default' => $config['Seriespedidoscompra']['serie'])); ?></td>
                <td>
                    <?php echo $this->Form->input('id'); ?>
                    <?php echo $this->Form->input('numero'); ?>
                </td>

                <td>
                    <?php echo $this->Form->input('tiposiva_id', array('label' => 'Tipo de Iva')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('referencia_proveedor', array('label' => 'Referencia proveedor')); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $this->Form->input('proveedore_id', array('label' => 'Proveedor', 'class' => 'chzn-select-required')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('fecha',array('dateFormat'=>'DMY')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('almacene_id', array('label' => 'Almacén', 'class' => 'chzn-select-required')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('confirmado'); ?>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <?php echo $this->Form->input('observaciones'); ?>
                </td>
            </tr>
            <tr>
                <td colspan="1">
                    Pedido escaneado Actual: <?php echo $this->Html->link(__($this->Form->value('Pedidosproveedore.pedidoescaneado'), true), '/files/pedidosproveedore/' . $this->Form->value('Pedidosproveedore.pedidoescaneado')); ?>
                    <?php echo $this->Form->input('remove_file', array('type' => 'checkbox', 'label' => 'Borrar Documento Escaneado Actual', 'hiddenField' => false)); ?>
                    <?php echo $this->Form->input('file', array('type' => 'file', 'label' => 'Pedidos escaneado')); ?>
                </td>
                <td>
                <span><?php __('Comercial'); ?></span>
                <?php echo $this->Form->input('comerciale_id', array('label' => False, 'empty' => ' -- Ninguno --')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('centrosdecoste_id', array('label' => 'Centros de Coste')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('fecharecepcion', array('label' => 'Fecha de Recepcion','dateFormat'=>'DMY')); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $this->Form->input('transportista_id', array('label' => 'Transportista')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('numero_expedicion', array('label' => 'Nº Expedición')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('tipo_envio', array('label' => 'Tipo de Envio')); ?>
                </td>
                <td>
                    <?php echo $this->Form->input('estadospedidosproveedore_id', array('label' => 'Estado')); ?>
                </td>
            </tr>
        </table>  
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
    <div class="actions">
        <ul>   
            <li><?php echo $this->Html->link(__('Nuevo Albaran a proveedores', true), array('controller' => 'albaranesproveedores', 'action' => 'add', $this->Form->value('Pedidosproveedore.id')), array('style' => 'background: -webkit-gradient(linear, left top, left bottom, from(#FFA54F), to(#EEECA9));')); ?> </li>
        </ul>
    </div>
</div>
