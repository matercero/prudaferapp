<div class="configs">
    <?php echo $this->Form->create('Config'); ?>
    <fieldset>
        <legend>Impuesto Predeterminado</legend>
        <table class="view edit">
            <tr>
                <td><span><?php __('Tipo de IVA') ?></span></td>
                <td><?php echo $this->Form->input('tiposiva_id', array('label' => false,'empty' =>'-- Seleccionar Tipo de IVA --')); ?></td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
        <legend><?php __('Configuración de Costos'); ?></legend>
        <table class="view edit">
            <tr>
                <td><span><?php __('Costo de Hora de Desplazamiento') ?></span></td>
                <td><?php echo $this->Form->input('costohoradesplazamiento', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Costo del KM de Desplazamiento') ?></span></td>
                <td><?php echo $this->Form->input('costokmdesplazamiento', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Costo Hora del Mecánico en Centro de Trabajo del Cliente') ?></span></td>
                <td><?php echo $this->Form->input('costo_hora_en_centrotrabajo', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Costo Hora del Mecánico en Taller') ?></span></td>
                <td><?php echo $this->Form->input('costo_hora_en_taller', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Costo Hora Extra del Mecánico') ?></span></td>
                <td><?php echo $this->Form->input('costo_hora_extra', array('label' => false)); ?></td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
        <legend><?php __('Configuración de Series'); ?></legend>
        <table class="view edit">
            <tr>
                <td><span><?php __('Serie Actual de Presupuestos de Venta') ?></span></td>
                <td><?php echo $this->Form->input('seriespresupuestosventa_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Serie Actual de Pedidos de Venta') ?></span></td>
                <td><?php echo $this->Form->input('seriespedidosventa_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Serie Actual de Albaranes de Venta') ?></span></td>
                <td><?php echo $this->Form->input('series_albaranesventa_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Serie Actual de Facturas de Venta') ?></span></td>
                <td><?php echo $this->Form->input('seriesfacturasventa_id', array('label' => false)); ?></td>
            </tr>
            <tr><td colspan="2"></td></tr>
            <tr>
                <td><span><?php __('Serie Actual de Presupuestos de Compra') ?></span></td>
                <td><?php echo $this->Form->input('seriespresupuestoscompra_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Serie Actual de Pedidos de Compra') ?></span></td>
                <td><?php echo $this->Form->input('seriespedidoscompra_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Serie Actual de Albaranes de Compra') ?></span></td>
                <td><?php echo $this->Form->input('seriesalbaranescompra_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span><?php __('Serie Actual de Facturas de Compra') ?></span></td>
                <td><?php echo $this->Form->input('seriesfacturascompra_id', array('label' => false)); ?></td>
            </tr>
        </table>

    </fieldset>
    <fieldset>
        <legend>Carta de Facturación</legend>
        <?php __('Texto de la Carta de Facturación') ?>
        <?php echo $this->Form->input('cartafacturacion', array('label' => False)) ?> 
    </fieldset>
    <?php
    echo $this->Form->input('id');
    ?>
    <?php echo $this->Form->end(__('Guardar', true)); ?>
</div>