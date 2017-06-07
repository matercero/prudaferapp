<?php echo $this->Form->create('MaterialesTareasalbaranescliente'); ?>
<fieldset>
    <legend><?php __('Editando Material de la Tarea del Albarán'); ?></legend>
    <input type="text"disabled="disabled" value="<?php echo $articulo['ref'] ?> --- <?php echo $articulo['nombre'] ?>"/>
    <p>Existencias: <span id="stock"><?php echo $articulo['existencias'] ?></span></p>
    <?php
    echo $this->Form->input('id');
    echo $this->Form->input('articulo_id', array('type' => 'hidden'));
    echo $this->Form->input('tareasalbaranescliente_id', array('type' => 'hidden'));
    echo $this->Form->input('cantidad');
    echo $this->Form->input('descuento');
    ?>
    <p style="font-size: 1.5em; text-align: center; color:green">Precio venta: 
        <?php echo$materiale['MaterialesTareasalbaranescliente']['precio_unidad'] - ($materiale['MaterialesTareasalbaranescliente']['precio_unidad'] * $materiale['MaterialesTareasalbaranescliente']['descuento'] / 100) ?> &euro;
    </p>
    <p style="font-size: 1.5em; text-align: center; color: #3AA29C">Fecha: <?php echo $materiale['Tareasalbaranescliente']['Albaranescliente']['fecha'] ?>
    </p>        
    <?php
        echo $this->Form->input('precio_unidad');
        echo $this->Form->input('importe');
        ?>
</fieldset>
<script type="text/javascript">
    //Calculo automático
    function calcular_materiale() {
        var importe = $('#MaterialesTareasalbaranesclienteCantidad').val() * $('#MaterialesTareasalbaranesclientePrecioUnidad').val();
        importe = importe - (importe * (parseFloat($('#MaterialesTareasalbaranesclienteDescuento').val()) / 100));
        importe = Math.round(importe * 100) / 100
        $('#MaterialesTareasalbaranesclienteImporte').val(importe);
    }
    $('#MaterialesTareasalbaranesclienteCantidad').keyup(function () {
        calcular_materiale();
    });
    $('#MaterialesTareasalbaranesclientePrecioUnidad').keyup(function () {
        calcular_materiale();
    });
    $('#MaterialesTareasalbaranesclienteDescuento').keyup(function () {
        calcular_materiale();
    });
</script>
<?php echo $this->Form->end(__('Guardar', true)); ?>
