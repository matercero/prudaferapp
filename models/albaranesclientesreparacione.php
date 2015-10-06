<?php

class Albaranesclientesreparacione extends AppModel {

    var $name = 'Albaranesclientesreparacione';
    var $displayField = 'numero';
    var $order = array("Albaranesclientesreparacione.fecha DESC", "Albaranesclientesreparacione.serie DESC", "Albaranesclientesreparacione.numero DESC");
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
        'tiposiva_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
    );
    var $belongsTo = array(
        'Tiposiva' => array(
            'className' => 'Tiposiva',
            'foreignKey' => 'tiposiva_id',
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
        'Estadosalbaranesclientesreparacione' => array(
            'className' => 'Estadosalbaranesclientesreparacione',
            'foreignKey' => 'estadosalbaranesclientesreparacione_id',
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
        'Almacene' => array(
            'className' => 'Almacene',
            'foreignKey' => 'almacene_id',
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
        ),
        'Comerciale' => array(
            'className' => 'Comerciale',
            'foreignKey' => 'comerciale_id',
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
        )
    );
    var $hasMany = array(
        'TareasAlbaranesclientesreparacione' => array(
            'className' => 'TareasAlbaranesclientesreparacione',
            'foreignKey' => 'albaranesclientesreparacione_id',
            'dependent' => true,
        ),
    );

    function beforeSave($options) {
        if (empty($this->data['Albaranesclientesreparacione']['id']) && empty($this->data['Albaranesclientesreparacione']['numero'])) {
            $config = ClassRegistry::init("Config")->findById(1);
            $query = 'SELECT MAX(a.numero) as numero  FROM albaranesclientesreparaciones a WHERE a.serie = "' . $config['SeriesAlbaranesventa']['serie'] . '"';
            $query2 = 'SELECT MAX(a.numero) as numero  FROM albaranesclientes a WHERE a.serie = "' . $config['SeriesAlbaranesventa']['serie'] . '"';
            $resultado = $this->query($query);
            $resultado2 = $this->query($query2);
            if (!empty($resultado[0][0]['numero']) && !empty($resultado2[0][0]['numero'])) {
                if ($resultado[0][0]['numero'] > $resultado2[0][0]['numero'])
                    $this->data['Albaranesclientesreparacione']['numero'] = $resultado[0][0]['numero'] + 1;
                else
                    $this->data['Albaranesclientesreparacione']['numero'] = $resultado2[0][0]['numero'] + 1;
            }else {
                $this->data['Albaranesclientesreparacione']['numero'] = 1;
            }
        }
        // Si hemos cambiado de serie calcular el nuevo numero de albaran
        if (!empty($this->data['Albaranesclientesreparacione']['id']) && !empty($this->data['Albaranesclientesreparacione']['serie'])) {
            $albaranesclientesreparacione = $this->find('first', array('contain' => array(), 'conditions' => array('Albaranesclientesreparacione.id' => $this->data['Albaranesclientesreparacione']['id'])));
            if ($albaranesclientesreparacione['Albaranesclientesreparacione']['serie'] != $this->data['Albaranesclientesreparacione']['serie']) {
                $query = 'SELECT MAX(a.numero) as numero  FROM albaranesclientesreparaciones a WHERE a.serie = "' . $this->data['Albaranesclientesreparacione']['serie'] . '"';
                $query2 = 'SELECT MAX(a.numero) as numero  FROM albaranesclientes a WHERE a.serie = "' . $this->data['Albaranesclientesreparacione']['serie'] . '"';
                $resultado = $this->query($query);
                $resultado2 = $this->query($query2);
                if (!empty($resultado[0][0]['numero']) && !empty($resultado2[0][0]['numero'])) {
                    if ($resultado[0][0]['numero'] > $resultado2[0][0]['numero'])
                        $this->data['Albaranesclientesreparacione']['numero'] = $resultado[0][0]['numero'] + 1;
                    else
                        $this->data['Albaranesclientesreparacione']['numero'] = $resultado2[0][0]['numero'] + 1;
                }else {
                    $this->data['Albaranesclientesreparacione']['numero'] = 1;
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
        if (!empty($resultado[0][0]['numero']) && !empty($resultado2[0][0]['numero'])) {
            if ($resultado[0][0]['numero'] > $resultado2[0][0]['numero'])
                $siguientenumero = $resultado[0][0]['numero'] + 1;
            else
                $siguientenumero = $resultado2[0][0]['numero'] + 1;
        }elseif (empty($resultado[0][0]['numero']) && !empty($resultado2[0][0]['numero'])) {
            $siguientenumero = $resultado2[0][0]['numero'] + 1;
        } elseif (empty($resultado2[0][0]['numero']) && !empty($resultado[0][0]['numero'])) {
            $siguientenumero = $resultado[0][0]['numero'] + 1;
        } else {
            $siguientenumero = 1;
        }
        return $siguientenumero;
    }

    public function get_baseimponible($albaranesclientesreparacione_id, $deleted_id = null) {
        $baseimponible = 0;
        $tareas = $this->TareasAlbaranesclientesreparacione->find('all', array(
            'fields' => array('id', 'total_partes_imputable', 'total_materiales_imputables'),
            'contain' => '',
            'conditions' => array('TareasAlbaranesclientesreparacione.albaranesclientesreparacione_id' => $albaranesclientesreparacione_id),
                ));
        foreach ($tareas as $tarea) {
            if ($tarea['TareasAlbaranesclientesreparacione']['id'] != $deleted_id)
                $baseimponible += $tarea['TareasAlbaranesclientesreparacione']['total_partes_imputable'] + $tarea['TareasAlbaranesclientesreparacione']['total_materiales_imputables'];
        }
        return redondear_dos_decimal($baseimponible);
    }

    public function get_totalmanoobra_servicios($albaranesclientesreparacione_id, $deleted_id = null) {
        $manoobraotroservicios = 0;
        $tareas = $this->TareasAlbaranesclientesreparacione->find('all', array(
            'fields' => array('id', 'total_partes_imputable'),
            'contain' => '',
            'conditions' => array('TareasAlbaranesclientesreparacione.albaranesclientesreparacione_id' => $albaranesclientesreparacione_id),
                ));
        foreach ($tareas as $tarea) {
            if ($tarea['TareasAlbaranesclientesreparacione']['id'] != $deleted_id)
                $manoobraotroservicios += $tarea['TareasAlbaranesclientesreparacione']['total_partes_imputable'];
        }
        return redondear_dos_decimal($manoobraotroservicios);
    }

    public function get_totalrepuestos($albaranesclientesreparacione_id, $deleted_id = null) {
        $total_repuestos = 0;
        $tareas = $this->TareasAlbaranesclientesreparacione->find('all', array(
            'fields' => array('id', 'total_materiales_imputables'),
            'contain' => '',
            'conditions' => array('TareasAlbaranesclientesreparacione.albaranesclientesreparacione_id' => $albaranesclientesreparacione_id),
                ));
        foreach ($tareas as $tarea) {
            if ($tarea['TareasAlbaranesclientesreparacione']['id'] != $deleted_id)
                $total_repuestos += $tarea['TareasAlbaranesclientesreparacione']['total_materiales_imputables'];
        }
        return redondear_dos_decimal($total_repuestos);
    }

    function recalcularTotales($deleted_id = null) {
        if (!empty($this->id)) {
            $this->saveField('total_materiales', redondear_dos_decimal($this->get_totalrepuestos($this->id, $deleted_id)));
            $this->saveField('total_manoobra', redondear_dos_decimal($this->get_totalmanoobra_servicios($this->id, $deleted_id)));
            $this->saveField('baseimponible', redondear_dos_decimal($this->get_baseimponible($this->id, $deleted_id)));
        }
    }

    function dime_siguiente_numero_ajax($serie) {
        $config = ClassRegistry::init("Config")->findById(1);
        $query = 'SELECT MAX(a.numero) as numero  FROM albaranesclientesreparaciones a WHERE a.serie = "' . $serie . '"';
        $query2 = 'SELECT MAX(a.numero) as numero  FROM albaranesclientes a WHERE a.serie = "' . $serie . '"';
        $resultado = $this->query($query);
        $resultado2 = $this->query($query2);
        if (!empty($resultado[0][0]['numero']) && !empty($resultado2[0][0]['numero'])) {
            if ($resultado[0][0]['numero'] > $resultado2[0][0]['numero'])
                $siguientenumero = $resultado[0][0]['numero'] + 1;
            else
                $siguientenumero = $resultado2[0][0]['numero'] + 1;
        }elseif (empty($resultado[0][0]['numero']) && !empty($resultado2[0][0]['numero'])) {
            $siguientenumero = $resultado2[0][0]['numero'] + 1;
        } elseif (empty($resultado2[0][0]['numero']) && !empty($resultado[0][0]['numero'])) {
            $siguientenumero = $resultado[0][0]['numero'] + 1;
        } else {
            $siguientenumero = 1;
        }
        return $siguientenumero;
    }

}

?>