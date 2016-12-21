<div class="articulos">
    <?php echo $this->Form->create('Articulo', array('type' => 'file')); ?>
    <fieldset>
        <legend>
            <?php __('Editar Artículo'); ?>
            <?php echo $this->Html->link(__('Ver Artículo', true), array('action' => 'view', $this->Form->value('Articulo.id')), array('class' => 'button_link')); ?>
            <?php echo $this->Html->link(__('Eliminar Artículo', true), array('action' => 'delete', $this->Form->value('Articulo.id')), array('class' => 'button_link')); ?>
            <?php echo $this->Html->link(__('Nuevo Artículo', true), array('action' => 'add'), array('class' => 'button_link')); ?>
            <?php echo $this->Html->link(__('Listar Artículos', true), array('action' => 'index'), array('class' => 'button_link')); ?>
        </legend>
        <table class="edit">
            <tr>
                <td class="required"><span>Referencia</span></td>
                <td><?php echo $this->Form->input('ref', array('label' => false)); ?></td>
                <td><span>Código de Barras</span></td>
                <td><?php echo $this->Form->input('codigobarras', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td class="required"><span>Descripción</span></td>
                <td><?php echo $this->Form->input('nombre', array('label' => false)); ?></td>
                <td><span>Localización</span></td>
                <td><?php echo $this->Form->input('localizacion', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span>PVP</span></td>
                <td><?php echo $this->Form->input('precio_sin_iva', array('label' => false)); ?></td>
                <td><span>Último Precio de Coste</span></td>
                <td><?php echo $this->Form->input('ultimopreciocompra', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td class="required"><span>Almacén</span></td>
                <td colspan="3"><?php echo $this->Form->input('almacene_id', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span>Existencias</span></td>
                <td><?php echo $this->Form->input('existencias', array('label' => false, 'readonly' => True)); ?></td>
            </tr>
            <tr>
                <td><span>Stock Mínimo</span></td>
                <td><?php echo $this->Form->input('stock_minimo', array('label' => false)); ?></td>
                <td><span>Stock Máximo</span></td>
                <td><?php echo $this->Form->input('stock_maximo', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span>Familia</span></td>
                <td><?php echo $this->Form->input('familia_id', array('label' => false, 'empty' => '', 'data-placeholder' => 'Seleccione la Familia...', 'class' => 'chzn-select-required')); ?></td>
                <td><span>Imágen Actual</span></td>
                <td>
                    <?php echo $this->Html->link(__($this->Form->value('Articulo.articuloescaneado'), true), '/files/articulo/' . $this->Form->value('Articulo.articuloescaneado')); ?>
                    <?php echo $this->Form->input('remove_file', array('type' => 'checkbox', 'label' => 'Borrar Imágen Actual', 'hiddenField' => false)); ?>
                    <?php echo $this->Form->input('file', array('type' => 'file', 'label' => 'Imágen del Artículo')); ?>
                </td>
            </tr>
            <tr>
                <td><span>Peso (Kgs)</span></td>
                <td><?php echo $this->Form->input('peso', array('label' => false)); ?></td>
                <td><span>Largo (mm)</span></td>
                <td><?php echo $this->Form->input('largo', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span>Ancho (mm)</span></td>
                <td><?php echo $this->Form->input('ancho', array('label' => false)); ?></td>
                <td><span>Alto (mm)</span></td>
                <td><?php echo $this->Form->input('alto', array('label' => false)); ?></td>
            </tr>
            <tr>
                <td><span>Observaciones</span></td>
                <td><?php echo $this->Form->input('observaciones', array('label' => false)); ?></td>
                <td class="required"><span>Proveedor habitual</span></td>
                <td><?php echo $this->Form->input('proveedore_id', array('label' => false, 'empty' => '', 'data-placeholder' => 'Seleccione el Proveedor...', 'class' => 'chzn-select-required')); ?></td>
            </tr>
            <tr>
                <td><span>Descripción larga</span></td>
                <td><?php echo $this->Form->textarea('descripcionLarga', array('label' => false)); ?></td>
            </tr>
        </table>
    </fieldset>
    <?php echo $this->Form->end(__('Guardar', true), array ('class' => 'button_link')); ?>
</div>
