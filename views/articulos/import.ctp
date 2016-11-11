
<div class="articulos">
    <h2>
        <?php __('Importar artículos desde fichero. '); ?>
    </h2>

    <?php
    if (!isset($resultado)) {
        //echo " resultado is null<br/>";
        print "Seleccione el fichero .csv con datos de los articulos a importar.<br /><br />";
        print "<form enctype='multipart/form-data' action='import' method='post'>";
        print "<input size='50' type='file' name='filename'><br />";
        print "<br /><br /><input type='submit' name='submit' value='Importar ' style='width: 10em;  height: 2.5em;'></form>";
    } else {
        print_r($resultadoUpload);       
        echo "<br /><b>Resumen de la importacion:</b><br />";
        print_r($resultadoResumen);
        echo "<br /><br /><b>Detalle por registro:</b><br /><br />";
        print_r($resultado);
        echo $this->Html->link(__('Listar Artículos', true), array('action' => 'index'), array('class' => 'button_link'));
    } ?>
</div>