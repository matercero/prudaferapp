<?php

class Pedidoscliente extends AppModel {

    var $name = 'Pedidoscliente';
    var $displayField = 'serie_numero';
    var $validate = array(
        'Pedidoscliente_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );
    var $virtualFields = array('serie_numero' => 'CONCAT(Pedidoscliente.serie, "-", LPAD(Pedidoscliente.numero, 6 ,"0"))');
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    var $order = array("Pedidoscliente.fecha DESC", "Pedidoscliente.serie DESC", "Pedidoscliente.numero DESC");
    var $belongsTo = array(
        'Presupuestoscliente' => array(
            'className' => 'Presupuestoscliente',
            'foreignKey' => 'presupuestoscliente_id',
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
        'Estadospedidoscliente' => array(
            'className' => 'Estadospedidoscliente',
            'foreignKey' => 'estadospedidoscliente_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
    var $hasMany = array(
        'Presupuestosproveedore' => array(
            'className' => 'Presupuestosproveedore',
            'foreignKey' => 'pedidoscliente_id',
            'dependent' => false,
        ),
        'Albaranescliente' => array(
            'className' => 'Albaranescliente',
            'foreignKey' => 'pedidoscliente_id',
            'dependent' => false,
        ),
        'Tareaspedidoscliente' => array(
            'className' => 'Tareaspedidoscliente',
            'foreignKey' => 'pedidoscliente_id',
            'dependent' => true,
        ),
    );

    function beforeSave($options) {
        if (empty($this->data['Pedidoscliente']['id']) && empty($this->data['Pedidoscliente']['numero'])) {
            $config = ClassRegistry::init("Config")->findById(1);
            $query = 'SELECT MAX(a.numero) as numero  FROM pedidosclientes a WHERE a.serie = "' . $config['Seriespedidosventa']['serie'] . '"';
            $resultado = $this->query($query);
            if (!empty($resultado[0][0]['numero'])) {
                $this->data['Pedidoscliente']['numero'] = $resultado[0][0]['numero'] + 1;
            } else {
                $this->data['Pedidoscliente']['numero'] = 1;
            }
        }
        // Si hemos cambiado de serie calcular el nuevo numero de pedido
        if (!empty($this->data['Pedidoscliente']['id']) && !empty($this->data['Pedidoscliente']['serie'])) {
            $Pedidoscliente = $this->find('first', array('contain' => array(), 'conditions' => array('Pedidoscliente.id' => $this->data['Pedidoscliente']['id'])));
            if ($Pedidoscliente['Pedidoscliente']['serie'] != $this->data['Pedidoscliente']['serie']) {
                $query = 'SELECT MAX(a.numero) as numero  FROM pedidosclientes a WHERE a.serie = "' . $this->data['Pedidoscliente']['serie'] . '"';
                $resultado = $this->query($query);
                if (!empty($resultado[0][0]['numero'])) {
                    $this->data['Pedidoscliente']['numero'] = $resultado[0][0]['numero'] + 1;
                } else {
                    $this->data['Pedidoscliente']['numero'] = 1;
                }
            }
        }
        return true;
    }

    function dime_siguiente_numero() {
        $config = ClassRegistry::init("Config")->findById(1);
        $query = 'SELECT MAX(a.numero) as numero  FROM pedidosclientes a WHERE a.serie = "' . $config['Seriespedidosventa']['serie'] . '"';
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