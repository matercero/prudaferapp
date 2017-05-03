<?php echo $this->Html->css('menu.style'); ?>
<div class="nav-container-outer">
    <ul id="nav-container" class="nav-container">
        <?php if (!empty($_SERVER['HTTP_REFERER'])): ?>
            <li><span class="divider divider-vert" ></span></li>
            <li><a class="item-primary" href="<?php echo $_SERVER['HTTP_REFERER'] ?>" target="_self">Volver</a>
            <?php endif; ?>
        </li><li><span class="divider divider-vert" ></span></li>
        <li><a class="item-primary" href="<?php echo Configure::read('proyect_url') ?>avisostalleres/mapa" target="_self">Avisos</a>
            <ul>                    
                <li><a href="<?php echo Configure::read('proyect_url') ?>avisostalleres" title="Avisos de Taller" target="_self" >Avisos de taller</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>avisostalleres/mapa" title="Mapa Avisos de Taller" target="_self" >Mapa de Avisos de Taller</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>avisosrepuestos" title="Avisos de repuestos" target="_self" >Avisos de repuestos</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>avisosrepuestos/mapa" title="Mapa Avisos de Repuestos" target="_self" >Mapa de Avisos de Repuestos</a></li>
            </ul>
        </li>
        <li><span class="divider divider-vert" ></span></li>
        <li><a class="item-primary" href="<?php echo Configure::read('proyect_url') ?>ordenes/mapa" target="_self">&Oacute;rdenes</a>
            <ul>
                <li><a href="<?php echo Configure::read('proyect_url') ?>ordenes" target="_self">Listado de &oacute;rdenes</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>ordenes/mapa" target="_self">Mapa de &oacute;rdenes</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>events/calendario" title="Calendario de Tareas" target="_self">Calendario de Tareas</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>tareas" target="_self">Listado de Tareas</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>tareas/listadopartes" target="_self">Listado de Partes</a></li>
            </ul>
        </li>
        <li><span class="divider divider-vert" ></span></li>
        <li><a class="item-primary" href="#" target="_self">Compras</a>
            <ul>
                <li><a href="<?php echo Configure::read('proyect_url') ?>presupuestosproveedores" title="Presupuestos a proveedores" target="_self" >Presupuestos a proveedores</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>pedidosproveedores" title="Pedidos a proveedores" target="_self" >Pedidos a proveedores</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>albaranesproveedores" title="Albaranes de compra" target="_self" >Albaranes de compra</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>albaranesproveedores/facturacion" title="Facturación de Albaranes" target="_self" >Facturación de Albaranes</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>facturasproveedores" title="Facturas de compra" target="_self" >Facturas de compra</a></li>
            </ul>
        </li>
        <li><span class="divider divider-vert" ></span></li>
        <li><a class="item-primary" href="#" target="_self">Ventas</a>
            <ul>
                <li><a href="<?php echo Configure::read('proyect_url') ?>presupuestosclientes" title="Presupuestos a clientes" target="_self" >Presupuestos a clientes</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>pedidosclientes" title="Pedidos de clientes" target="_self" >Pedidos de clientes</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>albaranesclientes" title="Albaranes de Repuestos" target="_self" >Albaranes de Repuestos</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>albaranesclientesreparaciones" title="Albaranes de Reparación" target="_self" >Albaranes de Reparación</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>facturas_clientes/facturacion" title="Facturación de Albaranes" target="_self" >Facturación de Albaranes</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>facturas_clientes" title="Facturas de venta" target="_self" >Facturas de venta</a></li>
            </ul>
        </li>
        <li><span class="divider divider-vert" ></span></li>
        <li><a class="item-primary" href="#" target="_self">Maestros</a>
            <ul>
                <li><a href="<?php echo Configure::read('proyect_url') ?>almacenes" title="Almacenes" target="_self" >Almacenes</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>articulos" title="Art&iacute;culos" target="_self" >Art&iacute;culos</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>familias" title="Familas" target="_self" >Familas</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>centrostrabajos" title="Centros de Trabajo" target="_self" >Centros de Trabajo</a></li>	
                <li><a href="<?php echo Configure::read('proyect_url') ?>clientes" title="Clientes" target="_self" >Clientes</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>comerciales" title="Comerciales" target="_self" >Comerciales</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>comerciales_proveedores" title="Comerciales Proveedores" target="_self" >Comerciales Proveedores</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>formapagos" title="Formas de Pago" target="_self" >Formas de pago</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>maquinas" title="M&aacute;quinas" target="_self" >M&aacute;quinas</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>mecanicos" title="Mec&aacute;nicos" target="_self" >Mec&aacute;nicos</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>proveedores" title="Proveedores" target="_self" >Proveedores</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>transportistas" title="Transportistas" target="_self" >Transportistas</a></li>
            </ul>
        </li>
       
        <li><span class="divider divider-vert" ></span></li>
        <li><a class="item-primary" href="#" target="_self">Opciones</a>
            <ul>
                <li><a href="<?php echo Configure::read('proyect_url') ?>users" title="Usuarios" target="_self">Usuarios</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>roles" title="Roles" target="_self">Roles</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>restricciones" title="Restricciones" target="_self">Restricciones</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>mensajesinformativos" title="Mensajes Informativos" target="_self">Mensajes Informativos</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>centrosdecostes" title="Tipos de IVA" target="_self">Centros de Coste</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>cuentascontables" title="Cuentas Contables" target="_self">Cuentas Contables</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>tiposivas" title="Tipos de IVA" target="_self">Tipos de IVA</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>seriespresupuestosventas" title="Series" target="_self">Series de Presupuestos de Venta</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>seriespedidosventas" title="Series" target="_self">Series de Pedidos de Venta</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>series_albaranesventas" title="Series" target="_self">Series de Albaranes de Venta</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>seriesfacturasventas" title="Series" target="_self">Series de Facturas de Venta</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>seriespresupuestoscompras" title="Series" target="_self">Series de Presupuestos de Compras</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>seriespedidoscompras" title="Series" target="_self">Series de Pedidos de Compras</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>seriesalbaranescompras" title="Series" target="_self">Series de Albaranes de Compras</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>seriesfacturascompras" title="Series" target="_self">Series de Facturas de Compras</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>configs/edit/1" title="Configuración" target="_self" >Configuración</a></li>
            </ul>
        </li>
        <li><span class="divider divider-vert" ></span></li>
        <li><a class="item-primary" href="#" target="_self">Informes</a>
            <ul>
                <li><a href="<?php echo Configure::read('proyect_url') ?>informe_articuloVenta" title="Articulos venta" target="_self">Articulos venta</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>informe_articuloReparacion" title="Articulos reparación" target="_self">Articulos reparación</a></li>
                <li><a href="<?php echo Configure::read('proyect_url') ?>informe_articuloOrden" title="Articulos órdenes" target="_self">Articulos órdenes</a></li>
            </ul>
        </li>
        <li><span class="divider divider-vert" ></span></li>
        <li><a class="item-primary" href="<?php echo Configure::read('proyect_url') ?>users/logout" target="_self">Cerrar Sesión</a>
        <li><span class="divider divider-vert" ></span></li>
        <li class="clear"> </li>
    </ul>
    <div><?php echo "Versión 1.0" ?></div>
</div>
