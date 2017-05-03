<p>
    <?php echo $this->Paginator->sort('Ordenar por Fecha', 'fecha'); ?>
    <?php echo $this->Paginator->sort('Ordenar por Numero', 'numero'); ?>
</p>

<?php foreach ($ordenes as $orden): ?>
    <div id="orden<?php echo $orden["Ordene"]["id"] ?>" class="orden_mapa">
        <div class="informacion">
            <h3><?php echo $this->Html->link(__('Orden ' . $orden['Ordene']['numero'], true), array('action' => 'view', $orden['Ordene']['id'])); ?></h3>
            <p><span>Fecha Orden:</span> <?php echo $this->Time->format('d-m-Y', $orden['Ordene']['fecha']) ?></p>
            <p title="Fecha Prevista de Reparación"><span>Fecha Prevista Rep.:</span> <?php echo $this->Time->format('d-m-Y', $orden['Ordene']['fecha_prevista_reparacion']) ?></p>
            <p><span>Cliente:</span> <?php echo isset($orden["Avisostallere"]["Cliente"]) ? $orden["Avisostallere"]["Cliente"]["nombre"] : "" ?></p>
            <p><span>Centro:</span> <?php echo isset($orden["Avisostallere"]["Centrostrabajo"]["centrotrabajo"]) ? $orden["Avisostallere"]["Centrostrabajo"]["centrotrabajo"] : "" ?></p>
            <p><span>Máquina: </span><?php echo isset($orden["Avisostallere"]["Maquina"]) ? $orden["Avisostallere"]["Maquina"]["nombre"] : "" ?></p>
            <p title="<?php echo $orden["Ordene"]["horas_maquina"] ?>"><span>Horas: </span><?php echo substr($orden["Ordene"]["horas_maquina"], 0, 100) ?></p>
            <p><span>Urgente: </span><?php echo $orden["Ordene"]["urgente"] == 1 ? '<span style="color: red">URGENTE</span>' : '<span style="color: green">No urgente</span>' ?></p>
            <p><span>Mantenimiento: </span><span style="color: green"><?php echo $orden["Ordene"]["mantenimientos"] ?></p>
            <p title="<?php echo $orden["Ordene"]["descripcion"] ?>"><span>Descripción: </span><?php echo substr($orden["Ordene"]["descripcion"], 0, 30) ?>...</p>
            <p title="<?php echo $orden["Ordene"]["observaciones"] ?>"><span>Observaciones: </span><?php echo substr($orden["Ordene"]["observaciones"], 0, 30) ?>...</p>
            <p><?php echo $this->Html->link(__('Fecha Aviso: ' . $this->Time->format('d-m-Y H:i:s', $orden["Avisostallere"]["fechaaviso"]), true), array('controller' => 'avisostalleres', 'action' => 'edit', $orden['Avisostallere']['id'])); ?></p>
        </div>
        <div class="botonera">
            <p style="font-size: 160%;">
                <?php echo $orden["Avisostallere"]['Cliente']['riesgos']  == 0 ? '<span style="color:green">RIESGO NO SUPERADO</span>' : '<span class="parpadea textoRiesgo">RIESGO SUPERADO</span>'; ?>                
            </p>
        </div>
        <?php if ($orden["Estadosordene"]["id"] == 5): ?>
            <div class="botonera">
                <span class="button_css_aceptado">Terminada - Pendiente de Facturar</span>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
