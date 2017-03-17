<?php

class Pedidosproveedore extends AppModel {

    var $name = 'Pedidosproveedore';
    var $order = array("Pedidosproveedore.fecha DESC", "Pedidosproveedore.serie DESC", "Pedidosproveedore.numero DESC");
    var $validate = array(
        'fecha' => array(
            'date' => array(
                'rule' => array('date'),
            ),
        ),
        'proveedore_id' => array(
            'rule' => 'notEmpty',
        ),
    );
    var $belongsTo = array(
        'Presupuestosproveedore' => array(
            'className' => 'Presupuestosproveedore',
            'foreignKey' => 'presupuestosproveedore_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Proveedore' => array(
            'className' => 'Proveedore',
            'foreignKey' => 'proveedore_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Almacene' => array(
            'className' => 'Almacene',
            'foreignKey' => 'almacene_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Tiposiva' => array(
            'className' => 'Tiposiva',
            'foreignKey' => 'tiposiva_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Centrosdecoste' => array(
            'className' => 'Centrosdecoste',
            'foreignKey' => 'centrosdecoste_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Comerciale' => array(
            'className' => 'Comerciale',
            'foreignKey' => 'comerciale_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Transportista' => array(
            'className' => 'Transportista',
            'foreignKey' => 'transportista_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Estadospedidosproveedore' => array(
            'className' => 'Estadospedidosproveedore',
            'foreignKey' => 'estadospedidosproveedore_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasMany = array(
        'Albaranesproveedore' => array(
            'className' => 'Albaranesproveedore',
            'foreignKey' => 'pedidosproveedore_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'ArticulosPedidosproveedore' => array(
            'className' => 'ArticulosPedidosproveedore',
            'foreignKey' => 'pedidosproveedore_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );


    function beforeSave($options) {
        if (empty($this->data['Pedidosproveedore']['id']) && empty($this->data['Pedidosproveedore']['numero'])) {
            $config = ClassRegistry::init("Config")->findById(1);
            $query = 'SELECT MAX(a.numero) as numero  FROM pedidosproveedores a WHERE a.serie = "' . $config['Seriespedidoscompra']['serie'] . '"';
            $resultado = $this->query($query);
            if (!empty($resultado[0][0]['numero'])) {
                $this->data['Pedidosproveedore']['numero'] = $resultado[0][0]['numero'] + 1;
            } else {
                $this->data['Pedidosproveedore']['numero'] = 1;
            }
        }
        // Si hemos cambiado de serie calcular el nuevo numero de pedido
        if (!empty($this->data['Pedidosproveedore']['id']) && !empty($this->data['Pedidosproveedore']['serie'])) {
            $Pedidosproveedore = $this->find('first', array('contain' => array(), 'conditions' => array('Pedidosproveedore.id' => $this->data['Pedidosproveedore']['id'])));
            if ($Pedidosproveedore['Pedidosproveedore']['serie'] != $this->data['Pedidosproveedore']['serie']) {
                $query = 'SELECT MAX(a.numero) as numero  FROM pedidosproveedores a WHERE a.serie = "' . $this->data['Pedidosproveedore']['serie'] . '"';
                $resultado = $this->query($query);
                if (!empty($resultado[0][0]['numero'])) {
                    $this->data['Pedidosproveedore']['numero'] = $resultado[0][0]['numero'] + 1;
                } else {
                    $this->data['Pedidosproveedore']['numero'] = 1;
                }
            }
        }
        return true;
    }

    function dime_siguiente_numero() {
        $config = ClassRegistry::init("Config")->findById(1);
        $query = 'SELECT MAX(a.numero) as numero  FROM pedidosproveedores a WHERE a.serie = "' . $config['Seriespedidoscompra']['serie'] . '"';
        $resultado = $this->query($query);
        if (!empty($resultado[0][0]['numero'])) {
            $siguientenumero = $resultado[0][0]['numero'] + 1;
        } else {
            $siguientenumero = 1;
        }
        return $siguientenumero;
    }
}

?>
