<div class="facturasClientes">
    <h2><?php __('Filtro de Facturación'); ?></h2>
    <?php echo $this->Form->create('FacturasCliente'); ?>
    <fieldset>
        <legend><?php __('Clientes'); ?></legend>
        <p style="margin-bottom: 30px">Todos los clientes <?php echo $this->Form->checkbox('Filtro.todos', array('hiddenField' => false)); ?></p>
        <div id="clientes-seleccionar">
            <a href="#" class="linkbutton" id="add_cliente_to_list">Añadir Cliente al Filtro +</a>
            <table id="cliente_list">
                <tr>
                    <th>Cliente</th>
                    <th>Borrar</th>
                </tr>
            </table>
        </div>
        <label style="font-weight: bold;">Datos por Defecto de la Factura:</label>
        <?php echo $this->Form->input('Filtro.fecha_factura', array('type' => 'date')); ?> 
        <?php echo $this->Form->input('Filtro.serie_factura', array('type' => 'select', 'empty' => false, 'options' => $seriesfacturasventas)); ?> 
    </fieldset>
    <fieldset>
        <legend><?php __('Intervalo de  Facturación'); ?></legend>
        <?php
        // Inicializa fechas inicio Fin
        if (empty($this->params['url']['FechaInicio'])) {
            $this->params['url']['FechaInicio'] = '1998-01-01';
        }
        if (empty($this->params['url']['FechaFin'])) {
            $this->params['url']['FechaFin'] = date("Y-m-d");
        }
        ?>
        <label>Fecha de Inicio</label>
        <?php echo $this->Form->day('Filtro.fecha_inicio', date('d'), array('empty' => false)); ?> 
        <?php echo $this->Form->month('Filtro.fecha_inicio', date('m'), array('empty' => false)); ?> 
        <?php echo $this->Form->year('Filtro.fecha_inicio', 1994, date('Y'), null, array('empty' => false)); ?> 
        <label>Fecha de Fin</label>
        <?php echo $this->Form->day('Filtro.fecha_fin', date('d'), array('empty' => false)); ?> 
        <?php echo $this->Form->month('Filtro.fecha_fin', date('m'), array('empty' => false)); ?> 
        <?php echo $this->Form->year('Filtro.fecha_fin', 1994, date('Y'), null, array('empty' => false)); ?> 
        <label>Serie de los Albaranes de Venta</label>
    <?php echo $this->Form->input('Filtro.seriesAlbaranesventa', array('multiple' => true, 'style' => 'width: 60%;', 'options' => $seriesAlbaranesventas, 'label' => false)) ?>
    </fieldset>
        <?php echo $this->Form->end(__('Albaranes Posibles de Facturar', true)); ?>
    <div id="add-cliente-popup"  title="Añadir Cliente al Filtro">
<?php echo $this->Autocomplete->replace_select('Cliente', 'Cliente', true, null); ?>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        $("#FiltroSeriesAlbaranesventa").select2();

        $("#dialog:ui-dialog").dialog("destroy");
        $("#add-cliente-popup").dialog({
            autoOpen: false,
            width: '400',
            height: 'auto',
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                    html = '<tr><td>' + $('#autocomplete-Cliente').val() + '<input type="hidden" name="data[Filtro][Cliente][]" value="' + $('#cliente_id').val() + '" /></td><td><a href="#" class="borrar-cliente-from-list">Borrar</a></td></tr>'
                    $('#cliente_list').append(html);
                }
            },
            modal: true
        });
        $('#add_cliente_to_list').click(function () {
            $("#add-cliente-popup").dialog('open');
            $('#autocomplete-Cliente').val('');
            $('#cliente_id').val('');
            return false;
        });
        $('.borrar-cliente-from-list').live('click', function (event) {
            $(this).parent().parent().remove();
            return false;
        });
        $('#FiltroTodos').change(function () {
            if ($(this).is(':checked')) {
                $('#clientes-seleccionar').hide();
            } else {
                $('#clientes-seleccionar').show();
            }
        });
    });
</script>