<?php echo $this->Form->create('TareasAlbaranesclientesreparacionesParte', array('type' => 'file', 'style' => 'width: 100%; margin-left: 0;')); ?>
<table class="view" style="font-size: 75%; width: 100%">
    <tr>
        <th>Nº Parte</th>
        <th style="width: 200px">Fecha</th>
        <th colspan="2">Mecánico</th>
    </tr>
    <tr>
        <td>
            <?php
            echo $this->Form->input('numero', array('label' => false));
            echo $this->Form->input('tareas_albaranesclientesreparacione_id', array('type' => 'hidden', 'value' => $tareas_albaranesclientesreparacione_id));
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
            <?php echo $this->Form->input('operacion', array('label' => false)); ?>
        </td>
        <td colspan="2">
            <?php echo $this->Form->input('observaciones', array('label' => false)); ?>
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
                    <th>Inicio</th>
                    <th>Final</th>
                    <th>Real</th>
                    <th>Imputable</th>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('horasdesplazamientoinicio_ida', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientofin_ida', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientoreales_ida', array('label' => false, 'readonly' => true, 'value' => 0)); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientoimputables_ida', array('label' => false, 'value' => 0)); ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('horasdesplazamientoinicio_vuelta', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientofin_vuelta', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientoreales_vuelta', array('label' => false, 'readonly' => true, 'value' => 0)); ?></td>
                    <td><?php echo $this->Form->input('horasdesplazamientoimputables_vuelta', array('label' => false, 'value' => 0)); ?></td>
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
                    <td><?php echo $this->Form->input('kilometrajereal_ida', array('label' => false, 'value' => $tarea['Albaranesclientesreparacione']['Centrostrabajo']['distancia'])); ?></td>
                    <td><?php echo $this->Form->input('kilometrajeimputable_ida', array('label' => false, 'value' => $tarea['Albaranesclientesreparacione']['Centrostrabajo']['distancia'])); ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('kilometrajereal_vuelta', array('label' => false, 'value' => $tarea['Albaranesclientesreparacione']['Centrostrabajo']['distancia'])); ?></td>
                    <td><?php echo $this->Form->input('kilometrajeimputable_vuelta', array('label' => false, 'value' => $tarea['Albaranesclientesreparacione']['Centrostrabajo']['distancia'])); ?></td>
                </tr>
            </table>
        </td>
        <td>
            <?php
            if ($tarea['Albaranesclientesreparacione']['Centrostrabajo']['modofacturacion'] == 'preciofijio')
                echo $this->Form->input('preciodesplazamiento', array('label' => false, 'value' => $tarea['Albaranesclientesreparacione']['Centrostrabajo']['preciofijodesplazamiento']));
            else
                echo $this->Form->input('preciodesplazamiento', array('label' => false, 'value' => 0));
            ?>
        </td>
    </tr>
    <tr>
        <th colspan="2">Horas de Trabajo</th>
        <th>Descuento Mano de Obra</th>
        <th>Dietas</th>
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
                    <td><?php echo $this->Form->input('horasreales', array('label' => false, 'readonly' => false, 'value' => 0)); ?></td>
                    <td><?php echo $this->Form->input('horasimputables', array('label' => false, 'value' => 0)); ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <th>Precio de Hora en Centro de Trabajo</th>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('preciohoraencentro', array('label' => false, 'value' => $tarea['Albaranesclientesreparacione']['Centrostrabajo']['preciohoraencentro'], 'readonly' => false, 'default' => 0)); ?></td>
                </tr>
            </table>
        </td>
        <td>
            <?php echo $this->Form->input('descuento_manodeobra', array('label' => False, 'default' => 0, 'class' => 'percent', 'after' => '<span class="add-on">&percnt;</span>')) ?>
        </td>
        <td>
            <table>
                <tr>
                    <th>Real</th>
                    <th>Imputadas</th>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('dietasreales', array('label' => false, 'value' => $tarea['Albaranesclientesreparacione']['Centrostrabajo']['dietas'])); ?></td>
                    <td><?php echo $this->Form->input('dietasimputables', array('label' => false, 'value' => $tarea['Albaranesclientesreparacione']['Centrostrabajo']['dietas'])); ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $this->Form->input('file', array('type' => 'file', 'label' => 'Parte de Centro de Trabajo Escaneado')); ?>
        </td>
        <td colspan="2">
            <table>
                <tr><th colspan="2">Otros Servicios</th></tr>
                <tr><td colspan="2">Descripción</td></tr>
                <tr><td colspan="2"><?php echo $this->Form->input('varios_descripcion', array('label' => false)); ?></td></tr>
                <tr>
                    <td>Real</td>
                    <td>Imputable</td>
                </tr>
                <tr>
                    <td><?php echo $this->Form->input('otrosservicios_real', array('label' => false, 'value' => 0)); ?></td>
                    <td><?php echo $this->Form->input('otrosservicios_imputable', array('label' => false, 'value' => 0)); ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php echo $this->Form->end(__('Guardar', true)); ?>
<script type="text/javascript">
    $(function(){
        var currentTime = new Date();
        
        // Horas de Trabajo
        $('#TareasAlbaranesclientesreparacionesParteHorainicio').timeEntry({show24Hours: true,defaultTime: null});
        $('#TareasAlbaranesclientesreparacionesParteHorainicio').timeEntry('setTime', currentTime);
        $('#TareasAlbaranesclientesreparacionesParteHorafinal').timeEntry({show24Hours: true,defaultTime: null});
        $('#TareasAlbaranesclientesreparacionesParteHorafinal').timeEntry('setTime', currentTime);
        
        $('#TareasAlbaranesclientesreparacionesParteHorainicio').keyup(calcula_horasreales_trabajo);
        $('#TareasAlbaranesclientesreparacionesParteHorafinal').keyup(calcula_horasreales_trabajo);
 
        function calcula_horasreales_trabajo(){
            horainicio = $('#TareasAlbaranesclientesreparacionesParteHorainicio').timeEntry('getTime');
            horafinal =$('#TareasAlbaranesclientesreparacionesParteHorafinal').timeEntry('getTime');
            diferenciamilisegundos = (horafinal-horainicio); // difference in milliseconds
            horasreales = Math.round((((diferenciamilisegundos/1000)/60)/60) *100)/100; // difference in milliseconds
            $('#TareasAlbaranesclientesreparacionesParteHorasreales').val(horasreales);
            $('#TareasAlbaranesclientesreparacionesParteHorasimputables').val(horasreales);
        }
        
        // Desplazamiento Ida
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientoinicioIda').timeEntry({show24Hours: true,defaultTime: null});
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientoinicioIda').timeEntry('setTime', currentTime);
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientoinicioIda').keyup(calcula_horasreales_desplazamiento_ida);
        
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientofinIda').timeEntry({show24Hours: true,defaultTime: null});
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientofinIda').timeEntry('setTime', currentTime);
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientofinIda').keyup(calcula_horasreales_desplazamiento_ida);
          
        function calcula_horasreales_desplazamiento_ida(){
            horainicio = $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientoinicioIda').timeEntry('getTime');
            horafinal = $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientofinIda').timeEntry('getTime');
            diferenciamilisegundos = (horafinal-horainicio); // difference in milliseconds
            horasreales = Math.round((((diferenciamilisegundos/1000)/60)/60) *100)/100; // difference in milliseconds
            $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientorealesIda').val(horasreales)
            $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientoimputablesIda').val(horasreales)
        }
        
        // Desplazamiento Vuelta
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientoinicioVuelta').timeEntry({show24Hours: true,defaultTime: null});
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientoinicioVuelta').timeEntry('setTime', currentTime);
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientoinicioVuelta').keyup(calcula_horasreales_desplazamiento_vuelta);
        
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientofinVuelta').timeEntry({show24Hours: true,defaultTime: null});
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientofinVuelta').timeEntry('setTime', currentTime);
        $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientofinVuelta').keyup(calcula_horasreales_desplazamiento_vuelta);
        
        function calcula_horasreales_desplazamiento_vuelta(){
            horainicio = $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientoinicioVuelta').timeEntry('getTime');
            horafinal =$('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientofinVuelta').timeEntry('getTime');
            diferenciamilisegundos = (horafinal-horainicio); // difference in milliseconds
            horasreales = Math.round((((diferenciamilisegundos/1000)/60)/60) *100)/100; // difference in milliseconds
            $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientorealesVuelta').val(horasreales)
            $('#TareasAlbaranesclientesreparacionesParteHorasdesplazamientoimputablesVuelta').val(horasreales)
        }
        
        // Fecha
        $('#TareasAlbaranesclientesreparacionesParteFecha').dateEntry({dateFormat: 'dmy-'});
        $('#TareasAlbaranesclientesreparacionesParteFecha').dateEntry('setDate', currentTime);
    });
</script>