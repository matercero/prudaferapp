<?php

class Albaranesproveedore extends AppModel {

    var $name = 'Albaranesproveedore';
    var $displayField = 'numero';
    var $order = array("Albaranesproveedore.fecha DESC", "Albaranesproveedore.serie DESC", "Albaranesproveedore.numero DESC");
    var $validate = array(
        'fecha' => array(
            'date' => array(
                'rule' => array('date'),
            ),
        ),
        'numero' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'serie' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'centrosdecoste_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
    );
    var $belongsTo = array(
        'Pedidosproveedore' => array(
            'className' => 'Pedidosproveedore',
            'foreignKey' => 'pedidosproveedore_id',
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
        'Tiposiva' => array(
            'className' => 'Tiposiva',
            'foreignKey' => 'tiposiva_id',
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
        'Centrosdecoste' => array(
            'className' => 'Centrosdecoste',
            'foreignKey' => 'centrosdecoste_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Estadosalbaranesproveedore' => array(
            'className' => 'Estadosalbaranesproveedore',
            'foreignKey' => 'estadosalbaranesproveedore_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
    var $hasMany = array(
        'ArticulosAlbaranesproveedore' => array(
            'className' => 'ArticulosAlbaranesproveedore',
            'foreignKey' => 'albaranesproveedore_id',
            'dependent' => true,
        ),
    );

    function beforeSave($options) {
        if (empty($this->data['Albaranesproveedore']['id']) && empty($this->data['Albaranesproveedore']['numero'])) {
            $config = ClassRegistry::init("Config")->findById(1);
            $query = 'SELECT MAX(a.numero) as numero  FROM albaranesproveedores a WHERE a.serie = "' . $config['Seriesalbaranescompra']['serie'] . '"';
            $resultado = $this->query($query);
            if (!empty($resultado[0][0]['numero'])) {
                $this->data['Albaranesproveedore']['numero'] = $resultado[0][0]['numero'] + 1;
            } else {
                $this->data['Albaranesproveedore']['numero'] = 1;
            }
        }
        // Si hemos cambiado de serie calcular el nuevo numero de albaran
        if (!empty($this->data['Albaranesproveedore']['id']) && !empty($this->data['Albaranesproveedore']['serie'])) {
            $Albaranesproveedore = $this->find('first', array('contain' => array(), 'conditions' => array('Albaranesproveedore.id' => $this->data['Albaranesproveedore']['id'])));
            if ($Albaranesproveedore['Albaranesproveedore']['serie'] != $this->data['Albaranesproveedore']['serie']) {
                $query = 'SELECT MAX(a.numero) as numero  FROM albaranesproveedores a WHERE a.serie = "' . $this->data['Albaranesproveedore']['serie'] . '"';
                $resultado = $this->query($query);
                if (!empty($resultado[0][0]['numero'])) {
                    $this->data['Albaranesproveedore']['numero'] = $resultado[0][0]['numero'] + 1;
                } else {
                    $this->data['Albaranesproveedore']['numero'] = 1;
                }
            }
        }
        return true;
    }

    function dime_siguiente_numero() {
        $config = ClassRegistry::init("Config")->findById(1);
        $query = 'SELECT MAX(a.numero) as numero  FROM albaranesproveedores a WHERE a.serie = "' . $config['Seriesalbaranescompra']['serie'] . '"';
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