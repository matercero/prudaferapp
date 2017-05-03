<div class="clientes">
    <h2>
        <?php __('Cliente'); ?>
        <?php echo $html->link(__('Editar', true), array('action' => 'edit', $cliente['Cliente']['id']), array('class' => 'button_link')); ?> 
        <?php echo $html->link(__('Eliminar', true), array('action' => 'delete', $cliente['Cliente']['id']), array('class' => 'button_link'), sprintf(__('¿Desea eliminar el cliente %s?', true), $cliente['Cliente']['id'])); ?> 
        <?php echo $html->link(__('Listar Clientes', true), array('action' => 'index'), array('class' => 'button_link')); ?> 
    </h2>
    <table class="view">
        <tr>
            <td><span>Denomicación Comercial</span></td>
            <td><?php echo $cliente['Cliente']['nombre']; ?></td>
            <td><span>Nombre Fiscal</span></td>
            <td><?php echo $cliente['Cliente']['nombrefiscal']; ?></td>
            <td><span>CIF</span></td>
            <td><?php echo $cliente['Cliente']['cif']; ?></td>
        </tr>
        <tr>
            <td><span>Teléfono Principal</span></td>
            <td><?php echo $cliente['Cliente']['telefono']; ?></td>
            <td><span>Dirección Fiscal</span></td>
            <td><?php echo $cliente['Cliente']['direccion_fiscal']; ?></td>
            <td><span>Cuenta Contable</span></td>
            <td><?php echo $cliente['Cuentascontable']['codigo']; ?></td>
        </tr>
        <tr>
            <td><span>Fax</span></td>
            <td><?php echo $cliente['Cliente']['fax']; ?></td>
        </tr>
        <tr>
            <td><span>Web</span></td>
            <td><?php echo $cliente['Cliente']['web']; ?></td>
            <td><span>Email</span></td>
            <td><?php echo $cliente['Cliente']['email']; ?></td>
            <td><span>Factura Electrónica</span></td>
            <td><?php echo $cliente['Cliente']['facturaelectronica'] == 0 ? 'No' : 'Sí'; ?></td>
        </tr>
        <tr>
            <td><span>Personas de Contacto</span></td>
            <td><?php echo $cliente['Cliente']['personascontacto']; ?></td>
            <td><span>Modo Envio Factura</span></td>
            <td colspan="3"><?php echo $cliente['Cliente']['modoenviofactura']; ?></td>
        </tr>
        <tr>
            <td><span>Riesgos</span></td>   
            <td style="font-size: 120%;">
                <?php echo $cliente['Cliente']['riesgos'] == 0 ? '<span style="color:green">RIESGO NO SUPERADO</span>' : '<span class="parpadea textoRiesgo">RIESGO SUPERADO</span>'; ?>
            </td>
            <td><span>Modo Facturación</span></td>
            <td><?php echo $cliente['Cliente']['modo_facturacion']; ?></td>
            <td><span>Comercial</span></td>
            <td><?php echo $html->link($cliente['Comerciale']['nombre'], array('controller' => 'comerciales', 'action' => 'view', $cliente['Comerciale']['id'])); ?></td>
        </tr>
        <tr>
            <th colspan="6"><h4>Dirección Postal</h4></th>
        </tr>
        <tr>
            <td><span>Provincia</span></td>
            <td><?php echo $cliente['Cliente']['provinciapostal']; ?></td>
            <td><span>Población</span></td>
            <td><?php echo $cliente['Cliente']['poblacionpostal']; ?></td>
        </tr>
        <tr>
            <td><span>Código Postal</span></td>
            <td><?php echo $cliente['Cliente']['codigopostal']; ?></td>
            <td><span>Apto. Correos</span></td>
            <td><?php echo $cliente['Cliente']['apartadocorreospostal']; ?></td>
            <td><span>Dirección</span></td>
            <td><?php echo $cliente['Cliente']['direccion_postal']; ?></td>
        </tr>
        <tr>
            <th colspan="6"><h4>Dirección Fiscal</h4></th>
        </tr>
        <tr>
            <td><span>Provincia</span></td>
            <td><?php echo $cliente['Cliente']['provinciafiscal']; ?></td>
            <td><span>Población</span></td>
            <td><?php echo $cliente['Cliente']['poblacionfiscal']; ?></td>
        </tr>
        <tr>
            <td><span>Código Postal</span></td>
            <td><?php echo $cliente['Cliente']['codigopostalfiscal']; ?></td>
            <td><span>Apto. Correos</span></td>
            <td><?php echo $cliente['Cliente']['apartadocorreosfiscal']; ?></td>
            <td><span>Dirección</span></td>
            <td><?php echo $cliente['Cliente']['direccion_fiscal']; ?></td>
        </tr>
    </table>
    <table class="view">
        <tr>
            <th><h4>Forma de Pago</h4></th>
        <th><h4>Datos Bancarios</h4></th>
        </tr>
        <tr>
            <td><?php echo $cliente['Formapago']['nombre']; ?></td>
            <td>
                <table class="edit">
                    <tr>
                        <td><span>Nombre</span><br/><?php echo $cliente['Cuentasbancaria']['nombre']; ?></td>
                        <td><span>Nº Entidad</span><br/><?php echo $cliente['Cuentasbancaria']['numero_entidad']; ?></td>
                        <td><span>Nº Sucursal</span><br/><?php echo $cliente['Cuentasbancaria']['numero_sucursal']; ?></td>
                        <td><span>D.C</span><br/><?php echo $cliente['Cuentasbancaria']['numero_dc']; ?></td>
                        <td><span>Nº CCC</span><br/><?php echo $cliente['Cuentasbancaria']['numero_cuenta']; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2"><span>BIC/SWIFT</span><br/><?php echo $cliente['Cuentasbancaria']['numero_bicswift']; ?></td>
                        <td colspan="2"><span>IBAN</span><br/><?php echo $cliente['Cuentasbancaria']['numero_iban']; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div class="related">
        <h3>
            Centros de Trabajo
            <?php echo $this->Html->link('Nuevo Centro de Trabajo', array('controller' => 'centrostrabajos', 'action' => 'add_popup', $cliente['Cliente']['id']), array('class' => 'button_link popup')) ?>
            <?php echo $this->Html->link('Nueva Máquina', array('controller' => 'maquinas', 'action' => 'add_popup', $cliente['Cliente']['id']), array('class' => 'button_link popup')) ?>
        </h3>
        <table class="view">
            <tr>
                <th>Centro de Trabajo</th>
                <th>Dirección</th>
                <th class="actions">Acciones</th>
            </tr>
            <?php foreach ($cliente['Centrostrabajo'] as $centrostrabajo): ?>
                <tr>
                    <td><?php echo empty($centrostrabajo['centrotrabajo']) ? '' : $centrostrabajo['centrotrabajo'] ?></td>
                    <td><?php echo $centrostrabajo['direccion'] ?></td>
                    <td class="actions"><?php echo $html->link(__('Ver', true), array('controller' => 'centrostrabajos', 'action' => 'view', $centrostrabajo['id'])); ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="datagrid">
        <table>
            <caption>Teléfonos <?php echo $this->Html->link('Añadir', array('controller' => 'telefonos', 'action' => 'add', 'cliente', $cliente['Cliente']['id']), array('class' => 'popup button_brownie')); ?> </caption>
            <thead>
                <tr><th>Nombre</th><th>Número</th><th>E-mail</th><th>Eliminar</th></tr>
            </thead>
            <tfoot>
                <tr><td colspan="3"></td></tr>
            </tfoot>
            <tbody>
                <?php foreach ($cliente['Telefono'] as $telefono): ?>
                    <tr>
                        <td><?php echo $telefono['nombre'] ?></td>
                        <td><?php echo $telefono['telefono'] ?></td>
                        <td><?php echo $telefono['e-mail'] ?></td>
                        <td>
                            <?php echo $html->link(__('Eliminar', true), array('controller' => 'telefonos', 'action' => 'delete', $telefono['id']), array('class' => 'button_brownie'), sprintf(__('¿Seguro que quieres borrar el teléfono # %s?', true), $telefono['telefono'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
