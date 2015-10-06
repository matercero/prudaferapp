<?php echo $this->Form->create('Manodeobra'); ?>
<fieldset>
    <legend><?php __('Editando Mano de Obra a la Tarea del Presupuesto'); ?></legend>
    <?php
    echo $this->Form->input('tareaspresupuestocliente_id', array('type' => 'hidden', 'value' => $tareaspresupuestocliente['id']));
    echo $this->Form->input('horas', array('default' => 0));
    if ($tareaspresupuestocliente['tipo'] == 'centro')
        echo $this->Form->input('precio_hora', array('label' => 'Precio Hora en Centro', 'default' => $centrostrabajo['preciohoraencentro']));
    elseif ($tareaspresupuestocliente['tipo'] == 'taller')
        echo $this->Form->input('precio_hora', array('label' => 'Precio Hora en Taller', 'default' => $centrostrabajo['preciohoraentraller']));
    else
        echo $this->Form->input('precio_hora', array('label' => 'Precio Hora', 'default' => 0));
    if (!empty($centrostrabajo['descuentomanoobra']))
        echo $this->Form->input('descuento', array('default' => $centrostrabajo['descuentomanoobra'], 'label' => 'Descuento de Mano de Obra  %'));
    else
        echo $this->Form->input('descuento', array('default' => 0, 'label' => 'Descuento de Mano de Obra %'));
    echo $this->Form->input('importe', array('default' => 0, 'readonly' => true));
    echo $this->Form->input('descripcion', array('placeholder' => 'Inserta aquí una descripción'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Guardar', true)); ?>
<script type="text/javascript">
    //Calculo automático
    function calcular_manodeobras(){
        var importe = parseFloat($('#ManodeobraHoras').val())*parseFloat($('#ManodeobraPrecioHora').val());
        importe = importe - (importe * (parseFloat($('#ManodeobraDescuento').val())/100));
        $('#ManodeobraImporte').val(importe);
    }
    $('#ManodeobraHoras').keyup(function(){
        calcular_manodeobras();
    });
    $('#ManodeobraPrecioHora').keyup(function(){
        calcular_manodeobras();
    });
    $('#ManodeobraDescuento').keyup(function(){
        calcular_manodeobras();
    });
</script>