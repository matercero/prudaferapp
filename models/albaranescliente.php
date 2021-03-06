<?php

class Albaranescliente extends AppModel {

    var $name = 'Albaranescliente';
    var $displayField = 'numero';
    var $order = array("Albaranescliente.fecha DESC", "Albaranescliente.serie DESC", "Albaranescliente.numero DESC");
    var $validate = array(
        'fecha' => array(
            'date' => array(
                'rule' => array('date'),
            ),
        ),
        'cliente_id' => array(
            'rule' => 'notEmpty',
            'class' => 'hola',
            'message' => 'Debes selecionar un Cliente'
        ),
        'centrostrabajo_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Debes selecionar un Centro de Trabajo'
        ),
        'maquina_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Debes selecionar una máquina'
        ),
    );
    
   
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'Avisosrepuesto' => array(
            'className' => 'Avisosrepuesto',
            'foreignKey' => 'avisosrepuesto_id',
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
        'Pedidoscliente' => array(
            'className' => 'Pedidoscliente',
            'foreignKey' => 'pedidoscliente_id',
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
        'Estadosalbaranescliente' => array(
            'className' => 'Estadosalbaranescliente',
            'foreignKey' => 'estadosalbaranescliente_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'FacturasCliente' => array(
            'className' => 'FacturasCliente',
            'foreignKey' => 'facturas_cliente_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasMany = array(
        'Tareasalbaranescliente' => array(
            'className' => 'Tareasalbaranescliente',
            'foreignKey' => 'albaranescliente_id',
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
        if (empty($this->data['Albaranescliente']['id']) && empty($this->data['Albaranescliente']['numero'])) {
            $config = ClassRegistry::init("Config")->findById(1);
            $query = 'SELECT MAX(a.numero) as numero  FROM albaranesclientesreparaciones a WHERE a.serie = "' . $config['SeriesAlbaranesventa']['serie'] . '"';
            $query2 = 'SELECT MAX(a.numero) as numero  FROM albaranesclientes a WHERE a.serie = "' . $config['SeriesAlbaranesventa']['serie'] . '"';
            $resultado = $this->query($query);
            $resultado2 = $this->query($query2);
            if (!empty($resultado[0][0]['numero']) && !empty($resultado2[0][0]['numero'])) {
                if ($resultado[0][0]['numero'] > $resultado2[0][0]['numero']) {
                    $this->data['Albaranescliente']['numero'] = $resultado[0][0]['numero'] + 1;
                } else {
                    $this->data['Albaranescliente']['numero'] = $resultado2[0][0]['numero'] + 1;
                }
            } else {
                $this->data['Albaranescliente']['numero'] = 1;
            }
        }
        // Si hemos cambiado de serie calcular el nuevo numero de albaran
        if (!empty($this->data['Albaranescliente']['id']) && !empty($this->data['Albaranescliente']['serie'])) {
            $albaranescliente = $this->find('first', array('contain' => array(), 'conditions' => array('Albaranescliente.id' => $this->data['Albaranescliente']['id'])));
            if ($albaranescliente['Albaranescliente']['serie'] != $this->data['Albaranescliente']['serie']) {
                $query = 'SELECT MAX(a.numero) as numero  FROM albaranesclientesreparaciones a WHERE a.serie = "' . $this->data['Albaranescliente']['serie'] . '"';
                $query2 = 'SELECT MAX(a.numero) as numero  FROM albaranesclientes a WHERE a.serie = "' . $this->data['Albaranescliente']['serie'] . '"';
                $resultado = $this->query($query);
                $resultado2 = $this->query($query2);
                if (!empty($resultado[0][0]['numero']) && !empty($resultado2[0][0]['numero'])) {
                    if ($resultado[0][0]['numero'] > $resultado2[0][0]['numero'])
                        $this->data['Albaranescliente']['numero'] = $resultado[0][0]['numero'] + 1;
                    else
                        $this->data['Albaranescliente']['numero'] = $resultado2[0][0]['numero'] + 1;
                }else {
                    $this->data['Albaranescliente']['numero'] = 1;
                }
            }
        }
        return true;
    }

    function dime_siguiente_numero() {
        $config = ClassRegistry::init("Config")->findById(1);
        $query = 'SELECT MAX(a.numero) as numero  FROM albaranesclientesreparaciones a WHERE a.serie = "' . $config['SeriesAlbaranesventa']['serie'] . '"';
        $query2 = 'SELECT MAX(a.numero) as numero  FROM albaranesclientes a WHERE a.serie = "' . $config['SeriesAlbaranesventa']['serie'] . '"';
        $resultado = $this->query($query);
        $resultado2 = $this->query($query2);
        $siguientenumero = 1;
        if (!empty($resultado[0][0]['numero']) && !empty($resultado2[0][0]['numero'])) {
            if ($resultado[0][0]['numero'] > $resultado2[0][0]['numero'])
                $siguientenumero = $resultado[0][0]['numero'] + 1;
            else
                $siguientenumero = $resultado2[0][0]['numero'] + 1;
        }
        if (!empty($resultado[0][0]['numero']) && empty($resultado2[0][0]['numero']))
            $siguientenumero = $resultado[0][0]['numero'] + 1;
        if (!empty($resultado2[0][0]['numero']) && empty($resultado[0][0]['numero']))
            $siguientenumero = $resultado2[0][0]['numero'] + 1;
        return $siguientenumero;
    }

    function dime_siguiente_numero_ajax($serie) {
        $config = ClassRegistry::init("Config")->findById(1);
        $query = 'SELECT MAX(a.numero) as numero  FROM albaranesclientesreparaciones a WHERE a.serie = "' . $serie . '"';
        $query2 = 'SELECT MAX(a.numero) as numero  FROM albaranesclientes a WHERE a.serie = "' . $serie . '"';
        $resultado = $this->query($query);
        $resultado2 = $this->query($query2);
        $siguientenumero = 1;
        if (!empty($resultado[0][0]['numero']) && !empty($resultado2[0][0]['numero'])) {
            if ($resultado[0][0]['numero'] > $resultado2[0][0]['numero'])
                $siguientenumero = $resultado[0][0]['numero'] + 1;
            else
                $siguientenumero = $resultado2[0][0]['numero'] + 1;
        }
        if (!empty($resultado[0][0]['numero']) && empty($resultado2[0][0]['numero']))
            $siguientenumero = $resultado[0][0]['numero'] + 1;
        if (!empty($resultado2[0][0]['numero']) && empty($resultado[0][0]['numero']))
            $siguientenumero = $resultado2[0][0]['numero'] + 1;
        return $siguientenumero;
    }

    function afterSave($created) {
        $albaranescliente = $this->find('first', array(
            'contain' => 'Comerciale',
            'conditions' => array('Albaranescliente.id' => $this->id)));
        $comision = redondear_dos_decimal($albaranescliente['Albaranescliente']['precio'] * ($albaranescliente['Comerciale']['porcentaje_comision'] / 100 ));
        $query = 'UPDATE albaranesclientes a SET a.comision = ' . $comision . ' WHERE a.id = ' . $this->id;
        $resultado = $this->query($query);
    }

}

?>