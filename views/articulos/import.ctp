
<div class="articulos">
    <h2>
        <?php __('Importar artículos desde fichero .CSV '); ?>
    </h2>

    <?php
    if (!isset($resultado)) {
        //echo " resultado is null<br/>";
        print "<h3>Seleccione el fichero .CSV con columnas: <br /> REFERENCIA, NOMBRE, ULTIMOPRECIOCOMPRA,
            PRECIO_SIN_IVA, FAMILIA_ID, PROVEEDORE_ID,
            PESO (kgs), LARGO (mm), ANCHO (mm), ALTO (mm).</h3><br /><br />";
        print "<form enctype='multipart/form-data' action='import' method='post'>";
        print "Seleccione almacén: 
                <select name='almacen'>    
                    <option value='1'>A1 Moron</option>    
                    <option value='2'>A2 Alcalá</option>    
                  </select><br>";
        print "<br /><br />";
        print "<input size='50' type='file' name='filename'><br />"
                . " <div style='text-align:center'> "
                . " <input type='submit' name='submit' value=' Importar ' class='button_css_blue' "
                . " style='width: 8em;  height: 2em;'>"
                . " <div/>"
                . "</form>";
    } else {
        if (strpos($resultado, 'No') !== false) {
            print_r($resultado);
        } else {
            print_r($resultadoUpload);
            print_r($resultadoResumen);
            echo "<br /><br /><b>Detalle por registro:</b><br /><br />";
            print_r($resultado);
            echo $this->Html->link(__('Listar Artículos', true), array('action' => 'index'), array('class' => 'button_link'));
        }
    }
    ?>
</div>