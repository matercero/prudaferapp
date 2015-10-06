<?php

class Presupuestoscliente extends AppModel {

    var $name = 'Presupuestoscliente';
    var $displayField = 'fecha';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $validate = array(
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
    );
    var $order = array("Presupuestoscliente.fecha DESC", "Presupuestoscliente.serie DESC", "Presupuestoscliente.numero DESC");
    var $belongsTo = array(
        'Comerciale' => array(
            'className' => 'Comerciale',
            'foreignKey' => 'comerciale_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Centrostrabajo' => array(
            'className' => 'Centrostrabajo',
            'foreignKey' => 'centrostrabajo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Maquina' => array(
            'className' => 'Maquina',
            'foreignKey' => 'maquina_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Avisosrepuesto' => array(
            'className' => 'Avisosrepuesto',
            'foreignKey' => 'avisosrepuesto_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Mensajesinformativo' => array(
            'className' => 'Mensajesinformativo',
            'foreignKey' => 'mensajesinformativo_id',
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
        'Cliente' => array(
            'className' => 'Cliente',
            'foreignKey' => 'cliente_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Ordene' => array(
            'className' => 'Ordene',
            'foreignKey' => 'ordene_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Presupuestosproveedore' => array(
            'className' => 'Presupuestosproveedore',
            'foreignKey' => 'presupuestosproveedore_id',
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
        'Estadospresupuestoscliente' => array(
            'className' => 'Estadospresupuestoscliente',
            'foreignKey' => 'estadospresupuestoscliente_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Avisostallere' => array(
            'className' => 'Avisostallere',
            'foreignKey' => 'avisostallere_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasMany = array(
        'Tareaspresupuestocliente' => array(
            'className' => 'Tareaspresupuestocliente',
            'foreignKey' => 'presupuestoscliente_id',
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
        'Pedidoscliente' => array(
            'className' => 'Pedidoscliente',
            'foreignKey' => 'presupuestoscliente_id',
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
    );

    function beforeSave($options) {
        if (empty($this->data['Presupuestoscliente']['id']) && empty($this->data['Presupuestoscliente']['numero'])) {
            $config = ClassRegistry::init("Config")->findById(1);
            $query = 'SELECT MAX(a.numero) as numero  FROM presupuestosclientes a WHERE a.serie = "' . $config['Seriespresupuestosventa']['serie'] . '"';
            $resultado = $this->query($query);
            if (!empty($resultado[0][0]['numero'])) {
                $this->data['Presupuestoscliente']['numero'] = $resultado[0][0]['numero'] + 1;
            } else {
                $this->data['Presupuestoscliente']['numero'] = 1;
            }
        }
        // Si hemos cambiado de serie calcular el nuevo numero de presupuesto
        if (!empty($this->data['Presupuestoscliente']['id']) && !empty($this->data['Presupuestoscliente']['serie'])) {
            $Presupuestoscliente = $this->find('first', array('contain' => array(), 'conditions' => array('Presupuestoscliente.id' => $this->data['Presupuestoscliente']['id'])));
            if ($Presupuestoscliente['Presupuestoscliente']['serie'] != $this->data['Presupuestoscliente']['serie']) {
                $query = 'SELECT MAX(a.numero) as numero  FROM presupuestosclientes a WHERE a.serie = "' . $this->data['Presupuestoscliente']['serie'] . '"';
                $resultado = $this->query($query);
                if (!empty($resultado[0][0]['numero'])) {
                    $this->data['Presupuestoscliente']['numero'] = $resultado[0][0]['numero'] + 1;
                } else {
                    $this->data['Presupuestoscliente']['numero'] = 1;
                }
            }
        }
        return true;
    }

    function dime_siguiente_numero() {
        $config = ClassRegistry::init("Config")->findById(1);
        $query = 'SELECT MAX(a.numero) as numero  FROM presupuestosclientes a WHERE a.serie = "' . $config['Seriespresupuestosventa']['serie'] . '"';
        $resultado = $this->query($query);
        if (!empty($resultado[0][0]['numero'])) {
            $siguientenumero = $resultado[0][0]['numero'] + 1;
        } else {
            $siguientenumero = 1;
        }
        return $siguientenumero;
    }
    
    function dime_siguiente_numero_ajax($serie) {
        $config = ClassRegistry::init("Config")->findById(1);
        $query = 'SELECT MAX(a.numero) as numero  FROM presupuestosclientes a WHERE a.serie = "' . $serie . '"';
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