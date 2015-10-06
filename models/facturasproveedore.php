<?php

class Facturasproveedore extends AppModel {

    var $name = 'Facturasproveedore';
    var $order = "Facturasproveedore.fechafactura DESC";
    var $validate = array(
        'numero' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'fechafactura' => array(
            'date' => array(
                'rule' => array('date'),
            ),
        ),
        'tiposiva_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'Tiposiva' => array(
            'className' => 'Tiposiva',
            'foreignKey' => 'tiposiva_id',
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
        'Estadosfacturasproveedore' => array(
            'className' => 'Estadosfacturasproveedore',
            'foreignKey' => 'estadosfacturasproveedore_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
    var $hasMany = array(
        'Albaranesproveedore' => array(
            'className' => 'Albaranesproveedore',
            'foreignKey' => 'facturasproveedore_id',
            'dependent' => false
        ),
    );

    function beforeSave($options) {
        if (empty($this->data['Facturasproveedore']['id']) && empty($this->data['Facturasproveedore']['numero'])) {
            $config = ClassRegistry::init("Config")->findById(1);
            $query = 'SELECT MAX(a.numero) as numero  FROM facturasproveedores a WHERE a.serie = "' . $config['Seriesfacturascompra']['serie'] . '"';
            $resultado = $this->query($query);
            if (!empty($resultado[0][0]['numero'])) {
                $this->data['Facturasproveedore']['numero'] = $resultado[0][0]['numero'] + 1;
            } else {
                $this->data['Facturasproveedore']['numero'] = 1;
            }
        }
        // Si hemos cambiado de serie calcular el nuevo numero de albaran
        if (!empty($this->data['Facturasproveedore']['id']) && !empty($this->data['Facturasproveedore']['serie'])) {
            $Albaranesproveedore = $this->find('first', array('contain' => array(), 'conditions' => array('Facturasproveedore.id' => $this->data['Facturasproveedore']['id'])));
            if ($Albaranesproveedore['Facturasproveedore']['serie'] != $this->data['Facturasproveedore']['serie']) {
                $query = 'SELECT MAX(a.numero) as numero  FROM facturasproveedores a WHERE a.serie = "' . $this->data['Facturasproveedore']['serie'] . '"';
                $resultado = $this->query($query);
                if (!empty($resultado[0][0]['numero'])) {
                    $this->data['Facturasproveedore']['numero'] = $resultado[0][0]['numero'] + 1;
                } else {
                    $this->data['Facturasproveedore']['numero'] = 1;
                }
            }
        }
        return true;
    }

    function dime_siguiente_numero() {
        $config = ClassRegistry::init("Config")->findById(1);
        $query = 'SELECT MAX(a.numero) as numero  FROM facturasproveedores a WHERE a.serie = "' . $config['Seriesfacturascompra']['serie'] . '"';
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