<script language="javascript" type="text/javascript">
function windowClose() {
window.open('','_parent','');
window.close();
}
</script>
<div>
    <h2><?php __('Facturas Clientes'); ?></h2>
    <?php
  //  $path = 'C:\\xampp\\htdocs\\';
     $path = '../webroot/files/facturaEmails/' ;
    $nombre_fichero = 'factura_' . $facturasCliente['FacturasCliente']['id'] . '.pdf';
    $pathFactura = $path . $nombre_fichero;

    echo "<h2>Resultado de la generaci&oacute;n de factura. </h2> ";
    if (file_exists($pathFactura)) {
        echo "<h1 style='color:green'><br/>La Factura se ha creado correctamente en ruta: $pathFactura </h1>";
    } else {
        echo "<h1 style='color:red'><br/>La Factura NO se ha creado.</h1>";
    }
    ?> 
    <input type="button" value="CERRAR" onclick="windowClose();">
</div>
