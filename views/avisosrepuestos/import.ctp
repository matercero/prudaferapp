
<div class="articulos">
    <h2>
        <?php __('Importar artículos al Aviso de repuesto Nº. ' . $avisosrepuesto['Avisosrepuesto']['numero'] .
                ' en el almacén ' . $avisosrepuesto['Almacene']['nombre']) ; ?>
    </h2>

    <?php
    if (!isset($resultado)) {
        //echo " resultado is null<br/>";
        print "<h3>Seleccione el fichero .CSV con Referencia y cantidad de los artículos a importar.</h3><br /><br />";
        print "<form enctype='multipart/form-data' action='import' method='post'>";
        print "<input size='50' type='file' name='filename'><br />";
        print "<input type='hidden' name='idAviso' value='" . $avisosrepuesto['Avisosrepuesto']['id'] . "'>";
        print "<input type='hidden' name='idAlmacene' value='" . $avisosrepuesto['Almacene']['id'] . "'>";
        print "<br /><br />"
                . " <div style='text-align:center'>  <input type='submit' name='submit' value=' Importar ' class='button_css_blue' "
                . " style='width: 8em;  height: 2em;'>"
                . " <div/>"
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