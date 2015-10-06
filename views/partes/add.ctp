<?php echo $this->Form->create('Parte', array('type' => 'file', 'style' => 'margin-left: 0;')); ?>
<h2>Orden: <?php echo zerofill($tarea['Ordene']['numero']) ?> - Tarea: <?php echo zerofill($tarea['Tarea']['numero']) ?></h2>
<table class="view partes" style="font-size: 75%; ">
    <tr>
        <th>Nº Parte</th>
        <th style="width: 200px">Fecha</th>
        <th colspan="2">Mecánico</th>
    </tr>
    <tr>
        <td>
            <?php
            echo $this->Form->input('numero', array('label' => false));
            echo $this->Form->input('tarea_id', array('type' => 'hidden', 'value' => $tarea_id));
            ?>
        </td>
        <td>
            <?php echo $this->Form->input('fecha', array('type' => 'text', 'label' => false, 'dateFormat' => 'DMY', 'style' => 'width: 80%;')); ?>
        </td>
        <td colspan="2">
            <?php echo $this->Form->input('mecanico_id', array('label' => false, 'data-placeholder' => 'Selecione el Mecánico...', 'empty' => '', 'class' => 'chzn-select-required')); ?>
        </td>
    </tr>
    <tr>
        <th colspan="2">Descripción Operación</th>
        <th colspan="2">Observaciones</th>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $this->Form->input('operacion', array('label' => false, 'class' => 'textfield', 'rows' => '3')); ?>
        </td>
        <td colspan="2">
            <?php echo $this->Form->input('observaciones', array('label' => false, 'class' => 'textfield', 'rows' => '3')); ?>
        </td>
    </tr>
    <tr>
        <th colspan="2">Horas Desplazamiento</th>
        <th>Kilometraje</th>
        <th>Precio Desplazamiento</th>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <th style="width: 150px;">Inicio</th>
                    <th style="width: 150px;">Final</th>
                    <th>Real</th>
                    <th>Imputable</th>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('horasdesplazamientoinicio_ida', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientofin_ida', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientoreales_ida', array('label' => false, 'readonly' => true, 'value' => 0, 'class' => 'dineroinput')); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientoimputables_ida', array('label' => false, 'value' => 0, 'class' => 'dineroinput')); ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('horasdesplazamientoinicio_vuelta', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientofin_vuelta', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientoreales_vuelta', array('label' => false, 'readonly' => true, 'value' => 0, 'class' => 'dineroinput')); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientoimputables_vuelta', array('label' => false, 'value' => 0, 'class' => 'dineroinput')); ?></td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <th>Real</th>
                    <th>Imputable</th>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('kilometrajereal_ida', array('label' => false, 'value' => $tarea['Ordene']['Centrostrabajo']['distancia'], 'class' => 'dineroinput')); ?></td>
                    <td><?php echo $this->Form->input('kilometrajeimputable_ida', array('label' => false, 'value' => $tarea['Ordene']['Centrostrabajo']['distancia'], 'class' => 'dineroinput')); ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('kilometrajereal_vuelta', array('label' => false, 'value' => $tarea['Ordene']['Centrostrabajo']['distancia'], 'class' => 'dineroinput')); ?></td>
                    <td><?php echo $this->Form->input('kilometrajeimputable_vuelta', array('label' => false, 'value' => $tarea['Ordene']['Centrostrabajo']['distancia'], 'class' => 'dineroinput')); ?></td>
                </tr>
            </table>
        </td>
        <td>
            <?php
            if ($tarea['Ordene']['Centrostrabajo']['modofacturacion'] == 'preciofijio')
                echo $this->Form->input('preciodesplazamiento', array('label' => false, 'value' => $tarea['Ordene']['Centrostrabajo']['preciofijodesplazamiento'], 'class' => 'dineroinput'));
            else
                echo $this->Form->input('preciodesplazamiento', array('label' => false, 'value' => 0, 'class' => 'dineroinput'));
            ?>
        </td>
    </tr>
    <tr>
        <th colspan="2">Horas de Trabajo</th>
        <th>Dietas</th>
        <th>Precio de Hora en Centro de Trabajo</th>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <th>Inicio</th>
                    <th>Final</th>
                    <th>Real</th>
                    <th>Imputadas</th>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('horainicio', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                    <td><?php echo $this->Form->input('horafinal', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                    <td><?php echo $this->Form->input('horasreales', array('label' => false, 'readonly' => true, 'value' => 0, 'class' => 'dineroinput')); ?></td>
                    <td><?php echo $this->Form->input('horasimputables', array('label' => false, 'value' => 0, 'class' => 'dineroinput')); ?></td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <th>Real</th>
                    <th>Imputadas</th>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('dietasreales', array('label' => false, 'value' => $tarea['Ordene']['Centrostrabajo']['dietas'], 'class' => 'dineroinput')); ?></td>
                    <td><?php echo $this->Form->input('dietasimputables', array('label' => false, 'value' => $tarea['Ordene']['Centrostrabajo']['dietas'], 'class' => 'dineroinput')); ?></td>
                </tr>
            </table>
        </td>
        <td><?php echo $this->Form->input('preciohoraencentro', array('label' => false, 'value' => $tarea['Ordene']['Centrostrabajo']['preciohoraencentro'], 'readonly' => false, 'class' => 'dineroinput')); ?></td>
    </tr>
    <tr>
        <td colspan="4">
            <table>
                <tr>
                    <th colspan="2">Otros Servicios</th>
                    <td>Real</td>
                    <td>Imputable</td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $this->Form->input('varios_descripcion', array('label' => false, 'class' => 'textfield', 'placeholder' => 'Descripción', 'rows' => '3')); ?></td>
                    <td><?php echo $this->Form->input('otrosservicios_real', array('label' => false, 'value' => 0, 'class' => 'dineroinput')); ?></td>
                    <td><?php echo $this->Form->input('otrosservicios_imputable', array('label' => false, 'value' => 0, 'class' => 'dineroinput')); ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $this->Form->input('file', array('type' => 'file', 'label' => 'Parte de Centro de Trabajo Escaneado')); ?>
        </td>
    </tr>
</table>
<input type="text" id="defaultEntry">
<?php echo $this->Form->end(__('Guardar', true)); ?>
<script type="text/javascript">
    $(function(){
        var currentTime = new Date();
        
        // Horas de Trabajo
        $('#ParteHorainicio').timeEntry({show24Hours: true,defaultTime: null});
        $('#ParteHorainicio').timeEntry('setTime', currentTime);
        $('#ParteHorafinal').timeEntry({show24Hours: true,defaultTime: null});
        $('#ParteHorafinal').timeEntry('setTime', currentTime);
        
        $('#ParteHorainicio').keyup(calcula_horasreales_trabajo);
        $('#ParteHorafinal').keyup(calcula_horasreales_trabajo);
 
        function calcula_horasreales_trabajo(){
            horainicio = $('#ParteHorainicio').timeEntry('getTime');
            horafinal =$('#ParteHorafinal').timeEntry('getTime');
            diferenciamilisegundos = (horafinal-horainicio); // difference in milliseconds
            horasreales = Math.round((((diferenciamilisegundos/1000)/60)/60) *100)/100; // difference in milliseconds
            $('#ParteHorasreales').val(horasreales);
            $('#ParteHorasimputables').val(horasreales);
        }
        
        // Desplazamiento Ida
        $('#ParteHorasdesplazamientoinicioIda').timeEntry({show24Hours: true,defaultTime: null});
        $('#ParteHorasdesplazamientoinicioIda').timeEntry('setTime', currentTime);
        $('#ParteHorasdesplazamientoinicioIda').keyup(calcula_horasreales_desplazamiento_ida);
        
        $('#ParteHorasdesplazamientofinIda').timeEntry({show24Hours: true,defaultTime: null});
        $('#ParteHorasdesplazamientofinIda').timeEntry('setTime', currentTime);
        $('#ParteHorasdesplazamientofinIda').keyup(calcula_horasreales_desplazamiento_ida);
          
        function calcula_horasreales_desplazamiento_ida(){
            horainicio = $('#ParteHorasdesplazamientoinicioIda').timeEntry('getTime');
            horafinal =$('#ParteHorasdesplazamientofinIda').timeEntry('getTime');
            diferenciamilisegundos = (horafinal-horainicio); // difference in milliseconds
            horasreales = Math.round((((diferenciamilisegundos/1000)/60)/60) *100)/100; // difference in milliseconds
            $('#ParteHorasdesplazamientorealesIda').val(horasreales)
            $('#ParteHorasdesplazamientoimputablesIda').val(horasreales)
        }
        
        // Desplazamiento Vuelta
        $('#ParteHorasdesplazamientoinicioVuelta').timeEntry({show24Hours: true,defaultTime: null});
        $('#ParteHorasdesplazamientoinicioVuelta').timeEntry('setTime', currentTime);
        $('#ParteHorasdesplazamientoinicioVuelta').keyup(calcula_horasreales_desplazamiento_vuelta);
        
        $('#ParteHorasdesplazamientofinVuelta').timeEntry({show24Hours: true,defaultTime: null});
        $('#ParteHorasdesplazamientofinVuelta').timeEntry('setTime', currentTime);
        $('#ParteHorasdesplazamientofinVuelta').keyup(calcula_horasreales_desplazamiento_vuelta);
        
        function calcula_horasreales_desplazamiento_vuelta(){
            horainicio = $('#ParteHorasdesplazamientoinicioVuelta').timeEntry('getTime');
            horafinal =$('#ParteHorasdesplazamientofinVuelta').timeEntry('getTime');
            diferenciamilisegundos = (horafinal-horainicio); // difference in milliseconds
            horasreales = Math.round((((diferenciamilisegundos/1000)/60)/60) *100)/100; // difference in milliseconds
            $('#ParteHorasdesplazamientorealesVuelta').val(horasreales)
            $('#ParteHorasdesplazamientoimputablesVuelta').val(horasreales)
        }
        
        // Fecha
        $('#ParteFecha').dateEntry({dateFormat: 'dmy-'});
        $('#ParteFecha').dateEntry('setDate', currentTime);
    });
</script>