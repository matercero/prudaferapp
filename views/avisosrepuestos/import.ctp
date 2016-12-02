
<div class="articulos">
    <h2>
        <?php __('Importar artículos al Aviso de repuesto Nº. ' . $avisosrepuesto['Avisosrepuesto']['numero']); ?>
    </h2>

    <?php
    if (!isset($resultado)) {
        //echo " resultado is null<br/>";
        print "<h3>Seleccione el fichero .CSV con Referencia y cantidad de los artículos a importar.</h3><br /><br />";
        print "<form enctype='multipart/form-data' action='import' method='post'>";
        print "<input size='50' type='file' name='filename'><br />";
        print "<input type='hidden' name='idAviso' value='" . $avisosrepuesto['Avisosrepuesto']['id'] . "'><br />";
        print "<br /><br />"
                . "   <input type='submit' name='submit' value='Importar ' style='width: 10em;  height: 2.5em;'>"
                . "</form>";
    } else {
        print_r($resultadoUpload);
        echo "<br /><b>Resumen de la importacion:</b><br />";
        print_r($resultadoResumen);
        echo "<br /><br /><b>Detalle de incidencias: </b><br /><br />";
        print_r($resultado);        
    }
    ?>
</div>