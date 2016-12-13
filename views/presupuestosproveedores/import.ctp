
<div class="articulos">
    <h2>
        <?php __('Importar artículos existentes de  l almacén ' . $presupuestosproveedore['Almacene']['nombre'] 
                .', al Presupuesto de proveedor Nº. ' . $presupuestosproveedore['Presupuestosproveedore']['numero'] ); ?>
    </h2>

    <?php
    if (!isset($resultado)) {
        //echo " resultado is null<br/>";
        print "<h3>Seleccione el fichero .CSV con columnas Referencia, Cantidad, idTarea, Precio y Descuento.</h3><br /><br />";
        print "<h3>Las columnas idTarea, Precio y Descuento son OPCIONALES.</h3><br /><br />";
        print "<form enctype='multipart/form-data' action='import' method='post'>";
        print "<input size='50' type='file' name='filename'><br />";
        print "<input type='hidden' name='idPresProvee' value='" . $presupuestosproveedore['Presupuestosproveedore']['id'] . "'>";
        print "<input type='hidden' name='idAlmacene' value='" . $presupuestosproveedore['Almacene']['id'] . "'>";
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