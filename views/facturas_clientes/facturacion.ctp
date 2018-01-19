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
            $this->params['url']['FechaInicio'] =  date("Y-m-d");
        }
        if (empty($this->params['url']['FechaFin'])) {
            $this->params['url']['FechaFin'] = date("Y-m-d");
        }
        ?>
        <table id="intervalo">
            <tr>

                <!-- Fecha inicio NUEVA -->
                <td style="width: 250px">
                    <?php
                    echo $this->Form->input('Filtro.FechaInicio', array('type' => 'text', 'id' => 'calendar_inputEnt',
                        'value' => $this->params['url']['FechaInicio'], 'style' => 'width: 120px;'))
                    ?>
                </td>
                <!-- Fecha Fin NUEVA -->
                <td style="width: 250px">
                    <?php
                    echo $this->Form->input('Filtro.FechaFin', array('type' => 'text', 'id' => 'calendar_inputFin',
                        'value' => $this->params['url']['FechaFin'], 'style' => 'width: 120px;'))
                    ?>
                </td>
                <td>
                    <label>Serie de los Albaranes de Venta</label>
                    <?php echo $this->Form->input('Filtro.seriesAlbaranesventa', array('multiple' => true, 'style' => 'width: 60%;', 'options' => $seriesAlbaranesventas, 'label' => false)) ?>
                </td>
            </tr>
        </table>
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
<script>
    dhtmlXCalendarObject.prototype.langData["es"] = {
        dateformat: '%d-%m-%Y',
        monthesFNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthesSNames: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        daysFNames: ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado", "Domingo"],
        daysSNames: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        weekstart: 1,
        weekname: "S",
        today: "Hoy",
        clear: "Limpiar"
    };
    var myCalendar = new dhtmlXCalendarObject(["calendar_inputEnt", "calendar_inputFin"]);
    myCalendar.loadUserLanguage("es");
    myCalendar.hideTime();
</script>