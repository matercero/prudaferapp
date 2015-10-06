<?php

class Presupuestosproveedore extends AppModel {

    var $name = 'Presupuestosproveedore';
    var $order = array("Presupuestosproveedore.fecha DESC", "Presupuestosproveedore.serie DESC", "Presupuestosproveedore.numero DESC");
    var $validate = array(
        'proveedore_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'almacene_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
    );
    
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'Proveedore' => array(
            'className' => 'Proveedore',
            'foreignKey' => 'proveedore_id',
        ),
        'Almacene' => array(
            'className' => 'Almacene',
            'foreignKey' => 'almacene_id',
        ),
        'Tiposiva' => array(
            'className' => 'Tiposiva',
            'foreignKey' => 'tiposiva_id',
        ),
        'Avisosrepuesto' => array(
            'className' => 'Avisosrepuesto',
            'foreignKey' => 'avisosrepuesto_id',
        ),
        'Avisostallere' => array(
            'className' => 'Avisostallere',
            'foreignKey' => 'avisostallere_id',
        ),
        'Ordene' => array(
            'className' => 'Ordene',
            'foreignKey' => 'ordene_id',
        ),
        'Pedidoscliente' => array(
            'className' => 'Pedidoscliente',
            'foreignKey' => 'pedidoscliente_id',
        ),
        'Estadospresupuestosproveedore' => array(
            'className' => 'Estadospresupuestosproveedore',
            'foreignKey' => 'estadospresupuestosproveedore_id',
        ),
    );
    var $hasMany = array(
        'ArticulosPresupuestosproveedore' => array(
            'className' => 'ArticulosPresupuestosproveedore',
            'foreignKey' => 'presupuestosproveedore_id',
            'dependent' => true
        ),
        'Pedidosproveedore' => array(
            'className' => 'Pedidosproveedore',
            'foreignKey' => 'presupuestosproveedore_id',
            'dependent' => true
        ),
        'Presupuestoscliente' => array(
            'className' => 'Presupuestoscliente',
            'foreignKey' => 'presupuestosproveedore_id',
            'dependent' => true
        ),
    );
    
    
      function beforeSave($options) {
        if (empty($this->data['Presupuestosproveedore']['id']) && empty($this->data['Presupuestosproveedore']['numero'])) {
            $config = ClassRegistry::init("Config")->findById(1);
            $query = 'SELECT MAX(a.numero) as numero  FROM presupuestosproveedores a WHERE a.serie = "' . $config['Seriespresupuestoscompra']['serie'] . '"';
            $resultado = $this->query($query);
            if (!empty($resultado[0][0]['numero'])) {
                $this->data['Presupuestosproveedore']['numero'] = $resultado[0][0]['numero'] + 1;
            } else {
                $this->data['Presupuestosproveedore']['numero'] = 1;
            }
        }
        // Si hemos cambiado de serie calcular el nuevo numero de albaran
        if (!empty($this->data['Presupuestosproveedore']['id']) && !empty($this->data['Presupuestosproveedore']['serie'])) {
            $Presupuestosproveedore = $this->find('first', array('contain' => array(), 'conditions' => array('Presupuestosproveedore.id' => $this->data['Presupuestosproveedore']['id'])));
            if ($Presupuestosproveedore['Presupuestosproveedore']['serie'] != $this->data['Presupuestosproveedore']['serie']) {
                $query = 'SELECT MAX(a.numero) as numero  FROM presupuestosproveedores a WHERE a.serie = "' . $this->data['Presupuestosproveedore']['serie'] . '"';
                $resultado = $this->query($query);
                if (!empty($resultado[0][0]['numero'])) {
                    $this->data['Presupuestosproveedore']['numero'] = $resultado[0][0]['numero'] + 1;
                } else {
                    $this->data['Presupuestosproveedore']['numero'] = 1;
                }
            }
        }
        return true;
    }

    function dime_siguiente_numero() {
        $config = ClassRegistry::init("Config")->findById(1);
        $query = 'SELECT MAX(a.numero) as numero  FROM presupuestosproveedores a WHERE a.serie = "' . $config['Seriespresupuestoscompra']['serie'] . '"';
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