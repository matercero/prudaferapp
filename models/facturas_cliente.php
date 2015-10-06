<?php

class FacturasCliente extends AppModel {

    var $name = 'FacturasCliente';
    var $order = array("FacturasCliente.fecha DESC", "FacturasCliente.serie DESC", "FacturasCliente.numero DESC");
    var $belongsTo = array(
        'Cliente' => array(
            'className' => 'Cliente',
            'foreignKey' => 'cliente_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Estadosfacturascliente' => array(
            'className' => 'Estadosfacturascliente',
            'foreignKey' => 'estadosfacturascliente_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
    var $hasMany = array(
        'Albaranescliente' => array(
            'className' => 'Albaranescliente',
            'foreignKey' => 'facturas_cliente_id',
            'dependent' => false
        ),
        'Albaranesclientesreparacione' => array(
            'className' => 'Albaranesclientesreparacione',
            'foreignKey' => 'facturas_cliente_id',
            'dependent' => false
        ),
    );

    function beforeSave($options) {
        if (empty($this->data['FacturasCliente']['id']) && empty($this->data['FacturasCliente']['numero'])) {
            $config = ClassRegistry::init("Config")->findById(1);
            if (empty($this->data['FacturasCliente']['serie'])) {
                $query = 'SELECT MAX(f.numero) as numero  FROM facturas_clientes f WHERE f.serie = "' . $config['Seriesfacturasventa']['serie'] . '"';
            } else {
                $query = 'SELECT MAX(f.numero) as numero  FROM facturas_clientes f WHERE f.serie = "' . $this->data['FacturasCliente']['serie'] . '"';
                echo $query;
            }
            $resultado = $this->query($query);
            pr($resultado);
            if (!empty($resultado[0][0]['numero'])) {
                $this->data['FacturasCliente']['numero'] = $resultado[0][0]['numero'] + 1;
            } else {
                $this->data['FacturasCliente']['numero'] = 1;
            }
        }
        // Si hemos cambiado de serie calcular el nuevo numero de albaran
        if (!empty($this->data['FacturasCliente']['id']) && !empty($this->data['FacturasCliente']['serie'])) {
            $FacturasCliente = $this->find('first', array('contain' => array(), 'conditions' => array('FacturasCliente.id' => $this->data['FacturasCliente']['id'])));
            if ($FacturasCliente['FacturasCliente']['serie'] != $this->data['FacturasCliente']['serie']) {
                $query = 'SELECT MAX(f.numero) as numero  FROM facturas_clientes f WHERE f.serie = "' . $this->data['FacturasCliente']['serie'] . '"';
                $resultado = $this->query($query);
                if (!empty($resultado[0][0]['numero'])) {
                    $this->data['FacturasCliente']['numero'] = $resultado[0][0]['numero'] + 1;
                } else {
                    $this->data['FacturasCliente']['numero'] = 1;
                }
            }
        }
        return true;
    }

    function dime_siguiente_numero($serie = null) {
        if (empty($serie)) {
            $config = ClassRegistry::init("Config")->findById(1);
            $query = 'SELECT MAX(f.numero) as numero  FROM facturas_clientes f WHERE f.serie = "' . $config['Seriesfacturasventa']['serie'] . '"';
        } else {
            $query = 'SELECT MAX(f.numero) as numero  FROM facturas_clientes f WHERE f.serie = "' . $serie . '"';
        }
        $resultado = $this->query($query);

        if (!empty($resultado[0][0]['numero'])) {
            $siguientenumero = $resultado[0][0]['numero'] + 1;
        } else {
            $siguientenumero = 1;
        }
        return $siguientenumero;
    }

    /*
     * Antes de borrar los albaranes debemos poner facturables a True
     */

    function beforeDelete() {
        $albaranescliente_list = $this->Albaranescliente->find('list', array('conditions' => array('Albaranescliente.facturas_cliente_id' => $this->id)));
        foreach ($albaranescliente_list as $albaranescliente_id => $value) {
            $this->Albaranescliente->id = $albaranescliente_id;
            $this->Albaranescliente->saveField('facturable', 1);
            $this->Albaranescliente->saveField('facturas_cliente_id', null);
        }
        $albaranesclientesreparacione_list = $this->Albaranesclientesreparacione->find('list', array('conditions' => array('Albaranesclientesreparacione.facturas_cliente_id' => $this->id)));
        foreach ($albaranesclientesreparacione_list as $albaranescliente_id => $value) {
            $this->Albaranesclientesreparacione->id = $albaranescliente_id;
            $this->Albaranesclientesreparacione->saveField('facturable', 1);
            $this->Albaranesclientesreparacione->saveField('facturas_cliente_id', null);
        }
        return true;
    }

    /* Recalcular los totales */

    function recalcular_totales($facturas_cliente_id = null) {
        $id = null;
        if (!empty($facturas_cliente_id))
            $id = $facturas_cliente_id;
        if (!empty($this->id))
            $id = $this->id;
        if (!empty($id)) {
            $baseimponible = 0;
            $impuestos = 0;
            $facturas_cliente = $this->find(
                    'first', array(
                'contain' => array(
                    'Estadosfacturascliente',
                    'Cliente' => array('Formapago', 'Cuentasbancaria'),
                    'Albaranescliente' => array('Tiposiva', 'Cliente'),
                    'Albaranesclientesreparacione' => array('Tiposiva', 'Cliente')
                ),
                'conditions' => array('FacturasCliente.id' => $id),
                    )
            );
            foreach ($facturas_cliente['Albaranescliente'] as $albaranescliente) {
                $baseimponible += $albaranescliente['precio'];
                $impuestos += $albaranescliente['impuestos'];
            }
            foreach ($facturas_cliente['Albaranesclientesreparacione'] as $albaranescliente) {
                $baseimponible += $albaranescliente['baseimponible'];
                $impuestos += $albaranescliente['baseimponible'] * $albaranescliente['Tiposiva']['porcentaje_aplicable'] / 100;
            }
            $this->saveField('baseimponible', redondear_dos_decimal($baseimponible));
            $this->saveField('impuestos', redondear_dos_decimal($impuestos));
            $this->saveField('total', redondear_dos_decimal($baseimponible + $impuestos));
        }
        return true;
    }

}

?>