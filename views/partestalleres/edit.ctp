<?php echo $this->Form->create('Partestallere', array('type' => 'file', array('action' => 'edit'))); ?>
<fieldset style=" width: 100%;">
    <legend><?php __('Editando Parte de Taller'); ?></legend>
    <table class="view" style="font-size: 75%;">
        <tr>
            <th>Número</th>
            <th>Fecha</th>
            <th>Mecánico</th>
        </tr>
        <tr>
            <td>
                <?php
                echo $this->Form->hidden('tarea_id', array('type' => 'hidden'));
                echo $this->Form->input('numero', array('label' => false));
                ?>
            </td>
            <td>
                <?php echo $this->Form->input('fecha', array('type' => 'text', 'label' => false, 'dateFormat' => 'DMY', 'style' => 'width: 80%;')); ?>
            </td>
            <td>
                <?php echo $this->Form->input('mecanico_id', array('label' => false, 'data-placeholder' => 'Selecione el Mecánico...', 'empty' => '', 'class' => 'chzn-select-required')); ?>
            </td>
        </tr>
        <tr>
            <th>Horas de Trabajo</th>
            <th colspan="2">Descripción de Operaciónes</th>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <th>Inicio</th>
                        <th>Final</th>
                        <th>Real</th>
                        <th>Imputable</th>
                    </tr>
                    <tr>
                        <td><?php echo $this->Form->input('horainicio', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                        <td><?php echo $this->Form->input('horafinal', array('type' => 'text', 'label' => false, 'style' => 'width: 80%;')); ?></td>
                        <td><?php echo $this->Form->input('horasreales', array('label' => false, 'readonly' => true)); ?></td>
                        <td><?php echo $this->Form->input('horasimputables', array('label' => false)); ?></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Precio de Hora de Trabajo en Taller</th>
                    </tr>
                    <tr>
                        <td><?php echo $this->Form->input('preciohoraentraller', array('label' => false, 'readonly' => false)); ?></td>
                    </tr>
                    <tr>
                        <th>Descuento Mano de Obra</th>
                    </tr>
                    <tr>
                        <td><?php echo $this->Form->input('descuento_manodeobra', array('label' => False, 'default' => 0, 'class' => 'percent', 'after' => '<span class="add-on">&percnt;</span>')) ?></td>
                    </tr>
                </table>
            </td>
            <td colspan="2">
                <?php echo $this->Form->input('operacion', array('label' => false)); ?>
                <p><span>Observaciones</span></p>
                <?php echo $this->Form->input('observaciones', array('label' => false)); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php
                echo 'Adjunto Actual: ' . $this->Html->link(__($this->Form->value('Partestallere.parteescaneado'), true), '/files/partestallere/' . $this->Form->value('Partestallere.parteescaneado'));
                echo $this->Form->input('remove_file', array('type' => 'checkbox', 'label' => 'Borrar Parte de Taller Escaneado Actual', 'hiddenField' => false));
                echo $this->Form->input('file', array('type' => 'file', 'label' => 'Parte de Taller Escaneado'));
                ?>
            </td>
            <td colspan="3">
                <table>
                    <tr><th colspan="2">Otros Servicios</th></tr>
                    <tr><td colspan="2">Descripción</td></tr>
                    <tr><td colspan="2"><?php echo $this->Form->input('varios_descripcion', array('label' => false)); ?></td></tr>
                    <tr>
                        <td>Real</td>
                        <td>Imputable</td>
                    </tr>
                    <tr>
                        <td><?php echo $this->Form->input('otrosservicios_real', array('label' => false)); ?></td>
                        <td><?php echo $this->Form->input('otrosservicios_imputable', array('label' => false)); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</fieldset>
<?php echo $this->Form->end(__('Guardar', true)); ?>
<script type="text/javascript">
    $(function(){
        date = new Date('<?php echo $this->Form->value('Partestallere.fecha') ?>');
        
        // Horas de Trabajo
        $('#PartestallereHorainicio').timeEntry({show24Hours: true});
        $('#PartestallereHorafinal').timeEntry({show24Hours: true});
        
        $('#PartestallereHorainicio').keyup(calcula_horasreales);
        $('#PartestallereHorafinal').keyup(calcula_horasreales);
        
        function calcula_horasreales(){
            horainicio = $('#PartestallereHorainicio').timeEntry('getTime');
            horafinal =$('#PartestallereHorafinal').timeEntry('getTime');
            diferenciamilisegundos = (horafinal-horainicio); // difference in milliseconds
            horasreales = Math.round((((diferenciamilisegundos/1000)/60)/60) *100)/100; // difference in milliseconds
            $('#PartestallereHorasreales').val(horasreales)
            $('#PartestallereHorasimputables').val(horasreales)
        }
        
        // Fecha
        $('#PartestallereFecha').dateEntry({dateFormat: 'dmy-'});
        $('#PartestallereFecha').dateEntry('setDate', date);
    })
</script>