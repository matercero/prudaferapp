<?php

class Partestallere extends AppModel {

    var $name = 'Partestallere';
    var $validate = array(
        'fecha' => array(
            'date' => array(
                'rule' => array('notempty'),
            ),
        ),
        'operacion' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
    );

    var $belongsTo = array(
        'Tarea' => array(
            'className' => 'Tarea',
            'foreignKey' => 'tarea_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Mecanico' => array(
            'className' => 'Mecanico',
            'foreignKey' => 'mecanico_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    function afterSave($created) {
        $partestallere = $this->find('first', array('contain' => array('Tarea'), 'conditions' => array('Partestallere.id' => $this->id)));
        $this->Tarea->id = $partestallere['Partestallere']['tarea_id'];
        $this->Tarea->recalcularTotales();
    }

    function beforeDelete() {
        $partestallere = $this->find('first', array('contain' => array('Tarea'), 'conditions' => array('Partestallere.id' => $this->id)));
        $this->Tarea->id = $partestallere['Partestallere']['tarea_id'];
        $this->Tarea->recalcularTotales($this->id);
        return true;
    }

}

?>